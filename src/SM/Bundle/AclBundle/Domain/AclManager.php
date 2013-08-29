<?php

namespace SM\Bundle\AclBundle\Domain;

use Symfony\Component\Security\Acl\Dbal\MutableAclProvider;
use Symfony\Component\Security\Acl\Domain\Acl;
use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;
use Symfony\Component\Security\Core\SecurityContext;
use SM\Bundle\AclBundle\Model\AclManagerInterface;
use SM\Bundle\AclBundle\Domain\AbstractAclManager;
use SM\Bundle\AclBundle\Model\PermissionContextInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * Acl manager
 */
class AclManager extends AbstractAclManager
{

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     */
    public function addObjectPermission($domainObject, $mask, $securityIdentity = null)
    {
        $this->addPermission($domainObject, $mask, $securityIdentity, 'object', false);
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     */
    public function addClassPermission($domainObject, $mask, $securityIdentity = null)
    {
        $this->addPermission($domainObject, $mask, $securityIdentity, 'class', false);
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     * @param type $type             type
     * @param type $replaceExisting  replaceExisting
     *
     * @return \SM\Bundle\AclBundle\Domain\AbstractAclManager
     */
    protected function addPermission($domainObject, $mask, $securityIdentity = null, $type = 'object', $replaceExisting = false)
    {
        if (is_null($securityIdentity)) {
            $securityIdentity = $this->getUser();
        }
        $context = $this->doCreatePermissionContext($type, $securityIdentity, $mask);
        $oid = $this->getObjectIdentityRetrievalStrategy()->getObjectIdentity($domainObject);
        $acl = $this->doLoadAcl($oid);
        $this->doApplyPermission($acl, $context, $replaceExisting);

        $this->getAclProvider()->updateAcl($acl);

        return $this;
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     * @param type $type             type
     *
     * @return \SM\Bundle\AclBundle\Domain\AbstractAclManager
     */
    protected function setPermission($domainObject, $mask, $securityIdentity = null, $type = 'object')
    {
        $this->addPermission($domainObject, $mask, $securityIdentity, $type, true);

        return $this;
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     */
    public function setObjectPermission($domainObject, $mask, $securityIdentity = null)
    {
        $this->setPermission($domainObject, $mask, $securityIdentity, 'object');
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     */
    public function setClassPermission($domainObject, $mask, $securityIdentity = null)
    {
        $this->setPermission($domainObject, $mask, $securityIdentity, 'class');
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     * @param type $type             type
     *
     * @return \SM\Bundle\AclBundle\Domain\AbstractAclManager
     */
    public function revokePermission($domainObject, $mask, $securityIdentity = null, $type = 'object')
    {
        if (is_null($securityIdentity)) {
            $securityIdentity = $this->getUser();
        }
        $context = $this->doCreatePermissionContext($type, $securityIdentity, $mask);
        $oid = $this->getObjectIdentityRetrievalStrategy()->getObjectIdentity($domainObject);
        $acl = $this->doLoadAcl($oid);
        $this->doRevokePermission($acl, $context);
        $this->getAclProvider()->updateAcl($acl);

        return $this;
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $securityIdentity securityIdentity
     */
    public function revokeAllClassPermissions($domainObject, $securityIdentity = null)
    {
        $this->revokeAllPermissions($domainObject, $securityIdentity, 'class');
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $securityIdentity securityIdentity
     */
    public function revokeAllObjectPermissions($domainObject, $securityIdentity = null)
    {
        $this->revokeAllPermissions($domainObject, $securityIdentity, 'object');
    }

    /**
     * @param type $domainObject     domainObject
     * @param type $securityIdentity securityIdentity
     * @param type $type             type
     *
     * @return \SM\Bundle\AclBundle\Domain\AbstractAclManager
     */
    protected function revokeAllPermissions($domainObject, $securityIdentity = null, $type = 'object')
    {
        if (is_null($securityIdentity)) {
            $securityIdentity = $this->getUser();
        }
        $securityIdentity = $this->doCreateSecurityIdentity($securityIdentity);
        $oid = $this->getObjectIdentityRetrievalStrategy()->getObjectIdentity($domainObject);
        $acl = $this->doLoadAcl($oid);
        $this->doRevokeAllPermissions($acl, $securityIdentity, $type);
        $this->getAclProvider()->updateAcl($acl);

        return $this;
    }

    /**
     * @param type $objects objects
     *
     * @return type
     */
    public function preloadAcls($objects)
    {
        $oids = array();
        foreach ($objects as $object) {
            $oid = $this->getObjectIdentityRetrievalStrategy()->getObjectIdentity($object);
            $oids[] = $oid;
        }

        $acls = $this->getAclProvider()->findAcls($oids); // todo: do we need to do anything with these?

        return $acls;
    }

    /**
     * @param type $domainObject domainObject
     *
     * @return \SM\Bundle\AclBundle\Domain\AbstractAclManager
     */
    public function deleteAclFor($domainObject)
    {
        $oid = $this->getObjectIdentityRetrievalStrategy()->getObjectIdentity($domainObject);
        $this->getAclProvider()->deleteAcl($oid);

        return $this;
    }

    /**
     * @param type $attributes attributes
     * @param type $object     object
     *
     * @return type
     */
    public function isGranted($attributes, $object = null)
    {
        return $this->getSecurityContext()->isGranted($attributes, $object);
    }

    /**
     * @return null
     */
    public function getUser()
    {
        $token = $this->getSecurityContext()->getToken();

        if (null === $token) {
            return null;
        }

        $user = $token->getUser();

        return (is_object($user)) ? $user : 'IS_AUTHENTICATED_ANONYMOUSLY';
    }

}
