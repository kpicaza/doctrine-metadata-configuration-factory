<?php

namespace spec\DRKP\ZF3Doctrine;

use Doctrine\ORM\Configuration;
use DRKP\ZF3Doctrine\MetadataConfigurationFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MetadataConfigurationFactorySpec extends ObjectBehavior
{
    const VALID_MAPPING_TYPES = [
        'yaml',
        'xml',
        'annotation'
    ];

    const CONFIG_ANNOTATION = [
        "mappings" => [
            [
                "type" => "annotation",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "path" => __DIR__ . "/test/mapping",
            ],
        ],
    ];

    const CONFIG_YAML = [
        "mappings" => [
            [
                "type" => "yaml",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "path" => __DIR__ . "/test/mapping",
            ],
        ],
    ];

    const CONFIG_XML = [
        "mappings" => [
            [
                "type" => "xml",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "path" => __DIR__ . "/test/mapping",
            ],
        ],
    ];

    const MULTIPLE_MAPPINGS = [
        "mappings" => [
            [
                "type" => "xml",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "path" => __DIR__ . "/test/mapping",
            ],
            [
                "type" => "xml",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "path" => __DIR__ . "/test/mapping",
            ],
            [
                "type" => "yaml",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "path" => __DIR__ . "/test/mapping",
            ],
        ],
    ];

    const INVALID_CONFIG_TYPE = [
        "mappings" => [
            [
                "type" => "other",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "path" => __DIR__ . "/test/mapping",
            ],
        ],
    ];

    const INVALID_CONFIG_MAPPING = [
        "mappings" => [
            [
                "type" => "yaml",
                "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
                "posth" => __DIR__ . "/test/mapping",
            ],
        ],
    ];

    function it_should_thrown_an_exception_when_mapping_is_not_valid()
    {
        $mapping = self::INVALID_CONFIG_MAPPING;
        $this->beConstructedWith(
            $mapping['mappings'],
            $mapping['mappings'][0]['type']
        );

        $this->shouldThrow(
            \InvalidArgumentException::class
        )->duringInstantiation();
    }

    function it_can_be_yaml_configuration_class()
    {
        $mapping = self::CONFIG_YAML;
        $this->beConstructedWith(
            $mapping['mappings'],
            $mapping['mappings'][0]['type']
        );

        $this->make()->shouldReturnAnInstanceOf(Configuration::class);
    }

    function it_should_thrown_an_exception_when_mapping_type_is_not_valid()
    {
        $mapping = self::CONFIG_YAML;

        $this->beConstructedWith(
            $mapping['mappings'],
            self::INVALID_CONFIG_TYPE
        );

        $this->shouldThrow(
            \InvalidArgumentException::class
        )->duringInstantiation();
    }

    function it_can_be_annotation_configuration_class()
    {
        $mapping = self::CONFIG_ANNOTATION;
        $this->beConstructedWith(
            $mapping['mappings'],
            $mapping['mappings'][0]['type']
        );

        $this->make()->shouldReturnAnInstanceOf(Configuration::class);
    }

    function it_can_be_xml_configuration_class()
    {
        $mapping = self::CONFIG_YAML;
        $this->beConstructedWith(
            $mapping['mappings'],
            $mapping['mappings'][0]['type']
        );

        $this->make()->shouldReturnAnInstanceOf(Configuration::class);
    }

    function it_should_ignore_mappings_with_diferent_mapping_type_than_expected()
    {
        $mapping = self::MULTIPLE_MAPPINGS;
        $this->beConstructedWith(
            $mapping['mappings'],
            $mapping['mappings'][0]['type']
        );

        $this->make()->shouldReturnAnInstanceOf(Configuration::class);
    }
}
