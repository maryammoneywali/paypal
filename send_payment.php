<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sender = $_SESSION['user'];
    $receiver = $_POST['receiver'];
    $amount = $_POST['amount'];

    $senderData = $conn->query("SELECT * FROM users WHERE email='$sender'")->fetch_assoc();
    $receiverData = $conn->query("SELECT * FROM users WHERE email='$receiver'")->fetch_assoc();

    if (!$receiverData) {
        echo "<script>alert('Recipient not found'); window.location='dashboard.php';</script>";
        exit;
    }

    if ($senderData['balance'] < $amount) {
        echo "<script>alert('Insufficient balance'); window.location='dashboard.php';</script>";
        exit;
    }

    $conn->query("UPDATE users SET balance = balance - $amount WHERE email='$sender'");
    $conn->query("UPDATE users SET balance = balance + $amount WHERE email='$receiver'");
    $conn->query("INSERT INTO transactions (sender_email, receiver_email, amount) VALUES ('$sender', '$receiver', '$amount')");

    echo "<script>alert('Payment successful'); window.location='dashboard.php';</script>";
}
?>
