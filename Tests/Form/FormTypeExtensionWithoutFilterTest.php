<?php

/*
 * This file is part of the FilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests;

use Bukashk0zzz\FilterBundle\Service\Filter;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\User;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\UserType;
use Bukashk0zzz\FilterBundle\Tests\Form\FilterExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ArrayCache;

/** @noinspection LongInheritanceChainInspection
 *
 * Test the FormTypeExtensionWithoutFilterTest
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 */
class FormTypeExtensionWithoutFilterTest extends TypeTestCase
{
    /**
     * @var bool $autoFilter
     */
    protected $autoFilter;

    /**
     * Test form type extension without filter
     */
    public function testTypeWithoutFilter()
    {
        $user = new User();
        $this->autoFilter = false;
        $form = $this->factory->create(UserType::class, $user);
        $form->submit([
            'name' => 'Test name <p>test</p>',
            'about' => 'Test <p>about</p>',
        ]);
        static::assertSame('Test name <p>test</p>', $user->getName());
        static::assertSame('Test <p>about</p>', $form->getData()->getAbout());
    }

    protected function getExtensions()
    {
        return array_merge(parent::getExtensions(), array(
            new FilterExtension(new Filter(new CachedReader(new AnnotationReader(), new ArrayCache())), false),
        ));
    }
}
