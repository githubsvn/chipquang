<?php
namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MediaCategoryLanguage
 *
 * @ORM\Table(name="mtx_mediacategory_language")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\MediaCategoryLanguageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class MediaCategoryLanguage
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
     * @ORM\ManyToOne(targetEntity="MediaCategory", cascade={"persist"})
     */
    private $mediacategory;

    /**
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * Get the name with tree level
     *
     * @return string
     */
    public function getTreeName()
    {
        $level = $this->getMediacategory()->getLevel();
        $treeName = str_repeat('    ', $level - 1) . ($level == 1 ? '' : '└') . ' ' . $this->name;
        return $treeName;
    }

    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return MediaCategoryLanguage
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
     * Set mediacategory
     *
     * @param \SM\Bundle\AdminBundle\Entity\MediaCategory $mediacategory
     * @return MediaCategoryLanguage
     */
    public function setMediacategory(\SM\Bundle\AdminBundle\Entity\MediaCategory $mediacategory = null)
    {
        $this->mediacategory = $mediacategory;
    
        return $this;
    }

    /**
     * Get mediacategory
     *
     * @return \SM\Bundle\AdminBundle\Entity\MediaCategory 
     */
    public function getMediacategory()
    {
        return $this->mediacategory;
    }

    /**
     * Set language
     *
     * @param \SM\Bundle\AdminBundle\Entity\Language $language
     * @return MediaCategoryLanguage
     */
    public function setLanguage(\SM\Bundle\AdminBundle\Entity\Language $language = null)
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