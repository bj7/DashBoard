<?php
/**
 * User: joshuabernitt
 * Date: 12/7/13
 * Time: 6:59 PM
 */

$SName = md5 ( "Gary Anderson LLC Mechanical Services" );
session_name ( $SName );
session_start ();
if (ini_get ( 'register_globals' )) {
    foreach ( $_SESSION as $key => $value ) {
        if (isset ( $GLOBALS [$key] ))
            unset ( $GLOBALS [$key] );
    }
}

$root_path = './';
$main_view = $root_path."front_end/view/main_view.php";
