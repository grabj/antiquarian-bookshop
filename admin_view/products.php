<?php
include('../includes/connect.php');
include('../functions/common_functions.php');

?>
<div class="p-2">
    <h3 class="text-left m-3 ">All products in the database:</h3><hr/>

    <table class='table table-hover' id='table-admin'>
  <thead>

    <tr class='border border-secondary small' >
      <th scope='col'>ID</th>
      <th scope='col'>Photo</th>
        <th scope='col'>Title</th>
        <th scope='col'>Author</th>
        <th scope='col'>ISBN</th>
        <th scope='col'>Category</th>
        <th scope='col'>Publisher</th>
        <th scope='col'>Published</th>
        <th scope='col'>Condition</th>
        <th scope='col'>Condition description</th>
        <th scope='col'>Price (EUR)</th>
        <th scope='col'>Status</th>
        <th scope='col'>Modified</th>
        <th scope='col'>Edit</th>
        <th scope='col'>Delete </th>
        
        <th scope='col'>See on site</th>
    </tr>
  </thead>
  <tbody>
<?php
$get_products="SELECT * FROM `product`";
$result=mysqli_query($con,$get_products);

if(!$result){
    echo"Could not fetch data.";
}else{

    
while($row=mysqli_fetch_assoc($result)){

    $product_id=$row['product_id'];
    $product_title=$row['title'];
    $product_author=$row['author'];
    $category=$row['category'];
    $condition=$row['condition'];
    $product_photo=$row['photo'];
    $status=$row['status'];
    $description=$row['description'];
    $ISBN=$row['isbn'];
    $release_year=$row['release_year'];
    $publisher=$row['publisher'];
    $product_price=$row['price'];
    $insert_date=$row['insert_date'];

    if($ISBN==0){
        $ISBN=null;
    }
    if($release_year==0){
        $release_year=null;
    }
    if($status ==1){
        $status_show='<i class="fa-solid fa-check"></i>';
    }elseif($status==0){
        $status_show='<i class="fa-solid fa-x"></i>';
    }
    else{
        $status_show='<i class="fa-solid fa-ellipsis"></i>';
    }
    $price=number_format($product_price,2);
echo"
    <tr id='tr-admin'>
        <th scope='row'>$product_id</th>
            <td ><img src='./product_images/$product_photo' id='cart-img'  alt='product picture' class='product_img'></a></td>
            <td>$product_title</td>
            <td>$product_author</td>
            <td>$ISBN</td>
            <td>$category</td>
            <td>$publisher</td>
            <td >$release_year</td>
            <td >$condition</td>
            <td class='small'>$description</td>
            <td>$price</td>
            <td>$status_show</td>
            <td>$insert_date</td>
            <td><a class='btn btn-light text-dark' href='./edit_product.php?edit_product=$product_id'><i class='fas fa-pen'></i></a></td>
            <td><a class='btn btn-light text-danger' href='./products.php?delete=$product_id'><i class='fas fa-trash'></i></a></td>
            
      <td><a href='../product_details.php?product_id=$product_id'><i class='far fa-share-square'></i></a></td>
</th></tr>";
}
   
}

//delete product
if(isset($_GET['delete'])){
    $product_to_delete_id=$_GET['delete'];
    $query="DELETE FROM `product` WHERE product_id='$product_to_delete_id'";
    $result_delete=mysqli_query($con,$query);
    if(!$result_delete){
        print '<div class="alert alert-danger" role="alert">Error. Not possible to delete this product now.</div>';
    }else{
        echo"<script type='text/javascript'>window.open('./index.php','_self')</script>";
        print '<div class="alert alert-info" role="alert">Product deleted successsfully.</div>';
    }
  }


?>

</tbody>
</table>
</div>