<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Annotation;

use Attribute;
use Doctrine\ORM\Mapping\Annotation;
use Doctrine\ORM\Mapping\MappingAttribute;

/**
 * FilterAnnotation.
 *
 * @Annotation()
 * @Target({"PROPERTY", "METHOD"})
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
final class FilterAnnotation implements MappingAttribute
{
    /**
     * @var string LaminasFilter name
     */
    private $filter;

    /**
     * @var array<mixed> Options
     */
    private $options;

    /**
     * Constructor.
     *
     * @param array<mixed> $parameters Filter parameters
     */
    public function __construct(array $parameters)
    {
        if (!\array_key_exists('value', $parameters) && !\array_key_exists('filter', $parameters)) {
            throw new \LogicException('Either "value" or "filter" option must be set.');
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

    public function getFilter(): string
    {
        return $this->filter;
    }

    public function setFilter(mixed $filter): self
    {
        if (!\is_string($filter)) {
            throw new \InvalidArgumentException('Filter must be string');
        }

        if ($filter && \mb_strpos($filter, '\\') === false) {
            $filter = 'Laminas\Filter\\'.$filter;
        }

        if (!\class_exists($filter)) {
            throw new \InvalidArgumentException("Could not find or autoload: {$filter}");
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
     */
    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }
}
