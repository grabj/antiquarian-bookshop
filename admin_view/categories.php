<?php
include('../includes/connect.php');
include('../functions/common_functions.php');

?>
<div class="p-2">
    <h3 class="text-left m-3">All categories in the database:</h3>

    <table class='table table-hover' id='table-admin'>
  <thead>

    <tr class=' border-secondary' >
    <hr/>
      <th scope='col'>ID</th>
      <th scope='col'>Name</th>        
        <th scope='col'>Edit</th>
        <th scope='col'>Delete*</th>
        <th scope='col'>See on site</th>
    </tr>
  </thead>
  <tbody>

  <?php
$get_cats="SELECT * FROM `category`";
$result=mysqli_query($con,$get_cats);

if(!$result){
    echo"Could not fetch data.";
  }else{
    if (mysqli_num_rows($result) > 0) {
      while($row=mysqli_fetch_assoc($result)){

        $category_id=$row['category_id'];
        $name=$row['name'];
  echo"
      <tr id='tr-admin'>
          <th scope='row'>$category_id</th>
              <td>$name </td>
              <td><a class='btn btn-light text-dark' href='./edit_category.php?edit_category=$category_id'><i class='fas fa-pen'></i></a></td>";
        
        //make unable to delete busy categories
        $new_query = "SELECT * FROM `product` WHERE category=$category_id";
        $new_result=mysqli_query($con,$new_query);
        if(mysqli_num_rows($new_result) > 0) {
          echo"
          <td><a class='btn btn-light text-secondary disabled' href=''><i class='fas fa-trash'></i></a></td>";
        }
        else{
          echo"
          <td><a class='btn btn-light text-danger' href='./categories.php?delete=$category_id'><i class='fas fa-trash'></i></a></td>";
        }

        echo"
          <td><a href='../index.php?category=$category_id'><i class='far fa-share-square'></i></a></td>
  </th></tr>";

}}elseif (mysqli_num_rows($result) == 0){
  echo" <h2 class='text-center'>No categories in DB</h2>";
}}
?>
  </tbody>
  </table>
<p>*If you wish to delete a category, delete all products that belong to it.</p>
<?php
//delete category
if(isset($_GET['delete'])){
    $cat_to_delete_id=$_GET['delete'];
    $query="DELETE FROM `category` WHERE category_id='$cat_to_delete_id'";
    $result_delete=mysqli_query($con,$query);
    if(!$result_delete){
        print '<div class="alert alert-danger" role="alert">Error. Not possible to delete this category now.</div>';
    }else{
        echo"<script type='text/javascript'>window.open('./index.php','_self')</script>";
        print '<div class="alert alert-info" role="alert">PCategory deleted successsfully.</div>';
    }
  }
?>
</div>