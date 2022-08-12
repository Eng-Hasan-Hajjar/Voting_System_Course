<?php
//Include database connection
require("../config/db.php");
?>
<html>


<?php
$org = trim($_POST['org']);
$sql = "SELECT * FROM positions WHERE org = ?";
if(!$stmt = $db->prepare($sql)) {
    echo $stmt->error;
} else {
    $stmt->bind_param("s", $org);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<option value="">*****Select Position*****</option>
<?php if($result) { ?>
    <?php while($rowPos = $result->fetch_assoc()) { ?>
        <option value="<?php echo $rowPos['pos']; ?>"><?php echo $rowPos['pos']; ?></option>
    <?php } //End while ?>
<?php } //End if ?>

</html>