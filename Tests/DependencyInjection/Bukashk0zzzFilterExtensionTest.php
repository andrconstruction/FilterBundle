<?php

/*
 * This file is part of the Bukashk0zzzFilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests\DependencyInjection;

use Bukashk0zzz\FilterBundle\DependencyInjection\Bukashk0zzzFilterExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Bukashk0zzzFilterExtensionTest
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 */
class Bukashk0zzzFilterExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Bukashk0zzzFilterExtension $extension Bukashk0zzzFilterExtension
     */
    private $extension;

    /**
     * @var ContainerBuilder $container Container builder
     */
    private $container;

    /**
     * {@inheritdoc}
     * @throws \BadMethodCallException When this ContainerBuilder is frozen
     */
    protected function setUp()
    {
        $this->extension = new Bukashk0zzzFilterExtension();
        $this->container = new ContainerBuilder();

        $this->container->set('annotations.cached_reader', new \stdClass());

        $this->container->registerExtension($this->extension);
    }

    /**
     * Test load extension
     * @throws \Symfony\Component\DependencyInjection\Exception\BadMethodCallException When this ContainerBuilder is frozen
     * @throws \LogicException
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testLoadExtension()
    {
        $this->container->prependExtensionConfig($this->extension->getAlias(), ['auto_filter_forms' => true]);
        $this->container->loadFromExtension($this->extension->getAlias());
        $this->container->compile();

        // Check that services have been loaded
        static::assertTrue($this->container->has('bukashk0zzz_filter.filter'));
    }
}
