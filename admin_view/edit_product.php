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
    <title>Edit product - Antiquarian Bookshop</title>
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
        <h3 class=" pb-2 m-3">Change product's information</h3>
        <dl class="row">

<?php
if(isset($_GET['edit_product'])){

    $product_id=$_GET['edit_product'];

    $search_query="SELECT * FROM `product` WHERE product_id='$product_id'";
    $result_search=mysqli_query($con,$search_query);
    $number=mysqli_num_rows($result_search);
    if($number>0){
        $row=mysqli_fetch_assoc($result_search);
        $status=$row['status'];
        $title=$row['title'];
        $author=$row['author'];
        $release_date=$row['release_year'];
        $isbn=$row['isbn'];
        $publisher=$row['publisher'];
        $category=$row['category'];
        $condition=$row['condition'];
        $description=$row['description'];
        $prod_photo=$row['photo'];
        $price=$row['price'];
        $added=$row['insert_date'];
        
        echo"
        <dt class='col-sm-3 py-3'>Product ID:</dt>
        <dd class='col-sm-9 py-3'>$product_id</dd>";
            lineProductInfo($status,'Status',$product_id);
            lineProductInfo($title,'Title',$product_id);
            lineProductInfo($author,'Author',$product_id);
            lineProductInfo($isbn,'ISBN',$product_id);
            lineProductInfo($category,'Category',$product_id);
            lineProductInfo($publisher,'Publisher',$product_id);
            lineProductInfo($release_date,'Release year',$product_id);
            lineProductInfo($condition,'Condition',$product_id);  
            lineProductInfo($description,'Description',$product_id);
            lineProductInfo($price,'Price',$product_id);
        echo"
        <dt class='col-sm-3 py-2'>Modified lastly:</dt>
        <dd class='col-sm-9 py-2'>$added</dd>";
}
?>
       </div></div>
       <?php
            //dispaly outcome message
            if(isset($_POST['edit_product'])){
                if($result_insert_prod_query){
                    print '<div class="alert alert-success" role="alert">Success. The product has been edited.</div>';
                }else{
                    print '<div class="alert alert-danger" role="alert">Failure. The product could not be edited.</div>';
                }
            }}
        ?>
    </div>  
</body>
</html>

