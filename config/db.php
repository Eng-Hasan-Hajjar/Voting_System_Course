<?php


//This line of code connects to mysql database
define("HOST_NAME", "localhost");
define("HOST_USER", "root");
define("HOST_PASS", "");
define("HOST_DB", "voting");

$db = new mysqli(HOST_NAME, HOST_USER, HOST_PASS, HOST_DB);

/**
 * This line of code checks if connection error exists.

if($db->connect_error) {
    echo $db->connect_errno . " " . $db->connect_error;
} else {
    echo "Connection successful.";
}
 */