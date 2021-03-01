<?php

class Member
{
    private $_lname;
    private $_fname;
    private $_age;
    private $_gender;
    private $_phone;
    private $_email;
    private $_state;
    private $_seeking;
    private $_bio;

    function __construct($fname, $lname, $age, $gender, $phone)
    {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_age = $age;
        $this->_gender = $gender;
        $this->_phone = $phone;
    }

    /**
     * Getter for Last name
     * @return String
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * setter for last name
     * @param String $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * getter for first namae
     * @return String
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * Setter for first name
     * @param String $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * Getter for age
     * @return int
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * Set age
     * @param int $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

    /**
     * Get the gender
     * @return string
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * Set the gender
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * Get phone number
     * @return mixed
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Set phone number
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Get the email
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * set email
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * get the state
     * @return string
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * set the state
     * @param string $state
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * get seeking
     * @return string
     */
    public function getSeeking()
    {
        return $this->_seeking;
    }

    /**
     * set seeking
     * @param string $seeking
     */
    public function setSeeking($seeking)
    {
        $this->_seeking = $seeking;
    }

    /**
     * get the bio
     * @return string
     */
    public function getBio()
    {
        return $this->_bio;
    }

    /**
     * set the bio
     * @param string $bio
     */
    public function setBio($bio)
    {
        $this->_bio = $bio;
    }


}