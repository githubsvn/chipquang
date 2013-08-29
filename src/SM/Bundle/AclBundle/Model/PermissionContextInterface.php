<?php

namespace SM\Bundle\AclBundle\Model;

use Symfony\Component\Security\Acl\Model\AuditableEntryInterface;

/**
 * permission context interface
 */
interface PermissionContextInterface
{
    /**
     * getMask
     */
    public function getMask();

    /**
     * getSecurityIdentity
     */
    public function getSecurityIdentity();

    /**
     * getPermissionType
     */
    public function getPermissionType();

    /**
     * isGranting
     */
    public function isGranting();

    /**
     * @param \Symfony\Component\Security\Acl\Model\AuditableEntryInterface $ace ace
     */
    public function equals(AuditableEntryInterface $ace);

    /**
     * @param \Symfony\Component\Security\Acl\Model\AuditableEntryInterface $ace ace
     */
    public function hasDifferentPermission(AuditableEntryInterface $ace);
}
