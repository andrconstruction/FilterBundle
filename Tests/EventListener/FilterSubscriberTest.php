<?php

/*
 * This file is part of the FilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests\EventListener;

use Bukashk0zzz\FilterBundle\EventListener\FilterSubscriber;
use Bukashk0zzz\FilterBundle\Service\Filter;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\User;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/** @noinspection LongInheritanceChainInspection
 *
 * FilterSubscriberTest
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 */
class FilterSubscriberTest extends WebTestCase
{
    /**
     * Test persist event
     * @throws \Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     * @throws \PHPUnit_Framework_Exception
     * @throws \InvalidArgumentException
     */
    public function testPersist()
    {
        $user = new User();
        $filter = new Filter(new CachedReader(new AnnotationReader(), new ArrayCache()));

        $lifeCycleEvent = $this->mockEvent('LifecycleEventArgs');
        $lifeCycleEvent->expects(static::once())->method('getEntity')->willReturn($user);

        /** @var \Doctrine\ORM\Event\LifecycleEventArgs $lifeCycleEvent */
        $subscriber = new FilterSubscriber($filter);
        $subscriber->prePersist($lifeCycleEvent);
    }

    /**
     * Test update event
     * @throws \Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     * @throws \PHPUnit_Framework_Exception
     * @throws \InvalidArgumentException
     */
    public function testUpdate()
    {
        $user = new User();
        $filter = new Filter(new CachedReader(new AnnotationReader(), new ArrayCache()));

        $lifeCycleEvent = $this->mockEvent('LifecycleEventArgs');
        $lifeCycleEvent->expects(static::once())->method('getEntity')->willReturn($user);

        /** @var \Doctrine\ORM\Event\LifecycleEventArgs $lifeCycleEvent */
        $subscriber = new FilterSubscriber($filter);
        $subscriber->preUpdate($lifeCycleEvent);
    }

    /**
     * Test get subscribed events
     */
    public function testSubscription()
    {
        $filter = new Filter(new CachedReader(new AnnotationReader(), new ArrayCache()));
        $subscriber = new FilterSubscriber($filter);
        static::assertSame([
            'prePersist',
            'preUpdate',
        ], $subscriber->getSubscribedEvents());
    }

    /**
     * mock a lifeCycleEventArgs Object
     *
     * @param $eventType
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     * @throws \PHPUnit_Framework_Exception
     */
    private function mockEvent($eventType)
    {
        $lifeCycleEvent = $this->getMock(
            '\Doctrine\ORM\Event\\'.$eventType,
            ['getEntityManager', 'getEntity', 'getEntityChangeSet'],
            [],
            '',
            false
        );

        return $lifeCycleEvent;
    }
}
