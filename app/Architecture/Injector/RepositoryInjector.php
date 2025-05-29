<?php

namespace App\Architecture\Injector;

use App\Architecture\Repositories\Classes\PlatformRepository;
use App\Architecture\Repositories\Classes\PostRepository;
use App\Architecture\Repositories\Interfaces\IPlatformRepository;
use App\Architecture\Repositories\Interfaces\IPostRepository;
use App\Models\Platform;
use App\Models\Post;
use Illuminate\Support\ServiceProvider;

class RepositoryInjector extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(IPostRepository::class, function ($app) {
            return new PostRepository($app->make(Post::class));
        });
        $this->app->singleton(IPlatformRepository::class, function ($app) {
            return new PlatformRepository($app->make(Platform::class));
        });
    }
}
