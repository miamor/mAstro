<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author  Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

require_once(dirname(__FILE__).'/../html2pdf.class.php');

// get the HTML
$content = file_get_contents(dirname(__FILE__).'/../_tcpdf_'.HTML2PDF_USED_TCPDF_VERSION.'/cache/utf8test.txt');
$content = '<page backtop="15mm" backbottom="15mm" backleft="20mm" backright="20mm" style="font-family: freeserif;font-size:14px;line-height:25px"><br />'.nl2br($content).'</page>';
//$content = nl2br($content);

// convert to PDF
try {
	$html2pdf = new HTML2PDF('P', 'A4', 'fr');
	$html2pdf->pdf->SetDisplayMode('real');
	$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	$html2pdf->Output('utf8.pdf');
}
catch(HTML2PDF_exception $e) {
	echo $e;
	exit;
}
