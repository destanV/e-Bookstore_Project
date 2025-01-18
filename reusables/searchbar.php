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

// Fetch all languages for the dropdown
$language_query = "SELECT language_id, language_name FROM language";
$language_result = mysqli_query($conn, $language_query);
$languages = [];

if (!$language_result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($language_result)) {
    $languages[] = $row;
}

$conn->close();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <form method="GET" action="search.php">
                <!-- Search Bar -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="search-input" name="search_query" placeholder="Search by title..." aria-label="Search">
                    <button type="submit" class="btn btn-primary" id="search-button">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>

                <!-- Filter Options Toggle -->
                <button class="btn filter-button w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                    <i class="bi bi-filter"></i> Filter Options
                </button>

                <!-- Filter Section (Collapsible) -->
                <div class="collapse" id="filterSection">
                    <div class="card card-body">
                        <div class="row g-3">
                            <!-- Author Name Input -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="author-name" name="author_name" placeholder="Author name..." aria-label="Author Name">
                            </div>

                            <!-- Language Dropdown -->
                            <div class="col-md-4">
                                <select class="form-select" id="language-filter" name="language_filter">
                                    <option value="" selected>Choose Language</option>
                                    <?php foreach ($languages as $language): ?>
                                        <option value="<?= $language['language_id'] ?>" <?= isset($_GET['language_filter']) && $_GET['language_filter'] == $language['language_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($language['language_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Number of Pages (Range) -->
                            <div class="col-md-4">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="min-pages" name="min_pages" placeholder="Min pages" aria-label="Min Pages">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control" id="max-pages" name="max_pages" placeholder="Max pages" aria-label="Max Pages">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
