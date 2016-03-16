<?php

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Form\Extension\FormTypeExtension;
use Bukashk0zzz\FilterBundle\Service\Filter;
use Symfony\Component\Form\Extension\Validator\Type;
use Symfony\Component\Form\AbstractExtension;

/**
 * Filter Extension
 *
 * Enabled filtering in forms
 */
class FilterExtension extends AbstractExtension
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var boolean
     */
    protected $autoFilter;

    /**
     * {@inheritdoc}
     * @param Filter $filterService
     * @param        $autoFilter
     */
    public function __construct(Filter $filterService, $autoFilter)
    {
        $this->filter     = $filterService;
        $this->autoFilter = $autoFilter;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadTypeExtensions()
    {
        return array(
            new FormTypeExtension($this->filter, $this->autoFilter),
        );
    }
}
