<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.html");
    exit();
}

$servername = "localhost";
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "Lab_5b";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET name='$name', role='$role' WHERE matric='$matric'";

    if ($conn->query($sql) === TRUE) {
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    $matric = $_GET['matric'];
    $sql = "SELECT * FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html>
        <head>

            <title>Update User</title>
            <link rel="stylesheet" type="text/css" href="style.css">

        </head>
        <body>
            <h2>Update User</h2>
            <form action="update_user.php" method="POST">
                <label for="matric">Matric:</label>
                <input type="text" id="matric" name="matric" value="<?php echo $row['matric']; ?>" readonly><br><br>
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>
                
                <label for="role">Access Level:</label>
                <input type="text" id="role" name="role" value="<?php echo $row['role']; ?>" required><br><br>
                
                <input type="submit" value="Update">
                <a href="display_users.php">Cancel</a>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "No record found.";
    }

    $conn->close();
}
?>
