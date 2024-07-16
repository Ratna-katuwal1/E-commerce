<?php
session_start();
include('connection.php');

if (!isset($_SESSION['email'])){
    // $_SESSION['error'] = "";
    header('Location: ./adminLogin.php');
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM admin_login WHERE email='$email'";
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
    $_SESSION['fullname'] = $userData['fullname'];
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
    $name = $_POST['fullname'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];

    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;

    if($userId) {
    $updateQuery = "UPDATE admin_login SET fullname='$name', address='$address', email='$email', gender='$gender', contact='$contact' WHERE id='$userId'";
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
            $updateImageQuery = "UPDATE admin_login SET profile_Image='$targetFile' WHERE id='$userId'";
            $resultImage = mysqli_query($conn, $updateImageQuery);

            if (!$resultImage) {
                // Handle error
                echo "Error updating profile image: " . mysqli_error($conn);
        } else {
            $_SESSION['fullname'] = $name;
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
header('Location: account.php');
    exit();

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin Details</title>
    <link rel="stylesheet" href="adminDetailUpdate.css" />
    <link rel="icon" href="./Images/logo1.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/9a11afd28c.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Update Admin Details</h2>
        </header>

        <main>
            <form action="adminDetailUpdate.php" method="post" enctype="multipart/form-data">
                <div class="profile-section">
                    <label for="profileImage">Profile Image:</label>
                    <input type="file" id="profileImage" name="profileImage" accept="image/*">
                </div>

                <div class="details-section">
                    <label for="fullname">Full Name:</label>
                    <input type="text" id="fullname" name="fullname" value="">

                    <label for="contact">Contact:</label>
                    <input type="tel" id="contact" name="contact" value="">

                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" value="">

                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" value="">

                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender">
                        <option value="" name="gender" selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="btn">
                    <button type="submit" name="submit">Update Details</button>
                </div>
            </form>
        </main>
    </div>
</body>
</html>
