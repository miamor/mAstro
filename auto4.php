<?php
// example of how to use basic selector to retrieve HTML contents
include('include/simple_html_dom.php');
 
echo file_get_contents('http://www.google.com/')->plaintext;

$html = file_get_contents('https://www.w3schools.com/jsref/dom_obj_select.asp');
//echo $html;

$classname = 'w3-example';
$dom = new DOMDocument;
$dom->loadHTML($html);
$xpath = new DOMXPath($dom);
$results = $xpath->query("//*[@class='" . $classname . "']");

if ($results->length > 0) {
    echo $review = $results->item(0)->nodeValue;
}
