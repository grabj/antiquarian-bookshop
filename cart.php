<?php 
session_start();
//connect file -->
include('includes/connect.php');
include('functions/common_functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - Antiquarian Bookshop</title>
    <link rel="icon" type="image/x-icon" href="./images/book.ico">
    <!-- bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" >
    <!-- css style -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- navbar (100% width) -->
    <div class="container-fluid p-0">

        <?php
            include('includes/navbar.php');
            
        ?>
                <div class="bg-light">
                <h1 class="display-4 text-center"><small>Antiquarian Bookshop</small></h1>
        </div> 
        <?php
        // call cart function
                cart();
        ?>
        <div class="row m-0 p-0">
            <!-- side nav -->
            <div class='col order-3 order-sm-1 bg-dark bg-gradient p-0 side-nav border-dark rounded mt-3'  id='links-side' >
                <?php
                sideNav();
                ?>    
      
                <div class="col-sm-8 col-md-9 col-xl-10 bg-light p-3 px-lg-5 order-xs-5 order-1">
                    <div class='card border-dark col-lg-10 '>
                        <div class='card-header'>
<?php
    if (!isset($_SESSION['user_id'])){
        echo"Cart empty - log in to start shopping.";
     }else{                       
    ?>
                            <p class='lead'><strong>Your cart:</strong></p>
                        </div>
                        <div class='card-body'>
 <?php


  //get cart of an active user
  $user_id=$_SESSION['user_id'];
    $select_query="SELECT * FROM `cart` WHERE user_id='$user_id'";
    $result=mysqli_query($con,$select_query);
    if(mysqli_num_rows($result) > 0)
    {

//table to display cart content
echo"
<table class='table table-hover'>
  <thead>
    <tr>
      <th scope='col'>#</th>
        
        <th scope='col'>Picture</th>
        
        <th scope='col'>Name</th>
        
        <th scope='col'>Price</th>
        
        <th scope='col'> </th>
    </tr>
  </thead>
  <tbody>";


        $i=1;
        $price_total=0;
        //get user's products
        while($row=mysqli_fetch_array($result)){
            $product_id=$row['product_id'];

            $select_products="SELECT * FROM `product` WHERE product_id='$product_id'";
            $result_select=mysqli_query($con,$select_products);

            //put info into table
            while($row_prod=mysqli_fetch_array($result_select)){

                $product_title=$row_prod['title'];
                $product_photo=$row_prod['photo'];
                $price=$row_prod['price'];
                $price_total+=$price;
            
                $price_show=number_format($price,2);
                $product_id=$row_prod['product_id'];

                //display table
                echo"
                <tr class='border-bottom border-secondary'>
                
                <th scope='row'>$i</th>
                <td ><a href='./product_details.php?product_id=$product_id'><img src='./admin_view/product_images/$product_photo'id='cart-img'  alt='product picture'/></a></td>
                <td><a href='./product_details.php?product_id=$product_id' class='nav-link'>$product_title</a></td>
                <td>$price_show EUR</td>
                <td><a class='btn btn-light' href='cart.php?delete=$product_id'>Delete</a></td>
                </tr>";
                $i+=1;
            }       
        }
echo"
    <tr class='table-secondary '>
      <th scope='row'>Total</th>
      <td></td>
      <td></td>
      <td>$price_total EUR</td>
      <td></td>
    </tr>
  </tbody>
</table>";

//delete button
if(isset($_GET['delete'])){

    //delete products from order_products and cart tables
    $product_to_delete_id=$_GET['delete'];
    $query="DELETE FROM `cart` WHERE product_id='$product_to_delete_id' AND user_id='$user_id'";
    $result_delete=mysqli_query($con,$query);

    $query_del="DELETE FROM `order_products` WHERE product_id='$product_to_delete_id'";
    $result_del=mysqli_query($con,$query_del);

    if($result_delete && $result_del){
        print '<div class="alert alert-info" role="alert">Product deleted successsfully.</div>';
    }else{
        print '<div class="alert alert-danger" role="alert">Error. Not possible to delete product now.</div>';
    }
}
    ?>
                        </div>
                        <div class='card-footer bg-light  mb-2 lead'>
                            <?php
                            echo"<strong><p>Total price: <span class='d-inline border-danger border-bottom'>
                                $price_total EUR
                            </span></p></strong>";
                            //make an order
                            echo"
                            <a href='cart.php?order' class='btn btn-warning mb-2' name=''>
                                Make an order <i class='fa-solid fa-bag-shopping'></i></a>";
                            
            //checkout button
        if(isset($_GET['order']) && ($price_total>0)){
            
            order(); 

            $query_del="DELETE FROM `cart` WHERE user_id='$user_id'";
            $result_del=mysqli_query($con,$query_del);
        }
                                }else{echo"Your cart is empty";}
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
