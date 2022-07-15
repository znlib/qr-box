<?php

namespace ZnLib\QrBox\Services;

use DateTime;
use Exception;
use ZnCore\Collection\Interfaces\Enumerable;
use ZnCore\Collection\Libs\Collection;
use ZnDomain\Entity\Helpers\CollectionHelper;
use ZnLib\Components\Format\Encoders\ChainEncoder;
use ZnLib\QrBox\Entities\BarCodeEntity;
use ZnLib\QrBox\Libs\DataSize;
use ZnLib\QrBox\Libs\WrapperDetector;
use ZnLib\QrBox\Wrappers\WrapperInterface;

class EncoderService
{

    private $wrapperDetector;
    private $defaultEntityWrapper;
    private $wrappers = [];
    private $resultEncoder;
    private $wrapperEncoder;
    private $dataSize;

    public function __construct(
        WrapperDetector $wrapperDetector,
        ChainEncoder $resultEncoder,
        ChainEncoder $wrapperEncoder,
        WrapperInterface $defaultEntityWrapper,
        DataSize $dataSize
    )
    {
        $this->wrapperDetector = $wrapperDetector;
        $this->resultEncoder = $resultEncoder;
        $this->wrapperEncoder = $wrapperEncoder;
        $this->entityWrapper = $defaultEntityWrapper;
        $this->dataSize = $dataSize;
    }

    public function encode(string $data): Enumerable
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Empty data for encode!');
        }
        $encoded = $this->resultEncoder->encode($data);
        $dataSize = $this->dataSize->getSize($this->wrapperEncoder, $this->entityWrapper);
        $encodedParts = str_split($encoded, $dataSize);
        $collection = new Collection();
        foreach ($encodedParts as $index => $item) {
            $encodedItem = $this->wrapperEncoder->encode($item);
            $barCodeEntity = new BarCodeEntity();
            $barCodeEntity->setId($index + 1);
            $barCodeEntity->setData($encodedItem);
            $barCodeEntity->setCount(count($encodedParts));
            $barCodeEntity->setCreatedAt(new DateTime());
            $barCodeEntity->setEntityEncoders($this->entityWrapper->getEncoders());
            $collection->add($this->entityWrapper->encode($barCodeEntity));
        }
        return $collection;
    }

    public function decode(Enumerable $encodedData)
    {
        $barCodeCollection = $this->arrayToCollection($encodedData);
        $resultCollection = new Collection();
        foreach ($barCodeCollection as $barCodeEntity) {
            $decodedItem = $this->wrapperEncoder->decode($barCodeEntity->getData());
            $resultCollection->add($decodedItem);
        }
        $resultArray = $resultCollection->toArray();
        return $this->resultEncoder->decode(implode('', $resultArray));
    }

    /**
     * @param Enumerable $array
     * @return Enumerable | BarCodeEntity[]
     * @throws Exception
     */
    private function arrayToCollection(Enumerable $array): Enumerable
    {
        $collection = new Collection();
        foreach ($array as $item) {
            $wrapper = $this->wrapperDetector->detect($item);
            $barCodeEntity = $wrapper->decode($item);
            $collection->add($barCodeEntity);
        }
        $arr = CollectionHelper::indexing($collection, 'id');
        ksort($arr);
        return new Collection($arr);
    }
}