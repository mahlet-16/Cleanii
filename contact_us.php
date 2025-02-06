<?php 
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Log received data
    file_put_contents('php://stderr', "Received data - Name: $name, Email: $email, Subject: $subject, Message: $message\n");

    // Database connection 
    $servername = "localhost"; 
    $dbusername = "root"; 
    $dbpassword = ""; 
    $dbname = "clean"; 

    // Create connection 
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname); 

    // Check connection 
    if ($conn->connect_error) { 
        die("Connection failed: " . $conn->connect_error); 
    } 

    // Ensure the table structure is correct 
    $create_table_sql = "CREATE TABLE IF NOT EXISTS contact ( 
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(50) NOT NULL,
        subject VARCHAR(50) NOT NULL,
        message TEXT NOT NULL
    )"; 

    if ($conn->query($create_table_sql) === FALSE) { 
        die("Error creating table: " . $conn->error); 
    } 

    // Prepare statement 
    $stmt = $conn->prepare("INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)");
    if ($stmt === false) { 
        die("Prepare failed: " . $conn->error); 
    } 

    // Bind parameters
    $stmt->bind_param("ssss", $name, $email, $subject, $message); 

    // Execute statement 
    if ($stmt->execute()) { 
        echo "success"; 
    } else { 
        echo "Error: " . $stmt->error; 
    } 

    $stmt->close(); 
    $conn->close(); 
} 
?>
