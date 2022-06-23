<?php

namespace ZnLib\QrBox\Encoders;

class HexEncoder extends \ZnCore\Base\Format\Encoders\HexEncoder implements EntityEncoderInterface
{

    public function compressionRate(): float
    {
        return 2;
    }
}