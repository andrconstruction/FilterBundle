<?php

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
 * BadUser Entity
 */
class BadUser
{
    /**
     * @Filter("\stdClass")
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $about;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param string $about
     * @return $this
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }
}
