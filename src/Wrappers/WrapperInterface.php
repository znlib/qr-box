<?php

namespace ZnLib\QrBox\Wrappers;

use ZnLib\QrBox\Entities\BarCodeEntity;

interface WrapperInterface
{

    public function getEncoders(): array;

    public function setEncoders(array $encoders): void;

    public function isMatch(string $encodedData): bool;

    public function encode(BarCodeEntity $entity): string;

    public function decode(string $encodedData): BarCodeEntity;
}
