<?php

namespace SM\Bundle\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table("mtx_user")
 * @ORM\Entity(repositoryClass="SM\Bundle\AdminBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Sorry! This username exits. Please try another.")
 * @UniqueEntity(fields="email", message="Sorry! This email exits. Please try another.")
 * @ORM\HasLifecycleCallbacks
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="fullname", type="string", length=255)
     */
    private $fullname;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=40)
     */
    private $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    private $currentPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60)
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity="Role", cascade={"persist"})
     * @ORM\JoinTable(name="mtx_user_role")
     */
    protected $role_collection;

    /**
     * @var group
     *
     * @ORM\ManyToMany(targetEntity="Group", cascade={"persist"})
     * @ORM\JoinTable(name="mtx_user_group")
     */
    protected $group;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created_at;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated_at;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="smallint")
     */
    private $active;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->active = 1;
        $this->salt = md5(uniqid(null, true));
        $this->role_collection = new ArrayCollection();
        $this->group = new ArrayCollection();
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set fullname
     *
     * @param string $fullname
     * @return User
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;

        return $this;
    }

    /**
     * Get fullname
     *
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the plain password.
     *
     * @param string $password
     * @return User
     */
    public function setCurrentPassword($password)
    {
        $this->currentPassword = $password;

        return $this;
    }

    /**
     * Gets the plain password.
     *
     * @return string
     */
    public function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set created_at
     *
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get created_at
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updated_at
     *
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updated_at
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add role_collection
     *
     * @param \SM\Bundle\AdminBundle\Entity\Role $roleCollection
     * @return User
     */
    public function addRoleCollection(\SM\Bundle\AdminBundle\Entity\Role $roleCollection)
    {
        $this->role_collection[] = $roleCollection;

        return $this;
    }

    /**
     * Remove role_collection
     *
     * @param \SM\Bundle\AdminBundle\Entity\Role $roleCollection
     */
    public function removeRoleCollection(\SM\Bundle\AdminBundle\Entity\Role $roleCollection)
    {
        $this->role_collection->removeElement($roleCollection);
    }

    /**
     * Get role_collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoleCollection()
    {
        return $this->role_collection;
    }

    /**
     * Add group
     *
     * @param \SM\Bundle\AdminBundle\Entity\Group $group
     * @return User
     */
    public function addGroup(\SM\Bundle\AdminBundle\Entity\Group $group)
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \SM\Bundle\AdminBundle\Entity\Group $group
     */
    public function removeGroup(\SM\Bundle\AdminBundle\Entity\Group $group)
    {
        $this->group->removeElement($group);
    }

    /**
     * Get group
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroup()
    {
        return $this->group;
    }

    public function eraseCredentials()
    {

    }

    public function getRoles()
    {
        $roles = new ArrayCollection();
        if ($this->getRoleCollection()) {
            foreach ($this->getRoleCollection() as $role)
            {
                $roles->add($role->getRole());
            }
        }

        foreach ($this->getGroup() as $group)
        {
            foreach ($group->getRoleCollection() as $role)
            {
                $roles->add($role->getRole());
            }
        }

        return array_unique($roles->toArray());

    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

    public function isEqualTo(AdvancedUserInterface $user)
    {
        return $this->username === $user->getUsername();
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->active;
    }

    /**
     * Update timestamps
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedAt(new \DateTime(date('Y-m-d H:i:s')));

        if($this->getCreatedAt() == null)
        {
            $this->setCreatedAt(new \DateTime(date('Y-m-d H:i:s')));
        }
    }

    public function __toString()
    {
        return $this->fullname;
    }
}