<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Form\Extension;

use Bukashk0zzz\FilterBundle\Form\EventListener\FilterListener;
use Bukashk0zzz\FilterBundle\Service\Filter;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class FormTypeExtension
 */
class FormTypeExtension extends AbstractTypeExtension
{
    /**
     * @var Filter
     */
    protected $filterService;

    /**
     * @var bool
     */
    protected $autoFilter;

    /**
     * FilterListener constructor.
     *
     * @param Filter $filterService
     * @param bool   $autoFilter
     */
    public function __construct(Filter $filterService, bool $autoFilter)
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
