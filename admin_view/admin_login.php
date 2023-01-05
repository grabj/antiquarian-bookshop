<?php 
session_start();
//connect file -->
include('../includes/connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin log in - Antiquarian Bookshop</title>
  <link rel="icon" type="image/x-icon" href="../images/book.ico">
  <!-- bootstrap CSS link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- css style -->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container-fluid mt-5">
    <div class="container col-md-8 col-lg-6 offset-lg-3 offset-md-2">
      <h5 class="mx-3">Log in</h5>
      <form method="POST" action="">
        <div class="input-group mb-3 mt-4">
          <span class="input-group-text" id="basic-addon3">Name</span>
          <input type="text" class="form-control" name="admin_name"tabindex="1" aria-describedby="basic-addon3" required>
        </div>
        <div class="input-group mb-3">
          <span class="input-group-text" id="basic-addon3">Password</span>
          <input type="password" class="form-control" name="admin_password"tabindex="10" aria-describedby="basic-addon3" required>
        </div>
        <div class="row mb-3">
          <div class="col text-center">
            <button class="btn btn-primary" value="login" NAME="admin_login" tabindex="11"type="submit">Submit</button>
          </div>
       
        </div>
 
<?php 

  if(isset($_POST['admin_login'])){

    if(!($_SESSION['admin_logged'])){

      $password=$_POST['admin_password'];
      $admin=$_POST['admin_name'];

      $search_query="SELECT * FROM `admin` WHERE `name`='$admin'";
      $result_search=mysqli_query($con,$search_query);
      $number=mysqli_num_rows($result_search);
      if($number>0){
        $row_data=mysqli_fetch_assoc($result_search);

        //verify hashed password
        if(password_verify($password,$row_data['password'])){

          $_SESSION['admin_logged']=true;
          

          print '<div class="alert alert-success" role="alert">You are logged in.</div>';
            echo"
            <div class='col text-center'>
                <a class='btn btn-outline-primary' tabindex='13' href='./index.php'>Go to the management panel</a>
            </div>";
        }
        else{
          print '<div class="alert alert-danger" role="alert">Invalid credentials.</div>';
        }
      }
      else{
        print '<div class="alert alert-danger" role="alert">Invalid credentials.</div>';
      }
    }else{
          print '<div class="alert alert-info" role="alert">You are already logged in.</div>';
            echo"
            <div class='col text-center'>
                <a class='btn btn-outline-primary' tabindex='13' href='./index.php'>Go to the management panel</a>
            </div>";
    }
  }

?>
     </form>
    </div>
  </div>

</body>
</html>