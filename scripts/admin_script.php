<?php
if (session_status() === PHP_SESSION_NONE) { //prevent double session start
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
        // Validate year: ensure it is a 4-digit number
        if (is_numeric($year) && strlen($year) == 4 && $year >= 1000 && $year <= 9999) {
            // Year is valid
        } else {
            // If year is invalid, set default to current year
            $year = date('Y');  // Use the current year
        }

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
        $genreSelectStatement = $mysqli->prepare("SELECT genre_id FROM genres WHERE genre_name = ? ");
        $genreSelectStatement->bind_param("s", $genre);
        $genreSelectStatement->execute();
        $genreCheckResult = $genreSelectStatement->get_result();

        if ($row = $genreCheckResult->fetch_assoc()) {
            $genre_id = $row['genre_id'];
        } else {
            $genreInsertStatement = $mysqli->prepare("
                INSERT INTO genres (genre_name)
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
    
} //handle delete book
else if (isset($_POST['delete_book'])) {
    $book_id = intval($_POST['book_id']); //
    $stmt = $mysqli->prepare("DELETE FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $stmt->close();

    echo "<script>
            alert('Book with ID {$book_id} has been deleted.');
            window.location.href = 'admin_page.php';
          </script>";
}

$mysqli->close();
?>
