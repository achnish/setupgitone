<?php

 session_start();
  require_once "connection.php";

 if (isset($_POST['submit'])) {
 
    $firstname = mysqli_real_escape_string($conn,$_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn,$_POST['lastname']);
    $birthdate = ($_POST['birthdate']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $phoneno = mysqli_real_escape_string($conn,$_POST['phoneno']);
    $lang = implode(",", $_POST['lang']);
    $pass = mysqli_real_escape_string($conn,$_POST['pass']);
    $pass = md5($pass);
    $cpass = mysqli_real_escape_string($conn,$_POST['cpass']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
     $role = mysqli_real_escape_string($conn,$_POST['role']);
     $active = 1;
     $email_status = 1;
     $country = mysqli_real_escape_string($conn,$_POST['country']);
     $state = mysqli_real_escape_string($conn,$_POST['state']);
     $city = mysqli_real_escape_string($conn,$_POST['city']);

  $sql = "INSERT INTO registration (firstname,lastname,birthdate,gender,email,phoneno,language,pass,cpass,address,role,active,email_status,country,state,city) VALUES ('$firstname','$lastname','$birthdate','$gender','$email','$phoneno','$lang','$pass','$cpass','$address','$role','$active','$email_status','$country','$state','$city')";

  require 'vendor/autoload.php';
          $mail = new PHPMailer(true); 
          $subject = 'Registration mail';
          $message = file_get_contents('email_template.html');
          $message = str_replace('%testusername%', $firstname, $message);  
          $message = str_replace('%testemail%', $email, $message);  
          $message = str_replace('%testpass%', $cpass, $message);  
                        
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
 
        $mail->MsgHTML($message);
        $mail->IsHTML(true);                            
        $mail->Subject = $subject;
 
        $mail->send();  
    } catch (Exception $e) {
     $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
     $_SESSION['status'] = 'error';
    }
  
  $query_run = mysqli_query($conn,$sql);
   if ($query_run) {
        $_SESSION['status'] = 'Successfully Register';
        header("location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "" . mysqli_error($conn);
    }}

   
    mysqli_close($conn);
?>