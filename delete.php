<?php
require_once "config.php";
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Prepare a delete statement
    $sql = "DELETE FROM people WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    $my_option=$_GET['id'];
    if(empty($my_option)){
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
    <title>Delete Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body{ font-family: Arial, Helvetica, sans-serif; }
        .wrapper{ width: 600px; margin: 0 auto; }
        </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Delete Record</h2>
                    </div>
                    <p>Are you sure you want to delete this record?</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <input type="submit" value="Yes" class="btn btn-danger">
                        <a href="index.php" class="btn btn-default">No</a>
                    </form>
                </div>        
            </div>        
        </div>
    </div>
</body>
</html>