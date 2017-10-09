<?php
error_reporting(E_ERROR | E_PARSE);

// Optionally define the filesystem path to your system fonts
// otherwise tFPDF will use [path to tFPDF]/font/unifont/ directory
// define("_SYSTEM_TTFONTS", "C:/Windows/Fonts/");

define('MAIN_PATH', 'E:\Devs\xampp\htdocs\astro');
require('tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();

// Add a Unicode font (uses UTF-8)
$pdf->AddFont('DejaVu','','elle-futura-book.ttf',true);
$pdf->SetFont('DejaVu','',14);

// Load a UTF-8 string from a file and print it
//$txt = file_get_contents('HelloWorld.txt');
$txt = 'English: Hello World
Greek: Γειά σου κόσμος
Polish: Witaj świecie
Portuguese: Olá mundo
Russian: Здравствулте мир
Vietnamese: Xin chào thế giới';
$pdf->Write(8,$txt);

// Select a standard font (uses windows-1252)
$pdf->SetFont('Arial','',14);
$pdf->Ln(10);
$pdf->Write(5,'The file size of this PDF is only 12 KB.');

$pdf->Output();
?>
