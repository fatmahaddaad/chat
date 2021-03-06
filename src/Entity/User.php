<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=500)
     * @Serializer\Exclude()
     */
    private $password;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=225, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $created_at;

    /**
     * @var array
     * @ORM\Column(type="array", length=500)
     */
    protected $roles;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conversation", mappedBy="creator")
     */
    private $conversation;

    public function __construct($username)
    {
        $this->isActive = true;
        $this->username = $username;
        $this->roles = array('ROLE_USER');
        $this->conversation = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getConversation() : Collection
    {
        return $this->conversation;
    }

    /**
     * @param mixed $conversation
     */
    public function setConversation($conversation): void
    {
        $this->conversation = $conversation;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function getRoles()
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    public function eraseCredentials()
    {
    }
}
