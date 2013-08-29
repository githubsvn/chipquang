<?php

namespace SM\Bundle\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use SM\Bundle\AdminBundle\Entity\Language;
use Doctrine\ORM\UnitOfWork;

/**
 * LanguageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LanguageRepository extends EntityRepository
{

    /**
     * @param type $limit    limit
     * @param type $offset   offset
     * @param type $criteria criteria
     * @param type $orderBy  orderBy
     *
     * @return type
     */
    public function getList($limit = null, $offset = null, $criteria = array(), $orderBy = array())
    {
        return $this->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Delete language by array id
     *
     * @param array $ids
     *
     * @return array
     */
    public function deleteByIds($ids = array())
    {
        $em = $this->getEntityManager();
        $rst = array();
        if (is_array($ids) && count($ids)) {
            foreach ($ids as $id) {
                $entity = $this->find($id);
                $em->remove($entity);
                if ($em->getUnitOfWork()->getEntityState($entity) == UnitOfWork::STATE_REMOVED) {
                    $rst[] = $id;
                }
            }
            $em->flush();
        }

        return $rst;
    }

    /**
     * get total
     *
     * @return type
     */
    public function getTotal()
    {
        $rst = $this->findAll();
        return count($rst);
    }

    /**
     * get default language
     *
     * @return Language $entity
     */
    public function findOneByIsDefault()
    {
        $entity = new Language();
        $rst = $this->findBy(array('is_default' => true));
        if (!empty($rst[0])) {
            $entity = $rst[0];
        } else {
            $rst = $this->getList();
            if (!empty($rst[0])) {
                $entity = $rst[0];
            }
        }

        return $entity;
    }

    /**
     * Adding new language from entity
     *
     * @param \SM\Bundle\AdminBundle\Entity\Language $entity
     *
     * @return int $id
     */
    public function addByEntity(\SM\Bundle\AdminBundle\Entity\Language $entity)
    {
        $em = $this->getEntityManager();
        $id = 0;
        if (is_object($entity)) {
            $em->persist($entity);
            $em->flush();
            $id = $entity->getId();
        }

        return $id;
    }


    /**
     * Set default for language
     *
     * @param int $id the language id
     *
     * @return int the id of language
     */
    public function setDefaultById($id = '')
    {
        $em = $this->getEntityManager();
        $rst = 0;
        if (!empty($id)) {
            $entLangs = $this->getList();
            if (is_array($entLangs) && count($entLangs) > 0) {
                foreach ($entLangs as $entity) {
                    $entity->setIsDefault(0);
                    $em->persist($entity);
                }
            }
            $language = $this->find($id);
            $language->setIsDefault(1);
            $em->persist($language);
            $em->flush();

            $rst = $language->getId();
        }

        return $rst;
    }

    /**
     * get options
     *
     * @return array $options the option
     */
    public function getOptions()
    {
        $options = array();
        $rst = $this->getList();
        if (is_array($rst) && count($rst) > 0 ) {
            foreach ($rst as $ent) {
                $options[$ent->getId()]['id'] = $ent->getId();
                $options[$ent->getId()]['name'] = $ent->getName();
                $options[$ent->getId()]['key'] = $ent->getLangKey();
                $options[$ent->getId()]['is_default'] = $ent->getIsDefault();
            }
        }

        return $options;
    }

}
