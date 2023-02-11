<?php

namespace App\Enums\App;

use BenSampo\Enum\Enum;

final class FileTypes extends Enum
{
    //Image
    public const JPEG = "jpeg";
    public const JPG = "jpg";
    public const PNG = "png";
    public const GIF = "gif";
    public const WEBP = "webp";
    public const WBMP = "wbmp";
    public const BMP = "bmp";
    //Video
    public const MP4 = "mp4";
    public const WMV = "wmv";
    public const WEBM = "webm";
    public const MOV = "mov";
    public const M4P = "m4p";
    public const M4V = "m4v";
}
