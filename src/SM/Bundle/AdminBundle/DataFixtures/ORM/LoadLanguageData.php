<?php

namespace SM\Bundle\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SM\Bundle\AdminBundle\Entity\Language;

/**
 * Load language data
 */
class LoadLanguageData implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    /**
     * Set container
     *
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Function to load data
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // get default language from config
        $defaultLang = $this->container->getParameter('locale');
        $entityLang = new Language();
        $entityLang->setName(ucfirst($defaultLang));
        $entityLang->setLangKey($defaultLang);
        $entityLang->setIsDefault(1);

        $manager->persist($entityLang);
        $manager->flush();
    }
}
