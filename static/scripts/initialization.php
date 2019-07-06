<?php
//Get Organization-Specific Variables
include $_SERVER['DOCUMENT_ROOT'] . "/../Org-Specific-Info/info.php";

//Initialize timezone for all php scripts
date_default_timezone_set($organizationTimeZone);

//Connect to Database
$db_connection = pg_connect("host=localhost dbname=$database user=$dbuser password=$dbpassword");

//Load custom functions
include $_SERVER['DOCUMENT_ROOT'] . "/static/scripts/functions.php";


?>
