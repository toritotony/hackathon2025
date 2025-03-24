<!-- This file is underdevelopment and not working -->

<?php
require_once("../conn.php");
$conn = hum_conn_no_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and trim user input
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $errors = [];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }
    if (empty($password)) {
        $errors[] = "Password is required.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        // Hash the password using the default algorithm (bcrypt)
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database using a prepared statement
        try {
            $stmt = $conn->prepare("INSERT INTO users (username, password_hash, created_at) VALUES (:username, :password_hash, NOW())");
            $stmt->execute([
                ':username'      => $username,
                ':password_hash' => $passwordHash
            ]);
            echo "<h2>Registration Successful!</h2>";
            echo "<p>Username: " . htmlspecialchars($username) . "</p>";
            // In production, you would redirect to another page
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry code (may vary by DB)
                $errors[] = "Username already exists. Please choose another.";
            } else {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <?php
    // Display errors if any
    if (!empty($errors)) {
        echo '<ul style="color: red;">';
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo '</ul>';
    }
    ?>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>
        <br><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter password" required>
        <br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
