<?php

//contains validation functions
class Validate
{
    private  $_dataLayer;
    function __construct()
    {
        $this->_dataLayer = $dataLayer;
    };

    /** validName() returns true if Name is not empty
     * * @param $name string name
     * @return bool valid name
     */
    function validName($name)
    {
        return !empty($name && ctype_alpha($name));
    }

    /**validAge returns true if age is between 18 and 118
     * @param $age numeric age
     * @return bool valid age
     */
    function validAge($age)
    {
        return ($age > 17 && $age <= 118);
    }

    /** validPhone returns true if phone is only numbers and is 9 characters long
     * @param $phone string phone number
     * @return bool valid number
     */
    function validPhone($phone)
    {
        if (strlen($phone) == 10) {
            return is_numeric($phone);
        }
        return false;
    }

    /** validEmail returns true if email contains @ and .
     * @param $email string
     * @return bool
     */
    function validEmail($email)
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        return (filter_var($email, FILTER_VALIDATE_EMAIL));

    }

    /** validOutdoor checks each selected outdoor interest against a list of valid options
     * * @param $selected
     * @return bool
     */
    function validOutdoor($selected)
    {

        $validOutside = getOutdoorInterests();
        foreach ($selected as $outdoor) {
            if (!(in_array($outdoor, $validOutside))) {
                return false;
            }
        }
        return true;
    }

    /** validIndoor checks each selected indoor interest against a list of valid options
     * * @param $selected
     * @return bool
     */
    function validIndoor($selected)
    {
        $validIndoor = getIndoorInterests();
        foreach ($selected as $indoor) {
            if (!(in_array($indoor, $validIndoor))) {
                return false;
            }
        }
        return true;
    }

    /** validGender returns true if the selected gender is in the list of valid options
     * @param $selected string
     * @return bool
     */
    function validGender($selected)
    {
        $validGender = getGender();
        return (in_array($selected, $validGender));
    }

    /** validState returns true if the selected state is in the list of valid options
     * @param $selected string the selected state
     * @return bool
     */
    function validState($selected)
    {
        $validState = getStates();
        return (in_array($selected, $validState));
    }
}