<?php
session_start();
include 'db_config.php';

// login check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $bookId = $_POST['book_id'];
    $userId = $_SESSION['user_id'];

    // mysql
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //check basket exist for user
    $basketQuery = $conn->prepare("SELECT basket_id FROM basket WHERE user_id = ?");
    if (!$basketQuery) {
        die("error: " . $conn->error);
    }
    $basketQuery->bind_param("i", $userId);
    $basketQuery->execute();
    $basketResult = $basketQuery->get_result(); 

    if ($basketResult->num_rows > 0) {
        $basketRow = $basketResult->fetch_assoc();
        $basketId = $basketRow['basket_id'];
    } else {
        //if no basket exists create one
        $createBasket = $conn->prepare("INSERT INTO basket (user_id) VALUES (?)");
        if (!$createBasket) {
            die("eror: " . $conn->error);
        }
        $createBasket->bind_param("i", $userId);
        $createBasket->execute();
        $basketId = $createBasket->insert_id;
        $createBasket->close();
    }
    $basketQuery->close();

    //insert book basketitems table
    $insertBooktoBasket = $conn->prepare("INSERT INTO basket_items (basket_id, book_id) VALUES (?, ?)");
    if (!$insertBooktoBasket) {
        die("error inserting to basketitems: " . $conn->error);
    }
    $insertBooktoBasket->bind_param("ii", $basketId, $bookId);
    if ($insertBooktoBasket->execute()) {
        echo "<script> 
                alert('Book with ID $bookId has been added to basket');
                window.location.href='../shop.php';
              </script>";
    } else {
        
        echo "<script>
                alert('error: " . $conn->error . "');
                window.location.href='../shop.php';
              </script>";
    }
    $insertBooktoBasket->close();
    $conn->close();

    exit();
} else {
    exit();
}
?>
