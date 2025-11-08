<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./utils/indexcss.css">
</head>
<body>
    <?php
    require './DbConnector.php';

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
                <li><a href="index.php" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="inventory/inventory.php"><i class="fas fa-box-open"></i> Inventory</a></li>
                <li><a href="supplier/suppliers.php"><i class="fas fa-truck"></i> Suppliers</a></li>
                <li><a href="order/order.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                <li><a href="store/stores.php"><i class="fas fa-store"></i> Manage Store</a></li>
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
                        <div class="user-name">John Doe</div>
                        <div class="user-role">Administrator</div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <div class="welcome-section">
                    <h1>Dashboard Overview</h1>
                    <p>Welcome back! Here's what's happening with your inventory today.</p>
                </div>

                <!-- Stats Cards -->
                <div class="dashboard-grid">
                    <div class="stat-card total-items">
                        <div class="stat-card-header">
                            <h3>Total Items</h3>
                            <div class="stat-card-icon">
                                <i class="fas fa-boxes"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">8</div>
                        <div class="stat-card-footer">
                            <i class="fas fa-arrow-up positive"></i>
                            <span>2% increase from last month</span>
                        </div>
                    </div>

                    <div class="stat-card total-orders">
                        <div class="stat-card-header">
                            <h3>Total Orders</h3>
                            <div class="stat-card-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">8</div>
                        <div class="stat-card-footer">
                            <i class="fas fa-arrow-up positive"></i>
                            <span>5 new orders today</span>
                        </div>
                    </div>

                    <div class="stat-card total-suppliers">
                        <div class="stat-card-header">
                            <h3>Total Suppliers</h3>
                            <div class="stat-card-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">54</div>
                        <div class="stat-card-footer">
                            <i class="fas fa-minus"></i>
                            <span>No change from last week</span>
                        </div>
                    </div>

                    <div class="stat-card total-stores">
                        <div class="stat-card-header">
                            <h3>Total Stores</h3>
                            <div class="stat-card-icon">
                                <i class="fas fa-store"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">13</div>
                        <div class="stat-card-footer">
                            <i class="fas fa-arrow-up positive"></i>
                            <span>1 new store this quarter</span>
                        </div>
                    </div>

                    <div class="stat-card low-stock">
                        <div class="stat-card-header">
                            <h3>Low Stock Items</h3>
                            <div class="stat-card-icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">9</div>
                        <div class="stat-card-footer">
                            <i class="fas fa-arrow-up negative"></i>
                            <span>3 more than last week</span>
                        </div>
                    </div>

                    <div class="stat-card out-of-stock">
                        <div class="stat-card-header">
                            <h3>Out of Stock Items</h3>
                            <div class="stat-card-icon">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                        <div class="stat-card-value">5</div>
                        <div class="stat-card-footer">
                            <i class="fas fa-arrow-down positive"></i>
                            <span>2 resolved since yesterday</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <h2 class="section-title">
                    <i class="fas fa-history"></i>
                    Recent Activity
                </h2>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon" style="background-color: var(--primary);">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="activity-details">
                            <div class="activity-title">New inventory item added</div>
                            <div class="activity-time">Product "Wireless Earbuds" was added to inventory</div>
                        </div>
                        <div class="activity-time">2 hours ago</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background-color: var(--info);">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="activity-details">
                            <div class="activity-title">New order received</div>
                            <div class="activity-time">Order #ORD-7842 from TechCorp Inc.</div>
                        </div>
                        <div class="activity-time">5 hours ago</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background-color: var(--success);">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="activity-details">
                            <div class="activity-title">Supplier updated</div>
                            <div class="activity-time">Global Electronics contact information updated</div>
                        </div>
                        <div class="activity-time">Yesterday</div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon" style="background-color: var(--warning);">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="activity-details">
                            <div class="activity-title">Low stock alert</div>
                            <div class="activity-time">"USB-C Cables" running low (only 12 left)</div>
                        </div>
                        <div class="activity-time">2 days ago</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple script to handle active navigation item
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-menu a');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navLinks.forEach(item => item.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>