<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Model
 *
 * @ORM\Table(name="model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModelRepository")
 */
class Model
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
     * @var array
     *
     * @ORM\Column(name="columns", type="array")
     */
    private $columns;
	
	/**
     * @var integer
     *
     * @ORM\Column(name="order_id", type="integer")
     */
    private $orderId;
	
	/**
     * @var bool
     *
     * @ORM\Column(name="is_visible", type="boolean")
     */
    private $isVisible;
	
	/**
	* @ORM\ManyToOne(targetEntity="Setting", inversedBy="models")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $setting;

	/**
	* @ORM\ManyToOne(targetEntity="ModelType")
	* @ORM\JoinColumn(nullable=false)
	*/
	private $modelType;


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
     * Set columns
     *
     * @param array $columns
     *
     * @return Model
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * Get columns
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set setting
     *
     * @param \AppBundle\Entity\Setting $setting
     *
     * @return Model
     */
    public function setSetting(Setting $setting)
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
     * Set modelType
     *
     * @param \AppBundle\Entity\ModelType $modelType
     *
     * @return Model
     */
    public function setModelType(ModelType $modelType)
    {
        $this->modelType = $modelType;

        return $this;
    }

    /**
     * Get modelType
     *
     * @return \AppBundle\Entity\ModelType
     */
    public function getModelType()
    {
        return $this->modelType;
    }

    /**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Model
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Get orderId
     *
     * @return integer
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
	
	/**
     * Get orderId
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->orderId;
    }
	
	/**
     * Set orderId
     *
     * @param integer $orderId
     *
     * @return Model
     */
    public function setOrder($orderId)
    {
        $this->orderId = $orderId;

        return $this;
    }

    /**
     * Set isVisible
     *
     * @param boolean $isVisible
     *
     * @return Model
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return boolean
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }
	
	/**
     * Get isVisible
     *
     * @return boolean
     */
    public function isVisible()
    {
        return $this->isVisible;
    }
}
