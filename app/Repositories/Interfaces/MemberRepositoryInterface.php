<?php

namespace App\Repositories\Interfaces;

interface MemberRepositoryInterface
{
    /**
     * @param  array $data
     * [
     *     'name' => 'name',
     *     'email' => email,
     *     'account' => 'account',
     *     'password' => 'password',
     * ]
     * @return int member id
     */
    public function createMember($data);

    /**
     * @param  string $account
     * @return array|null
     * [
     *     'id' => id,
     *     'name' => 'name',
     *     'email' => email,
     *     'account' => 'account',
     *     'password' => 'password',
     * ]
     */
    public function getMemberByAccount(string $account);

    /**
     * @param  int $id
     * @return array|null
     * [
     *     'id' => id,
     *     'name' => 'name',
     *     'email' => email,
     *     'account' => 'account',
     *     'password' => 'password',
     * ]
     */
    public function getMemberById(int $id);

    /**
     * @param  int    $id
     * @param  array  $data
     * [
     *     'name' => 'name',
     *     'email' => email,
     *     'password' => 'password',
     * ]
     */
    public function updateMemberData(int $id, array $data);
}
