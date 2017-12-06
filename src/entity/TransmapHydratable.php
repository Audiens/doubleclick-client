<?php

namespace Audiens\DoubleclickClient\entity;

use Audiens\DoubleclickClient\exceptions\ClientException;
use Doctrine\Common\Annotations\AnnotationReader;
use Exception;
use GiacomoFurlan\ObjectTransmapperValidator\Transmapper;
use RuntimeException;

/**
 * Trait TransmapHydratable
 */
trait TransmapHydratable
{
    private static $transmapper;

    private static function getTransmapper(): Transmapper
    {
        if (!static::$transmapper) {
            self::$transmapper = new Transmapper(new AnnotationReader());
        }

        return self::$transmapper;
    }

    /**
     * @param array $objectArray
     * @return array
     */
    protected static function hydratePreprocess(array $objectArray): array
    {
        return $objectArray;
    }

    /**
     * @param array $objectArray
     *
     * @return static
     * @throws \Audiens\DoubleclickClient\exceptions\ClientException
     */
    public static function fromArray(array $objectArray)
    {

        $object = (object) static::hydratePreprocess($objectArray);
        try {
            return static::getTransmapper()->map($object, static::class);
        } catch (Exception $exception) {
            throw new ClientException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return array
     * @throws \RuntimeException
     */
    public function toArray()
    {
        throw new RuntimeException('Not implemented yet');
    }
}
