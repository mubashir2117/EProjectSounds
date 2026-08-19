<?php
include("config.php");
$id = $_GET['delvideoid'];
$query = "DELETE FROM `video` WHERE `video_id` = $id";
$result = mysqli_query($conn, $query);
if($result){
    header("location: videolist.php");
}
else{
    echo " fail";
}
?>