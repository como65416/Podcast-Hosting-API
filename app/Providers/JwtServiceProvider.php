<?php

namespace App\Providers;

use App\Services\JwtService;
use Illuminate\Support\ServiceProvider;

class JwtServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configRepository = $this->app->make('config');

        $jwtService = new JwtService(
            $configRepository->get('jwt.algorithm'),
            $configRepository->get('jwt.key')
        );
        $this->app->instance(JwtService::class, $jwtService);
    }
}
