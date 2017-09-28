<?php

namespace Audiens\DoubleclickClient\entity;

use Audiens\DoubleclickClient\exceptions\ClientException;
use ReflectionObject;
use Zend\Hydrator\ObjectProperty;
use Zend\Hydrator\Reflection;

/**
 * Class HydratableTrait
 */
trait HydratableTrait
{
    /**
     * @param array $objectArray
     *
     * @return static
     * @throws \Audiens\DoubleclickClient\exceptions\ClientException
     * @throws \Zend\Hydrator\Exception\BadMethodCallException
     */
    public static function fromArray(array $objectArray)
    {
        $object = new self();
        $reflectionObject = new ReflectionObject($object);
        $props = $reflectionObject->getProperties();

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

        if (count($missingFields) > 0) {
            throw new ClientException('hydration: missing ['.implode(', ', $missingFields).']');
        }

        self::getHydrator()->hydrate($objectArray, $object);

        return $object;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return self::getHydrator()->extract($this);
    }

    /**
     * @return ObjectProperty
     */
    private static function getHydrator()
    {
        $hydrator = new Reflection();

        return $hydrator;
    }
}
