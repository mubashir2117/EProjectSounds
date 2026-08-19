
<?php
    include("header.php");?>


<?php
    include("config.php");
    $id = $_GET['editvideoid'];

   if(isset($_POST['submit'])){
    $video_name = $_POST["video_name"];
    $genre_id = $_POST["genre_id"];
    $Artist_id = $_POST["Artists_id"];
    $years = $_POST["years"];

    $video=$_FILES["video_file"];
    $videoName = $video['name'];
    $tempPath = $video['tmp_name'];
    $myPath5= "images/".$videoName;
    
    move_uploaded_file($tempPath, $videoName);

    
    $query1 = "UPDATE `video` SET `video_name`='$video_name',`video_file`='$myPath5',`years`='$years',
    `genre_id`='$genre_id',`Artists_id`='$Artist_id' WHERE `video_id` = '$id'";

    $result1 = mysqli_query($conn, $query1);

    if($result1){
       echo"update";
    }
    else{
        echo "Error";
    }
}
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <form action="" method="Post" enctype="multipart/form-data">
                    <h1>Edit Video</h1>
                    <?php
                    $query = "SELECT * FROM `video` WHERE video_id = $id";
                    $result = mysqli_query($conn, $query);
                    $rows = mysqli_fetch_assoc($result);
                    ?>
                    <input value="<?php echo $rows["video_id"]?>" type="hidden" name="id">

                    <div class="form-group">
                        <label for="video_name">Video Name</label>
                        <input value="<?php echo htmlspecialchars($rows['video_name'])?>" type="text" id="video_name" name="video_name" required>
                    </div>

                    <div class="form-group">
                        <label for="video_file">Video File</label>
                        <input type="file" id="video_file" name="video_file">
                    </div>

                    <div class="form-group">
                        <label for="years">Release Year</label>
                        <input value="<?php echo $rows['years']?>" type="number" id="years" name="years" required>
                    </div>

                    <div class="form-group">
                        <label for="genre_id">Genre</label>
                        <select name="genre_id" id="genre_id" class="form-control">
            <?php
              $qry= "select * from genre";
              $res= mysqli_query($conn, $qry);
              
              while($data = mysqli_fetch_assoc($res)){
                  $selected = ($data['id'] == $rows['genre_id']) ? 'selected' : '';
                  ?>

                <option <?php echo $selected ?> value="<?php echo $data["id"]?>"><?php echo $data["genre_name"]?></option>
            <?php
                }
            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Artists_id">Artist</label>
                        <select name="Artists_id" id="Artists_id" class="form-control">
            <?php
              $qry= "select * from artist";
              $res= mysqli_query($conn, $qry);
              
              while($data = mysqli_fetch_assoc($res)){
                  $selected = ($data['Artist_id'] == $rows['Artist_id']) ? 'selected' : '';
                  ?>

                <option <?php echo $selected ?> value="<?php echo $data["Artist_id"]?>"><?php echo $data["artist_name"]?></option>
            <?php
                }
            ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-add" name="submit"><i class="fa-solid fa-check"></i> Save Changes</button>
                        <a class="btn btn-outline-primary" href="videolist.php"><i class="fa-solid fa-xmark"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
