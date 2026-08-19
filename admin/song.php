
<?php
include "header.php";
?>
<?php
    include("config.php");
   if(isset($_POST['submit'])){
   
    $song_name = $_POST["song_name"];
    $genre_id = $_POST["genre"];
    $Artists_id = $_POST["artist"];
    $year = $_POST["years"];
    
    $img=$_FILES["song_image"];
    $imgName= $img['name'];
    $tempPath = $img['tmp_name'];
    $myPath= "images/".$imgName;
    
    move_uploaded_file($tempPath, $myPath);
    
    
    $audio = $_FILES["song_file"];
    $audioName = $audio['name'];
    $tempAudioPath = $audio['tmp_name'];
    $audioPath = "audio/".$audioName;
    move_uploaded_file($tempAudioPath, $audioPath);



    $query9 = "INSERT INTO `song`(`song_name`,`song_image`,`song_file`,`years`,`genre_id`,`Artists_id`) VALUES
     ('$song_name','$myPath','$audioPath','$year','$genre_id','$Artists_id')";
$result9 = mysqli_query($conn, $query9);

$qry11= "select * from song";
$res11= mysqli_query($conn, $qry11);


    if($result9){
        echo "Record inserted";
        header("Location: songlist.php");

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

                    <h1>Add Song</h1>

                    <div class="form-group">
                        <label for="song_name">Song Name</label>
                        <input type="text" id="song_name" name="song_name" placeholder="e.g. Tera Hone Laga Hoon" required>
                    </div>

                    <div class="form-group">
                        <label for="song_image">Song Image</label>
                        <input type="file" id="song_image" name="song_image" required>
                    </div>

                    <div class="form-group">
                        <label for="song_file">Audio File</label>
                        <input type="file" id="song_file" name="song_file" required>
                    </div>

                    <div class="form-group">
                        <label for="years">Release Year</label>
                        <input type="text" id="years" name="years" placeholder="e.g. 2024" required>
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

                    <div class="form-group">
                        <label for="artist">Artist</label>
                        <select name="artist" id="artist" class="form-control">
            <?php
                $qry1= "select * from artist";
                $res1= mysqli_query($conn, $qry1);

                while($data1 = mysqli_fetch_assoc($res1)){
            ?>
                <option value="<?php echo $data1["Artist_id"]?>"><?php echo $data1["artist_name"]?></option>
            <?php
                }
            ?>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-add" name="submit"><i class="fa-solid fa-plus"></i> Add Song</button>
                        <a class="btn btn-outline-primary" href="songlist.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include 'footer.php';
            
?>
