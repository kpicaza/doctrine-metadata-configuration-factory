<?php

namespace DRKP\ZF3Doctrine;

use Doctrine\ORM\Tools\Setup;

class MetadataConfigurationFactory
{
    /**
     * Valid mapping types.
     */
    const VALID_MAPPING_TYPES = [
        'yaml',
        'xml',
        'annotation'
    ];

    /**
     * Minimum required mapping keys.
     */
    const MAPPING_KEYS = [
        'path',
        'namespace',
        'type'
    ];

    /**
     * @var array
     */
    private $mappings;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $env;

    /**
     * MetadataConfigurationFactory constructor.
     * @param $mappings
     * @param $type
     */
    public function __construct(array $mappings, $type, $env = false)
    {
        foreach ($mappings as $mapping) {
            if (
                !array_key_exists('path', $mapping) ||
                !array_key_exists('namespace', $mapping) ||
                !array_key_exists('type', $mapping)
            ) {
                throw new \InvalidArgumentException(
                    'Mapping type should have at least an array with following keys ' . implode(', ', self::MAPPING_KEYS)
                );
            }
        }

        $this->mappings = $mappings;

        if (!in_array($type, self::VALID_MAPPING_TYPES, true)) {
            throw new \InvalidArgumentException(
                'Mapping type should be one of ' . implode(', ', self::VALID_MAPPING_TYPES)
            );
        }

        $this->type = $type;
        $this->env = $env;
    }

    /**
     * @return mixed
     */
    public function make()
    {
        $metadataConfigMethod = sprintf(
            'create%sMetadataConfiguration',
            'annotation' === $this->type ? ucfirst($this->type) : strtoupper($this->type)
        );

        $mappings = [];

        foreach ($this->mappings as $mapping) {
            if ($this->type !== $mapping['type']) {
                continue;
            }
            $mappings[] = $mapping['path'];
        }

        return Setup::$metadataConfigMethod(
            $mappings,
            $this->env
        );
    }

}
