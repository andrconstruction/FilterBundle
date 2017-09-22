<?php declare(strict_types = 1);
/*
 * This file is part of the FilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests\Service;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use PHPUnit\Framework\TestCase;

/**
 * Test the FilterTest
 */
class FilterTest extends TestCase
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->filter = new Filter(new CachedReader(new AnnotationReader(), new ArrayCache()));
    }

    /**
     * Service init test
     */
    public function testWrapper(): void
    {
        //check if instance
        static::assertInstanceOf(Filter::class, $this->filter);
    }

    /**
     * Test Filter With Object that null
     */
    public function testFilterWithNullObject(): void
    {
        $this->filter->filterEntity(null);
        self::assertTrue(true);
    }
}
