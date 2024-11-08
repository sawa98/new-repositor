<?php
$con = mysqli_connect("localhost", "root", "", "testing");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['sno'])) {
    echo "Error: 'sno' parameter is missing.";
    exit;
}

$sno = $_GET['sno'];
echo $sno;
// Retrieve existing data
$query = mysqli_query($con, "SELECT `sno`, `name`, `message` FROM `testingtable` WHERE sno=$sno");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "No record found for sno: $sno";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $message = $_POST['message'];

    // Update the record
    $stmt = mysqli_prepare($con, "UPDATE `testingtable` SET `name`=?, `message`=? WHERE `sno`=?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $message, $sno);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Update Record</h2>
        <form method="post">
            <div class="mb-3">
                <label for="sno" class="form-label">SNO</label>
                <input type="text" class="form-control" name="sno" value="<?php echo htmlspecialchars($user['sno']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea name="message" class="form-control" rows="3" required><?php echo htmlspecialchars($user['message']); ?></textarea>
            </div>
            <button class="btn btn-success" type="submit" name="update">Update</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>