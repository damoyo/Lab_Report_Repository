<?php
/** @noinspection ALL */
session_start();
include 'NoDirectPhpAccess.php';
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

// ############################### Validate Student ID ##################################
if (!empty($_POST["form_signup"])) {
    // remove any special characters that may interfere with the query operations for user ID and remove whitespaces.
    $student_id = trim(mysqli_real_escape_string($con, $_POST["user_student_id"]));

    // check if it is a validated student number
    if (!is_valid_student_number($student_id)) {
        $_SESSION["info_signup"] = "Invalid Student Number.";
        header("Location: signup.php");
        return;
    }

    // Check if this student number is allowed to register according to the list
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

// ############################### CREATE USER According to the list ##################################
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
    if (strcmp($password, $confirmpassword) != 0) {
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

    $upperLetter     = preg_match('@[A-Z]@',    $password); //Have a capital letter
    $smallLetter     = preg_match('@[a-z]@',    $password); //Have a small letter
    $containsDigit   = preg_match('@[0-9]@',    $password); //Have a number
    $containsSpecial = preg_match('@[^\w]@',    $password); //Have a special character
    $containsAll = $upperLetter && $smallLetter && $containsDigit && $containsSpecial;

    // check if password contains all requirements Se!1 for example
    if (!$containsAll) {
        $_SESSION['info_signup'] = "Password must have at least a lowercase letter, uppercase letter, a numbers and a special character (e.g., !?.,*^).";
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

    // Check if the passport number is for the student number according to the list
    $sql_query = "SELECT Passport_Number FROM users_able_to_signup WHERE Student_ID= $student_id";
    $passport_result = mysqli_query($con, $sql_query);
    $row = mysqli_fetch_row($passport_result);
    $passport_str =trim(strval($row[0]));
    $test = strcasecmp($passport_str, $passport); //returns zero when they match
    if ($test != 0){
        $_SESSION['info_signup'] = "Passport Details do not match";
        header("Location: signup.php");
        return;
    }

    /// Get type of user from the table users_able_to_signup
    $sql_query = "select Type_of_User from users_able_to_signup 
    join user_type ut on ut.ID = users_able_to_signup.user_type_ID
    where Student_ID= $student_id";

    $result_query = mysqli_query($con, $sql_query);
    $row = mysqli_fetch_row($result_query);
    $user_type_query_str =trim(strval($row[0]));

    // apply password_hash()
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users_table (`Email`, `Password`, `Full_Name`, `UserType`, `Student_ID`, `Passport_Number`) VALUES ('$email','$password_hash','$fullname','$user_type_query_str','$student_id', '$passport_str')";

    if ($con->query($sql) === TRUE) {
        header("Location: Courses.php");
    } else {
        echo "Something really bad (SQL insertion error) happened during sign up.";
    }
}