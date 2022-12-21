<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Form\Extension\FormTypeExtension;
use Bukashk0zzz\FilterBundle\Service\Filter;
use Symfony\Component\Form\AbstractExtension;

/**
 * Filter Extension.
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
     * {@inheritdoc}
     *
     * @param $autoFilter
     */
    public function __construct(Filter $filterService, protected $autoFilter)
    {
        $this->filter = $filterService;
    }

    /**
     * {@inheritdoc}
     */
    protected function loadTypeExtensions(): array
    {
        return [
            new FormTypeExtension($this->filter, $this->autoFilter),
        ];
    }
}
