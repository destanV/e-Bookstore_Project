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

// Check if a search query exists
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Sanitize and trim input values from GET request
    $search_query = isset($_GET['search_query']) ? trim(mysqli_real_escape_string($conn, $_GET['search_query'])) : '';

    // Build the SQL query based on search
    $query = "SELECT books.book_id, books.book_name, books.numberOfPages, books.release_year,
              author.auth_name, language.language_name 
              FROM books 
              LEFT JOIN author ON books.auth_id = author.auth_id
              LEFT JOIN language ON books.language_id = language.language_id
              WHERE books.book_name LIKE '%$search_query%'";

    // Execute the query
    $result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));

    // Store the fetched books
    $books_from_db = [];
    while ($book = mysqli_fetch_assoc($result)) {
        $books_from_db[] = [
            'id' => $book['book_id'],
            'name' => $book['book_name'],
            'author' => $book['auth_name'],
            'language' => $book['language_name'],
            'pages' => $book['numberOfPages'],
            'photo' => 'images/book-minimalistic-d.svg',  // Placeholder photo
            'release_year' => $book['release_year']
        ];
    }
} else {
    // If no search query, load all books (same as the original shop)
    $query = "SELECT books.book_id, books.book_name, books.numberOfPages, books.release_year,
              author.auth_name, language.language_name 
              FROM books 
              LEFT JOIN author ON books.auth_id = author.auth_id
              LEFT JOIN language ON books.language_id = language.language_id";

    $result = mysqli_query($conn, $query) or die('Query failed: ' . mysqli_error($conn));
    
    // Store the fetched books
    $books_from_db = [];
    while ($book = mysqli_fetch_assoc($result)) {
        $books_from_db[] = [
            'id' => $book['book_id'],
            'name' => $book['book_name'],
            'author' => $book['auth_name'],
            'language' => $book['language_name'],
            'pages' => $book['numberOfPages'],
            'photo' => 'images/book-minimalistic-d.svg',  // Placeholder photo
            'release_year' => $book['release_year']
        ];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include the font from your previous design -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <style>
        /* Apply the desired font (Montserrat) */
        * {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body>
    <?php include 'reusables/navbar.php'; ?>

    <main>
        <?php include 'reusables/searchbar.php'; ?>

        <div class="container bg-cream" style="margin-top:3rem;">
            <h1 class="mb-4">Shop Page</h1>
            <div id="book-list">
                <?php if (!empty($books_from_db)): ?>
                    <?php foreach ($books_from_db as $book): ?>
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
                                <p>Release Year: <?= htmlspecialchars($book['release_year']) ?></p>
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
                <?php else: ?>
                    <p>No results found!</p>
                <?php endif; ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
