<?php
error_reporting (E_ALL);

if (isset($_GET['idx'])){

session_start();
if (!isset($_SESSION['SES_SIMRS_REG'])){
	die();
}	

require('../config/config.php');
require('../shared/connect_db.php');
require('../shared/function.php');
require('pdfb/pdfb.php');
require('barcode/barcode.inc.php');

$idx	= $_GET['idx'];
$sql = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.ST_BARU,m_pasien.NAMA_PASIEN,m_unit.NAMA_UNIT,
		m_jaminan.NAMA_JAMINAN,t_irja.USER_RM,t_irja.USER_PENDAFTARAN,m_pasien.JNS_KELAMIN,
		DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
		DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR
		FROM m_pasien
		INNER JOIN t_irja ON (m_pasien.NOMR = t_irja.NOMR)
		INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
		INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
		WHERE t_irja.IRJA_ID = "' . $idx . '"';
$get = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($get) > 0){
	$dat = mysql_fetch_assoc($get);
	$nomr = formatNomr($dat['NOMR']);
	$nama_pasien = $dat['NAMA_PASIEN'];
	$jenis_kelamin = $dat['JNS_KELAMIN'];
	$tgl_lahir = $dat['TGL_LAHIR'];
	$poli = $dat['NAMA_UNIT'];
	$tgl_daftar = $dat['TANGGAL_DAFTAR'];
	$jns_bayar = $dat['NAMA_JAMINAN'];
	if($jenis_kelamin == 'L') $jenis_kelamin = 'Lk';
	if($jenis_kelamin == 'P') $jenis_kelamin = 'Pr';
	
	if($poli != 'IGD') $poli = 'Klinik ' . $poli;
	
	class PDF extends PDFB {
		function Header() {
		}
		function Footer() {
		}
	}
	
	$pdf = new PDF("p", "mm", array(235,192));
	$pdf->SetAuthor("PDFB Library");
	$pdf->SetTitle("Label MR Pasien");

	$pdf->SetAutoPageBreak(false);
	
	$pdf->setSourceFile("label_mr_pasien.pdf");
	$tplidx = $pdf->ImportPage(1);	
	
	$pdf->AddPage();
	$pdf->useTemplate($tplidx);
	
	$x = 20;
	$i = 1;
	while ($i < 5){
		
		$j = 1;
		$y = 5;
		while ($j < 4){
			$pdf->SetFont("Arial", "B", 12);
			$pdf->Text($y, $x, $nomr);
			$pdf->SetFont("Arial", "", 10);
			$pdf->Text($y, $x + 5, $nama_pasien);
			$pdf->Text($y, $x + 10, $tgl_lahir);
			$pdf->Text($y, $x + 15, $jenis_kelamin);
			$j++;
			$y = $y + 87;
		}
	$i++;
	$x = $x + 48;
	}	
	
	$pdf->Output();
	$pdf->closeParsers();
}
}
?>