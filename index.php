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

$root_path = './';
$main_view = $root_path."front_end/view/main_view.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?
    require_once($main_view);
?>
</body>
</html>