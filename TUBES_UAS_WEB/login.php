<?php
    require 'function.php';

    if(isset($_SESSION['login'])) {
        header("location:index.php");
        exit;
    }

    if(isset($_POST['login'])){
        $username=$_POST["username"];
        $password=$_POST["password"];

        $_SESSION["username"]=$username;

        $result=mysqli_query($c,"SELECT * FROM user WHERE username='$username'");

        if(mysqli_num_rows($result)===1){
            $row=mysqli_fetch_assoc($result);

            if(password_verify($password, $row["password"])){
                $_SESSION["login"]=true;
                $_SESSION["id_user"]=$row["id_user"];

                header("Location:index.php");
                exit;
            }
        }

        echo '
            <script>alert("Username atau Password Salah");
            window.location.href="login.php"
            </script>
        ';
        $error = true;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <h1 class="text-center text-white font-weight-light my-4">Selamat Datang di B-Order</h1>
                        <div class="d-flex">
                        <img class="p-2" src="./image/login-illustration.png" alt="login_ilustration" style="width: 640px; margin-top:32px;">
                            <div class="p-2 col-lg-5" style="margin-top: 32px;">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header bg-info"><h3 class="text-center text-white font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" name="username" type="text" placeholder="name@example.com" required />
                                                <label for="inputEmail">Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-around mt-4 mb-0">
                                                <h6>Belum punya akun? <a href="registrasi.php">Registrasi</a></h6>
                                                <button type="submit" name="login" class="btn btn-info" href="index.php">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
