<?php
    session_start();
    
    include("../includes/connection.php");

    $query = "DELETE FROM book WHERE b_id = ?";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($query);
    
    // Bind parameters
    $stmt->bind_param("i", $_GET['id']);
    
    // Execute the statement
    if ($stmt->execute()) {
        // If deletion was successful, redirect to category_view.php
        header("location:book_view.php");
        exit();
    } else {
        // If deletion failed, handle the error
        echo "Error: " . $mysqli->error;
    }
?>
