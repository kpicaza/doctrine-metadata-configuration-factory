<?php

namespace spec\DRKP\ZF3Doctrine;

use DRKP\ZF3Doctrine\MappingConfigValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MappingConfigValidatorSpec extends ObjectBehavior
{
    const CONFIG_ANNOTATION = [
        "type" => "annotation",
        "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
        "path" => __DIR__ . "/test/mapping",
    ];

    const INVALID_CONFIG_MAPPING = [
        "type" => "yaml",
        "namespace" => "DRKP\\ZF3Doctrine\\Tests\\ORM\\Mapping",
        "posth" => __DIR__ . "/test/mapping",
    ];

    function it_should_thrown_an_exception_when_mapping_is_not_valid()
    {
        $this->validate(
            self::INVALID_CONFIG_MAPPING
        )->shouldBe(false);
    }

    function it_have_valid_mapping_configuration()
    {
        $this->validate(
            self::CONFIG_ANNOTATION
        )->shouldBe(true);
    }
}
