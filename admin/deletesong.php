<?php
include("config.php");
$id = $_GET['delsid'];
$query = "DELETE FROM `song` WHERE `song_id` = $id";
$result = mysqli_query($conn, $query);
if($result){
    header("location: songlist.php");
}
else{
    echo " fail";
}
?>