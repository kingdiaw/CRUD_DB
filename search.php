<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style type="text/css">
        .wrapper {
            width: 600px;
            margin: 0 auto;
            margin-top: 40px;
        }
        p {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Search by Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Search</button>
        </form>
        <br>

        <?php
        if (isset($_POST['submit'])) {
            if (preg_match("/^[A-Za-z0-9 ]+$/", $_POST['name'])) {
                $name = $_POST['name'];
                $conn = mysqli_connect("localhost", "root", "", "crud_db");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM people WHERE name LIKE '%$name%'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    echo "<table class='table table-bordered table-striped table-hover'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>Name</th>";
                    echo "<th>Address</th>";
                    echo "<th>Marks</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['marks'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p>No results found.</p>";
                }

                mysqli_close($conn);
            } else {
                echo "<p>Please enter a valid search query (letters and numbers only).</p>";
            }

            echo "<p><a href='index.php' class='btn btn-primary'>Back</a></p>";
        }
        ?>
    </div>
</body>
</html>
