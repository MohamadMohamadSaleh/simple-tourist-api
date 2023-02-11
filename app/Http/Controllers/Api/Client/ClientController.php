<?php

namespace App\Http\Controllers\Api\Client;

use App\Helper\ApiResponse;
use App\Helper\FileHelper;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Client\Client\ChangePasswordRequest;
use App\Http\Requests\Api\Client\Client\UpdateRequest;
use App\Http\Requests\Api\Client\Client\UploadRequest;
use App\Models\Client\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ClientController extends ApiController
{
    use ApiResponse, FileHelper;

    public function __construct(protected User $user)
    {
    }

    public function show(User $user): Response
    {
        return $this->operationSucceeded($user);
    }

    public function showProfile(Request $request): Response
    {
        return $this->operationSucceeded($request->user());
    }

    public function update(UpdateRequest $request): Response
    {
        $userData = $request->validated();
        $userData['name'] = $userData['first_name'] . ' ' . $userData['last_name'];
        $status = $this->user->where('id', $request->user()->id)->update($userData);
        return $status ? $this->operationSucceeded() : $this->operationFailed();
    }

    public function updatePhoto(UploadRequest $request): Response
    {
        $fileName = $this->uploadFile($request->file('file'));
        $status = $this->user->where('id', $request->user()->id)->update(['img' => $fileName]);
        return $status ? $this->operationSucceeded() : $this->operationFailed();
    }

    public function changePassword(ChangePasswordRequest $request): Response
    {
        $user = $request->validated();
        if (!Hash::check($user['old_password'], $request->user()->password)) {
            return $this->invalidData();
        }
        $status = $this->user->where('id', $request->user()->id)->update(['password' => Hash::make($user['password'])]);
        return $status ? $this->operationSucceeded() : $this->operationFailed();
    }
}
