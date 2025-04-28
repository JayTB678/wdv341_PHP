<?php
session_start();
require 'dbConnect.php';

$username = $password = "";
$loginError = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        $sql = "SELECT event_user_password FROM event_user WHERE event_user_name = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if($password === $row['event_user_password']) {
                $_SESSION['validUser'] = "yes";
                $_SESSION['username'] = $username;
                header("Location: homepage.php");
                exit();
            } else {
                $loginError = "Invalid username or password.";
            }
        } else {
            $loginError = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        $loginError = "Error : " . $e ->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h2>Event Admin Login</h2>

    <?php
    if ($loginError) {
        echo "<p style='color:red;'>$loginError</p>";
    }
    ?>

    <form method="post" action="login.php">
        <label for="username">Username:</label><br>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>