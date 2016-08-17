<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Header
 *
 * @ORM\Table(name="header")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AboutRepository")
 */
class Header
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
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $favicon;
	
	/**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=255)
     */
    private $logo;
	
	/**
     * @var string
     *
     * @ORM\Column(name="banner", type="string", length=255)
     */
    private $banner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inserted_at", type="datetime")
     */
    private $insertedAt;

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
     * Set favicon
     *
     * @param string $favicon
     *
     * @return Header
     */
    public function setFavicon($favicon)
    {
        $this->favicon = $favicon;

        return $this;
    }

    /**
     * Get favicon
     *
     * @return string
     */
    public function getFavicon()
    {
        return $this->favicon;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Header
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set banner
     *
     * @param string $banner
     *
     * @return Header
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set insertedAt
     *
     * @param \DateTime $insertedAt
     *
     * @return Header
     */
    public function setInsertedAt($insertedAt)
    {
        $this->insertedAt = $insertedAt;

        return $this;
    }

    /**
     * Get insertedAt
     *
     * @return \DateTime
     */
    public function getInsertedAt()
    {
        return $this->insertedAt;
    }
}
