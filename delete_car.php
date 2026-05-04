<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3>Delete Car</h3>

<form method="POST" class="row g-3 my-4">
    <div class="col-md-4">
        <input type="number" name="id" class="form-control" placeholder="Car ID" required>
    </div>
    <div class="col-md-2">
        <button type="submit" name="delete" class="btn btn-danger w-100">Delete</button>
    </div>
</form>

<?php
if (isset($_POST['delete'])) {

    $conn = new mysqli("localhost", "root", "", "auto_trade_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];

    $sql = "DELETE FROM cars WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {

        // Class
        class Car {
            public $id;
            function __construct($id) {
                $this->id = $id;
            }
        }

        $cars = [];
        $cars[] = new Car($id);

        function displayCars($cars) {
            echo "<h4>Deleted Record</h4>";
            echo "<table class='table table-bordered'>";
            echo "<tr><th>Deleted ID</th></tr>";

            foreach ($cars as $c) {
                echo "<tr><td>{$c->id}</td></tr>";
            }

            echo "</table>";
        }

        displayCars($cars);

    } else {
        echo "<p class='text-danger'>Error: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>

</body>
</html>