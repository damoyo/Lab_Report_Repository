<?php
include 'NoDirectPhpAccess.php';
?>

<?php
$page='Submit LAB+';
include 'Header.php';
?>

<div class='row' style='width:80%;margin:auto;'>


<?php

$c_date =  date("Y-m-d H:i");
$student_id = $_SESSION["user_student_id"];
  
if(!empty($_GET["id"]))
{
    $id = mysqli_real_escape_string($con, $_GET["id"]);
    $url = mysqli_real_escape_string($con, $_GET["url"]);
      
    $result1 = mysqli_query($con," SELECT `Type`, `Lab_Report_ID`, `Course_ID`, `Posted_Date`, `Deadline`, `Instructions`, `Title`, `Attachment_link_1`, `Attachment_link_2`, `Attachment_link_3`, `Attachment_link_4` FROM `lab_reports_table` WHERE Lab_Report_ID=$id  and Deadline > '$c_date'  ORDER by Lab_Report_ID DESC");
    if(mysqli_num_rows($result1) == 0)
    {
        echo "No active assignments for this course so far.";
     
    } else {
        
        while($row = mysqli_fetch_assoc($result1)) {
        
            $Course_ID = $row['Course_ID'];
            $title = $row['Title'];
            $ins = $row['Instructions'];
            $posted = $row['Posted_Date'];	
            $deadline = $row['Deadline'];
            $att1 = $row['Attachment_link_1'];
            $att2 = $row['Attachment_link_2'];
            $att3 = $row['Attachment_link_3'];
            $att4 = $row['Attachment_link_4'];
            $labid = $row['Lab_Report_ID'];
            $type = $row['Type'];
        
            //----------------------------------Giving both the Group Admin and Group Members same priviledges to submit assignment--------------------------------------
            if($type=="Group"){
                $resultx1 = mysqli_query($con,"SELECT Course_Group_id  FROM `course_groups_table` WHERE (Course_id=$Course_ID) and ((Group_Member=$student_id ) or (Group_Member2=$student_id ) or (Group_Member3=$student_id ) or (Group_Member4=$student_id ) or (Group_Leader=$student_id))");
                while($row = mysqli_fetch_assoc($resultx1)) {
                    $_SESSION["Group_ID"] = $row['Course_Group_id'];
                }  
      
                if($_SESSION["Group_ID"] < 1) 
                {
                    echo" <center><h3> This Lab report can only be submitted by Group Admin  </h3> </center> ";
                    return;
                }
            }
                                     
                                     
            $full_link="<a href='~\..\Lab_Report_Assignments\\$att1'>$att1</a>";      
                                     
            if($att2!=""){
                $full_link = $full_link."| <a href='~\..\Lab_Report_Assignments\\$att2'>$att2</a>";    
            }
            if($att3!=""){
                $full_link = $full_link."| <a href='~\..\Lab_Report_Assignments\\$att3'>$att3</a>";    
            }
                                     
            if($att4!=""){
                $full_link = $full_link."| <a href='~\..\Lab_Report_Assignments\\$att4'>$att4</a>";    
            }
               
            echo    "  <div class='alert' style='margin-left:20px;border-bottom:2px solid #1D91EF;'> <a href='~\..\Courses.php?course=$url'>
  Courses > $url > Submlit Lab Report > $title 
   <br> 
</a></div>
 ";

            echo "";
        }
    }
}

$Group_ID = $_SESSION["Group_ID"];

?>

</div>




<div style="width:80%;margin:auto;">

         <h3> Submit Lab Report Assignment </h3>
         <hr>
    <div class="row">
     
         <div class="col-md-6">
            

         <form method='post' enctype='multipart/form-data' action='Script.php'>
         <input type='hidden' name='frm_submitlab' value='true' required=''/>
         <input type='hidden' name='lab_id' value='<?php echo $id; ?>' required=''/>
         <input type='hidden' name='student_id' value='<?php echo $student_id; ?>' required=''/>
         <input type='hidden' name='group_id' value='<?php echo $Group_ID; ?>' required=''/>
         <input type='hidden' name='url' value='<?php echo $url; ?>' required=''/>
                              
         Title
         <input type='text'  name='title' placeholder='Ttle' class='form-control' required=''>

         Attachment 1
         <input type='file'  name='attachment1' placeholder='Attachment 1' class='form-control' required=''>

         Attachment 2
         <input type='file' name='attachment2' placeholder='Attachment 2' class='form-control'>

         </div>

         <div class="col-md-6">

         Attachment 3
         <input type='file'  name='attachment3' placeholder='Attachment 3' class='form-control' >

         Attachment 4
         <input type='file'  name='attachment4' placeholder='Attachment 4' class='form-control' >
         <br>
         
         <input type='submit' class='btn btn-primary' value='Submit Lab Assignment'><br>
         </form>
   
         </div>

   </div>
    
</div> 
