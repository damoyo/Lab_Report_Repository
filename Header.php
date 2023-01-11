<?php
session_start();
error_reporting(0);
date_default_timezone_set('Asia/Shanghai');
include_once "get_mysql_credentials.php";
?>

<!DOCTYPE html>

<head>
    <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="./font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="./css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="./css/signin.css" rel="stylesheet" type="text/css" />
    <link href = "./css/main.css" rel = "stylesheet" type = "text/css" /> <!--Our custom CSS-->
    <script src="./css/jquery.min.js" type="text/javascript"></script>
    <script src="./css/bootstrap.min.js" type="text/javascript"></script>
    <script src="./css/jquery.datetimepicker.min.js" type="text/javascript"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom_navbar">
    <a class="navbar-brand" href="~\..\index.php"> <img src="logo.png" style="width:30px;height:30px;"> LRR </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">

        <li class="nav-item active">
          <!-- <a class='nav-link' href='~\..\Visitors.php'>     <i class='fa fa-globe'></i>  Visitor Portal <span class='sr-only'>(current)</span></a> -->
        </li>
        <?php
        if (isset($_SESSION["user_fullname"])) {

          echo "       <a class='nav-link' href='~\..\Courses.php'><i class='fa fa-book'></i> Courses <span class='sr-only'>(current)</span></a>";
        ?>
          </li>
      </ul>



      <form class="form-inline my-2 my-lg-0" style="color:#fff;">
        Welcome &nbsp; <b> <?php echo $_SESSION['user_fullname']; ?> </b> &nbsp;

        <?php
          $c_date =  date("Y-m-d H:i");
          if (isset($_SESSION['user_student_id']))
            echo "(" . $_SESSION['user_type'] . " - " . $_SESSION['user_student_id'] . ")   ";
          else
            echo "(" . $_SESSION['user_type'] . ")   ";
        ?>

        <?php
          if ($_SESSION['user_type'] == "Lecturer") {
            echo  "&nbsp;&nbsp;&nbsp;  <i class=\"fa fa-cog\" style=\"color:#fff;\"> </i> &nbsp;<a style='color:#fff !important' href=\"~\..\Admin.php\" id=\"admin_tab\">Admin </a>";
          }
        ?>

        &nbsp;&nbsp;&nbsp; <i class="fa fa-user" style="color:#fff;"> </i>
        &nbsp;<a href="#" style='color:#fff !important' onclick="updatePass(<?php echo $_SESSION['user_id']; ?>)">Update password</a>
        &nbsp;&nbsp;&nbsp; <i class="fa fa-lock" style="color:#fff;"> </i> &nbsp;<a style='color:#fff !important' href="~\..\logout.php">Logout </a>

      <?php
        }
      ?>
      </form>
    </div>
  </nav>
</body>



  <script>
    function updatePass(id) {

      var pass = prompt("Enter your new password : ", "Enter a strong password");

      if (!confirm('Are you sure you want to reset your password?')) {
        return;
      }

      window.location.href = "\Script.php\?action=passchange&uid=" + id + "&pass=" + pass;
    }

    function blockUser(id, status) {
      if (!confirm('Are you sure you want to change user status?')) {
        return;
      }
      window.location.href = "\Script.php\?action=statuschange&uid=" + id + "&status=" + status;
    }
  </script>