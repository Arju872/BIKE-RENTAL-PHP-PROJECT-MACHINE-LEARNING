<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location:vehical-details.php');
    exit();
}

// Check if form was submitted and OTP was provided
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredOtp = $_POST['otp'];

    // Assuming OTP is 123456 for demo purposes (you should replace this with the actual OTP system)
    $expectedOtp = "123456"; // This should be dynamically generated and sent to the user's phone in a real system

    if ($enteredOtp === $expectedOtp) {
        // OTP matches - process the booking
        $_SESSION['booking_success'] = "Booking successful!";
    } else {
        // Invalid OTP
        $_SESSION['error'] = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Validation</title>
    <script>
        window.onload = function() {
            <?php if (isset($_SESSION['booking_success'])) { ?>
                alert("<?php echo $_SESSION['booking_success']; ?>");
                window.location.href = "index.php"; // Redirect after success message
            <?php unset($_SESSION['booking_success']); } ?>

            <?php if (isset($_SESSION['error'])) { ?>
                alert("<?php echo $_SESSION['error']; ?>");
                window.location.href = "index.php"; // Redirect to vehicle-listing.php after error message
            <?php unset($_SESSION['error']); } ?>
        };
    </script>
</head>
<body>
    <form method="POST" action="">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <button type="submit">Submit OTP</button>
    </form>
</body>
</html>
