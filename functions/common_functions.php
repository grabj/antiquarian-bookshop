<?php

//getting product cards (instances) to display on main page
function fetchProductCards($result_query){
    global $con;
    if (mysqli_num_rows($result_query) > 0) {
        while($row=mysqli_fetch_assoc($result_query)){
            $product_status=$row['status'];
            if($product_status=="1"){
                $product_id=$row['product_id'];
                $product_title=$row['title'];
                $product_photo=$row['photo'];
                $product_price=$row['price'];
                $product_author=$row['author'];

                $price=number_format($product_price,2);
                echo "
                <div class='col-md-4 col-xl-3 mb-3 h-100 d-inline-block'>
                    <div class='card border-dark bg-white'>
                        <a href='product_details.php?product_id=$product_id'>
                            <img class='card-img-top pt-2' src=./admin_view/product_images/$product_photo alt='Picture of a product'>
                        </a>
                        <div class='card-body'>
                            <p class='card-title'>$product_title
                                <p class='text-muted'>$product_author</p>
                            </p>
                            <p class='card-text text-center'>
                            <span class='border-danger border-bottom'> $price EUR
                            </span></p>
                        </div>
                        <div class='card-footer bg-light text-center border-dark'>";
                            //view details button
                            echo"<a href='product_details.php?product_id=$product_id' class='btn btn-info my-1 mx-1'>
                                View details</a>";
                            //add to cart button
                                if(isset($_SESSION['user_id'])){
                                    echo"<a href='index.php?add_to_cart=$product_id' class='btn btn-warning'>
                                    Add to cart <i class='fa-solid fa-cart-arrow-down'></i></a>";
                                }
                                else{
                                    echo"<a href='#' class='btn btn-secondary disabled'>
                                    Add to cart <i class='fa-solid fa-cart-arrow-down'></i></a>";
                                }
                                echo"
                        </div>
                    </div>
                </div>";
            }
        }   
    }
}


//side nav display
function sideNav(){
    global $con;
    echo"            
                <ul class='navbar-nav me-auto text-center p-2 bg-gradient'>
                    <li class='nav-item rounded mb-0 text-light '>
                    <h4> <a href='./' class='nav-link' >All products</a></h4>
                    </li>
                    <li class='nav-item order rounded'>
                        <a class='nav-link text-light'><h4>Categories</h4></a>
                    </li>";
                        $select_cat_query="SELECT * FROM `category` ORDER BY `name`";
                        $result_cat_query=mysqli_query($con,$select_cat_query);
                        while($row_data=mysqli_fetch_assoc($result_cat_query)){
                            $cat_name=$row_data['name'];
                            $cat_id=$row_data['category_id'];
                        echo " <li class='nav-item'>
                            <a href='index.php?category=$cat_id' class='nav-link text-light '>$cat_name</a>
                            </li>";
                        }
                    echo" 
                </ul>
        </div>";
}


//show instructions how to rate books condition
function showConditionInstrustions(){
    global $con;
    $select_condition_query="SELECT * FROM `condition`";
    $result_condition_query=mysqli_query($con,$select_condition_query);
    echo '<small class="p-0">';
    while($row_data=mysqli_fetch_assoc($result_condition_query)){
        
        print "<p><b>" . $row_data['name']. "</b>" . ": " . $row_data['description']. "</p>";
    }
    echo"</small>";
}


//display different navbar for guest and logged user.
function mainNavbar(){
    echo"        <div class='d-flex'>
                <span class='nav-text text-light p-1 m-auto'>";
    
    if(!isset($_SESSION['user_id']))
    {
        echo"
        Welcome Guest!</span>
        <a class=' btn btn-outline-info border-info px-4 p-1 mx-4' href='./user_view/login.php'>Login</a>
        <a class=' btn btn-outline-light border px-3 p-1' href='./user_view/register.php'>Register</a>
            </div>";
    }
    else{
        echo"Welcome ";
        echo $_SESSION['user_first_name'];
        echo"!</span>
        <a class=' btn btn-outline-info border-info p-1 mx-4' href='./user_view/user_settings.php'>Account details</a>
        <a class=' btn btn-outline-warning px-3 p-1 ' href='./user_view/logout.php'>Log out</a>
            </div>";
    }
}


//add to cart function
function cart(){
    if(isset($_SESSION['user_id'])){
        if(isset($_GET['add_to_cart'])){
            global $con;
            $get_product_id=$_GET['add_to_cart'];
            
            $user_id=$_SESSION['user_id'];
            //check if product already in a cart
            $select_query="SELECT * FROM `cart` WHERE product_id='$get_product_id' AND user_id='$user_id'";
            $result_insert=mysqli_query($con,$select_query);

            //check if product is available
            $select_query2="SELECT * FROM `product` WHERE product_id='$get_product_id' AND status='active'";
            $result_insert2=mysqli_query($con,$select_query2);

            if(mysqli_num_rows($result_insert)>0){
                print '<div class="alert alert-info text-center" role="alert">You picked the same item twice.</div>';
            }
            elseif(mysqli_num_rows($result_insert2)>0){
                print '<div class="alert alert-warning text-center" role="alert">Item is not available anymore.</div>';
            }else{
                $add_query="INSERT INTO `cart`(`user_id`, `product_id`) VALUES ('$user_id','$get_product_id')";
                $result=mysqli_query($con,$add_query);
                print '<div class="alert alert-success text-center" role="alert">Item added to cart.</div>';
            }
        }
        if(isset($_GET['order'])){
            count_items();
        }
    }
}


//function to display num of products in a cart on navbar
function count_items(){
    global $con;
    $user_id=$_SESSION['user_id'];
    $select_query="SELECT * FROM `cart` WHERE user_id='$user_id'";
        $result_insert=mysqli_query($con,$select_query);
        return mysqli_num_rows($result_insert);
}


//count total price of an active cart
function count_total_price(){
    global $con;
    $sum=0;
    $user_id=$_SESSION['user_id'];
    $select_query="SELECT * FROM `cart` WHERE user_id='$user_id'";
        $result=mysqli_query($con,$select_query);
    while($row=mysqli_fetch_array($result)){
        $product_id=$row['product_id'];

        $select_products="SELECT 'price' FROM `cart` WHERE product_id='$product_id'";
        $result_select=mysqli_query($con,$select_products);
        while($row_prod=mysqli_fetch_array($result_select)){
            $product_price=array($row_prod['price']);
            $sum=array_sum($product_price);
        }
    }
    return $sum;
}


//display field with appended possibility to change user's argument
function lineAttribute($arg, $arg2){
    global $con;
    echo"
    <dt class='col-sm-3'>$arg2:</dt>
    <dd class='col-sm-9'>
        <form method='POST' action=''>
        <div class='input-group mb-3'>
            <input type='text' class='form-control' name='input' placeholder='$arg' value='$arg'>
            <div class='input-group-append'>
                <button class='btn btn-outline-danger' name='$arg2' type='submit'>Change</button>
            </div>      
        </div></form>
    </dd>";
    //update arguments that differ
    if(isset($_POST[$arg2])){
        $arg3=$_POST['input'];
        if ($arg3!==$arg && $arg3!=""){
            $arg5=$_SESSION['user_id'];
            $query="UPDATE`user` SET `$arg2`='$arg3' WHERE `user_id`='$arg5'";
            $result_insert=mysqli_query($con,$query);
            if($result_insert){

                print '<div class="alert alert-success" role="alert">Success. You have changed your '. $arg2.'.</div>';

            }
            else{
                print '<div class="alert alert-danger" role="alert">Failure.</div>';
            }
        }
        else{
            print '<div class="alert alert-warning" role="alert">Values cannot be empty or unchanged.</div>';
        }
    }
    
}


//display field with appended possibility to change user's argument (for admin's management panel)
function lineAttributeAdmin($arg, $arg2, $user){
    global $con;
    echo"
    <dt class='col-sm-3'>$arg2:</dt>
    <dd class='col-sm-9'>
        <form method='POST' action=''>
        <div class='input-group mb-3'>
            <input type='text' class='form-control' name='input' placeholder='$arg' value='$arg'>
            <div class='input-group-append'>
                <button class='btn btn-outline-danger' name='$arg2' type='submit'>Edit</button>
            </div>
            
        </div></form>
    </dd>";
    //update arguments that differ
    if(isset($_POST[$arg2])){
        $arg3=$_POST['input'];
        if ($arg3!==$arg && $arg3!==""){

            $query="UPDATE`user` SET `$arg2`='$arg3' WHERE `user_id`='$user'";
            $result_insert=mysqli_query($con,$query);
            if($result_insert){

                print '<div class="alert alert-success" role="alert">Success. You have changed value.</div>';

            }
            else{
                print '<div class="alert alert-danger" role="alert">Failure.</div>';
            }
        }
        else{
            print '<div class="alert alert-warning" role="alert">Values cannot be empty or unchanged.</div>';
        }
    }
}


//display field with appended possibility to change product's argument
function lineProductInfo($arg, $arg2, $product){
    global $con;
    echo"
    <dt class='col-sm-3'>$arg2:</dt>
    <dd class='col-sm-9'>
        <form method='POST' action=''>
        <div class='input-group mb-3'>
            <input type='text' class='form-control' name='input' placeholder='$arg' value='$arg'>
            <div class='input-group-append'>
                <button class='btn btn-outline-danger' name='$arg2' type='submit'>Edit</button>
            </div>
            
        </div></form>
    </dd>";
    //update argument that differ
    if(isset($_POST[$arg2])){
        $arg3=$_POST['input'];
        if ($arg3!==$arg && $arg3!==""){
            $query="UPDATE`product` SET `$arg2`='$arg3' WHERE `product_id`='$product'";
            $result_insert=mysqli_query($con,$query);
            if($result_insert){

                print '<div class="alert alert-success" role="alert">Success. You have changed a value.</div>';
            }
            else{
                print '<div class="alert alert-danger" role="alert">Failure.</div>';
            }
        }
        else{
            print '<div class="alert alert-warning" role="alert">Values cannot be empty or unchanged.</div>';
        }
    }
}


//display field with appended possibility to change order's argument
function lineOrderInfo($arg, $arg2, $order){
    global $con;
    echo"
    <dt class='col-sm-3'>$arg2:</dt>
    <dd class='col-sm-9'>
        <form method='POST' action=''>
        <div class='input-group mb-3'>
            <input type='text' class='form-control' name='input' placeholder='$arg' value='$arg'>
            <div class='input-group-append'>
                <button class='btn btn-outline-danger' name='$arg2' type='submit'>Edit</button>
            </div>
            
        </div></form>
    </dd>";
    //update only argument that differ
    if(isset($_POST[$arg2])){
        $arg3=$_POST['input'];
        if ($arg3!==$arg && $arg3!==""){
            $query="UPDATE`user_order` SET `$arg2`='$arg3' WHERE `order_id`='$order'";
            $result_insert=mysqli_query($con,$query);
            if($result_insert){

                print '<div class="alert alert-success" role="alert">Success. You have changed a value.</div>';
            }
            else{
                print '<div class="alert alert-danger" role="alert">Failure.</div>';
            }
        }
        else{
            print '<div class="alert alert-warning" role="alert">Values cannot be empty or unchanged.</div>';
        }
    }
}


//make an order function
function order(){
    global $con;
    //get a cart of an active user
    $user_id=$_SESSION['user_id'];
    $status='1';
    $select_query="SELECT * FROM `cart` WHERE user_id='$user_id'";
      $result_select_cart=mysqli_query($con,$select_query);
      $count=0;
      $price_total=0;

      //get user's product ids to get all values required to insert order query
    while($row=mysqli_fetch_array($result_select_cart)){
        $product_id=$row['product_id'];
    
        $select_products="SELECT * FROM `product` WHERE product_id='$product_id'";
        $result_select=mysqli_query($con,$select_products);
        while($row_prod=mysqli_fetch_array($result_select)){
            $price=$row_prod['price'];
            $price_total+=$price;
            $count+=1;
        }
    }
    //insert order query
    $make_order="INSERT INTO `user_order`(`user_id`, `order_date`, 
    `total_price`, `total_products`, `status`) VALUES ('$user_id',NOW(),'$price_total','$count','active')";

     $result_insert=mysqli_query($con,$make_order);

     //get last inserted order id 
     if ($result_insert) {
        $last_id = mysqli_insert_id($con);
  
        //get a cart to inset into a DB list of ordered products
        $select_query="SELECT * FROM `cart` WHERE user_id='$user_id'";
        $result_select_cart=mysqli_query($con,$select_query);
        while($row=mysqli_fetch_array($result_select_cart)){
            $product_id=$row['product_id'];
        
            $select_products="SELECT * FROM `product` WHERE product_id='$product_id'";
            $result_select=mysqli_query($con,$select_products);
            while($row_prod=mysqli_fetch_array($result_select)){

                //update table orders-products
                $insert_product="INSERT INTO `order_products`(`order_id`,`product_id`) VALUES ('$last_id', '$product_id')";
                $result_insert_prods=mysqli_query($con,$insert_product);

                //update product status to unavailable in product table
                $update_products="UPDATE `product` SET `status`='0' WHERE `product_id`='$product_id'";
                $result_update=mysqli_query($con,$update_products);
            
            }
        }
        if($result_update && $result_insert && $result_insert_prods){

            print '<div class="alert alert-success" role="alert">Success. You have made an order. See your account details.</div>';
        }
        else{
            print '<div class="alert alert-danger" role="alert">Error. Not possible to checkout now.</div>';
        }
    }
    else{
        print '<div class="alert alert-danger" role="alert">Error. Could not create new order.</div>';
    }

}


?>
