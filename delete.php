<?php

 include_once("includes/config.php");
 $obj = new DbConfig;
 $obj->dbconn();
 if(isset($_GET['invID'])) {
    $deleteID = $_GET['invID'];
     
   if( $obj->deleteProduct($deleteID)){

    echo '<script>alert("Product deleted successfully"); window.location.href = "dashboard.php";</script>';
    exit();
   }else{
    echo '<script>alert("Failed to delete data")</script>';
   }
}  

?>
