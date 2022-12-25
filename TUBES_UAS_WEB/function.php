<?php

session_start();

//Buat Koneksi
$c = mysqli_connect('localhost','root','','b_order_db');

if (isset($_POST['registrasi'])) {
    if (registrasi($_POST) > 0) {
        echo "
            <script>
                alert('Selamat, Registrasi Berhasil');
                document.location.href='login.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Maaf, Registrasi Gagal');
                document.location.href='registrasi.php';
            </script>
        ";
    }
}

function registrasi($data) {
    global $c;
    $username = strtolower(stripcslashes($data['username']));
    $telepon = strtolower(stripcslashes($data['telepon']));
    $password = mysqli_real_escape_string($c, $data['password']);
    $password2 = mysqli_real_escape_string($c, $data['password2']);
    $result = mysqli_query($c, "SELECT username, telepon_user FROM user WHERE username='$username' OR telepon_user='$telepon'");

    if (mysqli_fetch_assoc($result)) {
        echo "
            <script>
                alert('Username atau Nomor Telepon sudah digunakan');
            </script>
        ";
        return false;
    }

    if ($password != $password2) {
        echo "
        <script>
            alert('Password Anda tidak sesuai');
        </script>
        ";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($c, "INSERT INTO user VALUES ('', '$username', '$password', '$telepon')");
    return mysqli_affected_rows($c);
}

//Hapus User
if(isset($_POST['hapus_user'])){
    $idUser = $_POST['idUser'];

    $user = mysqli_query($c, "SELECT * FROM pesanan WHERE id_user='$idUser'");
    $hitungUser = mysqli_num_rows($user);

    if ($hitungUser > 0) {
        echo '
        <script>alert("Gagal Hapus Data User, Data User masih Digunakan");
        window.location.href="user.php"
        </script>
        ';
    } else {
        $query = mysqli_query($c, "DELETE FROM user WHERE id_user='$idUser'");

        if($query){
            header('location:user.php');
        } else {
            echo '
            <script>alert("Gagal Hapus Data Pelanggan");
            window.location.href="user.php"
            </script>
            ';
        }
    }
}

// Update User Password
if (isset($_POST['konfigurasi_password'])) {
    if (konfigurasi_password($_POST) > 0) {
        echo "
            <script>
                alert('Selamat, Password Berhasil Diubah');
                document.location.href='logout.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Maaf, Password Gagal Diubah');
                document.location.href='ubah_data_user.php';
            </script>
        ";
    }
}

function konfigurasi_password($data) {
    global $c;
    $username = $_SESSION['username'];
    $password = mysqli_real_escape_string($c, $data['password']);
    $password2 = mysqli_real_escape_string($c, $data['password2']);

    if ($password != $password2) {
        echo "
        <script>
            alert('Password Anda tidak sesuai');
        </script>
        ";
        return false;
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query($c, "UPDATE user SET password = '$password' WHERE username = '$username'");
    return mysqli_affected_rows($c);
}

// Update Telepon User
if(isset($_POST['konfigurasi_telepon'])) {
    $username = $_SESSION['username'];
    $noTelp = $_POST['telepon'];
    $result = mysqli_query($c, "SELECT telepon_user FROM user WHERE telepon_user='$noTelp'");

    if (mysqli_fetch_assoc($result)) {
        echo "
            <script>
                alert('Nomor Telepon sudah digunakan');
            </script>
        ";
    } else {
        $query = mysqli_query($c,"UPDATE user SET telepon_user = '$noTelp' WHERE username = '$username'"); 

        if($query){
            header('location:ubah_data_user.php');
        } else {
            echo '
            <script>alert("Maaf, Telepon Gagal Diubah");
            window.location.href="ubah_data_user.php"
            </script>
            ';
        }
    }
}

// Tambah Data Pelanggan
if(isset($_POST['tambah_pelanggan'])) {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_telp_pelanggan = $_POST['no_telp_pelanggan'];
    $alamat_pelanggan = $_POST['alamat_pelanggan'];

    $tambah = mysqli_query($c,"INSERT INTO pelanggan (nama_pelanggan, no_telp_pelanggan, alamat_pelanggan) values ('$nama_pelanggan', '$no_telp_pelanggan', '$alamat_pelanggan')");

    if($tambah) {
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal Tambah Data Pelanggan");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//Edit Pelanggan
if(isset($_POST['edit_pelanggan'])) {
    $idPelanggan = $_POST['idPl'];
    $namaPelanggan = $_POST['nama_pelanggan'];
    $noTelpPelanggan = $_POST['no_telp'];
    $alamatPelanggan = $_POST['alamat'];

    $query = mysqli_query($c,"UPDATE pelanggan SET nama_pelanggan='$namaPelanggan', no_telp_pelanggan='$noTelpPelanggan', 
    alamat_pelanggan='$alamatPelanggan' WHERE id_pelanggan='$idPelanggan'"); 

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal Edit Data Pelanggan");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//Hapus Pelanggan
if(isset($_POST['hapus_pelanggan'])){
    $idPelanggan = $_POST['idPl'];

    $pelanggan = mysqli_query($c, "SELECT * FROM pesanan WHERE id_pelanggan='$idPelanggan'");
    $countPelanggan = mysqli_num_rows($pelanggan);

    if ($countPelanggan > 0) {
        echo '
        <script>alert("Gagal Hapus Data Pelanggan, Data Pelanggan masih Digunakan");
        window.location.href="pelanggan.php"
        </script>
        ';
    } else {
        $query = mysqli_query($c, "DELETE FROM pelanggan WHERE id_pelanggan='$idPelanggan'");

        if($query){
            header('location:pelanggan.php');
        } else {
            echo '
            <script>alert("Gagal Hapus Data Pelanggan");
            window.location.href="pelanggan.php"
            </script>
            ';
        }
    }
}

// Tambah Produk
if(isset($_POST['tambah_produk'])){
    $nama_produk = $_POST['nama_produk'];
    $deskripsi_produk = $_POST['deskripsi_produk'];
    $harga_produk = $_POST['harga_produk'];
    $stok_produk = $_POST['stok_produk'];

    $tambah = mysqli_query($c,"INSERT INTO produk (nama_produk, deskripsi_produk, harga_produk, stok_produk) values ('$nama_produk', '$deskripsi_produk', '$harga_produk', '$stok_produk')");

    if($tambah) {
        header('location:stock.php');
    } else {
        echo '
        <script>alert("Gagal Tambah Barang Baru");
        window.location.href="stock.php"
        </script>
        ';
    }
}

//Edit Produk
if(isset($_POST['edit_produk'])){
    $idProduk = $_POST['idp'];
    $namaProduk = $_POST['nama_produk'];
    $deskripsiProduk = $_POST['deskripsi_produk'];
    $hargaProduk = $_POST['harga_produk'];

    $query = mysqli_query($c,"UPDATE produk SET nama_produk='$namaProduk', deskripsi_produk='$deskripsiProduk', 
    harga_produk='$hargaProduk' WHERE id_produk='$idProduk'"); 

    if($query){
        header('location:stock.php');
    } else {
        echo '
        <script>alert("Gagal Edit Barang");
        window.location.href="stock.php"
        </script>
        ';
    }
}

//Hapus Produk
if(isset($_POST['hapus_produk'])){
    $idProduk = $_POST['idp'];

    $query = mysqli_query($c, "DELETE FROM produk WHERE id_produk='$idProduk'");

    if($query){
        header('location:stock.php');
    } else {
        echo '
        <script>alert("Gagal Hapus Barang");
        window.location.href="stock.php"
        </script>
        ';
    }
}

//Menambah Barang Masuk
if(isset($_POST['add_produk_masuk'])){
    $idProdukM = $_POST['id_produk'];
    $jumlahM = $_POST['qty_masuk'];

    $tambahM = mysqli_query($c,"INSERT INTO masuk (id_produk, qty_masuk) VALUES ('$idProdukM', '$jumlahM')");

    if($tambahM){
        header('location:masuk.php');
    } else {
        echo '
        <script>alert("Gagal Tambah Barang Masuk");
        window.location.href="masuk.php"
        </script>
        ';
    }
}

// Mengedit Barang Masuk
if(isset($_POST['edit_barang_masuk'])) {
    $idMasuk = $_POST['idm'];
    $idProduk = $_POST['idp'];
    $jumlah = $_POST['qty'];

    // Cari QTY data
    $cariDataQtyMasuk = mysqli_query($c,"SELECT * FROM masuk WHERE id_masuk = '$idMasuk'");
    $cariDataQtyMasuk1 = mysqli_fetch_array($cariDataQtyMasuk);
    $qtySekarang = $cariDataQtyMasuk1['qty_masuk'];

    // Cari Stok Sekarang
    $cariStock = mysqli_query($c, "SELECT * FROM produk WHERE id_produk='$idProduk'");
    $cariStock2 = mysqli_fetch_array($cariStock);
    $stokSekarang = $cariStock2['stok_produk'];

    if($jumlah >= $qtySekarang) {
        $selisih = $jumlah - $qtySekarang;
        $newStock = $stokSekarang + $selisih;

        $query1 = mysqli_query($c,"UPDATE masuk SET qty_masuk = '$jumlah' WHERE id_masuk='$idMasuk'");
        $query2 = mysqli_query($c,"UPDATE produk SET stok_produk = '$newStock' WHERE id_produk='$idProduk'");  

        if($query1 && $query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal Edit Data Barang Masuk");
            window.location.href="masuk.php"
            </script>
            ';
        }
    } else {
        $selisih = $qtySekarang - $jumlah;
        $newStock = $stokSekarang - $selisih;

        $query1 = mysqli_query($c,"UPDATE masuk SET qty_masuk = '$jumlah' WHERE id_masuk='$idMasuk'");
        $query2 = mysqli_query($c,"UPDATE produk SET stok_produk = '$newStock' WHERE id_produk='$idProduk'");

        if($query1 && $query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal Edit Data Barang Masuk");
            window.location.href="masuk.php"
            </script>
            ';
        }
    }
}

//Hapus Data Barang Masuk
if(isset($_POST['hapus_barang_masuk'])){
    $idMasuk = $_POST['idm'];
    $idProduk = $_POST['idp'];

    // Cari QTY data
    $cariDataQtyMasuk = mysqli_query($c,"SELECT * FROM masuk WHERE id_masuk = '$idMasuk'");
    $cariDataQtyMasuk1 = mysqli_fetch_array($cariDataQtyMasuk);
    $qtySekarang = $cariDataQtyMasuk1['qty_masuk'];

    // Cari Stok Sekarang
    $cariStock = mysqli_query($c, "SELECT * FROM produk WHERE id_produk='$idProduk'");
    $cariStock2 = mysqli_fetch_array($cariStock);
    $stokSekarang = $cariStock2['stok_produk'];

    $newStock = $stokSekarang - $qtySekarang;

    $query1 = mysqli_query($c,"DELETE FROM masuk WHERE id_masuk='$idMasuk'");
    $query2 = mysqli_query($c,"UPDATE produk SET stok_produk = '$newStock' WHERE id_produk='$idProduk'");

    if($query1 && $query2){
        header('location:masuk.php');
    } else {
        echo '
        <script>alert("Gagal Hapus Data Barang Masuk");
        window.location.href="masuk.php"
        </script>
        ';
    }
}


// Tambah Pesanan
if(isset($_POST['tambah_pesanan'])) {
    $idPelanggan = $_POST['id_pelanggan'];
    $idUser = $_SESSION['id_user'];

    $tambah = mysqli_query($c,"INSERT INTO pesanan (id_user, id_pelanggan) values ('$idUser', '$idPelanggan')");

    if($tambah) {
        header('location:index.php');
    } else {
        echo '
        <script>alert("Gagal Tambah Pesanan Baru");
        window.location.href="index.php"
        </script>
        ';
    }
}

//Hapus Pesanan
if(isset($_POST['hapus_pesanan'])){
    $idPesanan = $_POST['idp'];

    $cekData = mysqli_query($c,"SELECT * FROM detail_pesanan dp WHERE id_order = '$idPesanan'"); 

    while($ok = mysqli_fetch_array($cekData)) {
        $jumlah = $ok['qty'];
        $idProduk = $ok['id_produk'];
        $idDetailOrder = $ok['id_detail_order'];

        // Cari Stok Sekarang
        $cariStock = mysqli_query($c, "SELECT * FROM produk WHERE id_produk='$idProduk'");
        $cariStock2 = mysqli_fetch_array($cariStock);
        $stokSekarang = $cariStock2['stok_produk'];

        $newStock = $stokSekarang + $jumlah;

        $queryUpdate = mysqli_query($c,"UPDATE produk SET stok_produk = '$newStock' WHERE id_produk='$idProduk'");

        // Hapus Data
        $queryDelete = mysqli_query($c,"DELETE FROM detail_pesanan WHERE id_detail_order='$idDetailOrder'");
    }

    $query = mysqli_query($c, "DELETE FROM pesanan WHERE id_order='$idPesanan'");

    if($queryUpdate && $queryDelete && $query){
        header('location:index.php');
    } else {
        echo '
        <script>alert("Gagal Hapus Data Pesanan");
        window.location.href="index.php"
        </script>
        ';
    }
}

//Tambah Produk diPilih di Pesanan
if(isset($_POST['add_produk'])) {
    $idProduk = $_POST['id_produk'];
    $idPesanan = $_POST['idp'];
    $qty = $_POST['qty'];

    //Hitung Stock Sekarang
    $ht1 = mysqli_query($c,"SELECT * FROM produk WHERE id_produk='$idProduk'");
    $ht2 = mysqli_fetch_array($ht1);
    $stockNow = $ht2['stok_produk'];

    if($stockNow>=$qty){
        //Kurangi Stok
        $selisih = $stockNow - $qty;

        //Stok Sekarang Cukup
        $tambah = mysqli_query($c,"INSERT INTO detail_pesanan (id_order, id_produk, qty) values ('$idPesanan', '$idProduk', '$qty')");
        $update = mysqli_query($c,"UPDATE produk SET stok_produk='$selisih' WHERE id_produk='$idProduk'");

        if($tambah) {
            header('location:view.php?idp='.$idPesanan);
        } else {
            echo '
            <script>alert("Gagal Tambah Pesanan Baru");
            window.location.href="view.php?idp='.$idPesanan.'"
            </script>
            ';
        }
    } else {
        echo '
        <script>alert("Stock Barang Tidak Cukup");
        window.location.href="view.php?idp='.$idPesanan.'"
        </script>
        ';
    }
}

// Mengedit Detail Pesanan
if(isset($_POST['edit_detail_pesanan'])) {
    $idDetailOrder = $_POST['iddp'];
    $idProduk = $_POST['idpr'];
    $idOrder = $_POST['idp'];
    $jumlah = $_POST['qty'];

    // Cari QTY data
    $cariDataQty = mysqli_query($c,"SELECT * FROM detail_pesanan WHERE id_detail_order = '$idDetailOrder'");
    $cariDataQty1 = mysqli_fetch_array($cariDataQty);
    $qtySekarang = $cariDataQty1['qty'];

    // Cari Stok Sekarang
    $cariStock = mysqli_query($c, "SELECT * FROM produk WHERE id_produk='$idProduk'");
    $cariStock2 = mysqli_fetch_array($cariStock);
    $stokSekarang = $cariStock2['stok_produk'];

    if($jumlah >= $qtySekarang) {
        $selisih = $jumlah - $qtySekarang;
        $newStock = $stokSekarang - $selisih;

        $query1 = mysqli_query($c,"UPDATE detail_pesanan SET qty = '$jumlah' WHERE id_detail_order='$idDetailOrder'");
        $query2 = mysqli_query($c,"UPDATE produk SET stok_produk = '$newStock' WHERE id_produk='$idProduk'");  

        if($query1 && $query2){
            header('location:view.php?idp='.$idOrder);
        } else {
            echo '
            <script>alert("Gagal Edit Data Barang Masuk");
            window.location.href="view.php?idp='.$idOrder.'"
            </script>
            ';
        }
    } else {
        $selisih = $qtySekarang - $jumlah;
        $newStock = $stokSekarang + $selisih;

        $query1 = mysqli_query($c,"UPDATE detail_pesanan SET qty = '$jumlah' WHERE id_detail_order='$idDetailOrder'");
        $query2 = mysqli_query($c,"UPDATE produk SET stok_produk = '$newStock' WHERE id_produk='$idProduk'");

        if($query1 && $query2){
            header('location:view.php?idp='.$idOrder);
        } else {
            echo '
            <script>alert("Gagal Edit Data Barang Masuk");
            window.location.href="view.php?idp='.$idOrder.'"
            </script>
            ';
        }
    }
}

//Hapus Produk Pesanan
if(isset($_POST['del_produk_order'])){
    $idp = $_POST['idp'];
    $idDp = $_POST['idDp'];
    $idPrdk = $_POST['idPrdk'];

    //Cek Qty Sekarang
    $cek1 = mysqli_query($c,"SELECT * FROM detail_pesanan WHERE id_detail_order = '$idDp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtyNow = $cek2['qty'];

    //Cek Stok Sekarang
    $cek3 = mysqli_query($c,"SELECT * FROM produk WHERE id_produk = '$idPrdk'");
    $cek4 = mysqli_fetch_array($cek3);
    $stokNow = $cek4['stok_produk'];

    $hitung = $stokNow + $qtyNow;

    //Update Stok
    $update = mysqli_query($c,"UPDATE produk SET stok_produk='$hitung' WHERE id_produk='$idPrdk'");
    $hapus = mysqli_query($c,"DELETE FROM detail_pesanan WHERE id_produk='$idPrdk' AND id_detail_order='$idDp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$idp);
    } else {
        echo '
        <script>alert("Gagal Hapus Pesanan");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }
}
?>