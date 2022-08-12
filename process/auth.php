<?php
//Create authentication

//Start session
session_start();

if(!isset($_SESSION['STUD_ID'])) {
    header("location: ./index.php");
    exit();
}