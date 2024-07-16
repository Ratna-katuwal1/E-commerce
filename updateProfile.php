<?php
session_start();

include('connection.php');
if (!isset($_SESSION['name'])) {
    header('Location: ./CustomerLogin.php');
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM customer_register WHERE email='$email'";
$result = mysqli_query($conn, $query);

if (!$result) {
    // Handle database query error
    echo "Error fetching user data: " . mysqli_error($conn);
    exit();
}

if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);

    // Set user data in the session
    $_SESSION['id'] = $userData['id'];
    $_SESSION['name'] = $userData['name'];
    $_SESSION['email'] = $userData['email'];
    $_SESSION['address'] = $userData['address'];
    $_SESSION['gender'] = $userData['gender'];
    $_SESSION['contact'] = $userData['contact'];
    $_SESSION['profile_Image'] = $userData['profile_Image'];
} else {
    // Handle database query error
    echo "Error: No user found with the provided email.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];

    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if($userId) {
    $updateQuery = "UPDATE customer_register SET name='$name', address='$address', email='$email', gender='$gender', contact='$contact' WHERE id='$userId'";
    $result = mysqli_query($conn, $updateQuery);

    if (!$result) {
        echo "Error updating profile: " . mysqli_error($conn);
    }

    if ($_FILES['profileImage']['error'] == 0) {
        $targetDir = "profile_Images/";
        $targetFile = $targetDir . basename($_FILES['profileImage']['name']);

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFile)) {
            // Update the database with the new profile image path
            $updateImageQuery = "UPDATE customer_register SET profile_Image='$targetFile' WHERE id='$userId'";
            $resultImage = mysqli_query($conn, $updateImageQuery);

            if (!$resultImage) {
                // Handle error
                echo "Error updating profile image: " . mysqli_error($conn);
        } else {
            $_SESSION['name'] = $name;
            $_SESSION['address'] = $address;
            $_SESSION['email'] = $email;
            $_SESSION['gender'] = $gender;
            $_SESSION['contact'] = $contact;
            $_SESSION['profile_Image'] = $targetFile;
        }
} else {
    // Handle missing user ID
    echo "Error moving uploaded file.";
}
    }
} else {
    echo "Error: User ID is missing.";
}
header('Location: ./profile.php');
    exit();

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShopLuxe - Ladies Clothing Shop</title>
    <link rel="stylesheet" href="./updateProfile.css" />
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

        <section class="update-profile">
            <h2>Update Profile</h2>
            <div class="update-profile-form">
                <form method="post" action="updateProfile.php" enctype="multipart/form-data">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" autocomplete="off">

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" autocomplete="off">

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" autocomplete="off">

                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" autocomplete="off">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>

                    <label for="contact">Contact:</label>
                    <input type="tel" id="contact" name="contact" autocomplete="off">

                    <label for="profileImage">Profile Image:</label>
                    <input type="file" id="profileImage" name="profileImage">
                    <button type="submit">Update Profile</button>
                </form>
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
</body>

</html>