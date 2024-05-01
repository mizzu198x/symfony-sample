<?php

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'compact_nullable_typehint' => true,
        'declare_strict_types' => true,
        'explicit_indirect_variable' => true,
        'linebreak_after_opening_tag' => true,
        'no_extra_blank_lines' => true,
        'no_useless_return' => true,
        'phpdoc_to_comment' => false,
        'psr_autoloading' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_first'
        ],
    ])
    ->setFinder(PhpCsFixer\Finder::create()
        ->in('src')
    )
    ;

/*
This document has been generated with
https://mlocati.github.io/php-cs-fixer-configurator/?version=2.13#configurator
you can change this configuration by importing this YAML code:

version: 2.13.0
expandSets: false
fixerSets:
  - '@Symfony'
fixers:
  compact_nullable_typehint: true
  declare_strict_types: true
  explicit_indirect_variable: true
  linebreak_after_opening_tag: true
  no_extra_blank_lines: true
  no_useless_return: true
  ordered_imports: true
  psr_autoloading: true
  risky: true
  phpdoc_types_order:
    null_adjustment: always_first

*/
