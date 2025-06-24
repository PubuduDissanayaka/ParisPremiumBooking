<?php
$name       = htmlspecialchars($_POST['name']);
$phone      = htmlspecialchars($_POST['phone']);
$email      = htmlspecialchars($_POST['email']);
$pickup     = htmlspecialchars($_POST['pickup']);
$drop       = htmlspecialchars($_POST['drop']);
$passengers = htmlspecialchars($_POST['passengers']);
$luggages   = htmlspecialchars($_POST['luggages']);
$date       = htmlspecialchars($_POST['date']);
$time       = htmlspecialchars($_POST['time']);
$return     = isset($_POST['return']) ? 'Yes' : 'No';
$messageText = htmlspecialchars($_POST['message']);


$priceTable = [
  "DISNEY-CDG" => [80, 100, 110],
  "DISNEY-ORLY" => [80, 100, 110],
  "DISNEY-PARIS" => [90, 110, 120],
  "DISNEY-BEAUVAIS" => [155, 170, 180],
  "PARIS-CDG" => [80, 100, 110],
  "PARIS-ORLY" => [80, 100, 110],
  "PARIS-DISNEY" => [90, 110, 120],
  "PARIS-BEAUVAIS" => [165, 180, 190],
  "PARIS-GARS" => [55, 70, 75],
  "PARIS-VERSAILLES" => [75, 90, 90],
  "CDG-PARIS" => [65, 70, 80],
  "CDG-ORLY" => [80, 85, 90],
  "CDG-DISNEY" => [65, 70, 80],
  "CDG-La Défense" => [60, 65, 70],
  "ORLY-PARIS" => [65, 70, 80],
  "ORLY-DISNEY" => [70, 80, 90],
  "BEAUVAIS-PARIS" => [120, 130, 140],
  "BEAUVAIS-DISNEY" => [125, 135, 145],
  "VERSAILLES-PARIS" => [65, 65, 75]
];

$routeKey = "$pickup-$drop";
$price = "N/A";
if (isset($priceTable[$routeKey])) {
  if ($passengers <= 3) $price = $priceTable[$routeKey][0];
  elseif ($passengers <= 6) $price = $priceTable[$routeKey][1];
  else $price = $priceTable[$routeKey][2];
  if ($return === 'Yes') $price *= 2;
}

$to = "info@parispremiumshuttle.com";
$subject = "New Shuttle Booking from $name";
$headers = "From: info@parispremiumshuttle.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Cc: $email\r\n";
$headers .= "Bcc: snishantha2002@yahoo.fr\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

$message = "
<html><body>
  <h2>New Booking Received</h2>
  <table cellpadding='8' border='1' style='border-collapse:collapse;'>
    <tr><th align='left'>Name</th><td>$name</td></tr>
    <tr><th align='left'>Phone</th><td>$phone</td></tr>
    <tr><th align='left'>Email</th><td>$email</td></tr>
    <tr><th align='left'>Pickup</th><td>$pickup</td></tr>
    <tr><th align='left'>Drop</th><td>$drop</td></tr>
    <tr><th align='left'>Passengers</th><td>$passengers</td></tr>
    <tr><th align='left'>Luggages</th><td>$luggages</td></tr>
    <tr><th align='left'>Date</th><td>$date</td></tr>
    <tr><th align='left'>Time</th><td>$time</td></tr>
    <tr><th align='left'>Return Transfer</th><td>$return</td></tr>
    <tr><th align='left'>Message</th><td>" . nl2br($messageText) . "</td></tr>
    <tr><th align='left'>Total Price</th><td>€$price</td></tr>
  </table>
</body></html>
";

$success = mail($to, $subject, $message, $headers);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Booking Status</title>
  <style>
    body {
      font-family: Arial;
      background: #f7f7f7;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .status-box {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
      text-align: center;
      max-width: 400px;
    }
    .success {
      color: #2e7d32;
      font-size: 20px;
    }
    .error {
      color: #c62828;
      font-size: 20px;
    }
    a {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      color: #007bff;
    }
  </style>
</head>
<body>
  <div class="status-box">
    <?php if ($success): ?>
      <div class="success">✅ Your booking was sent successfully!</div>
    <?php else: ?>
      <div class="error">❌ Failed to send your booking. Please try again.</div>
    <?php endif; ?>
    <a href="index.html">← Back to Booking</a>
  </div>
</body>
</html>
