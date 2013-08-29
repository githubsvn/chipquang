<?php

namespace SM\Bundle\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use SM\Bundle\AdminBundle\Entity\User;
use SM\Bundle\AdminBundle\Entity\Group;
use SM\Bundle\AdminBundle\Entity\Role;

/**
 * Load user, group, role data
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
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
        // Setup roles and group
        $rolenames = array(
            'ROLE_SUPER_ADMIN',
            'ROLE_ADMIN',
            'ROLE_USER'
        );
        $groupnames = array('Administrators', 'Manager', 'Users');

        for ($i = 0; $i < count($rolenames); $i++) {
            $groupname = $groupnames[$i];
            $rolename = $rolenames[$i];

            $entityRole = new Role($rolename);
            $entityRole->setRole($rolename);
            $manager->persist($entityRole);
            $manager->flush();

            $entityGroup = new Group($rolename);
            $entityGroup->addRoleCollection($entityRole);
            $entityGroup->setName($groupname);
            $entityGroup->updatedTimestamps();
            $entityGroup->setActive(1);
            $manager->persist($entityGroup);
            $manager->flush();

            if ($rolename == 'ROLE_SUPER_ADMIN') {
                $roleAdmin = $entityRole;
            }

            if ($groupname == 'Administrators') {
                $groupAdmin = $entityGroup;
            }
        }


        // Setup User
        $entityUser = new User();
        $entityUser->setUsername('admin');
        $entityUser->setPassword('password');
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($entityUser);
        $password = $encoder->encodePassword($entityUser->getPassword(), $entityUser->getSalt());
        $entityUser->setPassword($password);
        $entityUser->setActive(1);
        $entityUser->setFullname('Administrator');
        $entityUser->setEmail('admin@sm.com');
        $entityUser->addRoleCollection($roleAdmin);
        $entityUser->addGroup($groupAdmin);

        $manager->persist($entityUser);
        $manager->flush();
    }

}