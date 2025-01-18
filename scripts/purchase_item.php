<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = $_POST['book_id'];

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the basket and purchase records exist
$conn->begin_transaction();

try {
    // Remove item from the basket
    $delete_sql = "DELETE bi FROM basket_items bi
                   JOIN basket ba ON bi.basket_id = ba.basket_id
                   WHERE ba.user_id = ? AND bi.book_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param('ii', $user_id, $book_id);
    $stmt->execute();

    // Add item to purchases
    $insert_sql = "INSERT INTO purchase_items (purchase_id, book_id) 
                   SELECT p.purchase_id, ? FROM purchase p WHERE p.user_id = ?";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param('ii', $book_id, $user_id);
    $stmt->execute();

    $conn->commit();
    header("Location: purchases.php");
} catch (Exception $e) {
    $conn->rollback();
    echo "Error processing purchase: " . $e->getMessage();
}

$stmt->close();
$conn->close();
?>