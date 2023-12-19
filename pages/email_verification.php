<?php
include '../database/config.php';
if(!empty($_GET['code']) && isset($_GET['code']))
{

$code = mysqli_real_escape_string($conn, $_GET['code']);
$sql="SELECT * FROM tbl_users WHERE activationcode='$code'";
$result =$conn->query($sql);
if($result->num_rows > 0)
{
$st=0;
$sql ="SELECT * FROM tbl_users WHERE activationcode='$code' and status='$st'";
$result4=$conn->query($sql);
if($result4->num_rows > 0)
 {
     while($row = $result4->fetch_assoc()) {
          $newpassword=$row['newpass']  ;
          $st=1;
         $sql = "UPDATE tbl_users SET status='$st',login='$newpassword' WHERE activationcode='$code'";
         if ($conn->query($sql) === TRUE) 
            {         
              header("location:../index.php?rp=1987");
            }
 }
  

}
else
{
header("location:../index.php?rp=1988");
}
}
else
{
header("location:../index.php?rp=1989");
}
}
$conn->close();
?>