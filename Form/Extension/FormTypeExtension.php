<?php

/*
 * This file is part of the Bukashk0zzzFilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Form\Extension;

use Bukashk0zzz\FilterBundle\Form\EventListener\FilterListener;
use Bukashk0zzz\FilterBundle\Service\Filter;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FormTypeExtension
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 */
class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * @var Filter
     */
    protected $filterService;

    /**
     * @var boolean
     */
    protected $autoFilter;

    /**
     * FilterListener constructor.
     * @param Filter  $filterService
     * @param boolean $autoFilter
     */
    public function __construct(Filter $filterService, $autoFilter)
    {
        $this->filterService = $filterService;
        $this->autoFilter = $autoFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return FormType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$this->autoFilter) {
            return;
        }

        $builder->addEventSubscriber(new FilterListener($this->filterService));
    }
}
