<?php declare(strict_types = 1);
/*
 * This file is part of the FilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests\Annotation;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation;
use PHPUnit\Framework\TestCase;
use Zend\Filter\StringTrim;

/**
 * FilterAnnotationTest
 */
class FilterTest extends TestCase
{
    /**
     * Test annotation with `value` option
     */
    public function testValueOption(): void
    {
        $annotation = new FilterAnnotation(['value' => 'StringTrim']);

        static::assertEquals(StringTrim::class, $annotation->getFilter());
        static::assertEmpty($annotation->getOptions());
    }

    /**
     * Test annotation with all options
     */
    public function testAllOptions(): void
    {
        $annotation = new FilterAnnotation([
            'filter' => 'StringTrim',
            'options' => ['charlist' => 'test'],
        ]);

        static::assertEquals(StringTrim::class, $annotation->getFilter());
        static::assertEquals(['charlist' => 'test'], $annotation->getOptions());
    }

    /**
     * Test annotation without any option
     *
     * @expectedException \LogicException
     */
    public function testAnnotationWithoutOptions(): void
    {
        new FilterAnnotation([]);
    }

    /**
     * Test annotation with wrong type for `filter` option
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWrongTypeForFilterOption(): void
    {
        new FilterAnnotation(['filter' => 123]);
    }

    /**
     * Test annotation with wrong zend filter class for `filter` option
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWrongFilterClassForFilterOption(): void
    {
        new FilterAnnotation(['filter' => 'test']);
    }

    /**
     * Test annotation with wrong type for `value` option
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWrongTypeForValueOption(): void
    {
        new FilterAnnotation(['value' => 123]);
    }

    /**
     * Test annotation with wrong type for `options` option
     *
     * @expectedException \TypeError
     */
    public function testWrongTypeForOptionsOption(): void
    {
        new FilterAnnotation(['filter' => 'StringTrim', 'options' => 123]);
    }
}
