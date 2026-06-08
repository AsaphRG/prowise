<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class VertexAIService
{
    protected $projectId;
    protected $location;
    protected $resourceId;
    protected $credentialsPath;

    public function __construct()
    {
        $this->projectId = Config::get('services.vertex_ai.project_id');
        $this->location = Config::get('services.vertex_ai.location', 'us-central1');
        $this->resourceId = Config::get('services.vertex_ai.resource_id');

        Log::debug('VertexAIService Initialized', [
            'project' => $this->projectId,
            'location' => $this->location,
            'resource' => $this->resourceId
        ]);
        $creds = Config::get('services.vertex_ai.credentials');
        if ($creds) {
            // Check if it's already an absolute path (Linux '/' or Windows 'C:\')
            if (str_starts_with($creds, '/') || preg_match('/^[A-Za-z]:\\\\/', $creds)) {
                $this->credentialsPath = $creds;
            } else {
                // Clean up any leading './' or '.\' before using base_path
                $cleanCreds = preg_replace('/^\\.\\/|^\\.\\\\/', '', $creds);
                $this->credentialsPath = base_path($cleanCreds);
            }
        } else {
            $this->credentialsPath = '';
        }
    }

    /**
     * Get OAuth 2.0 Access Token from Google Service Account
     */
    protected function getAccessToken(): string
    {
        $scopes = ['https://www.googleapis.com/auth/cloud-platform'];

        $credentials = new ServiceAccountCredentials($scopes, $this->credentialsPath);
        $token = $credentials->fetchAuthToken();

        return $token['access_token'];
    }

    protected function baseEndpoint(): string
    {
        return "https://{$this->location}-aiplatform.googleapis.com/v1/projects/{$this->projectId}/locations/{$this->location}/reasoningEngines/{$this->resourceId}";
    }

    /**
     * Create a new ADK session in the Reasoning Engine.
     * AdkApp exposes :create_session which expects {class_method, input: {user_id}}.
     */
    public function createSession(string $userId): ?string
    {
        try {
            $token = $this->getAccessToken();
            $endpoint = $this->baseEndpoint() . ':query';

            $payload = [
                'class_method' => 'create_session',
                'input' => [
                    'user_id' => (string) $userId,
                ],
            ];

            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($endpoint, $payload);

            if ($response->failed()) {
                Log::error('Vertex AI Create Session Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return null;
            }

            $result = $response->json();

            // AdkApp returns the session dict under `output`
            // Shape: { id, user_id, app_name, last_update_time, events, state }
            return $result['output']['id'] ?? null;

        } catch (\Exception $e) {
            Log::error('Vertex AIService CreateSession Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Query the Reasoning Engine (RAG Agent) via AdkApp stream_query.
     */
    public function query(string $query, ?string $sessionId = null, array $history = [])
    {
        try {
            $token = $this->getAccessToken();
            $endpoint = $this->baseEndpoint() . ':streamQuery?alt=sse';

            // Use consistent user ID for session tracking
            $userId = \Illuminate\Support\Facades\Auth::check() ? (string) \Illuminate\Support\Facades\Auth::id() : 'guest_user';

            $payload = [
                'class_method' => 'stream_query',
                'input' => [
                    'message' => $query,
                    'user_id' => $userId,
                    'session_id' => $sessionId ?? 'laravel_default_session',
                ],
            ];

            Log::debug('Vertex AI Stream Query Start', [
                'session_id' => $sessionId,
                'user_id' => $userId
            ]);

            // Use stream => true to handle SSE properly
            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Accept' => 'text/event-stream',
                ])
                ->timeout(120)
                ->withOptions(['stream' => true])
                ->post($endpoint, $payload);

            if ($response->failed()) {
                Log::error('Vertex AI Stream Query Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return [
                    'content' => 'Desculpe, tive um problema ao processar sua solicitação.',
                    'citations' => [],
                ];
            }

            $content = '';
            $citations = [];
            $stream = $response->toPsrResponse()->getBody();

            // Read the stream line by line
            while (!$stream->eof()) {
                $line = $this->readLine($stream);
                if (empty($line)) continue;

                $jsonData = $line;
                // Remove SSE prefix if present
                if (str_starts_with($line, 'data:')) {
                    $jsonData = trim(substr($line, 5));
                }

                if ($jsonData === '[DONE]') break;

                $event = json_decode($jsonData, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::warning('Vertex AI Stream JSON Decode Error', [
                        'error' => json_last_error_msg(),
                        'line' => substr($jsonData, 0, 100)
                    ]);
                    continue;
                }

                if (isset($event['content']['parts'])) {
                    foreach ($event['content']['parts'] as $part) {
                        if (!empty($part['text'])) {
                            $content .= $part['text'];
                        }
                        
                        // Capture citations from rag_query function_response
                        $funcResp = $part['function_response'] ?? null;
                        if ($funcResp && ($funcResp['name'] ?? null) === 'rag_query') {
                            $data = $funcResp['response'] ?? [];
                            if (($data['status'] ?? null) === 'success') {
                                foreach ($data['results'] ?? [] as $res) {
                                    $source = $res['source_name'] ?? $res['source_uri'] ?? null;
                                    if ($source) {
                                        $citation = [
                                            'source' => $source,
                                            'url' => $res['source_uri'] ?? '#',
                                            'title' => $res['source_name'] ?? 'Referência'
                                        ];

                                        // Deduplicate
                                        $exists = false;
                                        foreach ($citations as $c) {
                                            if ($c['source'] === $source) {
                                                $exists = true;
                                                break;
                                            }
                                        }
                                        if (!$exists) {
                                            $citations[] = $citation;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            if (trim($content) === '') {
                Log::warning('Vertex AI: Stream ended with no content', [
                    'status' => $response->status()
                ]);
                return [
                    'content' => 'O assistente não retornou uma resposta textual. Verifique se o seu projeto Google Cloud tem as permissões necessárias.',
                    'citations' => $citations,
                ];
            }

            return [
                'content' => $content,
                'citations' => $citations,
            ];

        } catch (\Exception $e) {
            Log::error('Vertex AIService Error: ' . $e->getMessage(), [
                'trace' => substr($e->getTraceAsString(), 0, 500)
            ]);
            return [
                'content' => 'Erro interno ao processar a resposta do assistente.',
                'citations' => [],
            ];
        }
    }

    /**
     * Helper to read a line from a PSR-7 stream.
     * Handles SSE lines which might end with \r\n or just \n.
     */
    protected function readLine($stream): string
    {
        $buffer = '';
        while (!$stream->eof()) {
            $char = $stream->read(1);
            if ($char === '') break;
            if ($char === "\n") break;
            $buffer .= $char;
        }
        return trim($buffer, "\r\n ");
    }
}
