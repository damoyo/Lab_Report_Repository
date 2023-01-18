<?php
include 'NoDirectPhpAccess.php';
include 'Header.php';
?>

<div class="row">
  <div class="col-md-4 list-group" style="margin:auto; padding: 30px;">
  <h4 class="list-group-item active"> Reset my password </h4>
    <div class="list-group-item">
      <div class="panel-body">
          <form method="post" action="Script.php">
                <input type="hidden" name="frm_recover_password" value="true"/>
                <label for = "Student Number">Student number</label>
                <input type="text" name="sno" placeholder="Enter your student number" class="form-control" required="required" value="<?php echo $_SESSION['student_number']; ?>">
                <label>Email</label>
                <input type="text" name="email" placeholder="Enter your email address" class="form-control" required="required" value="<?php echo $_SESSION['user_email']; ?>">
              <div class="text-center">
                  <button  type="submit" class="btn-primary" name="Recover" id="recover_btn" style="margin: 20px"> Recover</button>
              </div>
          </form>


<?php

if(isset($_SESSION['info_recover_password'])) {
  echo  '<hr><div class="alert alert-danger" role="alert">'.$_SESSION['info_recover_password'].'</div>';
  $_SESSION['info_recover_password']=null;
}

?>

