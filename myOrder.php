<?php
session_start();

include('connection.php');

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = array();
}

$totalItems = 0;
$subTotal = 0;
$total = 0;
$grandTotal = 0;
foreach ($_SESSION['cart'] as $productID => $productData) {
  $totalItems += $productData['quantity'];
  $subTotal += $productData['price'] * $productData['quantity'];
}

$shippingCharge = 100;
$total = $subTotal + $shippingCharge;
$taxRate = 0.13;

$tax = $total * $taxRate;
$grandTotal = $total + $tax;

if (empty($errors)) {
  $stmt = $conn->prepare("INSERT INTO `order_product` (sn, product_name, product_Image, quantity, price, total, grandTotal, product_type, brand) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
  foreach ($_SESSION['cart'] as $productID => $productData) {
    $query = $conn->prepare("SELECT product_name, product_Image, product_type, brand FROM addproduct WHERE id = ?");
    $query->bind_param("i", $productID);
    $query->execute();
    $result = $query->get_result();
    $productInfo = $result->fetch_assoc();


    $productName = $productInfo['product_name'];
    $quantity = $productData['quantity'];
    $productPrice = $productData['price'];
    $productType = $productInfo['product_type'];
    $brand = $productInfo['brand'];
    $productImage = $productInfo['product_Image'];
    $total = $subTotal + $shippingCharge;
    $grandTotal = $total + $tax;

    if ($productImage !== null) {
      $stmt->bind_param("issddddds", $sn, $productName, $productImage, $quantity, $productPrice, $total, $grandTotal, $productType, $brand);
      $stmt->execute();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopLuxe - E-commerce Website</title>
  <link rel="stylesheet" href="./myorder.css" />
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

    <div class="container-box">
      <div class="cart-item">
        <h3>Product Cart List</h3>
      </div>

      <div class="product-list">
        <?php
        foreach ($_SESSION['cart'] as $productID => $productData) {
          $query = $conn->prepare("SELECT product_name, product_Image, product_type, brand FROM addproduct WHERE id = ?");
          $query->bind_param("i", $productID);
          $query->execute();
          $result = $query->get_result();
          $productInfo = $result->fetch_assoc();

          $productName = $productInfo['product_name'];
          $quantity = $productData['quantity'];
          $productPrice = $productData['price'];
          $productType = $productInfo['product_type'];
          $brand = $productInfo['brand'];
          $productImage = $productInfo['product_Image'];
          $total = $subTotal + $shippingCharge;
          $grandTotal = $total + $tax;
          ?>
          <div class="product-section">
            <div class="product-image">
              <img src="addProductImages/<?php echo $productImage; ?>" alt="product">
            </div>

            <div class="product-detail">
              <div class="product-title">
                <h2>
                  <?php echo $productName; ?>
                </h2>
              </div>

              <div class="product-det">
                <ul>
                  <li>Quantity:
                    <?php echo $quantity; ?>
                  </li>
                  <li>Brand:
                    <?php echo $brand; ?>
                  </li>
                  <li>Product type:
                    <?php echo $productType; ?>
                  </li>
                </ul>
              </div>

              <div class="product-remove">
                <li><a href="#"><i class="fa-solid fa-trash"></i>Remove Item</a></li>
              </div>
            </div>
          </div>
          <?php
        }
        ?>
      </div>

      <div class="amount-desp">
        <div class="summary">
          <h2>Summary:</h2>
        </div>

        <div class="amount-det">
          <ul>
            <li><span>Total item: </span>
              <?php echo $totalItems; ?>
            </li>
            <li><span>Sub-Total: </span>Rs.
              <?php echo number_format($subTotal, 2); ?>
            </li>
            <li><span>Shipping Charge: </span>Rs.
              <?php echo number_format($shippingCharge, 2); ?>
            </li>
            <li><span>Total: </span>Rs.
              <?php echo number_format($total, 2); ?>
            </li>
            <li><span>Tax (13%): </span>Rs.
              <?php echo number_format($tax, 2); ?>
            </li>
            <li><span>Grand Total: </span>Rs.
              <?php echo number_format($grandTotal, 2); ?>
            </li>
          </ul>
        </div>
        <div class="checkout">
          <button class="button" type="submit" name="submit" onclick="Checkout()">Proceed to Checkout</button>
        </div>
      </div>
    </div>

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
</body>

<script>
  function showMyOrder() {
    window.location.href = 'myOrder.php';
  }

  function showUpdateProfile() {
    window.location.href = 'updateProfile.php';
  }

  function logout() {
    window.location.href = 'index.php?logout=true';
  }

  function Checkout() {
    var totalItems = <?php echo $totalItems; ?>;
    if(totalItems > 0){
    var subTotal = <?php echo $subTotal; ?>;
    var shippingCharge = <?php echo $shippingCharge; ?>;
    var total = <?php echo $total; ?>;
    var tax = <?php echo $tax; ?>;
    var grandTotal = <?php echo $grandTotal; ?>;
    window.location.href = 'checkout.php?totalItems=' + totalItems +
      '&subTotal=' + subTotal +
      '&shippingCharge=' + shippingCharge +
      '&total=' + total +
      '&tax=' + tax +
      '&grandTotal=' + grandTotal;
  } else {
    alert("Yout cart is empty. Please add items to proceed checkout.");
    window.location.href = 'lehenga.php';
  }
}
</script>

</html>