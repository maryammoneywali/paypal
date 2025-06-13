<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            echo "<script>alert('Login successful!'); window.location='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('User not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - PayClone</title>
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
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #FFEB3B; /* Bright lemon yellow */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
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
            background: #FFF176;
            color: #333;
        }

        button {
            background: #F57F17;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #E65100;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Login</h2>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>

</body>
</html>
