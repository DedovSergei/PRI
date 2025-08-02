document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const resultsContainer = document.getElementById('results');
    let allBooks = [];

    // Fetch books from API
    fetch('/api/books.php')
        .then(response => response.json())
        .then(data => {
            allBooks = data;
            renderTable(allBooks);
        })
        .catch(err => {
            console.error('Error fetching books:', err);
            resultsContainer.innerHTML = '<p>Error loading books.</p>';
        });

    // Listen for input to filter results
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        const filtered = allBooks.filter(book =>
            book.title.toLowerCase().includes(query) ||
            book.author.toLowerCase().includes(query)
        );
        renderTable(filtered);
    });

    function renderTable(books) {
        if (books.length === 0) {
            resultsContainer.innerHTML = '<p>No matching books found.</p>';
            return;
        }
        let html = '<table class="book-table"><thead><tr>' +
            '<th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>Genre</th><th>Summary</th><th>Actions</th>' +
            '</tr></thead><tbody>';
        books.forEach(book => {
            html += `<tr>` +
                `<td>${book.id}</td>` +
                `<td>${escapeHtml(book.title)}</td>` +
                `<td>${escapeHtml(book.author)}</td>` +
                `<td>${book.publication_year}</td>` +
                `<td>${escapeHtml(book.genre)}</td>` +
                `<td>${escapeHtml(book.summary ?? '')}</td>` +
                `<td><a href="/edit.php?id=${book.id}">Edit</a></td>` +
                `</tr>`;
        });
        html += '</tbody></table>';
        resultsContainer.innerHTML = html;
    }

    // Escape HTML to prevent XSS
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
});
