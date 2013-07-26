<?php
    namespace Ates\StoreBundle\Entity;
    
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="korisnik")
     */
    
    class Korisnik
    {
        /**
        * @ORM\Id
        * @ORM\Column(type="integer")
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        protected $id;

        /**
        * @ORM\Column(type="string", length=50)
        */
        protected $ime;

        /**
        * @ORM\Column(type="string", length=50)
        */
        protected $prezime;

        /**
         * @ORM\Column(type="string", length=20)
         */
        protected $jmbg;

        /**
         * @ORM\Column(type="string", length=50)
         */
        protected $adresa;

        /**
         * @ORM\Column(type="string", length=20)
         */
        protected $telefon;

        /**
         * @ORM\Column(type="date")
         */
        protected $pocetak_rada;

        /**
         * @ORM\Column(type="string", length=30)
         */
        protected $email;

        /**
         * @ORM\Column(type="integer")
         */
        protected $br_slobodnih_dana;

        /**
         * @ORM\Column(type="string", length=10)
         */
        protected $privilegija;
        
        /**
         * @ORM\Column(type="string", length=30)
         */
        protected $sifra;
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
     * Set ime
     *
     * @param string $ime
     * @return Korisnik
     */
    public function setIme($ime)
    {
        $this->ime = $ime;
    
        return $this;
    }

    /**
     * Get ime
     *
     * @return string 
     */
    public function getIme()
    {
        return $this->ime;
    }

    /**
     * Set prezime
     *
     * @param string $prezime
     * @return Korisnik
     */
    public function setPrezime($prezime)
    {
        $this->prezime = $prezime;
    
        return $this;
    }

    /**
     * Get prezime
     *
     * @return string 
     */
    public function getPrezime()
    {
        return $this->prezime;
    }

    /**
     * Set jmbg
     *
     * @param string $jmbg
     * @return Korisnik
     */
    public function setJmbg($jmbg)
    {
        $this->jmbg = $jmbg;
    
        return $this;
    }

    /**
     * Get jmbg
     *
     * @return string 
     */
    public function getJmbg()
    {
        return $this->jmbg;
    }

    /**
     * Set adresa
     *
     * @param string $adresa
     * @return Korisnik
     */
    public function setAdresa($adresa)
    {
        $this->adresa = $adresa;
    
        return $this;
    }

    /**
     * Get adresa
     *
     * @return string 
     */
    public function getAdresa()
    {
        return $this->adresa;
    }

    /**
     * Set telefon
     *
     * @param string $telefon
     * @return Korisnik
     */
    public function setTelefon($telefon)
    {
        $this->telefon = $telefon;
    
        return $this;
    }

    /**
     * Get telefon
     *
     * @return string 
     */
    public function getTelefon()
    {
        return $this->telefon;
    }

    /**
     * Set pocetak_rada
     *
     * @param \DateTime $pocetakRada
     * @return Korisnik
     */
    public function setPocetakRada($pocetakRada)
    {
        $this->pocetak_rada = $pocetakRada;
    
        return $this;
    }

    /**
     * Get pocetak_rada
     *
     * @return \DateTime 
     */
    public function getPocetakRada()
    {
        return $this->pocetak_rada;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Korisnik
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set br_slobodnih_dana
     *
     * @param integer $brSlobodnihDana
     * @return Korisnik
     */
    public function setBrSlobodnihDana($brSlobodnihDana)
    {
        $this->br_slobodnih_dana = $brSlobodnihDana;
    
        return $this;
    }

    /**
     * Get br_slobodnih_dana
     *
     * @return integer 
     */
    public function getBrSlobodnihDana()
    {
        return $this->br_slobodnih_dana;
    }

    /**
     * Set privilegija
     *
     * @param string $privilegija
     * @return Korisnik
     */
    public function setPrivilegija($privilegija)
    {
        $this->privilegija = $privilegija;
    
        return $this;
    }

    /**
     * Get privilegija
     *
     * @return string 
     */
    public function getPrivilegija()
    {
        return $this->privilegija;
    }

    /**
     * Set sifra
     *
     * @param string $sifra
     * @return Korisnik
     */
    public function setSifra($sifra)
    {
        $this->sifra = $sifra;
    
        return $this;
    }

    /**
     * Get sifra
     *
     * @return string 
     */
    public function getSifra()
    {
        return $this->sifra;
    }
}