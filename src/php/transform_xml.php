<?php
/**
 * Utility function to transform the books XML into HTML using XSLT.
 * Returns the transformed HTML string.
 */
function renderBooksTable(): string
{
    $xmlPath = realpath(__DIR__ . '/../xml/books.xml');
    $xslPath = realpath(__DIR__ . '/../xslt/books_to_html.xslt');

    if (!file_exists($xmlPath) || !file_exists($xslPath)) {
        return '<p>Could not find XML or XSL files.</p>';
    }

    $xml = new DOMDocument;
    $xml->load($xmlPath);
    $xsl = new DOMDocument;
    $xsl->load($xslPath);

    $proc = new XSLTProcessor;
    $proc->importStylesheet($xsl);
    $html = $proc->transformToXML($xml);
    return $html ?: '<p>Error generating table.</p>';
}
?>
