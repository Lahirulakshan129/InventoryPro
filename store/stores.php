<?php
require '../DbConnector.php';

$dbcon = new DbConnector();
$con = $dbcon->getConnection();

$query = "SELECT * FROM store ORDER BY store_id DESC";
$stmt = $con->query($query);
$rs = $stmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Stores</title>
        <link rel="stylesheet" href="stores.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>

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
                <div class="col-12">
                    <h2 class="align-self-center">Manage Stores</h2>     
                </div>

                <div class="col-12 d-flex justify-content-end" style="padding-bottom: 20px">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Store</button>
                </div>

                <!-- Modal Form-->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Store</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="" method="POST" action="manage_stores.php">
                                    <div class="col-12">
                                        <label class="">Store Name</label>
                                        <input type="text" class="form-control" id="store-name" name="store-name" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="">Address</label>
                                        <input type="text" class="form-control" id="store-address" name="store-address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="">Contact Number</label>
                                        <input type="text" class="form-control" id="store-contact" name="store-contact" placeholder="0xxxxxxxxx">
                                    </div>
                                    <div class="col-md-6" style="padding-bottom: 20px">
                                        <label class="">Your E-mail</label>
                                        <input type="text" class="form-control" id="store-email" name="store-email" placeholder="saman123@gmail.com" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-outline-dark">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>                     

                <?php foreach ($rs as $row): ?>
                    <!--cards-->
                    <div class="card mb-3 col-md-9">
                        <div class="row g-0">
                            <div class="col-md-9">
                                <div class="card-body">
                                    <div class="row">
                                        <h5 class="card-title col-md-11"><?php echo htmlspecialchars($row->store_name); ?></h5>
                                        <div class="d-grid gap-2 d-md-flex justify-content-start col-md-1">
                                            <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $row->store_id; ?>">
                                                Edit
                                            </button>
                                            <form method="POST" action="manage_stores.php" onsubmit="return confirm('Are you sure you want to delete this store?');">
                                                <input type="hidden" name="d_id" value="<?php echo $row->store_id; ?>">
                                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($row->address); ?></small></p>
                                    <p class="card-text"><small class="text-muted"><?php echo htmlspecialchars($row->contact_no); ?></small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->

                    <div class="modal fade" id="modal-<?php echo $row->store_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel-<?php echo $row->store_id; ?>" aria-hidden="true" >
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
                                            <label for="edit-email-<?php echo $row->store_id; ?>" class="form-label">E-mail</label>
                                            <input type="email" class="form-control" id="store-email-<?php echo $row->store_id; ?>" name="edit-email" value="<?php echo htmlspecialchars($row->email); ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
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

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>



