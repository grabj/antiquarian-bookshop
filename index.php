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
    <title>Antiquarian Bookshop</title>
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
                <div >
                <h1 class="display-4 text-center "><small>Antiquarian Bookshop</small></h1>
        </div> 

        <div class="row m-0 p-0 " id="products">
            <!-- side nav -->
            <div class='col order-3 order-sm-1 bg-dark bg-gradient p-0 side-nav border-dark rounded mt-3'  id='links-side' >
            <?php
            sideNav();
            
            ?>    
      
            <div class="col col-sm-8 col-md-9 col-lg-10  p-3 order-5 ">

            <?php
            // call cart function
                cart();
            ?>
            
                <div class='card-deck'>
                <!-- display products -->
                <div class="row" >
                    <!-- fetch products -->
                    <?php
                    // display all products
                    if(!isset($_GET['category'])){

                        $select_prod_query="SELECT * FROM `product` WHERE status='1' ORDER BY `title`";
                        $result_prod_query=mysqli_query($con, $select_prod_query);
                        
                        fetchProductCards($result_prod_query);
                    
                    //display picked category
                    }else{
                        $category_name=$_GET['category'];
                        $select_cat_prod_query="SELECT * FROM `product` WHERE category='$category_name' AND status='1' ORDER BY `title`";
                        $result_cat_prod_query=mysqli_query($con, $select_cat_prod_query);
                        
                        if (mysqli_num_rows($result_cat_prod_query) > 0) {
                            
                            fetchProductCards($result_cat_prod_query);
                    
                        //display if no product belongs to a category
                        }else{
                            echo"
                            <div class='col  col-md-10 p-3 pt-5'>
                            <div class='alert alert-info text-center' role='alert'>
                                 <h4>No available products to display right now.<br/> We are sorry!</h4>
                            </div>
                            </div>";
                        }
                echo"</div>
            
            </div>";
                    }
            ?>
        </div>
    </div>

    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>