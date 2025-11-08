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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Supplies</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="nav1 col-md-2">
                <ul class="nav-menu">
                    <li><a href="#">Dashboard</a></li>
                    <li><a href="#">Inventory</a></li>
                    <li><a href="#">Supplies</a></li>
                    <li><a href="#">Orders</a></li>
                    <li><a href="#">Manage Suppliers</a></li>
                    <li><a href="#">Logout</a></li>
                </ul>
            </div>
            <div class="col-md-10" id="content-main">
                <div class="p-4 m-4" id="content-second">
                    <div>
                        <?php if ($message): ?>
                            <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
                                <?php echo $message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="align-self-center">Manage Supplies</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplyModal">Add Supply</button>
                        </div>

                        <!-- Supplies Table -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
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
                                        <td><?php echo htmlspecialchars($supply->quantity); ?></td>
                                        <td><?php echo htmlspecialchars($supply->supplier_name); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editSupplyModal-<?php echo $supply->supply_id; ?>">Edit</button>
                                            <form method="POST" action="deleteSupply.php" onsubmit="return confirm('Are you sure you want to delete this supply?');" class="d-inline">
                                                <input type="hidden" name="s_id" value="<?php echo $supply->supply_id; ?>">
                                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Add Supply Modal -->
                        <div class="modal fade" id="addSupplyModal" tabindex="-1" aria-labelledby="addSupplyModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="addSupplyModalLabel">Add Supply</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="addSupply.php">
                                            <div class="mb-3">
                                                <label for="itemid" class="form-label">Supply Name</label>
                                                <select class="form-select" id="supply-name" name="itemid" required>
                                                    <option value="" disabled selected>Select Supply</option>
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
                                            <button type="submit" class="btn btn-primary">Add Supply</button>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                                                    <label for="edit-supply-name-<?php echo $supply->supply_id; ?>" class="form-label">Supply Name</label>
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
                                                        <?php foreach ($suppliers as $supplier): ?>
                                                            <option value="<?php echo htmlspecialchars($supplier->id); ?>" <?php echo $supply->supplierid == $supplier->id ? 'selected' : ''; ?>><?php echo htmlspecialchars($supplier->name); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybBogGzOgA2+c/GxS6ur2lHf3o0BZiF6p+Vu5p6L6ZZ65p8v2" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-p2o2ZWFobC5J2tt6qi3UqftTy3lIMcEZllp4rFViDaTf1z7Fwhp9uLVtZg2OO5Gx" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoBmwAhcR7ejno4t82f5AfJZ02z0R7P5SEf4RSOCoPsm3mo" crossorigin="anonymous"></script>
</body>
</html>
