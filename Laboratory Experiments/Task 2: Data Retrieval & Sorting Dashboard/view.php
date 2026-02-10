<?php
$conn = mysqli_connect("localhost", "root", "", "college");
if (!$conn) {
    die("Database connection failed");
}
$sort = $_GET['sort'] ?? 'name';
$dept = $_GET['dept'] ?? '';

$query = "SELECT * FROM students";

if ($dept != '') {
    $query .= " WHERE department='$dept'";
}
if ($sort == 'date') {
    $query .= " ORDER BY join_date DESC";
} else {
    $query .= " ORDER BY name ASC";
}
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
</head>
<body>
<h2>Student Records</h2>
<form method="GET">
    Sort By:
    <select name="sort">
        <option value="name">Name</option>
        <option value="date">Date</option>
    </select>
    Department:
    <select name="dept">
        <option value="">All</option>
        <option value="CSE">CSE</option>
        <option value="ECE">ECE</option>
        <option value="EEE">EEE</option>
    </select>

    <button type="submit">Apply</button>
</form>
<br>
<table border="1">
<tr>
    <th>Name</th>
    <th>Department</th>
    <th>Join Date</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['department']; ?></td>
    <td><?php echo $row['join_date']; ?></td>
</tr>
<?php } ?>
</table>
<h3>Students Count Per Department</h3>

<?php
$countQuery = "SELECT department, COUNT(*) AS total FROM students GROUP BY department";
$countResult = mysqli_query($conn, $countQuery);

while($row = mysqli_fetch_assoc($countResult)) {
    echo $row['department'] . " : " . $row['total'] . "<br>";
}
?>

</body>
</html>
