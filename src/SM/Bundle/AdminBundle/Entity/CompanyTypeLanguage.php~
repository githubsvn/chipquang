<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CompanyTypeLanguage
 *
 * @ORM\Table(name="mtx_companytype_language")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\CompanyTypeLanguageRepository")
 * @UniqueEntity(fields="name", message="Sorry! This username exits. Please try another.")
 * @ORM\HasLifecycleCallbacks
 */
class CompanyTypeLanguage
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
     * @ORM\ManyToOne(targetEntity="CompanyType", cascade={"persist"})
     */
    private $companytype;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;


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
     * Set companytype
     *
     * @param \SM\Bundle\AdminBundle\Entity\CompanyType $companytype
     * @return CompanyTypeLanguage
     */
    public function setCompanytype(\SM\Bundle\AdminBundle\Entity\CompanyType $companytype)
    {
        $this->companytype = $companytype;

        return $this;
    }

    /**
     * Get companytype
     *
     * @return \SM\Bundle\AdminBundle\Entity\CompanyType
     */
    public function getCompanytype()
    {
        return $this->companytype;
    }

    /**
     * Set language
     *
     * @param \SM\Bundle\AdminBundle\Entity\Language $language
     * @return ArticleLanguage
     */
    public function setLanguage(\SM\Bundle\AdminBundle\Entity\Language $language = null) {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \SM\Bundle\AdminBundle\Entity\Language
     */
    public function getLanguage() {
        return $this->language;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return CompanyTypeLanguage
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
}