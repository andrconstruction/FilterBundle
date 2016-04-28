<?php

/*
 * This file is part of the Bukashk0zzzFilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Annotation;

use Doctrine\ORM\Mapping\Annotation;

/**
 * FilterAnnotation
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 */
final class FilterAnnotation implements Annotation
{
    /**
     * @var string $filter ZendFilter name
     */
    private $filter;

    /**
     * @var array $options Options
     */
    private $options;


    /**
     * Constructor
     *
     * @param array $parameters Filter parameters
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function __construct(array $parameters)
    {
        if (!array_key_exists('value', $parameters) && !array_key_exists('filter', $parameters)) {
            throw new \LogicException(sprintf('Either "value" or "filter" option must be set.'));
        }

        if (array_key_exists('value', $parameters)) {
            $this->setFilter($parameters['value']);
        } elseif (array_key_exists('filter', $parameters)) {
            $this->setFilter($parameters['filter']);
        }

        if (array_key_exists('options', $parameters)) {
            $this->setOptions($parameters['options']);
        }
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setFilter($filter)
    {
        if (!is_string($filter)) {
            throw new \InvalidArgumentException('Filter must be string');
        }

        if ($filter && strpos($filter, '\\') === false) {
            $filter = 'Zend\Filter\\'.$filter;
        }

        if (!class_exists($filter)) {
            throw new \InvalidArgumentException("Could not find or autoload: $filter");
        }

        $this->filter = $filter;

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setOptions($options)
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException('Options must be array');
        }
        $this->options = $options;

        return $this;
    }
}
