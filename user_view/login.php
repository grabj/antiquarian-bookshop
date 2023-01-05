<?php 
session_start();
//connect file -->
include('../includes/connect.php');
include('../functions/common_functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in - Antiquarian Bookshop</title>
  <link rel="icon" type="image/x-icon" href="../images/book.ico">
  <!-- bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- font awesome link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" >
  <!-- css style -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container-fluid mt-5">
    <div class="container col-md-8 col-lg-6 offset-lg-3 offset-md-2">
      <h5 class="mx-3">Log in</h5>
      <form method="POST" action="">
        <div class="input-group mb-3 mt-4">
          <span class="input-group-text" id="basic-addon3">Email address</span>
          <input type="text" class="form-control" name="email"tabindex="1" aria-describedby="basic-addon3" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon3">Password</span>
          <input type="password" class="form-control" name="password"tabindex="10" aria-describedby="basic-addon3" required>
        </div>
        <div class="row mb-3">
          <div class="col offset-5">
            <button class="btn btn-primary" value="login" NAME="login" tabindex="11"type="submit">Submit</button>
          </div>
          <div class="col">
            <a class="btn btn-outline-primary"tabindex="13" href="../index.php">Go back to the main page</a>
          </div>
        </div>
      </form>

<?php 
  if(isset($_POST['login'])){

    if(!isset($_SESSION['user_id'])){

      $password=$_POST['password'];
      $email=$_POST['email'];

      //check if email exists in DB
      $search_query="SELECT * FROM `user` WHERE email='$email'";
      $result_search=mysqli_query($con,$search_query);
      $number=mysqli_num_rows($result_search);
      if($number>0){
        $row_data=mysqli_fetch_assoc($result_search);

        //verify hashed password
        if(password_verify($password,$row_data['password'])){

          $_SESSION['user_email']=$email;

          $user_id=$row_data['user_id'];
          $user_first_name=$row_data['first_name'];

          $_SESSION['user_id']=$user_id;
          $_SESSION['user_first_name']=$user_first_name;
          

          print '<div class="alert alert-success" role="alert">You are logged in.</div>';
        }
        else{
          print '<div class="alert alert-danger" role="alert">Invalid Password.</div>';
        }
      }
      else{
        print '<div class="alert alert-danger" role="alert">Invalid email address.</div>';
      }
    }else{
      print '<div class="alert alert-info" role="alert">You are already logged in.</div>';
    }
  }

?>

    </div>
  </div>

</body>
</html>