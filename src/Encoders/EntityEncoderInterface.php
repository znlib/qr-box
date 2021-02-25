<?php

namespace ZnLib\QrBox\Encoders;

use ZnCore\Base\Interfaces\EncoderInterface;

interface EntityEncoderInterface extends EncoderInterface
{

    public function compressionRate(): float;

}
