
<?php
    include("header.php");?>

<?php
    include("config.php");
    $id = $_GET['getid'];

   if(isset($_POST['submit'])){
    // $id = $_POST["id"];
    $artist_name = $_POST["artist_name"];
    $genre_id = $_POST["genre_id"];
    $artist_image=$_FILES["artist_image"];

    $imgName = $artist_image['name'];
    $tempPath = $artist_image['tmp_name'];
    $myPath2= "images/".$imgName;
    
    move_uploaded_file($tempPath, $myPath2);


    $query4 = "UPDATE `artist` SET `artist_name`='$artist_name',
    `artist_image`='$myPath2',`genre_id`='$genre_id' WHERE `Artist_id` = '$id'";

    $result4 = mysqli_query($conn, $query4);

    if($result4){
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
                    <h1>Edit Artist</h1>
                    <?php
                    $query = "SELECT * FROM `artist` WHERE Artist_id = $id";
                    $result = mysqli_query($conn, $query);
                    $artist_row = mysqli_fetch_assoc($result);
                    ?>
                    <input value="<?php echo $artist_row["Artist_id"]?>" type="hidden" name="id">

                    <div class="form-group">
                        <label for="artist_name">Artist Name</label>
                        <input value="<?php echo htmlspecialchars($artist_row['artist_name'])?>" type="text" id="artist_name" name="artist_name" required>
                    </div>

                    <div class="form-group">
                        <label for="artist_image">Artist Image</label>
                        <input type="file" id="artist_image" name="artist_image">
                    </div>

                    <div class="form-group">
                        <label for="genre_id">Genre</label>
                        <select name="genre_id" id="genre_id" class="form-control">
            <?php
              $qry= "select * from genre";
              $res= mysqli_query($conn, $qry);
              
              while($genre_row = mysqli_fetch_assoc($res)){
                  $selected = ($genre_row['id'] == $artist_row['genre_id']) ? 'selected' : '';
                  ?>

                <option <?php echo $selected ?> value="<?php echo $genre_row["id"]?>"><?php echo $genre_row["genre_name"]?></option>
            <?php
                }
            ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-add" name="submit"><i class="fa-solid fa-check"></i> Save Changes</button>
                        <a class="btn btn-outline-primary" href="artistlist.php"><i class="fa-solid fa-xmark"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
