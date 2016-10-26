<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="Username already taken.")
 * @UniqueEntity(fields="email", message="Email already taken.")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60)
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registered_at", type="datetime")
     */
    private $registeredAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_office", type="boolean")
     */
    private $isOffice;
	
	/**
     * @var bool
     *
     * @ORM\Column(name="is_app", type="boolean")
     */
    private $isApp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
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
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

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
     * Set salt
     *
     * @param string $salt
     *
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
     * Set email
     *
     * @param string $email
     *
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
     * Set registeredAt
     *
     * @param \DateTime $registeredAt
     *
     * @return User
     */
    public function setRegisteredAt($registeredAt)
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * Get registeredAt
     *
     * @return \DateTime
     */
    public function getRegisteredAt()
    {
        return $this->registeredAt;
    }

    /**
     * Set isOffice
     *
     * @param boolean $isOffice
     *
     * @return User
     */
    public function setIsOffice($isOffice)
    {
        $this->isOffice = $isOffice;

        return $this;
    }

    public function isOffice()
    {
        return $this->isOffice;
    }
	
	/**
     * Get isOffice
     *
     * @return bool
     */
    public function getIsOffice()
    {
        return $this->isOffice;
    }
	
    /**
     * Set isApp
     *
     * @param boolean $isApp
     *
     * @return User
     */
    public function setIsApp($isApp)
    {
        $this->isApp = $isApp;

        return $this;
    }

    public function isApp()
    {
        return $this->isApp;
    }

    /**
     * Get isApp
     *
     * @return bool
     */
    public function getIsApp()
    {
        return $this->isApp;
    }

    public function getRoles()
    {
        $roles = ['ROLE_USER'];
		if($this->isApp()){
            $roles[] = ['ROLE_APP_ADMIN'];
        }
        if($this->isOffice()){
			$roles[] = ['ROLE_APP_ADMIN'];
            $roles[] = ['ROLE_OFFICE_ADMIN'];
        }
        return $roles;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
