<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Tests\Fixtures\User;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\UserType;

/**
 * Test the FormTypeExtensionWithoutFilterTest.
 *
 * @internal
 */
final class FormTypeExtensionWithoutFilterTest extends AbstractFormTypeExtension
{
    /**
     * Setup.
     */
    protected function setUp(): void
    {
        $this->autoFilter = false;

        parent::setUp();
    }

    /**
     * Test form type extension without filter.
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
