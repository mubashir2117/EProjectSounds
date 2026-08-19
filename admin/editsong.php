<?php
include "header.php";
?>
<?php
    include("config.php");
    $id = $_GET['editsid'];

   if(isset($_POST['submit'])){
    // $id = $_POST["id"];
    $song_name = $_POST["song_name"];
    
    $genre_id = $_POST["genre_id"];
    $Artist_id = $_POST["Artists_id"];
    $years = $_POST["years"];

    $img=$_FILES["song_image"];
    $imgName = $img['name'];
    $tempPath = $img['tmp_name'];
    $myPath3= "images/".$imgName;
    
    move_uploaded_file($tempPath, $myPath3);
    
    $audio = $_FILES["song_file"];
    $audioName = $audio['name'];
    $tempPath = $audio['tmp_name'];
    $myPath4= "audio/".$audioName;
    
    move_uploaded_file($tempPath, $myPath4);

    $query1 = "UPDATE `song` SET `song_name`='$song_name',`song_image`='$myPath3',`song_file`='$myPath4',`years`='$years',
    `genre_id`='$genre_id',`Artists_id`='$Artist_id' WHERE `song_id` = '$id'";

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
                    <h1>Edit Song</h1>
                    <?php
                    $query = "SELECT * FROM `song` WHERE song_id = $id";
                    $result = mysqli_query($conn, $query);
                    $rows = mysqli_fetch_assoc($result);
                    ?>
                    <input value="<?php echo $rows["song_id"]?>" type="hidden" name="id">

                    <div class="form-group">
                        <label for="song_name">Song Name</label>
                        <input value="<?php echo htmlspecialchars($rows['song_name'])?>" type="text" id="song_name" name="song_name" required>
                    </div>

                    <div class="form-group">
                        <label for="song_image">Song Image</label>
                        <input type="file" id="song_image" name="song_image">
                    </div>

                    <div class="form-group">
                        <label for="song_file">Audio File</label>
                        <input type="file" id="song_file" name="song_file">
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
                        <a class="btn btn-outline-primary" href="songlist.php"><i class="fa-solid fa-xmark"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
