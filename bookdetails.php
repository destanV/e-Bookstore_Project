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
        body {
            padding-top: 0rem;
        }
        .book-details-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 3rem;
            background-color: #fffccc;
            border-radius: 10px;
            margin-top: 10rem;
            margin-bottom: 11rem;
        }
        .book-photo {
            flex: 1;
            text-align: left;
        }
        .book-photo img {
            max-width: 100%;
            border-radius: 10px;
        }
        .book-info {
            flex: 2;
            padding-left: 2rem;
        }
        .action-buttons {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
        }
        main {
            padding: 2rem;
        }
    </style>
</head>
<body>

    <?php include 'reusables/navbar.php'; ?>

    <main class="container bg-cream">
        <?php
        // Retrieve book details from query parameters
        $book_id = $_GET['id'] ?? '0';
        $book_name = $_GET['name'] ?? 'Unknown Book';
        $author = $_GET['author'] ?? 'Unknown Author';
        $language = $_GET['language'] ?? 'Unknown Language';
        $genre = $_GET['genre'] ?? 'Unknown Genre';
        $pages = $_GET['pages'] ?? 'Unknown Number of Pages';
        $photo = $_GET['photo'] ?? 'images/book-minimalistic-d.svg'; // Default photo
        $year = $_GET['year'] ?? "unknown year";
        ?>

        <h1>Book Details</h1>
        <div class="book-details-container">
            <!-- Book Photo -->
            <div class="book-photo">
                <img src="<?= htmlspecialchars($photo) ?>" alt="<?= htmlspecialchars($book_name) ?>">
            </div>

            <!-- Book Info -->
            <div class="book-info">
                <h2><?= htmlspecialchars($book_name) ?></h2>
                <p><strong>Author:</strong> <?= htmlspecialchars($author) ?></p>
                <p><strong>Language:</strong> <?= htmlspecialchars($language) ?></p>
                <p><strong>Genre:</strong> <?= htmlspecialchars($genre) ?></p>
                <p><strong>Number of Pages:</strong> <?= htmlspecialchars($pages) ?></p>
                <div class="action-buttons">
                    <button type="button" class="btn btn-primary" onclick="addToBasket(<?= htmlspecialchars($book_id) ?>)">
                        <i class="bi bi-cart-plus"></i> Add to Basket
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="addToWishlist(<?= htmlspecialchars($book_id) ?>)">
                        <i class="bi bi-heart"></i> Add to Wishlist
                    </button>
                </div>
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
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
</body>
</html>