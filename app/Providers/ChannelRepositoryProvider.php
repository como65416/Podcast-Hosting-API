<?php

namespace App\Providers;

use App\Models\Channel;
use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\ChannelRepository;
use Illuminate\Support\ServiceProvider;

class ChannelRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ChannelRepositoryInterface::class, function($app) {
            return new ChannelRepository(new Channel());
        });
    }
}
