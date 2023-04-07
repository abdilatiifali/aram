<?php

/*$mysql_hostname = "Localhost";
$mysql_user = "roadtaxuser";
$mysql_password = "faisal123";
$mysql_database = "roadtax";*/

$mysql_hostname = "Localhost";
$mysql_user = "root";
$mysql_password = "triadpass";
$mysql_database = "roadtax";

$db = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Opps some thing went wrong");
mysql_select_db($mysql_database, $db) or die("Opps some thing went wrong");
mysql_query("set character_set_server='utf8'");
mysql_query("set names 'utf8'");
?>