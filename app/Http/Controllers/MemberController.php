<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use App\Services\JwtService;
use App\Services\MemberService;

class MemberController extends Controller
{
    protected $memberService;

    protected $jwtService;

    public function __construct(MemberService $memberService, JwtService $jwtService)
    {
        $this->memberService = $memberService;
        $this->jwtService = $jwtService;
    }

    /**
     * register new account
     *
     * @param  Request $request
     */
    public function register(Request $request)
    {
        $this->validateRequest($request, [
            'name' => ['required', 'string', 'min:2'],
            'account' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'email']
        ]);

        $member = $this->memberService->getMemberByAccount($request->input('account'));
        if ($member != null) {
            throw new BadRequestException('Account already exists.');
        }

        $this->memberService->createMember([
            'name' => $request->input('name'),
            'account' => $request->input('account'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
        ]);
    }

    /**
     * login and get jwt token
     *
     * @param  Request $request
     */
    public function login(Request $request)
    {
        $this->validateRequest($request, [
            'account' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $memberId = $this->memberService->validatePassword(
            $request->input('account'),
            $request->input('password'),
        );
        if ($memberId == null) {
            throw new UnauthorizedException('account or password not validated.');
        }

        return [
            'token' => $this->jwtService->generateToken([
                'memberId' => $memberId,
            ], 86400),
        ];
    }

    /**
     * get account profile
     *
     * @param  Request $request
     */
    public function getProfile(Request $request)
    {
        $memberId = $request->attributes->get('memberId');
        $member = $this->memberService->getMemberById($memberId);

        return $member;
    }

    /**
     * update account profile
     *
     * @param Request $request
     */
    public function updateProfile(Request $request)
    {
        $this->validateRequest($request, [
            'name' => ['string', 'min:2'],
            'password' => ['string', 'min:8'],
            'email' => ['string', 'email'],
        ]);

        $memberId = $request->attributes->get('memberId');
        $updateData = $request->all();

        $this->memberService->updateMember($memberId, $updateData);

        return new Response('', 204);
    }
}
