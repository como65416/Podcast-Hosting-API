<?php

namespace App\Repositories\Interfaces;

interface ItemRepositoryInterface
{
    /**
     * @param  array $data
     * [
     *     'channelId' => channel id,
     *     'title' => title,
     *     'description' => description,
     *     'audioPath' => audio path,
     *     'publishAt' => publish time,
     * ]
     * @return int member id
     */
     public function createItem($data);

     /**
      * @param  array  $ids
      * @return array
      * [
      *     id => [
      *         'id' => 'id',
      *         'channelId' => channel id,
      *         'title' => title,
      *         'description' => description,
      *         'audioPath' => audio path,
      *         'publishAt' => publish time,
      *     ],
      *     ...
      * ]
      */
     public function getItemsByIds(array $ids);

     /**
      * @param  array  $channelIds
      * @return array
      * [
      *     channel id => [
      *         [
      *             'id' => 'id',
      *             'channelId' => channel id,
      *             'title' => title,
      *             'description' => description,
      *             'audioPath' => audio path,
      *             'publishAt' => publish time,
      *         ],
      *         ...
      *     ],
      *     ...
      * ]
      */
     public function getItemsByChannelIds(array $channelIds);

     /**
      * @param  array  $ids
      */
     public function deleteItemsByIds(array $ids);

     /**
      * @param  array  $channelIds
      */
     public function deleteItemsByChannelIds(array $channelIds);
}
