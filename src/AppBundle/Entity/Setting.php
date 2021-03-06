<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Setting
 *
 * @ORM\Table(name="setting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingRepository")
 */
class Setting
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
	 * @ORM\OneToOne(targetEntity="About", cascade={"remove"})
	 * @ORM\JoinColumn(nullable=true, onDelete="set null")
	 */
	private $about;
	
	/**
	 * @ORM\OneToOne(targetEntity="Header", cascade={"remove"})
	 * @ORM\JoinColumn(nullable=true, onDelete="set null")
	 */
	private $header;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
	
	/**
	* @ORM\OneToMany(targetEntity="Model", mappedBy="setting")
	*/
	private $models;
	
	/**
	* @ORM\OneToMany(targetEntity="Social", mappedBy="setting")
	*/
	private $socials;


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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Setting
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set about
     *
     * @param \AppBundle\Entity\About $about
     *
     * @return Setting
     */
    public function setAbout(About $about = null)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return \AppBundle\Entity\About
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * Set header
     *
     * @param \AppBundle\Entity\Header $header
     *
     * @return Setting
     */
    public function setHeader(Header $header = null)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return \AppBundle\Entity\Header
     */
    public function getHeader()
    {
        return $this->header;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->models = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add model
     *
     * @param \AppBundle\Entity\Model $model
     *
     * @return Setting
     */
    public function addModel(Model $model)
    {
        $this->models[] = $model;

        return $this;
    }

    /**
     * Remove model
     *
     * @param \AppBundle\Entity\Model $model
     */
    public function removeModel(Model $model)
    {
        $this->models->removeElement($model);
    }

    /**
     * Get models
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Add social
     *
     * @param \AppBundle\Entity\Social $social
     *
     * @return Setting
     */
    public function addSocial(Social $social)
    {
        $this->socials[] = $social;

        return $this;
    }

    /**
     * Remove social
     *
     * @param \AppBundle\Entity\Social $social
     */
    public function removeSocial(Social $social)
    {
        $this->socials->removeElement($social);
    }

    /**
     * Get socials
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSocials()
    {
        return $this->socials;
    }
}
