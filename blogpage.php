<?php


session_start();
require_once '../BlogPost/dbconnect.php';


if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

$id = $_GET['id'];
$sql = "SELECT MIN(posts.post_id), posts.title, posts.description FROM `user_posts` INNER JOIN posts ON user_posts.post_id = posts.post_id WHERE user_posts.post_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$desc = $result['description'];
$title = $result['title'];




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once '../BlogPost/components/head.php'; ?>
    <title>BlogPost</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Blog</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><?php include_once '../BlogPost/components/count.php'; ?>
                            <?php echo $count; ?>
                        </a>
                    </div>


                    <div class="row">
                        <div class="col-xl-12 col-md-6 mb-4 ">
                            <div class="card mx-auto" style="width: 50rem;">
                                <div class="card-header">
                                    <?php echo $title; ?>
                                </div>
                                <div class="card-body">
                                    <div class="float-end" >
                                        <h5 class="text-primary">Authors</h5>
                                        <ul style="list-style-type: none;" class="px-0">
                                        <?php 
                                            $id = $_GET['id'];
                                            $sql = "SELECT DISTINCT users.firstname, users.lastname, user_posts.user_id FROM users INNER JOIN user_posts ON users.id = user_posts.user_id WHERE user_posts.post_id = :id";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':id', $id);
                                            $stmt->execute();
                                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($result as $value){
                                                echo "<li>".$value['firstname']." ".$value['lastname']."</li>";
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                    <h4 class="text-primary">Description</h4>     
                                    <p>
                                        <?php

                                        echo $desc;
                                        ?>
                                    </p>
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