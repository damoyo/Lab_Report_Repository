<?php
include 'NoDirectPhpAccess.php';
include 'Header.php';
?>


<div class="row">

    <div class="col-md-4 list-group" style="margin:auto;">

        <br>

        <h4 class="list-group-item active"> Please fill in each field below </h4>
        <div class="list-group-item">

            <div class="panel-body">

                <form method="post" action="Script_SignUp.php" id="signup_form">
                    <input type="hidden" name="form_signup" value="true" />

                    Full Name
                    <input type="text" name="fullname" placeholder="Your full name" class="form-control" value="<?php echo $_SESSION['user_fullname']; ?>" required="required" id="full_name"/>

                    Student ID
                    <input type="text" name="user_student_id" placeholder="Enter your student ID" class="form-control" value="<?php echo $_SESSION['user_student_id']; ?>" required="required" id="student_id">

                    Email
                    <input type="text" name="email" placeholder="Email" class="form-control" value="<?php echo $_SESSION['user_email']; ?>" required="required" id="email" />

                    Passport
                    <input type="text" name="passport_info" placeholder="Passport" class="form-control" value="<?php echo $_SESSION['passport_info']; ?>" required="required" id="passport" />

                    Password (<i>must include uppercase and lowercase letters, digits and special characters</i>)
                    <input type="password" class="form-control" name="password" placeholder="Enter password" required="required" id="password1" />

                    Confirm Password
                    <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm password" required="required" id="password2" />
                    <br>
                    <input type="submit" class="btn-primary" value="Sign up" id="signup_btn">
                    <?php
                    error_reporting(E_ALL);
                    if (isset($_SESSION['info_signup'])) {
                        echo  '<hr><div class="alert alert-danger" role="alert">' . $_SESSION['info_signup'] . '</div>';
                        $_SESSION['info_signup'] = null;
                    }
                    ?>
                </form>

            </div>
        </div>
    </div>
</div>
