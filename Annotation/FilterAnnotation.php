<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * FilterAnnotation
 *
 * @Annotation()
 * @Target({"PROPERTY", "METHOD"})
 */
final class FilterAnnotation implements Annotation
{
    /**
     * @var string ZendFilter name
     */
    private $filter;

    /**
     * @var array<mixed> Options
     */
    private $options;

    /**
     * Constructor
     *
     * @param array<mixed> $parameters Filter parameters
     */
    public function __construct(array $parameters)
    {
        if (!\array_key_exists('value', $parameters) && !\array_key_exists('filter', $parameters)) {
            throw new \LogicException(\sprintf('Either "value" or "filter" option must be set.'));
        }

        if (\array_key_exists('value', $parameters)) {
            $this->setFilter($parameters['value']);
        } elseif (\array_key_exists('filter', $parameters)) {
            $this->setFilter($parameters['filter']);
        }

        if (!\array_key_exists('options', $parameters)) {
            return;
        }

        $this->setOptions($parameters['options']);
    }

    /**
     * @return string
     */
    public function getFilter(): string
    {
        return $this->filter;
    }

    /**
     * @param mixed $filter
     *
     * @return FilterAnnotation
     */
    public function setFilter($filter): FilterAnnotation
    {
        if (!\is_string($filter)) {
            throw new \InvalidArgumentException('Filter must be string');
        }

        if ($filter && \mb_strpos($filter, '\\') === false) {
            $filter = 'Zend\Filter\\'.$filter;
        }

        if (!\class_exists($filter)) {
            throw new \InvalidArgumentException("Could not find or autoload: $filter");
        }

        $this->filter = $filter;

        return $this;
    }

    /**
     * @return array<mixed>|null
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param array<mixed>|null $options
     *
     * @return FilterAnnotation
     */
    public function setOptions(?array $options): FilterAnnotation
    {
        $this->options = $options;

        return $this;
    }
}
