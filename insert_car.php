<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Insert Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3>Add New Car</h3>

<form method="POST" class="row g-3 my-4">
    <div class="col-md-4">
        <input type="text" name="make" class="form-control" placeholder="Car Model" required>
    </div>
    <div class="col-md-3">
        <input type="number" name="year" class="form-control" placeholder="Year" required>
    </div>
    <div class="col-md-3">
        <input type="number" name="price" class="form-control" placeholder="Price" required>
    </div>
    <div class="col-md-2">
        <button type="submit" name="add" class="btn btn-dark w-100">Insert</button>
    </div>
</form>

<?php
if (isset($_POST['add'])) {

    $conn = new mysqli("localhost", "root", "", "auto_trade_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $make = $_POST['make'];
    $year = $_POST['year'];
    $price = $_POST['price'];

    $sql = "INSERT INTO cars (make_model, year, price_omr) VALUES ('$make', '$year', '$price')";

    if ($conn->query($sql) === TRUE) {

        // ✅ Class
        class Car {
            public $model;
            public $year;
            public $price;

            function __construct($model, $year, $price) {
                $this->model = $model;
                $this->year = $year;
                $this->price = $price;
            }
        }

        // ✅ Array of objects
        $cars = [];
        $cars[] = new Car($make, $year, $price);

        // ✅ Function
        function displayCars($cars) {
            echo "<h4>Inserted Car</h4>";
            echo "<table class='table table-bordered'>";
            echo "<tr><th>Model</th><th>Year</th><th>Price</th></tr>";

            foreach ($cars as $c) {
                echo "<tr>
                        <td>{$c->model}</td>
                        <td>{$c->year}</td>
                        <td>{$c->price}</td>
                      </tr>";
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