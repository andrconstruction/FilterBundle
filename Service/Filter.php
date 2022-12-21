<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Service;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Laminas\Filter\AbstractFilter;
use Laminas\Filter\FilterInterface;

/**
 * Class Filter.
 */
class Filter
{
    /**
     * @var Reader Cached annotation reader
     */
    protected $annotationReader;

    /**
     * Filter constructor.
     */
    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    public function filterEntity(mixed $object): void
    {
        if ($object === null) {
            return;
        }

        $reflectionClass = ClassUtils::newReflectionClass($object::class);

        foreach ($reflectionClass->getProperties() as $property) {
            foreach ($this->annotationReader->getPropertyAnnotations($property) as $annotation) {
                if (!($annotation instanceof FilterAnnotation)) {
                    continue;
                }

                $property->setAccessible(true);
                $value = $property->getValue($object);

                if (!$value) {
                    continue;
                }

                $filter = $annotation->getFilter();
                $options = $annotation->getOptions();
                $property->setValue($object, $this->getLaminasInstance($filter, $options)->filter($value));
            }
        }
    }

    /**
     * @param array<mixed>|null $options
     */
    protected function getLaminasInstance(string $class, ?array $options): FilterInterface
    {
        /** @var AbstractFilter $filter */
        $filter = new $class();

        $abstractFilterClass = AbstractFilter::class;

        if (!$filter instanceof $abstractFilterClass) {
            throw new \InvalidArgumentException("Filter class must extend {$abstractFilterClass}: {$class}");
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
