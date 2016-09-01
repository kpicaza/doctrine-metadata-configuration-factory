<?php

namespace DRKP\ZF3Doctrine;

use Doctrine\Common\Cache\Cache;
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
    private $isDevMode;

    /**
     * @var null
     */
    private $proxyDir;

    /**
     * @var Cache
     */
    private $cache;

    /**
     * MetadataConfigurationFactory constructor.
     * @param $mappings
     * @param $type
     */
    public function __construct(array $mappings, $type, $isDevMode = false, $proxyDir = null, Cache $cache = null)
    {
        foreach ($mappings as $mapping) {
            if (false === MappingConfigValidator::validate($mapping)) {
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
        $this->isDevMode = $isDevMode;
        $this->proxyDir = $proxyDir;
        $this->cache = $cache;
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
            $this->isDevMode,
            $this->proxyDir,
            $this->cache
        );
    }

}
