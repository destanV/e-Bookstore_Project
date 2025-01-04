<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_config.php'; 
    // connect to mysql
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
   if(!$conn) {
    die(mysqli_connect_error());
   }
    $username = mysqli_real_escape_string($conn, $_POST["username"]); //escape_string to prevent sql injection
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    //check valid email   
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('bad email'); window.history.back();</script>";
        exit;
    }
    
    //check for duplicate
    $myQuery = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $myQuery);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username or email already'); window.history.back();</script>";
    } else {
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";//insert into db

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
        }
    }

    //close conn
    mysqli_close($conn);
}
?>
