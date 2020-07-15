<?php

namespace VentureLeapUtilBundle\Util;

final class ArrayUtil
{
    public static function getMappedArray(array $array, $label = null): array
    {
        return array_map(
            function ($elem) use ($label) {
                return $label.$elem;
            },
            $array
        );
    }

    public static function getMappedAndCombinedArray(array $array, $label = null): array
    {
        return array_combine(
            self::getMappedArray($array, $label),
            $array
        );
    }
}
