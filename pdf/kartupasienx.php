<?php
if (isset($_GET['nomr']) and isset($_GET['nama']) and isset($_GET['alamat']) and isset($_GET['jnskel']) and isset($_GET['tgllahir'])){
	
session_start();
if (!isset($_SESSION['SES_SIMRS_REG'])){
	die();
}	
	
	error_reporting(E_ALL);
	//create barcode
	require('barcode/barcode.inc.php');

	$barcode = new BARCODE();
	
	if($barcode == false)
		die($barcode->error());

	$barnumber = str_replace('.','',$_GET['nomr']);
	$barcode->setSymblogy('CODE93');
	$barcode->setHeight(50);
	$barcode->setFont('Arial');
	$barcode->setScale(2);
	$barcode->setHexColor('#000000','#FFFFFF');

	$return = $barcode->genBarCode($barnumber,'png','barcode/' . $barnumber);
	if($return == false)
		$barcode->error(true);
		
	//create pdf	
	require('pdfb/pdfb.php');
	class PDF extends PDFB {
		function Header() {
		}

		function Footer() {
        }
	}

	$pdf = new PDF('p', 'mm', array(85,54));
	$pdf->SetAuthor('PDFB Library');
	$pdf->SetTitle('Kartu Pasien');

	$pdf->SetFont('Arial', 'b', 12);
	$pdf->SetAutoPageBreak(false);

	$pdf->setSourceFile('kartu_pasien_blank.pdf');
	$tplidx = $pdf->ImportPage(1);

	$pdf->AddPage();
	$pdf->useTemplate($tplidx);

	$jnskel = 'Laki-laki';
	if(strtoupper($_GET['jnskel'])=='P') $jnskel = 'Perempuan';

	$pdf->Text(5, 28, $_GET['nama']);
	$pdf->Text(5, 33, $_GET['nomr']);
	
	//$pdf->Text(32, 31.5, $_GET['tgllahir']);
	//$pdf->Text(32, 35.5, $jnskel);
	//$pdf->SetXY(31,37.5);
	//$pdf->MultiCell(0,2.5,$_GET['alamat'],0,"L");

	$pdf->Image('barcode/' . $barnumber . '.png',1,40,45,12,'png','');

	$pdf->Output();
	$pdf->closeParsers();
}	
?>