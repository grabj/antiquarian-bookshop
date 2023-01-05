<!-- connect file -->
<?php 
session_start();
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
    
    <div class="container-fluid p-0 ">
        <?php
        include('./includes/navbar.php');
        ?>        
        <div >
                <h1 class="display-4 text-center"><small>Antiquarian Bookshop</small></h1>
        </div> 

        <div class="row m-0 p-0">
            <!-- side nav -->
            <div class='col-sm order-3 order-sm-1 bg-dark  p-0 side-nav border-dark rounded mt-3 bg-gradient'  id='links-side' >
            <?php
                sideNav();
            ?>
            <div class="col col-sm-8 col-md-9 col-lg-10 p-3 px-5 order-xs-2 order-sm-2">
            <?php
            // call cart function
                cart();
            ?>
                <!-- display product -->
                    <div class="row">

                    <?php 
                            //getting product info
                            $product_id=$_GET['product_id'];
                            $select_prod_query="SELECT * FROM `product` WHERE product_id=$product_id";
                            $result_prod_query=mysqli_query($con,$select_prod_query);
                            if ($row=mysqli_fetch_assoc($result_prod_query)){
                
                                $product_title=$row['title'];
                                $product_photo=$row['photo'];
                                $product_price=$row['price'];
                                $product_author=$row['author'];
                                $product_release=$row['release_year'];
                                $product_isbn=$row['isbn'];
                                $product_publisher=$row['publisher'];
                                $product_category=$row['category'];
                                $product_condition=$row['condition'];
                                $product_description=$row['description'];
                                $product_status=$row['status'];

                                $price=number_format($product_price,2);
                            }
                            
                        echo"
                        <div class='col col-md-5 order-3'>
                            <img src='./admin_view/product_images/$product_photo' alt='product photo' id='img-details' class='border rounded'/>
                        </div>";

                        echo"
                        <div class='col-md-7 order-1  mb-2'>
                            <div class='card border-dark'>
                                <div class='card-header pb-0'>
                                    <p><strong>Book title: $product_title</p>
                                    <p class='text-muted'>Author: $product_author</p></strong>
                                </div>
                                <div class='card-body'><br/>";
                                    if (isset ($product_publisher)){
                                        echo"<p class>Publisher: $product_publisher</p>";
                                    }
                                    if (isset ($product_isbn) && ($product_isbn!=0)){
                                        echo"<p>ISBN number: $product_isbn</p>";
                                    }
                                    if (isset ($product_release) && ($product_release!=0)){
                                        ECHO"<p>Year of release: $product_release</p>";
                                        
                                    }
                                    echo"
                                    <br/><p class='mb-0'>Condition of the book: $product_condition</p>
                                    
                                    <button type='button' class='btn btn-light btn-sm' data-container='body' data-toggle='popover' data-placement='bottom' data-content='text'><details><summary>Explain...</summary>";
                                        showConditionInstrustions();
                                    echo"
                                    </details></button>
                                    <p>Additional information: ";
                                    if(($product_description != "")){
                                        echo"$product_description";
                                    }
                                    else{echo"none.";}

                                    echo"
                                    </p><br/><a href='index.php?category=$product_category' link'>See more from this category...</a>

                                </div>
                                <div class='card-footer'>";
                                echo"<strong><p>Price: <span class='d-inline border-danger border-bottom'>
                                $price EUR
                                </span></p></strong>";
                                //add to cart GET
                                if(isset($_SESSION['user_id']) && $product_status==1){
                                    echo"<a href='index.php?add_to_cart=$product_id' class='btn btn-warning'>
                                    Add to cart <i class='fa-solid fa-cart-arrow-down'></i></a>";
                                }
                                else{
                                    echo"
                                    <a href='#' class='btn btn-secondary disabled'>
                                    Add to cart <i class='fa-solid fa-cart-arrow-down'></i></a>
                                    <span>Log in to start shopping!</span>";
                                }
                                
                                
                                ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>