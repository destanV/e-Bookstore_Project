<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Log in</title>
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
<script>
    function validate() {
        var first = document.getElementById('password').value;
        var second = document.getElementById('repeat').value;
        if (first !== second) {
            document.getElementById('ismatching').innerText = "Passwords do not match";
            return false;
        }
        else if (first.length < 8 && first) { document.getElementById('ismatching').innerText = "Password must be at least 8 characters"; }
        else {
            document.getElementById('ismatching').innerText = "";
            return true;

        }
    }
</script>

<body>
    <?php include 'reusables/navbar.php'; ?>
    <main>
        <main>
            <div class="container pb-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-header text-center bg-dark text-white">
                                <h3>Sign Up</h3>
                            </div>
                            <div class="card-body">
                                <form action="process_reg.php" method="POST">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="text" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            oninput="validate()" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Repeat Password</label>
                                        <input type="password" class="form-control" id="repeat" name="repeat"
                                            oninput="validate()" required>
                                    </div>
                                    <div class="mb-3 text-danger text-center" id="ismatching"
                                        style="min-height: 1.5em; line-height: 1.5;">
                                        <label for="ismatching" class="form-label"></label>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Create Account</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </main>

    <?php include 'reusables/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>