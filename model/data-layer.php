<?php
/* model/validate.php
*returns data for my app
 *
*/

class PDataLayer
{
    function getIndoorInterests()
    {
        return array("tv", "grooming", "sleeping", "snuggles",
            "treats", "training", "window watching", "hide-n-seek");
    }

    function getOutdoorInterests()
    {
        return array("fetch", "biking", "chases", "walks",
            "sunbathing", "swimming", "tug-o-war");
    }

    function getGender()
    {
        return array("male", "female");
    }

    function getStates()
    {
        return array("Washington", "California", "Oregon");
    }
}