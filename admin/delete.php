<?php
include("config.php");
$id = $_GET['id'];
$query12 = "DELETE FROM `genre` WHERE id = $id";
$result12 = mysqli_query($conn, $query12);
if($result12){
    header("location: genrelist.php");
}
else{
    echo " fail";
}
?>