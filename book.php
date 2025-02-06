<?php
// Database connection
$host = 'localhost';
$user = 'root'; // Change if necessary
$password = ''; // Change if necessary
$db = 'clean';

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $session_date = $conn->real_escape_string($_POST['session_date']);
    $session_time = $conn->real_escape_string($_POST['session_time']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO bookings (name, email, phone, session_date, session_time, message) 
            VALUES ('$name', '$email', '$phone', '$session_date', '$session_time', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Booking successful! We'll contact you soon.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Session</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        form { background: #fff; padding: 20px; border-radius: 5px; max-width: 400px; margin: auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 4px; }
        button { background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
    
</head>
<body>

<h2>Book a Session</h2>
<form method="POST" action="">
    <label for="name">Full Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone">

    <label for="session_date">Avaliable Date:</label>
    <input type="date" id="session_date" name="session_date" required>

    <label for="session_time">Avaliable Time:</label>
    <input type="time" id="session_time" name="session_time" required>

    <label for="message">What type of cleaner you want (Optional):</label>
    <textarea id="message" name="message" rows="4"></textarea>

    <button type="submit">Book Now</button>
</form>

</body>
</html>
