<?php
require '../DbConnector.php';

$dbcon = new DbConnector();
$con = $dbcon->getConnection();

$query = "SELECT * FROM store ORDER BY store_id DESC";
$stmt = $con->query($query);
$rs = $stmt->fetchAll(PDO::FETCH_OBJ);

// Get store statistics
$totalStores = count($rs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Management</title>
    <link rel="stylesheet" href="../utils/stores.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
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
                <li><a href="../supplier/suppliers.php"><i class="fas fa-truck"></i> Suppliers</a></li>
                <li><a href="../order/order.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="stores.php" class="active"><i class="fas fa-store"></i> Manage Store</a></li>
                <li><a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search stores, locations, contacts...">
                </div>
                <div class="user-info">
                    <div class="user-avatar">AD</div>
                    <div>
                        <div class="user-name">Admin User</div>
                        <div class="user-role">Store Manager</div>
                    </div>
                </div>
            </div>

            <!-- Stores Content -->
            <div class="stores-content">
                <div class="page-header">
                    <div>
                        <h1 class="page-title">Store Management</h1>
                        <p class="page-description">Manage your store locations, contacts, and information</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        <i class="fas fa-plus me-2"></i>Add New Store
                    </button>
                </div>

                <!-- Store Statistics -->
                <div class="store-stats">
                    <div class="stat-card">
                        <div class="stat-label">Total Stores</div>
                        <div class="stat-value"><?php echo $totalStores; ?></div>
                        <div class="stat-trend"><i class="fas fa-store text-primary me-1"></i>All locations</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Active Stores</div>
                        <div class="stat-value"><?php echo $totalStores; ?></div>
                        <div class="stat-trend"><i class="fas fa-check-circle text-success me-1"></i>All active</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Cities</div>
                        <div class="stat-value"><?php echo min($totalStores, 5); ?></div>
                        <div class="stat-trend"><i class="fas fa-map-marker-alt text-info me-1"></i>Different cities</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-label">Capacity</div>
                        <div class="stat-value"><?php echo $totalStores * 250; ?></div>
                        <div class="stat-trend"><i class="fas fa-boxes text-warning me-1"></i>Total capacity</div>
                    </div>
                </div>

                <!-- Store Cards -->
                <div class="stores-container">
                    <?php foreach ($rs as $row): ?>
                        <div class="store-card">
                            <div class="store-card-header">
                                <div class="store-avatar">
                                    <?php
                                    // Display store initials
                                    $initials = '';
                                    $words = explode(' ', $row->store_name);
                                    foreach ($words as $word) {
                                        $initials .= strtoupper($word[0]);
                                    }
                                    echo htmlspecialchars($initials);
                                    ?>
                                </div>
                                <div class="store-info">
                                    <div class="store-name"><?php echo htmlspecialchars($row->store_name); ?></div>
                                    <div class="store-contact">
                                        <i class="fas fa-phone me-1"></i><?php echo htmlspecialchars($row->contact_no); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="store-card-body">
                                <div class="store-details">
                                    <div class="detail-item">
                                        <span class="detail-label"><i class="fas fa-map-marker-alt me-1"></i>Address:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($row->address); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label"><i class="fas fa-envelope me-1"></i>Email:</span>
                                        <span class="detail-value"><?php echo htmlspecialchars($row->email); ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label"><i class="fas fa-id-badge me-1"></i>Store ID:</span>
                                        <span class="detail-value">#<?php echo htmlspecialchars($row->store_id); ?></span>
                                    </div>
                                </div>
                                <div class="store-actions">
                                    <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $row->store_id; ?>">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <form method="POST" action="manage_stores.php" onsubmit="return confirm('Are you sure you want to delete this store?');" class="d-inline">
                                        <input type="hidden" name="d_id" value="<?php echo $row->store_id; ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Store Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add New Store</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="manage_stores.php">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="store-name" class="form-label">Store Name</label>
                                <input type="text" class="form-control" id="store-name" name="store-name" required placeholder="Enter store name">
                            </div>
                            <div class="col-12">
                                <label for="store-address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="store-address" name="store-address" required placeholder="Enter complete address">
                            </div>
                            <div class="col-md-6">
                                <label for="store-contact" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="store-contact" name="store-contact" placeholder="0xxxxxxxxx" required>
                            </div>
                            <div class="col-md-6">
                                <label for="store-email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="store-email" name="store-email" placeholder="store@example.com" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Store</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Store Modals -->
    <?php foreach ($rs as $row): ?>
        <div class="modal fade" id="modal-<?php echo $row->store_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $row->store_id; ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel-<?php echo $row->store_id; ?>">Edit Store</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="manage_stores.php">
                            <input type="hidden" name="s_id" value="<?php echo $row->store_id; ?>">
                            <div class="mb-3">
                                <label for="edit-name-<?php echo $row->store_id; ?>" class="form-label">Store Name</label>
                                <input type="text" class="form-control" id="store-name-<?php echo $row->store_id; ?>" name="edit-name" value="<?php echo htmlspecialchars($row->store_name); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-address-<?php echo $row->store_id; ?>" class="form-label">Address</label>
                                <input type="text" class="form-control" id="store-address-<?php echo $row->store_id; ?>" name="edit-address" value="<?php echo htmlspecialchars($row->address); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-contact-<?php echo $row->store_id; ?>" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="store-contact-<?php echo $row->store_id; ?>" name="edit-contact" value="<?php echo htmlspecialchars($row->contact_no); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-email-<?php echo $row->store_id; ?>" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="store-email-<?php echo $row->store_id; ?>" name="edit-email" value="<?php echo htmlspecialchars($row->email); ?>" required>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Set active navigation item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage || (currentPage === 'stores.php' && href.includes('stores'))) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>