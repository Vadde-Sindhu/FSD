<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "order_management", 3307);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Order Management</title>
<style>
body {
    font-family: Arial;
    background-color: #f4f4f4;
}
h2, h3 {
    text-align: center;
}
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background: white;
}
th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}
th {
    background-color: #007bff;
    color: white;
}
.result-box {
    text-align: center;
    font-size: 18px;
    margin: 10px;
    font-weight: bold;
}
</style>

</head>
<body>
<h2>Customer Order History</h2>
<table>
<tr>
    <th>Name</th>
    <th>Product</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Total</th>
    <th>Date</th>
</tr>
<?php
// JOIN + ORDER BY
$query = "
SELECT c.name, p.product_name, o.quantity, p.price,
(o.quantity * p.price) AS total_amount, o.order_date
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
JOIN products p ON o.product_id = p.product_id
ORDER BY o.order_date DESC
";
$result = mysqli_query($conn, $query);
while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$row['name']}</td>
            <td>{$row['product_name']}</td>
            <td>{$row['quantity']}</td>
            <td>{$row['price']}</td>
            <td>{$row['total_amount']}</td>
            <td>{$row['order_date']}</td>
          </tr>";
}
?>
</table>
<!-- Highest Value Order -->
<h3>Highest Value Order</h3>
<?php
$highestQuery = "
SELECT c.name, p.product_name, (o.quantity * p.price) AS total_amount
FROM orders o
JOIN customers c ON o.customer_id = c.customer_id
JOIN products p ON o.product_id = p.product_id
ORDER BY total_amount DESC
LIMIT 1
";
$highestResult = mysqli_query($conn, $highestQuery);
while($row = mysqli_fetch_assoc($highestResult)) {
    echo "<div class='result-box'>
            {$row['name']} - {$row['product_name']} - ₹{$row['total_amount']}
          </div>";
}
?>
<!-- Most Active Customer -->
<h3>Most Active Customer</h3>
<?php
$activeQuery = "
SELECT c.name, COUNT(o.order_id) AS total_orders
FROM customers c
JOIN orders o ON c.customer_id = o.customer_id
GROUP BY c.customer_id
ORDER BY total_orders DESC
LIMIT 1
";
$activeResult = mysqli_query($conn, $activeQuery);
while($row = mysqli_fetch_assoc($activeResult)) {
    echo "<div class='result-box'>
            {$row['name']} ({$row['total_orders']} orders)
          </div>";
}
?>
</body>
</html>
