<?php
session_start();

require '../DbConnector.php';


$dbcon = new DbConnector();
$con = $dbcon->getConnection();

$_SESSION['username'] = 'Ravindu';

$q1 = "SELECT * FROM item";
$s1 = $con->query($q1);
$rs1 = $s1->fetchAll(PDO::FETCH_OBJ);

$q2 = "SELECT * FROM store";
$s2 = $con->query($q2);
$rs2 = $s2->fetchAll(PDO::FETCH_OBJ);

$q3 = "SELECT * FROM orders";
$s3 = $con->query($q3);
$rs3 = $s3->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order</title>
        <link rel="stylesheet" href="../inventory.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>

        <div class="header"></div>
        <div class="container">
            <div class="navigation">
                <ul class="nav-menu">
                    <li><a href="../index.php">Dashboard</a></li>
                    <li><a href="../inventory.php">Inventory</a></li>
                    <li><a href="../Supplier/supplier.php">Supplies</a></li>
                    <li><a href="order.php">Orders</a></li>
                    <li><a href="../store/stores.php">Manage Store</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="content">
                <div class="products">
                    <h3>Orders</h3>
                    <div class="d-flex justify-content-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="addItems">
                            Add Orders
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Order an Item</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3 col-12" method="POST" action="OrderAdd.php">
                                        <div class="col-md-4">
                                            <?php
                                            $query = "SELECT orderid FROM orders ORDER BY orderid DESC LIMIT 1";
                                            $stmt = $con->prepare($query);
                                            $stmt->execute();
                                            $row = $stmt->fetch(PDO::FETCH_OBJ);
                                            $nextOrderId = $row->orderid + 1;
                                            ?>
                                            <label for="orderid" class="form-label">Order Id</label>
                                            <input type="text" class="form-control" name="orderid" value="<?php echo $nextOrderId; ?>" disabled>
                                        </div>


                                        <div class="col-md-8">
                                            <label for="itemid" class="form-label">Item</label>
                                            <select name="itemid" class="form-select" required>
                                                <?php
                                                foreach ($rs1 as $r1) {
                                                    echo '<option value="' . $r1->itemid . '">' . $r1->itemid . '   -   ' . $r1->itemname . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="text" class="form-control" name="quantity" required>
                                        </div>

                                        <div class="col-md-8">
                                            <label for="storeid" class="form-label">Store</label>
                                            <select name="storeid" class="form-select" required>
                                                <?php
                                                foreach ($rs2 as $r2) {
                                                    echo '<option value="' . $r2->store_id . '">' . $r2->store_id . '   -   ' . $r2->store_name . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="orderdate" class="form-label">Date</label>
                                            <input type="date" class="form-control" name="orderdate" required>
                                        </div>

                                        <div class="col-12" style="padding-bottom: 20px;">
                                            <input type="text" name="username" value="<?php echo $_SESSION['username'] ?>" hidden>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Done</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="operations">
                        
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Store Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query = "SELECT * FROM orders";
                                try {
                                    $stmt = $con->query($query);
                                    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($result as $item) {
                                        
                                        $sql1 = "SELECT itemname FROM item WHERE itemid = ?";
                                        $pstmt1 = $con->prepare($sql1);
                                        $pstmt1->bindParam(1, $item->itemid);
                                        $pstmt1->execute();
                                        $result1 = $pstmt1->fetch(PDO::FETCH_OBJ);
                                        
                                        $sql2 = "SELECT store_name FROM store WHERE store_id = ?";
                                        $pstmt2 = $con->prepare($sql2);
                                        $pstmt2->bindParam(1, $item->store_id);
                                        $pstmt2->execute();
                                        $result2 = $pstmt2->fetch(PDO::FETCH_OBJ);
                                        
                                        $sql3 = "SELECT username FROM user WHERE userid = ?";
                                        $pstmt3 = $con->prepare($sql3);
                                        $pstmt3->bindParam(1, $item->userid);
                                        $pstmt3->execute();
                                        $result3 = $pstmt3->fetch(PDO::FETCH_OBJ);
                                        
                                        echo "<tr><th scope='row'>" . $item->orderid . "</th>";
                                        echo "<td>" . $result3->username . "</td>";
                                        echo "<td>" . $result1->itemname . "</td>";
                                        echo "<td>" . $result2->store_name . "</td>";
                                        echo "<td>" . $item->quantity . "</td>";
                                        echo "<td>" . $item->orderdate . "</td>";
                                    }
                                } catch (Exception $ex) {
                                    die('Error: ' . $ex->getMessage());
                                }
                            
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>