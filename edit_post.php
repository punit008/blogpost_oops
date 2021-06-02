<?php
session_start();
require_once '../BlogPost/dbconnect.php';


if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}


// print_r($result);



if (isset($_POST['submit'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['desc']);
    $id = $_GET['id'];

    $sql = "UPDATE `posts` SET `title`= :title,`description`= :description WHERE post_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);
    $result = $stmt->execute();
    if ($result === true) {
        $post_id = $_GET['id'];
        $user_id = $_SESSION['user_id'];
        $sql = "INSERT INTO `user_posts`(`user_id`, `post_id`) VALUES (:user_id, :post_id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':post_id', $post_id);
        $result = $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $message = "Post Updated";
        } else {
            $message = "Fail to Update post";
        }
    } else {
        $message = "Not able to insert the given data";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once '../BlogPost/components/head.php'; ?>
    <title>Post Edit</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Include PHP Sidebar -->
            <?php include_once '../BlogPost/components/sidebar.php'; ?>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Include PHP Topbar -->
                    <?php include_once('../BlogPost/components/topbar.php'); ?>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Post</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><?php include_once '../BlogPost/components/count.php'; ?>
                            <?php echo $count; ?>
                        </a>
                    </div>


                    <div class="row">
                        <div class="col-xl-12 col-md-6 mb-4 ">
                            <div class="card mx-auto" style="width: 50rem;">
                                <div class="card-header">
                                    Post
                                </div>
                                <div class="card-body">
                                    <?php if (isset($message)) { ?>
                                        <div class="alert alert-success text-center col-6 mx-auto">
                                            <h4><?php echo $message; ?></h4>
                                        </div>
                                    <?php } ?>
                                    <?php

                                    $id = $_GET['id'];
                                    $sql = "SELECT * FROM `posts` WHERE post_id = :id";
                                    $stmt = $conn->prepare($sql);
                                    $stmt->bindParam(':id', $id);
                                    $stmt->execute();

                                    $result =  $stmt->fetch(PDO::FETCH_ASSOC);
                                    $title = $result["title"];
                                    $description = $result["description"];
                            
                                    ?>
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-6 mb-4">
                                                <label for="title">Title</label>
                                                <input type="text" class="form-control" name="title" required value="<?php echo $title;?>">
                                            </div>
                                            <div class="col-xl-12 col-md-6 mb-4">
                                                <label for="desc" class="mt-1">Description</label>
                                                <textarea  name="desc" id="desc" cols="20" rows="5" class="form-control" required><?php echo $description;?></textarea>
                                            </div>
                                            <div class="col-xl-12 col-md-6 mb-4">
                                                <button class="btn btn-primary" name="submit">Submit</button>
                                            </div>

                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <!-- Include PHP Footer -->
                <?php include_once '../BlogPost/components/footer.php'; ?>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>