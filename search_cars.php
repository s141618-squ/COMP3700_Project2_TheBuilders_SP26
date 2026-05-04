<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3>Search Car Inventory</h3>

<form method="GET" class="row g-3 my-4">
    <div class="col-md-4">
        <input type="text" name="model" class="form-control" placeholder="Car Model">
    </div>
    <div class="col-md-3">
        <input type="number" name="min_p" class="form-control" placeholder="Min Price">
    </div>
    <div class="col-md-3">
        <input type="number" name="max_p" class="form-control" placeholder="Max Price">
    </div>
    <div class="col-md-2">
        <button type="submit" name="s" class="btn btn-dark w-100">Search</button>
    </div>
</form>

<?php
if (isset($_GET['s'])) {

    try {
        $db = new PDO('mysql:host=localhost;dbname=auto_trade_db', 'root', '');

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

        $m = "%" . ($_GET['model'] ?? '') . "%";
        $min = $_GET['min_p'] ?: 0;
        $max = $_GET['max_p'] ?: 999999;

        $st = $db->prepare("SELECT * FROM cars WHERE make_model LIKE ? AND price_omr BETWEEN ? AND ?");
        $st->execute([$m, $min, $max]);

        $cars = [];

        while ($r = $st->fetch()) {
            $cars[] = new Car($r['make_model'], $r['year'], $r['price_omr']);
        }

        function displayCars($cars) {
            echo "<table class='table table-bordered'>";
            echo "<tr><th>Model</th><th>Year</th><th>Price</th></tr>";

            foreach ($cars as $c) {
                echo "<tr>
                        <td>{$c->model}</td>
                        <td>{$c->year}</td>
                        <td>" . number_format($c->price,3) . "</td>
                      </tr>";
            }

            echo "</table>";
        }

        displayCars($cars);

    } catch (Exception $e) {
        echo "Database Error.";
    }
}
?>

</body>
</html>