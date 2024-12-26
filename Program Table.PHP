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
    $sql = "SELECT * FROM Program WHERE PNAME LIKE '%$searchTerm%'";
} else {
    $sql = "SELECT * FROM Program";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Table - University Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Program Table</h2>
        <form method="POST" class="mb-3">
            <input type="text" class="form-control" name="searchTerm" placeholder="Search by Program Name" value="<?php echo $searchTerm; ?>">
            <button type="submit" name="search" class="btn btn-primary mt-2">Search</button>
        </form>

        <!-- Add Program Form -->
        <form method="POST" action="insert_program.php" class="mb-4">
            <div class="mb-3">
                <label for="PNAME" class="form-label">Program Name</label>
                <input type="text" class="form-control" id="PNAME" name="PNAME" required>
            </div>
            <div class="mb-3">
                <label for="TotalCreditRequired" class="form-label">Total Credit Required</label>
                <input type="number" class="form-control" id="TotalCreditRequired" name="TotalCreditRequired" required>
            </div>
            <div class="mb-3">
                <label for="YearCommenced" class="form-label">Year Commenced</label>
                <input type="number" class="form-control" id="YearCommenced" name="YearCommenced" required>
            </div>
            <button type="submit" class="btn btn-success">Add Program</button>
        </form>

        <!-- Program Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ProgramID</th>
                    <th>Program Name</th>
                    <th>Total Credit Required</th>
                    <th>Year Commenced</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["ProgramID"] . "</td>
                                <td>" . $row["PNAME"] . "</td>
                                <td>" . $row["TotalCreditRequired"] . "</td>
                                <td>" . $row["YearCommenced"] . "</td>
                                <td>
                                    <a href='update_program.php?id=" . $row["ProgramID"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_program.php?id=" . $row["ProgramID"] . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found</td></tr>";
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
