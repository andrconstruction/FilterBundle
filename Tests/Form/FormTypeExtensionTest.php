<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Tests\Fixtures\User;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\UserType;

/**
 * Test the FormTypeExtension.
 *
 * @internal
 */
final class FormTypeExtensionTest extends AbstractFormTypeExtension
{
    /**
     * Test form type extension.
     */
    public function testType(): void
    {
        $user = new User();
        $form = $this->factory->create(UserType::class, $user);
        $form->submit([
            'name' => '     Test name <p>test</p> bla <br> bla',
            'about' => 'Test <p>about</p>     ',
        ]);
        static::assertSame('Test name test bla <br> bla', $user->getName());
        static::assertSame('Test about', $form->getData()->getAbout());
    }
}
