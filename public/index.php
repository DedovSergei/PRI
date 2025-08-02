<?php
// List view page - displays all books using the XML/XSLT transformation

// Generate the latest XML file; suppress direct output
ob_start();
require_once __DIR__ . '/../php/generate_xml.php';
ob_end_clean();

require_once __DIR__ . '/../php/transform_xml.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="nav">
        <a href="/index.php">Home</a>
        <a href="/create.php">Add Book</a>
        <a href="/filter.php">Filter/Search</a>
    </nav>

    <h1>All Books</h1>

    <?php
    echo renderBooksTable();
    ?>
</body>
</html>
