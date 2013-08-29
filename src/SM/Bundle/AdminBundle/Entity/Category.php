<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="mtx_category")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\CategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Category
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
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
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
     * @ORM\OneToMany(targetEntity="CategoryLanguage", mappedBy="category", cascade={"all"})
     */
    protected $category_languages;

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
        $this->category_languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set status
     *
     * @param boolean $status
     * @return Category
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
     * @return Category
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
     * @return Category
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
     * @param \SM\Bundle\AdminBundle\Entity\Category $parent
     * @return Category
     */
    public function setParent(\SM\Bundle\AdminBundle\Entity\Category $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \SM\Bundle\AdminBundle\Entity\Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set created
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $created
     * @return Category
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
     * @return Category
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
     * Add category_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\CategoryLanguage $categoryLanguages
     * @return Category
     */
    public function addCategoryLanguage(\SM\Bundle\AdminBundle\Entity\CategoryLanguage $categoryLanguages)
    {
        $this->category_languages[] = $categoryLanguages;

        return $this;
    }

    /**
     * Remove category_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\CategoryLanguage $categoryLanguages
     */
    public function removeCategoryLanguage(\SM\Bundle\AdminBundle\Entity\CategoryLanguage $categoryLanguages)
    {
        $this->category_languages->removeElement($categoryLanguages);
    }

    /**
     * Get category_languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategoryLanguages()
    {
        return $this->category_languages;
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
        $catLanguages = $this->category_languages->toArray();
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
        if (count($this->category_languages->toArray()) > 0) {
            foreach ($this->category_languages as $plTemp) {
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
        $catLanguages = $this->category_languages->toArray();
        if (is_array($catLanguages)) {
            if (isset($catLanguages[0])) {
                return $catLanguages[0]->getTreeName();
            }
        }

        return '';
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Category
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
     * @return Category
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
     * Add children
     *
     * @param \SM\Bundle\AdminBundle\Entity\Category $children
     * @return Category
     */
    public function addChildren(\SM\Bundle\AdminBundle\Entity\Category $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \SM\Bundle\AdminBundle\Entity\Category $children
     */
    public function removeChildren(\SM\Bundle\AdminBundle\Entity\Category $children)
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

    public function getLevel()
    {
        if (null === $this->parent) {
            return 1;
        } else {
            return $this->parent->getLevel() + 1;
        }
    }
}