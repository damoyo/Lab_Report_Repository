<?php
  $page='Home';
  require 'Header.php';
  session_start();
?>

<?php
  // if the user has already logged in, then clicking the LRRS icon should not display the login page (i.e., index.php).
if (isset($_SESSION["user_fullname"])) {
    header("Location: Courses.php");
}
?>
<!--Container for the logo label and Signup Form split into two 6columns-->
<div class ="container">
    <div class="row">
        <!--Divide the page by 6 columns for the first section-->
        <div class="col">

            <!---Index Page Logo and Labeling on the left hand side -->
            <section class="logolabel">
                <div>
                    <img src="logo.png"  alt="LRR Logo">
                </div>
                <div>
                    <h1 class="lrrwordlog">Lab Report Repository</h1>
                </div>
            </section>
        </div>

        <!--Divide the page by 6 columns for the last section-->
        <div class="col">

            <!--Index Page Signup form on the right hand side-->
            <section class="signup-form">
                <h4 class="list-group-item active"> Sign in </h4>
                <div class="list-group-item">
                    <div class="panel-body">
                        <form method="post" action="Script.php" name="frm_login">
                            <input type="hidden" name="frm_login" value="true"/>
                            <label>Student ID / Instructor Email</label>
                            <input type="text" name="user" placeholder="Email / Student Number" class="form-control" required="required" id="user_name" />
                            <label>Password</label>
                            <input type="password" class="form-control"  name="password" placeholder="password" required="required" id="user_password" />
                            <div class="text-center">
                                <button type="submit" class="btn-primary" name="Login" id="login_btn" style="margin: 20px">Login</button>
                                <label> <!---Warning labels-->
                                    <?php
                                    // wrong pass
                                    if(isset($_SESSION['wrong_pass'])) {
                                        echo  '<hr><div class="alert alert-danger" role="alert">'.$_SESSION['wrong_pass'].'</div>';
                                        $_SESSION['wrong_pass']=null;
                                    }

                                    error_reporting(E_ALL);
                                    if(isset($_SESSION['info_login'])) {
                                        echo  '<hr><div class="alert alert-danger" role="alert">'.$_SESSION['info_login'].'</div>';
                                        $_SESSION['info_login']=null;
                                    }

                                    if(isset($_SESSION['infoChangePassword'])) {
                                        echo  '<hr><div class="alert alert-danger" role="alert">'.$_SESSION['infoChangePassword'].'</div>';
                                        $_SESSION['infoChangePassword']=null;
                                    }
                                    ?>
                                </label>

                            </div>

                            <label class="footer" href="recover_password.php" ">Reset my password</label>
                            <div class="text-center">
                                <br><span class="txt1">Don't have an account?</span>
                                <a class="txt2" href="signup.php" style="font-weight:normal" id="signup_link">Sign Up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>






    <?php

    ?>
      



<div id="footer">
    LRR was originally developed as a <a href="http://lanlab.org/course/2018f/se/homepage.html" style="color:white;">software engineering course project</a> by Mohamed Nor and Elmahdi Houzi.  Please submit your suggestions or bug reports to  lanhui.  Last updated on 18/04/2020 by Ashly. <a href="./homepage" style="color:white;">More information ...</a>
    </div>

</div>