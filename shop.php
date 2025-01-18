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

// Query to fetch books with author, language, and genre details
$query = "SELECT books.book_id, books.book_name, books.numberOfPages, 
          author.auth_name, language.language_name, genres.name AS genre
          FROM books 
          LEFT JOIN author ON books.auth_id = author.auth_id
          LEFT JOIN language ON books.language_id = language.language_id
          LEFT JOIN genres ON books.genre_id = genres.genre_id";

$result = $conn->query($query);

// Check if we got the result
if ($result && $result->num_rows > 0) {
    $books_from_db = [];
    while ($book = $result->fetch_assoc()) {
        // Store each book along with author, language, and genre details
        $books_from_db[] = [
            'id' => $book['book_id'],
            'name' => $book['book_name'],
            'author' => $book['auth_name'],  // Get author name
            'language' => $book['language_name'],  // Get language name
            'pages' => $book['numberOfPages'],
            'photo' => 'images/book-minimalistic-d.svg',  // Placeholder photo
            'genre' => $book['genre']  // Get genre name
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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
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
                // Render the book
                foreach ($books_from_db as $book): ?>
                    <div class="row book-item">
                        <div class="col-md-2">
                            <?php if (!empty($book['photo'])): ?>
                                <img src="<?= htmlspecialchars($book['photo']) ?>" alt="<?= htmlspecialchars($book['name']) ?>"
                                    class="img-fluid" style="max-height: 120px;">
                            <?php else: ?>
                                <div class="book-photo">No Photo Available</div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-8 book-details">
                            <h4>
                                <a href="bookdetails.php?
                                    name=<?= urlencode($book['name']) ?>&
                                    author=<?= urlencode($book['author']) ?>&
                                    language=<?= urlencode($book['language']) ?>&
                                    pages=<?= $book['pages'] ?>&
                                    photo=<?= urlencode($book['photo']) ?>&
                                    genre=<?= urlencode($book['genre']) ?>">
                                    <?= htmlspecialchars($book['name']) ?>
                                </a>
                            </h4>
                            <p>Author: <?= htmlspecialchars($book['author']) ?></p>
                            <p>Language: <?= htmlspecialchars($book['language']) ?></p>
                            <p>Pages: <?= htmlspecialchars($book['pages']) ?></p>
                            <p>Genre: <?= htmlspecialchars($book['genre']) ?></p>
                        </div>
                        <div class="col-md-2 action-buttons">
                            <form method="POST" action="scripts/add2.php">
                                <input type="hidden" name="book_id" value="<?= urlencode($book['id']) ?>">
                                <button type="submit" class="btn btn-primary">Add to Basket</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php include 'reusables/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>