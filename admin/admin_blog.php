<?php
include('../admin/includs/header.php');
?>





<?php

$conn = mysqli_connect('localhost', 'root', '', 'database') or die('connection failed');


if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $text = $_POST['text'];
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `blog` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `blog`(image,name,text) VALUES('$image', '$name', '$text')") or die('query failed');

      if($add_product_query){
         if($image_size > 20000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT image FROM `blog` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   
   mysqli_query($conn, "DELETE FROM `blog` WHERE id = '$delete_id'") or die('query failed');
}

if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_text = $_POST['update_text'];

   mysqli_query($conn, "UPDATE `blog` SET name = '$update_name', text = '$update_text' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'uploaded_img/'.$update_image;
   $update_old_image = $_POST['update_old_image'];

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `blog` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('uploaded_img/'.$update_old_image);
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>add_blogs</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="../admin/css/admin_blog.css">
   <style>
       .btn a {
    text-decoration: none;
    background-color: #089da1;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
    margin-top: 9px;
    
}
.delete-btn{
   margin-left: 150px;

}

   </style>
   
</head>
<body>
   


<!-- product CRUD section starts  -->
<h1 class="title">blog</h1>
<section>

        <form class="form" method="post" enctype="multipart/form-data">
            <h3 class="add_product">add Blog</h3>
            <br><br><br>
            <input type="text" name="name" class="form--input" placeholder="enter product name" required >
            <input type="text" name="text" class="form--input" placeholder="enter product text" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="form--input" required>
            <input type="submit" value="add blog" name="add_product" class="form--submit">

        </form>

</section>

<!-- product CRUD section ends -->

<!-- show products  -->

<section class="show-products">

   <div class="box-container">

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `blog`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
      <div class="box">
         <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="text"><?php echo $fetch_products['text']; ?></div>
         <div class="btn">
            <a href="../admin/update_blog.php?name=<?php echo urlencode($fetch_products['name']); ?>" class='update-btn'>Update</a>
            <a href="?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirmDelete();">Delete</a>
         </div>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?> 
   </div>

</section>









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>


</body>
</html>











<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php')
?>