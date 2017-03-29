<?php
$doc = new DOMDocument();
$doc->load( 'books.xml');
$xpath = new DOMXPath($doc);
$arts = $xpath->query("/books/book/author");

foreach ($arts as $art)
{
echo $art->nodeValue."";
}
$arts = $xpath->query("/books/book/title");

foreach ($arts as $art)
{
echo $art->nodeValue."";
}
?>
