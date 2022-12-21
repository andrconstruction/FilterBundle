<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * AbstractFormTypeExtension.
 */
abstract class AbstractFormTypeExtension extends TypeTestCase
{
    /**
     * @var bool
     */
    protected $autoFilter = true;

    /**
     * @return array<mixed>
     */
    protected function getExtensions(): array
    {
        $cache = DoctrineProvider::wrap(
            new ArrayAdapter()
        );

        return \array_merge(parent::getExtensions(), [
            new FilterExtension(new Filter(new CachedReader(new AnnotationReader(), $cache)), $this->autoFilter),
        ]);
    }
}
