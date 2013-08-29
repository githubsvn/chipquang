<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="mtx_mediacategory")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\MediaCategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class MediaCategory
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MediaCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="MediaCategory", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var integer
     *
     * @ORM\Column(name="lft", type="integer", nullable=true)
     */
    private $lft;

    /**
     * @var integer
     *
     * @ORM\Column(name="rgt", type="integer", nullable=true)
     */
    private $rgt;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $updated;

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
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MediaCategoryLanguage", mappedBy="mediacategory", cascade={"all"})
     */
    protected $mediacategory_languages;

    /**
     * @var Language
     */
    private $language;

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
     * Constructor
     */
    public function __construct()
    {
        $this->mediacategory_languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getCurrentLanguage()
    {
        $catLanguages = $this->mediacategory_languages->toArray();
        if (is_array($catLanguages)) {
            if (null !== $this->language) {
                foreach ($catLanguages as $ctLanguage) {
                    if ($ctLanguage->getLanguage()->getId() == $this->language->getId()) {
                        return $ctLanguage;
                    }
                }
            }
        }

        return null;
    }

    public function hasLanguage(Language $language)
    {
        $result = false;
        if (count($this->mediacategory_languages->toArray()) > 0) {
            foreach ($this->mediacategory_languages as $plTemp) {
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
        $catLanguages = $this->mediacategory_languages->toArray();
        if (is_array($catLanguages)) {
            if (isset($catLanguages[0])) {
                return $catLanguages[0]->getTreeName();
            }
        }

        return '';
    }

    public function getLevel()
    {
        if (null === $this->parent) {
            return 1;
        } else {
            return $this->parent->getLevel() + 1;
        }
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
     * Set lft
     *
     * @param integer $lft
     * @return MediaCategory
     */
    public function setLft($lft)
    {
        $this->lft = $lft;
    
        return $this;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return MediaCategory
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;
    
        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return MediaCategory
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
     * @return MediaCategory
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
     * @return MediaCategory
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
     * Set parent
     *
     * @param \SM\Bundle\AdminBundle\Entity\MediaCategory $parent
     * @return MediaCategory
     */
    public function setParent(\SM\Bundle\AdminBundle\Entity\MediaCategory $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \SM\Bundle\AdminBundle\Entity\MediaCategory 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \SM\Bundle\AdminBundle\Entity\MediaCategory $children
     * @return MediaCategory
     */
    public function addChildren(\SM\Bundle\AdminBundle\Entity\MediaCategory $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \SM\Bundle\AdminBundle\Entity\MediaCategory $children
     */
    public function removeChildren(\SM\Bundle\AdminBundle\Entity\MediaCategory $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set created
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $created
     * @return MediaCategory
     */
    public function setCreated(\SM\Bundle\AdminBundle\Entity\User $created = null)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \SM\Bundle\AdminBundle\Entity\User 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $updated
     * @return MediaCategory
     */
    public function setUpdated(\SM\Bundle\AdminBundle\Entity\User $updated = null)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \SM\Bundle\AdminBundle\Entity\User 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add mediacategory_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\MediaCategoryLanguage $mediacategoryLanguages
     * @return MediaCategory
     */
    public function addMediacategoryLanguage(\SM\Bundle\AdminBundle\Entity\MediaCategoryLanguage $mediacategoryLanguages)
    {
        $this->mediacategory_languages[] = $mediacategoryLanguages;
    
        return $this;
    }

    /**
     * Remove mediacategory_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\MediaCategoryLanguage $mediacategoryLanguages
     */
    public function removeMediacategoryLanguage(\SM\Bundle\AdminBundle\Entity\MediaCategoryLanguage $mediacategoryLanguages)
    {
        $this->mediacategory_languages->removeElement($mediacategoryLanguages);
    }

    /**
     * Get mediacategory_languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMediacategoryLanguages()
    {
        return $this->mediacategory_languages;
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
}