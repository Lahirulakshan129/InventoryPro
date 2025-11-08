<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inventory</title>
        <link rel="stylesheet" href="inventory.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <?php
        require '../DbConnector.php';

        $dbcon = new DbConnector();
        $con = $dbcon->getConnection();
        ?>
        <div class="header"></div>
        <div class="container">
            <div class="navigation">
                <ul class="nav-menu">
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="inventory.php">Inventory</a></li>
                    <li><a href="supplier/suppliers.php">Supplies</a></li>
                    <li><a href="order/order.php">Orders</a></li>
                    <li><a href="store/stores.php">Manage Store</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
            <div class="content">
                <div class="products">
                    <h3>Products</h3>
                    <div class="d-flex justify-content-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="addItems">
                            Add Items
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add an Item</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form class="row g-3 col-12" method="POST" action="additem_processs.php">
                                        <div class="col-md-4">
                                            <?php
                                            $query = "SELECT itemid FROM item ORDER BY itemid DESC LIMIT 1";
                                            $stmt = $con->prepare($query);
                                            $stmt->execute();
                                            $row = $stmt->fetch(PDO::FETCH_OBJ);
                                            $nextItemId = $row->itemid + 1;
                                            ?>
                                            <label for="itemid" class="form-label">Item Id</label>
                                            <input type="text" class="form-control" name="itemid" value="<?php echo $nextItemId; ?>" disabled>
                                        </div>
                                <div class="col-md-8">
                                    <label for="itemname" class="form-label">Item Name</label>
                                    <input type="text" class="form-control" name="itemname" required>
                                </div>
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control" name="description" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="category" class="form-label">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option selected value="Accessories">Accessories</option>
                                        <option value="Footwear">Footwear</option>
                                        <option value="Stationary">Stationary</option>
                                        <option value="Foods and Beverages">Foods and Beverages</option>
                                        <option value="Grocery Items">Grocery Items</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <label for="criticalvalue" class="form-label"><a data-bs-toggle="tooltip" title="This value is set a margin for low stock indication.">Critical Value</a></label>
                                    <input type="text" class="form-control" name="criticalvalue" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="unitprice" class="form-label">Unit Price</label>
                                    <input type="text" class="form-control" name="unitprice" required>
                                </div>

                                <div class="col-md-5">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="text" class="form-control" name="quantity" required>
                                </div>
                                <div class="col-12" style="padding-bottom: 20px;">

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
                    <div class="row">
                        <div class="col-md-7">
                            <form action="" method="GET">
                                <div class="input-group mb-3 d-flex">
                                    <input type="text" name="search" value="<?php
                                    if (isset($_GET['search'])) {
                                        echo $_GET['search'];
                                    }
                                    ?>" class="form-control" placeholder="Search Here...">
                                    <button type="submit" class="btn btn-secondary">Search</button>                                       
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Index</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Category</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Availability</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET['search']) && !empty($_GET['search'])) {
                            $searched_values = $_GET['search'];
                            $query_searched = "SELECT * FROM item WHERE CONCAT(itemid, itemname, quantity, category, unitprice, availability) LIKE '%$searched_values%'";

                            try {
                                $stmt = $con->query($query_searched);
                                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                                $index =1;
                                foreach ($result as $item) {
                                    echo "<tr><th scope='row'>" .$index. "</th>";
                                    echo "<td>" . $item->itemname . "</td>";
                                    echo "<td>" . $item->description . "</td>";
                                    echo "<td>" . $item->quantity . "</td>";
                                    echo "<td>" . $item->category . "</td>";
                                    echo "<td>" . $item->unitprice . "</td>";

                                    $status = $item->availability;
                                    if ($status == "Low Stock") {
                                        echo "<td><p style='color:#cc7a00'>" . $item->availability . "</p></td></tr>";
                                    } else if ($status == "In Stock") {
                                        echo "<td><p style='color:green'>" . $item->availability . "</p></td></tr>";
                                    } else if ($status == "Out of Stock") {
                                        echo "<td><p style='color:red'>" . $item->availability . "</p></td></tr>";
                                    }
                                    
                                    $index++;
                                }
                            } catch (Exception $ex) {
                                die('Error: ' . $ex->getMessage());
                            }
                        } else {
                            // Display all items (similar to your initial code)
                            $query = "SELECT * FROM item";
                            try {
                                $stmt = $con->query($query);
                                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                                $index = 1;
                                foreach ($result as $item) {                                   
                                    echo "<tr><th scope='row'>" . $index . "</th>";
                                    echo "<td>" . $item->itemname . "</td>";
                                    echo "<td>" . $item->description . "</td>";
                                    echo "<td>" . $item->quantity . "</td>";
                                    echo "<td>" . $item->category . "</td>";
                                    echo "<td>" . $item->unitprice . "</td>";

                                    $status = $item->availability;
                                    if ($status == "Low Stock") {
                                        echo "<td><p style='color:#cc7a00'>" . $item->availability . "</p></td></tr>";
                                    } else if ($status == "In Stock") {
                                        echo "<td><p style='color:green'>" . $item->availability . "</p></td></tr>";
                                    } else if ($status == "Out of Stock") {
                                        echo "<td><p style='color:red'>" . $item->availability . "</p></td></tr>";
                                    }
                                    
                                    $index++;
                                }
                            } catch (Exception $ex) {
                                die('Error: ' . $ex->getMessage());
                            }
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