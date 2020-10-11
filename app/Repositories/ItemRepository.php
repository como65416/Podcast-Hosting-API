<?php

namespace App\Repositories;

use App\Models\Item;
use App\Repositories\Interfaces\ItemRepositoryInterface;

class ItemRepository implements ItemRepositoryInterface
{
    protected $itemModel;

    public function __construct(Item $itemModel)
    {
        $this->itemModel = $itemModel;
    }

    /**
    * {@inheritDoc}
     */
    public function createItem($data)
    {
        $item = new Item;
        $item->channel_id = $data['channelId'];
        $item->title = $data['title'];
        $item->description = $data['description'];
        $item->audio_path = $data['audioPath'];
        $item->publish_at = $data['publishAt'];
        $item->save();

        return $item->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getItemsByIds(array $ids)
    {
        $items = $this->itemModel
            ->select('id', 'channel_id as channelId', 'title', 'description', 'audio_path as audioPath', 'publish_at as publishAt')
            ->whereIn('id', $ids)
            ->get();

        return $items->keyBy('id')->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function getItemsByChannelIds(array $channelIds)
    {
        $items = $this->itemModel
            ->select('id', 'channel_id as channelId', 'title', 'description', 'audio_path as audioPath', 'publish_at as publishAt')
            ->whereIn('channel_id', $channelIds)
            ->get();

        return $items->groupBy('channelId')->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function updateItemData(int $id, array $data)
    {
        $item = $this->itemModel->find($id);
        $item->channel_id = $data['channelId'] ?? $item->channel_id;
        $item->title = $data['title'] ?? $item->title;
        $item->description = $data['description'] ?? $item->description;
        $item->audio_path = $data['audioPath'] ?? $item->audio_path;
        $item->publish_at = $data['publishAt'] ?? $item->publish_at;
        $item->save();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteItemsByIds(array $ids)
    {
        $this->itemModel->whereIn('id', $ids)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteItemsByChannelIds(array $channelIds)
    {
        $this->itemModel->whereIn('channel_id', $channelIds)->delete();
    }
}
