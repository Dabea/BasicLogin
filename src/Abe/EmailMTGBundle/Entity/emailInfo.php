<?php

namespace Abe\EmailMTGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * email_info
 *
 * @ORM\Table("email_info")
 * @ORM\Entity(repositoryClass="Abe\EmailMTGBundle\Entity\emailInfoRepository")
 */
class emailInfo
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
     * @var \DateTime
     *
     * @ORM\Column(name="time_recived", type="datetimetz")
     */
    private $timeRecived;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_completed", type="datetime")
     */
    private $timeCompleted;

    /**
     * @var string
     *
     * @ORM\Column(name="completed_by", type="string", length=255)
     */
    private $completedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="header", type="text")
     */
    private $header;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="sender", type="string", length=255)
     */
    private $sender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_taken", type="datetime")
     */
    private $timeTaken;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="complete", type="boolean")
     */
    private $complete;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dumped", type="boolean")
     */
    private $dumped;


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
     * Set timeRecived
     *
     * @param \DateTime $timeRecived
     * @return email_info
     */
    public function setTimeRecived($timeRecived)
    {
        $this->timeRecived = $timeRecived;
    
        return $this;
    }

    /**
     * Get timeRecived
     *
     * @return \DateTime 
     */
    public function getTimeRecived()
    {
        return $this->timeRecived;
    }

    /**
     * Set timeCompleted
     *
     * @param \DateTime $timeCompleted
     * @return email_info
     */
    public function setTimeCompleted($timeCompleted)
    {
        $this->timeCompleted = $timeCompleted;
    
        return $this;
    }

    /**
     * Get timeCompleted
     *
     * @return \DateTime 
     */
    public function getTimeCompleted()
    {
        return $this->timeCompleted;
    }

    /**
     * Set completedBy
     *
     * @param string $completedBy
     * @return email_info
     */
    public function setCompletedBy($completedBy)
    {
        $this->completedBy = $completedBy;
    
        return $this;
    }

    /**
     * Get completedBy
     *
     * @return string 
     */
    public function getCompletedBy()
    {
        return $this->completedBy;
    }

    /**
     * Set header
     *
     * @param string $header
     * @return email_info
     */
    public function setHeader($header)
    {
        $this->header = $header;
    
        return $this;
    }

    /**
     * Get header
     *
     * @return string 
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return email_info
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set sender
     *
     * @param string $sender
     * @return email_info
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    
        return $this;
    }

    /**
     * Get sender
     *
     * @return string 
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set timeTaken
     *
     * @param \DateTime $timeTaken
     * @return email_info
     */
    public function setTimeTaken($timeTaken)
    {
        $this->timeTaken = $timeTaken;
    
        return $this;
    }

    /**
     * Get timeTaken
     *
     * @return \DateTime 
     */
    public function getTimeTaken()
    {
        return $this->timeTaken;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return email_info
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set complete
     *
     * @param boolean $complete
     * @return email_info
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
    
        return $this;
    }

    /**
     * Get complete
     *
     * @return boolean 
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * Set dumped
     *
     * @param boolean $dumped
     * @return email_info
     */
    public function setDumped($dumped)
    {
        $this->dumped = $dumped;
    
        return $this;
    }

    /**
     * Get dumped
     *
     * @return boolean 
     */
    public function getDumped()
    {
        return $this->dumped;
    }
}
