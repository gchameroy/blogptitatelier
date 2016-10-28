<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PostLike
 *
 * @ORM\Table(name="post_like")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostLikeRepository")
 */
class PostLike
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
     * @var \DateTime
     *
     * @ORM\Column(name="like_at", type="datetime")
     */
    private $likeAt;
	
	/**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="likes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;
	
	/**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="likes", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;


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
     * Set likeAt
     *
     * @param \DateTime $likeAt
     *
     * @return PostLike
     */
    public function setLikeAt($likeAt)
    {
        $this->likeAt = $likeAt;

        return $this;
    }

    /**
     * Get likeAt
     *
     * @return \DateTime
     */
    public function getLikeAt()
    {
        return $this->likeAt;
    }

    /**
     * Set post
     *
     * @param \AppBundle\Entity\Post $post
     *
     * @return PostLike
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

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return PostLike
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
}
