<?php
include '../database/config.php';
if (isset($_GET['rp'])) {
$error_code = mysqli_real_escape_string($conn, $_GET['rp']);

$sql = "SELECT * FROM tbl_alerts WHERE code = '$error_code'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
	$ms = 1;
    //setms(1);
     $description = $row['description'];
    }
} else {
	$ms = 0;
    //setms(0);
}
$conn->close();

}

/*function setms($x)
{
 $ms=$x;   
}*/

?>