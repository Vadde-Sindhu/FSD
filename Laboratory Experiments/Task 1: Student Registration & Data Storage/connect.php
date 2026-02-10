<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$conn = new mysqli("localhost", "root", "", "student_db");
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
echo "Page reached<br>";   // DEBUG LINE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Form submitted<br>";  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $sql = "INSERT INTO students (name, email, dob, department, phone)
            VALUES ('$name', '$email', '$dob', '$department', '$phone')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration Successful! <br><a href="View.php">View Students</a>";
    } else {
        echo "Database Error: " . $conn->error;
    }
} else {
    echo "Form NOT submitted";
}
$conn->close();
?>
