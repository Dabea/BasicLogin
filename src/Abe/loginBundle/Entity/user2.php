<?php

namespace Abe\loginBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * user2
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Abe\loginBundle\Entity\user2Repository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class user2 implements UserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", unique=true,  length=255, )
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=false, length=255)
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true, length=255 )
     */
    private $email;

    /**
     * @var string
     *
     * //Temporay Place to store the value submitted form the forms
     */
    private $plainPassword;
    

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
    *  @var array
    *
    *  @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
    *  @ORM\JoinTable(name="user2_role")
    *       
    */
    private $roles;
    

    /**
     * Set username
     *
     * @param string $username
     * @return user2
     */
    public function setUsername($username)
    {
        if(!is_null($username)){
        $this->username = $username;
        }
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
     * Set password
     *
     * @param string $password
     * @return user2
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
     * Set plainPassword
     *
     * @return string 
     * 
     */
    public function setplainPassword($plainPassword)
    {
        
        $this->plainPassword = $plainPassword;
        
        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string 
     */
    public function getplainPassword()
    {
        return $this->plainPassword;
    }
    
    
    
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        
        return $this;
    }
    
    public function eraseCredentials()
    {
        $this->setplainPassword(null);
    }
    
    public function getSalt()
    {
        return null;
    }
    
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
    /**
    * get Roles
    * @param Doctrine\Common\Collections\ArrayCollection
    */
    public function getRoles()
    {   
        $roles = $this->roles;
        
    
        return $this->roles->toArray();
    }
    
      public function serialize()
{
    return json_encode(
            array($this->username, $this->password,
                     $this->id));
}

/**
 * Unserializes the given string in the current User object
 * @param serialized
 */
public function unserialize($serialized)
{
    list($this->username, $this->password,
                     $this->id) = json_decode(
            $serialized);
} 

 

    /**
     * Add roles
     *
     * @param \Abe\loginBundle\Entity\Role $roles
     * @return user2
     */
    public function addRole(\Abe\loginBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Abe\loginBundle\Entity\Role $roles
     */
    public function removeRole(\Abe\loginBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }
    
    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }

    /**
     * Set email
     *
     * @param string $email
     * @return user2
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
    
    public function __toString()
{
    return (string) $this->getUsername();
}
    
}