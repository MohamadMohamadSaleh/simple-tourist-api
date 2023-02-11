<?php

namespace App\Http\Controllers\Admin\Client;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Admin\Client\Auth\LoginRequest;
use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends ApiController
{
    use ApiResponse;

    public function __construct(protected User $user)
    {
    }

    public function login(LoginRequest $request): Response
    {
        $admin = $this->user->where(['username' => $request->get('username'), 'user_scope' => 'admin'])->first();
        $user = $this->user->login($request->validated(), $admin);
        return $user ?
            $this->operationSucceeded($user) :
            $this->authenticationFailed();
    }

    public function logout(Request $request): Response
    {
        $status = $request->user()->token()->revoke();
        return $status ?
            $this->operationSucceeded() :
            $this->authenticationFailed();
    }
}
