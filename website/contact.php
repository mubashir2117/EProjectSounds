<?php
session_start();
include("config.php");

if(isset($_POST['submit'])){

    $c_name  = mysqli_real_escape_string($conn, $_POST['c_name']);
    $c_email = mysqli_real_escape_string($conn, $_POST['c_email']);
    $reviews = mysqli_real_escape_string($conn, $_POST['reviews']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contact(c_name, c_email, reviews, message)
              VALUES('$c_name','$c_email','$reviews','$message')";

    $result = mysqli_query($conn, $query);

    if($result){
        echo "<script>
                alert('Message Sent Successfully!');
                window.location='contact.php';
              </script>";
    }else{
        echo "<script>
                alert('Error: ".mysqli_error($conn)."');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Contact — YOUR VOICE ON THE MARK</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.6/gsap.min.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
       <!--favicon-img--> 
       <link rel="icon" type="image/png" href="images/logo-new.svg">
       <!--favicon-img-->
    
        <link rel="stylesheet" href="css/index.css">
       
    
    </head>
<body>
    <main id="contact-one">

            <!-- PRELOADER -->
        <div id="preloader">
            <div class="p">
                <img src="images/logo-new.svg" alt="logo" style="width:200px; height:auto;">
            </div>
            <div class="p">Use Headphone For Better Music Experience.</div>
        </div>
        <!-- PRELOADER -->


        <div id="contact-one-content">

  <!-- TOP NAVIGATION BAR -->
  <header class="top-navbar">
    <a href="index.php" class="brand">
        <img src="images/logo-new.svg" alt="YOUR VOICE ON THE MARK">
    </a>

    <nav class="nav-links">
        <a href="index.php">Home</a>
        <a href="songsone.php">Songs</a>
        <a href="videoone.php">Videos</a>
        <a href="about.php">About Us</a>
    </nav>

    <div class="nav-user">
        <?php if(isset($_SESSION['user_name'])){ ?>
            <span class="user-chip">
                <span class="user-avatar"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                <?php echo $_SESSION['user_name']; ?>
            </span>
            <a href="logout.php" class="btn-logout">Logout</a>
        <?php } else { ?>
            <a href="login.php" class="btn-login">Login</a>
        <?php } ?>

        <div class="menu-bar hover" id="hamburger">
            <div class="menu-bar-name text">Menu</div>
            <div class="menu-bar-lines text">
                <div class="menu-bar-line"></div>
                <div class="menu-bar-line"></div>
            </div>
        </div>
    </div>
</header>
<!-- TOP NAVIGATION BAR -->

<!-- SOCIAL MEDIA LINKS -->
<div class="social-media-links">
    <ul>
        <li>
            <a href="https://www.youtube.com/channel/UCCCiwtoLf3wMnRMdxOYTErg#" data-text="Youtube" class="soc-icon soc-youtube hover" aria-label="YouTube">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19C0 8.07 0 12 0 12s0 3.93.5 5.81a3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14C24 15.93 24 12 24 12s0-3.93-.5-5.81zM9.55 15.57V8.43L15.82 12l-6.27 3.57z"/></svg>
            </a>
        </li>
        <li>
            <a href="https://www.facebook.com/" data-text="Facebook" class="soc-icon soc-facebook hover" aria-label="Facebook">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07c0 6.03 4.39 11.03 10.13 11.93v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.69.24 2.69.24v2.97h-1.52c-1.49 0-1.96.93-1.96 1.89v2.25h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07z"/></svg>
            </a>
        </li>
        <li>
            <a href="https://www.instagram.com/" data-text="Instagram" class="soc-icon soc-instagram hover" aria-label="Instagram">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.8-.25-2.23-.41-.56-.22-.96-.48-1.38-.9-.42-.42-.68-.82-.9-1.38-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38.42-.42.82-.68 1.38-.9.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63c-.79.31-1.46.72-2.13 1.38C1.35 2.68.94 3.35.63 4.14.33 4.9.13 5.78.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91.31.79.72 1.46 1.38 2.13.67.66 1.34 1.07 2.13 1.38.76.3 1.64.5 2.91.56 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56.79-.31 1.46-.72 2.13-1.38.66-.67 1.07-1.34 1.38-2.13.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91-.31-.79-.72-1.46-1.38-2.13C20.32 1.35 19.65.94 18.86.63 18.1.33 17.22.13 15.95.07 14.67.01 14.26 0 12 0zm0 5.84A6.16 6.16 0 1 0 18.16 12 6.16 6.16 0 0 0 12 5.84zm0 10.16A4 4 0 1 1 16 12a4 4 0 0 1-4 4zm7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
            </a>
        </li>
    </ul>
</div>
<!-- SOCIAL MEDIA LINKS -->





<!-- HEADING -->
<div class="section-head">
    <span class="section-eyebrow">GET IN TOUCH</span>
    <h2 class="heading-text">CONTACT</h2>
    <p class="section-sub">Let's make something worth listening to.</p>
</div>

<!-- HEADING -->


<div id="flex-row">

<!-- CONTACT FORM -->

<div id="contact-form">


    <div id="form" class="opacity-contact">

            <form action="" method="POST">
              <div class="input-line">
                <input id="name" name="c_name" type="text" placeholder="NAME" class="input-same-line" required>
                <input id="email" type="email" name="c_email" placeholder="EMAIL" class="input-same-line" required>
              </div>
              <div class="input-line-column">
                <input id="subject" name="reviews" type="text" placeholder="REVIEWS" required>
                <input id="subject" name="message" type="text" placeholder="MESSAGE" required>
              </div>
             <button type="submit" id="submit" name="submit" class="hover">Send</button>
            </form>
          
    </div>
</div>

<!-- CONTACT FORM -->



<!-- ENQUIRY MAIL -->

<div id="collaboration-mail" class="opacity-contact">

    <div class="circular-text">
        <span id="rotated">  
            FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp; 
            FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp; 
            FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp; 
            FOR COLLABORATION * &nbsp;&nbsp;&nbsp;&nbsp;
         </span>
    </div>
    <div class="mail">
        <a href="">Sound</a>
    </div>
</div>

<!-- ENQUIRY MAIL -->

</div>

 <!-- HEADPHONE IMG -->
 <div class="headphone img text">
    <img src="images/headphone.png" title="headphone zone" class="text" alt="headphone">
  </div>
   <!-- HEADPHONE IMG -->
  


<!-- progress-bar -->
<div class="progress-bar-container fade-in">
    <div class="progressbar"></div>
</div>
<!-- progress-bar -->



        </div>


        
    <!-- NAVIGATION CONTENT -->
    <div class="navigation-content">
        
        <ul class="navigation-ul">
            <li><a href="index.php" data-text="Home" data-img="images/album-thumbnail-five.jpg">Home</a></li>
            <li><a href="about.php"  data-text="About"  data-img="images/about-img.jpg">About</a></li>
            <li><a href="songsone.php" data-text="Songs"  data-img="images/album-thumbnail-nine.jpg">Songs</a></li>
            <li><a href="videoone.php"  data-text="Video" data-img="images/img.jpg">Video</a></li>
            <li><a href="contact.php"  data-text="Contact" data-img="images/album-thumbnail-four.jpg">Contact</a></li>
        </ul>
        <div class="navigation-close hover about-close opacity">
            <div class="navigation-close-line"></div>
            <div class="navigation-close-line"></div>
          </div>
    
            <div class="project-preview"></div>

            
     <!-- HEADPHONE IMG -->
     <div class="headphone-navigation opacity">
        <img src="images/headphone.png" title="headphone zone" class="text" alt="headphone">
      </div>
       <!-- HEADPHONE IMG -->

    
    </div>
    
    <!-- NAVIGATION CONTENT -->




        </main>

        <!-- FOOTER -->
        <?php include "footer.php"; ?>
        <!-- FOOTER -->

        <script src="js/jquery.min.js"></script>
        <script src="js/circletype.min.js"></script>
        <script src="js/jquery.lettering.js"></script>
        <script src="js/bez.js"></script>
        <script src="js/pace.js"></script>
        <script src="js/index.js"></script>

</body>
</html>
<?php
   if(isset($_POST['submit'])){
   
    $c_name = $_POST["c_name"];
    $c_email = $_POST["c_email"];
    $reviews = $_POST["reviews"];
    $message = $_POST["message"];
    
    $query = "INSERT INTO `contact`(`c_name`,`c_email`,`reviews`,`message`) VALUES 
    ('$c_name','$c_email','$reviews','$message')";

    $result = mysqli_query($conn, $query);

    if($result){
        echo "Record inserted";
    }
    else{
        echo "Error";
    }
}

?>