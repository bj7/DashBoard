<?php
/**
 * User: joshuabernitt
 * Date: 12/7/13
 * Time: 1:34 PM
 */

/**
 * Class calModel Class for storing information about events on the calendar.
 */
class calModel {
    private $event_name = '';
    private $day = '';
    private $start = '';
    private $end = '';
    private $invites = array ();
    private $conflicts = array();
    private $tasks = array();

    /**
     * constructor
     *
     * @access public
     * @param $data_array Array containing all the data necessary to instantiate an object
     *
     * Simple constructor method that accepts input to create the object
     */
    function __construct () {
        $this->event_name   = 'Default';
        $this->day          = 'Sunday';
        $this->start        = '12:00:00';
        $this->end          = '12:00:00';
        $this->invites      = 'NA';
        $this->conflicts    = 'None';
        $this->tasks      = 'None';
    }

    /**
     * Function to fetch data from the server
     * @return bool Return true on successfull data pull
     */
    public function pullData () {
        if (true /*db_pull*/) {
            //code to assign variables the data
            return true;
        } else {
            return false;
        }
    }
    // setter methods
    public function setEventName ($name) {
        $this->event_name = $name;
    }

    public function setDay ($day) {
        $this->day = $day;
    }

    public function setStartTime ($time) {
        $this->start = $time;
    }

    public function setEndTime ($time) {
        $this->end = $time;
    }

    public function setInvites ($invites) {
        for ($i = 0; $i < sizeof($invites); $i++) {
            $this->invites[$i] = $invites[$i];
        }
    }

    public function setconflicts ($issues) {
        for ($i = 0; $i < sizeof($issues); $i++) {
            $this->conflicts[$i] = $issues[$i];
        }
    }

    public function settasks ($WOs) {
        for ($i = 0; $i < sizeof($WOs); $i++) {
            $this->tasks[$i] = $WOs[$i];
        }
    }

    // getter methods
    public function getEventName () {
        return $this->event_name;
    }

    public function getDay () {
        return $this->day;
    }

    public function getStartTime () {
        return $this->start;
    }

    public function getEndTime () {
        return $this->end;
    }

    public function getInvites () {
        return $this->invites;
    }

    public function getconflicts () {
        return $this->conflicts;
    }

    public function gettasks () {
        return $this->tasks;
    }

    /**
     * returns a dump of the object in an array for json encoding
     *
     * @access public
     * @return array $json_format Array formatted so it creates proper json for the front end once encoded,
     *
     * Puts everything into an array that once encoded will result in the JSON format expected by the javascript on
     * the front end.
     */
    public function dumpJSON () {
        $json_format = array(0 => array('eventName' => $this->event_name, 'day' => $this->day, 'start' => $this->start,
        'end' => $this->end, 'invites' => $this->invites),1 => array('conflicts' => $this->conflicts, 'tasks' => $this->tasks));
        return $json_format;
    }
} 