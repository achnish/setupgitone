<?php
error_reporting(0);
session_start();

require_once "connection.php";
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phoneno = $_POST['phoneno'];
    $designation = $_POST['designation'];
    $lang = implode(",", $_POST['lang']);
    $address = $_POST['address'];
    $status = 1;
    $manager_id = $_SESSION['id'];
    $active = 1;
    $email_status = 1;
    
    
    if (isset($_FILES['profile_image'])) {    
        $filename = $_FILES["profile_image"]["name"];
        $tempname = $_FILES["profile_image"]["tmp_name"];    
        $folder = "uploads/".$filename;            
    }
  
    $sql = "INSERT INTO cruddetails (firstname,lastname,birthdate,gender,email,phoneno,designation,lang,address,image,status,manager_id,active,email_status) VALUES ('$firstname','$lastname','$birthdate','$gender','$email','$phoneno','$designation','$lang','$address','$filename','$status','$manager_id','$active','$email_status')";
    // print_r($sql);
    // exit();
    require 'vendor/autoload.php';
          $mail = new PHPMailer(true); 
          $subject = 'Registration mail';
          $message = 'your Registration successfully Done' ;                           
    try {
        $mail->isSMTP();                                     
        $mail->Host = 'smtp.gmail.com';                      
        $mail->SMTPAuth = true;                             
        $mail->Username = 'modi.himani.3110@gmail.com';     
        $mail->Password = 'himani@1234';             
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
        );                         
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;   
        $mail->setFrom('modi.himani.3110@gmail.com');
 
        $mail->addAddress($email);              
        $mail->addReplyTo('modi.himani.3110@gmail.com');
 
        $mail->isHTML(true);                                  
        $mail->Subject = $subject;
        $mail->Body    = $message;
 
        $mail->send();  
    } catch (Exception $e) {
     $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
     $_SESSION['status'] = 'error';
    }
    if (mysqli_query($conn, $sql)) {
        if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
        } 
        $_SESSION['status'] = 'Successfully Register';  
        header("location: emp_info.php");
        exit();
    } else {
      $_SESSION['status'] = 'Not Register'; 
      header("location: emp_info.php");
        //echo "Error: " . $sql . "" . mysqli_error($conn);
    }
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <?php include "head.php"; ?>
   <?php include "nav.php"; ?>
<body>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
           <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Add Employee</h3>
            <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-outline">
                    <label class="form-label">First Name</label>
                     <input type="text" id="firstname" name="firstname" class="form-control" value="" maxlength="50" required="" class="form-control form-control-lg" />
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-outline">
                    <label class="form-label">Last Name</label>
                    <input type="text" id="lastname" name="lastname" class="form-control" value="" maxlength="50" required=""class="form-control form-control-lg" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3 d-flex align-items-center">
                  <div class="form-outline datepicker w-100">
                    <label for="birthdayDate" class="form-label">Birthday</label>
                     <input type="date" id="birthdate" name="birthdate" class="form-control" value="" maxlength="50" required=""
                      class="form-control form-control-lg"/>
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <h6 class="mb-2 pb-1">Gender: </h6>
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input" type="radio" name="gender" id="gender" value="female" checked
                     />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="male" />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender" value="other"/>
                    <label class="form-check-label" for="otherGender">Other</label>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <div class="form-outline">
                     <label class="form-label" for="emailAddress">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="" maxlength="50" required=""class="form-control form-control-lg" />
                  </div>
                </div>
                <div class="col-md-6 mb-3">
                  <div class="form-outline">
                    <label class="form-label" for="phoneNumber">Phone Number</label>
                   <input type="text" id="phoneno" name="phoneno" class="form-control" value="" maxlength="50" required=""class="form-control form-control-lg" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <label for="designation" class="mb-2">Select Designation</label>
                        <select name="designation" id="designation" class="form-control">
                            <option value="select">Select Designation</option>
                            <option value="teamleader">Team Leader</option>
                            <option value="developer">Developer</option>
                            <option value="hr">HR</option>
                            <option value="designer">Designer</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                   <span>Select languages</span><br/>
                   <div class="row">
                    <div class="col-md-4 mt-2">
                     <input type="checkbox" name='lang[]' value="hindi"> Hindi  </div>
                    <div class="col-md-4 mt-2">
                    <input type="checkbox" name='lang[]' value="english"> English </div>
                    <div class="col-md-4 mt-2">
                    <input type="checkbox" name='lang[]' value="gujarati"> Gujarati </div></div>
                 </div>
               </div>
               <div class="row mt-3">
                <div class="col-md-12 mt-2">
                  <label for="birthdayDate" class="form-label">Address</label>
                <div class="form-floating">
                  <textarea name="address" id="address" class="form-control" id="address"></textarea>
                </div></div></div>
                <div class="row mt-3">
                <div class="col-md-6 mt-2">
                   <label for="birthdayDate" class="form-label">Select Image</label>
                   <input type="file" name="profile_image" id="profile_image" onchange="previewFile(this);">
                    <img id="previewImg" style="width: 100px;" >
                </div>
               </div>


                </div>
              </div>
              <div class="mt-3 pt-2">
                 <input type="submit" class="btn btn-primary" name="submit" value="submit">
                 <a href="emp_info.php" class="btn btn-default">All Employee</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<style>
  .error {
    color: red;
  }
</style>
<script type="text/javascript">
  $(document).ready(function () {
    $('#form').validate({
      rules: {
        firstname: {
          required: true
        },
        lastname: {
          required: true
        },
        birthdate: {
          required: true
        },
        gender: {
          required: true
        },
        email: {
          email: true,
          remote: {
        url: "unique_email.php",
        type: "post",
        data: {
          email: function() {
           return $('#form :input[name="email"]').val();
          }
        }
      }
        },
        phoneno: {
          required: true,
          rangelength: [10, 12],
          number: true
        },
        address: {
          required: true
        },
        profile_image: {
          required: true
        }
      },
      messages: {
        firstname: 'Please enter FirstName.',
        lastname: 'Please enter LastName.',
        birthdate: 'Please Select birthdate.',
        gender: 'Please Select .',
        email: {
          required: 'Please enter Email Address.',
          email: 'Please enter a valid Email Address.',
        },
        phoneno: {
          required: 'Please enter Contact.',
          rangelength: 'Contact should be 10 digit number.'
        },
        address: 'Please Enter Address.',
        profile_image: 'Please Select Image.',
      },

      submitHandler: function (form) {
        form.submit();
      }
    });
  });
</script>
 <script type="text/javascript">
        setTimeout(function () {
            $('#alert').alert('close');
        }, 5000);
    </script>
    <script>
    function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
  </script>
    
</body>
</head>
</html>