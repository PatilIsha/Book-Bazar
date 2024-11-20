<?php
    session_start();
    
    include("../includes/connection.php");

    $query = "DELETE FROM register WHERE r_id = ?";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("i", $_GET['id']);
    
    // Execute the statement
    if ($stmt->execute()) {
        // If deletion was successful, redirect to users_view.php
        header("location:users_view.php");
        exit();
    } else {
        // If deletion failed, handle the error
        echo "Error: " . $mysqli->error;
    }
?>
