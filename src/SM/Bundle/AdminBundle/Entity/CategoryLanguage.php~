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
 * @ORM\Table(name="mtx_category_language")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\CategoryLanguageRepository")
 * @UniqueEntity(fields="name", message="Sorry! This username exits. Please try another.")
 * @ORM\HasLifecycleCallbacks
 */
class CategoryLanguage
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
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
     */
    private $category;

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
     * @return CategoryLanguage
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
     * Set category
     *
     * @param \SM\Bundle\AdminBundle\Entity\Category $category
     * @return CategoryLanguage
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
     * Set language
     *
     * @param \SM\Bundle\AdminBundle\Entity\Language $language
     * @return CategoryLanguage
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

    /**
     * Get the name with tree level
     *
     * @return string
     */
    public function getTreeName()
    {
        $level = $this->getCategory()->getLevel();
        $treeName = str_repeat('    ', $level - 1) . ($level == 1 ? '' : '└') . ' ' . $this->name;
        return $treeName;
    }

    public function __toString()
    {
        return $this->name;
    }
}