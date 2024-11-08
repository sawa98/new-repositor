<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "testing");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'sno' parameter is set in the URL
if (isset($_GET['sno'])) {
    $sno = $_GET['sno'];

    // Prepare the DELETE statement
    $stmt = mysqli_prepare($con, "DELETE FROM testing WHERE sno = ?");
    
    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $sno); // "i" indicates that $sno is an integer

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Successfully deleted
        header("Location: index.php"); // Redirect to index.php after deletion
        exit();
    } else {
        // Handle error
        echo "Error deleting record: " . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Error: 'sno' parameter is missing.";
}

// Close the database connection
mysqli_close($con);
?>