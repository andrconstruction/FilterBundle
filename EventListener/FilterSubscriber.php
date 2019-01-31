<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\EventListener;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class AbstractListener
 */
class FilterSubscriber implements EventSubscriber
{
    /**
     * @var Filter
     */
    protected $filterService;

    /**
     * FilterListener constructor.
     *
     * @param Filter $filterService
     */
    public function __construct(Filter $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->filter($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->filter($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    protected function filter(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        $this->filterService->filterEntity($entity);
    }
}
