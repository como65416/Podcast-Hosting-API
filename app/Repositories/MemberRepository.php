<?php

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\Interfaces\MemberRepositoryInterface;

class MemberRepository implements MemberRepositoryInterface
{
    protected $memberModel;

    public function __construct(Member $memberModel)
    {
        $this->memberModel = $memberModel;
    }

    /**
    * {@inheritDoc}
     */
    public function createMember($data)
    {
        $member = new Member;
        $member->account = $data['account'];
        $member->password = $data['password'];
        $member->name = $data['name'];
        $member->email = $data['email'];
        $member->save();

        return $member->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getMemberByAccount(string $account)
    {
        $member = $this->memberModel
            ->select('id', 'account', 'password', 'email', 'name')
            ->where('account', '=', $account)
            ->first();

        return ($member != null) ? $member->toArray() : null;
    }

    /**
     * {@inheritDoc}
     */
    public function getMemberById(int $id)
    {
        $member = $this->memberModel
            ->select('id', 'account', 'password', 'email', 'name')
            ->find($id);

        return ($member != null) ? $member->toArray() : null;
    }

    /**
     * {@inheritDoc}
     */
    public function updateMemberData(int $id, array $data)
    {
        $member = $this->memberModel->find($id);
        $member->password = $data['password'] ?? $member->password;
        $member->name = $data['name'] ?? $member->name;
        $member->email = $data['email'] ?? $member->email;
        $member->save();
    }
}
