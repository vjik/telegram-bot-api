<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = (new Finder())->in([
    __DIR__ . '/src',
    __DIR__ . '/tests',
]);

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRules(['@PER-CS2.0' => true])
    ->setFinder($finder);
