<?php
include "header.php";
?>

<?php
    include("config.php");
    $id = $_GET['id'];

   if(isset($_POST['submit'])){
    $id = $_POST["id"];
    $genre_name = $_POST["genre_name"];
    
    $query1 = "UPDATE `genre` SET `genre_name`='$genre_name' WHERE id = $id";
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
                <form action="" method="Post">
                    <h1>Edit Genre</h1>
                    <?php
                    $qry = "SELECT * FROM `genre` WHERE id = $id";
                    $result1 = mysqli_query($conn, $qry);
                    $rows = mysqli_fetch_assoc($result1);
                    ?>
                    <input value="<?php echo $rows["id"]?>" type="hidden" name="id">

                    <div class="form-group">
                        <label for="genre_name">Genre Name</label>
                        <input value="<?php echo htmlspecialchars($rows['genre_name'])?>" type="text" id="genre_name" name="genre_name" required>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-add" name="submit"><i class="fa-solid fa-check"></i> Save Changes</button>
                        <a class="btn btn-outline-primary" href="genrelist.php"><i class="fa-solid fa-xmark"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
