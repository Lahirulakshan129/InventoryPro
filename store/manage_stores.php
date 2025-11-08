<?php
require './stores.php';
require './store_process.php';

$dbcon = new DbConnector();
$con = $dbcon->getConnection();



if (isset($_POST['s_id']) && !empty($_POST['s_id'])) {
    $e_id = $_POST['s_id'];
    $e_name = $_POST['edit-name'];
    $e_contact = $_POST['edit-contact'];
    $e_address = $_POST['edit-address'];
    $e_email = $_POST['edit-email'];

    $store = new Stores($e_name, $e_address, $e_contact, $e_email);

    if ($store->editStore($con, $e_id)) {
        echo '<script> 
        alert("Details edited Successfully");
        window.location.href="stores.php";
        </script>';
    } else {
        echo "error occured";
    }
} elseif (isset($_POST['d_id']) && !empty($_POST['d_id'])) {
    // Delete store
    $d_id = $_POST['d_id'];
    $store = new Stores();

    if ($store->deleteS($con, $d_id)) {
        echo '<script>
            
            window.location.href = "stores.php";
        </script>';
    }
} else {
    $name = $_POST['store-name'];
    $contact = $_POST['store-contact'];
    $address = $_POST['store-address'];
    $email = $_POST['store-email'];

    $store = new Stores($name, $address, $contact, $email);
    if ($store->addStore($con)) {
        echo
        '<script> 
  alert("Store Added Successfully");
  window.location.href="stores.php";
</script>';
    } else {
        echo "error occured";
    }
}
?>
