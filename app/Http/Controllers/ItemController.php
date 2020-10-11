<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use App\Services\JwtService;
use App\Services\MemberService;
use App\Services\PodcastService;

class ItemController extends Controller
{
    protected $podcastService;

    public function __construct(PodcastService $podcastService)
    {
        $this->podcastService = $podcastService;
    }

    /**
     * create new channel item
     *
     * @param  Request $request
     * @return
     */
    public function createItem(Request $request)
    {
        $this->validateRequest($request, [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'publishAt' => ['required', 'int'],
        ]);

        $channelId = $request->route('channelId');
        $itemId = $this->podcastService->createItem($channelId, $request->all());

        return [
            'itemId' => $itemId,
        ];
    }

    /**
     * upload item audio
     *
     * @param  Request $request
     */
    public function uploadAudio(Request $request)
    {
        $this->validateRequest($request, [
            'audio' => ['required', 'file'],
        ]);

        $audioFile = $request->file('audio');
        $itemId = $request->route('itemId');
        $this->podcastService->setItemAudio($itemId, $audioFile->getRealPath());

        return new Response('', 204);
    }

    /**
     * download item audio
     *
     * @param  Request $request
     */
    public function getAudio(Request $request)
    {
        $itemId = $request->route('itemId');
        $filePath = $this->podcastService->getItemAudio($itemId);

        if ($filePath === null) {
            return new JsonResponse([
                'message' => 'audio not found.',
            ], 404);
        }

        return response()
            ->download($filePath, 'audio', [
                'Content-Type' => mime_content_type($filePath),
            ])
            ->deleteFileAfterSend();;
    }

    /**
     * get channel items
     *
     * @param  Request $request
     */
    public function getItems(Request $request)
    {
        $channelId = $request->route('channelId');
        $items = $this->podcastService->getChannelItems($channelId);
        $outItems = [];
        foreach($items as $item) {
            $audioUrl = env('APP_URL') . '/Channels/' . $item['channelId'] . '/Items/' . $item['id'] . '/Audios';

            $outItems[] = [
                'id' => $item['id'],
                'channelId' => $item['channelId'],
                'title' => $item['title'],
                'description' => $item['description'],
                'publishAt' => $item['publishAt'],
                'audioUrl' => ($item['hasAudio']) ? $audioUrl : null,
            ];
        }

        return $outItems;
    }

    /**
     * delete item
     *
     * @param  Request $request
     */
    public function deleteItem(Request $request)
    {
        $itemId = $request->route('itemId');
        $this->podcastService->deleteItem($itemId);

        return new Response('', 204);
    }
}
