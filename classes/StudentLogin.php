<?php


class StudentLogin
{
    private $_stud_id;

    public function __construct($c_stud_id) {
        $this->_stud_id = $c_stud_id;
    }

    public function StudLogin() {
        global $db;

        //Start session
        session_start();

        //Array to store error message
        $error_msg_array = array();

        //Error messages
        $error_msg = FALSE;

        if($this->_stud_id == "") {
            $error_msg_array[] = "Please input your ID number.";
            $error_msg = TRUE;
        }

        if($error_msg) {
            $_SESSION['ERROR_MSG_ARRAY'] = $error_msg_array;
            header("location: ..//index.php");
            exit();
        }

        $sql = "SELECT * FROM voters WHERE stud_id = ? LIMIT 1";
        if(!$stmt = $db->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->bind_param("s", $this->_stud_id);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            //Create session
            session_regenerate_id();
            $_SESSION['ID']      = $row['id'];
            $_SESSION['NAME']    = $row['name'];
            $_SESSION['COURSE']  = $row['course'];
            $_SESSION['YEAR']    = $row['year'];
            $_SESSION['STUD_ID'] = $row['stud_id'];
            session_write_close();

            header("location: ..//stud_page.php");

        } else {
            $error_msg_array[] = "Sorry the ID number you entered is not in the database.";
            $error_msg = TRUE;

            if($error_msg) {
                $_SESSION['ERROR_MSG_ARRAY'] = $error_msg_array;
                header("location: ..//index.php");
                exit();
            }
            $stmt->free_result();
        }
        $result->free();
        return $result;
    }
}