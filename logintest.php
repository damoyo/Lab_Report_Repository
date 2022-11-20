<?php
include 'Tester.php';
$username = 'admin@qq.com';
$password = '123';

if (!empty($_POST["frm_login"])) {
    var_dump($_POST);
    $user = mysqli_real_escape_string($con, $_POST["user"]); // user could be a 12-digit student number or an email address
    $is_student_number = 0;

    // Validate student number
    if (is_valid_student_number($user)) {
        $is_student_number = 1;
    }

    // Validate email address if what provided is not a student number
    if (!$is_student_number && !filter_var($user, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["info_login"] = "Invalid email address: " . "$user";
        header("Location: index.php");
        return;
    }

    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $result = mysqli_query($con, "SELECT * FROM users_table WHERE (Student_ID='$user') OR (Email='$user')");
    if (mysqli_num_rows($result) == 0) {
        $_SESSION["info_login"] = "Inavlid user name information.";
        echo $_SESSION["info_login"];
        header("Location: index.php");
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            //  verify the hashed password and unhashed password
            $sha512pass = hash('sha512', $password); // for backward compatibility.  Old passwords were hashed using SHA512 algorithm.
            if (password_verify($password, $row["Password"]) or $sha512pass == $row["HashPassword"]) {

                $_SESSION['user_id'] = $row['User_ID'];
                $_SESSION['user_email'] = $row['Email'];
                $_SESSION['user_student_id'] = $row['Student_ID'];
                $_SESSION['user_type'] = $row['UserType'];
                $_SESSION['user_fullname'] = $row['Full_Name'];

                if ($_SESSION['user_type'] == "Student") {
                    header("Location: Courses.php");
                }

                if ($_SESSION['user_type'] == "Lecturer") {
                    header("Location: Courses.php");
                }

                if ($_SESSION['user_type'] == "TA") {
                    header("Location: Courses.php");
                }

                if ($_SESSION['user_type'] == "Admin") {
                    header("Location: Admin.php");
                }
                //  report wrong pass if not correct
            } else {
                $_SESSION["wrong_pass"] = "Wrong Password.";
                header("Location: index.php");
            }
        }
    }
}
