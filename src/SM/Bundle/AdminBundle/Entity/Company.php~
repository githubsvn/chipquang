<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Company
 *
 * @ORM\Table(name="mtx_company")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\CompanyRepository")
 * @UniqueEntity(fields="email", message="Sorry! This email exits. Please try another.")
 * @ORM\HasLifecycleCallbacks
 */
class Company
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
     * @ORM\ManyToOne(targetEntity="CompanyType")
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="charter_capital", type="float", nullable=true)
     */
    private $charter_capital;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=255, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="mst", type="string", length=255, nullable=true)
     */
    private $mst;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
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
     * @ORM\OneToMany(targetEntity="CompanyLanguage", mappedBy="company", cascade={"all"})
     */
    protected $company_languages;

    /**
     * @var Language
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", nullable=true)
     */
    public $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", nullable=true)
     */
    private $website;

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updated_at = new \DateTime();
    }

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
     * Set type
     *
     * @param \SM\Bundle\AdminBundle\Entity\CompanyType $type
     * @return CompanyType
     */
    public function setType(\SM\Bundle\AdminBundle\Entity\CompanyType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \SM\Bundle\AdminBundle\Entity\CompanyType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set charter_capital
     *
     * @param float $charterCapital
     * @return Company
     */
    public function setCharterCapital($charterCapital)
    {
        $this->charter_capital = $charterCapital;

        return $this;
    }

    /**
     * Get charter_capital
     *
     * @return float
     */
    public function getCharterCapital()
    {
        return $this->charter_capital;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Company
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Company
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set mst
     *
     * @param string $mst
     * @return Company
     */
    public function setMst($mst)
    {
        $this->mst = $mst;

        return $this;
    }

    /**
     * Get mst
     *
     * @return string
     */
    public function getMst()
    {
        return $this->mst;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Company
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Company
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return Company
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return Company
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set user
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $user
     * @return Company
     */
    public function setCreated(\SM\Bundle\AdminBundle\Entity\User $created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SM\Bundle\AdminBundle\Entity\User
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set user
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $user
     * @return Company
     */
    public function setUpdated(\SM\Bundle\AdminBundle\Entity\User $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SM\Bundle\AdminBundle\Entity\User
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->company_languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->language = null;
    }

    /**
     * Add company_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\CompanyLanguage $companyLanguages
     * @return Company
     */
    public function addCompanyLanguage(\SM\Bundle\AdminBundle\Entity\CompanyLanguage $companyLanguages)
    {
        $this->company_languages[] = $companyLanguages;

        return $this;
    }

    /**
     * Remove company_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\CompanyLanguage $companyLanguages
     */
    public function removeCompanyLanguage(\SM\Bundle\AdminBundle\Entity\CompanyLanguage $companyLanguages)
    {
        $this->company_languages->removeElement($companyLanguages);
    }

    /**
     * Get company_languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanyLanguages()
    {
        return $this->company_languages;
    }

    /**
     * Set Language
     *
     * @param \SM\Bundle\AdminBundle\Entity\Language $language
     */
    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \SM\Bundle\AdminBundle\Entity\Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function getCurrentLanguage()
    {
        $companyLanguages = $this->company_languages->toArray();
        if (is_array($companyLanguages)) {
            if (null !== $this->language) {
                foreach ($companyLanguages as $comLanguage) {
                    if ($comLanguage->getLanguage()->getId() == $this->language->getId()) {
                        return $comLanguage;
                    }
                }
            }
        }

        return null;
    }

    public function hasLanguage(Language $language)
    {
        $result = false;
        if (count($this->company_languages->toArray()) > 0) {
            foreach ($this->company_languages as $plTemp) {
                if ($language->getId() == $plTemp->getLanguage()->getId()) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Company
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Company
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

}