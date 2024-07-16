<?php
session_start();
include('connection.php');

if (!isset($_SESSION['email'])) {
  // $_SESSION['error'] = "";
  header('Location: adminLogin.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SHOPLUXE - Ladies Shopping Store</title>
  <link rel="stylesheet" href="account.css" />
  <link rel="icon" href="./Images/logo1.png" type="image/x-icon">
  <script src="https://kit.fontawesome.com/9a11afd28c.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="sidebar">
    <div class="sidebar-logo">
      <img src="./images/logo.png" alt="logo" />
    </div>

    <div class="sidebar-menu">
      <ul>
        <li><a href="dashboard.php" class="active">Dashboard</a></li>
        <li><a href="customer.php" class="active">Customers</a></li>
        <li><a href="addProduct.php" class="active">Add Products</a></li>
        <li><a href="productList.php" class="active">Product Lists</a></li>
        <li><a href="order.php" class="active">Orders</a></li>
        <li><a href="account.php" class="active">Account</a></li>
        <li><a href="logout.php" class="active">Logout</a></li>
      </ul>
    </div>
  </div>

  <div class="main-content">
    <header>
      <h2>Account</h2>
      <div class="search-wrapper">
        <span class="fa-solid fa-magnifying-glass"></span>
        <input type="search" placeholder="Search Here" />
      </div>

      <div class="user-wrapper">
        <img src="<?php echo isset($_SESSION['profile_Image']) ? $_SESSION['profile_Image'] : 'defaultimage.jpg'; ?>" width="50px" height="50px" alt="profile" />
        <div>
          <h4>Ratna Katuwal</h4>
          <small>Admin</small>
        </div>
      </div>
    </header>

    <main>
      <div class="cust">
        <div class="heading">
          <h1>Admin Profile</h1>
        </div>

        <section class="section-left">
          <div class="profile">
            <img src="<?php echo isset($_SESSION['profile_Image']) ? $_SESSION['profile_Image'] : 'defaultimage.jpg'; ?>" alt="profile" />
          </div>
          <div class="name-email">
            <ul>
              <li>
              <?php echo isset($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>
              </li>
              <li>
              <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>
              </li>
            </ul>
          </div>

          <div class="social-links">
            <ul>
              <li><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a></li>
              <li><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i></a></li>
              <li><a href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a></li>
              <li><a href="https://twitter.com/"><i class="fa-brands fa-twitter"></i></a></li>
            </ul>
          </div>
        </section>

        <section class="section-right">
          <div class="details">
            <ul>
              <li>Name:
              <?php echo ($_SESSION['fullname']) ? $_SESSION['fullname'] : ''; ?>
              </li>
              <li>Contact:
              <?php echo ($_SESSION['contact']) ? $_SESSION['contact'] : ''; ?>
              </li>
              <li>E-mail:
              <?php echo ($_SESSION['email']) ? $_SESSION['email'] : ''; ?>
              </li>
              <li>Address:
              <?php echo ($_SESSION['address']) ? $_SESSION['address'] : ''; ?>
              </li>
              <li>Gender:
              <?php echo ($_SESSION['gender']) ? $_SESSION['gender'] : ''; ?>
              </li>
            </ul>
          </div>
          <div class="btn">
            <button type="submit" name="submit" onclick="updateProfile()">Update Profile</button>
          </div>
        </section>
      </div>
    </main>
  </div>
  <script>
    function updateProfile() {
      window.location.href = 'adminDetailUpdate.php';
    }
  </script>
</body>

</html>