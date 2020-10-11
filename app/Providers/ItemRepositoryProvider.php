<?php

namespace App\Providers;

use App\Models\Item;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use App\Repositories\ItemRepository;
use Illuminate\Support\ServiceProvider;

class ItemRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ItemRepositoryInterface::class, function($app) {
            return new ItemRepository(new Item());
        });
    }
}
