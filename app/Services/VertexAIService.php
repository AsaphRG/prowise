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

    /**
     * Query the Reasoning Engine (RAG Agent)
     */
    public function query(string $query, array $history = [])
    {
        try {
            $token = $this->getAccessToken();
            $endpoint = "https://{$this->location}-aiplatform.googleapis.com/v1/projects/{$this->projectId}/locations/{$this->location}/reasoningEngines/{$this->resourceId}:query";

            // O AgentWrapper no Python espera 'message'
            $payload = [
                'message' => $query,
                'user_id' => 'laravel_user',
                'session_id' => 'laravel_session'
            ];

            $response = Http::withToken($token)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($endpoint, $payload);

            if ($response->failed()) {
                Log::error('Vertex AI Request Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'payload' => $payload,
                    'endpoint' => $endpoint
                ]);
                return [
                    'content' => "Desculpe, tive um problema ao processar sua solicitação. Por favor, tente novamente.",
                    'citations' => []
                ];
            }

            $result = $response->json();

            // Resposta do Reasoning Engine via ADK geralmente vem em 'output'
            $content = '';
            $citations = [];

            if (isset($result['output'])) {
                // Se a saída for uma string direta
                if (is_string($result['output'])) {
                    $content = $result['output'];
                } 
                // Se for um array (ex: se o agente retornar JSON estruturado)
                elseif (is_array($result['output'])) {
                    $content = $result['output']['content'] ?? $result['output']['answer'] ?? json_encode($result['output']);
                    $citations = $result['output']['citations'] ?? $result['output']['sources'] ?? [];
                }
            } else {
                Log::warning('Resposta inesperada do Vertex AI', ['result' => $result]);
                return [
                    'content' => "Recebi uma resposta incompleta do assistente. Por favor, tente novamente.",
                    'citations' => []
                ];
            }

            return [
                'content' => $content,
                'citations' => $citations
            ];

        } catch (\Exception $e) {
            Log::error('Vertex AIService Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'content' => "Ocorreu um erro interno ao tentar falar com o assistente.",
                'citations' => []
            ];
        }
    }
}
