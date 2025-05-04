<?php

@include 'config.php';

session_start();

if(isset($_POST['submit_user'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ? AND user_type = 'user'";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  
   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
   } else{
      $message[] = 'incorrect email or password!';
     }
}

if(isset($_POST['submit_admin'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $sql = "SELECT * FROM `users` WHERE email = ? AND password = ? AND user_type = 'admin'";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass]);
   $rowCount = $stmt->rowCount();  
   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

   }else{
      $message[] = 'incorrect email or password!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/components.css">

</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

?>
   
<section class="form-container">

   <form action="" method="POST">
      <h3>Login Now</h3>
      <input type="email" name="email" class="box" placeholder="enter your email" required>
      <input type="password" name="pass" class="box" placeholder="enter your password" required>
      <input type="submit" name="submit_user" class="btn" value="User login">
      <input type="submit" name="submit_admin" class="btn" value="Admin login">
      <p>don't have an account? <a href="register.php">register now</a></p>
      

   </form>
</section>
</body>
</html>