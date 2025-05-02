<?php
    require 'conn/koneksi.php';
    session_start();

    if(isset($_POST['login'])) {
        $userName = $_POST['userName'];
        $pass = $_POST['password'];

        $cekdatabase = mysqli_query($conn,"SELECT * FROM login where username = '$userName'" );
        // $hitung = mysqli_num_rows($cekdatabase);

        if(mysqli_num_rows($cekdatabase)===1) {
            $row = mysqli_fetch_assoc($cekdatabase); 
            if(password_verify($pass, $row['pass'])) {
                $_SESSION['log'] = 'true';
                $_SESSION['role'] = $row['roles'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['id_login'] = $row['id'];
                if($row['roles'] === 'admin') {
                header('location: dashboard.php');
            } elseif($row['roles'] === 'user') {
                header('location: user_dashboard.php');
            } else {
                echo 'role tidak dikenali';
            }
                
                exit;
            } else {
                echo 'password tidak cocok';
            }
            
        } else {

        header('location: login.php');
    }
    };
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputName"  name="userName" type="userName" placeholder="User name" />
                                                <label for="inputEmail">username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.php">Forgot Password?</a>
                                                <button class="btn btn-primary" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
