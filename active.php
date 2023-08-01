<?php
  
     include_once 'connection.php';
  
    if (isset($_GET['id'])){

        $active_id=$_GET['id'];

        $query = "select * from registration where  id = '$active_id' ";

        $rs = mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($rs);
    
        if($row['active'] == 1){
  
        $sql="UPDATE `registration` SET 
             `active`=0 WHERE id='$active_id'";
        } else {
            $sql="UPDATE `registration` SET 
             `active`=1 WHERE id='$active_id'";
        }
      
        mysqli_query($conn,$sql);
    }
  
    header('location: users.php');
?>