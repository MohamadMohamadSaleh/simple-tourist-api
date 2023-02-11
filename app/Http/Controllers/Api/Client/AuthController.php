<?php

namespace App\Http\Controllers\Api\Client;

use App\Helper\ApiResponse;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Client\Auth\LoginRequest;
use App\Http\Requests\Api\Client\Auth\RegisterRequest;
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

        $user = $this->user->login($request->validated(), $this->user->where('email', $request->get('email'))->first());
        if (!$user) {
            return $this->authenticationFailed();
        }
        $user->load('favorites.favorable');
        return $this->operationSucceeded($user);
    }

    public function register(RegisterRequest $request): Response
    {
        $user = $this->user->register($request->validated());
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
