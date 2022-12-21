<?php declare(strict_types = 1);

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__])
    ->exclude('vendor')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@DoctrineAnnotation' => true,
        '@PHP70Migration' => true,
        '@PHP70Migration:risky' => true,
        '@PHP71Migration' => true,
        '@PHP71Migration:risky' => true,
        '@PHP73Migration' => true,
        '@PHPUnit75Migration:risky' => true,
        'yoda_style' => false,
        'blank_line_after_opening_tag' => false,
        'phpdoc_no_empty_return' => false,
        'mb_str_functions' => true,
        'simplified_null_return' => true,
        'static_lambda' => true,
        'ordered_interfaces' => true,
        'phpdoc_to_param_type' => true,
        'php_unit_test_class_requires_covers' => false,
        'native_function_invocation' => false,
        'linebreak_after_opening_tag' => false,
        'phpdoc_to_return_type' => true,
        'declare_equal_normalize' => ['space' => 'single'],
        'array_syntax' => ['syntax' => 'short'],
        'list_syntax' => ['syntax' => 'short'],
        'doctrine_annotation_braces' => ['syntax' => 'with_braces'],
        'general_phpdoc_annotation_remove' => ['annotations' => ['author', 'created', 'version', 'package', 'copyright', 'license', 'throws']],
    ])
    ->setFinder($finder)
    ;
