<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter/Search Books</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="nav">
        <a href="/index.php">Home</a>
        <a href="/create.php">Add Book</a>
        <a href="/filter.php">Filter/Search</a>
    </nav>
    <h1>Search Books</h1>
    <p>Type a title or author to filter the list:</p>
    <input type="text" id="search" placeholder="Search...">
    <div id="results">
        <!-- JS will insert table here -->
    </div>
    <script src="/js/filter.js"></script>
</body>
</html>
