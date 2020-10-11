<?php

namespace App\Http\Middleware;

use App\Exceptions\ForbiddenException;
use App\Services\PodcastService;
use Closure;
use Exception;

class ChannelPermissionMiddleware
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

        $channel = $this->podcastService->getChannel($channelId);
        if ($channel == null || $channel['memberId'] != $memberId) {
            throw new ForbiddenException('no permission.');
        }

        return $next($request);
    }
}
