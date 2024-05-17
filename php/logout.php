<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    
    // Check if logout_id is set and is a valid number
    if(isset($_GET['logout_id']) && is_numeric($_GET['logout_id'])){
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        
        // Update user status to 'Offline'
        $status = "Offline now";
        $sql = "UPDATE users SET status = '{$status}' WHERE unique_id = '{$logout_id}'";
        
        if(mysqli_query($conn, $sql)){
            // Unset all of the session variables
            $_SESSION = array();
            
            // Destroy the session
            session_destroy();
            
            // Redirect to login page
            header("location: ../login.php");
            exit; // Make sure to exit after redirection
        } else {
            // Handle SQL error
            echo "Error updating status: " . mysqli_error($conn);
        }
    } else {
        // Handle invalid or missing logout_id
        echo "Invalid logout ID.";
    }
} else {  
    // Redirect to login page if user is not logged in
    header("location: ../login.php");
    exit; // Make sure to exit after redirection
}
?>
