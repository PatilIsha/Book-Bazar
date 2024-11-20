<?php
session_start();

include("includes/connection.php");

if (!empty($_POST)) {
    extract($_POST);
    extract($_SESSION);

    $_SESSION['error'] = array();

    if (empty($fnm)) {
        $_SESSION['error'][] = "Enter Full Name";
    }

    if (empty($add)) {
        $_SESSION['error'][] = "Enter Full Address";
    }

    if (empty($pc)) {
        $_SESSION['error'][] = "Enter City Pincode";
    }

    if (empty($city)) {
        $_SESSION['error'][] = "Enter City";
    }

    if (empty($state)) {
        $_SESSION['error']['state'] = "Enter State";
    }

    if (empty($mno)) {
        $_SESSION['error'][] = "Enter Mobile Number";
    } else if (!is_numeric($mno)) {
        $_SESSION['error'][] = "Enter Mobile Number in Numbers";
    }

    if (!empty($_SESSION['error'])) {
        header("location:order.php");
        exit;
    } else {
        // Check if 'o_rid' is set to a valid value
        if (isset($_SESSION['client']['id']) && !empty($_SESSION['client']['id'])) {
            $rid = $_SESSION['client']['id'];

            // Retrieve order details from session or URL parameters
            $order_details = "";
            $total_amount = 0;

            // Debugging
            echo "Total from GET: ".$_GET['total']."<br>";
            echo "<script>alert('Total is ".$_GET['total']."');</script>";

            if (isset($_GET['total'])) {
                $total_amount = (float)$_GET['total']; // Cast to float to handle formatting issues
                echo "Total amount after casting: ".$total_amount."<br>";
            } else {
                echo "Total not found in GET parameters<br>";
            }

            if (isset($_SESSION['cart'])) {
                $total_amount = 0; // Initialize total amount to 0
                $order_details_array = array();
                foreach ($_SESSION['cart'] as $id => $val) {
                    $total_item_price = $val['qty'] * $val['price'];
                    $total_amount += $total_item_price; // Add total item price to total amount
                    $order_details_array[] = $val['nm'] . " (Qty: " . $val['qty'] . ", Price: " . $val['price'] . ", Total: " . $total_item_price . ")";
                }
                // Assign the total amount to the session or URL parameters
                $_SESSION['total_amount'] = $total_amount;
                // Convert array to string  
                $order_details = implode(", ", $order_details_array);
            }

            // Prepare the SQL query to insert order details
            $query = "INSERT INTO orders (
                            o_name,
                            o_address,
                            o_pincode,
                            o_city,
                            o_state,
                            o_mobile,
                            o_order_details,
                            o_total_amount,
                            o_rid
                        ) VALUES (
                            ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )";

            $stmt = $mysqli->prepare($query);

            // Bind parameters to the prepared statement
            $stmt->bind_param("ssisssssi", $fnm, $add, $pc, $city, $state, $mno, $order_details, $total_amount, $rid);

            // Execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to order page with success message
                header("location:order.php?order");
                exit;
            } else {
                // Display error message
                echo "Error: " . $query . "<br>" . $mysqli->error;
            }
            $stmt->close();
        } else {
            // Handle case where 'o_rid' is not set
            echo "<script>alert('Error: User ID not set'); window.location.href = 'order.php';</script>";
            exit;
        }
    }
} else {
    header("location:order.php");
    exit;
}
?>
