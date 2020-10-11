<?php

namespace App\Repositories;

use App\Models\Channel;
use App\Repositories\Interfaces\ChannelRepositoryInterface;

class ChannelRepository implements ChannelRepositoryInterface
{
    protected $channelModel;

    public function __construct(Channel $channelModel)
    {
        $this->channelModel = $channelModel;
    }

    /**
     * {@inheritDoc}
     */
    public function createChannel($data)
    {
        $channel = new Channel;
        $channel->member_id = $data['memberId'];
        $channel->title = $data['title'];
        $channel->description = $data['description'];
        $channel->save();

        return $channel->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getChannelsByMemberIds(array $memberIds)
    {
        $channels = $this->channelModel
            ->select('id', 'member_id as memberId', 'title', 'description')
            ->whereIn('member_id', $memberIds)
            ->get();

        return $channels->groupBy('memberId')->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function getChannelsByIds(array $ids)
    {
        $channels = $this->channelModel
            ->select('id', 'member_id as memberId', 'title', 'description')
            ->whereIn('id', $ids)
            ->get();

        return $channels->keyBy('id')->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function updateChannelData(int $id, array $data)
    {
        $channel = $this->channelModel->find($id);
        $channel->member_id = $data['memberId'] ?? $channel->member_id;
        $channel->title = $data['title'] ?? $channel->title;
        $channel->description = $data['description'] ?? $channel->description;
        $channel->save();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteChannelsByIds(array $ids)
    {
        $this->channelModel->whereIn('id', $ids)->delete();
    }
}
