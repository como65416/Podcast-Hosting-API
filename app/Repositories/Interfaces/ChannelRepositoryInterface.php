<?php

namespace App\Repositories\Interfaces;

interface ChannelRepositoryInterface
{
    /**
     * @param  array $data
     * [
     *     'member_id' => member id,
     *     'title' => title,
     *     'description' => 'description',
     * ]
     * @return int channel id
     */
    public function createChannel($data);

    /**
     * @param  array    $memberIds
     * @return array
     * [
     *     member id => [
     *         [
     *             'id' => id,
     *             'memberId' => member id,
     *             'title' => title,
     *             'description' => description,
     *         ],
     *         ...
     *     ]
     *     ...
     * ]
     */
    public function getChannelsByMemberIds(array $memberIds);

    /**
     * @param  int    $id
     * @return array
     * [
     *     id => [
     *         'id' => id,
     *         'memberId' => member id,
     *         'title' => title,
     *         'description' => description,
     *     ],
     *     ...
     * ]
     */
    public function getChannelsByIds(array $ids);

    /**
     * @param  int    $id
     * @param  array  $data
     * [
     *     'title' => title,
     *     'description' => description,
     * ]
     */
    public function updateChannelData(int $id, array $data);

    /**
     * @param  array    $ids
     */
    public function deleteChannelsByIds(array $ids);
}
