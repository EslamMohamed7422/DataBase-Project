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
    $sql = "SELECT * FROM Instructor WHERE Fname LIKE '%$searchTerm%' OR Lname LIKE '%$searchTerm%'";
} else {
    $sql = "SELECT * FROM Instructor";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Table - University Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Instructor Table</h2>
        <form method="POST" class="mb-3">
            <input type="text" class="form-control" name="searchTerm" placeholder="Search by First or Last Name" value="<?php echo $searchTerm; ?>">
            <button type="submit" name="search" class="btn btn-primary mt-2">Search</button>
        </form>

        <!-- Add Instructor Form -->
        <form method="POST" action="insert_instructor.php" class="mb-4">
            <div class="mb-3">
                <label for="Fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="Fname" name="Fname" required>
            </div>
            <div class="mb-3">
                <label for="Lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="Lname" name="Lname" required>
            </div>
            <div class="mb-3">
                <label for="Role" class="form-label">Role</label>
                <input type="text" class="form-control" id="Role" name="Role" required>
            </div>
            <div class="mb-3">
                <label for="Contact_Email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="Contact_Email" name="Contact_Email" required>
            </div>
            <button type="submit" class="btn btn-success">Add Instructor</button>
        </form>

        <!-- Instructor Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>InstructorID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Role</th>
                    <th>Contact Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["InstructorID"] . "</td>
                                <td>" . $row["Fname"] . "</td>
                                <td>" . $row["Lname"] . "</td>
                                <td>" . $row["Role"] . "</td>
                                <td>" . $row["Contact_Email"] . "</td>
                                <td>
                                    <a href='update_instructor.php?id=" . $row["InstructorID"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_instructor.php?id=" . $row["InstructorID"] . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
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
