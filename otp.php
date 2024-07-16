<?php
session_start();
include('connection.php');
$otpFields = ['otp1', 'otp2', 'otp3', 'otp4', 'otp5', 'otp6'];

if (!isset($_SESSION['otp']) || !isset($_SESSION['email'])) {
    header('Location: forgetPassword.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (issetAndNotEmpty($_POST, $otpFields) && validateOTPLength($_POST, $otpFields)) {
        $userEnteredOTP = $_POST['otp1'] . $_POST['otp2'] . $_POST['otp3'] . $_POST['otp4'] . $_POST['otp5'] . $_POST['otp6'];

        if ($userEnteredOTP == $_SESSION['otp']) {
            header('Location: changePassword.php');
            exit;
        } else {
            echo '<script>alert("Incorrect OTP. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Please enter the complete OTP.");</script>';
    }
}
function issetAndNotEmpty($array, $keys)
{
    foreach ($keys as $key) {
        if (!isset($array[$key]) || empty($array[$key])) {
            return false;
        }
    }
    return true;
}

function validateOTPLength($array, $keys)
{
    foreach ($keys as $key) {
        if (strlen($array[$key]) !== 1) {
            return false;
        }
    }
    return true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPLUXE - Ladies Shopping Store</title>
    <link rel="stylesheet" href="otp.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="image">
                <img src="./Images/otp.avif" alt="img">
            </div>
            <div class="forget-form">
                <h2>OTP Verification</h2>
                <p>Enter OTP Code send to your E-mail <span>
                        <?php echo $_SESSION['email']; ?>
                    </span></p>

                <form method="post" action="" id="otpForm" onsubmit="return validateForm()">
                    <div class="otp-container">
                        <div class="otp-input-container">
                            <input type="text" id="otp1" name="otp1" maxlength="1" autocomplete="off"
                                oninput="moveToNext(this, 'otp2')">
                            <input type="text" id="otp2" name="otp2" maxlength="1" autocomplete="off"
                                oninput="moveToNext(this, 'otp3')">
                            <input type="text" id="otp3" name="otp3" maxlength="1" autocomplete="off"
                                oninput="moveToNext(this, 'otp4')">
                            <input type="text" id="otp4" name="otp4" maxlength="1" autocomplete="off"
                                oninput="moveToNext(this, 'otp5')">
                            <input type="text" id="otp5" name="otp5" maxlength="1" autocomplete="off"
                                oninput="moveToNext(this, 'otp6')">
                            <input type="text" id="otp6" name="otp6" maxlength="1" autocomplete="off">
                        </div>
                        <button type="submit">Verify & Proceed</button>
                        <p class="resend-message">Did not receive the OTP? <a href="#" onclick="resendOTP()">Resend
                                it</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function moveToNext(currentInput, nextInputId) {
            if (currentInput.value.length === currentInput.maxLength) {
                document.getElementById(nextInputId).focus();
            }
        }

        function resendOTP() {
            alert("Resending OTP....");
        }

        function validateForm() {
            var otpFields = ['otp1', 'otp2', 'otp3', 'otp4', 'otp5', 'otp6'];
            var isValid = true;

            otpFields.forEach(function (field) {
                var input = document.getElementById(field);
                if (input.value.length !== input.maxLength) {
                    isValid = false;
                }
            });

            if (!isValid) {
                alert("Please enter the complete OTP.");
            }

            return isValid;
        }
    </script>
</body>

</html>