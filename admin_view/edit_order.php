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
    <title>Edit order - Antiquarian Bookshop</title>
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
        <h3 class=" pb-2 m-3">Change order's status</h3>
        <dl class="row">
<?php
if(isset($_GET['edit_order'])){

    $order_id=$_GET['edit_order'];

    $search_query="SELECT * FROM `user_order` WHERE order_id='$order_id'";
    $result_search=mysqli_query($con,$search_query);
    $number=mysqli_num_rows($result_search);
    if($number>0){
        $row=mysqli_fetch_assoc($result_search);
        $status=$row['status'];
        $user_id=$row['user_id'];
        $date=$row['order_date'];
        $price=$row['total_price'];
        $quantity=$row['total_products'];
        
    echo"
    <dt class='col-sm-3 py-3'>Order ID:</dt>
    <dd class='col-sm-9 py-3'>$order_id</dd>";
        lineOrderInfo($status,'Status',$order_id);
    echo"
    <dt class='col-sm-3 mb-3'>Order date:</dt>
    <dd class='col-sm-9 mb-3'>$date</dd>
    <dt class='col-sm-3 py-3'>Total price:</dt>
    <dd class='col-sm-9 py-3'>$price</dd>
    <dt class='col-sm-3 py-3'>Number of products:</dt>
    <dd class='col-sm-9 py-3'>$quantity</dd>

    <dt class='col-sm-3 py-3'>Products IDs:</dt>";
    //display products
    $get_prods="SELECT * FROM `order_products` WHERE order_id='$order_id'";
    $result_prods=mysqli_query($con,$get_prods);
        echo"<dd class='col-sm-9 py-3'>
        <ul class='list-group text-center col-2' >";

          while($row_prods=mysqli_fetch_assoc($result_prods)){
            $product = $row_prods['product_id'];
            echo"
            <li class='list-group-item'>
              <a href='../product_details.php?product_id=$product' class='nav-link'>$product</a>
            </li>";
          }

          echo"
        </ul></dd>;"

?>
       </div></div>
       <?php
            //display output message
            if(isset($_POST['edit_order'])){
                if($result_insert_prod_query){
                    print '<div class="alert alert-success" role="alert">Success. Order has been edited.</div>';
                }else{
                    print '<div class="alert alert-danger" role="alert">Failure. Order could not be edited.</div>';
                }
            }}}
        ?>
    </div>  
</body>
</html>

