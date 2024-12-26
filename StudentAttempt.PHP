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
    $sql = "SELECT * FROM StudentAttempt WHERE TSID LIKE '%$searchTerm%' OR TPID LIKE '%$searchTerm%' OR TCID LIKE '%$searchTerm%'";
} else {
    $sql = "SELECT * FROM StudentAttempt";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Attempt Table - University Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Student Attempt Table</h2>
        <form method="POST" class="mb-3">
            <input type="text" class="form-control" name="searchTerm" placeholder="Search by Student ID, Program ID, or Course ID" value="<?php echo $searchTerm; ?>">
            <button type="submit" name="search" class="btn btn-primary mt-2">Search</button>
        </form>

        <!-- Add Student Attempt Form -->
        <form method="POST" action="insert_student_attempt.php" class="mb-4">
            <div class="mb-3">
                <label for="TSID" class="form-label">Student ID</label>
                <input type="number" class="form-control" id="TSID" name="TSID" required>
            </div>
            <div class="mb-3">
                <label for="TPID" class="form-label">Program ID</label>
                <input type="number" class="form-control" id="TPID" name="TPID" required>
            </div>
            <div class="mb-3">
                <label for="TCID" class="form-label">Course ID</label>
                <input type="number" class="form-control" id="TCID" name="TCID" required>
            </div>
            <div class="mb-3">
                <label for="YEAR" class="form-label">Year</label>
                <input type="date" class="form-control" id="YEAR" name="YEAR" required>
            </div>
            <div class="mb-3">
                <label for="Semester" class="form-label">Semester</label>
                <input type="text" class="form-control" id="Semester" name="Semester" required>
            </div>
            <div class="mb-3">
                <label for="Mark" class="form-label">Mark</label>
                <input type="number" class="form-control" id="Mark" name="Mark" required>
            </div>
            <div class="mb-3">
                <label for="Grade" class="form-label">Grade</label>
                <input type="text" class="form-control" id="Grade" name="Grade" required>
            </div>
            <button type="submit" class="btn btn-success">Add Student Attempt</button>
        </form>

        <!-- Student Attempt Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Program ID</th>
                    <th>Course ID</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["TSID"] . "</td>
                                <td>" . $row["TPID"] . "</td>
                                <td>" . $row["TCID"] . "</td>
                                <td>" . $row["YEAR"] . "</td>
                                <td>" . $row["Semester"] . "</td>
                                <td>" . $row["Mark"] . "</td>
                                <td>" . $row["Grade"] . "</td>
                                <td>
                                    <a href='update_student_attempt.php?id=" . $row["TSID"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_student_attempt.php?id=" . $row["TSID"] . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No records found</td></tr>";
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
