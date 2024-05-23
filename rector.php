<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\DowngradeLevelSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets(
        [DowngradeLevelSetList::DOWN_TO_PHP_74]
    )
    ->withPhpSets(
        false,  // 8.3
        false,  // 8.2
        false,  // 8.1
        false,  // 8.0
        true    // 7.4
    )
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);