<!-- connect file -->
<?php 
include('../includes/connect.php');
include('../functions/common_functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Antiquarian Bookshop</title>
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
      <div class="container col-md-8 col-lg-6 offset-lg-3 offset-md-2 ">
        <h5 class="mx-3">Create an account</h5>
        <hr/>
        <form class="row g-3 mt-3 mb-3" method="POST" action="">
          <div class="col-6">
            <label for="validationDefault01" class="form-label">First name</label>
            <input type="text" class="form-control" name="f-name" id="validationDefault01" tabindex="1"required>
          </div>
          <div class="col-6">
            <label for="validationDefault02" class="form-label">Last name</label>
            <input type="text" class="form-control" name="l-name" id="validationDefault02" tabindex="3"required>
          </div>
          <div class="col-12">
            <label for="validationDefault05" class="form-label">Email address</label>
            <div class="input-group">
                <input type="text" class="form-control" name="email1" id="validationDefault05" tabindex="7"required>
                <span class="input-group-text">@</span>
                <input type="text" class="form-control" name="email2" id="validationDefault06" tabindex="8"required>
            </div>
          </div>
          <div class="col-sm-6">
            <label for="validationDefault08" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="validationDefault08" tabindex="10" required>
          </div>
          <div class="col-sm-6">
            <label for="validationDefault03" class="form-label">Confirm password</label>
            <input type="password" class="form-control" name="pass-conf" id="validationDefault03" tabindex="12"  required>
          </div>
          
  
          <div class="col offset-5">
            <button class="btn btn-primary" value="register" name="register" tabindex="14" type="submit">Submit</button>
          </div>
          <div class="col">
            <a class="btn btn-outline-primary"tabindex="18" href="./login.php">Go to log in page</a>
          </div>
        </form>
<?php
//main
if(isset($_POST['register'])){
    $password_conf=$_POST['pass-conf'];
    $email1=$_POST['email1'];
    $email2=$_POST['email2'];
      $email=$email1 . "@" . $email2;
    $fname=$_POST['f-name'];
    $lname=$_POST['l-name'];
    $password=$_POST['password'];
    $hash_password=password_hash($password,PASSWORD_DEFAULT);

    //check if not empty
    if($email1=="" or $email2=="" or $password=="" or $password_conf=="" or $fname=="" or $lname==""){
        print '<div class="alert alert-warning" role="alert">Please fill all fields.</div>';
    }
    else{
        //check if email exists in database
        $compare_query="SELECT * FROM `user` WHERE email='$email'";
        $result_compare=mysqli_query($con,$compare_query);
        $number=mysqli_num_rows($result_compare);
        if($number>0){
            print '<div class="alert alert-danger" role="alert">
            Account could not be created - this email has already been taken.
            </div>';}
        else{
            //Validate password strength
            $uppercase= preg_match('@[A-Z]@',$password);
            $lowercase= preg_match('@[a-z]@',$password);
            $num= preg_match('@[0-9]@',$password);
            if(!$uppercase || !$lowercase || !$num || strlen($password) < 7) {
                print '<div class="alert alert-warning" role="alert">
                Password must be at least 6 characters in length.</br>
                Password must include at least 1 upper case letter.</br>
                Password must include at least 1 number.
                </div>';
            }
            else{
                //check if password is equal
                if($password!=$password_conf){
                  print '<div class="alert alert-warning" role="alert">
                  Account could not be created - password confirmation is incorrect.
                  </div>';
                }
                else{
                    $insert_query="INSERT INTO `user`(`password`, `first_name`, 
                    `last_name`, `email`, `creation_date`) VALUES ('$hash_password',
                    '$fname','$lname','$email',NOW())";

                    $result_insert=mysqli_query($con,$insert_query);

                    if($result_insert){
                        print '<div class="alert alert-success" role="alert">Success. The account has been created.</div>';
                    }
                    else{
                      print '<div class="alert alert-danger" role="alert">Failure. Account could not be created.</div>';
                    }
                }
            }
        }
    }       
}             
?>
      <div>
    </div>
</body>
</html>