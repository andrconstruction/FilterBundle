<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * AbstractFormTypeExtension
 */
abstract class AbstractFormTypeExtension extends TypeTestCase
{
    /**
     * @var bool
     */
    protected $autoFilter = true;

    /**
     * {@inheritdoc}
     */
    protected function getExtensions()
    {
        return \array_merge(parent::getExtensions(), [
            new FilterExtension(new Filter(new CachedReader(new AnnotationReader(), new ArrayCache())), $this->autoFilter),
        ]);
    }
}
