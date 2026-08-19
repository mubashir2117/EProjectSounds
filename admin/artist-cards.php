<?php
include "header.php";
?>
<?php
include("config.php");
$query12 = "SELECT * FROM `artist` inner join genre where genre.id = artist.genre_id";
$result12 = mysqli_query($conn,$query12);

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
            while ($data = mysqli_fetch_assoc($result12)) {
            ?>
                <div class="col-lg-3 mt-3">
                    <div class="card bg-dark text-white" style="width: 15rem; margin-top:90px; margin-left:250px; ">
                        <img src="<?php echo $data['artist_image'] ?>"  style="width:239px; height:220px; " class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-text"><?php echo $data['artist_name'] ?></h5><br>
                            <h5 class="card-title"><?php echo $data['genre_name'] ?></h5>
                       
                            
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