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
        $this->location = Config::get('services.vertex_ai.location', 'us-west1');
        $this->resourceId = Config::get('services.vertex_ai.resource_id');

        // Ensure credentials path is absolute
        $creds = Config::get('services.vertex_ai.credentials');
        if (str_starts_with($creds, '.\\') || str_starts_with($creds, './')) {
            $this->credentialsPath = base_path(str_replace(['.\\', './'], '', $creds));
        } else {
            $this->credentialsPath = $creds;
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
     *
     * AdkApp :stream_query returns a stream of ADK events (JSON lines). Each
     * event has shape: { content: { parts: [...] }, author, ... }. We
     * accumulate text parts and citations from rag_query function_response
     * events into a single response for the UI.
     */
    public function query(string $query, ?string $sessionId = null, array $history = [])
    {
        try {
            $token = $this->getAccessToken();
            $endpoint = $this->baseEndpoint() . ':streamQuery?alt=sse';

            $payload = [
                'class_method' => 'stream_query',
                'input' => [
                    'message' => $query,
                    'user_id' => 'laravel_user',
                    'session_id' => $sessionId ?? 'laravel_session',
                ],
            ];

            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->timeout(120)
                ->post($endpoint, $payload);

            if ($response->failed()) {
                Log::error('Vertex AI Stream Query Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'payload' => $payload,
                    'endpoint' => $endpoint,
                ]);
                return [
                    'content' => 'Desculpe, tive um problema ao processar sua solicitação. Por favor, tente novamente.',
                    'citations' => [],
                ];
            }

            $body = $response->body();
            Log::info('Vertex AI Stream Query Success', [
                'status' => $response->status(),
                'length' => strlen($body),
            ]);

            return $this->parseStreamEvents($body);

        } catch (\Exception $e) {
            Log::error('Vertex AIService Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return [
                'content' => 'Ocorreu um erro interno ao tentar falar com o assistente.',
                'citations' => [],
            ];
        }
    }

    /**
     * Parse a stream_query response (either SSE or newline-delimited JSON)
     * into a single {content, citations} payload for the UI.
     */
    protected function parseStreamEvents(string $body): array
    {
        $content = '';
        $citations = [];

        foreach (preg_split('/\r?\n/', $body) as $line) {
            $line = trim($line);
            if ($line === '' || $line === 'data:') {
                continue;
            }

            // Handle SSE `data: {...}` prefix
            if (str_starts_with($line, 'data:')) {
                $line = trim(substr($line, 5));
            }

            $event = json_decode($line, true);
            if (!is_array($event)) {
                continue;
            }

            $parts = $event['content']['parts'] ?? [];
            foreach ($parts as $part) {
                if (!empty($part['text'])) {
                    $content .= $part['text'];
                }

                $funcResp = $part['function_response'] ?? null;
                if ($funcResp && ($funcResp['name'] ?? null) === 'rag_query') {
                    $data = $funcResp['response'] ?? [];
                    if (($data['status'] ?? null) === 'success') {
                        foreach ($data['results'] ?? [] as $res) {
                            $source = $res['source_name'] ?? $res['source_uri'] ?? null;
                            if ($source && !in_array($source, $citations, true)) {
                                $citations[] = $source;
                            }
                        }
                    }
                }
            }
        }

        if ($content === '') {
            Log::warning('Vertex AI stream returned no text', ['length' => strlen($body)]);
            $content = 'Recebi uma resposta incompleta do assistente. Por favor, tente novamente.';
        }

        return [
            'content' => $content,
            'citations' => $citations,
        ];
    }
}
