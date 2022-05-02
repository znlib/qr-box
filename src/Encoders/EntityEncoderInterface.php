<?php

namespace ZnLib\QrBox\Encoders;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;

interface EntityEncoderInterface extends EncoderInterface
{

    public function compressionRate(): float;

}
