<?php
include('../includes/connect.php');
include('../functions/common_functions.php');

if(isset($_POST['insert_product'])){

    $title=$_POST['title'];

    $sname=$_POST['author-s-name'];
    if(isset($_POST['author-f-name'])){
        $fname=$_POST['author-f-name'];
        $author=$sname . " " . $fname;
    }else{
        $author=$sname;
    }

    $release_date=$_POST['year'];
    $isbn=$_POST['isbn'];
    $publisher=$_POST['publisher'];
    $category=$_POST['category'];
    $condition=$_POST['condition'];
    $description=$_POST['description'];
    $price=$_POST['price'];

    // accessing image
    $photo=$_FILES['photo']['name'];
    // accessing image tmp name
    $photo_tmp=$_FILES['photo']['tmp_name'];

    //checking empty conditions
    if($title=="" or $author=="" or $category== "" or $condition=="" or $price=="" or $photo==""){
        print '<div class="alert alert-warning" role="alert">Please fill all required fields.</div>';
    }else{
        move_uploaded_file($photo_tmp,"./product_images/$photo");

        //insert query
        $insert_product_query="INSERT INTO `product`(`title`, `author`, `release_year`, 
        `isbn`, `publisher`, `category`, `photo`, `price`, `condition`, `description`, 
        `insert_date`, `status`) VALUES ('$title','$author','$release_date','$isbn',
        '$publisher','$category','$photo','$price','$condition','$description',NOW(), 1)";

        $result_insert_prod_query=mysqli_query($con,$insert_product_query);
    }

}
?>
       <form action="" method="POST" enctype="multipart/form-data" class="p-4">
        <h3 class="text-left mb-3">Add a new book</h3>
            <div class="form outline mb-4">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="" tabindex="1" Required>
                </div>
                
                <label for="author-f-name" class="form-label">Author</label>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="author-f-name" name="author-f-name" placeholder="First name" tabindex="2">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="author-s-name" name="author-s-name" placeholder="Last name"tabindex="3" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="release-date" class="form-label">Year of release</label>
                    <input type="text" name="year" id="release-date" class="form-control" pattern="[0-9]{4,4}" placeholder="Enter 4 digits" tabindex="10">
                </div>

                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" name="isbn" id="isbn" pattern="[0-9]{10,13}" class="form-control" placeholder="Enter only digits" tabindex="20">
                </div>

                <div class="mb-3">
                    <label for="publisher" class="form-label">Publisher</label>
                    <input type="text" name="publisher" id="publisher" class="form-control" placeholder="" tabindex="22">
                </div>

                <!-- category input -->
                <div class="form-group mb-3">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="category" tabindex="25" required>
                    <option selected>Select book category</option>
                        <?php
                        $select_cat_query="SELECT * FROM `category`";
                        $result_cat_query=mysqli_query($con,$select_cat_query);
                        while($row_data=mysqli_fetch_assoc($result_cat_query)){
                            $category_id=$row_data['category_id'];
                            $category_name=$row_data['name'];
                            echo "<option value='$category_id'>";
                            print $category_name."</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- condition input -->
                <div class="form-group mb-3">
                    <label for="condition">Condition</label>
                    <select class="form-control select-condition mb-1" id="condition" name="condition" tabindex="30" required>
                        <option selected>Select book condition</option>
                        <?php
                        $select_condition_query="SELECT * FROM `condition`";
                        $result_condition_query=mysqli_query($con,$select_condition_query);
                        while($row_data=mysqli_fetch_assoc($result_condition_query)){
                            $condition=$row_data['name'];
                            echo "<option value='$condition'>";
                            print $condition."</option>";
                        }
                        ?>
                    </select>
                    <button type="button" class="btn btn-light" data-container="body" data-toggle="popover" data-placement="bottom" data-content="">
                        <details><summary>Explain...</summary>
                            <?php
                            showConditionInstrustions();
                            ?>
                        </details>
                    </button>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="textarea" name="description" id="description" rows="3" maxlength="300" class="form-control" tabindex="32">
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label">Product price</label>
                    <input type="number" name="price" id="price" class="form-control" pattern="[0-9]+([\.][0-9]+)?" step="0.01" placeholder="eg. 4.20" tabindex="35" required>
                </div>

                <div class="form-group">
                    <label for="photo">Select a photo to display: </label>
                    <input type="file" class="form-control-file" id="photo" accept="image/*" name="photo" tabindex="40" required>
                </div>

            </div>

            <input type="submit" class="btn btn-success" value="Submit" name="insert_product" tabindex="50"/>

        </form>
        <?php
            if(isset($_POST['insert_product'])){
                if($result_insert_prod_query){
                    print '<div class="alert alert-success" role="alert">Success. The product has been inserted to the database.</div>';
                }else{
                    print '<div class="alert alert-danger" role="alert">Failure. The product could not be added to the database.</div>';
                }
            }
        ?>