<?php
session_start();

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
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE matric = '$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Successful login
            $_SESSION['loggedin'] = true;
            $_SESSION['matric'] = $matric;
            header("Location: display_users.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid username or password, try <a href='login.html'>login</a> again.";
        }
    } else {
        // Invalid matric
        echo "Invalid username or password, try <a href='login.html'>login</a> again.";
    }
}

$conn->close();
?>
