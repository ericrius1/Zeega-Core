<?php

// src/Zeega/DataBundle/Entity/Frame.php

namespace Zeega\DataBundle\Entity;

class Frame
{
 
 
 		   /**
     * Constructs a new instance of Project
     */
    public function __construct()
    {
        $this->created_at = new \DateTime();
    
        $this->thumb_url = "http://mlhsite.org/gamma-james/images/thumb.png";
    }

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var integer $sequence_index
     */
    private $sequence_index;

    /**
     * @var array $attr
     */
    private $attr;

    /**
     * @var string $thumb_url
     */
    private $thumb_url;

    /**
     * @var Zeega\DataBundle\Entity\User
     */
    private $user;

    /**
     * @var Zeega\DataBundle\Entity\Sequence
     */
    private $sequence;

    /**
     * @var Zeega\DataBundle\Entity\Frame
     */
    private $link_up;

    /**
     * @var Zeega\DataBundle\Entity\Frame
     */
    private $link_down;

    /**
     * @var Zeega\DataBundle\Entity\Frame
     */
    private $link_left;

    /**
     * @var Zeega\DataBundle\Entity\Frame
     */
    private $link_right;

    /**
     * @var Zeega\DataBundle\Entity\Layer
     */
    private $layers;

  
    
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
     * Set sequence_index
     *
     * @param integer $sequenceIndex
     */
    public function setSequenceIndex($sequenceIndex)
    {
        $this->sequence_index = $sequenceIndex;
    }

    /**
     * Get sequence_index
     *
     * @return integer 
     */
    public function getSequenceIndex()
    {
        return $this->sequence_index;
    }

    /**
     * Set attr
     *
     * @param array $attr
     */
    public function setAttr($attr)
    {
        $this->attr = $attr;
    }

    /**
     * Get attr
     *
     * @return array 
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * Set thumb_url
     *
     * @param string $thumbUrl
     */
    public function setThumbUrl($thumbUrl)
    {
        $this->thumb_url = $thumbUrl;
    }

    /**
     * Get thumb_url
     *
     * @return string 
     */
    public function getThumbUrl()
    {
        return $this->thumb_url;
    }

    /**
     * Set user
     *
     * @param Zeega\DataBundle\Entity\User $user
     */
    public function setUser(\Zeega\DataBundle\Entity\User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user
     *
     * @return Zeega\DataBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set sequence
     *
     * @param Zeega\DataBundle\Entity\Sequence $sequence
     */
    public function setSequence(\Zeega\DataBundle\Entity\Sequence $sequence)
    {
        $this->sequence = $sequence;
    }

    /**
     * Get sequence
     *
     * @return Zeega\DataBundle\Entity\Sequence 
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Set link_up
     *
     * @param Zeega\DataBundle\Entity\Frame $linkUp
     */
    public function setLinkUp(\Zeega\DataBundle\Entity\Frame $linkUp)
    {
        $this->link_up = $linkUp;
    }

    /**
     * Get link_up
     *
     * @return Zeega\DataBundle\Entity\Frame 
     */
    public function getLinkUp()
    {
        return $this->link_up;
    }

    /**
     * Set link_down
     *
     * @param Zeega\DataBundle\Entity\Frame $linkDown
     */
    public function setLinkDown(\Zeega\DataBundle\Entity\Frame $linkDown)
    {
        $this->link_down = $linkDown;
    }

    /**
     * Get link_down
     *
     * @return Zeega\DataBundle\Entity\Frame 
     */
    public function getLinkDown()
    {
        return $this->link_down;
    }

    /**
     * Set link_left
     *
     * @param Zeega\DataBundle\Entity\Frame $linkLeft
     */
    public function setLinkLeft(\Zeega\DataBundle\Entity\Frame $linkLeft)
    {
        $this->link_left = $linkLeft;
    }

    /**
     * Get link_left
     *
     * @return Zeega\DataBundle\Entity\Frame 
     */
    public function getLinkLeft()
    {
        return $this->link_left;
    }

    /**
     * Set link_right
     *
     * @param Zeega\DataBundle\Entity\Frame $linkRight
     */
    public function setLinkRight(\Zeega\DataBundle\Entity\Frame $linkRight)
    {
        $this->link_right = $linkRight;
    }

    /**
     * Get link_right
     *
     * @return Zeega\DataBundle\Entity\Frame 
     */
    public function getLinkRight()
    {
        return $this->link_right;
    }

    /**
     * Add layers
     *
     * @param Zeega\DataBundle\Entity\Layer $layers
     */
    public function addLayers(\Zeega\DataBundle\Entity\Layer $layers)
    {
        $this->layers[] = $layers;
    }

    /**
     * Get layers
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLayers()
    {
        return $this->layers;
    }

    /**
     * Set layers
     *
     * @param array $layers
     */
    public function setLayers($layers)
    {
        $this->layers = $layers;
    }
}