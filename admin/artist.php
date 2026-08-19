<?php
include "header.php";
?>
<?php
    include("config.php");
   if(isset($_POST['submit'])){   
    $artist_name = $_POST["artist_name"];
    $genre_id = $_POST["genre"];
    $img=$_FILES["artist_image"];

$imgName = $img['name'];
$tempPath = $img['tmp_name'];
$myPath= "images/".$imgName;

move_uploaded_file($tempPath, $myPath);
 
    $query = "INSERT INTO `artist`(`artist_name`, `artist_image`,`genre_id`) VALUES 
    ('$artist_name','$myPath','$genre_id')";

    $result = mysqli_query($conn, $query);

    if($result){
        echo "Record inserted";
        header("Location: artistlist.php");
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
                    <h1>Add Artist</h1>

                    <div class="form-group">
                        <label for="artist_name">Artist Name</label>
                        <input type="text" id="artist_name" name="artist_name" placeholder="e.g. Atif Aslam" required>
                    </div>

                    <div class="form-group">
                        <label for="artist_image">Artist Image</label>
                        <input type="file" id="artist_image" name="artist_image" required>
                    </div>

                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <select name="genre" id="genre" class="form-control">
            <?php
                $qry= "select * from genre";
                $res= mysqli_query($conn, $qry);

                while($data = mysqli_fetch_assoc($res)){
            ?>
                <option value="<?php echo $data["id"]?>"><?php echo $data["genre_name"]?></option>
            <?php
                }
            ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-add" name="submit"><i class="fa-solid fa-plus"></i> Add Artist</button>
                        <a class="btn btn-outline-primary" href="artistlist.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>