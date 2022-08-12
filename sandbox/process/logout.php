<?php
//Start session
session_start();

session_destroy();
header("location: ../index.php");
exit();