<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user'])) {
    echo "<script>alert('Please login first!'); window.location='login.php';</script>";
}

$email = $_SESSION['user'];
$sql = "SELECT * FROM users WHERE email='$email'";
$user = $conn->query($sql)->fetch_assoc();

$transactions = $conn->query("SELECT * FROM transactions WHERE sender_email='$email' OR receiver_email='$email' ORDER BY timestamp DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - PayClone</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #FFF9C4; /* Light lemon yellow */
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #FFEB3B; /* Bright lemon yellow */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
        }

        p {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .balance {
            font-size: 22px;
            font-weight: bold;
            background: #FBC02D;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            color: white;
        }

        form {
            margin-top: 20px;
        }

        input, button {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        input {
            background: #FFF176; /* Slightly darker yellow */
            color: #333;
        }

        button {
            background: #F57F17; /* Orange-yellow */
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #E65100; /* Darker orange */
        }

        h3 {
            margin-top: 30px;
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background: #FFEE58;
            padding: 10px;
            margin: 5px auto;
            border-radius: 5px;
            width: 80%;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Welcome, <?php echo $user['name']; ?></h2>
        <p>Balance:</p>
        <span class="balance">$<?php echo number_format($user['balance'], 2); ?></span>

        <h3>Send Payment</h3>
        <form action="send_payment.php" method="post">
            <input type="email" name="receiver" placeholder="Recipient Email" required>
            <input type="number" name="amount" placeholder="Amount" required>
            <button type="submit">Send Money</button>
        </form>

        <h3>Transaction History</h3>
        <ul>
            <?php while ($tx = $transactions->fetch_assoc()) { ?>
                <li><?php echo $tx['sender_email'] . " sent $" . $tx['amount'] . " to " . $tx['receiver_email']; ?></li>
            <?php } ?>
        </ul>

        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>

</body>
</html>
