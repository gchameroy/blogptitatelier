<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Social
 *
 * @ORM\Table(name="social")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SocialRepository")
 */
class Social
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
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
	
	/**
	* @ORM\ManyToOne(targetEntity="Setting", inversedBy="socials")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $setting;

	/**
	* @ORM\ManyToOne(targetEntity="SocialType")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $socialType;


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
     * Set url
     *
     * @param string $url
     *
     * @return Social
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set setting
     *
     * @param \AppBundle\Entity\Setting $setting
     *
     * @return Social
     */
    public function setSetting(\AppBundle\Entity\Setting $setting)
    {
        $this->setting = $setting;

        return $this;
    }

    /**
     * Get setting
     *
     * @return \AppBundle\Entity\Setting
     */
    public function getSetting()
    {
        return $this->setting;
    }

    /**
     * Set socialType
     *
     * @param \AppBundle\Entity\SocialType $socialType
     *
     * @return Social
     */
    public function setSocialType(SocialType $socialType)
    {
        $this->socialType = $socialType;

        return $this;
    }

    /**
     * Get socialType
     *
     * @return \AppBundle\Entity\SocialType
     */
    public function getSocialType()
    {
        return $this->socialType;
    }
}
