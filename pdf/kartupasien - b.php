<?php
if (isset($_GET['nomr']) and isset($_GET['nama']) and isset($_GET['alamat']) and isset($_GET['jnskel']) and isset($_GET['tgllahir'])){

session_start();
if (!isset($_SESSION['SES_SIMRS_REG'])){
	die();
}	

error_reporting (E_ALL);  
require('pdfb/pdfb.php');

class PDF extends PDFB {
    function Header() {
    }

    function Footer() {
        //$this->Text(402, 735, "Dynamic PDF: PDFB Library!");
    }

 }

// Create a PDF object and set up the properties
$pdf = new PDF("p", "mm", array(85,54));
$pdf->SetAuthor("PDFB Library");
$pdf->SetTitle("Kartu Pasien");

$pdf->SetFont("Arial", "", 8);
$pdf->SetAutoPageBreak(false);

// Load the base PDF into template
$pdf->setSourceFile("kartu_pasien.pdf");
$tplidx = $pdf->ImportPage(1);

// Add new page & use the base PDF as 
$pdf->AddPage();
$pdf->useTemplate($tplidx);

// Probably load Packing Slip information from a database.
//$pkgslip = rand(1000,9999);

//$pdf->SetLeftMargin(20);
//$pdf->SetRightMargin(15);
//$pdf->Text(5, 28.5, $_GET['NOMR']);
//$pdf->Text(5, 36.5, $_GET['NAMA']);

$jnskel = "Laki-laki";
if(strtoupper($_GET['jnskel'])=="P"){
	$jnskel = "Perempuan";
}

$pdf->Text(32, 23.5, $_GET['nomr']);
$pdf->Text(32, 27.5, $_GET['nama']);
$pdf->Text(32, 31.5, str_replace('/','-',$_GET['tgllahir']));
$pdf->Text(32, 35.5, $jnskel);
$pdf->SetXY(31,37.5);
$pdf->MultiCell(0,2.5,$_GET['alamat'],0,"L");

$filename = str_replace('.','',$_GET['nomr']);
$file = 'barcode/' . $filename . '.jpg';
$barcode_font = 'font/Code39Azalea.ttf';
$plain_font = 'font/arial.ttf';

$width = 113;
$height = 45;

$img = imagecreate($width, $height);
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
imagettftext($img, 28, 0, 5, 40, $black, $barcode_font, '*' . str_replace('.','',$_GET['nomr']) . '*');
//imagettftext($img, 8, 0, 50, 60, $black, $plain_font, $_GET['nomr']);
		
imagejpeg($img, $file, 100);
imagedestroy($img);

$pdf->Image($file, 4, 43, 26, 8);
//$pdf->BarCode(str_replace('.','',$_GET['nomr']), "c39", 1.2,39.5, 30,20, 1, 1, 0.7, 1, "", "PNG");

$pdf->Output();
$pdf->closeParsers();
}
?>