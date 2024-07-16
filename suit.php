<?php
session_start();
if (!isset($_SESSION['cart_quantity'])) {
  $_SESSION['cart_quantity'] = array();
}
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ShopLuxe - Ladies Clothing Shop</title>
  <link rel="stylesheet" href="./lehenga.css" />
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
            <span class="icon-large"
              ><i class="fa-solid fa-magnifying-glass"></i
            ></span>
            <input type="search" placeholder="Search for Products" />
            <button type="submit">Search</button>
          </form>
        </div>
    </header>

    <div class="title">
      <h2>Suits</h2>
    </div>
    <div class="product">

      <?php
      $select = mysqli_query($conn, "SELECT * FROM addproduct WHERE product_category='suit'");
      while ($row = mysqli_fetch_assoc($select)) { ?>
        <div class="row1">
          <tbody>
            <tr>
              <td>
                <img src="addProductImages/<?php echo $row['product_Image']; ?>" alt="" />
              </td>
              <td>
                <h3>
                  <?php echo $row['product_name']; ?>
                </h3>
              </td>
              <td>
                <p>Brand:
                  <?php echo $row['brand']; ?> |
                  <?php echo $row['product_type']; ?>
                </p>
              </td>
              <td>
                <h2>Rs: <span>
                    <?php echo $row['price']; ?>
                  </span></h2>
              </td>
              <td>
                <form class="inc">
                  <div class="value-button" id="decrease" value="Decrease Value"
                    data-product-id="<?php echo $row['id']; ?>">-</div>
                  <input type="number" class="number" id="number_<?php echo $row['id']; ?>" value="0" />
                  <div class="value-button" id="increase" value="Increase Value"
                    data-product-id="<?php echo $row['id']; ?>">+</div>
                  <?php
                  if (isset($_SESSION['name'])) {
                    if (isset($row['product_id'])) {
                      $productID = $row['product_id'];
                    } else {
                      $productID = '';
                    }
                    ?>
                    <button class="add-to-cart" data-product-id="<?php echo $row['id']; ?>"
                      data-product-price="<?php echo $row['price']; ?>"> Add to Cart </button>
                  <?php } else { ?>
                    <p>Please <a href="./CustomerLogin.php" class="hover-link"> login</a> or <a href="./CustomerRegister.php"
                        class="hover-link"> register</a> to add products
                      in your cart. </p>
                  <?php } ?>
                </form>
              </td>
              <td><a href="productDetails.php?product_id=<?php echo $row['id']; ?>">View Details</a></td>
            </tr>
          </tbody>
        </div>
      <?php } ?>


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
      document.addEventListener('DOMContentLoaded', function () {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        const decreaseButtons = document.querySelectorAll('.value-button#decrease');
        const increaseButtons = document.querySelectorAll('.value-button#increase');

        addToCartButtons.forEach(button => {
          button.addEventListener('click', addToCart);
        });

        decreaseButtons.forEach(button => {
          button.addEventListener('click', decreaseQuantity);
        });

        increaseButtons.forEach(button => {
          button.addEventListener('click', increaseQuantity);
        });

        function addToCart(event) {
          event.preventDefault();
          const productId = event.target.getAttribute('data-product-id');
          const productPrice = event.target.getAttribute('data-product-price');
          const quantityInput = document.querySelector(`#number_${productId}`);
          const productName = event.target.closest('.row1').querySelector('h3').textContent;
          const quantity = parseInt(quantityInput.value);
          const total = quantity * parseFloat(productPrice);
          if (quantity > 0) {
          fetch(`addToCart.php?product_id=${productId}&price=${productPrice}&product_name=${productName}&quantity=${quantity}&total=${total}`)
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert('product added to cart');
                quantityInput.value = 0;
              } else {
                alert('Error adding product to cart')
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });
        } else {
          alert('Invalid quantity. Please select a valid quantity.');
        }
      }

        function decreaseQuantity(event) {
          const productId = event.target.getAttribute('data-product-id');
          const quantityInput = document.querySelector(`#number_${productId}`);
          let currentQuantity = parseInt(quantityInput.value);
          if (currentQuantity > 0) {
            currentQuantity--;
            quantityInput.value = currentQuantity;
          }
        }

        function increaseQuantity(event) {
          const productId = event.target.getAttribute('data-product-id');
          const quantityInput = document.querySelector(`#number_${productId}`);
          let currentQuantity = parseInt(quantityInput.value);
          currentQuantity++;
          quantityInput.value = currentQuantity;
        }
      });
    </script>
</body>

</html>