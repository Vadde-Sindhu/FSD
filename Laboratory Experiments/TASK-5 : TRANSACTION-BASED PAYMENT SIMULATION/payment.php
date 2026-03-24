<?php
$conn = mysqli_connect("localhost", "root", "", "payment_system", 3307);
if (!$conn) {
    die("Connection failed");
}
$message = "";
if (isset($_POST['pay'])) {
    $user = $_POST['user'];
    $merchant = $_POST['merchant'];
    $amount = $_POST['amount'];
    mysqli_begin_transaction($conn);
    try { 
        mysqli_query($conn, "UPDATE accounts SET balance = balance - $amount WHERE name='$user'");    
        mysqli_query($conn, "UPDATE accounts SET balance = balance + $amount WHERE name='$merchant'");
        mysqli_commit($conn);
        $u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT balance FROM accounts WHERE name='$user'"));
        $m = mysqli_fetch_assoc(mysqli_query($conn, "SELECT balance FROM accounts WHERE name='$merchant'"));

        $message = "success|Payment Successful! Transaction Committed.|$user New Balance: ₹{$u['balance']}|$merchant New Balance: ₹{$m['balance']}";

    } catch (Exception $e) {
        mysqli_rollback($conn);
        $message = "error|Payment Failed! Transaction Rolled Back.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Online Payment</title>
<style>
body {
    font-family: Arial;
    background-color: #f2f2f2;
    text-align: center;
}
.container {
    background: white;
    width: 320px;
    margin: 80px auto;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px gray;
}
select, input {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
}
button {
    width: 100%;
    padding: 10px;
    background: green;
    color: white;
    border: none;
    cursor: pointer;
}
.success {
    color: green;
    margin-top: 10px;
}
.error {
    color: red;
    margin-top: 10px;
}
</style>
</head>
<body>
<div class="container">
<h2>Online Payment</h2>
<form method="POST">
    <!-- USER DROPDOWN -->
    <label>Select User</label>
    <select name="user">
    <?php
    $res = mysqli_query($conn, "SELECT name FROM accounts WHERE name IN ('Ravi','Asha','Neha','Rahul')");
    while($row = mysqli_fetch_assoc($res)) {
        echo "<option>{$row['name']}</option>";
    }
    ?>
    </select>
    <!-- MERCHANT DROPDOWN -->
    <label>Select Merchant</label>
    <select name="merchant">
    <?php
    $res = mysqli_query($conn, "SELECT name FROM accounts WHERE name IN ('Amazon','Flipkart','Swiggy','Zomato')");
    while($row = mysqli_fetch_assoc($res)) {
        echo "<option>{$row['name']}</option>";
    }
    ?>
    </select>
    <label>Enter Amount</label>
    <input type="number" name="amount" required>

    <button name="pay">Pay Now</button>
</form>
<?php
if ($message != "") {
    $parts = explode("|", $message);

    if ($parts[0] == "success") {
        echo "<div class='success'>
                ✔ {$parts[1]}<br>
                {$parts[2]}<br>
                {$parts[3]}
              </div>";
    } else {
        echo "<div class='error'>❌ {$parts[1]}</div>";
    }
}
?>
</div>
</body>
</html>
