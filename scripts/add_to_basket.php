<?php
session_start();
include 'db_config.php';

// login check
if (!isset($_SESSION['user_id'])) {
    //
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_id'])) {
    $bookId = intval($_POST['book_id']);
    $userId = $_SESSION['user_id'];

    //connection mysql
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("connection fail myslq" . $conn->connect_error);
    }
    //prepare query for basket of user
    $basketQuery = $conn->prepare("SELECT basket_id FROM basket WHERE user_id = ?"); 
    $basketQuery->bind_param("i", $userId);
    $basketQuery->execute();
    $basketResult = $basketQuery->get_result(); 

    if ($basketResult->num_rows > 0) {
        $basketRow = $basketResult->fetch_assoc();
        $basketId = $basketRow['basket_id'];
    } else {
        //if no basket exists create basket
        $createBasket = $conn->prepare("INSERT INTO basket (user_id) VALUES (?)");
        $createBasket->bind_param("i", $userId);
        $createBasket->execute();
        $basketId = $createBasket->insert_id;
        $createBasket->close();
    }
    $basketQuery->close();

    // insert book to basket sql
    $insertBooktoBasket = $conn->prepare("INSERT INTO basket_items (basket_id, book_id) VALUES (?, ?)");
    $insertBooktoBasket->bind_param("ii", $basketId, $bookId);
    if ($insertBooktoBasket->execute()) { //js alert for success
        echo "<script> 
                alert('Book with ID $bookId has been added to basket');
                window.location.href='../shop.php';
              </script>";
    } else {
        echo "<script>
                alert('Error occured');
                window.location.href='../shop.php';
              </script>";
    }
    $insertBooktoBasket->close();
    $conn->close();

    header("Location: ../shop.php");
    exit();
} else {
    // The request wasn't valid.
    header("Location: ../index.php");
    exit();
}
?>
