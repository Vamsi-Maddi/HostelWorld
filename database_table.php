<?php
// Database connection parameters
$servername = "localhost"; // Change this if your database is hosted on a different server
$username = "username";
$password = "password";

// Create a connection to MySQL server
$conn = new mysqli($servername, $username, $password);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a new database
$dbname = "hostel_website";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the created database
$conn->select_db($dbname);

// Create a table
$sql = "CREATE TABLE IF NOT EXISTS student_details (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    reg_no VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    branch VARCHAR(50) NOT NULL,
    year INT(4) NOT NULL,
    semester INT(1) NOT NULL,
    mobile VARCHAR(20) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'student_details' created successfully.<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Close the database connection
$conn->close();
?>
