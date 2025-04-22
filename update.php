<?php
require_once "config.php";
//Define variables and initialize with empty values
$name = $address = $marks = "";
$name_err = $address_err = $marks_err = "";
// Processing form data when form is submitted
if(isset($_POST["id"])&& !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"]; 
    // Validate name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } else{
        $name = trim($_POST["name"]);
    }
    
    // Validate address
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter an address.";     
    } else{
        $address = trim($_POST["address"]);
    }
    
    // Validate marks
    if(empty(trim($_POST["marks"]))){
        $marks_err = "Please enter the marks.";     
    } elseif(!ctype_digit(trim($_POST["marks"]))){
        $marks_err = "Please enter a positive integer value.";
    } else{
        $marks = trim($_POST["marks"]);
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($address_err) && empty($marks_err)){
        // Prepare an insert statement
        $sql = "UPDATE people SET name=?, address=?, marks=? WHERE id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssii", $param_name, $param_address, $param_marks, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_marks = $marks;
            $param_id = $_POST["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    $my_option=$_GET['id'];
    if(!empty($my_option)){
        //Get URL parameter
        $id=trim($_GET['id']);

        // Prepare a select statement
        $sql = "SELECT * FROM people WHERE id = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = trim($_GET["id"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
                
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $address = $row["address"];
                    $marks = $row["marks"];
                } else{
                    // URL doesn't contain valid id parameter. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    } else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Record</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <style>
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2>Update Record</h2>
            <p>Please edit the input values and submit to update the record.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                    <span class="help-block"><?php echo $name_err;?></span>
                </div>
                <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                    <span class="help-block"><?php echo $address_err;?></span>
                </div>
                <div class="form-group  <?php echo (!empty($marks_err)) ? 'has-error' : ''; ?>">
                    <label>Marks</label>
                    <input type="text" name="marks" class="form-control" value="<?php echo $marks; ?>">
                    <span class="help-block"><?php echo $marks_err;?></span>
                </div>
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <input type="submit" class="btn btn-primary" value="Submit">
                <a href="index.php" class="btn btn-default">Cancel</a>
            </form>
        </div>
    </body>
    </html>

