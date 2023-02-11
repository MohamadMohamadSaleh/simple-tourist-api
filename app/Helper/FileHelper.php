<?php

namespace App\Helper;

use Illuminate\Http\UploadedFile;

trait FileHelper
{
    public function uploadFile(UploadedFile $file, string $path = 'app/public/uploads'): ?string
    {
        try {
            $path = storage_path($path);
            if (!file_exists($path) && !mkdir($path, 0777, true) && !is_dir($path)) {
                return null;
            }
            $name = uniqid('', true) . '_' . trim($file->getClientOriginalName());
            $file->move($path, $name);
            return $name;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
