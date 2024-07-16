<?php
session_start();
include("connection.php");

$errors = [];

if (isset($_POST['submit'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';

    if (empty($name) || !preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors['name'] = "Name is required";
    }

    if (empty($address)) {
        $errors['address'] = "Address is required";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email is required";
    }

    if (empty($contact) || !preg_match("/^\d{10}$/", $contact)) {
        $errors['contact'] = "Contact is required";
    }

    if (empty($gender)) {
        $errors['gender'] = "Gender should be selected.";
    }

    if (empty($password) || strlen($password) < 8) {
        $errors['password'] = "Password is required and must be at least 8 characters";
    }

    if (empty($cpassword) || $password !== $cpassword) {
        $errors['cpassword'] = "Passwords do not match.";
    }

    if (empty($errors)) {
        $check_sql = "SELECT email, contact FROM customer_register WHERE email='$email' or contact = '$contact'";
        $result_check = mysqli_query($conn, $check_sql);
        $row_count = mysqli_num_rows($result_check);

        if ($row_count == 0) {
            $user_sql = "INSERT INTO customer_register(id, name, address, email, contact, gender, password, cpassword) VALUES('','$name', '$address','$email','$contact','$gender','$password','$cpassword')";
            $result_user = mysqli_query($conn, $user_sql);

            if ($result_user) {
                echo '<script>alert("Registration successful")</script>';
                $_SESSION['name'] = $name;
                $_SESSION['image'] = $profileImage;
                $_SESSION['email'] = $email;
                $_SESSION['address'] = $address;
                $_SESSION['gender'] = $gender;
                $_SESSION['contact'] = $contact;

                $_SESSION['profileImage'] = $profileImageFolder;

                echo '<script>location.replace("./CustomerLogin.php");</script>';
            } else {
                echo '<script>alert("Error")</script>';
            }
        } else {
            echo '<script>alert("Email or Contact already exists.")</script>';
        }
    }
}
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SHOPLUXE - Ladies Shopping Store</title>
    <link rel="stylesheet" href="./CustomerRegister.css">
</head>

<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form id="myform" action="" method="POST" name="signup_form" onsubmit="return validateForm();">
                    <h2>Customer Register</h2>
                    <div class="inputbox">
                        <input type="text" id="name" name="name"
                            value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" autocomplete="off">
                        <span id="nameError" class="error">
                            <?php echo isset($errors['name']) ? $errors['name'] : ''; ?>
                        </span>
                        <label for="name">Name</label>
                    </div>

                    <div class="inputbox">
                        <input type="text" id="address" name="address"
                            value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>" autocomplete="off">
                        <span id="addressError" class="error">
                            <?php echo isset($errors['address']) ? $errors['address'] : ''; ?>
                        </span>
                        <label for="address">Address</label>
                    </div>

                    <div class="inputbox">
                        <input type="email" id="email" name="email"
                            value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" autocomplete="off">
                        <span id="emailError" class="error">
                            <?php echo isset($errors['email']) ? $errors['email'] : ''; ?>
                        </span>
                        <label for="email">E-mail</label>
                    </div>

                    <div class="inputbox">
                        <input type="text" id="contact" name="contact"
                            value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>" autocomplete="off">
                        <span id="contactError" class="error">
                            <?php echo isset($errors['contact']) ? $errors['contact'] : ''; ?>
                        </span>
                        <label for="phone">Contact</label>
                    </div>

                    <div class="inputbox">
                        <label for="gender" class="gender">Gender:</label>
                        <select id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <span id="genderError" class="error"><?php echo isset($errors['gender']) ? $errors['gender'] : ''; ?></span>
                    </div>

                    <div class="inputbox">
                        <ion-icon name="eye" id="togglePassword"></ion-icon>
                        <input type="password" id="password" name="password"
                            value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>"
                            autocomplete="off">
                        <span id="passwordError" class="error">
                            <?php echo isset($errors['password']) ? $errors['password'] : ''; ?>
                        </span>
                        <label for="password">Password</label>
                    </div>

                    <div class="inputbox">
                        <ion-icon name="eye" id="toggleCPassword"></ion-icon>
                        <input type="password" id="cpassword" name="cpassword"
                            value="<?php echo isset($_POST['cpassword']) ? $_POST['cpassword'] : ''; ?>"
                            autocomplete="off">
                        <span id="cpasswordError" class="error">
                            <?php echo isset($errors['cpassword']) ? $errors['cpassword'] : ''; ?>
                        </span>
                        <label for="cpassword">Confirm Password</label>
                    </div>

                    <button type="submit" name="submit">Register</button>
                    <div class="register">
                        <p>Already Registered <a href="./CustomerLogin.php">Login now</a></p>
                    </div>
                    <div class="error-container" id="error-container">
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        function handleLabel(label, input) {
            if (input.value !== '') {
                label.classList.add('active');
            } else {
                label.classList.remove('active');
            }
        }

        const inputFields = document.querySelectorAll('.inputbox input');
        inputFields.forEach(inputField => {
            const label = inputField.nextElementSibling;
            inputField.addEventListener('input', () => {
                handleLabel(label, inputField);
            });
            handleLabel(label, inputField);
        });

        const passwordInput = document.getElementById("password");
        const togglePasswordIcon = document.getElementById("togglePassword");

        const cpasswordInput = document.getElementById("cpassword");
        const toggleCPasswordIcon = document.getElementById("toggleCPassword");

        togglePasswordIcon.style.display = "none";
        toggleCPasswordIcon.style.display = "none";

        passwordInput.addEventListener("input", function () {
            if (passwordInput.value.length > 0) {
                togglePasswordIcon.style.display = "inline";
            } else {
                togglePasswordIcon.style.display = "none";
            }
        });

        cpasswordInput.addEventListener("input", function () {
            if (cpasswordInput.value.length > 0) {
                toggleCPasswordIcon.style.display = "inline";
            } else {
                toggleCPasswordIcon.style.display = "none";
            }
        });

        function togglePasswordVisibility(input, toggleIcon) {
            if (input.type === "password") {
                input.type = "text";
                toggleIcon.setAttribute("name", "eye-off");
            } else {
                input.type = "password";
                toggleIcon.setAttribute("name", "eye");
            }
        }

        togglePasswordIcon.addEventListener("click", function () {
            togglePasswordVisibility(passwordInput, togglePasswordIcon);
        });

        toggleCPasswordIcon.addEventListener("click", function () {
            togglePasswordVisibility(cpasswordInput, toggleCPasswordIcon);
        });

        function validateForm(event) {
            event.preventDefault();  // Prevent the form from submitting by default
            var name = document.getElementById('name').value.trim();
            var email = document.getElementById('email').value.trim();
            var contact = document.getElementById('contact').value.trim();
            var address = document.getElementById('address').value;
            var gender = document.getElementById('gender').value;
            var password = document.getElementById('password').value;
            var cpassword = document.getElementById("cpassword").value;

            var errorMessages = [];


            if (name === "") {
                errorMessages.push("Name is required");
                document.getElementById("nameError").textContent = "Name is required";
            } else if (!/^[a-zA-Z ]+$/.test(name)) {
                errorMessages.push("Name is required");
                document.getElementById("nameError").textContent = "Name should only contain letters and spaces";
            } else {
                document.getElementById("nameError").textContent = ""; // Clear error
            }

            if (email === "") {
                errorMessages.push("Email is required");
                document.getElementById("emailError").textContent = "Email is required";
            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                errorMessages.push("Invalid email address");
                document.getElementById("emailError").textContent = "Invalid email format";
            } else {
                document.getElementById("emailError").textContent = ""; // Clear error
            }

            if (contact === "") {
                errorMessages.push("Contact is required");
                document.getElementById("contactError").textContent = "Contact is required";
            } else if (!/^\d{10}$/.test(contact)) {
                errorMessages.push("Contact should be 10 digits.");
                document.getElementById("contactError").textContent = "Contact should be 10 digits";
            } 

            if (gender === "") {
                errorMessages.push("Gender is required");
                document.getElementById("genderError").textContent = "Please select a gender";
            } else {
                document.getElementById("genderError").textContent = ""; // Clear error
            }

            if (address === "") {
                errorMessages.push("address is required");
                document.getElementById("addressError").textContent = "Address is required";
            } else {
                document.getElementById("addressError").textContent = ""; // Clear error
            }

            if (password === "") {
                errorMessages.push("Password is required");
                document.getElementById("passwordError").textContent = "Password is required";
            } else if (password.length < 8) {
                errorMessages.push("Password must be at least 8 characters");
                document.getElementById("passwordError").textContent = "Password must be at least 8 characters";
            } else {
                document.getElementById("passwordError").textContent = ""; // Clear error
            }

            if (cpassword === "") {
                errorMessages.push("Confirm Password is required");
                document.getElementById("cpasswordError").textContent = "Confirm Password is required";
            } else if (password !== cpassword) {
                errorMessages.push("Passwords do not match");
                document.getElementById("cpasswordError").textContent = "Passwords do not match";
            } else {
                document.getElementById("cpasswordError").textContent = ""; // Clear error
            }

            var errorContainer = document.getElementById('error-container');
            errorContainer.innerHTML = "";

            if (errorMessages.length > 0) {
                var ul = document.createElement('ul');
                errorMessages.forEach(function (error) {
                    var li = document.createElement('li');
                    li.textContent = error;
                    ul.appendChild(li);
                });
                errorContainer.appendChild(ul);
            } else {
                document.getElementById('myform').submit();
            }
        }
    </script>
    <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js" type="module"></script>
    <script src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js" nomodule></script>
</body>

</html>