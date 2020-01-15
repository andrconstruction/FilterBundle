<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\Tests\Fixtures;

use Bukashk0zzz\FilterBundle\Annotation\FilterAnnotation as Filter;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User Entity
 */
class User
{
    /**
     * @Assert\Length(
     *     min=0,
     *     max=1
     * )
     *
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return User
     */
    public function setName(string $name): User
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
     * @return User
     */
    public function setAbout(string $about): User
    {
        $this->about = $about;

        return $this;
    }
}
