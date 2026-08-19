<?php
include "header.php";
?>
<?php
include("config.php");
$query = "SELECT * FROM `song`  join genre on genre.id = song.genre_id join artist on artist.Artist_id = song.Artists_id";
$result = mysqli_query($conn,$query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <?php
            while ($data = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-lg-3 ms-5 mt-1">
                    <div class="card bg-dark text-white" style="width: 21rem; margin-top:90px; margin-left:200px">
                        <img src="<?php echo $data['song_image'] ?>" class="card-img-top"  width="20px" height="200px"alt="...">
                        <div class="card-body">
                            <h1 class="card-title"><?php echo $data['song_name'] ?></h1>
                            <audio controls>
  <source src="<?php echo $data["song_file"]; ?>" width="20px" height="100px" type="audio/ogg"> 
</audio><br>
            <h5 class="card-title"><?php echo $data['genre_name'] ?></h5>
            
            <h5 class="card-title"><?php echo $data['artist_name'] ?></h5>
           
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</body>

</html>

<?php
include "footer.php";
?>