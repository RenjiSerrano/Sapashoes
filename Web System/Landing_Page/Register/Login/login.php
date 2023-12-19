<?php

@include 'once_db.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
   <link rel="stylesheet" href="loginCSS.css">

</head>
<body>

<?php

@include 'once_db.php';


if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = $_POST['password'];
   $cpass = $_POST['cpassword'];
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM user WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);
   
      $user_id = $row['user_id'];
   
      if($row['user_type'] == 'a'){
         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['user_id'] = $user_id; 
         header('location: admin_page.php');
      } elseif($row['user_type'] == 'u'){
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_id'] = $user_id; 
         header('location: user_page.php');
      }
   } else {
      $error[] = 'Incorrect email or password!';
   }

};

?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>Don't have an account? <a href="/Web System/Landing_Page/Register/register.php">Register</a></p>
   </form>

</div>

</body>
</html>