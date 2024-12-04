<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location:vehical-details.php');
    exit();
}

// Retrieve booking details from form submission
$fromDate = $_POST['fromdate'];
$toDate = $_POST['todate'];
$message = $_POST['message'];
$vehicleId = $_POST['vehicle_id'];
$pricePerDay = $_POST['price_per_day'];
$brandName = $_POST['brand_name'];
$vehicleTitle = $_POST['vehicle_title'];

// Calculate the total booking amount (you can adjust this calculation as needed)
$date1 = new DateTime($fromDate);
$date2 = new DateTime($toDate);
$days = $date2->diff($date1)->days + 1;  // Adding 1 to include the last day
$totalAmount = $days * $pricePerDay;

// Store amount in session to use it later during payment process
$_SESSION['amount'] = $totalAmount;
?>

<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bank Payment</title>
    <link href="css/bank.css" rel="stylesheet" type="text/css"/>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #mainContainer {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 400px;
        }

        .text-center h2 {
            margin: 0;
            color: #333;
        }

        .divider {
            margin: 20px 0;
            border-top: 1px solid #eaeaea;
        }

        .mercDetails dt {
            font-weight: bold;
            color: #555;
        }

        .mercDetails dd {
            margin: 0 0 10px 0;
            color: #333;
        }

        .page2 {
            margin-top: 20px;
        }

        .form-heading {
            font-size: 18px;
            color: #333;
        }

        .form-subheading {
            font-size: 14px;
            color: #777;
        }

        .formInputSection {
            margin-top: 15px;
        }

        .form-control {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }

        .button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #4cae4c;
        }

        .request-link {
            color: #337ab7;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .tryAgain {
            display: inline-block;
            margin-top: 20px;
            color: #d9534f;
        }

        .tryAgain a {
            text-decoration: none;
            color: #d9534f;
        }
    </style>
</head>
<body>

<div id="mainContainer">
    <div class="text-center"><h2>BANK PAYMENT</h2></div>
    <hr class="divider">
    <dl class="mercDetails">
        <dt>Merchant</dt><dd>Bike Rental</dd>
        <dt>Transaction Amount</dt><dd>INR <?php echo $_SESSION['amount']; ?></dd>
        <dt>Vehicle</dt><dd><?php echo $brandName . ' ' . $vehicleTitle; ?></dd>
    </dl>
    <hr class="divider">
    
    <form name="form1" id="form1" method="post" action="complete_payment.php">
        <fieldset class="page2">
            <div class="page-heading">
                <h6 class="form-heading">Authenticate Payment</h6>
                <p class="form-subheading">OTP sent to your mobile number ending with <strong>1343</strong></p>
            </div>

            <div class="row formInputSection">
                <div class="large-12 columns">
                    <label>
                        Enter One Time Password (OTP)
                        <input type="tel" name="otp" class="form-control optPass" value="" maxlength="6" autocomplete="off"/>
                    </label>
                </div>
            </div>

            <div class="row formInputSection">
                <div class="large-12 columns">
                    <button type="button" class="button next" onClick="ValidateForm()">Make Payment</button>
                </div>
            </div>

            <div class="text-right resendBtn requestOTP">
                <a class="request-link" href="javascript:void(0)">Resend OTP</a>
            </div>
            <p class="tryAgain"><a class="tryAgain" href="vehical-details.php?vhid=<?php echo $vehicleId; ?>">Go back</a> to merchant</p>
        </fieldset>
    </form>
</div>

<script>
    function ValidateForm() { 
        var regPin = RegExp("^[0-9]{4,6}$");
        if (document.form1.otp.value == "" || !document.form1.otp.value.match(regPin)) {     
            alert("Please enter a valid 6 digit One Time Password (OTP) received on your registered Mobile Number."); 
            document.form1.otp.focus(); 
            return false;  
        } else {
            document.form1.submit();
        }
    }
</script>
</body>
</html>
