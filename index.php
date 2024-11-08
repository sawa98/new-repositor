<?php 
$con = mysqli_connect("localhost", "root", "", "testing");
if ($con) {
    // echo "connect"; // Uncomment for debugging
} else {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert data
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $query = "INSERT INTO `testingtable`(`name`, `message`) VALUES ('$name','$message')";
    if(mysqli_query($con, $query)){
      echo "<div class='bg bg-success text-light'>thankyou</div>";
    }
    
}

// Update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    $updateQuery = "UPDATE `testingtable` SET `name`='$name', `message`='$message' WHERE `sno`='$id'";
    mysqli_query($con, $updateQuery);
}

// Delete data
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $deleteQuery = "DELETE FROM `testingtable` WHERE `sno`='$id'";
    mysqli_query($con, $deleteQuery);
}

// Fetch existing data for update
$currentRow = null;
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $currentRow = mysqli_query($con, "SELECT `sno`, `name`, `message` FROM `testingtable` WHERE `sno`='$id'");
    $currentRow = mysqli_fetch_assoc($currentRow);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<form class="container" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" placeholder="name" value="<?php echo $currentRow ? htmlspecialchars($currentRow['name']) : ''; ?>" required>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea name="message" class="form-control" rows="3" required><?php echo $currentRow ? htmlspecialchars($currentRow['message']) : ''; ?></textarea>
    </div>
    <?php if ($currentRow): ?>
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($currentRow['sno']); ?>">
        <button class="btn btn-success" onclick="alert('you have successfully updated this record');" type="submit" name="update">Update</button>
    <?php else: ?>
        <button class="btn btn-primary" onclick="alert('you have successfully insert a new data?');" type="submit" name="submit">Submit</button>
    <?php endif; ?>
</form>

<table class="table container">
    <thead>
        <th>SNO</th>
        <th>Name</th>
        <th>Message</th>
        <th>Option</th>
    </thead>
    <tbody>
        <?php
        $query = "SELECT sno, name, message FROM `testingtable`;";
        
        $result = mysqli_query($con, $query);
      
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>" . htmlspecialchars($row["sno"]) . "</td>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>" . htmlspecialchars($row["message"]). "</td>
                <td>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($row["sno"]) . "'>
                        <button type='submit' name='edit' class='btn btn-warning'>Edit</button>
                    </form>
                    <form method='post' style='display:inline;' onsubmit=\"return confirm('Are you sure you want to delete this record?');\">
                        <input type='hidden' name='id' value='" . htmlspecialchars($row["sno"]) . "'>
                        <button type='submit' name='delete'  class='btn btn-success'>Delete</button>
                        </form>";
                      }
                        ?>
                        </tbody>
                        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
                      </body>
                        </html>
                        