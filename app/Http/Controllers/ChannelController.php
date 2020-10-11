<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use App\Services\JwtService;
use App\Services\MemberService;
use App\Services\PodcastService;
use Comoco\PodcastRssXml\RssGenerator;
use Comoco\PodcastRssXml\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChannelController extends Controller
{
    protected $podcastService;

    protected $memberService;

    public function __construct(PodcastService $podcastService, MemberService $memberService)
    {
        $this->podcastService = $podcastService;
        $this->memberService = $memberService;
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

    /**
     * get channel rss xml
     *
     * @param  Request $request
     */
    public function getRss(Request $request)
    {
        $channelId = $request->route('channelId');
        $channel = $this->podcastService->getChannel($channelId);
        $items = $this->podcastService->getChannelItems($channelId);
        $member = $this->memberService->getMemberById($channel['memberId']);

        $rssGenerator = new RssGenerator;
        $rssGenerator->setTitle($channel['title'])
            ->setDescription($channel['description'])
            ->setAuthor($member['name'])
            ->setOwner($member['email']);
        foreach ($items as $item) {
            if ($item['publishAt'] > time() || !$item['hasAudio']) {
                continue;
            }

            $audioUrl = env('APP_URL') . '/Channels/' . $item['channelId'] . '/Items/' . $item['id'] . '/Audios';
            $rssGenerator->addItem(
                (new Item)->setTitle($item['title'])
                    ->setGuid($item['id'])
                    ->setDescription($item['description'])
                    ->setPubTime($item['publishAt'])
                    ->setAudioUrl($audioUrl)
            );
        }

        return (new Response($rssGenerator->toXml(), 200))
            ->header('Content-Type', 'text/xml');
    }
}
