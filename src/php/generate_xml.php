<?php
require_once __DIR__ . '/db.php';

/**
 * Script to generate an XML representation of all books in the database.
 * It also validates the generated XML against the XSD schema defined in ../xsd/books.xsd.
 */

$pdo = Database::getConnection();
$stmt = $pdo->query('SELECT id, title, author, publication_year, genre, summary FROM books ORDER BY id');
$books = $stmt->fetchAll();

$dom = new DOMDocument('1.0', 'UTF-8');
$dom->formatOutput = true;
$root = $dom->createElement('books');
$dom->appendChild($root);

foreach ($books as $book) {
    $bookElem = $dom->createElement('book');
    $bookElem->setAttribute('id', (string)$book['id']);
    $title = $dom->createElement('title', htmlspecialchars($book['title']));
    $author = $dom->createElement('author', htmlspecialchars($book['author']));
    $year = $dom->createElement('publicationYear', (string)$book['publication_year']);
    $genre = $dom->createElement('genre', htmlspecialchars($book['genre']));
    $summary = $dom->createElement('summary', htmlspecialchars($book['summary'] ?? ''));

    $bookElem->appendChild($title);
    $bookElem->appendChild($author);
    $bookElem->appendChild($year);
    $bookElem->appendChild($genre);
    if (!empty($book['summary'])) {
        $bookElem->appendChild($summary);
    }

    $root->appendChild($bookElem);
}

// Save generated XML to file inside xml directory
$xmlDir = realpath(__DIR__ . '/../xml');
if (!is_dir($xmlDir)) {
    mkdir($xmlDir, 0755, true);
}
$xmlFile = $xmlDir . '/books.xml';
$dom->save($xmlFile);

// Validate against XSD
$xsdPath = realpath(__DIR__ . '/../xsd/books.xsd');
$isValid = $dom->schemaValidate($xsdPath);

// If this script is accessed directly, output the XML;
// when it’s included (e.g. by index.php), only save & validate.
if (basename($_SERVER['SCRIPT_NAME']) === basename(__FILE__)) {
    header('Content-Type: text/xml; charset=UTF-8');
    if (!$isValid) {
        http_response_code(500);
    }
    echo $dom->saveXML();
}
