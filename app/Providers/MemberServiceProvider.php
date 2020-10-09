<?php

namespace App\Providers;

use App\Services\MemberService;
use App\Repositories\Interfaces\MemberRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class MemberServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MemberService::class, function($app) {
            return new MemberService(
                $app->make(MemberRepositoryInterface::class)
            );
        });
    }
}
