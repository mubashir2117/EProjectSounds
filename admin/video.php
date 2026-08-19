
<?php
include "header.php";
?>
<?php
    include("config.php");
   if(isset($_POST['submit'])){   
    $video_name = $_POST["video_name"];
    $genre_id = $_POST["genre"];
    $Artist_id = $_POST["artist"];
    $years = $_POST["years"];

    
    $video=$_FILES["video_file"];
    $videoName= $video['name'];
    $tempPath = $video['tmp_name'];
    $myPath= "images/".$videoName;
    print_r($_FILES["video_file"]);
    move_uploaded_file($tempPath, $myPath);
    
    $query12 = "INSERT INTO `video`(`video_name`,`video_file`,`years`,`genre_id`,`Artists_id`) 
    VALUES ('$video_name','$myPath','$years','$genre_id','$Artist_id')";

    $result12 = mysqli_query($conn, $query12);
    if ($result12) {
        echo "recodr";
    } else {
        echo "Error";
    }
    
}
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <form action="" method="Post" enctype="multipart/form-data">
                    <h1>Add Video</h1>

                    <div class="form-group">
                        <label for="video_name">Video Name</label>
                        <input type="text" id="video_name" name="video_name" placeholder="e.g. Official Music Video" required>
                    </div>

                    <div class="form-group">
                        <label for="video_file">Video File</label>
                        <input type="file" id="video_file" name="video_file" required>
                    </div>

                    <div class="form-group">
                        <label for="years">Release Year</label>
                        <input type="number" id="years" name="years" placeholder="e.g. 2024" required>
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <select name="genre" id="genre" class="form-control">
            <?php
                $qry3= "select * from genre";
                $res3= mysqli_query($conn, $qry3);

                while($data3 = mysqli_fetch_assoc($res3)){
            ?>
                <option value="<?php echo $data3["id"]?>"><?php echo $data3["genre_name"]?></option>
            <?php
                }
            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="artist">Artist</label>
                        <select name="artist" id="artist" class="form-control">
            <?php
                $qry11= "select * from artist";
                $res11= mysqli_query($conn, $qry11);

                while($data11 = mysqli_fetch_assoc($res11)){
            ?>
                <option value="<?php echo $data11["Artist_id"]?>"><?php echo $data11["artist_name"]?></option>
            <?php
                }
            ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-add" name="submit"><i class="fa-solid fa-plus"></i> Add Video</button>
                        <a class="btn btn-outline-primary" href="videolist.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include "footer.php";
?>
