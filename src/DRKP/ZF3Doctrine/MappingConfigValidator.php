<?php

namespace DRKP\ZF3Doctrine;

/**
 * Class MappingConfigValidator
 * @package DRKP\ZF3Doctrine
 */
class MappingConfigValidator
{
    /**
     * @param array $mapping
     * @return bool
     */
    public static function validate(array $mapping)
    {
        if (
            !array_key_exists('path', $mapping) ||
            !array_key_exists('namespace', $mapping) ||
            !array_key_exists('type', $mapping)
        ) {
            return false;
        }

        return true;
    }
}
