<?php

namespace Abe\loginBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ROLE
 *
 * @ORM\Table(name="Role")
 * @ORM\Entity
 */
class Role implements RoleInterface
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * 
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;


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
     * Set name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * Get role
     *
     * @return ArrayCollection
     */
    public function getRole()
    {
      
    return $this->role;
    }
    
     /**
     * @ORM\ManyToMany(targetEntity="user2", mappedBy="roles")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    
    

    /**
     * Add users
     *
     * @param \Abe\loginBundle\Entity\user2 $users
     * @return Role
     */
    public function addUser(\Abe\loginBundle\Entity\user2 $users)
    {
        $this->users[] = $users;
    
        return $this;
    }

    /**
     * Remove users
     *
     * @param \Abe\loginBundle\Entity\user2 $users
     */
    public function removeUser(\Abe\loginBundle\Entity\user2 $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\ArrayCollection 
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    public  function __toString ( )  { 
    return  $this->role ;
 }
}