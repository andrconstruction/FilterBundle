<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Fixtures;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation as Filter;

/**
 * BadUser Entity.
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(string $about): self
    {
        $this->about = $about;

        return $this;
    }
}
