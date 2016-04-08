<?php

/*
 * This file is part of the FilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Symfony\Component\Form\Test\TypeTestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;

/** @noinspection LongInheritanceChainInspection
 *
 * AbstractFormTypeExtension
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 */
abstract class AbstractFormTypeExtension extends TypeTestCase
{
    /**
     * @var bool $autoFilter
     */
    protected $autoFilter = true;

    /**
     * {@inheritdoc}
     */
    protected function getExtensions()
    {
        return array_merge(parent::getExtensions(), array(
            new FilterExtension(new Filter(new CachedReader(new AnnotationReader(), new ArrayCache())), $this->autoFilter),
        ));
    }
}
