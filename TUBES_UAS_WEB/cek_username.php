<?php
    if($_SESSION['username'] == 'admin'){
        //Login as Admin
    } else {
        //Login as Regular
        header('location:index.php');
    }
?>