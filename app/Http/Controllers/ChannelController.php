<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use App\Services\JwtService;
use App\Services\MemberService;
use App\Services\PodcastService;

class ChannelController extends Controller
{
    protected $podcastService;

    public function __construct(PodcastService $podcastService)
    {
        $this->podcastService = $podcastService;
    }

    /**
     * create new channel
     *
     * @param  Request $request
     */
    public function createChannel(Request $request)
    {
        $this->validateRequest($request, [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $memberId = $request->attributes->get('memberId');
        $channelId = $this->podcastService->createChannel($memberId, $request->all());

        return [
            'channelId' => $channelId,
        ];
    }

    /**
     * get all channel
     *
     * @param  Request $request
     */
    public function getChannels(Request $request)
    {
        $memberId = $request->attributes->get('memberId');

        return $this->podcastService->getMemberChannels($memberId);
    }

    /**
     * delete channel
     *
     * @param  Request $request
     */
    public function deleteChannel(Request $request)
    {
        $channelId = $request->route('channelId');
        $this->podcastService->deleteChannel($channelId);

        return new Response('', 204);
    }
}
