<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "University_Management_System";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Search
$searchTerm = "";
if (isset($_POST['search'])) {
    $searchTerm = $_POST['searchTerm'];
    $sql = "SELECT * FROM Enrollement WHERE STATUS LIKE '%$searchTerm%'";
} else {
    $sql = "SELECT * FROM Enrollement";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollement Table - University Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Enrollement Table</h2>
        <form method="POST" class="mb-3">
            <input type="text" class="form-control" name="searchTerm" placeholder="Search by Status" value="<?php echo $searchTerm; ?>">
            <button type="submit" name="search" class="btn btn-primary mt-2">Search</button>
        </form>

        <!-- Add Enrollement Form -->
        <form method="POST" action="insert_enrollement.php" class="mb-4">
            <div class="mb-3">
                <label for="TotalCredCompleted" class="form-label">Total Credits Completed</label>
                <input type="number" class="form-control" id="TotalCredCompleted" name="TotalCredCompleted" required>
            </div>
            <div class="mb-3">
                <label for="STATUS" class="form-label">Status</label>
                <input type="text" class="form-control" id="STATUS" name="STATUS" required>
            </div>
            <button type="submit" class="btn btn-success">Add Enrollement</button>
        </form>

        <!-- Enrollement Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>EnrollementID</th>
                    <th>Total Credits Completed</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["EnrollementID"] . "</td>
                                <td>" . $row["TotalCredCompleted"] . "</td>
                                <td>" . $row["STATUS"] . "</td>
                                <td>
                                    <a href='update_enrollement.php?id=" . $row["EnrollementID"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_enrollement.php?id=" . $row["EnrollementID"] . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
