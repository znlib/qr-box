<?php

namespace ZnLib\QrBox\Factories;

use ZnLib\Components\Format\Encoders\GZipEncoder;
use ZnLib\Components\Format\Encoders\ZipEncoder;
use ZnLib\QrBox\Encoders\Base64Encoder;
use ZnLib\QrBox\Encoders\HexEncoder;
use ZnLib\QrBox\Libs\ClassEncoder;

class ClassEncoderFactory
{

    public static function create(): ClassEncoder
    {
        $encoders = [
            'zip' => ZipEncoder::class,
            'gz' => new GZipEncoder(ZLIB_ENCODING_GZIP, 9),
            'gzDeflate' => new GZipEncoder(ZLIB_ENCODING_RAW, 9),
            'base64' => Base64Encoder::class,
            'b64' => Base64Encoder::class,
            'hex' => HexEncoder::class,
        ];
        $classEncoder = new ClassEncoder($encoders);
        return $classEncoder;
    }
}