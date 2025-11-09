<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management</title>
    <link rel="stylesheet" href="../utils/inventory.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
    require '../DbConnector.php';

    $dbcon = new DbConnector();
    $con = $dbcon->getConnection();
    ?>
    
    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-boxes"></i>
                <h3>InventoryPro</h3>
            </div>
            <ul class="nav-menu">
                <li><a href="../index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="inventory.php" class="active"><i class="fas fa-box-open"></i> Inventory</a></li>
                <li><a href="../supplier/suppliers.php"><i class="fas fa-truck"></i> Suppliers</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="../store/stores.php"><i class="fas fa-store"></i> Manage Store</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search inventory, orders, suppliers...">
                </div>
                <div class="user-info">
                    <div class="user-avatar">JD</div>
                    <div>
                    <div class="user-name">Lahiru lk</div>
                    <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- Inventory Content -->
            <div class="inventory-content">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Inventory Management</h1>
                        <p class="page-description">Manage your product inventory, stock levels, and availability</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fas fa-plus me-2"></i>Add New Item
                    </button>
                </div>

                <!-- Search Section -->
                <div class="search-section">
                    <div class="search-row">
                        <div class="search-input">
                            <form action="" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" value="<?php
                                    if (isset($_GET['search'])) {
                                        echo $_GET['search'];
                                    }
                                    ?>" class="form-control" placeholder="Search by product name, category, or ID...">
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-search me-2"></i>Search
                                    </button>                                       
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
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
                                            echo "<td><span class='badge bg-light text-dark'>" . $item->category . "</span></td>";
                                            echo "<td>$" . $item->unitprice . "</td>";

                                            $status = $item->availability;
                                            if ($status == "Low Stock") {
                                                echo "<td><span class='status-badge status-low-stock'>" . $item->availability . "</span></td></tr>";
                                            } else if ($status == "In Stock") {
                                                echo "<td><span class='status-badge status-in-stock'>" . $item->availability . "</span></td></tr>";
                                            } else if ($status == "Out of Stock") {
                                                echo "<td><span class='status-badge status-out-of-stock'>" . $item->availability . "</span></td></tr>";
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
                                            echo "<td><span class='badge bg-light text-dark'>" . $item->category . "</span></td>";
                                            echo "<td>$" . $item->unitprice . "</td>";

                                            $status = $item->availability;
                                            if ($status == "Low Stock") {
                                                echo "<td><span class='status-badge status-low-stock'>" . $item->availability . "</span></td></tr>";
                                            } else if ($status == "In Stock") {
                                                echo "<td><span class='status-badge status-in-stock'>" . $item->availability . "</span></td></tr>";
                                            } else if ($status == "Out of Stock") {
                                                echo "<td><span class='status-badge status-out-of-stock'>" . $item->availability . "</span></td></tr>";
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
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3" method="POST" action="additem_processs.php">
                        <div class="col-md-4">
                            <?php
                            $query = "SELECT itemid FROM item ORDER BY itemid DESC LIMIT 1";
                            $stmt = $con->prepare($query);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_OBJ);
                            $nextItemId = $row->itemid + 1;
                            ?>
                            <label for="itemid" class="form-label">Item ID</label>
                            <input type="text" class="form-control" name="itemid" value="<?php echo $nextItemId; ?>" readonly>
                        </div>
                        <div class="col-md-8">
                            <label for="itemname" class="form-label">Product Name</label>
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
                        <div class="col-6">
                            <label for="criticalvalue" class="form-label">
                                Critical Value 
                                <i class="fas fa-info-circle ms-1" data-bs-toggle="tooltip" title="This value sets a margin for low stock indication."></i>
                            </label>
                            <input type="text" class="form-control" name="criticalvalue" required>
                        </div>
                        <div class="col-md-6">
                            <label for="unitprice" class="form-label">Unit Price ($)</label>
                            <input type="text" class="form-control" name="unitprice" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" name="quantity" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Set active navigation item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>