<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Annotation;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation;
use PHPUnit\Framework\TestCase;
use Laminas\Filter\StringTrim;

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
     */
    public function testAnnotationWithoutOptions(): void
    {
        $this->expectException(\LogicException::class);
        new FilterAnnotation([]);
    }

    /**
     * Test annotation with wrong type for `filter` option
     */
    public function testWrongTypeForFilterOption(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new FilterAnnotation(['filter' => 123]);
    }

    /**
     * Test annotation with wrong laminas filter class for `filter` option
     */
    public function testWrongFilterClassForFilterOption(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new FilterAnnotation(['filter' => 'test']);
    }

    /**
     * Test annotation with wrong type for `value` option
     */
    public function testWrongTypeForValueOption(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new FilterAnnotation(['value' => 123]);
    }

    /**
     * Test annotation with wrong type for `options` option
     */
    public function testWrongTypeForOptionsOption(): void
    {
        $this->expectException(\TypeError::class);

        new FilterAnnotation(['filter' => 'StringTrim', 'options' => 123]);
    }
}
