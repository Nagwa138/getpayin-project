<?php

namespace App\Architecture\Injector;

use App\Architecture\Services\Classes\PlatformService;
use App\Architecture\Services\Classes\PostService;
use App\Architecture\Services\Interfaces\IPlatformService;
use App\Architecture\Services\Interfaces\IPostService;
use Illuminate\Support\ServiceProvider;

class ServicesInjector extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(IPostService::class, PostService::class);
        $this->app->bind(IPlatformService::class, PlatformService::class);
    }
}
