<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="mtx_news")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\NewsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class News {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $updated;

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
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="NewsLanguage", mappedBy="news", cascade={"all"})
     */
    protected $news_languages;

    /**
     * @var Language
     */
    private $language;
    
    /**
     * @var string
     *
      * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    public $image;
    
    /**
     * @ORM\ManyToMany(targetEntity="Media", cascade={"persist"})
     * @ORM\JoinTable(name="mtx_news_media")
     */
    private $media_id;
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue() {
        if (!$this->getCreatedAt()) {
            $this->created_at = new \DateTime();
            $this->updated_at = new \DateTime();
        }
    }

    public function getCurrentLanguage() {
        $objLanguages = $this->news_languages->toArray();
        if (is_array($objLanguages)) {
            if (null !== $this->language) {
                foreach ($objLanguages as $oLanguage) {
                    if ($oLanguage->getLanguage()->getId() == $this->language->getId()) {
                        return $oLanguage;
                    }
                }
            }
        }

        return null;
    }

    public function hasLanguage(Language $language) {
        $result = false;
        if (count($this->news_languages->toArray()) > 0) {
            foreach ($this->news_languages as $plTemp) {
                if ($language->getId() == $plTemp->getLanguage()->getId()) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
    }

    public function __toString() {
        $objLanguages = $this->news_languages->toArray();
        if (is_array($objLanguages)) {
            if (isset($objLanguages[0])) {
                return $objLanguages[0]->getName();
            }
        }
        return '';
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

    /**
     * Constructor
     */
    public function __construct() {
        $this->news_languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->language = null;
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
     * @return News
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
     * @return News
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
     * @return News
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
     * Set image
     *
     * @param string $image
     * @return News
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set category
     *
     * @param \SM\Bundle\AdminBundle\Entity\Category $category
     * @return News
     */
    public function setCategory(\SM\Bundle\AdminBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \SM\Bundle\AdminBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set created
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $created
     * @return News
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
     * @return News
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
     * Add news_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\NewsLanguage $newsLanguages
     * @return News
     */
    public function addNewsLanguage(\SM\Bundle\AdminBundle\Entity\NewsLanguage $newsLanguages)
    {
        $this->news_languages[] = $newsLanguages;
    
        return $this;
    }

    /**
     * Remove news_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\NewsLanguage $newsLanguages
     */
    public function removeNewsLanguage(\SM\Bundle\AdminBundle\Entity\NewsLanguage $newsLanguages)
    {
        $this->news_languages->removeElement($newsLanguages);
    }

    /**
     * Get news_languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewsLanguages()
    {
        return $this->news_languages;
    }
    
    /**
     * Add media_id
     *
     * @param \SM\Bundle\AdminBundle\Entity\Media $mediaId
     * @return Products
     */
    public function addMediaId(\SM\Bundle\AdminBundle\Entity\Media $mediaId)
    {
        $this->media_id[] = $mediaId;

        return $this;
    }

    /**
     * Remove media_id
     *
     * @param \SM\Bundle\AdminBundle\Entity\Media $mediaId
     */
    public function removeMediaId(\SM\Bundle\AdminBundle\Entity\Media $mediaId)
    {
        $this->media_id->removeElement($mediaId);
    }

    /**
     * Get media_id
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMediaId()
    {
        return $this->media_id;
    }
}