<?php

$student_id = "201836020137";
$passport = "BN566";
$mysql_servername = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "lrr";
$con = mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);

/// Get type of user from the table users_able_to_signup
$sql_query = "select Type_of_User from users_able_to_signup 
    join user_type ut on ut.ID = users_able_to_signup.user_type_ID
    where Student_ID= $student_id";

$result_query = mysqli_query($con, $sql_query);
$row = mysqli_fetch_row($result_query);
$user_type_query_str =trim(strval($row[0]));



