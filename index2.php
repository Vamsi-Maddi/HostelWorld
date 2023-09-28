<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $sname = $_POST["sname"];
    $sno = $_POST["sno"];
    $smail = $_POST["smail"];
    $sgender = $_POST["sgender"];
    $sbranch = $_POST["sbranch"];
    $syear = $_POST["syear"];
    $ssem = $_POST["ssem"];
    $smobile = $_POST["smobile"];

    // Database connection details
    $servername = "your_mysql_servername";
    $username = "your_mysql_username";
    $password = "your_mysql_password";
    $dbname = "your_mysql_database";

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to insert data into the table
    $sql = "INSERT INTO students (name, reg_no, email, gender, branch, year, semester, mobile)
            VALUES ('$sname', '$sno', '$smail', '$sgender', '$sbranch', '$syear', '$ssem', '$smobile')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Data has been successfully stored in the database.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
