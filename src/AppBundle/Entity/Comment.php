<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="message", type="text")
     */
    private $message;

	/**
     * @var bool
     *
     * @ORM\Column(name="is_validate", type="boolean")
     */
    private $isValidate;
	
    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean")
     */
    private $isDeleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validate_at", type="datetime", nullable=true)
     */
    private $validateAt;
	
	/**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;
	
	/**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
	
	/**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;


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
     * Set message
     *
     * @param string $message
     *
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set isValidate
     *
     * @param boolean $isValidate
     *
     * @return Comment
     */
    public function setIsValidate($isValidate)
    {
        $this->isValidate = $isValidate;

        return $this;
    }

    /**
     * Get isValidate
     *
     * @return boolean
     */
    public function getIsValidate()
    {
        return $this->isValidate;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Comment
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set validateAt
     *
     * @param \DateTime $validateAt
     *
     * @return Comment
     */
    public function setValidateAt($validateAt)
    {
        $this->validateAt = $validateAt;

        return $this;
    }

    /**
     * Get validateAt
     *
     * @return \DateTime
     */
    public function getValidateAt()
    {
        return $this->validateAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Comment
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return Comment
     */
    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \AppBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
