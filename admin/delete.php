<?php 
include __DIR__ . "/../config/db.php";
$id = $_GET['id'];
mysqli_query($conn,"DELETE  FROM  products  WHERE  id = $id" );
header("Location:dashboard.php");
?>