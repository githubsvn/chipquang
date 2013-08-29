<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Product
 *
 * @ORM\Table(name="mtx_product")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\ProductsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Products
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
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=255, nullable=true)
     */
    private $unit;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float", nullable=true)
     */
    private $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb", type="string", length=255, nullable=true)
     */
    public $thumb;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
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
     * @ORM\OneToMany(targetEntity="ProductLanguage", mappedBy="product", cascade={"all"})
     */
    protected $product_languages;

    /**
     * @ORM\ManyToOne(targetEntity="Branch")
     */
    protected $branch;

    /**
     * @var Language
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity="Media", cascade={"persist"})
     * @ORM\JoinTable(name="mtx_product_media")
     */
    private $media_id;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product_languages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set price
     *
     * @param float $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set unit
     *
     * @param string $unit
     * @return Products
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set discount
     *
     * @param float $discount
     * @return Products
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set thumb
     *
     * @param string $thumb
     * @return Products
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * Get thumb
     *
     * @return string
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return Products
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Products
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
     * @return Products
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
     * @return Products
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
     * Set created
     *
     * @param \SM\Bundle\AdminBundle\Entity\User $created
     * @return Products
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
     * @return Products
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
     * Add product_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\ProductLanguage $productLanguages
     * @return Products
     */
    public function addProductLanguage(\SM\Bundle\AdminBundle\Entity\ProductLanguage $productLanguages)
    {
        $this->product_languages[] = $productLanguages;

        return $this;
    }

    /**
     * Remove product_languages
     *
     * @param \SM\Bundle\AdminBundle\Entity\ProductLanguage $productLanguages
     */
    public function removeProductLanguage(\SM\Bundle\AdminBundle\Entity\ProductLanguage $productLanguages)
    {
        $this->product_languages->removeElement($productLanguages);
    }

    /**
     * Get product_languages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductLanguages()
    {
        return $this->product_languages;
    }

    /**
     * Set branch
     *
     * @param \SM\Bundle\AdminBundle\Entity\Branch $branch
     * @return Products
     */
    public function setBranch(\SM\Bundle\AdminBundle\Entity\Branch $branch = null)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return \SM\Bundle\AdminBundle\Entity\Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

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

    public function getCurrentLanguage() {
        $oLanguages = $this->product_languages->toArray();
        if (is_array($oLanguages)) {
            if (null !== $this->language) {
                foreach ($oLanguages as $eLanguage) {
                    if ($eLanguage->getLanguage()->getId() == $this->language->getId()) {
                        return $eLanguage;
                    }
                }
            }
        }

        return null;
    }

    public function hasLanguage(Language $language) {
        $result = false;
        if (count($this->product_languages->toArray()) > 0) {
            foreach ($this->product_languages as $plTemp) {
                if ($language->getId() == $plTemp->getLanguage()->getId()) {
                    $result = true;
                    break;
                }
            }
        }

        return $result;
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