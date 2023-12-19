<?php
include '../../database/config.php';
$qsid = mysqli_real_escape_string($conn, $_GET['id']);
$exid = mysqli_real_escape_string($conn, $_GET['eid']);

$sql = "DELETE FROM tbl_questions WHERE question_id='$qsid'";

if ($conn->query($sql) === TRUE) {
   // $fileToDelete = ''.$exid.$qsid.'jpeg';
$directory = '../../admin/uploads/';
$prefix = $exid.$qsid;

// Open the directory
$files = glob($directory . $prefix . '*');

// Loop through each file
foreach ($files as $file) {
    // Check if the file exists before attempting to delete
    if (file_exists($file)) {
        // Attempt to delete the file
        if (unlink($file)) {
            echo "File {$file} deleted successfully.<br>";
        } else {
            echo "Error deleting the file {$file}.<br>";
        }
    } else {
        echo "File {$file} does not exist.<br>";
    }
}
    
    header("location:../view-questions.php?rp=7823&eid=$exid");
} else {
    header("location:../view-questions.php?rp=1298&eid=$exid");
}

$conn->close();
?>
