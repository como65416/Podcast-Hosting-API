<?php

namespace App\Providers;

use App\Services\PodcastService;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class PodcastServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(PodcastService::class, function($app) {
            return new PodcastService(
                $app->make(ChannelRepositoryInterface::class),
                $app->make(ItemRepositoryInterface::class)
            );
        });
    }
}
