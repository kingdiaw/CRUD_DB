<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "config.php";

// Define variables and initialize with empty values
$name = $address = $marks = "";
$name_err = $address_err = $marks_err = "";

// Processing form data when form is submitted  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)) {
        $name_err = "Please enter a name.";
    } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } elseif (!filter_var($input_address, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $address_err = "Please enter a valid address.";
    } else {
        $address = $input_address;
    }

    // Validate marks
    $input_marks = trim($_POST["marks"]);
    if (empty($input_marks)) {
        $marks_err = "Please enter the marks.";
    } elseif (!ctype_digit($input_marks)) {
        $marks_err = "Please enter a positive integer value.";
    } else {
        $marks = $input_marks;
    }

    // Check input errors before inserting in database
    if (empty($name_err) && empty($address_err) && empty($marks_err)) {
        $sql = "INSERT INTO people (name, address, marks) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_address, $param_marks);

            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_marks = $marks;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                header("location: index.php");
                exit();
            } else {
                echo "Something went wrong while executing. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Failed to prepare SQL statement: " . mysqli_error($conn);
        }
    }

    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create Record</h2>
                </div>
                <p>Please fill this form to create a record.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                        <span class="help-block"><?php echo $address_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($marks_err)) ? 'has-error' : ''; ?>">
                        <label>Marks</label>
                        <input type="text" name="marks" class="form-control" value="<?php echo $marks; ?>">
                        <span class="help-block"><?php echo $marks_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
