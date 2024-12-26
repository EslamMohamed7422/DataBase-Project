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
    $sql = "SELECT * FROM Student_Enrollement WHERE SID LIKE '%$searchTerm%' OR PID LIKE '%$searchTerm%'";
} else {
    $sql = "SELECT * FROM Student_Enrollement";
}

// Handle Add
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $SID = $_POST['SID'];
    $PID = $_POST['PID'];
    $EID = $_POST['EID'];

    $sql_insert = "INSERT INTO Student_Enrollement (SID, PID, EID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("iii", $SID, $PID, $EID);

    if ($stmt->execute()) {
        header("Location: Student_Enrollement.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $SID = $_GET['SID'];
    $PID = $_GET['PID'];
    $EID = $_GET['EID'];

    $sql_delete = "DELETE FROM Student_Enrollement WHERE SID = ? AND PID = ? AND EID = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("iii", $SID, $PID, $EID);

    if ($stmt->execute()) {
        header("Location: Student_Enrollement.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $SID = $_POST['SID'];
    $PID = $_POST['PID'];
    $EID = $_POST['EID'];
    $SID_old = $_POST['SID_old'];
    $PID_old = $_POST['PID_old'];
    $EID_old = $_POST['EID_old'];

    $sql_update = "UPDATE Student_Enrollement SET SID = ?, PID = ?, EID = ? WHERE SID = ? AND PID = ? AND EID = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("iiiiii", $SID, $PID, $EID, $SID_old, $PID_old, $EID_old);

    if ($stmt->execute()) {
        header("Location: Student_Enrollement.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enrollement Table - University Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Student Enrollement Table</h2>

        <!-- Search Form -->
        <form method="POST" class="mb-3">
            <input type="text" class="form-control" name="searchTerm" placeholder="Search by Student ID or Program ID" value="<?php echo $searchTerm; ?>">
            <button type="submit" name="search" class="btn btn-primary mt-2">Search</button>
        </form>

        <!-- Add Student Enrollement Form -->
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="SID" class="form-label">Student ID</label>
                <input type="number" class="form-control" id="SID" name="SID" required>
            </div>
            <div class="mb-3">
                <label for="PID" class="form-label">Program ID</label>
                <input type="number" class="form-control" id="PID" name="PID" required>
            </div>
            <div class="mb-3">
                <label for="EID" class="form-label">Enrollement ID</label>
                <input type="number" class="form-control" id="EID" name="EID" required>
            </div>
            <button type="submit" name="add" class="btn btn-success">Add Student Enrollement</button>
        </form>

        <!-- Student Enrollement Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Program ID</th>
                    <th>Enrollement ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["SID"] . "</td>
                                <td>" . $row["PID"] . "</td>
                                <td>" . $row["EID"] . "</td>
                                <td>
                                    <a href='Student_Enrollement.php?SID=" . $row["SID"] . "&PID=" . $row["PID"] . "&EID=" . $row["EID"] . "' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='Student_Enrollement.php?delete=true&SID=" . $row["SID"] . "&PID=" . $row["PID"] . "&EID=" . $row["EID"] . "' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Edit Form (if clicked Edit) -->
        <?php
        if (isset($_GET['SID'])) {
            $SID = $_GET['SID'];
            $PID = $_GET['PID'];
            $EID = $_GET['EID'];

            $sql_edit = "SELECT * FROM Student_Enrollement WHERE SID = ? AND PID = ? AND EID = ?";
            $stmt_edit = $conn->prepare($sql_edit);
            $stmt_edit->bind_param("iii", $SID, $PID, $EID);
            $stmt_edit->execute();
            $result_edit = $stmt_edit->get_result();
            $row_edit = $result_edit->fetch_assoc();
        ?>
        
        <h3>Edit Student Enrollement</h3>
        <form method="POST">
            <input type="hidden" name="SID_old" value="<?php echo $row_edit['SID']; ?>">
            <input type="hidden" name="PID_old" value="<?php echo $row_edit['PID']; ?>">
            <input type="hidden" name="EID_old" value="<?php echo $row_edit['EID']; ?>">
            <div class="mb-3">
                <label for="SID" class="form-label">Student ID</label>
                <input type="number" class="form-control" id="SID" name="SID" value="<?php echo $row_edit['SID']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="PID" class="form-label">Program ID</label>
                <input type="number" class="form-control" id="PID" name="PID" value="<?php echo $row_edit['PID']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="EID" class="form-label">Enrollement ID</label>
                <input type="number" class="form-control" id="EID" name="EID" value="<?php echo $row_edit['EID']; ?>" required>
            </div>
            <button type="submit" name="edit" class="btn btn-warning">Update Enrollement</button>
        </form>

        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
