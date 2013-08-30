<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu Language
 *
 * @ORM\Table(name="mtx_menu_language")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\MenuLanguageRepository")
 * @UniqueEntity(fields="name", message="Sorry! This name exits. Please try another.")
 * @ORM\HasLifecycleCallbacks
 */
class MenuLanguage
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
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="menu_languages", cascade={"persist"})
     */
    private $menu;

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
     * @var string
     *
     * @ORM\Column(name="alias", type="string", length=255, nullable=true)
     */
    private $alias;

    /**
     * Get the name with tree level
     * 
     * @return string
     */
    public function getTreeName()
    {
        //the space is chr(255)
        $treeName = str_repeat('    ', $this->getMenu()->getLevel() - 1) .
                            ($this->getMenu()->getLevel() == 1 ? '' : '└') .
                            ' ' .
                            $this->getName();
        return $treeName;
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
     * @return MenuLanguage
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
     * Set alias
     *
     * @param string $alias
     * @return MenuLanguage
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    
        return $this;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set menu
     *
     * @param \SM\Bundle\AdminBundle\Entity\Menu $menu
     * @return MenuLanguage
     */
    public function setMenu(\SM\Bundle\AdminBundle\Entity\Menu $menu = null)
    {
        $this->menu = $menu;
    
        return $this;
    }

    /**
     * Get menu
     *
     * @return \SM\Bundle\AdminBundle\Entity\Menu 
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * Set language
     *
     * @param \SM\Bundle\AdminBundle\Entity\Language $language
     * @return MenuLanguage
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