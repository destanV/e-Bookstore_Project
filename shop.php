<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>E-bookstore</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom Styling for Book Items */
        .book-item {
            margin-bottom: 30px; /* Add space between items */
            padding: 15px;
            border: 1px solid #ddd; /* Optional: Add border to book items */
            border-radius: 5px; /* Optional: Rounded corners for book items */
        }

        .book-photo {
            height: 120px;
            background-color: #f4f4f4;
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

        .container {
            margin-top: 30px; /* Space above the book list */
        }
    </style>
</head>
<body>

    <?php include 'reusables/navbar.php'; ?>

    <main>
        <?php include 'reusables/searchbar copy.php'; ?>

        <div class="container">
            <h1 class="mb-4">Shop Page</h1>

            <!-- Example Book Items Container -->
            <div id="book-list">
                <!-- Book Items Will Be Inserted Dynamically -->
            </div>
        </div>
    </main>

    <?php include 'reusables/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- JavaScript Logic -->
    <script>
        // Mock Data: Replace with data fetched from your database
        const books = [
            {
                id: 1,
                name: "Book 1",
                author: "Author 1",
                language: "English",
                genre: "Fiction",
                pages: 300,
                photo: "images/book-minimalistic-d.svg"
            },
            {
                id: 2,
                name: "Book 2",
                author: "Author 2",
                language: "Turkish",
                genre: "Mystery",
                pages: 250,
                photo: ""
            },
            {
                id: 3,
                name: "Book 3",
                author: "Author 3",
                language: "Russian",
                genre: "Science Fiction",
                pages: 400,
                photo: ""
            }
        ];

        // Function to Render Books
        function renderBooks() {
            const bookList = document.getElementById("book-list");
            bookList.innerHTML = ""; // Clear existing items

            books.forEach((book) => {
                // Create Book Item Container
                const bookItem = document.createElement("div");
                bookItem.classList.add("row", "book-item");
               
                // Book Photo
                const photoCol = document.createElement("div");
                photoCol.classList.add("col-md-2");

                if (book.photo && book.photo.trim() !== "") {
                    const img = document.createElement("img");
                    img.src = book.photo; // Set photo source
                    img.alt = book.name; // Set alt text for accessibility
                    img.classList.add("img-fluid"); // Responsive image
                    img.style.maxHeight = "120px"; // Optional: Limit height
                    photoCol.appendChild(img);
                } else {
                    const photoDiv = document.createElement("div");
                    photoDiv.classList.add("book-photo", "d-flex", "align-items-center", "justify-content-center");
                    photoDiv.textContent = "No Photo Available"; // Placeholder
                    photoCol.appendChild(photoDiv);
                }

                // Book Details
                const detailsCol = document.createElement("div");
                detailsCol.classList.add("col-md-8", "book-details");
                detailsCol.innerHTML = `
                    <h5>${book.name}</h5>
                    <p><strong>Author:</strong> ${book.author}</p>
                    <p><strong>Language:</strong> ${book.language}</p>
                    <p><strong>Genre:</strong> ${book.genre}</p>
                    <p><strong>Pages:</strong> ${book.pages}</p>
                `;

                // Action Buttons
                const actionCol = document.createElement("div");
                actionCol.classList.add("col-md-2", "action-buttons");
                actionCol.innerHTML = `
                    <button class="btn btn-primary btn-sm mb-2" onclick="addToBasket(${book.id})">
                        <i class="bi bi-cart-plus"></i> Add to Basket
                    </button>
                    <button class="btn btn-secondary btn-sm" onclick="addToWishlist(${book.id})">
                        <i class="bi bi-heart"></i> Add to Wishlist
                    </button>
                `;

                // Append Columns to Book Item
                bookItem.appendChild(photoCol);
                bookItem.appendChild(detailsCol);
                bookItem.appendChild(actionCol);

                // Append Book Item to List
                bookList.appendChild(bookItem);
            });
        }

        // Function to Handle Add to Basket
        function addToBasket(bookId) {
            alert(`Book with ID ${bookId} added to Basket!`);
        }

        // Function to Handle Add to Wishlist
        function addToWishlist(bookId) {
            alert(`Book with ID ${bookId} added to Wishlist!`);
        }

        // Render Books on Page Load
        renderBooks();
    </script>

</body>
</html>


