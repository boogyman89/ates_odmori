<?php
namespace Ates\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="request")
 */
class Request
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
    * @ORM\Column(type="integer")
    */
    protected $id_admin;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $submitted;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $from;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $to;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $state;
    
     /**
     * @ORM\Column(type="string", length=200)
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
     * Set from
     *
     * @param \DateTime $from
     * @return Request
     */
    public function setFrom($from)
    {
        $this->from = $from;
    
        return $this;
    }

    /**
     * Get from
     *
     * @return \DateTime 
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set to
     *
     * @param \DateTime $to
     * @return Request
     */
    public function setTo($to)
    {
        $this->to = $to;
    
        return $this;
    }

    /**
     * Get to
     *
     * @return \DateTime 
     */
    public function getTo()
    {
        return $this->to;
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