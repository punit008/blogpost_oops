<?php

session_start();

if(isset($_SESSION['user_id'])){
    header('location:dashboard.php');
}

require_once '../BlogPost/dbconnect.php';

if (isset($_POST['submit'])) {
    $firstname = htmlspecialchars(strip_tags($_POST['firstname']));
    $lastname = htmlspecialchars(strip_tags($_POST['lastname']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $password = htmlspecialchars(strip_tags($_POST['password']));
    $repeat_password = htmlspecialchars(strip_tags($_POST['repeat_pass']));

    // Hashed password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check = "SELECT * FROM `users` WHERE email = :email";
    $check_stmt = $conn->prepare($check);
    $check_stmt->bindParam(':email', $email);
    $check_result = $check_stmt->execute();

    if ($check_stmt->rowCount() > 0) {
        $message = "Email already exist";
    } else {
        if ($password === $repeat_password) {
            $sql = "INSERT INTO `users` (firstname, lastname, email , password) VALUES (:firstname, :lastname, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $result = $stmt->execute();

            if ($result === true) {
                // $last_id = $conn->lastInsertId();
                $_SESSION['success_msg'] = "Registration done <br> Login Now";
                header('location: login.php');
            } else {
                $message = "Failed to create the user";
            }
        } else {
            $message = "Password and Repeat Password Does Not Match";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/myStyle.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image my-register-image">

                    </div> -->
                    <div class="col-lg-8 mx-auto">
                        <?php if (isset($message)) { ?>
                            <div class="alert alert-danger mt-3 text-center">
                                <p><?php echo $message; ?></p>
                            </div>
                        <?php } ?>
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" method="POST">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name" name="firstname" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name" name="lastname" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" name="email" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Minimum eight characters, at least one letter and one number">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Repeat Password" name="repeat_pass" required pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="Minimum eight characters, at least one letter and one number">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block" name="submit" type="submit">
                                    Register Account
                                </button>
                                <hr>
                            </form>
                            <hr>
                            <!-- <div class="text-center">
                                <a class="small" href="forgot-password.html">Forgot Password?</a>
                            </div> -->
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
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

</body>

</html>