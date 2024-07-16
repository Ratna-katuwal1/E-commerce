<?php
session_start();

include("connection.php");

if (isset($_POST['submit'])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $errors = [];

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    }

    if (empty($errors)) {
        $email_search = "SELECT * FROM admin_login WHERE email='$email'";
        $query = mysqli_query($conn, $email_search);

        if ($query) {
            $email_pass = mysqli_fetch_assoc($query);

            if ($email_pass) {
                $db_pass = $email_pass['password'];

                if ($password == $db_pass) {
                    $_SESSION['username'] = $email_pass['name'];
                    $_SESSION['email'] = $email_pass['email'];
                    $_SESSION['address'] = $email_pass['address'];
                    $_SESSION['gender'] = $email_pass['gender'];
                    $_SESSION['contact'] = $email_pass['contact'];
                   header("Location: ./dashboard.php");
                   exit();
                } else {
                    echo '<script>alert("Incorrect Password")</script>';
                }
            } else {
                echo '<script>alert("Invalid Email")</script>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SHOPLUXE - Ladies Shopping Store</title>
        <link rel="icon" href="./Images/logo1.png" type="image/x-icon">
        <link rel="stylesheet" href="./CustomerLogin.css">
    </head>

    <body>
        <section>
            <div class="form-box">
                <div class="form-value">
                    <form id="myform" method="POST" action="#" name="signin_form">
                        <h2>Admin Login</h2>
                        <div class="inputbox">
                            <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" autocomplete="off">
                            <span id="emailError" class="error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
                            <label for="email">E-mail</label>
                        </div>

                        <div class="inputbox">
                        <ion-icon name="eye" id="togglePassword"></ion-icon>
                            <input type="password" id="password" name="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" autocomplete="off">
                            <span id="passwordError" class="error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
                            <label for="password">Password</label>
                        </div>

                        <div class="checkbox">
                            <label for="remember-checkbox">
                                <input type="checkbox" id="remember-checkbox">
                                Remember me
                            </label>
                        </div>

                        <div class="forget">
                        <a href="forgetPassword.php">Forget Password</a>
                    </div>

                        <button type="submit" name="submit">Login</button>
                    </form>
                </div>
            </div>
        </section>
        <script>
                     const passwordInput = document.getElementById("password");
    const togglePasswordIcon = document.getElementById("togglePassword");

    togglePasswordIcon.style.display = "none";
    passwordInput.addEventListener("input", function () {
        if (passwordInput.value.length > 0) {
            togglePasswordIcon.style.display = "inline";
        } else {
            togglePasswordIcon.style.display = "none";
        }
    });

    togglePasswordIcon.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePasswordIcon.setAttribute("name", "eye-off");
        } else {
            passwordInput.type = "password";
            togglePasswordIcon.setAttribute("name", "eye");
        }
    });
            
    function validateForm(event) {
    event.preventDefault();

    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value;

    var errorMessages = [];

    if (email === "") {
        errorMessages.push("Email is required");
        document.getElementById("emailError").textContent = "Email is required";
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        errorMessages.push("Invalid email address");
        document.getElementById("emailError").textContent = "Invalid email format";
    } else {
        document.getElementById("emailError").textContent = "";
    }

    if (password === "") {
        errorMessages.push("Password is required");
        document.getElementById("passwordError").textContent = "Password is required";
    } else if (password.length < 8) {
        errorMessages.push("Password must be at least 8 characters");
        document.getElementById("passwordError").textContent = "Password must be at least 8 characters";
    } else {
        document.getElementById("passwordError").textContent = "";
    }
}
        </script>
        <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" type="module"></script>
        <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" nomodule></script>
    </body>

</html>