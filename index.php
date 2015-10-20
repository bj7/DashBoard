<?php
/**
 * User: joshuabernitt
 * Date: 12/4/13
 * Time: 5:07 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
/**
 * practice generic file for include
 */
include ('./calBootStrap.inc');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dashboard</title>
    </head>
    <body>
        <iframe src="<?echo $main_view; ?>" width="100%" height="100%"></iframe>
    </body>
</html>
