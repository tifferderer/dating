<?php
/* model/validate.php
*
 *
*/

/**
 * returns data for my app
 * Class PDataLayer
 */
class PDataLayer
{
    /**The indoor interests array
     * @return string[]
     */
    function getIndoorInterests()
    {
        return array("tv", "grooming", "sleeping", "snuggles",
            "treats", "training", "window watching", "hide-n-seek");
    }

    /**
     * get the outdoor interests
     * @return string[]
     */
    function getOutdoorInterests()
    {
        return array("fetch", "biking", "chases", "walks",
            "sunbathing", "swimming", "tug-o-war");
    }

    /**
     * get gender array
     * @return string[]
     */
    function getGender()
    {
        return array("male", "female");
    }

    function getStates()
    {
        return array("Washington", "California", "Oregon");
    }
}