<?php declare(strict_types = 1);
/*
 * This file is part of the FilterBundle
 *
 * (c) Denis Golubovskiy <bukashk0zzz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bukashk0zzz\FilterBundle\Tests\Fixtures;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation as Filter;

/**
 * User Entity
 */
class User
{
    /**
     * @Filter("StripTags", options={"allowTags": "br"})
     * @Filter("StringTrim")
     * @Filter("StripNewlines")
     *
     * @var string
     */
    protected $name;

    /**
     * @Filter("StripTags")
     * @Filter("StringTrim")
     *
     * @var string
     */
    protected $about;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @param string $about
     *
     * @return $this
     */
    public function setAbout(string $about)
    {
        $this->about = $about;

        return $this;
    }
}
