<?php 
    require 'cekLogin.php';
    require 'cek_username.php';

    //Hitung Jumlah User
    $s1 = mysqli_query($c, "SELECT * FROM user");
    $s2 = mysqli_num_rows($s1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <script type="text/javascript">
        var username = '<?php echo $_SESSION['
        username '];?>';

        function cekUsername() {
            if (username != "admin") {
                document.getElementById("produk").style.display = "none";
                document.getElementById("masuk").style.display = "none";
                document.getElementById("user").style.display = "none";
            }
        }

        window.onload = cekUsername;
    </script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Laman B-Order</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Order
                        </a>
                        <a class="nav-link" href="stock.php" id="produk">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Stok Barang
                        </a>
                        <a class="nav-link" href="masuk.php" id="masuk">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="pelanggan.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users fa-fw"></i></div>
                            Kelola Pelanggan
                        </a>
                        <a class="nav-link" href="user.php" id="user">
                            <div class="sb-nav-link-icon"><i class="fas fa-user fa-fw"></i></div>
                            Kelola User
                        </a>
                        <a class="nav-link" href="ubah_data_user.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Konfigurasi User
                        </a>
                        <a class="nav-link bg-danger bg-gradient text-dark"
                            onclick="return confirm('Apakah Anda yakin ingin LogOut?')" href="logout.php">
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php
                        echo $_SESSION['username'];
                    ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main class="bg-light bg-gradient">
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data User</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"></li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Jumlah User : <?=$s2;?></div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data User
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>ID User</th>
                                            <th>Username</th>
                                            <th>Telepon User</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $get = mysqli_query($c, "SELECT * FROM user");
                                        
                                        while($p=mysqli_fetch_array($get)) {
                                            $idUser = $p['id_user'];
                                            $username = $p['username'];
                                            $telepon = $p['telepon_user'];
                                        ?>
                                        <tr>
                                            <td><?=$idUser?></td>
                                            <td><?=$username;?></td>
                                            <td><?=$telepon;?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#Delete<?=$idUser?>">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- The Modal Delete -->
                                        <div class="modal fade" id="Delete<?=$idUser;?>">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Hapus User <?=$username;?>
                                                        </h4>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="post">

                                                        <!-- Modal body -->
                                                        <div class="modal-body">
                                                            apakah_anda_yakin_ingin_menghapus_user_tersebut_?
                                                            <input type="hidden" name="idUser" value="<?=$idUser;?>">
                                                        </div>

                                                        <!-- Modal footer -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success"
                                                                name="hapus_user">Submit</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }; // End of While
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; B-Order 2022</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>