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

use Bukashk0zzz\FilterBundle\Tests\Fixtures\BadUser;
use Bukashk0zzz\FilterBundle\Tests\Fixtures\UserType;

/** @noinspection LongInheritanceChainInspection
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
        $form = $this->factory->create(UserType::class, $user, ['data_class' => 'Bukashk0zzz\FilterBundle\Tests\Fixtures\BadUser']);
        $form->submit([
            'name' => 'Test',
            'about' => 'Test',
        ]);
    }
}
