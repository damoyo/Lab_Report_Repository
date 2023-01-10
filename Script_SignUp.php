<?php
/** @noinspection ALL */
session_start();
include 'NoDirectPhpAcess.php';
include_once "get_mysql_credentials.php";
date_default_timezone_set('Asia/Shanghai');
error_reporting(E_ALL); //as suggested by others add error logging
ini_set('display_errors',1); //and debugging to tell you info.
/*
 * This file contains the main Server-side scripts for the project.
 */


// #### FUNCTION CHECK FILE TYPES ////

// Check if student ID numeric, starts with 20 and is 12 digits long return bool
function is_valid_student_number($student_id): bool
{
    if (strlen($student_id) >= 12  && is_numeric($student_id) && str_starts_with($student_id, "20"))
        return TRUE;
    return FALSE;
}

// ############################### SIGN UP ##################################
if (!empty($_POST["form_signup"])) {
    // remove any special characters that may interfere with the query operations for user ID and remove whitespaces.
    $student_id = trim(mysqli_real_escape_string($con, $_POST["user_student_id"]));

    // check if it is a validated student number
    if (!is_valid_student_number($student_id)) {
        $_SESSION["info_signup"] = "Invalid Student Number.";
        header("Location: signup.php");
        return;
    }

    // Check if this student number is allowed to register in the database
    $sql_check = "SELECT * FROM users_able_to_signup WHERE Student_ID= $student_id";

    $result = mysqli_query($con, $sql_check);
    if (mysqli_num_rows($result) == 0) {
        $_SESSION["info_signup"] = "Your entered student number could not be verified.  Please contact Student Management Office <lanhui at zjnu.edu.cn>.  Thanks.";
        header("Location: signup.php");
        return;
    }


    // Check if the student number isn't already registered
    $sql_check = "SELECT * FROM users_table WHERE Student_ID= $student_id";
    $student_result = mysqli_query($con, $sql_check);
    if (mysqli_num_rows($student_result) > 0) {
        $_SESSION["info_signup"] = "This Student ID is already in use! Please contact Student Management Office <lanhui at zjnu.edu.cn> for help.";
        header("Location: signup.php");
        return;
    }



}

// ############################### CREATE STUDENT USER ##################################
if (!empty($_POST["form_signup"])) {
    $fullname = mysqli_real_escape_string($con, $_POST["fullname"]);
    $student_id = mysqli_real_escape_string($con, $_POST["user_student_id"]);
    $email = mysqli_real_escape_string($con, $_POST["email"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $confirmpassword = mysqli_real_escape_string($con, $_POST["confirmpassword"]);
    $passport = mysqli_real_escape_string($con, $_POST["passport_info"]);
    $_SESSION['user_fullname'] = $fullname;
    $_SESSION['user_type'] = "Student";
    $_SESSION['user_email'] = $email;
    $_SESSION['user_student_id'] = $student_id;
    $_SESSION['passport_info'] = $passport;

    // check confirmed password
    if (strcasecmp($password, $confirmpassword) != 0) {
        $_SESSION['info_signup'] = "Password confirmation failed.";
        $_SESSION['user_fullname'] = null;  // such that Header.php do not show the header information.
        header("Location: signup.php");
        return;
    }

    // validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['info_signup'] = "Invalid email address.";
        header("Location: signup.php");
        return;
    }

    $upperLetter     = preg_match('@[A-Z]@',    $password);
    $smallLetter     = preg_match('@[a-z]@',    $password);
    $containsDigit   = preg_match('@[0-9]@',    $password);
    $containsSpecial = preg_match('@[^\w]@',    $password);
    $containsAll = $upperLetter && $smallLetter && $containsDigit && $containsSpecial;

    // check for strong password
    if (!$containsAll) {
        $_SESSION['info_signup'] = "Password must have at least characters that include lowercase letters, uppercase letters, numbers and sepcial characters (e.g., !?.,*^).";
        header("Location: signup.php");
        return;
    }

    // check if email is taken
    $result = mysqli_query($con, "SELECT * FROM users_table WHERE email='$email'");
    if(mysqli_num_rows($result) != 0)
    {
        $_SESSION["info_signup"]="Email address ".$email."  is already in use.";
        $_SESSION['user_fullname'] = null;
        header("Location: signup.php");
        return;
    }

    // Check if the passport number is for the student number
    $sql_query = "SELECT Passport_Number FROM users_able_to_signup WHERE Student_ID= $student_id";
    $passport_result = mysqli_query($con, $sql_query);
    $row = mysqli_fetch_row($passport_result);
    $passport_str =trim(strval($row[0]));
    $test = strcasecmp($passport_str, $passport);
    if ($test != 0){
        $_SESSION['info_signup'] = "Passport Details do not match";
        header("Location: signup.php");
        return;
    }

    // apply password_hash()
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users_table (`Email`, `Password`, `Full_Name`, `UserType`, `Student_ID`, `Passport_Number`) VALUES ('$email','$password_hash','$fullname','Student','$student_id', 'BN55')";

    if ($con->query($sql) === TRUE) {
        header("Location: Courses.php");
    } else {
        echo "Something really bad (SQL insertion error) happened during sign up.";
    }
}