<?php

/*
 * This file is part of the Bukashk0zzzFilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Bukashk0zzz\FilterBundle\Service\Filter;

/**
 * Class AbstractListener
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 */
class FilterSubscriber implements EventSubscriber
{
    /**
     * @var Filter
     */
    protected $filterService;

    /**
     * FilterListener constructor.
     * @param Filter $filterService
     */
    public function __construct(Filter $filterService)
    {
        $this->filterService = $filterService;
    }

    /**
     * {@inheritdoc}
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
     * @throws \Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->filter($args);
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->filter($args);
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     */
    protected function filter(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->filterService->filterEntity($entity);
    }
}
