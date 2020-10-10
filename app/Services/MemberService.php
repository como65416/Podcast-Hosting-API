<?php

namespace App\Services;

use App\Models\Member;
use App\Repositories\Interfaces\MemberRepositoryInterface;
use App\Services\JwtService;
use Illuminate\Support\Facades\Hash;

class MemberService
{
    protected $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * @param  string    $account
     * @return array|null
     * [
     *     'id' => member id,
     *     'account' => account,
     *     'name' => name,
     *     'email' => email,
     * ]
     */
    public function getMemberByAccount(string $account)
    {
        $member = $this->memberRepository->getMemberByAccount($account);
        if ($member == null) {
            return null;
        }

        return [
            'id' => $member['id'],
            'account' => $member['account'],
            'name' => $member['name'],
            'email' => $member['email'],
        ];
    }

    /**
     * @param  int    $id
     * @return array|null
     * [
     *     'id' => member id,
     *     'account' => account,
     *     'name' => name,
     *     'email' => email,
     * ]
     */
    public function getMemberById(int $id)
    {
        $member = $this->memberRepository->getMemberById($id);
        if ($member == null) {
            return null;
        }

        return [
            'id' => $member['id'],
            'account' => $member['account'],
            'name' => $member['name'],
            'email' => $member['email'],
        ];
    }

    /**
     * @param  array $memberData
     * [
     *     'account' => account,
     *     'password' => password,
     *     'name' => name,
     *     'email' => email,
     * ]
     */
    public function createMember(array $memberData)
    {
        if (isset($memberData['password'])) {
            $memberData['password'] = Hash::make($memberData['password']);
        }

        $this->memberRepository->createMember($memberData);
    }

    /**
     * @param  string $account
     * @param  string $password
     * @return int|null if account and password is matcted, return the member id.
     */
    public function validatePassword(string $account, string $password)
    {
        $member = $this->memberRepository->getMemberByAccount($account);
        if ($member == null || !Hash::check($password, $member['password'])) {
            return null;
        }

        return $member['id'];
    }

    /**
     * @param  int   $id
     * @param  array $memberData
     * [
     *     'name' => name,
     *     'email' => email,
     *     'password' => 'password',
     * ]
     */
    public function updateMember(int $id, array $memberData)
    {
        if (isset($memberData['password'])) {
            $memberData['password'] = Hash::make($memberData['password']);
        }

        $this->memberRepository->updateMemberData($id, $memberData);
    }
}
