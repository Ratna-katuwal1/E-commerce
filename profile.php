<?php
session_start();

include('connection.php');
if (!isset($_SESSION['name'])) {
  header('Location: ./CustomerLogin.php');
  exit();
}

function logout()
{
  session_destroy();
  header('Location: index.php');
  exit();
}

if (isset($_GET['logout'])) {
  logout();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopLuxe - Ladies Clothing Shop</title>
  <link rel="stylesheet" href="./profile.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <div id="page" class="site">
    <header>
      <div class="header-top">
        <ul>
          <li><a href="./CustomerRegister.php">Sign Up</a></li>
          <li><a href="./CustomerLogin.php">Login</a></li>
          <li><a href="./profile.php">My Profile</a></li>
        </ul>
      </div>

      <div class="header-nav">
        <div class="logo">
          <img src="./Images/logo1.PNG" alt="logo" />
        </div>

        <div class="nav-bar">
          <ul>
            <li><a href="./index.php">Home</a></li>
            <li><a href="./lehenga.php">Lehengas</a></li>
            <li><a href="./suit.php">Suits</a></li>
            <li><a href="./saree.php">Sarees</a></li>
          </ul>
        </div>
      </div>

      <div class="header-main">
        <form action="" class="search">
          <span class="icon-large"><i class="fa-solid fa-magnifying-glass"></i></span>
          <input type="search" placeholder="Search for Products" />
          <button type="submit">Search</button>
        </form>
      </div>
    </header>

    <section class="section_left">
      <div class="top">
        <div class="image">
          <img src="<?php echo isset($_SESSION['profile_Image']) ? $_SESSION['profile_Image'] : 'default_profile_image.jpg'; ?>" alt="profile image">
        </div>
        <div class="nameContact">
          <ul>
            <li>
              <?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>
            </li>
            <li>
              <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>
            </li>
          </ul>
        </div>
      </div>

      <div class="bottom">
        <div class="navi">
          <ul>
            <li onclick="showMyOrder()">My Order</li>
            <li onclick="showUpdateProfile()">Update Profile</li>
          </ul>
        </div>
        <div class="logout">
          <ul>
            <li><a href="?logout=true" onclick="logout()">Logout</a></li>
          </ul>
        </div>
      </div>
    </section>

    <section class="section_right">
      <h2>Customer Profile</h2>
      <div class="left">
        <ul>
          <li><span>Name:</span>
            <?php echo ($_SESSION['name']) ? $_SESSION['name'] : ''; ?>
          </li>
          <li><span>Address:</span>
            <?php echo ($_SESSION['address']) ? $_SESSION['address'] : ''; ?>
          </li>
          <li><span>E-mail:</span>
            <?php echo ($_SESSION['email']) ? $_SESSION['email'] : ''; ?>
          </li>
          <li><span>Gender:</span>
            <?php echo ($_SESSION['gender']) ? $_SESSION['gender'] : ''; ?>
          </li>
          <li><span>Contact:</span>
            <?php echo ($_SESSION['contact']) ? $_SESSION['contact'] : ''; ?>
          </li>
        </ul>
      </div>

      <div class="right">
        <h3>Profile Image</h3>
        <div class="profile_image">
          <img src="<?php echo isset($_SESSION['profile_Image']) ? $_SESSION['profile_Image'] : 'default_profile_image.jpg'; ?>" alt="profile image">
        </div>
      </div>
    </section>

    <footer>
      <div class="widgets">
        <div class="flexwrap">
          <div class="row">
            <div class="item mini-links">
              <h4>Contact Us</h4>
              <ul class="flexcol">
                <li><a href="./profile.php">Your Account</a></li>
                <li><a href="./myOrder.php">Your Order</a></li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>

          <div class="row">
            <div class="item mini-links">
              <h4>About Us</h4>
              <ul class="flexcol">
                <li><a href="#">Company info</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Policies</a></li>
                <li><a href="#">Customer Reviews</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="footer-info">
        <div class="wrapper">
          <div class="flexcol">
            <div class="logo">
              <img src="./Images/logo1.PNG" alt="">
            </div>
            <div class="socials">
              <ul class="flexitem">
                <li><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a></li>
                <li><a href="https://twitter.com/"><i class="fa-brands fa-twitter"></i></a></li>
              </ul>
            </div>
          </div>
          <p class="mini-text">Copyright 2023 &#169;. Ratna Katuwal. ShopLuxe All right reserved</p>
        </div>
      </div>
    </footer>
  </div>

  <script>
    function openImageUploader() {
      document.getElementById('fileInput').click();
    }


    function showMyOrder() {
      window.location.href = 'myOrder.php';
    }

    function showUpdateProfile() {
      window.location.href = 'updateProfile.php';
    }

    function logout() {
      window.location.href = 'index.php?logout=true';
    }
  </script>
</body>

</html>