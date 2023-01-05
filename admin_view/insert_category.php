<?php
include('../includes/connect.php');
?>


<form action="" method="POST" class="p-4">
    <h3 class="text-left mb-4">Add a new category</h3>
    <div class="form outline mb-3">
        <div class="input-group mb-4">
            <span class="input-group-text ">
                <i class="fa-solid fa-receipt"></i></span>
            <input type="text" class="form-control" name="cat_name" placeholder="Category name" maxlength="30" minlength="2" aria-label="Insert category" required pattern=".*\S.*">
            
        </div>
        <input type="submit" class="btn btn-success" value="Submit" name="insert_cat" tabindex="50">
    </div>
        
        
</form>
<?php
        if(isset($_POST['insert_cat'])){
            
            //check if category exists in database
            $category_name=$_POST['cat_name'];
            $compare_query="SELECT * FROM `category` WHERE name='$category_name'";
            $result_compare=mysqli_query($con,$compare_query);
            $number=mysqli_num_rows($result_compare);
            if($number>0){
                print '<div class="alert alert-danger" role="alert">
                Category has not been inserted - this category already exists.
                </div>';

            }else{
                $query="INSERT INTO `category` (name) VALUES ('$category_name')";
                $result=mysqli_query($con,$query);
                if($result){
                    print '<div class="alert alert-success" role="alert">
                    Category has been inserted successfully.
                    </div>';
                }else{
                    print '<div class="alert alert-danger" role="alert">
                    Category has not been inserted!
                    </div>';
                }
            }
        }
?>