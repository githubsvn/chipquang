<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyType
 *
 * @ORM\Table(name="mtx_companytype")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\CompanyTypeRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CompanyType {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $updated;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CompanyTypeLanguage", mappedBy="companytype", cascade={"all"})
     */
    protected $companytype_languages;

    /**
     * @var Language
     */
    private $language;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return CompanyType
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return CompanyType
     */
    public function setCreatedAt($createdAt) {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return CompanyType
     */
    public function setUpdatedAt($updatedAt) {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt() {
        return $this->updated_at;
    }

    /**
     * Set user
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $user
     * @return CompanyType
     */
    public function setCreated(\SM\Bundle\AdminBundle\Entity\User $created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SM\Bundle\AdminBundle\Entity\User
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set user
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $user
     * @return CompanyType
     */
    public function setUpdated(\SM\Bundle\AdminBundle\Entity\User $updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SM\Bundle\AdminBundle\Entity\User
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->companytype_languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->language = null;
    }

    /**
     * Add companytype_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\CompanyTypeLanguage $companytypeLanguages
     * @return CompanyType
     */
    public function addCompanytypeLanguage(\SM\Bundle\AdminBundle\Entity\CompanyTypeLanguage $companytypeLanguages) {
        $this->companytype_languages[] = $companytypeLanguages;

        return $this;
    }

    /**
     * Remove companytype_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\CompanyTypeLanguage $companytypeLanguages
     */
    public function removeCompanytypeLanguage(\SM\Bundle\AdminBundle\Entity\CompanyTypeLanguage $companytypeLanguages) {
        $this->companytype_languages->removeElement($companytypeLanguages);
    }

    /**
     * Get companytype_languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanytypeLanguages() {
        return $this->companytype_languages;
    }

    /**
     * Set Language
     *
     * @param \SM\Bundle\AdminBundle\Entity\Language $language
     */
    public function setLanguage(Language $language) {
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

    public function getCurrentLanguage() {
        $companytypeLanguages = $this->companytype_languages->toArray();
        if (is_array($companytypeLanguages)) {
            if (null !== $this->language) {
                foreach ($companytypeLanguages as $ctLanguage) {
                    if ($ctLanguage->getLanguage()->getId() == $this->language->getId()) {
                        return $ctLanguage;
                    }
                }
            }
        }

        return null;
    }

    public function hasLanguage(Language $language) {
        $result = false;
        if (count($this->companytype_languages->toArray()) > 0) {
            foreach ($this->companytype_languages as $plTemp) {
                if ($language->getId() == $plTemp->getLanguage()->getId()) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

     public function __toString()
    {
        $pageLanguages = $this->companytype_languages->toArray();
        if (is_array($pageLanguages)) {
            if (isset($pageLanguages[0])) {
                return $pageLanguages[0]->getName();
            }
        }
        return '';
    }
}