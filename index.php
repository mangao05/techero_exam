<?php
    session_start();

    include 'db_connect.php';

    if(!isset($_SESSION['is_logged_in']) && !$_SESSION['is_logged_in']) {
        header("Location: authenticate.php");
    }
   
    $sql = "SELECT country, SUM(amount) as total_amount FROM histories ";

    if(!isset($_GET['date_from'])) {
        $sql .= " WHERE MONTH(datetime) = ". date('n') ." AND YEAR(datetime) = ". date('Y') ."";
    }

    if(isset($_GET['date_from']) && isset($_GET['date_to'])) {
        $from = $_GET['date_from'];
        $to = $_GET['date_to'];
        $sql .= " WHERE datetime BETWEEN '$from' AND '$to'";
    }

    $sql .= " AND active = 1 GROUP BY country ORDER BY total_amount DESC";

    $result = $conn->query($sql);
    $histories = [];
    
    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
           $histories[] = $row;
        }            

    } 

    $conn->close();


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Histories</title>
  </head>
  <body>
    <div class="container">
        <div>
            <h1 class="float-left">Welcome, <?= $_SESSION['username'] ?></h1> 
            <a href="logout.php" class="btn btn-danger float-right">Logout</a>
        </div><br><br>
        <br>
        <form action="index.php" method="GET">
            <div class="row mb-2">
                <div class="col-5">
                    <label for="dateFrom">Date From:</label>
                    <input type="date" class="form-control" name="date_from" id="dateFrom" value="<?= isset($_GET['date_from']) ? $_GET['date_from'] : '' ?>">
                </div>
                <div class="col-5">
                    <label for="dateTo">Date To:</label>
                    <input type="date" class="form-control" name="date_to" id="dateTo" value="<?= isset($_GET['date_to']) ? $_GET['date_to'] : '' ?>">
                </div>
                <div class="col-2">
                    <label for="">&nbsp;</label>
                    <input type="submit" class="btn btn-success btn-block" value="Submit">
                </div>
            </div>
        </form>
        <?php if(isset($_GET['date_from']) || isset($_GET['date_to'])) :?>
        <div class="row">
            <a href="/index.php" class="btn btn-info">Clear filters</a>
        </div>

        <?php endif; ?>

        <div>
            <table class="table table-striped table-hover text-center">
                <thead>
                    <tr>
                        <th>Country</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($histories) < 1): ?>
                        <tr>
                            <td colspan="2" class="text-center">No data found...</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($histories as $history) : ?>
                            <tr>
                                <td><?= $history['country'] ?></td>
                                <td><?= number_format($history['total_amount'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                   
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>
</html>