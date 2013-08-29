<?php

namespace SM\Bundle\AclBundle\Domain;

use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;
use SM\Bundle\AclBundle\Model\PermissionContextInterface;
use Symfony\Component\Security\Acl\Model\AuditableEntryInterface;

/**
 * permission context
 */
class PermissionContext implements PermissionContextInterface
{

    protected $permissionMask;
    protected $securityIdentity;
    protected $permissionType;
    protected $granting;

    /**
     * constructor
     */
    public function __construct()
    {

    }

    /**
     * @param type $mask
     */
    public function setMask($mask)
    {
        $this->permissionMask = $mask;
    }

    /**
     * @return type
     */
    public function getMask()
    {
        return $this->permissionMask;
    }

    /**
     * @param \Symfony\Component\Security\Acl\Model\SecurityIdentityInterface $securityIdentity
     */
    public function setSecurityIdentity(SecurityIdentityInterface $securityIdentity)
    {
        $this->securityIdentity = $securityIdentity;
    }

    /**
     * @return type
     */
    public function getSecurityIdentity()
    {
        return $this->securityIdentity;
    }

    /**
     * @param type $type
     */
    public function setPermissionType($type)
    {
        $this->permissionType = $type;
    }

    /**
     * @return type
     */
    public function getPermissionType()
    {
        return $this->permissionType;
    }

    /**
     * @param type $granting
     */
    public function setGranting($granting)
    {
        $this->granting = $granting;
    }

    /**
     * @return type
     */
    public function isGranting()
    {
        return $this->granting;
    }

    /**
     * @param \Symfony\Component\Security\Acl\Model\AuditableEntryInterface $ace
     *
     * @return type
     */
    public function equals(AuditableEntryInterface $ace)
    {
        return $ace->getSecurityIdentity() == $this->getSecurityIdentity() &&
                $ace->isGranting() === $this->isGranting() &&
                $ace->getMask() === $this->getMask();
    }

    /**
     * @param \Symfony\Component\Security\Acl\Model\AuditableEntryInterface $ace
     *
     * @return type
     */
    public function hasDifferentPermission(AuditableEntryInterface $ace)
    {
        return $ace->getSecurityIdentity() == $this->getSecurityIdentity() &&
                $ace->isGranting() === $this->isGranting() && $ace->getMask() !== $this->getMask();
    }

}
