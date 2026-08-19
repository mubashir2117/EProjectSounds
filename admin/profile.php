<?php
      
      include("header.php");
     
        if(!isset($_SESSION['user_id'])){
          echo "<script>location.href = 'index.php';</script>";
          
        }
        else{
       $id = $_GET["id"];
        include("config.php");
        
        $userQuery = "SELECT * FROM users where id = $id";
        $userData = mysqli_query($conn, $userQuery);
        $user = mysqli_fetch_array($userData);
        $query = "SELECT * FROM roles";
        $result = mysqli_query($conn, $query);
        
        if(""){
          $_SESSION['user_id'] = $data['id'];
          $_SESSION['user_name'] = $data['user_name'];
            echo "<script>location.href = 'index.php';</script>";
        }
      ?>
      <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">

      <title>Impact Bootstrap Template - Index</title>
      <meta content="" name="description">
      <meta content="" name="keywords">

      <!-- Favicons -->
      <link href="assets/img/favicon.png" rel="icon">
      <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

      <!-- Google Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

      <!-- Vendor CSS Files -->
      <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
      <link href="assets/vendor/aos/aos.css" rel="stylesheet">
      <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
      <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

      <!-- Template Main CSS File -->
      <link href="assets/css/main.css" rel="stylesheet">

    </head>

      <main id="main">
          <!-- ======= login Section ======= -->
      <section id="contact" class="contact mb-5">
            <div class="container" data-aos="fade-up">
      
            
    <form class="form w-50 mt-5 mx-auto p-3 bg-light rounded-2" method="POST">
        <h1 class="text-center display-5">Edit Profile</h1>
        <input type="hidden" value="<?php echo $user["id"]?>" name="id"/>
        <input value="<?php echo $user["user_name"]?>"  placeholder="Enter username" class="form-control p-1 mt-2" type="text" name="user_name">
        <input value="<?php echo $user["user_email"]?>"  placeholder="Enter email" class="form-control p-1 mt-2" type="text" name="user_email">
        <input value="<?php echo $user["user_password"]?>"  placeholder="Enter password" class="form-control p-1 mt-2" type="password" name="user_password">
        <input value="<?php echo $user["user_address"]?>"  placeholder="Enter Address" class="form-control p-1 mt-2" type="text" name="user_address">
        
        <input class="btn btn-warning w-100 mt-5" type="submit" name="submit">
    </form>
                </div><!-- End login Form -->
              </div>
      
            </div>
          </section><!-- End login Section -->
      </main>
      
      <?php
        
            if(isset($_POST['submit'])){
              $user_name = $_POST["user_name"];
        $user_email =  $_POST["user_email"];
        $user_password =  $_POST["user_password"];
        $user_address =  $_POST["user_address"];

        if($user_name != null){
        $query = "UPDATE `users` SET `user_name`='$user_name', `user_email`='$user_email',`user_password`='$user_password',
        `user_address`='$user_address' WHERE id = $id";
        }
    $result = mysqli_query($conn, $query);

      echo "<script>location.href = 'index.php';</script>"; 
    }
    include("footer.php");
    }
      ?>
