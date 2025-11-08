<?php
require '../DbConnector.php';

$dbcon = new DbConnector();
$conn = $dbcon->getConnection();

// Fetch suppliers from the database
$query = "SELECT * FROM suppliers";
$stmt = $conn->query($query);
$suppliers = $stmt->fetchAll(PDO::FETCH_OBJ);

// Handle status messages
$status = isset($_GET['status']) ? $_GET['status'] : '';
$message = '';
$alertClass = '';

switch ($status) {
    case 'success_add':
        $message = 'Supplier added successfully!';
        $alertClass = 'alert-success';
        break;
    case 'success_edit':
        $message = 'Supplier edited successfully!';
        $alertClass = 'alert-success';
        break;
    case 'success_delete':
        $message = 'Supplier deleted successfully!';
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
        <title>Manage Suppliers</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>

        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="nav1 col-md-2" style="
                     height: auto;
                     ">
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
                                <h5 class="align-self-center">Manage Suppliers</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">Add Supplier</button>
                            </div>

                            <!-- Add Supplier Modal -->
                            <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="addSupplierModalLabel">Add Supplier</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="addSupplier.php">
                                                <div class="mb-3">
                                                    <label for="supplier-name" class="form-label">Supplier Name</label>
                                                    <input type="text" class="form-control" id="supplier-name" name="supplier-name" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="supplier-address" class="form-label">Address</label>
                                                    <input type="text" class="form-control" id="supplier-address" name="supplier-address" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="supplier-contact" class="form-label">Contact Number</label>
                                                    <input type="text" class="form-control" id="supplier-contact" name="supplier-contact" placeholder="0xxxxxxxxx">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="supplier-email" class="form-label">E-mail</label>
                                                    <input type="email" class="form-control" id="supplier-email" name="supplier-email" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="supplier-website" class="form-label">Website</label>
                                                    <input type="url" class="form-control" id="supplier-website" name="supplier-website">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Add Supplier</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php foreach ($suppliers as $supplier): ?>
                                <!-- Supplier Card -->
                                <div class="card mb-3 col-md-11 mx-auto">
                                    <div class="row g-0">
                                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                                            <div class="name-box">
                                                <?php
                                                // Display supplier initials
                                                $initials = '';
                                                $words = explode(' ', $supplier->name);
                                                foreach ($words as $word) {
                                                    $initials .= $word[0];
                                                }
                                                echo htmlspecialchars($initials);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <div class="row">
                                                    <h5 class="card-title col-md-8"><?php echo htmlspecialchars($supplier->name); ?></h5>
                                                    <div class="d-grid gap-2 d-md-flex justify-content-start col-md-4">
                                                        <!-- Edit Button -->
                                                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#editSupplierModal-<?php echo $supplier->id; ?>">Edit</button>
                                                        <!-- Delete Button -->
                                                        <form method="POST" action="deleteSupplier.php" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                                            <input type="hidden" name="d_id" value="<?php echo $supplier->id; ?>">
                                                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                                <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($supplier->address); ?></small></p>
                                                <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($supplier->contact); ?></small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Supplier Modal -->
                                <div class="modal fade" id="editSupplierModal-<?php echo $supplier->id; ?>" tabindex="-1" aria-labelledby="editSupplierModalLabel-<?php echo $supplier->id; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editSupplierModalLabel-<?php echo $supplier->id; ?>">Edit Supplier</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="editSupplier.php">
                                                    <input type="hidden" name="s_id" value="<?php echo $supplier->id; ?>">
                                                    <div class="mb-3">
                                                        <label for="edit-name-<?php echo $supplier->id; ?>" class="form-label">Supplier Name</label>
                                                        <input type="text" class="form-control" id="edit-name-<?php echo $supplier->id; ?>" name="edit-name" value="<?php echo htmlspecialchars($supplier->name); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit-address-<?php echo $supplier->id; ?>" class="form-label">Address</label>
                                                        <input type="text" class="form-control" id="edit-address-<?php echo $supplier->id; ?>" name="edit-address" value="<?php echo htmlspecialchars($supplier->address); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit-contact-<?php echo $supplier->id; ?>" class="form-label">Contact Number</label>
                                                        <input type="text" class="form-control" id="edit-contact-<?php echo $supplier->id; ?>" name="edit-contact" value="<?php echo htmlspecialchars($supplier->contact); ?>" placeholder="0xxxxxxxxx">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit-email-<?php echo $supplier->id; ?>" class="form-label">E-mail</label>
                                                        <input type="email" class="form-control" id="edit-email-<?php echo $supplier->id; ?>" name="edit-email" value="<?php echo htmlspecialchars($supplier->email); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="edit-website-<?php echo $supplier->id; ?>" class="form-label">Website</label>
                                                        <input type="text" class="form-control" id="edit-website-<?php echo $supplier->id; ?>" name="edit-website" value="<?php echo htmlspecialchars($supplier->website); ?>">
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
    </body>
</html>
