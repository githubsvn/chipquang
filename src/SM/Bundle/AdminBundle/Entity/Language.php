<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Language
 *
 * @ORM\Table(name="mtx_language")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\LanguageRepository")
 * @UniqueEntity(fields="lang_key", message="Language key is already in use")
 */
class Language
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lang_key", type="string", length=4, unique=true)
     */
    private $lang_key;

    /**
     * @var string
     *
     * @ORM\Column(name="is_default", type="boolean", nullable=true)
     */
    private $is_default;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Language
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lang_key
     *
     * @param string $langKey
     * @return Language
     */
    public function setLangKey($langKey)
    {
        $this->lang_key = $langKey;

        return $this;
    }

    /**
     * Get lang_key
     *
     * @return string
     */
    public function getLangKey()
    {
        return $this->lang_key;
    }


    /**
     * Set is_default
     *
     * @param integer $isDefault
     * @return Language
     */
    public function setIsDefault($isDefault)
    {
        $this->is_default = $isDefault;

        return $this;
    }

    /**
     * Get is_default
     *
     * @return integer
     */
    public function getIsDefault()
    {
        return $this->is_default;
    }

    public function __toString()
    {
        return $this->getName();
    }
}