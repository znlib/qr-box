<?php

namespace ZnLib\QrBox\Libs;

use ZnCore\Domain\Collection\Libs\Collection;
use ZnLib\Components\Format\Encoders\ChainEncoder;
use ZnCore\Base\Arr\Helpers\ArrayHelper;

class ClassEncoder
{

    private $assoc = [];

    public function __construct(array $assoc)
    {
        $this->assoc = $assoc;
    }

    private function encoderToClass(string $name)
    {
        return ArrayHelper::getValue($this->assoc, $name);
    }

    public function encodersToClasses(array $names): ChainEncoder
    {
        $classes = [];
        foreach ($names as $name) {
            $classes[] = $this->encoderToClass($name);
        }
        $encoders = new ChainEncoder(new Collection($classes));
        return $encoders;
    }
}