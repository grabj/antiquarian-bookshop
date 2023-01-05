<?php
session_start();
include('./verify_session.php');
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
    <title>Edit user - Antiquarian Bookshop</title>
    <link rel="icon" type="image/x-icon" href="../images/book.ico">
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <!-- css style -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include('management_panel.html'); ?>

 <div class="container-fluid p-0">

    <div class="container-fluid p-0 ">
        <div class="container col-md-8 col-lg-6 offset-lg-3 offset-md-2 p-2">
        <h3 class=" pb-2 m-3">Change user's information</h3>
        <dl class="row">

            <?php
            if(isset($_GET['edit_user']))
                $user_id = $_GET['edit_user'];
                $search_query="SELECT * FROM `user` WHERE user_id='$user_id'";
                $result_search=mysqli_query($con,$search_query);
                $number=mysqli_num_rows($result_search);
                if($number>0){
                    $row_data=mysqli_fetch_assoc($result_search);
                    
                    $user_last_name=$row_data['last_name'];
                    $user_first_name=$row_data['first_name'];
                    $user_email=$row_data['email'];
                    $user_creation_date=$row_data['creation_date'];

                    echo"
                    <dt class='col-sm-3 py-3'>User ID:</dt>
                    <dd class='col-sm-9 py-3'>$user_id</dd>";
                    

                    //create forms for an attributes and check changed
                    lineAttributeAdmin($user_email, 'Email', $user_id);

                    lineAttributeAdmin($user_first_name, 'First_name',$user_id);
                    
                    lineAttributeAdmin($user_last_name, 'Last_name',$user_id);


                    echo"
            <dt class='col-sm-3'>Password:</dt>
            <dd class='col-sm-9'>
            <form method='POST' action=''>  
                <input type='password' class='form-control mb-0' name='password'placeholder='Enter new password'>
                <div class='input-group mb-3'>
                    <input type='password' class='form-control'  name='password_conf' placeholder='Confirm password'>
                    <div class='input-group-append'>
                        <button class='btn btn-outline-danger' name='change_password'type='input'>Change</button>
                    </div>
                </div>
            </form></dd>";

            //if changing password - hash new one.
            if(isset($_POST['change_password'])){
                $password=$_POST['password'];
                $password_conf=$_POST['password_conf'];
                //check if password is equal
                if($password!=$password_conf){
                    print '<div class="alert alert-warning" role="alert">
                    Password confirmation is incorrect.
                    </div>';
                }else{
                    if ($password==""){
                        print '<div class="alert alert-warning" role="alert">
                        Password cannot be empty.
                        </div>';
                    }else{
                        $hash_password=password_hash($password,PASSWORD_DEFAULT);
                        $query="UPDATE`user` SET `password`='$hash_password' WHERE `user_id`='$user_id'";
                        $result_insert=mysqli_query($con,$query);
                        if($result_insert){
                            print '<div class="alert alert-success" role="alert">Success. You have changed a password.</div>';
                        }
                        else{
                            print '<div class="alert alert-danger" role="alert">Failure.</div>';
                        }
                    }
                }
            }
            echo"
            <dt class='col-sm-3'>Account created</dt>
            <dd class='col-sm-9'>$user_creation_date</dd>";

                }else{
                    print '<div class="alert alert-danger" role="alert">Data could not be fetched. Try again later.</div>';
                }
?>
        </dl>
    </div>
</div>
</body>
</html>


