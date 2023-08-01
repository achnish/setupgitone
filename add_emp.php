<?php
   session_start();
  // error_reporting(0);
  include "urlprevent.php"; 
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
    $status = '1';
    $manager_id = getIDbyName($_POST['manager']);
    $active = 1;
    $email_status = 0;
    
    
     if (isset($_FILES['profile_image'])) {    
      $filename = $_FILES["profile_image"]["name"];
      $tempname = $_FILES["profile_image"]["tmp_name"];    
      $folder = "uploads/".$filename;            
    }

    $sql = "INSERT INTO cruddetails (firstname,lastname,birthdate,gender,email,phoneno,designation,lang,image,address,status,manager_id,active,email_status) VALUES ('$firstname','$lastname','$birthdate','$gender','$email','$phoneno','$designation','$lang','$filename','$address','$status',$manager_id,$active,$email_status)";

      require 'vendor/autoload.php';
          $mail = new PHPMailer(true); 
          $subject = 'Registration mail';
          $message = 'your Registration successfully Done';                           
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
    $query_run = mysqli_query($conn,$sql);
    if ($query_run) {
       if (move_uploaded_file($tempname, $folder))  {
            $msg = "Image uploaded successfully";
        }   
      $_SESSION['status'] = 'Successfully Registered...';
      header("location: emp.php");
    } else {
       $_SESSION['status'] = 'Not Registered...';
      header("location: emp.php");
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
            

            <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"  enctype="multipart/form-data">
               <div class="row">
              <div class="col-md-4 mb-3">
              <h3>Add Employee</h3></div>
              <div class="col-md-8 mb-3">
                  <div class="form-group">
                        <label for="designation" class="mb-2">Select Manager</label>
                         <select name="manager" id="manager" class="form-control">
                             <option selected="" disable> Select Manager</option>
                             <?php
                              //include "connection.php"; 
                              $sql = "SELECT firstname From registration where role = 'manager'";
                             $query_run = mysqli_query($conn,$sql);
                          while($data = mysqli_fetch_array($query_run))
                          {
                              echo "<option value='". $data['firstname'] ."'>" .$data['firstname'] ."</option>";  
                          } 
                      ?>  
                        </select>
                    </div>
              </div>
            </div>
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
                   <input type="file" name="profile_image" id="profile_image">
                </div>
               </div>


                </div>
              </div>
              <div class="mt-3 pt-2">
                 <input type="submit" class="btn btn-primary" name="submit" value="submit">
                 <a href="emp.php" class="btn btn-default">All Employee</a>
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
          required: true,
          email: true
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
</body>
</head>
</html>