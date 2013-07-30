<?php
    namespace Ates\UserBundle\Entity;
    
    use FOS\UserBundle\Model\User as BaseUser;
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity
     * @ORM\Table(name="employee")
     */
    
    class User extends BaseUser
    {
        /**
        * @ORM\Id
        * @ORM\Column(type="integer")
        * @ORM\GeneratedValue(strategy="AUTO")
        */
        protected $id;

        /**
        * @ORM\Column(type="string", length=50, nullable = true)
        */
        protected $first_name;

        /**
        * @ORM\Column(type="string", length=50, nullable = true)
        */
        protected $last_name;

        /**
         * @ORM\Column(type="string", length=20, nullable = true)
         */
        protected $ssn;

        /**
         * @ORM\Column(type="string", length=50, nullable = true)
         */
        protected $address;

        /**
         * @ORM\Column(type="string", length=20, nullable = true)
         */
        protected $phone;

        /**
         * @ORM\Column(type="date", nullable = true)
         */
        protected $date_of_employment;

        /**
         * @ORM\Column(type="integer", nullable = true)
         */
        protected $no_days_off;

        /**
         * @ORM\Column(type="string", length=10, nullable = true)
         */
        protected $role;
        
        
        /**
         * @ORM\Column(type="boolean", nullable = true)
         */
        protected $is_approved;
        
        /**
         * @ORM\Column(type="boolean", nullable = true)
         */
        protected $is_validated;
 

        
    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set ssn
     *
     * @param string $ssn
     * @return User
     */
    public function setSsn($ssn)
    {
        $this->ssn = $ssn;
    
        return $this;
    }

    /**
     * Get ssn
     *
     * @return string 
     */
    public function getSsn()
    {
        return $this->ssn;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set date_of_employment
     *
     * @param \DateTime $dateOfEmployment
     * @return User
     */
    public function setDateOfEmployment($dateOfEmployment)
    {
        $this->date_of_employment = $dateOfEmployment;
    
        return $this;
    }

    /**
     * Get date_of_employment
     *
     * @return \DateTime 
     */
    public function getDateOfEmployment()
    {
        return $this->date_of_employment;
    }


    /**
     * Set no_days_off
     *
     * @param integer $noDaysOff
     * @return User
     */
    public function setNoDaysOff($noDaysOff)
    {
        $this->no_days_off = $noDaysOff;
    
        return $this;
    }

    /**
     * Get no_days_off
     *
     * @return integer 
     */
    public function getNoDaysOff()
    {
        return $this->no_days_off;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set is_approved
     *
     * @param \bool $isApproved
     * @return User
     */
    public function setIsApproved(\bool $isApproved)
    {
        $this->is_approved = $isApproved;
    
        return $this;
    }

    /**
     * Get is_approved
     *
     * @return \bool 
     */
    public function getIsApproved()
    {
        return $this->is_approved;
    }

    /**
     * Set is_validated
     *
     * @param \bool $isValidated
     * @return User
     */
    public function setIsValidated(\bool $isValidated)
    {
        $this->is_validated = $isValidated;
    
        return $this;
    }

    /**
     * Get is_validated
     *
     * @return \bool 
     */
    public function getIsValidated()
    {
        return $this->is_validated;
    }
}