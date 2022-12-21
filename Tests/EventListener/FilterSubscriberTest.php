<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\EventListener;

use Bukashk0zzz\FilterBundle\EventListener\FilterSubscriber;
use Bukashk0zzz\FilterBundle\Service\Filter;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\User;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\Event\LifecycleEventArgs;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * FilterSubscriberTest.
 *
 * @internal
 */
final class FilterSubscriberTest extends TestCase
{
    /**
     * Test persist event.
     */
    public function testPersist(): void
    {
        $user = new User();
        $cache = DoctrineProvider::wrap(
            new ArrayAdapter()
        );
        $filter = new Filter(new CachedReader(new AnnotationReader(), $cache));

        $lifeCycleEvent = $this->mockEvent('LifecycleEventArgs');
        $lifeCycleEvent->expects(static::once())->method('getEntity')->willReturn($user);

        /** @var LifecycleEventArgs $lifeCycleEvent */
        $subscriber = new FilterSubscriber($filter);
        $subscriber->prePersist($lifeCycleEvent);
    }

    /**
     * Test update event.
     */
    public function testUpdate(): void
    {
        $user = new User();
        $cache = DoctrineProvider::wrap(
            new ArrayAdapter()
        );
        $filter = new Filter(new CachedReader(new AnnotationReader(), $cache));

        $lifeCycleEvent = $this->mockEvent('LifecycleEventArgs');
        $lifeCycleEvent->expects(static::once())->method('getEntity')->willReturn($user);

        /** @var LifecycleEventArgs $lifeCycleEvent */
        $subscriber = new FilterSubscriber($filter);
        $subscriber->preUpdate($lifeCycleEvent);
    }

    /**
     * Test get subscribed events.
     */
    public function testSubscription(): void
    {
        $cache = DoctrineProvider::wrap(
            new ArrayAdapter()
        );
        $filter = new Filter(new CachedReader(new AnnotationReader(), $cache));
        $subscriber = new FilterSubscriber($filter);
        static::assertSame([
            'prePersist',
            'preUpdate',
        ], $subscriber->getSubscribedEvents());
    }

    /**
     * Mock a lifeCycleEventArgs Object.
     */
    private function mockEvent(string $eventType): MockObject
    {
        return $this->createPartialMock(
            '\Doctrine\ORM\Event\\'.$eventType,
            ['getEntityManager', 'getEntity'],
        );
    }
}
