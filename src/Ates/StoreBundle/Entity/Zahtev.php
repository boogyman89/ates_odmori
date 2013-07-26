<?php
namespace Ates\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="zahtev")
 */
class Zahtev
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
    protected $podnet;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $od;
    
    /**
     * @ORM\Column(type="date")
     */
    protected $do;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $status;
    
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
     * @return Zahtev
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
     * @return Zahtev
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
     * Set podnet
     *
     * @param \DateTime $podnet
     * @return Zahtev
     */
    public function setPodnet($podnet)
    {
        $this->podnet = $podnet;
    
        return $this;
    }

    /**
     * Get podnet
     *
     * @return \DateTime 
     */
    public function getPodnet()
    {
        return $this->podnet;
    }

    /**
     * Set od
     *
     * @param \DateTime $od
     * @return Zahtev
     */
    public function setOd($od)
    {
        $this->od = $od;
    
        return $this;
    }

    /**
     * Get od
     *
     * @return \DateTime 
     */
    public function getOd()
    {
        return $this->od;
    }

    /**
     * Set do
     *
     * @param \DateTime $do
     * @return Zahtev
     */
    public function setDo($do)
    {
        $this->do = $do;
    
        return $this;
    }

    /**
     * Get do
     *
     * @return \DateTime 
     */
    public function getDo()
    {
        return $this->do;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Zahtev
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set pdf
     *
     * @param string $pdf
     * @return Zahtev
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