<?php
include('../includes/connect.php');
include('../functions/common_functions.php');


?>
<div class="p-2">
    <h3 class="text-left m-3">All orders in the database:</h3>

    <table class='table table-hover' id='table-admin'>
  <thead>

    <tr class='border-bottom border-secondary' id='tr-admin'>
    <hr/>
      <th scope='col'>ID</th>
      <th scope='col'>User ID</th>
        <th scope='col'>Order date</th>
        
        <th scope='col'>Total price (EUR)</th>
        <th scope='col'>No. products</th>
        <th scope='col'>Product IDs</th>
        <th scope='col'>Status</th>
        
        <th >Edit</th>
        <th >Annul</th>
    </tr>
  </thead>
  <tbody>
<?php
$get_orders="SELECT * FROM `user_order`";
$result=mysqli_query($con,$get_orders);

if(!$result){
    echo"Could not fetch data.";
}else{
  if (mysqli_num_rows($result) > 0) {
    while($row=mysqli_fetch_assoc($result)){

      $order_id=$row['order_id'];
    $user_id=$row['user_id'];
    $order_date=$row['order_date'];
    
    $status=$row['status'];
    $total_products=$row['total_products'];
    $total_price=$row['total_price'];

    $price=number_format($total_price,2);


echo"
    <tr id='tr-admin'>
        <th scope='row'>$order_id</th>
            <td>$user_id</td>
            <td>$order_date</td>
            <td>$price EUR</td>
            <td >$total_products</td>";

//display products
$get_prods="SELECT * FROM `order_products` WHERE order_id='$order_id'";
$result_prods=mysqli_query($con,$get_prods);
        echo"<td>
        <ul class='list-group text-center' >";
          while($row_prods=mysqli_fetch_assoc($result_prods)){
            $product = $row_prods['product_id'];
            echo"
            <li class='list-group-item'>
              <a href='../product_details.php?product_id=$product' class='nav-link'>$product</a>
            </li>";
          }
          echo"
        </ul></td>


            <td >$status</td>       
            <td><a class='btn btn-light text-dark' href='./edit_order.php?edit_order=$order_id'><i class='fas fa-pen'></i></a></td>
            <td><a class='btn btn-light text-primary' href='./orders.php?annul=$order_id'><i class='fa-solid fa-arrow-rotate-left'></i></a></td>
      </th>";
}
echo"
</tr>
</tbody>
</table>
</div>";
}elseif (mysqli_num_rows($result) == 0){
  echo" <h2 class='text-center'>No orders yet.</h2>";
}}

//delete order - annullment
if(isset($_GET['annul'])){
  $order_to_delete_id=$_GET['annul'];

  $query="DELETE FROM `user_order` WHERE order_id='$order_to_delete_id'";
  $result_delete=mysqli_query($con,$query);

  $query_get="SELECT * FROM `order_products` WHERE order_id='$order_to_delete_id'";
  $result_get=mysqli_query($con,$query_get);
  while($row_get=mysqli_fetch_assoc($result_get)){
    $product_id = $row_get['product_id'];
    $query_back="UPDATE`product` SET `status`='1' WHERE `product_id`='$product_id'";
    $result_back=mysqli_query($con,$query_back);
  }

  $query_del="DELETE FROM `order_products` WHERE order_id='$order_to_delete_id'";
  $result_del=mysqli_query($con,$query_del);


  

  if(!$result_delete){
      print '<div class="alert alert-danger" role="alert">Error. Not possible to delete this order now.</div>';
  }else{
      echo"<script type='text/javascript'>window.open('./index.php','_self')</script>";
      print '<div class="alert alert-info" role="alert">Order deleted successsfully.</div>';
  }
}


?>