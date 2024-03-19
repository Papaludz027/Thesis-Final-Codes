<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_waterbilling";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the GET request is received
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["data"])) {
    // Extract the data from the GET request
    $data = $_GET["data"];

    // Extract the month and year from the current date
    $monthYear = date("Y-m");

    // Check if a record with the same month and year already exists
    $sql = "SELECT * FROM watercon WHERE DATE_FORMAT(date, '%Y-%m') = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $monthYear);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the existing record
        $updateSql = "UPDATE watercon SET consumption = ? WHERE DATE_FORMAT(date, '%Y-%m') = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ds", $data, $monthYear);
        if ($updateStmt->execute()) {
            echo "Data updated successfully";
        } else {
            echo "Error updating data: " . $updateStmt->error;
        }
        $updateStmt->close();
    } else {
        // Insert a new record
        // $insertSql = "INSERT INTO watercon (consumption, price, date) VALUES (?, 10, NOW())";
        // $insertStmt = $conn->prepare($insertSql);
        // $insertStmt->bind_param("d", $data);
        // if ($insertStmt->execute()) {
        //     echo "Data inserted successfully";
        // } else {
        //     echo "Error inserting data: " . $insertStmt->error;
        // }
        // $insertStmt->close();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}

