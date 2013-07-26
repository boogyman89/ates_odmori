<?php
    namespace Ates\StoreBundle\Entity;
    
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="privremeni_korisnik")
     */
    
    class PrivremeniKorisnik
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
     * @return PrivremeniKorisnik
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
     * @return PrivremeniKorisnik
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
     * @return PrivremeniKorisnik
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
     * @return PrivremeniKorisnik
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
     * @return PrivremeniKorisnik
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
     * @return PrivremeniKorisnik
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
     * @return PrivremeniKorisnik
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
     * Set sifra
     *
     * @param string $sifra
     * @return PrivremeniKorisnik
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