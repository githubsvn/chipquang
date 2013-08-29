<?php

namespace SM\Bundle\AclBundle\Model;

/**
 * Acl manager interface
 */
interface AclManagerInterface
{
    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mark
     * @param type $securityIdentity securityIdentity
     */
    public function addObjectPermission($domainObject, $mask, $securityIdentity = null);

    /**
     * @param type $domainObject     domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     */
    public function addClassPermission($domainObject, $mask, $securityIdentity = null);

    /**
     * @param type $domainObject     $domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     */
    public function setObjectPermission($domainObject, $mask, $securityIdentity = null);

    /**
     * @param type $domainObject     $domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     */
    public function setClassPermission($domainObject, $mask, $securityIdentity = null);

    /**
     * @param type $domainObject     $domainObject
     * @param type $mask             mask
     * @param type $securityIdentity securityIdentity
     * @param type $type             type
     */
    public function revokePermission($domainObject, $mask, $securityIdentity = null, $type = 'object');

    /**
     * @param type $domainObject     securityIdentity
     * @param type $securityIdentity securityIdentity
     */
    public function revokeAllObjectPermissions($domainObject, $securityIdentity = null);

    /**
     * @param type $domainObject     domainObject
     * @param type $securityIdentity securityIdentity
     */
    public function revokeAllClassPermissions($domainObject, $securityIdentity = null);

    /**
     * @param type $domainObject
     */
    public function deleteAclFor($domainObject);

    /**
     * @param type $attributes attributes
     * @param type $object     object
     */
    public function isGranted($attributes, $object = null);

    /**
     * @return UserInterface
     */
    public function getUser();

}
