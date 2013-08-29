<?php

namespace SM\Bundle\AdminBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Listener
 */
class TreeListener
{

    protected $listTree;
    private $currentEntity;
    private $_em;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->listTree = array(
            "SM\Bundle\AdminBundle\Entity\Menu",
            "SM\Bundle\AdminBundle\Entity\Category",
            "SM\Bundle\AdminBundle\Entity\MediaCategory",
            "SM\Bundle\AdminBundle\Entity\Branch",
        );
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->_em = $args->getEntityManager();

        if ($this->acceptPostTree($entity)) {
            //set the value of left to bigest
            $entity->setLft($this->getBigestLft(get_class($entity)));

            //check for root
            $root = $this->_em
                    ->getRepository(get_class($entity))
                    ->createQueryBuilder('c')
                    ->select('c.id')
                    ->where('c.parent IS NULL')
                    ->getQuery()
                    ->getArrayResult();
            if (empty($root)) {
                //insert one root for this tree
                $table = $this->_em->getClassMetadata(get_class($entity));
                $stmt = $this->_em
                        ->getConnection()
                        ->prepare("INSERT INTO {$table->getTableName()} (lft, rgt) VALUES (0, 0)");
                $stmt->execute();
                $root = $this->_em
                        ->getRepository(get_class($entity))
                        ->find($this->_em->getConnection()->lastInsertId());
                $entity->setParent($root);
            }
        }
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->rebuildTrees($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->rebuildTrees($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args args
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->rebuildTrees($args);
    }

    /**
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args args
     */
    private function rebuildTrees(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->_em = $args->getEntityManager();

        // perhaps you only want to act on some "Menu" entity
        if ($this->acceptPostTree($entity)) {
            $this->currentEntity = $entity;
            $this->rebuildLftRgt();
        }
    }

    /**
     * @param type $entity the entity
     *
     * @return type
     */
    public function acceptPostTree($entity)
    {
        $result = in_array(get_class($entity), $this->listTree);

        return $result;
    }

    /**
     * @return boolean
     */
    public function rebuildLftRgt()
    {
        //get all parent tree
        $trees = $this->_em
                ->getRepository(get_class($this->currentEntity))
                ->createQueryBuilder('c')
                ->select('c.id, c.lft, c.rgt')
                ->where('c.parent IS NULL')
                ->getQuery()
                ->getArrayResult();
        $begin = 1;
        $end = 0;
        foreach ($trees as $tree) {
            $this->postOrderTraversal($tree, $begin, $end);
            $begin = $end + 1;
        }

        return true;
    }

    /**
     * @param type $tree  tree
     * @param type $begin begin
     * @param type &$end  end
     */
    public function postOrderTraversal($tree, $begin, &$end)
    {
        //get $tree childrens
        $children = $this->getChildrenArray($tree['id']);

        $tree['lft'] = $begin;
        $end = ++$begin;
        //Travesal the tree
        foreach ($children as $child) {
            $this->postOrderTraversal($child, $begin, $end);
            $begin = ++$end;
        }
        $tree['rgt'] = $end;
        $this->setLftRgt($tree['id'], $tree['lft'], $tree['rgt']);
    }

    /**
     * getChildrenArray
     *
     * @param type $parentId the id
     *
     * @return @return array
     */
    private function getChildrenArray($parentId)
    {
        return $this->_em
                        ->getRepository(get_class($this->currentEntity))
                        ->createQueryBuilder('c')
                        ->select('c.id, c.lft, c.rgt')
                        ->where('c.parent = :parentId')
//                ->andWhere('c.parent != c.id')
                        ->setParameter('parentId', $parentId)
                        ->orderBy('c.lft', 'ASC')
                        ->getQuery()
                        ->getArrayResult();
    }

    /**
     * @param type $id  the id
     * @param type $lft lft
     * @param type $rgt rgt
     *
     * @return type
     */
    private function setLftRgt($id, $lft, $rgt)
    {
        return $this->_em
                        ->getRepository(get_class($this->currentEntity))
                        ->createQueryBuilder('c')
                        ->update()
                        ->set('c.lft', $lft)
                        ->set('c.rgt', $rgt)
                        ->where('c.id = :id')
                        ->setParameter('id', $id)
                        ->getQuery()
                        ->execute();
    }

    /**
     * get the bigest left value
     *
     * @param string $className
     *
     * @return integer
     */
    private function getBigestLft($className)
    {
        return $this->_em
                        ->getRepository($className)
                        ->createQueryBuilder('c')
                        ->select('max(c.lft)')
//                        ->groupBy('c.lft')
                        ->getQuery()
                        ->getSingleScalarResult();
    }
}

