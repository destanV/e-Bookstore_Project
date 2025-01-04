<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_config.php'; //setup db credential

    //connect
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
    if (!$conn) {
        die( mysqli_connect_error());}

    //form input into variables
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // search db for the user
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {//check user exist
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user['username']; //start session with 2 variables
        $_SESSION['user_id'] = $user['id'];

        //go to index
        header("Location: ../index.php");
        exit();
    } else {
        echo "<script>alert('Invalid login'); window.history.back();</script>";
    }
    mysqli_close($conn);
}
?>