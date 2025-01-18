<?php
session_start();
include 'db_config.php';

//check login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];

//connect db
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// deletefrom basket items
$delQuery = "DELETE bi FROM basket_items bi
        JOIN basket ba ON bi.basket_id = ba.basket_id
        WHERE ba.user_id = ? AND bi.book_id = ?";
$delStatement = $conn->prepare($delQuery);
$delStatement->bind_param('ii', $user_id, $book_id);

if ($delStatement->execute()) {
    $delStatement->close();

    //limit 1 to prevent bugs with multiple baskets
    $basketQuery = $conn->prepare("SELECT basket_id FROM basket WHERE user_id = ? LIMIT 1");
    $basketQuery->bind_param('i', $user_id);
    $basketQuery->execute();
    $basketResult = $basketQuery->get_result();
    //basket result is the active basket of user and basketId is the id of that basket
    if ($basketResult->num_rows > 0) {
        $basketRow = $basketResult->fetch_assoc();
        $basketId = $basketRow['basket_id'];
        $basketQuery->close();
        //how many items in basket?
        //if no items in basket delete it from basket table
        //so the select statement is always 1 row resuslt
        $countQuery = $conn->prepare("SELECT COUNT(*) AS itemCount FROM basket_items WHERE basket_id = ?");
        $countQuery->bind_param('i', $basketId);
        $countQuery->execute();
        $countResult = $countQuery->get_result();
        $countRow = $countResult->fetch_assoc();
        $itemCount = $countRow['itemCount'];
        $countQuery->close();
        if ($itemCount == 0) {
            $deleteBasket = $conn->prepare("DELETE FROM basket WHERE basket_id = ?");
            $deleteBasket->bind_param('i', $basketId);
            $deleteBasket->execute();
            $deleteBasket->close();
        }
    } else {
        // alternative flow falan
        $basketQuery->close();
    }

    header("Location: basket.php");
} else {
    echo "Error removing item: " . $conn->error;
}

$conn->close();
?>
