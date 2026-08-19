
<?php
include "header.php";
?>

<div class="content-body">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <form action="" method="Post">
                    <h1>Add Genre</h1>

                    <div class="form-group">
                        <label for="genre_name">Genre Name</label>
                        <input type="text" id="genre_name" name="genre_name" placeholder="e.g. Pop" required>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-add" name="submit"><i class="fa-solid fa-plus"></i> Add Genre</button>
                        <a class="btn btn-outline-primary" href="genrelist.php">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>

<?php
    include("config.php");
   if(isset($_POST['submit'])){
   
    $genre_name = $_POST["genre_name"];
    
    $query = "INSERT INTO `genre`(`genre_name`) VALUES ('$genre_name')";

    $result = mysqli_query($conn, $query);

    if($result){
        echo "Record inserted";
       
    }
    else{
        echo "Error";
    }
}
?>