<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Suppliers</title>
    <link rel="stylesheet" href="../utils/suppleirs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
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
                    <input type="text" placeholder="Search suppliers, contacts, locations...">
                </div>
                <div class="user-info">
                    <div class="user-avatar">JD</div>
                    <div>
                        <div class="user-name">John Doe</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- Suppliers Content -->
            <div class="suppliers-content">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Manage Suppliers</h1>
                        <p class="page-description">View and manage your supplier relationships and contacts</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                        <i class="fas fa-plus me-2"></i>Add New Supplier
                    </button>
                </div>

                <?php if ($message): ?>
                    <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
                        <i class="fas <?php echo $alertClass == 'alert-success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> me-2"></i>
                        <?php echo $message; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Suppliers Cards -->
                <div class="supplier-cards-container">
                    <?php foreach ($suppliers as $supplier): ?>
                        <div class="supplier-card">
                            <div class="supplier-card-header">
                                <div class="supplier-avatar">
                                    <?php
                                    // Display supplier initials
                                    $initials = '';
                                    $words = explode(' ', $supplier->name);
                                    foreach ($words as $word) {
                                        $initials .= strtoupper($word[0]);
                                    }
                                    echo htmlspecialchars($initials);
                                    ?>
                                </div>
                                <div class="supplier-info">
                                    <div class="supplier-name"><?php echo htmlspecialchars($supplier->name); ?></div>
                                    <div class="supplier-contact">
                                        <i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($supplier->contact); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="supplier-card-body">
                                <div class="supplier-details">
                                    <div class="detail-item">
                                        <span class="detail-label"><i class="fas fa-map-marker-alt me-1"></i>Address:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($supplier->address); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label"><i class="fas fa-envelope me-1"></i>Email:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($supplier->email); ?></span>
                                    </div>
                                    <?php if (!empty($supplier->website)): ?>
                                        <div class="detail-item">
                                            <span class="detail-label"><i class="fas fa-globe me-1"></i>Website:</span>
                                            <span class="detail-value"><?php echo htmlspecialchars($supplier->website); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="supplier-actions">
                                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#editSupplierModal-<?php echo $supplier->id; ?>">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <form method="POST" action="deleteSupplier.php" onsubmit="return confirm('Are you sure you want to delete this supplier?');" class="d-inline">
                                        <input type="hidden" name="d_id" value="<?php echo $supplier->id; ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Add Supplier Modal -->
                <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addSupplierModalLabel">Add New Supplier</h1>
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
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Add Supplier</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Supplier Modals -->
                <?php foreach ($suppliers as $supplier): ?>
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