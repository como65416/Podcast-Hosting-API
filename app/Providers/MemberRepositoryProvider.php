<?php

namespace App\Providers;

use App\Models\Member;
use App\Repositories\Interfaces\MemberRepositoryInterface;
use App\Repositories\MemberRepository;
use Illuminate\Support\ServiceProvider;

class MemberRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(MemberRepositoryInterface::class, function($app) {
            return new MemberRepository(new Member());
        });
    }
}
