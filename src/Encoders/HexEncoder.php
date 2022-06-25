<?php

namespace ZnLib\QrBox\Encoders;

class HexEncoder extends \ZnLib\Components\Format\Encoders\HexEncoder implements EntityEncoderInterface
{

    public function compressionRate(): float
    {
        return 2;
    }
}