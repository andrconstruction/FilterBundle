<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\EventListener;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class AbstractListener.
 */
class FilterSubscriber implements EventSubscriber
{
    /**
     * @var Filter
     */
    protected $filterService;

    /**
     * FilterListener constructor.
     */
    public function __construct(Filter $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents(): array
    {
        return [
            'prePersist',
            'preUpdate',
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->filter($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->filter($args);
    }

    protected function filter(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        $this->filterService->filterEntity($entity);
    }
}
