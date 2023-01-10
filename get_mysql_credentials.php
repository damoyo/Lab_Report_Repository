<?php

$mysql_servername = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "lrr";
$con = mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);

//Check database
if (mysqli_connect_errno()) {
    echo "Database connection failed.";
}


