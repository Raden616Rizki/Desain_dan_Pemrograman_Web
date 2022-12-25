<?php

    require 'function.php';

    if(isset($_SESSION['login'])){
        //Sudah Login
    } else {
        //Belum Login
        header('location:login.php');
    }
?>