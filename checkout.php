<?php
session_start();

$totalItems = $_GET['totalItems'] ?? 0;
$subTotal = $_GET['subTotal'] ?? 0;
$shippingCharge = $_GET['shippingCharge'] ?? 0;
$tax = $_GET['tax'] ?? 0;
$grandTotal = $_GET['grandTotal'] ?? 0;

function validation($data)
{
    $errors = [];

    if (empty ($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['emailError'] = 'Please enter a valid Email Address';
    }

    if (empty ($data['name'])) {
        $errors['nameError'] = 'Please enter your name';
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $data['name'])) {
        $errors['nameError'] = 'Name must contain only letters';
    }

    if (empty ($data['address'])) {
        $errors['addressError'] = 'please enter your address';
    }

    if (empty ($data['postal'])) {
        $errors['postalError'] = 'Please enter your postal/zip code';
    } elseif ($data['country'] === 'your_country_code' && !preg_match("/^\d{6}$/", $data['postal'])) {
        $errors['postalError'] = 'Postal code must be 6 digits for your country';
    }

    if (empty ($data['phone'])) {
        $errors['phoneError'] = 'Please enter your phone number';
    } elseif (!preg_match("/^\d{1,10}$/", $data['phone'])) {
        $errors['phoneError'] = 'Phone number must be numeric and not more than 10 digits';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validationErrors = validation($_POST);

    if (empty ($validationErrors)) {
        $orderQuery = "INSERT INTO checkout (customer_name, contact, product_name, product_Image, quantity, price, grandTotal)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $orderQuery);

        $customerName = $_POST['name'];
        $contact = $_POST['phone'];
        $productName = 'Your Product Name'; // Modify this according to your needs
        $productImage = 'path/to/product/image.jpg'; // Modify this according to your needs
        $quantity = $totalItems;
        $price = $subTotal + $shippingCharge;
        $grandTotalValue = $grandTotal;

        mysqli_stmt_bind_param($stmt, 'ssssidd', $customerName, $contact, $productName, $productImage, $quantity, $price, $grandTotalValue);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['orderDetails'] = [
            'customer_name' => $customerName,
            'contact' => $contact,
            'product_name' => $productName,
            'product_Image' => $productImage,
            'quantity' => $quantity,
            'price' => $price,
            'grandTotal' => $grandTotal,
        ];

        header("Location: khaltiPayment.php?totalItems=$totalItems&subTotal=$subTotal&shippingCharge=$shippingCharge&total=" . ($subTotal + $shippingCharge) . "&tax=$tax&grandTotal=$grandTotal");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShopLuxe - Ladies Shopping Store</title>
    <link rel="stylesheet" href="./checkout.css" />
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
            <div class="container-heading">
                <h1>Shipping and Billing</h1>
                <h2>SHOPLUXE: Ladies Clothing Shop</h2>
                <h3>Original Product | Safe Payment | Easy Return</h3>
            </div>

            <div class="billing">
                <div class="billing-detail">
                    <h2>Billing Details</h2>
                </div>

                <form action="#" method="post">
                    <div class="inputbox">
                        <label for="email">E-mail: </label>
                        <span id="emailError" class="error"></span>
                        <input type="email" id="email" name="email" value="" autocomplete="off">
                    </div>

                    <div class="inputbox">
                        <label for="name">Name: </label>
                        <span id="nameError" class="error"></span>
                        <input type="name" id="name" name="name" value="" autocomplete="off">
                    </div>

                    <div class="inputbox">
                        <label for="country">Country: </label>
                        <span id="countryError" class="error"></span>
                        <select name="country" id="country" autocomplete="off"></select>
                    </div>

                    <div class="inputbox">
                        <label for="address">Address: </label>
                        <span id="addressError" class="error"></span>
                        <input type="address" id="address" name="address" value="" autocomplete="off">
                    </div>

                    <div class="inputbox">
                        <label for="email">Postal / Zip: </label>
                        <span id="postalError" class="error"></span>
                        <input type="postal" id="postal" name="postal" value="" autocomplete="off">
                    </div>

                    <div class="inputbox">
                        <label for="phone">Phone: </label>
                        <span id="phoneError" class="error"></span>
                        <input type="phone" id="phone" name="phone" value="" autocomplete="off">
                    </div>
                </form>
            </div>
        </div>

        <form id="khaltiForm" action="khaltiPayment.php" method="get">
            <input type="hidden" name="email" value="">
            <input type="hidden" name="name" value="">
            <input type="hidden" name="phone" value="">
            <input type="hidden" name="grandTotal" id="grandTotal" value="<?php echo $grandTotal; ?>">

        </form>

        <div class="order">
            <div class="order-heading">
                <h2>Your Order</h2>
            </div>

            <div class="order-desc">
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
                        <?php echo number_format($subTotal + $shippingCharge, 2); ?>
                    </li>
                    <li><span>Tax (13%): </span>Rs.
                        <?php echo number_format($tax, 2); ?>
                    </li>
                    <li><span>Grand Total: </span>Rs.
                        <?php echo number_format($grandTotal, 2); ?>
                    </li>
                </ul>
            </div>

            <div class="second">
                <div class="payment-option">
                    <h3>Select Payment Method</h3>
                </div>

                <div class="radio-btn">
                    <div class="radio-list">
                        <div class="radio-item"><input name="radio" id="radio1" type="radio"><label for="radio1">Cash in
                                Delivery</label></div>
                        <div class="radio-item"><input name="radio" id="radio3" type="radio"><label for="radio3">Pay
                                vis Khalti</label></div>
                    </div>
                </div>
                <div class="order-place">
                    <div id="radioError" class="error"></div>
                    <!-- <button class="button" type="submit" name="submit">Place Order</button> -->
                    <button class="button" type="submit" name="submit" onclick="placeOrder()">Place Order</button>
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

    <script>
        fetch("https://restcountries.com/v2/all")
            .then(response => response.json())
            .then(data => {
                var countrySelect = document.getElementById("country");
                var defaultOption = document.createElement("option");
                defaultOption.value = "";
                defaultOption.text = "Select your country";
                defaultOption.disabled = true;
                defaultOption.selected = true;
                countrySelect.add(defaultOption);

                data.forEach(country => {
                    var option = document.createElement("option");
                    option.value = country.alpha2Code.toLowerCase();
                    option.text = country.name;
                    countrySelect.add(option);
                });
            })
            .catch(error => console.error("Error fetching countries:", error));

        function validateForm() {
            var email = document.getElementById('email').value;
            var name = document.getElementById('name').value;
            var country = document.getElementById('country').value;
            var address = document.getElementById('address').value;
            var postal = document.getElementById('postal').value;
            var phone = document.getElementById('phone').value;

            var emailError = document.getElementById('emailError');
            var nameError = document.getElementById('nameError');
            var countryError = document.getElementById('countryError');
            var addressError = document.getElementById('addressError');
            var postalError = document.getElementById('postalError');
            var phoneError = document.getElementById('phoneError');

            emailError.innerHTML = '';
            nameError.innerHTML = '';
            countryError.innerHTML = '';
            addressError.innerHTML = '';
            postalError.innerHTML = '';
            phoneError.innerHTML = '';

            var isValid = true;

            if (email === '' || !/^\S+@\S+\.\S+$/.test(email)) {
                emailError.innerHTML = 'Please enter a valid email address';
                isValid = false;
            }

            if (name === '') {
                nameError.innerHTML = 'Please enter your name';
                isValid = false;
            } else if (!/^[a-zA-Z\s]+$/.test(name)) {
                nameError.innerHTML = 'Name must contain only letters';
                isValid = false;
            }

            // if (country === '') {
            //     countryError.innerHTML = 'Please select your country';
            //     isValid = false;
            // }

            if (address === '') {
                addressError.innerHTML = 'Please enter your address';
                isValid = false;
            }

            if (postal === '') {
                postalError.innerHTML = 'Please enter your postal/zip code';
                isValid = false;
            } else if (country === 'your_country_code' && !/^\d{6}$/.test(postal)) {
                postalError.innerHTML = 'Postal code must be 6 digits for your country';
                isValid = false;
            }

            if (phone === '') {
                phoneError.innerHTML = 'Please enter your phone number';
                isValid = false;
            } else if (!/^\d{1,10}$/.test(phone)) {
                phoneError.innerHTML = 'Phone number must be numeric and not more than 10 digits';
                isValid = false;
            }

            return isValid;
        }

        function placeOrder() {

            document.getElementById('khaltiForm').querySelector('[name="email"]').value = document.getElementById('email').value;
            document.getElementById('khaltiForm').querySelector('[name="name"]').value = document.getElementById('name').value;
            document.getElementById('khaltiForm').querySelector('[name="phone"]').value = document.getElementById('phone').value;
            document.getElementById('grandTotal').value = '<?php echo $grandTotal; ?>';
            
            var radioButtons = document.querySelectorAll('input[name="radio"]');
            var radioError = document.getElementById('radioError');

            radioError.innerHTML = '';

            var isRadioValid = Array.from(radioButtons).some(button => button.checked);

            if (!isRadioValid) {
                radioError.innerHTML = 'Please select a payment method';
            }

            if (validateForm() && isRadioValid) {
                if (document.getElementById('radio1').checked) {
                    clearFormFieldAndRedirect();
                } else if (document.getElementById('radio3').checked) {
                    clearFormFieldAndRedirectKhalti();
                }
            }



            function clearFormFieldAndRedirect() {
                document.getElementById('email').value = '';
                document.getElementById('name').value = '';
                document.getElementById('country').value = '';
                document.getElementById('address').value = '';
                document.getElementById('postal').value = '';
                document.getElementById('phone').value = '';
                document.querySelectorAll('input[name="radio"]').forEach(button => {
                    button.checked = false;
                });
                window.location.href = 'thankyou.php';
            }


            function clearFormFieldAndRedirectKhalti() {
                document.getElementById('email').value = '';
                document.getElementById('name').value = '';
                document.getElementById('country').value = '';
                document.getElementById('address').value = '';
                document.getElementById('postal').value = '';
                document.getElementById('phone').value = '';
                document.querySelectorAll('input[name="radio"]').forEach(button => {
                    button.checked = false;
                });
                window.location.href = 'khaltiPayment.php';
            }

            document.getElementById('khaltiForm').submit();
        }

    </script>
</body>

</html>