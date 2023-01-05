<?php
include('../includes/connect.php');
include('../functions/common_functions.php');


?>
<div class="p-2">
    <h3 class="text-left m-3">All users in the database:</h3>

    <table class='table table-hover' id='table-admin'>
  <thead>
    <tr class='border-bottom border-secondary' id='tr-admin'>
    <hr/>
      <th scope='col'>ID</th>
      <th scope='col'>Email</th>
      <th scope='col'>First name</th>
      <th scope='col'>Last name</th>
      
      <th scope='col'>User since</th>
        
      <th scope='col'>Edit</th>
      <th scope='col'>Delete </th>
  
    </tr>
  </thead>
  <tbody>
<?php

$get_products="SELECT * FROM `user`";
$result=mysqli_query($con,$get_products);

if(!$result){
    echo"Could not fetch data.";
  }else{
    if (mysqli_num_rows($result) > 0) {
      while($row=mysqli_fetch_assoc($result)){

        $user_id=$row['user_id'];
        $fname=$row['first_name'];
        $email=$row['email'];
        $lname=$row['last_name'];
        $date=$row['creation_date'];

        echo"
    <tr id='tr-admin'>
        <th scope='row'>$user_id</th>
            <td>$email</td>
            <td>$fname</td>
            <td>$lname</td>
            
            <td>$date</td>

            <td><a class='btn btn-light text-dark' href='./edit_user.php?edit_user=$user_id'><i class='fas fa-pen'></i></a></td>

            <td><a class='btn btn-light text-danger' href='./users.php?delete=$user_id'><i class='fas fa-user-slash'></i></a></td>

            
</th></tr>";
      }
}elseif (mysqli_num_rows($result) == 0){
  echo" <h2 class='text-center'>No registered users.</h2>";
}}
?>

</tbody>
</table>

<?php
//delete user
if(isset($_GET['delete'])){
  $user_to_delete_id=$_GET['delete'];
  $query="DELETE FROM `user` WHERE user_id='$user_to_delete_id'";
  $result_delete=mysqli_query($con,$query);
  if(!$result_delete){
      print '<div class="alert alert-danger" role="alert">Error. Not possible to delete this user now.</div>';
  }else{
      echo"<script type='text/javascript'>window.open('./index.php','_self')</script>";
      print '<div class="alert alert-info" role="alert">User deleted successsfully.</div>';
  }
}

?>
</div>