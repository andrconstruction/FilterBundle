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
 * Test the FormTypeExtension
 *
 * @author Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 */
class FormTypeExtensionTest extends TypeTestCase
{
    /**
     * @var bool $autoFilter
     */
    protected $autoFilter;

    /**
     * Test form type extension
     */
    public function testType()
    {
        $user = new User();
        $form = $this->factory->create(UserType::class, $user);
        $form->submit([
            'name' => 'Test name <p>test</p> bla <br> bla',
            'about' => 'Test <p>about</p>',
        ]);
        static::assertSame('Test name test bla <br> bla', $user->getName());
        static::assertSame('Test about', $form->getData()->getAbout());
    }

    protected function getExtensions()
    {
        return array_merge(parent::getExtensions(), array(
            new FilterExtension(new Filter(new CachedReader(new AnnotationReader(), new ArrayCache())), true),
        ));
    }
}
