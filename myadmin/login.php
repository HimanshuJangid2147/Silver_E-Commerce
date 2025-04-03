<?php
include 'class.php';
$db = new GeneralSettings();
$row = $db->getSettings();
$rowdetails = $row->fetch_assoc();
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
 {
  
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create AdminLogin object
    $login = new AdminLogin();
    $result = $login->login($email, $password);

    // Check if login was successful
    if ($result && $result->num_rows ==1) {
     

      $_SESSION['adminlogin']="ss";
      // Redirect to dashboard
      header("Location: index.php");
      exit();
    }
    else {
      $error_message = "Invalid email or password!";
    }
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <title>Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="keywords" content="Modern Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
  <script type="application/x-javascript">
    addEventListener("load", function() {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
  <!-- Custom CSS -->
  <link href="css/style.css" rel='stylesheet' type='text/css' />
  <link href="css/font-awesome.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="js/jquery.min.js"></script>
  <!----webfonts--->
  <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
  <!---//webfonts--->
  <!-- Bootstrap Core JavaScript -->
  <script src="js/bootstrap.min.js"></script>
</head>

<body id="login">
  <div class="login-logo">
    <a href="index.php" alt="Logo" /><img src="<?php echo $rowdetails['StoreLogo']; ?> "height="250" /></a>
  </div>
  <h2 class="form-heading">login</h2>
  <div class="app-cam">
    <?php if(!empty($error_message)): ?>
      <div class="alert alert-danger">
        <?php echo $error_message;?>
      </div>
    <?php endif;?>
    <form method="post" action="">
      <input type="text" class="text" placeholder="E-mail address" value="<?php ?>" name="email" required>
      <input type="password" value="Password" name="password">
      <div class="submit"><input type="submit" onclick="myFunction()" value="Login"></div>
      <div class="login-social-link">
        <a href="index.php" class="facebook">
          Facebook
        </a>
        <a href="index.php" class="twitter">
          Twitter
        </a>
      </div>
      <ul class="new">
        <li class="new_left">
          <p><a href="#">Forgot Password ?</a></p>
        </li>
        <li class="new_right">
          <p class="sign">New here ?<a href="register.php"> Sign Up</a></p>
        </li>
        <div class="clearfix"></div>
      </ul>
    </form>
  </div>
</body>

</html>