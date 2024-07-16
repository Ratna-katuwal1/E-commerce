<?php
session_start();
include('connection.php');

if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header('Location: forgetPassword.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = $_POST['newPasswordInput'];
    $confirmPassword = $_POST['confirmPasswordInput'];
    $email = $_SESSION['email'];

    if (empty($newPassword) || empty($confirmPassword)) {
        echo '<script>alert("Please enter both new password and confirm password.");</script>';
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo '<script>alert("New password and confirm password do not match. Please try again.");</script>';
        exit;
    }

    $updatePasswordQuery = "UPDATE customer_register SET password='$newPassword', cpassword='$confirmPassword' WHERE email='$email'";
    $result = mysqli_query($conn, $updatePasswordQuery);

    if ($result) {
    session_unset();
    session_destroy();
    header('Location: customerLogin.php');
    exit;
} else {
    echo '<script>alert("Failed to update password. Please try again.");</script>';
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPLUXE - Ladies Shopping Store</title>
    <link rel="stylesheet" href="changePassword.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="image">
                <img src="./Images/change-password.png" alt="img">
            </div>
            <div class="forget-form">
                <h2>Change Password</h2>
                <form action="" method="post">
                <label for="newPasswordInput">New Password:</label>
                <div class="password-input-container">
                        <input type="password" class="form-control" id="newPasswordInput" name="newPasswordInput" autocomplete="off">
                        <span class="password-toggle" onclick="togglePasswordVisibility('newPasswordInput')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>

                <label for="confirmPasswordInput">Confirm New Password:</label>
                <div class="password-input-container">
                        <input type="password" class="form-control" id="confirmPasswordInput" name="confirmPasswordInput" autocomplete="off">
                        <span class="password-toggle" onclick="togglePasswordVisibility('confirmPasswordInput')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                <div class="row ">
                    <div class="change">
                        <button type="submit">Change Password</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            var passwordInput = document.getElementById(inputId);
            var icon = passwordInput.nextElementSibling.querySelector('i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
</body>

</html>