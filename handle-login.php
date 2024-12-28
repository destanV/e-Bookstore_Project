<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_config.php';

    // Establish database connection
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve and sanitize user inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE username = ?";
    $query = $conn->prepare($sql);
    $query->bind_param('s', $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password (assuming hashed passwords)
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location: index.php');
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Invalid username. Please try again.'); window.history.back();</script>";
    }

    // Close connections
    $query->close();
    $conn->close();
} else {
    // Redirect if not POST request
    header('Location: login.php');
    exit();
}
?>
