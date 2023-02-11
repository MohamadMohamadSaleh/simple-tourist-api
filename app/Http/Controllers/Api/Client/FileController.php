<?php

namespace App\Http\Controllers\Api\Client;

use App\Helper\FileHelper;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\Client\Client\UploadRequest;
use Illuminate\Http\Response;


class FileController extends ApiController
{
    use FileHelper;

    public function upload(UploadRequest $request): Response
    {
        $file = $this->uploadFile($request->file('file'));
        return $file ?
            $this->operationSucceeded(['name' => $file]) :
            $this->operationFailed();
    }
}
