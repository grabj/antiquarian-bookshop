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
    <title>Edit category - Antiquarian Bookshop</title>
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
        <h3 class=" pb-2 m-3">Edit category</h3>
        <dl class="row">

            <?php
            if(isset($_GET['edit_category']))
                $category_id = $_GET['edit_category'];
                $search_query="SELECT * FROM `category` WHERE category_id='$category_id'";
                $result_search=mysqli_query($con,$search_query);
                $number=mysqli_num_rows($result_search);
                if($number>0){
                    $row_data=mysqli_fetch_assoc($result_search);
                    $category=$row_data['name'];
                    
                    echo"
                    <dt class='col-sm-3 py-3'>Category ID:</dt>
                    <dd class='col-sm-9 py-3'>$category_id</dd>";
                    
                    //create form for an attribute and check changed
                    echo"
                    <dt class='col-sm-3'>Name:</dt>
                    <dd class='col-sm-9'>
                        <form method='POST' action=''>
                        <div class='input-group mb-3'>
                            <input type='text' class='form-control' name='input' placeholder='$category' value='$category'>
                            <div class='input-group-append'>
                                <button class='btn btn-outline-danger' name='submit' type='submit'>Edit</button>
                            </div>
                        </div></form>
                    </dd>";
                    //update arguments that differ
                    if(isset($_POST['submit'])){
                        $new_name=$_POST['input'];
                        if ($new_name!==$category && $new_name!==""){
                            $query="UPDATE`category` SET `name`='$new_name' WHERE `category_id`='$category_id'";
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
                }else{
                    print '<div class="alert alert-danger" role="alert">Data could not be fetched. Try again later.</div>';
                }
?>
        </dl>
    </div>
</div>
</body>
</html>


