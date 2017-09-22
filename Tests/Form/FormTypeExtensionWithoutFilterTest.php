<?php declare(strict_types = 1);
/*
 * This file is part of the FilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Tests\Fixtures\User;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\UserType;

/**
 * Test the FormTypeExtensionWithoutFilterTest
 */
class FormTypeExtensionWithoutFilterTest extends AbstractFormTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->autoFilter = false;
        parent::setUp();
    }

    /**
     * Test form type extension without filter
     */
    public function testTypeWithoutFilter(): void
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
}
