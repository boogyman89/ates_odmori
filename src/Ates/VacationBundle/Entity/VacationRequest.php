<?php
namespace Ates\VacationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Ates\VacationBundle\Entity\VacationRequestRepository")
 * @ORM\Table(name="request")
 */
class VacationRequest
{
    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;
    
    /**
    * @ORM\Column(type="integer")
    */
    protected $id_user;
    
    /**
    * @ORM\Column(type="integer", nullable = true)
    */
    protected $id_admin;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $submitted;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $start_date;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $end_date;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $state;
    
     /**
     * @ORM\Column(type="string", length=200, nullable = true)
     */
    protected $pdf;
    
    

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
     * Set id_user
     *
     * @param integer $idUser
     * @return Request
     */
    public function setIdUser($idUser)
    {
        $this->id_user = $idUser;
    
        return $this;
    }

    /**
     * Get id_user
     *
     * @return integer 
     */
    public function getIdUser()
    {
        return $this->id_user;
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
     * Set state
     *
     * @param string $state
     * @return Request
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set pdf
     *
     * @param string $pdf
     * @return Request
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
    
        return $this;
    }

    /**
     * Get pdf
     *
     * @return string 
     */
    public function getPdf()
    {
        return $this->pdf;
    }
}