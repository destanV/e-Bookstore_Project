<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>E-bookstore</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'reusables/navbar.php'; ?>
    <main>
        <header class="bg-dark text-white text-center py-5">
            <h1 class="display-3">Reading Made Easy.</h1>
            <p class="lead">Explore, Discover, and Enjoy Reading with Our Wide Collection of E-books</p>
            <a href="shop.php" class="btn btn-light btn-lg">Browse Books</a>
        </header>

        <div class="container py-5">
            <div class="row">
                <div class="col-md-6">
                    <h1>Welcome to E-Bookstore</h1>
                    <p>Discover your next great read and enjoy a seamless e-book shopping experience!</p>
                    <a href="shop.php" class="btn btn-primary">Browse Books</a>
                    <?php
                    if (isset($_SESSION["role"])) {
                        if ($_SESSION["role"] === "admin") {
                            echo "<a href='admin_page.php' class='btn btn-primary'> Manage Books</a>";
                        }
                    }
                    ?>
                </div>

            </div>


            <section class="bg-light py-5">
                <div class="row">
                    <div class="col">
                        <h2>Why Choose Us?</h2>
                        <p>We offer a wide range of books at affordable prices with excellent
                            customer support.</p>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <?php include 'reusables/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>