<?php
session_start();
// include("header.php");
?>
<?php

    include('config.php');

    if(isset($_POST['submit'])){

    
      $user_email = $_POST['user_email'];
      $user_password = $_POST['user_password'];

      $query = "SELECT u.user_id, u.user_name, u.user_email, r.role_name
                FROM users u
                JOIN roles r ON u.role_id = r.r_id
                WHERE u.user_email = '$user_email'
                  AND u.user_password = '$user_password'
                  AND r.role_name = 'Admin'";

      $result = mysqli_query($conn, $query);
      $data = mysqli_fetch_array($result);
      if(mysqli_num_rows($result) > 0){
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['user_name'] = $data['user_name'];
        $_SESSION['role'] = $data['role_name'];

        if($_SESSION['role'] == 'Admin'){

          echo "<script>location.href = 'index.php';</script>";
        }
      }
      else{

          echo "   <script>
          document.getElementById('err').innerHTML='Username Or Password is Incorrect';
          </script>";
         }
    }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Sound Music</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Inter', sans-serif;
      background: #0F1117;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      position: relative;
      overflow: hidden;
    }
    body::before {
      content: '';
      position: absolute;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(108,43,217,0.15) 0%, transparent 70%);
      top: -150px;
      right: -150px;
      border-radius: 50%;
      animation: float1 8s ease-in-out infinite;
    }
    body::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(0,212,255,0.1) 0%, transparent 70%);
      bottom: -100px;
      left: -100px;
      border-radius: 50%;
      animation: float2 10s ease-in-out infinite;
    }
    @keyframes float1 {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(-20px, 20px); }
    }
    @keyframes float2 {
      0%, 100% { transform: translate(0, 0); }
      50% { transform: translate(20px, -20px); }
    }
    .login-container {
      background: rgba(26, 29, 39, 0.8);
      padding: 40px 35px;
      border-radius: 20px;
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
      width: 380px;
      text-align: center;
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255,255,255,0.06);
      position: relative;
      z-index: 1;
    }
    .login-container::before {
      content: '';
      position: absolute;
      top: -1px;
      left: -1px;
      right: -1px;
      height: 3px;
      background: linear-gradient(90deg, #FF2D78, #6C2BD9, #00D4FF);
      border-radius: 20px 20px 0 0;
    }
    .login-container h1 {
      color: #E8E8ED;
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 24px;
      background: linear-gradient(135deg, #FF2D78, #6C2BD9);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .login-form {
      display: flex;
      flex-direction: column;
      gap: 6px;
    }
    .login-form label {
      color: rgba(232,232,237,0.5);
      font-weight: 500;
      text-align: left;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    .login-form input {
      width: 100%;
      padding: 12px 16px;
      box-sizing: border-box;
      margin-top: 4px;
      margin-bottom: 5px;
      border: 1px solid rgba(255,255,255,0.08);
      border-radius: 10px;
      background: rgba(255,255,255,0.04);
      color: #E8E8ED;
      outline: none;
      font-size: 15px;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
    }
    .login-form input:focus {
      border-color: rgba(108,43,217,0.5);
      box-shadow: 0 0 0 3px rgba(108,43,217,0.1);
    }
    .login-form button {
      background: linear-gradient(135deg, #6C2BD9, #00D4FF);
      color: white;
      padding: 14px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    .login-form button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(108,43,217,0.4);
    }
    #err {
      color: #FF2D78 !important;
      font-weight: 600;
      font-size: 14px;
      padding: 8px;
      border-radius: 8px;
      background: rgba(255,45,120,0.1);
    }
  </style>
<body>

<div class="content-body">
    <div class="container-fluid">
        <div class="row">
        <div id="err" style="color:white"></div>
<div class="login-container">
<div id="err" style="color:red"></div>
                <form action="" class="login-form" id="loginForm"  method="Post">
                
                    <h1>Admin Login</h1>
                    <label for="username">Email:</label>
                    <input type="text" class="p-1 border border-dark rounded" id="username" name="user_email" autocomplete="off" required><br>
                    <label for="password">Password:</label>
                    <input type="password" class="p-1 border border-dark rounded" id="password" name="user_password" autocomplete="off" required><br><br>

                    <button class="btn btn-outline-primary btn-lg" name="submit">Login</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
    
    // include("footer.php");

?>
