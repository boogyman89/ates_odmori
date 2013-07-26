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
    protected $id_korisnik;
    
    /**
    * @ORM\Column(type="date")
    */
    protected $datum;

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
     * Set id_korisnik
     *
     * @param integer $idKorisnik
     * @return Slava
     */
    public function setIdKorisnik($idKorisnik)
    {
        $this->id_korisnik = $idKorisnik;
    
        return $this;
    }

    /**
     * Get id_korisnik
     *
     * @return integer 
     */
    public function getIdKorisnik()
    {
        return $this->id_korisnik;
    }

    /**
     * Set datum
     *
     * @param \DateTime $datum
     * @return Slava
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
}