<?php

namespace App;

use Exception;
use Illuminate\Support\Facades\Http;

class FrappeApiClient
{
    protected $apiKey;
    protected $apiSecret;
    protected $frappeUrl;

    public function __construct()
    {
        $this->apiKey = env('FRAPPE_API_KEY');
        $this->apiSecret = env('FRAPPE_API_SECRET');
        $this->frappeUrl = env('FRAPPE_FRAPPE_URL');
    }

    protected function makeRequest($method, $url, $data = [])
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "token {$this->apiKey}:{$this->apiSecret}"
            ])->$method("{$this->frappeUrl}/api/{$url}", $data);

            return [
                'data' => $response->json(),
                'error' => !$response->successful(),
            ];
        } catch (Exception $exception) {
            return [
                'data' => $exception->getMessage(),
                'error' => true,
            ];
        }
    }

    public function save($docType, $data)
    {
        return $this->makeRequest('post', "resource/{$docType}", $data);
    }
    public function update($docType, $docName, $data)
    {
        return $this->makeRequest('put', "resource/{$docType}/{$docName}", $data);
    }
    public function customGetMethod($method, $params = [])
    {
        return $this->makeRequest('get', "method/{$method}", $params);
    }
}
