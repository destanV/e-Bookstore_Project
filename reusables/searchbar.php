
 <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <form>
          <!-- Search Bar -->
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="search-input" placeholder="Search by title..." aria-label="Search">
            <button type="button" class="btn btn-primary" id="search-button">
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
                  <input type="text" class="form-control" id="author-name" placeholder="Author name..." aria-label="Author Name ">
                </div>

                <!-- Language Dropdown -->
                <div class="col-md-4">
                  <select class="form-select" id="language-filter">
                    <option value="" selected>Choose Language</option>
                    <option value="English">English</option>
                    <option value="Turkish">Turkish</option>
                    <option value="Russian">Russian</option>
                    <option value="Spanich">Spanich</option>
                
                  </select>
                </div>

                <!-- Number of Pages (Range) -->
                <div class="col-md-4">
                  <div class="row g-2">
                    <div class="col-6">
                      <input type="number" class="form-control" id="min-pages" placeholder="Min pages" aria-label="Min Pages">
                    </div>
                    <div class="col-6">
                      <input type="number" class="form-control" id="max-pages" placeholder="Max pages" aria-label="Max Pages">
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JavaScript Logic -->
  <script>
    document.getElementById('search-button').addEventListener('click', function () {
      const searchQuery = document.getElementById('search-input').value;
      const authorName = document.getElementById('author-name').value;
      const language = document.getElementById('language-filter').value;
      const minPages = document.getElementById('min-pages').value;
      const maxPages = document.getElementById('max-pages').value;

      if (!searchQuery) {
        alert('Please enter a search term.');
        return;
      }

      let message = `Searching for: "${searchQuery}"`;
      if (authorName) message += ` by author: "${authorName}"`;
      if (language) message += ` in language: "${language}"`;
      if (minPages || maxPages) {
        message += ` with pages between ${minPages || "any"} and ${maxPages || "any"}`;
      }

      alert(message);

      
    });
  </script>
</body>



