<?php
    // MySQLi connection
    $mysqli = new mysqli("localhost", "root", "", "bms");

    // Check connection
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
