<?php
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SHOPLUXE - Ladies Clothing Shop</title>
    <link rel="stylesheet" href="./style.css" />
    <link rel="icon" href="./Images/logo1.png" type="image/x-icon">
    <script
      src="https://kit.fontawesome.com/9a11afd28c.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <div class="site" id="page">
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
          <form action="" class="search" method="post">
            <span class="icon-large"
              ><i class="fa-solid fa-magnifying-glass"></i
            ></span>
            <input type="search" name="search_query" placeholder="Search for Products" />
            <button type="submit">Search</button>
          </form>
        </div>
      </header>

      <main>
        <div class="slider">
          <div class="slide">
            <div class="object-cover">
              <img src="./Images/UntitledDesign.png" alt="slider1" />
            </div>
            <div class="text-content">
              <h4>Designer<br />Lehengas</h4>
              <h2 class="text">
                <span>Come and Grap it!</span><br /><span>New arrival</span>
              </h2>
              <a href="./lehenga.php">Shop Now</a>
            </div>
          </div>

          <div class="slide">
            <div class="object-cover">
              <img src="./Images/1.1.png" alt="slider2" />
            </div>
            <div class="text-content">
              <h4>Designer<br />Salwar Suit</h4>
              <h2 class="text">
                <span>Enhance yoyur Beauty</span><br /><span
                  >With Designer Suit</span
                >
              </h2>
              <a href="./suit.php">Shop Now</a>
            </div>
          </div>

          <div class="slide">
            <div class="object-cover">
              <img src="./Images/saree1.png" alt="slider3" />
            </div>
            <div class="text-content">
              <h4>Designer<br />Saree</h4>
              <h2 class="text">
                <span>Wrap Yourself in Elegance</span><br /><span
                  >Get Flat 15% off</span
                >
              </h2>
              <a href="./saree.php">Shop Now</a>
            </div>
          </div>

          <div class="slide">
            <div class="object-cover">
              <img src="./Images/lengha2.png" alt="slider4" />
            </div>
            <div class="text-content">
              <h4>Designer<br />Lehengas</h4>
              <h2 class="text">
                <span>Explore your Beautiness</span><br /><span
                  >New arrival</span
                >
              </h2>
              <a href="./lehenga.php">Shop Now</a>
            </div>
          </div>

          <div class="btn">
            <a class="prev" onclick="nextimage(-1)">&#10094;</a>
            <a class="next" onclick="nextimage(1)">&#10095;</a>
          </div>

          <div class="dots">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
          </div>
        </div>

        <div class="features">
          <div class="sectop">
            <h2><span class="circle"></span><span>Featured Products</span></h2>
          </div>

          <div class="products">
            <div class="item">
              <div class="thumbnail">
                <a href="lehenga.php"><img src="./Images/lengha3.png" alt="lehenga"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(1,348)</span>
                </div>
                <h3><a href="lehenga.php">Rose Gold Wedding Designer Lehenga Choli</a></h3>
              </div>
            </div>

            <div class="item">
              <div class="thumbnail">
                <a href="lehenga.php"><img src="./Images/lehenga2.jpg" alt="lehenga"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(3,893)</span>
                </div>
                <h3><a href="lehenga.php">Swanky Multi Colour Fancy Designer Lehenga</a></h3>
              </div>
            </div>

            <div class="item">
              <div class="thumbnail">
                <a href="suit.php"><img src="./Images/suit.jpg" alt="suit"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(1,548)</span>
                </div>
                <h3><a href="suit.php">Rayon Slub Kurti With Pant Duppatta Set</a></h3>
              </div>
            </div>

            <div class="item">
              <div class="thumbnail">
                <a href="suit.php"><img src="./Images/suit1.jpg" alt="suit"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(1,321)</span>
                </div>
                <h3><a href="suit.php">Purple Designer Net Straight Salwar Suit</a></h3>
              </div>
            </div>

            <div class="item">
              <div class="thumbnail">
                <a href="suit.php"><img src="./Images/suit3.webp" alt="suit"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(1,948)</span>
                </div>
                <h3><a href="suit.php">Mustard Chikankari Georgette Designer Salwar Kameez</a></h3>
              </div>
            </div>

            <div class="item">
              <div class="thumbnail">
                <a href="saree.php"><img src="./Images/saree.jpeg" alt="saree"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(2,548)</span>
                </div>
                <h3><a href="saree.php">Resham Work Embroidered Soft Silk Navy Blue Saree</a></h3>
              </div>
            </div>

            <div class="item">
              <div class="thumbnail">
                <a href="saree.php"><img src="./Images/saree1.jpg" alt="saree"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(1,671)</span>
                </div>
                <h3><a href="saree.php">Green Heavy Border Wedding Net Saree</a></h3>
              </div>
            </div>

            <div class="item">
              <div class="thumbnail">
                <a href="saree.php"><img src="./Images/saree2.webp" alt="suit"></a>
              </div>

              <div class="content">
                <div class="rating">
                  <div class="stars"></div>
                  <span class="mini-text">(1,571)</span>
                </div>
                <h3><a href="saree.php">Mauve Zariwork Shimmer Designer Saree</a></h3>
              </div>
            </div>
          </div>
        </div>
      </main>

      <footer>
        <div class="widgets">
            <div class="flexwrap">
              <div class="row">
                <div class="item mini-links">
                  <h4>Contact Us</h4>
                  <ul class="flexcol">
                    <li><a href="./profile.php">Your Account</a></li>
                    <li><a href="./myOrder.php">Your Order</a></li>
                    <li><a href="contact.php">Contact</a></li>
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
      var imageno = 1;
      displayimg(imageno);

      function nextimage(n) {
        displayimg((imageno += n));
      }

      function currentSlide(n) {
        displayimg((imageno = n));
      }

      function displayimg(n) {
        var i;
        var images = document.getElementsByClassName("slide");
        var dots = document.getElementsByClassName("dot");

        if (n > images.length) {
          imageno = 1;
        }

        if (n < 1) {
          imageno = images.length;
        }

        for (i = 0; i < images.length; i++) {
          images[i].style.display = "none";
        }

        for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace("active", "");
        }

        images[imageno - 1].style.display = "block";
        dots[imageno - 1].className += " active";
      }
    </script>
  </body>
</html>
