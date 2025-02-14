<?php


Class DbConfig {

    public $db_host = "localhost";
    public $db_user ="root";
    public $db_pass ="";
    public $db_name ="sminventorydb";

    public function dbConn(){
       

        $conn = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);   
        if($conn->connect_error){
              echo 'Cannot connect to database'.$conn->connect_error;
          }else{
              return $conn;
          }
    }

        public function login($username,$password){
            $conn = $this->dbConn();

            $sql = "SELECT * FROM tbl_account WHERE accUser = '$username' AND accPass = '$password'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               
                $row = $result->fetch_assoc();
          
                if ($row['accUser'] == 'admin' && $row['accPass']==$password) {
                    $_SESSION['admin'] = $row['accID'];  
                    header("Location: dashboard.php");
                    exit();
                    }
            }else{
                $_SESSION['error'] = '<div class="alert alert-danger" role="alert">Invalid Credentials</div>';
                header("Location: index.php"); 
                exit();
            }
        }

    

        public function addProducts($productID,$productName,$productType,$productPrice,$productStock,$productStatus){
            $conn = $this->dbConn();

            $sql = "INSERT INTO `tbl_inventory`(`invID`, `invName`, `invType`, `invPrice`, `invStock`, `invStatus`) VALUES ('$productID','$productName','$productType','$productPrice','$productStock]', '$productStatus')";
            $result = $conn->query($sql);

            if($result ==TRUE){
                echo '<script>alert("Product Added Successfully")</script>';
            }else{
                echo '<script>alert("Failed")</script>';
            }


        }


        

        public function updateProducts( $productStock) {
            $conn = $this->dbConn();
            $id = $_GET['updateID'];

            $overstock = 'Overstock';
            $understock = 'Understock';
            $normal = 'Normal';
            
            if ($productStock < 250) {
                $invStatus = $understock;
            } else if ($productStock > 500) {
                $invStatus = $overstock;
            } else {
                $invStatus = $normal;
            }
    
            $sql = "UPDATE tbl_inventory SET invStock = $productStock, invStatus = '$invStatus' WHERE invID = '$id'";
            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }




        public function deleteProduct($id) {
            $conn = $this->dbConn();
            $sql = "DELETE FROM tbl_inventory WHERE invID = '$id'";
            if ($conn->query($sql) === TRUE) {
                return true;
            } else {
                return false;
            }
        }
        

     

        public function showAll() {
            $conn = $this->dbConn();
            $sql = "SELECT * FROM tbl_inventory WHERE invID LIKE '%SM%'";
            $result = $conn->query($sql);
            $count = 1;
        
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $statusClass = '';
                    if ($row['invStatus'] == 'Understock') {
                        $statusClass = 'ustock';
                    } else if ($row['invStatus'] == 'Overstock') {
                        $statusClass = 'ostock';
                    } else {
                        $statusClass = 'normal';
                    }
                    ?>
                    <tr>
                        <?php echo "<td> <strong>".$count++."</strong></td>"; ?>
                        <td><?php echo $row['invID']; ?></td>
                        <td><?php echo $row['invName']; ?></td>
                        <td><?php echo $row['invType']; ?></td>
                        <td><?php echo $row['invPrice']; ?></td>
                        <td><?php echo $row['invStock']; ?></td>
                        <td class="<?php echo $statusClass; ?>"><?php echo $row['invStatus']; ?></td>
                        <td>
                            <button class="btn btn-danger" onclick="deleteProduct('<?php echo $row['invID']; ?>');">Delete</button>
                            <button class="btn btn-primary" onclick="location.href='updateProduct.php?updateID=<?php echo $row['invID']; ?>';">Update</button>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="8">
                        <div class="room-box">
                            <h2>No record found with 'SM' in ID</h2>
                        </div>
                    </td>
                </tr>
                <?php
            }
        }
}
