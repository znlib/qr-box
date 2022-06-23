<?php

namespace ZnLib\QrBox\Encoders;

class Base64Encoder extends \ZnCore\Base\Libs\Format\Encoders\Base64Encoder implements EntityEncoderInterface
{

    public function compressionRate(): float
    {
        return 4 / 3;
    }
}