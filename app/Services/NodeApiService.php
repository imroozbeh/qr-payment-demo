<?php

namespace App\Services;

class NodeApiService
{
    public function __call(string $name, array $arguments = [])
    {
        switch (config('node-api.default')) {
            case 'getblock':
                $response = \Illuminate\Support\Facades\Http::withHeaders([
                    'x-api-key' => config('node-api.providers.getblock.x-api-key'),
                    'Content-Type' => 'application/json',
                ])->post(config('node-api.providers.getblock.endpoint'), [
                    'jsonrpc' => '2.0',
                    'method' => $name,
                    'params' => $arguments,
                    'id' => config('node-api.providers.getblock.id'),
                ]);
                break;
        }
        return ['body' => $response->json(), 'status' => $response->status()];
    }
}
