<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
//check if admin
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header('Location: index.php');
    exit;
}

// connect
include 'scripts/db_config.php';
$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$mysqli) {
    die(mysqli_connect_error());
}

// handle add book
if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $page = $_POST['pages'];
    $language = $_POST['language'];

    // validate nonempty and prepare mysql insertion
    if (
        !empty($title) &&
        !empty($author) &&
        !empty($year) &&
        !empty($genre) &&
        !empty($page) &&
        !empty($language)
    ) {
        //insert directly into table
        $preparedInsertStatement = $mysqli->prepare("
            INSERT INTO books (book_name, release_year, numberOfPages)
            VALUES (?, ?, ?)
        ");
        $preparedInsertStatement->bind_param("sii", $title, $year, $page);
        $preparedInsertStatement->execute();
        $preparedInsertStatement->close();

        // zurnanin zrt dedigi yer
        $author_id = null;
        $authorSelectStatement = $mysqli->prepare("SELECT auth_id FROM author WHERE auth_name = ? ");
        $authorSelectStatement->bind_param("s", $author);
        $authorSelectStatement->execute();
        $authorCheckResult = $authorSelectStatement->get_result();

        if ($row = $authorCheckResult->fetch_assoc()) {
            // if author exists author_id is existing id
            $author_id = $row['auth_id']; // or 'auth_id' if that's your column name
        } else {
            // if author doesnt exis insert new author into table
            $authorInsertStatement = $mysqli->prepare("
                INSERT INTO author (auth_name)
                VALUES (?)
            ");
            $authorInsertStatement->bind_param("s", $author);
            $authorInsertStatement->execute();
            $author_id = $authorInsertStatement->insert_id; // new auto generated id
            $authorInsertStatement->close();
        }
        $authorSelectStatement->close();

        //------------------------------------------------------
        // handle genre
        $genre_id = null;
        $genreSelectStatement = $mysqli->prepare("SELECT genre_id FROM genres WHERE name = ? ");
        $genreSelectStatement->bind_param("s", $genre);
        $genreSelectStatement->execute();
        $genreCheckResult = $genreSelectStatement->get_result();

        if ($row = $genreCheckResult->fetch_assoc()) {
            $genre_id = $row['genre_id'];
        } else {
            $genreInsertStatement = $mysqli->prepare("
                INSERT INTO genres (name)
                VALUES (?)
            ");
            $genreInsertStatement->bind_param("s", $genre);
            $genreInsertStatement->execute();
            $genre_id = $genreInsertStatement->insert_id; // new auto generated id
            $genreInsertStatement->close();
        }
        $genreSelectStatement->close();

        //----------------------------------------------------------------------------------------
        $language_id = null;
        $languageSelectStatement = $mysqli->prepare("SELECT language_id FROM language WHERE language_name = ? ");
        $languageSelectStatement->bind_param("s", $language);
        $languageSelectStatement->execute();
        $languageCheckResult = $languageSelectStatement->get_result();

        if ($row = $languageCheckResult->fetch_assoc()) {
            $language_id = $row['language_id'];
        } else {
            $languageInsertStatement = $mysqli->prepare("
                INSERT INTO language (language_name)
                VALUES (?)
            ");
            $languageInsertStatement->bind_param("s", $language);
            $languageInsertStatement->execute();
            $language_id = $languageInsertStatement->insert_id; // new auto generated id
            $languageInsertStatement->close();
        }
        $languageSelectStatement->close();


        //yukaridaki belirledigimiz foreign keyleri burada ekliyoruz
        $insertForeignKeys = $mysqli->prepare("UPDATE books SET auth_id = ?, genre_id = ?, language_id = ? WHERE book_name = ?");
        $insertForeignKeys->bind_param("iiis", $author_id, $genre_id, $language_id, $title);
        $insertForeignKeys->execute();
        $insertForeignKeys->close();
    }
}
if (isset($_POST['delete_book'])) {
    $bookId = $_POST['book_id'] ?? '';

    //validate bookid
    if (!empty($bookId) && is_numeric($bookId)) {
        //delete statement
        $deleteStmt = $mysqli->prepare("DELETE FROM books WHERE book_id = ?");
        $deleteStmt->bind_param("i", $bookId);

        if ($deleteStmt->execute()) {
            echo "<p style='color:green;'>Book (ID: $bookId) deleted successfully</p>";
        } else {
            echo "<p style='color:red;'>Error deleting book: ";
        }
        $deleteStmt->close();
    } else {
        echo "<p style='color:red;'>Invalid book id.</p>";
    }
}
$mysqli->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin - Manage Books</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Custom Styles -->
    <link rel="stylesheet" href="style.css">
    <!-- Optional font links (as in your login.php) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Include Navbar (which already handles its session logic) -->
    <?php include 'reusables/navbar.php'; ?>

    <!-- Main Content -->
    <main class="container py-4" style="padding-top: 120px;">
        <h1 class="mb-4 text-center">Admin - Manage Books</h1>
        <div class="row">
            <!-- Add Book Form -->
            <div class="col-md-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Add a New Book
                    </div>
                    <div class="card-body">
                        <form method="POST" action="admin_page.php">
                            <div class="mb-3">
                                <label for="title" class="form-label">Book Title</label>
                                <input type="text" class="form-control" name="title" id="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author Name</label>
                                <input type="text" class="form-control" name="author" id="author" required>
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Release Year</label>
                                <input type="number" class="form-control" name="year" id="year" required>
                            </div>
                            <div class="mb-3">
                                <label for="genre" class="form-label">Genre</label>
                                <input type="text" class="form-control" name="genre" id="genre" required>
                            </div>
                            <div class="mb-3">
                                <label for="pages" class="form-label">Number of Pages</label>
                                <input type="number" class="form-control" name="pages" id="pages" required>
                            </div>
                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" class="form-control" name="language" id="language" required>
                            </div>
                            <button type="submit" name="add_book" class="btn btn-success">Add Book</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Book Form -->
            <div class="col-md-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        Delete a Book
                    </div>
                    <div class="card-body">
                        <form method="POST" action="admin_page.php">
                            <div class="mb-3">
                                <label for="book_id" class="form-label">Book ID to Delete</label>
                                <input type="number" class="form-control" name="book_id" id="book_id" required>
                            </div>
                            <button type="submit" name="delete_book" class="btn btn-danger">Delete Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Footer -->
    <?php include 'reusables/footer.php'; ?>

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>