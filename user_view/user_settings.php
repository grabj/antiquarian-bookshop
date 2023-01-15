<?php
session_start();
//connect file -->
include('../includes/connect.php');
include('../functions/common_functions.php');

if(!isset($_SESSION['user_id'])){
    header('HTTP/1.0 401 Unauthorized, true, 401');
    http_response_code(401);
    print('Error ' . http_response_code());
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account settings - Antiquarian Bookshop</title>
    <link rel="icon" type="image/x-icon" href="../images/book.ico">
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <!-- css style -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark pb-2 bg-gradient">
        <div class="container-fluid">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-0 mb-lg-0 p-1">
                <li class="nav-item m-auto">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item m-auto">
                    <a class="nav-link" href="../index.php#products">Products</a>
                </li>
                <li class="nav-item m-auto">
                    <a class='nav-link' href='../cart.php'>
                        Cart <i class='fa-solid fa-cart-shopping'></i>
                        <sup class='text-info'>
                            <?php
                            print count_items() 
                            ?>
                        </sup></a></a>
                </li>
            </ul>       
        </div>
        <div class='d-flex'>
        <a class=' btn btn-outline-info border-info p-1 mx-4' href='./user_settings.php'>Account details</a>
        <a class=' btn btn-outline-warning px-3 p-1 ' href='./logout.php'>Log out</a>
        </div>
        </div>
    </nav>


 <div class="container-fluid p-0">
    <div class="pb-5">
        <h3 class="text-center p-2 m-0">Change account's information</h3>
    </div>
    <div class="container-fluid p-0 ">
        <div class="container col-md-8 col-lg-6 offset-lg-3 offset-md-2">
        <dl class="row">

            <?php

                $user_id = $_SESSION['user_id'];
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
                    <dt class='col-sm-3 my-3'>Email:</dt>
                    <dd class='col-sm-9 my-3'>$user_email</dd>";

                    lineAttribute($user_first_name, 'First_name');
                    
                    lineAttribute($user_last_name, 'Last_name');

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
            if(isset($_POST['change_password'])){
                $password=$_POST['password'];
                $password_conf=$_POST['password_conf'];
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
                }else{
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
                                print '<div class="alert alert-success" role="alert">Success. You have changed your password.</div>';
                            }
                            else{
                                print '<div class="alert alert-danger" role="alert">Failure.</div>';
                            }
                        }    
                    }
                }
            }
            echo"
            <dt class='col-sm-3'>Account created:</dt>
            <dd class='col-sm-9'>$user_creation_date</dd>";



//SHOW ORDERS
echo"
            <h3 class='text-left pt-5 m-3'>Orders in the database:</h3>";

        $get_orders="SELECT * FROM `user_order` WHERE user_id='$user_id'";
        $result_get_orders=mysqli_query($con,$get_orders);
        

            if (mysqli_num_rows($result_get_orders) > 0) {

            echo"
            <table class='table' id='table-admin'>
            <thead>
          
              <tr class='border-bottom border-secondary' id='tr-admin'>
              <hr/>
                <th scope='col'>ID</th>
                
                  <th scope='col'>Order date</th>
      
                  <th scope='col'>Total price to pay</th>
                  <th scope='col'>Products ordered</th>
                  <th scope='col'>Status</th>
                  
              </tr>
            </thead>
            <tbody>";
            
                while($row=mysqli_fetch_assoc($result_get_orders)){
                
                    $order_id=$row['order_id'];
                    $order_date=$row['order_date'];
                    $status=$row['status'];
                    $total_products=$row['total_products'];
                    $total_price=$row['total_price'];
                
                    $price=number_format($total_price,2);

        echo"
            <tr id='tr-admin'>
                <th scope='row'>$order_id</th>
                    
                    <td>$order_date</td>
                    
                    <td>$price EUR</td>
                    <td >$total_products</td>
                    <td >$status</td>
               </th>";
                }
        echo"
        </tr>
        </tbody>
        </table>
        </div>";
            }elseif (mysqli_num_rows($result_get_orders) == 0){
          echo" <h2 class='text-center'>No orders yet.</h2>";
            }
        }

?>
        </dl>
    </div>
</div>
</body>
</html>
