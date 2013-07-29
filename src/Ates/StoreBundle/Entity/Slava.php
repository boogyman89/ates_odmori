<?php
namespace Ates\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="slava")
 */
class Slava
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
    * @ORM\Column(type="date")
    */
    protected $date;


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
     * @return Slava
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
     * Set date
     *
     * @param \DateTime $date
     * @return Slava
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
}