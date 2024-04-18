<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Service;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation;
use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Laminas\Filter\FilterChain;
use ReflectionProperty;

/**
 * Class Filter.
 */
class Filter
{

    public function filterEntity(mixed $object): void
    {
        if ($object === null) {
            return;
        }

        $reflectionClass = ClassUtils::newReflectionClass($object::class);

        foreach ($reflectionClass->getProperties() as $property) {
            $attributes = $this->getAttributes($property);

            if (empty($attributes)) {
                continue;
            }

            $property->setAccessible(true);
            $value = $property->getValue($object);

            $filter = new FilterChain();
            foreach ($attributes as $attribute) {
                $filter->attachByName($attribute->getFilter(), $attribute->getOptions());
            }

            $property->setValue($object, $filter->filter($value));
        }
    }

    /**
     * Get PHP Attributes.
     *
     * @return array<FilterAttributes>
     */
    private function getAttributes(ReflectionProperty $property): array
    {
        $propertyAttributes = $property->getAttributes();

        $attributes = [];
        foreach ($propertyAttributes as $propertyAttrubute) {
            if ($propertyAttrubute instanceof FilterAnnotation) {
                $attributes[] = $propertyAttrubute;
            }
        }

        // If we get an empty array with the annotations, we try PHP Attributes
        if (empty($attributes)) {
            $attrs = $property->getAttributes(FilterAnnotation::class);

            $attributes = [];
            foreach ($attrs as $attr) {
                $attributes[] = $attr->newInstance();
            }
        }

        return $attributes;
    }
}
