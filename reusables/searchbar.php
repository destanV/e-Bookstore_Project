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
                                    <option value="4">Turkish</option>
                                    <option value="5">English</option>
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
