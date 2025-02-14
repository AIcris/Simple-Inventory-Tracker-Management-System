<?php
session_start();
if(isset($_SESSION['admin'])){
    unset($_SESSION['admin']); // unset the session variable 'guestID'
    
}

header('Location: index.php');
exit;
?>