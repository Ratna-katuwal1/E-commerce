<?php
include('connection.php');
session_start();

function validation($data)
{
    $errors = [];

    if (empty($data['name'])) {
        $errors['nameError'] = 'Please enter your name';
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $data['name'])) {
        $errors['nameError'] = 'Name must contain only letters';
    }

    if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['emailError'] = 'Please enter a valid Email Address';
    }

    if (empty($data['phone'])) {
        $errors['phoneError'] = 'Please enter your phone number';
    } elseif (!preg_match("/^\d{1,10}$/", $data['phone'])) {
        $errors['phoneError'] = 'Phone number must be numeric and not more than 10 digits';
    }

    if (empty($data['message'])) {
        $errors['messageError'] = 'please enter your message';
    }
    return $errors;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = validation($_POST);

    if (empty($errors)) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];

        $sql = "INSERT INTO message (name, email, phone, message) VALUES ('$name', '$email', '$phone', '$message')";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SHOPLUXE - Ladies Clothing Shop</title>
    <link rel="stylesheet" href="./contact.css" />
    <script src="https://kit.fontawesome.com/9a11afd28c.js" crossorigin="anonymous"></script>
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
                <form action="" class="search">
                    <span class="icon-large"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="search" placeholder="Search for Products" />
                    <button type="submit">Search</button>
                </form>
            </div>
        </header>

        <div class="contact-us">
            <div class="heading">
                <h2>SHOPLUXE GROUP</h2>
                <h3>Contact Us</h3>
            </div>

            <div class="left">
                <div class="message">
                    <h3>Leave us a Message</h3>
                </div>

                <form action="#" method="post" onsubmit="return validateForm();">
                    <div class="input-box">
                        <label for="name">Name:</label>
                        <span class="error" id="nameError"></span>
                        <input type="name" id="name" name="name" value="" autocomplete="off">
                    </div>

                    <div class="input-box">
                        <label for="name">E-mail:</label>
                        <span class="error" id="emailError"></span>
                        <input type="email" id="email" name="email" value="" autocomplete="off">
                    </div>

                    <div class="input-box">
                        <label for="phone">Phone:</label>
                        <span class="error" id="phoneError"></span>
                        <input type="phone" id="phone" name="phone" value="" autocomplete="off">
                    </div>

                    <div class="input-box">
                        <label for="name">Message:</label>
                        <span class="error" id="messageError"></span>
                        <textarea id="message" name="message" rows="4" autocomplete="off"></textarea>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>

        <div class="contact-details">
            <div class="contact-heading">
                <h2>SHOPLUXE - Ladies Shopping Store</h2>
            </div>

            <div class="details">
                <div class="contact-item">
                    <i class="fas fa-phone icon"></i>
                    <div class="text">
                        <ul>
                            <li>Call Us: </li>
                            <li>+977 9816867954</li>
                        </ul>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-location-dot icon"></i>
                    <div class="text">
                        <ul>
                            <li>Location:</li>
                            <li>Dotel Dairy Chowk<br> Gothatar-9, Kathmandu<br> Kathmandu 44600</li>
                            <li><a href="https://maps.app.goo.gl/cEwmgky7GiCys1GL9" target="_blank">View Map</a></li>
                        </ul>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-envelope icon"></i>
                    <div class="text">
                        <ul>
                            <li>E-mail us</li>
                            <li><a href="mailto:shopluxe.3453@gmail.com">shopluxe.3453@gmail.com</a></li>
                        </ul>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-earth-americas icon"></i>
                    <div class="text">
                        <ul>
                            <li>Website</li>
                            <li><a href="https://shopluxe.com.np" target="_blank">shopluxe.com.np</a></li>
                        </ul>
                    </div>
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
                                <li><a href="https://www.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                                </li>
                                <li><a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i></a>
                                </li>
                                <li><a href="https://www.linkedin.com/"><i class="fa-brands fa-linkedin"></i></a>
                                </li>
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
       function validateForm() {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        var message = document.getElementById('message').value;

        var nameError = document.getElementById('nameError');
        var emailError = document.getElementById('emailError');
        var phoneError = document.getElementById('phoneError');
        var messageError = document.getElementById('messageError');

        nameError.innerHTML = '';
        emailError.innerHTML = '';
        phoneError.innerHTML = '';
        messageError.innerHTML = '';

        var isValid = true;

        if (name === '') {
                nameError.innerHTML = 'Please enter your name';
                isValid = false;
            } else if (!/^[a-zA-Z\s]+$/.test(name)) {
                nameError.innerHTML = 'Name must contain only letters';
                isValid = false;
            }

            if (email === '' || !/^\S+@\S+\.\S+$/.test(email)) {
                emailError.innerHTML = 'Please enter a valid email address';
                isValid = false;
            }

            if (phone === '') {
                phoneError.innerHTML = 'Please enter your phone number';
                isValid = false;
            } else if (!/^\d{1,10}$/.test(phone)) {
                phoneError.innerHTML = 'Phone number must be numeric and not more than 10 digits';
                isValid = false;
            }

            if (message === '') {
                messageError.innerHTML = 'please enter your message';
                isValid =false;
            }
            return isValid;
       }
    </script>
</body>

</html>