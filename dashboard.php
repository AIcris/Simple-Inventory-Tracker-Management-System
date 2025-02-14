<?php
session_start();
include_once("includes/config.php");
$id = $_SESSION['admin'];  

if (!isset($id)) {
    header("Location: index.php");
    exit();
}

$overstock = 'Overstock';
$understock = 'Understock';
$normal = 'Normal';

$obj = new DbConfig;
$obj->dbConn();

// Handle adding a product
if (isset($_POST['add'])) {
    $productID = $_POST['productID'];
    $productName = $_POST['productName'];
    $productType = $_POST['productType'];
    $productPrice = $_POST['productPrice'];
    $productStock = $_POST['productStock'];
    if ($productStock < 250) {
        $invStatus = $understock;
    } else if ($productStock > 500) {
        $invStatus = $overstock;
    } else {
        $invStatus = $normal;
    }

    $obj->addProducts($productID, $productName, $productType, $productPrice, $productStock, $invStatus);
}
$count = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>

        body{
            background-color: #f2f2f2;
        }
        .ustock { color: #ff3434; }
        .normal { color: black; }
        .ostock { color: #225bff; }
        tr,td,thead{
            text-align: center; 
        }
        .table-head-custom { 
            background: #dcdcdc;
             text-align: center; 
             letter-spacing: 1px; }
        @media (max-width: 768px) {
            .table-head-custom, .table td {
                font-size: 14px;
            }
            .table th {
                font-size: 12px;
            }
        }
        @media (max-width: 576px) {
            .table-head-custom, .table td, .table th {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class=" d-flex justify-content-between mb-3">
            <h3><strong>Welcome Admin</strong></h3>
        <a href="logout.php" class="btn btn-danger" onclick="return confirm('Are you sure you want to Logout?')">Logout</a>
        </div>
        
        <form action="" method="POST" class="shadow p-3 mb-5 bg-body rounded">
            <h4 class="mb-4">Add New Product</h4>
            <div class="row g-3">
                <div class="col-md-2">
                    <label for="productID" class="form-label">ID No.</label>
                    <input type="text" class="form-control" id="productID" name="productID" required>
                </div>
                <div class="col-md-4">
                    <label for="productName" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="productName" required>
                </div>
                <div class="col-md-2">
                    <label for="productType" class="form-label">Type</label>
                    <select class="form-select" id="productType" name="productType">
                        <option value="Food">Food</option>
                        <option value="Condiment">Condiment</option>
                        <option value="Equipment">Equipment</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="productPrice" class="form-label">Price</label>
                    <input type="text" class="form-control" id="productPrice" name="productPrice" required>
                </div>
                <div class="col-md-2">
                    <label for="productStock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="productStock" name="productStock" required>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" name="add">Add Product</button>
                <a href="dashboard.php" class="btn btn-warning ms-2">Reset</a>
            </div>
        </form>
        <div class="container shadow p-3 mb-5 bg-body rounded">
            <h4>Product List</h4>
            <div class="table-responsive">
                <table class="table mt-3">
                    <thead class="table-head-custom">
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Total Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $obj->showAll();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
    function deleteProduct(invID) {
        if (confirm("Are you sure you want to delete this product?")) {
            location.href = 'delete.php?invID=' + invID;
        }
    }
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
