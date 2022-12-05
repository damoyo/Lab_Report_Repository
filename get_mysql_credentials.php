<?php

$mysql_servername = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "lrr";
$con = mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
//Exception Handling for any database errors
try
{
    $con = mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);
    echo "Success";
    }


catch(Exception $e)
{
    echo $e->getMessage();
}

?>
