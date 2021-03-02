<?php

class Premium extends Member
{
   private $_indoorInterests;
   private $_outdoorInterests;

    /**
     * Get indoor interests
     * @return array
     */
    public function getIndoorInterests()
    {
        return $this->_indoorInterests;
    }

    /**
     * set indoor interests
     * @param array $indoorInterests
     */
    public function setIndoorInterests($indoorInterests)
    {
        $this->_indoorInterests = $indoorInterests;
    }

    /**
     * get outdoor interests
     * @return array
     */
    public function getOutdoorInterests()
    {
        return $this->_outdoorInterests;
    }

    /**
     * set outdoor interests
     * @param array $outdoorInterests
     */
    public function setOutdoorInterests($outdoorInterests)
    {
        $this->_outdoorInterests = $outdoorInterests;
    }



}