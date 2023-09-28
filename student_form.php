<?php
// Initialize variables to hold form data and error messages
$name = $regNo = $email = $gender = $branch = $year = $semester = $roomType = $messType = "";
$nameErr = $regNoErr = $emailErr = $yearErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate Name
    if (empty($_POST["sname"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["sname"]);
        // Check if name contains only letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
    }

    // Validate Registration Number
    if (empty($_POST["sno"])) {
        $regNoErr = "Registration Number is required";
    } else {
        $regNo = test_input($_POST["sno"]);
        // Check if registration number is alphanumeric
        if (!preg_match("/^[a-zA-Z0-9]*$/", $regNo)) {
            $regNoErr = "Only letters and numbers allowed";
        }
    }

    // Validate Email
    if (empty($_POST["smail"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["smail"]);
        // Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    // Validate Year
    if (empty($_POST["syear"])) {
        $yearErr = "Year is required";
    } else {
        $year = test_input($_POST["syear"]);
        // Check if year is numeric and within range
        if (!preg_match("/^[0-9]{1,2}$/", $year) || $year < 1 || $year > 99) {
            $yearErr = "Invalid year";
        }
    }

    // If all fields are valid, insert data into the database
    if (empty($nameErr) && empty($regNoErr) && empty($emailErr) && empty($yearErr)) {
        // Replace 'your_username' and 'your_password' with your actual MySQL credentials
        $conn = mysqli_connect("localhost", "root", "", "hostel_website");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Sanitize and escape data before inserting into the database
        $name = mysqli_real_escape_string($conn, $name);
        $regNo = mysqli_real_escape_string($conn, $regNo);
        $email = mysqli_real_escape_string($conn, $email);
        $gender = mysqli_real_escape_string($conn, $_POST["sgender"]);
        $branch = mysqli_real_escape_string($conn, $_POST["sbranch"]);
        $semester = mysqli_real_escape_string($conn, $_POST["ssem"]);
        $roomType = mysqli_real_escape_string($conn, $_POST["sroom"]);
        $messType = mysqli_real_escape_string($conn, $_POST["smess"]);

        // Create the SQL query to insert data into the table
        $sql = "INSERT INTO student_enrollment (name, regNo, email, gender, branch, year, semester, roomType, messType)
                VALUES ('$name', '$regNo', '$email', '$gender', '$branch', '$year', '$semester', '$roomType', '$messType')";

        if (mysqli_query($conn, $sql)) {
            echo "<p id='result'>Registration successful. Thank you!</p>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
}

// Function to sanitize and validate user input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student Registration Form</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #e1bee7, #90caf9);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #444;
        margin-bottom: 20px;
    }

    .form-container {
        background-color: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group.horizontal {
        display: flex;
        align-items: center;
    }

    .form-group.horizontal label {
        width: 150px;
        padding-right: 10px;
        text-align: right;
        color: #444;
    }

    .form-control {
        flex: 1;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 8px;
    }

    .form-control:focus {
        outline: none;
        border-color: #666;
        box-shadow: 0 0 5px rgba(102, 102, 102, 0.5);
    }

    input[type="submit"] {
        background-color: #2980b9;
        color: white;
        font-weight: bold;
        width: 100%;
        padding: 12px 0;
        border: none;
        cursor: pointer;
        border-radius: 8px;
    }

    input[type="submit"]:hover {
        background-color: #154360;
    }

    #result {
        color: #27ae60;
    }

</style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-lg-6 d-none d-lg-block">
            <img src="college.jpg" class="img-fluid" alt="Image">
            <p>
                Complete our student enrollment form to secure a spot in our welcoming hostel. Enjoy a comfortable stay and a vibrant campus community.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="form-container">
                <h1>Student Registration Form</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group horizontal">
                        <label for="sname">Name:</label>
                        <input type="text" name="sname" id="sname" class="form-control" placeholder="Enter your Name here" value="<?php echo $name; ?>">
                        <span class="text-danger"><?php echo $nameErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="sno">Reg No:</label>
                        <input type="text" name="sno" id="sno" class="form-control" placeholder="Enter your Reg.No here" value="<?php echo $regNo; ?>">
                        <span class="text-danger"><?php echo $regNoErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="smail">Mail:</label>
                        <input type="email" name="smail" id="smail" class="form-control" placeholder="Enter your E-Mail" value="<?php echo $email; ?>">
                        <span class="text-danger"><?php echo $emailErr; ?></span>
                    </div>
                    <div class="form-group horizontal select">
                        <label for="sgender">Gender:</label>
                        <select name="sgender" id="sgender" class="form-control">
                            <option value="Male" <?php if ($gender == "Male") echo "selected"; ?>>Male</option>
                            <option value="Female" <?php if ($gender == "Female") echo "selected"; ?>>Female</option>
                        </select>
                    </div>
                    <div class="form-group horizontal">
                        <label for="sbranch">Branch:</label>
                        <select name="sbranch" id="sbranch" class="form-control">
                            <option value="CSE" <?php if ($branch == "CSE") echo "selected"; ?>>Computer Science</option>
                            <option value="IT" <?php if ($branch == "IT") echo "selected"; ?>>Information Technology</option>
                            <option value="ECE" <?php if ($branch == "ECE") echo "selected"; ?>>Electronics and Communication Engineering</option>
                            <option value="EEE" <?php if ($branch == "EEE") echo "selected"; ?>>Electrical and Electronics Engineering</option>
                        </select>
                    </div>
                    <div class="form-group horizontal">
                        <label for="syear">Year:</label>
                        <input type="text" name="syear" id="syear" class="form-control" value="<?php echo $year; ?>">
                        <span class="text-danger"><?php echo $yearErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="ssem">Semester:</label>
                        <select name="ssem" id="ssem" class="form-control">
                            <option value="1" <?php if ($semester == "1") echo "selected"; ?>>1st Semester</option>
                            <option value="2" <?php if ($semester == "2") echo "selected"; ?>>2nd Semester</option>
                            <option value="3" <?php if ($semester == "3") echo "selected"; ?>>3rd Semester</option>
                            <option value="4" <?php if ($semester == "4") echo "selected"; ?>>4th Semester</option>
                            <option value="5" <?php if ($semester == "5") echo "selected"; ?>>5th Semester</option>
                            <option value="6" <?php if ($semester == "6") echo "selected"; ?>>6th Semester</option>
                            <option value="7" <?php if ($semester == "7") echo "selected"; ?>>7th Semester</option>
                            <option value="8" <?php if ($semester == "8") echo "selected"; ?>>8th Semester</option>
                        </select>
                    </div>
                    <div class="form-group horizontal select">
                        <label for="sroom">Room Type:</label>
                        <select name="sroom" id="sroom" class="form-control">
                            <option value="two_bedroom" <?php if ($roomType == "two_bedroom") echo "selected"; ?>>Two Bedroom</option>
                            <option value="four_bedroom" <?php if ($roomType == "four_bedroom") echo "selected"; ?>>Four Bedroom</option>
                            <option value="apartment" <?php if ($roomType == "apartment") echo "selected"; ?>>Apartment Type</option>
                            <option value="dormitory" <?php if ($roomType == "dormitory") echo "selected"; ?>>Dormitory</option>
                        </select>
                    </div>
                    <div class="form-group horizontal select">
                        <label for="smess">Mess Type:</label>
                        <select name="smess" id="smess" class="form-control">
                            <option value="veg" <?php if ($messType == "veg") echo "selected"; ?>>Veg</option>
                            <option value="non_veg" <?php if ($messType == "non_veg") echo "selected"; ?>>Non-Veg</option>
                            <option value="special" <?php if ($messType == "special") echo "selected"; ?>>Special</option>
                        </select>
                    </div>
                    <div class="form-group horizontal submit">
                        <input type="submit" value="Submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
