<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3>Update Car</h3>

<form method="POST" class="row g-3 my-4">
    <div class="col-md-2">
        <input type="number" name="id" class="form-control" placeholder="ID" required>
    </div>
    <div class="col-md-3">
        <input type="text" name="make" class="form-control" placeholder="Model" required>
    </div>
    <div class="col-md-2">
        <input type="number" name="year" class="form-control" placeholder="Year" required>
    </div>
    <div class="col-md-3">
        <input type="number" name="price" class="form-control" placeholder="Price" required>
    </div>
    <div class="col-md-2">
        <button type="submit" name="update" class="btn btn-warning w-100">Update</button>
    </div>
</form>

<?php
if (isset($_POST['update'])) {

    $conn = new mysqli("localhost", "root", "", "auto_trade_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];
    $make = $_POST['make'];
    $year = $_POST['year'];
    $price = $_POST['price'];

    $sql = "UPDATE cars SET make_model='$make', year='$year', price_omr='$price' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {

        class Car {
            public $id;
            public $model;
            public $year;
            public $price;

            function __construct($id, $model, $year, $price) {
                $this->id = $id;
                $this->model = $model;
                $this->year = $year;
                $this->price = $price;
            }
        }

        $cars = [];
        $cars[] = new Car($id, $make, $year, $price);

        function displayCars($cars) {
            echo "<h4>Updated Record</h4>";
            echo "<table class='table table-bordered'>";
            echo "<tr><th>ID</th><th>Model</th><th>Year</th><th>Price</th></tr>";

            foreach ($cars as $c) {
                echo "<tr>
                        <td>{$c->id}</td>
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