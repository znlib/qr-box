<?php

namespace ZnLib\QrBox\Factories;

use ZnLib\QrBox\Libs\ClassEncoder;
use ZnLib\QrBox\Libs\DataSize;
use ZnLib\QrBox\Libs\WrapperDetector;
use ZnLib\QrBox\Services\EncoderService;
use ZnLib\QrBox\Wrappers\WrapperInterface;

class EncoderServiceFactory
{

    public static function createService(array $resultEncoders, array $wrappers, WrapperInterface $wrapper, ClassEncoder $classEncoder, int $maxQrSize = 1183): EncoderService
    {
        $wrapperDetector = new WrapperDetector($wrappers);
        $resultEncoder = $classEncoder->encodersToClasses($resultEncoders);
        $wrapperEncoder = $classEncoder->encodersToClasses($wrapper->getEncoders());
        $dataSize = new DataSize($wrapperEncoder, $wrapper, $maxQrSize);
        $encoderService = new EncoderService(
            $wrapperDetector,
            $resultEncoder,
            $wrapperEncoder,
            $wrapper,
            $dataSize
        );
        return $encoderService;
    }
}