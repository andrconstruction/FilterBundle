<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Service;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Laminas\Filter\FilterChain;
use ReflectionProperty;

/**
 * Class Filter
 */
class Filter
{
    /**
     * @var Reader Cached annotation reader
     */
    protected $annotationReader;

    /**
     * Filter constructor.
     *
     * @param Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
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
            $attributes = $this->getAttributes($property);

            if (empty($attributes)) {
                continue;
            }

            $property->setAccessible(true);
            $value = $property->getValue($object);

            if (empty($value)) {
                continue;
            }

            $filter = new FilterChain();
            foreach($attributes as $attribute) {
                $filter->attachByName($attribute->getFilter(), $attribute->getOptions());
            }

            $property->setValue($object, $filter->filter($value));
        }
    }

    /**
     * Get Annotations of PHP Attributes.
     *
     * @return array<FilterAnnotation>
     */
    private function getAttributes(ReflectionProperty $property): array
    {
        $annotations = $this->annotationReader->getPropertyAnnotations($property);

        $attributes = [];
        foreach($annotations as $annotation) {
            if ($annotation instanceof FilterAnnotation) {
                $attributes[] = $annotation;
            }
        }

        // If we get an empty array with the annotations, we try PHP Attributes
        if (\PHP_VERSION_ID > 80000 && empty($attributes)) {
            $attrs = $property->getAttributes(FilterAnnotation::class);

            $attributes = [];
            foreach($attrs as $attr) {
                $attributes[] = $attr->newInstance();
            }
        }

        return $attributes;
    }
}
