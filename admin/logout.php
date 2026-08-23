<?php 
include __DIR__ . "/../config/db.php";
session_start();
session_destroy();
header("Location: ../includes/index.php");
exit();
?>