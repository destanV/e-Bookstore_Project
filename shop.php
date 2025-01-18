<?php
// Database connection
$db_host = 'localhost'; 
$db_user = 'ewb_user';           
$db_pass = 'abc1';
$db_name = 'ewb';               

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch books with author and language details
$query = "SELECT books.book_id, books.book_name, books.numberOfPages, 
          author.auth_name, language.language_name 
          FROM books 
          LEFT JOIN author ON books.auth_id = author.auth_id
          LEFT JOIN language ON books.language_id = language.language_id"; // Join with language table

$result = $conn->query($query);

// Check if we got the result
if ($result && $result->num_rows > 0) {
    $books_from_db = [];
    while ($book = $result->fetch_assoc()) {
        // Store each book along with the author name and language name
        $books_from_db[] = [
            'id' => $book['book_id'],
            'name' => $book['book_name'],
            'author' => $book['auth_name'],  // Get author name
            'language' => $book['language_name'],  // Get language name
            'pages' => $book['numberOfPages'],
            'photo' => 'images/book-minimalistic-d.svg'  // Placeholder photo
        ];
    }
} else {
    // If no books are found, provide a fallback (empty array)
    $books_from_db = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<title>Shop</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
<link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
    rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<style>
    .book-item {
        margin-bottom: 30px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .book-photo {
        height: 120px;
        background-color: #ffffeb;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #888;
        font-size: 14px;
    }

    .book-details {
        padding-left: 15px;
    }

    .action-buttons button {
        width: 100%;
        margin-bottom: 10px;
    }
</style>
<link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'reusables/navbar.php'; ?>

    <main>
        <?php include 'reusables/searchbar.php'; ?>

        <div class="container bg-cream" style="margin-top:3rem;">
            <h1 class="mb-4">Shop Page</h1>
            <div id="book-list">
                <?php 
                // Render the books (fetched from the database)
                foreach ($books_from_db as $book): ?>
                    <div class="row book-item">
                        <div class="col-md-2">
                            <?php if (!empty($book['photo'])): ?>
                                <img src="<?= $book['photo'] ?>" alt="<?= htmlspecialchars($book['name']) ?>" class="img-fluid" style="max-height: 120px;">
                            <?php else: ?>
                                <div class="book-photo">No Photo Available</div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-8 book-details">
                            <h4><a href="bookdetails.php?name=<?= urlencode($book['name']) ?>&author=<?= urlencode($book['author']) ?>&language=<?= urlencode($book['language']) ?>&pages=<?= $book['pages'] ?>&photo=<?= urlencode($book['photo']) ?>"><?= htmlspecialchars($book['name']) ?></a></h4>
                            <p>Author: <?= htmlspecialchars($book['author']) ?></p>
                            <p>Language: <?= htmlspecialchars($book['language']) ?></p>
                            <p>Pages: <?= htmlspecialchars($book['pages']) ?></p>
                        </div>

                        <div class="col-md-2 action-buttons">
                            <button class="btn btn-primary btn-sm mb-2" onclick="addToBasket(<?= $book['id'] ?>)">
                                <i class="bi bi-cart-plus"></i> Add to Basket
                            </button>
                            <button class="btn btn-secondary btn-sm" onclick="addToWishlist(<?= $book['id'] ?>)">
                                <i class="bi bi-heart"></i> Add to Wishlist
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php include 'reusables/footer.php'; ?>

    <script>
        function addToBasket(bookId) {
            alert(`Book with ID ${bookId} added to Basket!`);
        }

        function addToWishlist(bookId) {
            alert(`Book with ID ${bookId} added to Wishlist!`);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
