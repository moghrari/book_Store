<?php


include('../admin/includs/header.php');
$conn = mysqli_connect('localhost', 'root', '', 'database') or die('connection failed');

?>


<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">admis added</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <?php 
                                                $select_admin = mysqli_query($conn, "SELECT * FROM `admin`") or die('query failed');
                                                $number_of_admin = mysqli_num_rows($select_admin);
                                            ?>
                                            <h3><?php echo $number_of_admin; ?></h3>
                                        </div>
                                </div>
        </div>
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">users added</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php 
                                        $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                                        $number_of_users = mysqli_num_rows($select_users);
                                    ?>
                                    <h3><?php echo $number_of_users; ?></h3>
                                    </div>
                                </div>
        </div>
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">authors</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php 
                                        $select_author = mysqli_query($conn, "SELECT * FROM `authors`") or die('query failed');
                                        $number_of_author = mysqli_num_rows($select_author);
                                    ?>
                                    <h3><?php echo $number_of_author; ?></h3>
                                    </div>
                                </div>
        </div>
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">categories </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php 
                                        $select_category = mysqli_query($conn, "SELECT * FROM `categories`") or die('query failed');
                                        $number_of_category = mysqli_num_rows($select_category);
                                     ?>
                                     <h3><?php echo $number_of_category; ?></h3>
                                    </div>
                                </div>
        </div>
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">books added</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                        <?php 
                                            $select_books = mysqli_query($conn, "SELECT * FROM `book`") or die('query failed');
                                            $number_of_books = mysqli_num_rows($select_books);
                                        ?>
                                        <h3><?php echo $number_of_books; ?></h3>
                                    </div>
                                </div>
        </div>
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">messages</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <?php 
                                            $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
                                            $number_of_message = mysqli_num_rows($select_message);
                                        ?>
                                        <h3><?php echo $number_of_message; ?></h3>
                                    </div>
                                </div>
        </div>
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Books Opened</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php 
                                        $select_books_opened  = mysqli_query($conn, "SELECT * FROM `books_opened`") or die('query failed');
                                        $number_of_books_opened  = mysqli_num_rows($select_books_opened );
                                    ?>
                                    <h3><?php echo $number_of_books_opened ; ?></h3>
                                    </div>
                                </div>
        </div>
        <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">downloads </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                    <?php 
                                        $select_downloads = mysqli_query($conn, "SELECT * FROM `downloads`") or die('query failed');
                                        $number_of_downloads = mysqli_num_rows($select_downloads);
                                     ?>
                                     <h3><?php echo $number_of_downloads; ?></h3>
                                    </div>
                                </div>
        </div>
    </div>
</div>

<?php
include('../admin/includs/footer.php');
include('../admin/includs/scripts.php');
?>