<?php
// Initialize variables to hold form data and error messages
$name = $regNo = $email = $date = $fromTime = $toTime = $blockNumber = $roomNumber = $mentorApproval = $placeOfVisit = $purposeOfVisit = "";
$nameErr = $regNoErr = $emailErr = $dateErr = $fromTimeErr = $toTimeErr = $blockNumberErr = $roomNumberErr = $mentorApprovalErr = $placeOfVisitErr = $purposeOfVisitErr = "";

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

    // Validate Date
    if (empty($_POST["sdate"])) {
        $dateErr = "Date is required";
    } else {
        $date = test_input($_POST["sdate"]);
    }

    // Validate From-Time
    if (empty($_POST["sfrom"])) {
        $fromTimeErr = "From-Time is required";
    } else {
        $fromTime = test_input($_POST["sfrom"]);
    }

    // Validate To-Time
    if (empty($_POST["sto"])) {
        $toTimeErr = "To-Time is required";
    } else {
        $toTime = test_input($_POST["sto"]);
    }

    // Validate Block Number
    if (empty($_POST["sblock"])) {
        $blockNumberErr = "Block Number is required";
    } else {
        $blockNumber = test_input($_POST["sblock"]);
    }

    // Validate Room Number
    if (empty($_POST["sroom"])) {
        $roomNumberErr = "Room Number is required";
    } else {
        $roomNumber = test_input($_POST["sroom"]);
    }

    // Validate Mentor Approval
    if (empty($_POST["smentor"])) {
        $mentorApprovalErr = "Mentor Approval is required";
    } else {
        $mentorApproval = test_input($_POST["smentor"]);
    }

    // Validate Place of Visit
    if (empty($_POST["splace"])) {
        $placeOfVisitErr = "Place of Visit is required";
    } else {
        $placeOfVisit = test_input($_POST["splace"]);
    }

    // Validate Purpose of Visit
    if (empty($_POST["spurpose"])) {
        $purposeOfVisitErr = "Purpose of Visit is required";
    } else {
        $purposeOfVisit = test_input($_POST["spurpose"]);
    }

    // If all fields are valid, insert data into the database
    if (empty($nameErr) && empty($regNoErr) && empty($emailErr) && empty($dateErr) && empty($fromTimeErr) && empty($toTimeErr) && empty($blockNumberErr) && empty($roomNumberErr) && empty($mentorApprovalErr) && empty($placeOfVisitErr) && empty($purposeOfVisitErr)) {
        // Replace 'your_username' and 'your_password' with your actual MySQL credentials
        $conn = mysqli_connect("localhost", "root", "", "hostel_website");
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Sanitize and escape data before inserting into the database
        $name = mysqli_real_escape_string($conn, $name);
        $regNo = mysqli_real_escape_string($conn, $regNo);
        $email = mysqli_real_escape_string($conn, $email);
        $date = mysqli_real_escape_string($conn, $date);
        $fromTime = mysqli_real_escape_string($conn, $fromTime);
        $toTime = mysqli_real_escape_string($conn, $toTime);
        $blockNumber = mysqli_real_escape_string($conn, $blockNumber);
        $roomNumber = mysqli_real_escape_string($conn, $roomNumber);
        $mentorApproval = mysqli_real_escape_string($conn, $mentorApproval);
        $placeOfVisit = mysqli_real_escape_string($conn, $placeOfVisit);
        $purposeOfVisit = mysqli_real_escape_string($conn, $purposeOfVisit);

        // Create the SQL query to insert data into the table
        $sql = "INSERT INTO leave_form (name, regNo, email, date, fromTime, toTime, blockNumber, roomNumber, mentorApproval, placeOfVisit, purposeOfVisit)
                VALUES ('$name', '$regNo', '$email', '$date', '$fromTime', '$toTime', '$blockNumber', '$roomNumber', '$mentorApproval', '$placeOfVisit', '$purposeOfVisit')";

        if (mysqli_query($conn, $sql)) {
            echo "<p id='result'>Outing form submitted successfully. Thank you!</p>";
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
<title>Leave Form</title>
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

    .input-group {
        flex: 1;
        display: flex;
        align-items: center;
    }

    .input-group .form-control {
        margin-right: 5px;
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
            <img src="leave.jpg" class="img-fluid" alt="Image">
            <p>
                Write some content here about the form, explaining what it is for and any other relevant details.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="form-container">
                <h1>Leave Form</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group horizontal">
                        <label for="sname">Name:</label>
                        <input type="text" name="sname" id="sname" class="form-control" placeholder="Enter your Name here">
                        <span class="text-danger"><?php echo $nameErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="sno">Registration Number:</label>
                        <input type="text" name="sno" id="sno" class="form-control" placeholder="Enter your Registration Number here">
                        <span class="text-danger"><?php echo $regNoErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="smail">E-Mail:</label>
                        <input type="email" name="smail" id="smail" class="form-control" placeholder="Enter your E-Mail">
                        <span class="text-danger"><?php echo $emailErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label>From Date:</label>
                        <div class="input-group">
                            <input type="date" name="sdate" id="sdate" class="form-control">
                            <span style="padding: 0 5px;">To</span>
                            <input type="date" name="edate" id="edate" class="form-control">
                        </div>
                        <span class="text-danger"><?php echo $dateErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label>From Time:</label>
                        <div class="input-group">
                            <input type="time" name="sfrom" id="sfrom" class="form-control">
                            <span style="padding: 0 5px;">To</span>
                            <input type="time" name="sto" id="sto" class="form-control">
                        </div>
                        <span class="text-danger"><?php echo $fromTimeErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="sblock">Block Number:</label>
                        <input type="text" name="sblock" id="sblock" class="form-control" placeholder="Enter Block Number">
                        <span class="text-danger"><?php echo $blockNumberErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="sroom">Room Number:</label>
                        <input type="text" name="sroom" id="sroom" class="form-control" placeholder="Enter Room Number">
                        <span class="text-danger"><?php echo $roomNumberErr; ?></span>
                    </div>
                    <div class="form-group horizontal select">
                        <label for="smentor">Mentor Approval:</label>
                        <select name="smentor" id="smentor" class="form-control">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                        <span class="text-danger"><?php echo $mentorApprovalErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="splace">Place of Visit:</label>
                        <input type="text" name="splace" id="splace" class="form-control" placeholder="Enter Place of Visit">
                        <span class="text-danger"><?php echo $placeOfVisitErr; ?></span>
                    </div>
                    <div class="form-group horizontal">
                        <label for="spurpose">Purpose of Visit:</label>
                        <input type="text" name="spurpose" id="spurpose" class="form-control" placeholder="Enter Purpose of Visit">
                        <span class="text-danger"><?php echo $purposeOfVisitErr; ?></span>
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
