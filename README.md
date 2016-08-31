ZF3 Doctrine Metadata configuration Factory
===========================================

Factory class to create Doctrine 2  ORM Configuration instances.

Provides simple way to decide what kind of mapping you prefer in your project.

## Simple Usage:

````
<?php

$mapping = [
   "dbal" => [
       'driver' => 'pdo_sqlite',
       'path' =>  __DIR__ . '/../../../data/db.sqlite'
   ],
   "mappings" => [
       [
           "type" => "annotation",
           "namespace" => "Some\\Namespace",
           "path" => "/path/to/mapping/dir",
       ],
   ],
];

$config = new \DRKP\ZF3Doctrine\MetadataConfigurationFactory(
    $config['orm']['orm.em.options']['mappings'],
    $config['orm']['orm.em.options']['mappings'][0]['type']
);

$entityManager = \Doctrine\ORM\EntityManager::create(
    $config['dbal']['db.options'],
    $container->get(MetadataConfigurationFactory::class)->make()
);

$repository = $entityManager->getRepository(\Some\Namespace::class);
````

## Advanced usage

### Multiple Entity Managers and multiple mapping types

````
<?php

use DRKP\ZF3Doctrine\MetadataConfigurationFactory;
use Doctrine\ORM\EntityManager;

$mapping = [
   "dbal" => [
       'driver' => 'pdo_sqlite',
       'path' =>  __DIR__ . '/../../../data/db.sqlite'
   ],
   "dbal1" => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => '{db}',
        'user' => '{user}',
        'password' => '{pass}',
        'charset' => 'utf8'
   ],
   "mappings" => [
       [
           "type" => "annotation",
           "namespace" => "Some\\Namespace",
           "path" => "/path/to/mapping/dir",
       ],
       [
           "type" => "yaml",
           "namespace" => "Some\\Other\\Namespace",
           "path" => "/path/to/other/mapping/dir",
       ],
   ],
];

$config = new MetadataConfigurationFactory(
    $config['mappings'],
    $config['mappings'][0]['type']
);

$defaultEntityManager = EntityManager::create(
    $config['dbal']['db.options'],
    $container->get(MetadataConfigurationFactory::class)->make()
);

$config1 = new MetadataConfigurationFactory(
    $config['orm']['orm.em.options']['mappings'],
    'yaml'
);

$secondaryEntityManager = EntityManager::create(
    $config['dbal1']['db.options'],
    $container->get(MetadataConfigurationFactory::class)->make()
);

$repository = $defaultEntityManager->getRepository(\Some\Namespace::class);
$secondaryRepository = $secondaryEntityManager->getRepository(\Some\Namespace::class);

````
