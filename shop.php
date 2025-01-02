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
      rel="stylesheet"
    />
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
            <div id="book-list"></div>
        </div>
    </main>

    <?php include 'reusables/footer.php'; ?>

   
    
    <script>
        var books = [
            {
                id: 1,
                name: " Book 1",
                author: " Author 1",
                language: "",
                genre: "",
                pages: 300,
                photo: "images/book-minimalistic-d.svg"
            },
            {
                id: 2,
                name: " Book 2",
                author: " Author 2 ",
                language: "",
                genre: "",
                pages: 250,
                photo: "images/book-minimalistic-d.svg"
            },
            {
                id: 3,
                name: " Book 3",
                author: " Author 3",
                language: "",
                genre: " ",
                pages: 400,
                photo: "images/book-minimalistic-d.svg"
            }
        ];

        function renderBooks() {
            const bookList = document.getElementById("book-list");
            bookList.innerHTML = ""; 

            books.forEach((book) => {
                const bookItem = document.createElement("div");
                bookItem.classList.add("row", "book-item");
               
                const photoCol = document.createElement("div");
                photoCol.classList.add("col-md-2");

                if (book.photo && book.photo.trim() !== "") {
                    const img = document.createElement("img");
                    img.src = book.photo;
                    img.alt = book.name;
                    img.classList.add("img-fluid");
                    img.style.maxHeight = "120px";
                    photoCol.appendChild(img);
                } else {
                    const photoDiv = document.createElement("div");
                    photoDiv.classList.add("book-photo");
                    photoDiv.textContent = "No Photo Available";
                    photoCol.appendChild(photoDiv);
                }

                const detailsCol = document.createElement("div");
                detailsCol.classList.add("col-md-8", "book-details");
                detailsCol.innerHTML = `
                    <h4>${book.name}</h4>
                    <p>${book.author}</p>
                    
                `;

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

                bookItem.appendChild(photoCol);
                bookItem.appendChild(detailsCol);
                bookItem.appendChild(actionCol);

                bookList.appendChild(bookItem);
            });
        }

        function addToBasket(bookId) {
            alert(`Book with ID ${bookId} added to Basket!`);
        }

        function addToWishlist(bookId) {
            alert(`Book with ID ${bookId} added to Wishlist!`);
        }

        renderBooks();
    </script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>



