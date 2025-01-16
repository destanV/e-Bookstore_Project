<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Assuming you have a function to fetch user info from the database (replace this with your actual DB query)
$user = [
    'username' => $_SESSION['username'],
    'email' => 'user@example.com', // Replace with actual database query
   
];

// Turn off error reporting (useful for production to avoid unwanted output)
error_reporting(0);
ini_set('display_errors', 0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <title>Your Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Apply Montserrat font to the entire navbar including the logo and links */
        body {
            font-family: 'Montserrat', sans-serif;
        }

        /* Navbar Links */
        #nav-links a {
            font-family: 'Montserrat', sans-serif;
            font-weight: 400; /* Regular weight for navbar items */
        }

        /* Make navbar links bold */
        #nav-links a.bold-link {
            font-weight: 700; /* Bold weight for Home, Contact, Profile, Log Out */
        }

        /* Logo */
        .logo {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700; /* Bold for logo */
        }
    </style>
</head>

<body>
    <nav>
        <div class="container">
            <div id="logo-box">
                <a href="index.php" class="logo text-uppercase">E-Bookstore</a>
            </div>
            <div id="nav-links">
                <ul>
                    <li class="nav-item text-uppercase">
                        <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active bold-link' : 'bold-link'; ?>">Home</a>
                    </li>
                    <li class="nav-item text-uppercase">
                        <a href="contact.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active bold-link' : 'bold-link'; ?>">Contact</a>
                    </li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item text-uppercase">
                            <a href="profile.php" class="nav-link bold-link" id="navbarProfile">Profile</a>
                        </li>
                        <li class="nav-item text-uppercase">
                            <a href="scripts/logout.php" class="nav-link bold-link" id="navbarLogout">Log Out</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item text-uppercase">
                            <a href="login.php" class="nav-link" id="navbarLogin">Log In</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="container py-5">
            <h1 class="text-center">Your Profile</h1>

            <!-- Profile Information Section -->
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Welcome <?php echo htmlspecialchars($user['first_name']); ?>!</h3>
                            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'reusables/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
