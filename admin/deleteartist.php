<?php
include("config.php");
$id = $_GET['delid'];

$query4 = "DELETE FROM `artist` WHERE `Artist_id` = $id";
$result4 = mysqli_query($conn, $query4);
if($result4){

    header("location: artistlist.php");
}
else{
    echo " fail";
}

?>