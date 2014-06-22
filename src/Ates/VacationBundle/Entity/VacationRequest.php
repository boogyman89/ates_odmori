<?php
namespace Ates\VacationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Ates\VacationBundle\Entity\VacationRequestRepository")
 * @ORM\Table(name="request")
 */
class VacationRequest
{
    const PENDING = 1;
    const APPROVED = 2;
    const REJECTED = 3;
    
    
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
    * @ORM\ManyToOne(targetEntity="Ates\UserBundle\Entity\User", inversedBy="vacation_requests")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id") 
    */
    protected $user;
    
    /**
    * @ORM\Column(type="integer", nullable = true)
    */
    protected $id_admin;
    
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(name="updated", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $start_date;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $end_date;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $state;
    
    /**
     * @ORM\Column(type="string", length=300)
     */
    protected $comment;
    
    /**
     * @ORM\Column(type="integer", nullable = true)
     */
    protected $number_of_working_days;
    
    public function __construct()
    {
        $this->state = VacationRequest::PENDING;
    }
    
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
     * Set id_admin
     *
     * @param integer $idAdmin
     * @return Request
     */
    public function setIdAdmin($idAdmin)
    {
        $this->id_admin = $idAdmin;
    
        return $this;
    }

    /**
     * Get id_admin
     *
     * @return integer 
     */
    public function getIdAdmin()
    {
        return $this->id_admin;
    }

    /**
     * Set submitted
     *
     * @param \DateTime $submitted
     * @return Request
     */
    public function setSubmitted($submitted)
    {
        $this->submitted = $submitted;
    
        return $this;
    }

    /**
     * Get submitted
     *
     * @return \DateTime 
     */
    public function getSubmitted()
    {
        return $this->submitted;
    }

    /**
     * Set start_date
     *
     * @param \DateTime $start_date
     * @return Request
     */
    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    
        return $this;
    }

    /**
     * Get start_date
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Set end_date
     *
     * @param \DateTime $end_date
     * @return Request
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    
        return $this;
    }

    /**
     * Get end_date
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * Set edit_time
     *
     * @param \DateTime $editTime
     * @return VacationRequest
     */
    public function setEditTime($editTime)
    {
        $this->edit_time = $editTime;
    
        return $this;
    }

    /**
     * Get edit_time
     *
     * @return \DateTime 
     */
    public function getEditTime()
    {
        return $this->edit_time;
    }

    /**
     * Set user
     *
     * @param \Ates\UserBundle\Entity\User $user
     * @return VacationRequest
     */
    public function setUser(\Ates\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Ates\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return VacationRequest
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return VacationRequest
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return VacationRequest
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    
        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set numberOfWorkingDays
     *
     * @param integer $numberOfWorkingDays
     * @return VacationRequest
     */
    public function setNumberOfWorkingDays($numberOfWorkingDays)
    {
        $this->number_of_working_days = $numberOfWorkingDays;
    
        return $this;
    }

    /**
     * Get numberOfWorkingDays
     *
     * @return integer 
     */
    public function getNumberOfWorkingDays()
    {
        return $this->number_of_working_days;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return VacationRequest
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }
}