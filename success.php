<?php
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        echo "<h2>Data inserted successfully!</h2>";
    } elseif ($_GET['status'] == 'error') {
        echo "<h2>There was an error inserting the data.</h2>";
    }
}
?>