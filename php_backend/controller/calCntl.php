<?php
/**
 * File to handle data returns
 *
 * @author <jjbernitt@gmail.com> Josh Bernitt
 *
 * File handles calls from the angularjs app frontend and returns the gathered data from the server as json
 * data
 */
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once("../model/calModel.php");
// test if the update call was made and gather the appropriate resources and return the data
if ($_POST['update'] == true) {
    //echo json_encode(false); exit;
    $data = gatherData($mysqli, $theMessage);
    if ($data === false) {
        echo json_encode($theMessage);
        die (false);
    }
    echo json_encode($data);
}

/**
 * Internal function for calCntl.php. This function gathers all the data necessary for the dash board
 * and formats it in the expected way before passing it back to the dash board. If there is an error in the
 * retrieval then false is returned.
 *
 * @param $mysqli MySQL object for performing the query with
 * @param $theMessage Message that will contain the callback
 * @return array|bool Returns an array of work orders and their associated data or false if there was an error
 */
function gatherData (&$mysqli, &$theMessage) {
    $calendarData = new calModel();
    $calendarData->pullData();
    return $calendarData->dumpJSON();
}
