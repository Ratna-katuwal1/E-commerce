<?php
session_start();
include('connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'] . '/mis_project/Project-1/ProjectCode/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mis_project/Project-1/ProjectCode/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/mis_project/Project-1/ProjectCode/src/SMTP.php';

$emailError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = isset($_POST['email']) ? $_POST['email'] : '';

    if (empty($email)) {
        $emailError = 'Please enter your email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Invalid email format.';
    } else {
        $userExists = checkUserExists($email);

    if ($userExists) {
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        sendOTPByEmail($email, $otp);
        echo '<script>alert("OTP sent successfully");</script>';
        header('location: otp.php');
        exit;
    } else {
        echo '<script>alert("User not found. Please check your email address.");</script>';
    }
}
}

function checkUserExists($email)
{
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM customer_register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

function generateOTP()
{
    // Generate a random 6-digit OTP
    return rand(100000, 999999);
}

function sendOTPByEmail($email, $otp)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'p1147193@gmail.com';               // SMTP username
        $mail->Password = 'rwpvcafzgnqusdfa';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom($email, 'person');
        $mail->addAddress($email);                                  // Add a recipient

        // Content
        $mail->isHTML(true);                                        // Set email format to HTML
        $mail->Subject = 'OTP Verification';
        $mail->Body = "Your OTP is: $otp";

        $mail->send();
        echo 'OTP sent successfully';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPLUXE - Ladies Shopping Store</title>
    <link rel="stylesheet" href="forgetPassword.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="image">
                <img src="./Images/forgot.png" alt="img">
            </div>
            <div class="forget-form">
                <h2>Forgot <br> Your Password?</h2>
                <form action="" method="post" onsubmit="return validateForm()">
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Enter Your E-mail" class="form-control" autocomplete="off">
                    <span id="emailError" class="error"></span>
                    <div class="row ">
                        <div class="reset">
                            <button type="submit">Reset Password</button>
                        </div>
                        <div class="back">
                            <a href="customerLogin.php">Back To Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
       function validateForm() {
            var email = document.getElementById('email').value;
            var emailError = document.getElementById('emailError');

            if (email === "") {
                emailError.textContent = "Please enter your email.";
                emailError.style.color = "red";
                return false;
            }

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                emailError.textContent = "Invalid email format.";
                emailError.style.color = "red";
                return false;
            }

            emailError.textContent = ""; // Clear previous error messages
            return true;
        }
    </script>
</body>

</html>