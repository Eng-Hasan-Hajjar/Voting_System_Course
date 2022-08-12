<?php

/**
 * Created by PhpStorm.
 * User: faintedbrain63
 * Date: 10/07/2017
 * Time: 3:03 PM
 */
class Voters
{
    public function INSERT_VOTER($name, $course, $year, $stud_id) {
        global $db;

        //Check to see if the voter exists
        $sql = "SELECT *
                FROM voters
                WHERE name = ?
                LIMIT 1";
        if(!$stmt = $db->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if($result->num_rows > 0) {
            echo "<div class='alert alert-danger'>Sorry the voter you entered already exists in the database.</div>";
        } else {
            //Insert voter
            $sql = "INSERT INTO voters(name, course, year, stud_id)VALUES(?, ?, ?, ?)";
            if(!$stmt = $db->prepare($sql)) {
                echo $stmt->error;
            } else {
                $stmt->bind_param("ssss", $name, $course, $year, $stud_id);
            }
            if($stmt->execute()) {
                echo "<div class='alert alert-success'>Voter was inserted successfully.</div>";
            }
            $stmt->free_result();
        }
        return $stmt;
    }

    public function READ_VOTERS() {
        global $db;

        $sql = "SELECT *
                FROM voters
                ORDER BY name ASC";
        if(!$stmt = $db->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->execute();
            $result = $stmt->get_result();
        }
        $stmt->free_result();
        return $result;
    }

    public function EDIT_VOTER($voter_id) {
        global $db;

        $sql = "SELECT *
                FROM voters
                WHERE id = ?
                LIMIT 1";
        if(!$stmt = $db->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->bind_param("i", $voter_id);
            $stmt->execute();
            $result = $stmt->get_result();
        }
        $stmt->free_result();
        return $result;
    }

    public function UPDATE_VOTER($name, $course, $year, $stud_id, $voter_id) {
        global $db;

        $sql = "UPDATE voters
                SET name = ?, course = ?, year = ?, stud_id = ?
                WHERE id = ? LIMIT 1";
        if(!$stmt = $db->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->bind_param("ssssi", $name, $course, $year, $stud_id, $voter_id);
        }

        if($stmt->execute()) {
            echo "<div class='alert alert-success'>Voter was updated successfully.<a href='./add_voters.php'><span class='glyphicon glyphicon-backward'></span></a></div>";
        }
        $stmt->free_result();
        return $stmt;
    }

    public function DELETE_VOTER($voter_id) {
        global $db;

        $sql = "DELETE FROM voters
                WHERE id = ? LIMIT 1";
        if(!$stmt = $db->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->bind_param("i", $voter_id);
        }

        if($stmt->execute()) {
            header("location: ./add_voters.php");
            exit();
        }
        $stmt->free_result();
        return $stmt;
    }
}