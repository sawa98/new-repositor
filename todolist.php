<?php
$con = mysqli_connect("localhost", "root", "", "todolist");
if ($con) {
    // echo "connect"; // Uncomment for debugging
} else {
    die("Connection failed: " . mysqli_connect_error());
}

// Add new task to the database
if (isset($_POST['submit'])) {
    $task = mysqli_real_escape_string($con, $_POST['task']);
    if (empty($task)) {
        echo "<div class='bg bg-danger text-light'>Please enter a task before submitting.</div>";
    } else {
        $query = "INSERT INTO `todolist`(`TASK`) VALUES ('$task')";
        if (mysqli_query($con, $query)) {
            echo "<div class='bg bg-success text-light'>Task added successfully.</div>";
        }
    }
}

// Delete task
if (isset($_POST['delete'])) {
    $id = $_POST['name']; // Get ID of the task to delete
    if (isset($id) && is_numeric($id)) {
        $deleteQuery = "DELETE FROM `todolist` WHERE `ID` = $id";
        if (mysqli_query($con, $deleteQuery)) {
            echo "<div class='bg bg-danger text-light'>Task deleted successfully.</div>";
        } else {
            echo "<div class='bg bg-danger text-light'>Error deleting task.</div>";
        }
    }
}

// Delete all tasks
if (isset($_POST['deleted'])) {
    $deleteQuery = "DELETE FROM `todolist`";
    mysqli_query($con, $deleteQuery);
    echo "<div class='bg bg-danger text-light'>All tasks deleted successfully.</div>";
}

// Filter tasks
$filter = "";
if (isset($_POST['task_filter'])) {
    $filter = mysqli_real_escape_string($con, $_POST['task_filter']);
}

// Clear filter
if (isset($_POST['clear'])) {
    $filter = ""; // Clear the filter
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Task List</title>
</head>
<body>
    <div class="container">
        <h2>Task List</h2>
        <form method="post">
            <input type="text" name="task" class="form-control" placeholder="New Task">
            <button class="btn btn-primary my-3" name="submit">Add Task</button>
        </form>
    </div>

    <div class="container">
        <h2>Filter Tasks</h2>
        <form method="post">
            <input type="text" name="task_filter" class="form-control" placeholder="Filter Tasks" value="<?php echo htmlspecialchars($filter); ?>">
            <button class="btn btn-secondary my-3" type="submit">Filter</button>
            <button class="btn btn-dark my-3" name="clear" type="submit">Clear</button>
        </form>

        <table class="table container">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Modify query to apply the filter if there is a value in $filter
                if ($filter) {
                    $query = "SELECT `ID`, `TASK` FROM `todolist` WHERE `TASK` LIKE '%$filter%'";
                } else {
                    $query = "SELECT `ID`, `TASK` FROM `todolist`"; // No filter, show all tasks
                }

                $result = mysqli_query($con, $query);
                
                // Check if there are any tasks
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['TASK']); ?></td>
                    <td>
                    <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                        <input type="hidden" name="name" value="<?php echo $row['ID']; ?>"> <!-- Pass ID here -->
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </form>
                    </td>
                </tr>
            <?php
                    }
                } else {
                    echo "<tr><td colspan='2'>No tasks found for the given filter.</td></tr>";
                }
            ?>
            </tbody>
        </table>
    </div>

    <form class="container" method="post" onsubmit="return confirm('Are you sure you want to delete all tasks?');">
        <button type="submit" name="deleted" class="btn btn-dark">Delete All</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
