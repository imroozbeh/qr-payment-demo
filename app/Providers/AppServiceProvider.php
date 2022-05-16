<?php

namespace App\Providers;

use App\Facades\NodeApi;
use App\Services\NodeApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        NodeApi::shouldProxyTo(NodeApiService::class);
    }
}
