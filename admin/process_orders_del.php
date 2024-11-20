<?php
    // Start session
    session_start();

    // Include the database connection
    include("../includes/connection.php");

    // Check if the ID parameter is set
    if(isset($_GET['id'])) {
        // Sanitize the ID parameter to prevent SQL injection
        $order_id = mysqli_real_escape_string($mysqli, $_GET['id']);

        // Prepare the SQL query to delete the order
        $query = "DELETE FROM orders WHERE o_id = ?";

        // Prepare the statement
        $stmt = $mysqli->prepare($query);

        // Bind the parameters
        $stmt->bind_param("i", $order_id);

        // Execute the statement
        if($stmt->execute()) {
            // Redirect to the page where orders are listed
            header("Location: orders_view.php");
            exit();
        } else {
            // If the deletion fails, display an error message
            echo "Error deleting order: " . $mysqli->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // If the ID parameter is not set, redirect back to the page where orders are listed
        header("Location: orders_view.php");
        exit();
    }

    // Close the database connection
    $mysqli->close();
?>
