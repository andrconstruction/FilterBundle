<?php declare(strict_types = 1);
/*
 * This file is part of the Bukashk0zzzFilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Service;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Util\ClassUtils;
use Zend\Filter\AbstractFilter;
use Zend\Filter\FilterInterface;

/**
 * Class Filter
 */
class Filter
{
    /**
     * @var CachedReader Cached annotation reader
     */
    protected $annotationReader;

    /**
     * Filter constructor.
     *
     * @param CachedReader $annotationReader
     */
    public function __construct(CachedReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param mixed $object
     */
    public function filterEntity($object): void
    {
        if ($object === null) {
            return;
        }

        $reflectionClass = ClassUtils::newReflectionClass(\get_class($object));
        foreach ($reflectionClass->getProperties() as $property) {
            foreach ($this->annotationReader->getPropertyAnnotations($property) as $annotation) {
                if ($annotation instanceof FilterAnnotation) {
                    $property->setAccessible(true);
                    $value = $property->getValue($object);

                    if ($value) {
                        $filter = $annotation->getFilter();
                        $options = $annotation->getOptions();
                        $property->setValue($object, $this->getZendInstance($filter, $options)->filter($value));
                    }
                }
            }
        }
    }

    /**
     * @param string       $class
     * @param mixed[]|null $options
     *
     * @return \Zend\Filter\FilterInterface
     */
    protected function getZendInstance(string $class, ?array $options): FilterInterface
    {
        /** @var AbstractFilter $filter */
        $filter = new $class();

        $abstractFilterClass = AbstractFilter::class;
        if (!$filter instanceof $abstractFilterClass) {
            throw new \InvalidArgumentException("Filter class must extend $abstractFilterClass: $class");
        }

        try {
            if ($options !== null && \count($options) !== 0) {
                $filter->setOptions($options);
            }

            return $filter;
        } catch (\Throwable $e) {
            return new $class($options);
        }
    }
}
