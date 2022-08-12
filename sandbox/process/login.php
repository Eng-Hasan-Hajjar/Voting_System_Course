<?php
//Include database connection
require("../../config/db.php");

//Include class Admin_Login
require("../classes/Admin_Login.php");

if(isset($_POST['submit'])) {

    //Create variable to store post array values
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $adminLogin = new Admin_Login($username, $password);
    $rtnAdminLogin = $adminLogin->AdminLogin();

}
