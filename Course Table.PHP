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
    $sql = "SELECT * FROM Course WHERE CourseName LIKE '%$searchTerm%'";
} else {
    $sql = "SELECT * FROM Course";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Table - University Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Course Table</h2>
        <form method="POST" class="mb-3">
            <input type="text" class="form-control" name="searchTerm" placeholder="Search by Course Name" value="<?php echo $searchTerm; ?>">
            <button type="submit" name="search" class="btn btn-primary mt-2">Search</button>
        </form>

        <!-- Add Course Form -->
        <form method="POST" action="insert_course.php" class="mb-4">
            <div class="mb-3">
                <label for="CourseName" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="CourseName" name="CourseName" required>
            </div>
            <div class="mb-3">
                <label for="CreditPoints" class="form-label">Credit Points</label>
                <input type="number" class="form-control" id="CreditPoints" name="CreditPoints" required>
            </div>
            <div class="mb-3">
                <label for="Type" class="form-label">Type</label>
                <input type="text" class="form-control" id="Type" name="Type" required>
            </div>
            <div class="mb-3">
                <label for="INSTRID" class="form-label">Instructor ID</label>
                <input type="number" class="form-control" id="INSTRID" name="INSTRID" required>
            </div>
            <button type="submit" class="btn btn-success">Add Course</button>
        </form>

        <!-- Course Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>CourseID</th>
                    <th>Course Name</th>
                    <th>Credit Points</th>
                    <th>Type</th>
                    <th>Instructor ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["CourseID"] . "</td>
                                <td>" . $row["CourseName"] . "</td>
                                <td>" . $row["CreditPoints"] . "</td>
                                <td>" . (isset($row["Type"]) ? $row["Type"] : 'N/A') . "</td>
                                <td>" . $row["INSTRID"] . "</td>
                                <td>
                                    <a href='update_course.php?id=" . $row["CourseID"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_course.php?id=" . $row["CourseID"] . "' class='btn btn-danger btn-sm'>Delete</a>
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
