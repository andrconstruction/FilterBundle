<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Form;

use Bukashk0zzz\FilterBundle\Tests\Fixtures\BadUser;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\UserType;

/**
 * Test the FormTypeExtensionBadTest
 */
class FormTypeExtensionBadTest extends AbstractFormTypeExtension
{
    /**
     * Test annotation with wrong zend filter class for `filter` option
     *
     * @expectedException \InvalidArgumentException
     */
    public function testWrongFilterClassForFilterOption(): void
    {
        $user = new BadUser();
        $form = $this->factory->create(UserType::class, $user, ['data_class' => BadUser::class]);
        $form->submit([
            'name' => 'Test',
            'about' => 'Test',
        ]);
    }
}
