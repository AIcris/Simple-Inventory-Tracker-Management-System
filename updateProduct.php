<?php
    session_start();
    include_once("includes/config.php");
    $id = $_SESSION['admin'];  

if (!isset($id)) {
    header("Location: index.php");
    exit();
}

    $obj = new DbConfig;
    $obj->dbConn();

    $updateID = isset($_GET['updateID']) ? $_GET['updateID'] : '';
    if (isset($_POST['update'])) {
  
        $productStock = $_POST['productStock'];
    
    
        if ($obj->updateProducts( $productStock)) {
            header("Location: dashboard.php");
            exit();
        } else{
            echo '<script>alert("Error updating product")';
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product Stock</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <a  class="btn btn-primary mb-3" href="dashboard.php">Back</a>
        <form action="" method="POST" class="shadow p-3 mb-5 bg-body rounded">
            <h4 class="mb-4">Update Product Stock</h4>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="productID" class="form-label">Product ID</label>
                    <input type="text" name="productID" value="<?php  echo $updateID ?>"   class="field left form-control" readonly>
                </div>
                <div class="col-md-4">
                    <label for="newStock" class="form-label">Stock</label>
                    <input type="number" class="form-control" id="newStock" name="productStock" value="" required>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary" name="update">Update Stock</button>
                <a href="updateProduct.php" class="btn btn-warning ms-2">Reset</a>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
