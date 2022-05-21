<?php

namespace App\Providers;

use App\Facades\NodeApi;
use App\Facades\NodeHelper;
use App\Facades\NodeRepositoryFacade;
use App\Repositories\NodeRepository;
use App\Services\NodeApiService;
use App\Services\NodeHelperService;
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
        NodeHelper::shouldProxyTo(NodeHelperService::class);
        NodeRepositoryFacade::shouldProxyTo(NodeRepository::class);
    }
}
