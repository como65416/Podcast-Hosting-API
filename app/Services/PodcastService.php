<?php

namespace App\Services;

use App\Repositories\Interfaces\ChannelRepositoryInterface;
use App\Repositories\Interfaces\ItemRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class PodcastService
{
    protected $channelRepository;

    protected $itemRepository;

    public function __construct(ChannelRepositoryInterface $channelRepository, ItemRepositoryInterface $itemRepository)
    {
        $this->channelRepository = $channelRepository;
        $this->itemRepository = $itemRepository;
    }

    /**
     * @param  int    $memberId
     * @param  array  $channelData
     * [
     *     'title' => title,
     *     'description' => description,
     * ]
     * @return channel id
     */
    public function createChannel(int $memberId, array $channelData)
    {
        $channelId = $this->channelRepository->createChannel([
            'memberId' => $memberId,
        ] + $channelData);

        return $channelId;
    }

    /**
     * @param  int    $channelId
     * @param  array  $itemData
     * [
     *     'title' => title,
     *     'description' => description,
     *     'publishAt' => publish time,
     * ]
     * @return item id
     */
    public function createItem(int $channelId, array $itemData)
    {
        $itemId = $this->itemRepository->createItem([
            'channelId' => $channelId,
            'audioPath' => '',
        ] + $itemData);

        return $itemId;
    }

    /**
     * @param int    $itemId
     * @param string $audioPath
     */
    public function setItemAudio(int $itemId, string $audioPath)
    {
        $saveDir = 'UploadFile/Audios';
        Storage::disk('local')->putFileAs($saveDir, new File($audioPath), $itemId);

        $this->itemRepository->updateItemData($itemId, [
            'audioPath' => $saveDir . '/' . $itemId,
        ]);
    }

    /**
     * get item audio content
     *
     * @param  int $itemId
     * @return string|null
     */
    public function getItemAudio(int $itemId)
    {
        $item = $this->itemRepository->getItemsByIds([$itemId])[$itemId] ?? null;
        if ($item == null || $item['audioPath'] == '') {
            return null;
        }

        $fileContent = Storage::disk('local')->get($item['audioPath']);
        $savePath = sys_get_temp_dir() . '/' . uniqid();
        file_put_contents($savePath, $fileContent);

        return $savePath;
    }

    /**
     * @param  int $memberId
     * @return array
     * [
     *     [
     *         'id' => channel id,
     *         'title' => title,
     *         'description' => description,
     *     ],
     *     ...
     * ]
     */
    public function getMemberChannels(int $memberId)
    {
        return $this->channelRepository->getChannelsByMemberIds([$memberId])[$memberId] ?? [];
    }

    /**
     * @param  int    $channelId
     * @return array|null
     * [
     *     'id' => channel id,
     *     'title' => title,
     *     'description' => description,
     * ]
     */
    public function getChannel(int $channelId)
    {
        return $this->channelRepository->getChannelsByIds([$channelId])[$channelId] ?? null;
    }

    /**
     * @param  int    $itemId
     * @return array|null
     * [
     *     'id' => 'id',
     *     'channelId' => channel id,
     *     'title' => title,
     *     'description' => description,
     *     'publishAt' => publish time,
     * ]
     */
    public function getItem(int $itemId)
    {
        return $this->itemRepository->getItemsByIds([$itemId])[$itemId] ?? null;
    }

    /**
     * @param  int    $channelId
     * @return array
     * [
     *     [
     *         'id' => 'id',
     *         'channelId' => channel id,
     *         'title' => title,
     *         'description' => description,
     *         'publishAt' => publish time,
     *     ],
     *     ...
     *  ]
     */
    public function getChannelItems(int $channelId)
    {
        $items = $this->itemRepository->getItemsByChannelIds([$channelId])[$channelId] ?? [];
        $outItems = [];
        foreach ($items as $item) {
            $outItems[] = [
                'id' => $item['id'],
                'channelId' => $item['channelId'],
                'title' => $item['title'],
                'description' => $item['description'],
                'publishAt' => $item['publishAt'],
                'hasAudio' => !empty($item['audioPath']),
            ];
        }

        return $outItems;
    }
}
