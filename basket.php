<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Book Details</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <style>
        .book-item {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            background-color: #f9f9f9;
        }

        .book-photo {
            height: 120px;
            width: 100px;
            background-color: #ffffeb;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #888;
            font-size: 14px;
            border-radius: 5px;
        }

        .book-details {
            flex: 1;
            padding-left: 15px;
        }

        .action-buttons button {
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include 'reusables/navbar.php'; ?>
    <?php
    if (session_status() === PHP_SESSION_NONE) { //prevent double session start
        session_start();
    }

    // Include database configuration
    include 'scripts/db_config.php';

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect unauthenticated users to the login page
        header("Location: login.php");
        exit();
    }

    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Connect to the database
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("<p class='text-danger'>Database connection failed: " . $conn->connect_error . "</p>");
    }

    // Fetch items in the basket for the logged-in user
    $sql = "SELECT b.book_id, b.book_name, a.auth_name, l.language_name 
        FROM basket_items bi
        JOIN basket ba ON bi.basket_id = ba.basket_id
        JOIN books b ON bi.book_id = b.book_id
        JOIN author a ON b.auth_id = a.auth_id
        JOIN language l ON b.language_id = l.language_id
        WHERE ba.user_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("<p class='text-danger'>Failed to prepare query: " . $conn->error . "</p>");
    }
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    ?>

    <main class="container mt-4">
        <h1 class="mb-4">Basket</h1>
        <div id="basket-list">
            <?php
            // Display basket items or a message if the basket is empty
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="book-item">
                        <div class="book-photo">
                            <img src="images/book-minimalistic-d.svg" alt="<?= htmlspecialchars($row['book_name']) ?>"
                                style="max-height: 100%; max-width: 100%; border-radius: 5px;">
                        </div>
                        <div class="book-details">
                            <h4><?= htmlspecialchars($row['book_name']) ?></h4>
                            <p><strong>Author:</strong> <?= htmlspecialchars($row['auth_name']) ?></p>
                            <p><strong>Language:</strong> <?= htmlspecialchars($row['language_name']) ?></p>
                        </div>
                        <div class="action-buttons">
                            <form method="POST" action="scripts/remove_from_basket.php" style="margin-bottom: 10px;">
                                <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                            <form method="POST">
                                <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm" onclick="purchaseAlert()">Purchase</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Your basket is empty.</p>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </div>
    </main>
    <?php include 'reusables/footer.php'; ?>
    <script>
        function purchaseAlert() {
            alert("purchase not implemented yet");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>