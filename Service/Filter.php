<?php

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

/**
 * Class Filter
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 */
class Filter
{
    /**
     * @var CachedReader $annotationReader Cached annotation reader
     */
    protected $annotationReader;

    /**
     * Filter constructor.
     * @param CachedReader $annotationReader
     */
    public function __construct(CachedReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param mixed $object
     * @throws \Zend\Filter\Exception\RuntimeException If filtering $value is impossible
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     */
    public function filterEntity($object)
    {
        if ($object === null) {
            return;
        }

        $reflectionClass = ClassUtils::newReflectionClass(get_class($object));
        foreach ($reflectionClass->getProperties() as $property) {
            $filterAnnotation = $this->annotationReader->getPropertyAnnotation($property, FilterAnnotation::class);

            if ($filterAnnotation instanceof FilterAnnotation) {
                $property->setAccessible(true);

                if ($value = $property->getValue($object)) {
                    $filter = $filterAnnotation->getFilter();
                    $options = $filterAnnotation->getOptions();
                    $property->setValue($object, $this->getZendInstance($filter, $options)->filter($value));
                }
            }
        }
    }

    /**
     * @param string $class
     * @param array $options
     * @return \Zend\Filter\FilterInterface
     * @throws \Zend\Filter\Exception\InvalidArgumentException
     */
    protected function getZendInstance($class, $options)
    {
        try {
            new \ReflectionMethod($class, 'setOptions');

            /** @var \Zend\Filter\AbstractFilter $filter */
            $filter = new $class();
            if (count($options) !== 0) {
                $filter->setOptions($options);
            }

            return $filter;
        } catch (\Exception $e) {
            return new $class($options);
        }
    }
}
