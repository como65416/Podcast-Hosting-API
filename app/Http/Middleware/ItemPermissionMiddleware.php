<?php

namespace App\Http\Middleware;

use App\Exceptions\ForbiddenException;
use App\Services\PodcastService;
use Closure;
use Exception;

class ItemPermissionMiddleware
{
    protected $podcastService;

    public function __construct(PodcastService $podcastService)
    {
        $this->podcastService = $podcastService;
    }

    public function handle($request, Closure $next)
    {
        $memberId = $request->attributes->get('memberId');
        $channelId = $request->route('channelId');
        $itemId = $request->route('itemId');

        $channel = $this->podcastService->getChannel($channelId);
        $item = $this->podcastService->getItem($itemId);
        if ($channel == null || $item == null || $item['channelId'] != $channelId || $channel['memberId'] != $memberId) {
            throw new ForbiddenException('no permission.');
        }

        return $next($request);
    }
}
