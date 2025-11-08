<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Supplies</title>
    <link rel="stylesheet" href="../utils/supplies.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
    require '../DbConnector.php';

    $dbcon = new DbConnector();
    $conn = $dbcon->getConnection();

    // Fetch suppliers from the database
    $querySuppliers = "SELECT * FROM suppliers";
    $stmtSuppliers = $conn->query($querySuppliers);
    $suppliers = $stmtSuppliers->fetchAll(PDO::FETCH_OBJ);

    // Fetch supplies from the database
    $querySupplies = "
            SELECT supplies.*, suppliers.name AS supplier_name, item.itemname AS item_name 
            FROM supplies 
            INNER JOIN suppliers ON supplies.supplierid = suppliers.id 
            INNER JOIN item ON supplies.itemid = item.itemid
        ";

    $stmtSupplies = $conn->query($querySupplies);
    $supplies = $stmtSupplies->fetchAll(PDO::FETCH_OBJ);

    // Fetch items from the database
    $queryItems = "SELECT * FROM item";
    $stmtItems = $conn->query($queryItems);
    $items = $stmtItems->fetchAll(PDO::FETCH_OBJ);

    // Handle status messages
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $message = '';
    $alertClass = '';

    switch ($status) {
        case 'success_add':
            $message = 'Supply added successfully!';
            $alertClass = 'alert-success';
            break;
        case 'success_edit':
            $message = 'Supply edited successfully!';
            $alertClass = 'alert-success';
            break;
        case 'success_delete':
            $message = 'Supply deleted successfully!';
            $alertClass = 'alert-danger';
            break;
        case 'error':
            $message = 'An error occurred. Please try again.';
            $alertClass = 'alert-danger';
            break;
        default:
            $message = '';
            $alertClass = '';
    }
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
                <li><a href="../inventory/inventory.php"><i class="fas fa-box-open"></i> Inventory</a></li>
                <li><a href="suppliers.php" class="active"><i class="fas fa-truck"></i> Suppliers</a></li>
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
                    <input type="text" placeholder="Search supplies, items, suppliers...">
                </div>
                <div class="user-info">
                    <div class="user-avatar">JD</div>
                    <div>
                        <div class="user-name">John Doe</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- Supplies Content -->
            <div class="supplies-content">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Manage Supplies</h1>
                        <p class="page-description">Track and manage your supply orders and inventory</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplyModal">
                        <i class="fas fa-plus me-2"></i>Add New Supply
                    </button>
                </div>

                <?php if ($message): ?>
                    <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
                        <i class="fas <?php echo $alertClass == 'alert-success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> me-2"></i>
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Supplies Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Supplier</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($supplies as $supply): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($supply->supply_id); ?></td>
                                        <td><?php echo htmlspecialchars($supply->item_name); ?></td>
                                        <td><span class="badge bg-primary"><?php echo htmlspecialchars($supply->quantity); ?></span></td>
                                        <td><?php echo htmlspecialchars($supply->supplier_name); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editSupplyModal-<?php echo $supply->supply_id; ?>">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </button>
                                                <form method="POST" action="deleteSupply.php" onsubmit="return confirm('Are you sure you want to delete this supply?');" class="d-inline">
                                                    <input type="hidden" name="s_id" value="<?php echo $supply->supply_id; ?>">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Add Supply Modal -->
                <div class="modal fade" id="addSupplyModal" tabindex="-1" aria-labelledby="addSupplyModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addSupplyModalLabel">Add New Supply</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="addSupply.php">
                                    <div class="mb-3">
                                        <label for="itemid" class="form-label">Item Name</label>
                                        <select class="form-select" id="supply-name" name="itemid" required>
                                            <option value="" disabled selected>Select Item</option>
                                            <?php foreach ($items as $item): ?>
                                                <option value="<?php echo htmlspecialchars($item->itemid); ?>"><?php echo htmlspecialchars($item->itemname); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="supply-quantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="supply-quantity" name="supply-quantity" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="supply-supplier" class="form-label">Supplier</label>
                                        <select class="form-select" id="supply-supplier" name="supply-supplier" required>
                                            <option value="" disabled selected>Select Supplier</option>
                                            <?php foreach ($suppliers as $supplier): ?>
                                                <option value="<?php echo htmlspecialchars($supplier->id); ?>"><?php echo htmlspecialchars($supplier->name); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Add Supply</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Supply Modals -->
                <?php foreach ($supplies as $supply): ?>
                    <div class="modal fade" id="editSupplyModal-<?php echo $supply->supply_id; ?>" tabindex="-1" aria-labelledby="editSupplyModalLabel-<?php echo $supply->supply_id; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editSupplyModalLabel-<?php echo $supply->supply_id; ?>">Edit Supply</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="editSupply.php">
                                        <input type="hidden" name="supply-id" value="<?php echo $supply->supply_id; ?>">
                                        <div class="mb-3">
                                            <label for="edit-supply-name-<?php echo $supply->supply_id; ?>" class="form-label">Item Name</label>
                                            <select class="form-select" id="edit-supply-name-<?php echo $supply->supply_id; ?>" name="itemid" required>
                                                <?php foreach ($items as $item): ?>
                                                    <option value="<?php echo htmlspecialchars($item->itemid); ?>" <?php echo $supply->itemid == $item->itemid ? 'selected' : ''; ?>><?php echo htmlspecialchars($item->itemname); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-supply-quantity-<?php echo $supply->supply_id; ?>" class="form-label">Quantity</label>
                                            <input type="number" class="form-control" id="edit-supply-quantity-<?php echo $supply->supply_id; ?>" name="supply-quantity" value="<?php echo htmlspecialchars($supply->quantity); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-supply-supplier-<?php echo $supply->supply_id; ?>" class="form-label">Supplier</label>
                                            <select class="form-select" id="edit-supply-supplier-<?php echo $supply->supply_id; ?>" name="supply-supplier" required>
                                                <?php foreach ($suppliers as $supplier_item): ?>
                                                    <option value="<?php echo htmlspecialchars($supplier_item->id); ?>" <?php echo $supply->supplierid == $supplier_item->id ? 'selected' : ''; ?>><?php echo htmlspecialchars($supplier_item->name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set active navigation item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage || (currentPage === 'suppliers.php' && href.includes('suppliers'))) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>