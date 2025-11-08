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

// Get order statistics
$totalOrders   = count($rs3);
$today         = date('Y-m-d');
$todayOrders   = 0;
foreach ($rs3 as $order) {
    if ($order->orderdate == $today) {
        $todayOrders++;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Your custom CSS -->
    <link rel="stylesheet" href="../utils/order.css">
</head>

<body>
<div class="app-container">
    <!-- ====================== Sidebar ====================== -->
    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-boxes"></i>
            <h3>InventoryPro</h3>
        </div>
        <ul class="nav-menu">
            <li><a href="../index.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="../inventory/inventory.php"><i class="fas fa-box-open"></i> Inventory</a></li>
            <li><a href="../supplier/suppliers.php"><i class="fas fa-truck"></i> Suppliers</a></li>
            <li><a href="order.php" class="active"><i class="fas fa-shopping-cart"></i> Orders</a></li>
            <li><a href="../store/stores.php"><i class="fas fa-store"></i> Manage Store</a></li>
            <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- ====================== Main Content ====================== -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search orders, items, stores...">
            </div>
            <div class="user-info">
                <div class="user-avatar"><?php echo substr("LL", 0, 2); ?></div>
                <div>
                    <div class="user-name"><?php echo "Lahiru Lakshan"; ?></div>
                    <div class="user-role">Store Manager</div>
                </div>
            </div>
        </div>

        <!-- Orders Content -->
        <div class="orders-content">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Order Management</h1>
                    <p class="page-description">Manage and track all orders across your stores</p>
                </div>

                <!-- ==== Create New Order Button ==== -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="fas fa-plus me-2"></i>Create New Order
                </button>
            </div>

            <!-- Order Statistics -->
            <div class="order-stats">
                <div class="stat-card">
                    <div class="stat-label">Total Orders</div>
                    <div class="stat-value"><?php echo $totalOrders; ?></div>
                    <div class="stat-trend"><i class="fas fa-chart-line text-success me-1"></i>All time orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Today's Orders</div>
                    <div class="stat-value"><?php echo $todayOrders; ?></div>
                    <div class="stat-trend"><i class="fas fa-calendar-day text-primary me-1"></i>Orders today</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Active Items</div>
                    <div class="stat-value"><?php echo count($rs1); ?></div>
                    <div class="stat-trend"><i class="fas fa-box text-info me-1"></i>Available items</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Stores</div>
                    <div class="stat-value"><?php echo count($rs2); ?></div>
                    <div class="stat-trend"><i class="fas fa-store text-warning me-1"></i>Active stores</div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Store Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Order Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $query = "SELECT * FROM orders";
                        try {
                            $stmt = $con->query($query);
                            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                            foreach ($result as $item) {

                                // Item name
                                $sql1 = "SELECT itemname FROM item WHERE itemid = ?";
                                $pstmt1 = $con->prepare($sql1);
                                $pstmt1->bindParam(1, $item->itemid);
                                $pstmt1->execute();
                                $result1 = $pstmt1->fetch(PDO::FETCH_OBJ);

                                // Store name
                                $sql2 = "SELECT store_name FROM store WHERE store_id = ?";
                                $pstmt2 = $con->prepare($sql2);
                                $pstmt2->bindParam(1, $item->store_id);
                                $pstmt2->execute();
                                $result2 = $pstmt2->fetch(PDO::FETCH_OBJ);

                                // Username
                                $sql3 = "SELECT username FROM user WHERE userid = ?";
                                $pstmt3 = $con->prepare($sql3);
                                $pstmt3->bindParam(1, $item->userid);
                                $pstmt3->execute();
                                $result3 = $pstmt3->fetch(PDO::FETCH_OBJ);

                                // Status logic
                                $orderDate = new DateTime($item->orderdate);
                                $todayObj  = new DateTime();
                                $interval  = $todayObj->diff($orderDate);
                                $daysDiff  = $interval->days;

                                $status = $statusText = 'pending';
                                if ($daysDiff > 7) {
                                    $status = 'completed';
                                    $statusText = 'Completed';
                                } elseif ($daysDiff > 3) {
                                    $status = 'shipped';
                                    $statusText = 'Shipped';
                                }

                                echo "<tr>";
                                echo "<th scope='row'>#{$item->orderid}</th>";
                                echo "<td>{$result3->username}</td>";
                                echo "<td><strong>{$result1->itemname}</strong></td>";
                                echo "<td>{$result2->store_name}</td>";
                                echo "<td><span class='badge bg-primary'>{$item->quantity}</span></td>";
                                echo "<td>{$item->orderdate}</td>";
                                echo "<td><span class='status-badge status-{$status}'>{$statusText}</span></td>";
                                echo "</tr>";
                            }
                        } catch (Exception $ex) {
                            echo "<tr><td colspan='7' class='text-danger'>Error: " . htmlspecialchars($ex->getMessage()) . "</td></tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ====================== Add Order Modal ====================== -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Create New Order</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="POST" action="OrderAdd.php">
                    <?php
                    $query = "SELECT orderid FROM orders ORDER BY orderid DESC LIMIT 1";
                    $stmt  = $con->prepare($query);
                    $stmt->execute();
                    $row   = $stmt->fetch(PDO::FETCH_OBJ);
                    $nextOrderId = ($row) ? $row->orderid + 1 : 1;
                    ?>
                    <div class="col-md-4">
                        <label for="orderid" class="form-label">Order ID</label>
                        <input type="text" class="form-control" name="orderid"
                               value="<?php echo $nextOrderId; ?>" disabled>
                    </div>

                    <div class="col-md-8">
                        <label for="itemid" class="form-label">Item</label>
                        <select name="itemid" class="form-select" required>
                            <option value="" disabled selected>Select an item</option>
                            <?php foreach ($rs1 as $r1): ?>
                                <option value="<?php echo $r1->itemid; ?>">
                                    <?php echo $r1->itemid . ' - ' . $r1->itemname; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" required min="1">
                    </div>

                    <div class="col-md-8">
                        <label for="storeid" class="form-label">Store</label>
                        <select name="storeid" class="form-select" required>
                            <option value="" disabled selected>Select a store</option>
                            <?php foreach ($rs2 as $r2): ?>
                                <option value="<?php echo $r2->store_id; ?>">
                                    <?php echo $r2->store_id . ' - ' . $r2->store_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="orderdate" class="form-label">Order Date</label>
                        <input type="date" class="form-control" name="orderdate"
                               required value="<?php echo date('Y-m-d'); ?>">
                    </div>

                    <div class="col-12">
                        <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ====================== Bootstrap JS (must be BEFORE custom scripts) ====================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+Jj0vG3M6lT8k5q2jk7u5H1l3hi8"
        crossorigin="anonymous"></script>

<!-- ====================== Debug: Bootstrap loaded? ====================== -->
<script>
    if (typeof bootstrap === 'undefined') {
        alert('Bootstrap JS failed to load! Check network / CDN.');
    }
</script>

<!-- ====================== Custom JS ====================== -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set today’s date in the modal (fallback if PHP value is missing)
        const today = new Date().toISOString().split('T')[0];
        const dateInput = document.querySelector('input[name="orderdate"]');
        if (dateInput && !dateInput.value) {
            dateInput.value = today;
        }

        // Highlight active nav item (optional improvement)
        const current = location.pathname.split('/').pop();
        document.querySelectorAll('.nav-menu a').forEach(link => {
            const href = link.getAttribute('href').split('/').pop();
            link.classList.toggle('active', href === current || (current === 'order.php' && href.includes('order')));
        });
    });
</script>
</body>
</html>