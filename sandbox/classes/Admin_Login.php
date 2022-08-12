<?php

/**
 * Created by PhpStorm.
 * User: Gizmo
 * Date: 7/2/2017
 * Time: 6:59 PM
 */
class Admin_Login
{
    private $_username;
    private $_password;

    public function __construct($c_username, $c_password) {
        $this->_username = $c_username;
        $this->_password = $c_password;
    }

    public function AdminLogin() {
        global $db;

        //Start session
        session_start();

        //Array to validate errors
        $error_msg_array = array();

        //Error messages
        $error_msg = FALSE;

        if($this->_username == "") {
            $error_msg_array[] = "Please input your username";
            $error_msg = TRUE;
        }

        if($this->_password == "") {
            $error_msg_array[] = "Please input your password";
            $error_msg = TRUE;
        }

        if($error_msg) {
            $_SESSION['ERROR_MSG_ARR'] = $error_msg_array;
            header("location: ../index.php");
            exit();
        }

        $sql = "SELECT * FROM admin WHERE username = ? AND password = ? LIMIT 1";
        if(!$stmt = $db->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->bind_param("ss", $this->_username, $this->_password);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if($result->num_rows > 0) {
            //Login successful
            $row = $result->fetch_assoc();

            //Create session
            session_regenerate_id();
            $_SESSION['ADMIN_ID']   = $row["id"];
            $_SESSION['ADMIN_NAME'] = $row["name"];
            session_write_close();

            header("location: ../admin_page.php");

        } else {
            //Login failed
            $error_msg_array[] = "The username and password you entered is incorrect.";
            $error_msg = TRUE;

            if($error_msg) {
                $_SESSION['ERROR_MSG_ARR'] = $error_msg_array;
                header("location: ../index.php");
                exit();
            }
            $stmt->free_result();
        }
        $result->free();
        return $result;
    }
}