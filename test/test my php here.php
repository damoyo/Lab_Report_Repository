<?php

$student_id = "201836020137";
$passport = "BN566";
$mysql_servername = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "lrr";
$con = mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database);

/// Check if the passport number is for the student number
$sql_query = "SELECT Passport_Number FROM users_able_to_signup WHERE Student_ID= $student_id";
$passport_result = mysqli_query($con, $sql_query);
$row = mysqli_fetch_row($passport_result);
$passport_str =trim(strval($row[0]));
$test = strcasecmp($passport_str, $passport);
if ($test != 0){
    $_SESSION['info_signup'] = "Passport Details do not match";
    $_SESSION['user_fullname'] = null;  //
    header("Location: signup.php");
    return;
}


