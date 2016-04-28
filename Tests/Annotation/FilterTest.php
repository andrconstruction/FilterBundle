<?php

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

/**
 * FilterAnnotationTest
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 */
class FilterAnnotationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test annotation with `value` option
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testValueOption()
    {
        $annotation = new FilterAnnotation(['value' => 'StringTrim']);

        static::assertEquals('Zend\Filter\StringTrim', $annotation->getFilter());
        static::assertEmpty($annotation->getOptions());
    }

    /**
     * Test annotation with all options
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function testAllOptions()
    {
        $annotation = new FilterAnnotation([
            'filter' => 'StringTrim',
            'options' => ['charlist' => 'test'],
        ]);

        static::assertEquals('Zend\Filter\StringTrim', $annotation->getFilter());
        static::assertEquals(['charlist' => 'test'], $annotation->getOptions());
    }

    /**
     * Test annotation without any option
     *
     * @expectedException \LogicException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function testAnnotationWithoutOptions()
    {
        new FilterAnnotation([]);
    }

    /**
     * Test annotation with wrong type for `filter` option
     *
     * @expectedException \InvalidArgumentException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function testWrongTypeForFilterOption()
    {
        new FilterAnnotation(['filter' => 123]);
    }

    /**
     * Test annotation with wrong zend filter class for `filter` option
     *
     * @expectedException \InvalidArgumentException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function testWrongFilterClassForFilterOption()
    {
        new FilterAnnotation(['filter' => 'test']);
    }

    /**
     * Test annotation with wrong type for `value` option
     *
     * @expectedException \InvalidArgumentException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function testWrongTypeForValueOption()
    {
        new FilterAnnotation(['value' => 123]);
    }

    /**
     * Test annotation with wrong type for `options` option
     *
     * @expectedException \InvalidArgumentException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function testWrongTypeForOptionsOption()
    {
        new FilterAnnotation(['filter' => 'StringTrim', 'options' => 123]);
    }
}
