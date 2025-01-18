<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title style="color:05C760">Admin - Manage Books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="style.css">
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
    <?php include 'reusables/navbar.php'; ?>
    <?php include "scripts/admin_script.php"; ?>

    <main class="container py-4" style="padding-top: 120px; margin-top: 140px">
        <h1 class="mb-4 text-center text-green text-uppercase">Admin - Manage Books</h1>
        <div class="row">

            <div class="col-md-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Add a New Book
                    </div>
                    <div class="card-body bg-cream">
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

            <div class="col-md-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white">
                        Delete a Book
                    </div>
                    <div class="card-body bg-cream">
                        <form method="POST" action="admin_page.php" onsubmit="return validateId()">
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

    <?php include 'reusables/footer.php'; ?>

    <script>
        function validateId() {
            const bookIdField = document.getElementById('book_id');
            const bookId = bookIdField.value;

            // Check if the value is a valid integer
            if (!Number.isInteger(Number(bookId))) {
                alert("Please enter a valid integer for the Book ID.");
                return false; // Prevent form submission
            }
            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>