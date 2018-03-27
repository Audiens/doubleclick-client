<?php

namespace Audiens\DoubleclickClient\entity;

use Audiens\DoubleclickClient\exceptions\ClientException;
use ReflectionObject;
use Zend\Hydrator\Reflection;

trait HydratableTrait
{

    public static function preProcess(array $objectArray): array
    {
        return $objectArray;
    }

    /**
     * @param array $objectArray
     *
     * @return static
     * @throws \Audiens\DoubleclickClient\exceptions\ClientException
     * @throws \Zend\Hydrator\Exception\BadMethodCallException
     */
    public static function fromArray(array $objectArray)
    {
        $objectArray = static::preProcess($objectArray);

        $object           = new self();
        $reflectionObject = new ReflectionObject($object);
        $props            = $reflectionObject->getProperties();

        $missingFields = [];
        foreach ($props as $prop) {
            if (strpos($prop->getDocComment(), '@required') === false) {
                continue;
            }
            $propName = $prop->getName();


            if (!isset($objectArray[$propName])) {
                $missingFields[] = $propName;
            }
        }

        if (\count($missingFields) > 0) {
            throw new ClientException('hydration: missing ['.implode(', ', $missingFields).']');
        }

        self::getHydrator()->hydrate($objectArray, $object);

        return $object;
    }

    public function toArray(): array
    {
        return self::getHydrator()->extract($this);
    }

    private static function getHydrator(): Reflection
    {
        return new Reflection();
    }
}
