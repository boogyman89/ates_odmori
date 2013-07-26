<?php
namespace Ates\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="neradni_dani")
 */
class NeradniDani
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
    protected $id_admin;
    
    /**
    * @ORM\Column(type="date")
    */
    protected $datum;
    
   /**
     * @ORM\Column(type="string", length=100)
     */
    protected $naziv;

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
     * Set datum
     *
     * @param \DateTime $datum
     * @return NeradniDani
     */
    public function setDatum($datum)
    {
        $this->datum = $datum;
    
        return $this;
    }

    /**
     * Get datum
     *
     * @return \DateTime 
     */
    public function getDatum()
    {
        return $this->datum;
    }

    /**
     * Set id_admin
     *
     * @param integer $idAdmin
     * @return NeradniDani
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
     * Set naziv
     *
     * @param string $naziv
     * @return NeradniDani
     */
    public function setNaziv($naziv)
    {
        $this->naziv = $naziv;
    
        return $this;
    }

    /**
     * Get naziv
     *
     * @return string 
     */
    public function getNaziv()
    {
        return $this->naziv;
    }
}