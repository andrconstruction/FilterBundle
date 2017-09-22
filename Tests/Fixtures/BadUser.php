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
 * BadUser Entity
 */
class BadUser
{
    /**
     * @Filter("\stdClass")
     *
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $about;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return BadUser
     */
    public function setName(string $name): BadUser
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAbout(): ?string
    {
        return $this->about;
    }

    /**
     * @param string $about
     *
     * @return BadUser
     */
    public function setAbout(string $about): BadUser
    {
        $this->about = $about;

        return $this;
    }
}
