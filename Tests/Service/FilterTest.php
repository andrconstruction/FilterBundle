<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Service;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use PHPUnit\Framework\TestCase;

/**
 * Test the FilterTest.
 *
 * @internal
 */
final class FilterTest extends TestCase
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        $this->filter = new Filter(new CachedReader(new AnnotationReader(), new ArrayCache()));
    }

    /**
     * Service init test.
     */
    public function testWrapper(): void
    {
        // check if instance
        static::assertInstanceOf(Filter::class, $this->filter);
    }

    /**
     * Test Filter With Object that null.
     */
    public function testFilterWithNullObject(): void
    {
        $this->filter->filterEntity(null);
        static::assertTrue(true);
    }
}
