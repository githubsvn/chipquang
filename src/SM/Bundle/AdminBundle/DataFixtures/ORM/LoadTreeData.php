<?php

namespace SM\Bundle\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SM\Bundle\AdminBundle\Entity\Category;
use SM\Bundle\AdminBundle\Entity\Menu;
use SM\Bundle\AdminBundle\Entity\MediaCategory;

/**
 * Load tree page data
 */
class LoadTreeData implements FixtureInterface
{

    /**
     * Function to load data
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $entity = new Category();
        $entity->setLft(0);
        $entity->setRgt(0);
        $entity->setStatus(0);
        $manager->persist($entity);

        $entity = new Menu();
        $entity->setLft(0);
        $entity->setRgt(0);
        $entity->setStatus(0);
        $manager->persist($entity);

        $entity = new MediaCategory();
        $entity->setLft(0);
        $entity->setRgt(0);
        $entity->setStatus(0);
        $manager->persist($entity);
    }

}