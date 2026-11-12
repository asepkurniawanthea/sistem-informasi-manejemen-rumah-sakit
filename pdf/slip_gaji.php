<?php
//error_reporting (E_ALL);
if (isset($_GET['idx'])){
	
/*
session_start();
if (!isset($_SESSION['SES_SIMRS_REG'])){
	die();
}else{
	if($_SESSION['SES_SIMRS_NAMA_MODUL'] != 'SDM') die();
}
*/
	
require('../config/config.php');
require('../shared/connect_db.php');
require('../shared/function.php');
require('pdfb/pdfb.php');

$bulan_array = array('01'=>'Januari', '02'=>'Pebruari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni',
					'07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember');		

$sql_gaji = 'SELECT rg.*,ru.UANG_MAKAN,ru.PAJAK,ru.UANG_MAKAN_BERSIH,
			 rr.REMUNERASI,rr.PAJAK AS PAJAK_REMUNERASI,
			 rr.REMUNERASI_BERSIH,
			 po.*
			FROM db_sdm.r_gaji rg 
			INNER JOIN db_sdm.r_pegawai_ori po ON (rg.NIP = po.NIP)
			LEFT JOIN db_sdm.r_uang_makan ru ON (rg.NIP = ru.NIP AND ru.TAHUN = rg.TAHUN AND ru.BULAN = rg.BULAN)
			LEFT JOIN db_sdm.r_remunerasi rr ON (rg.NIP = rr.NIP AND rr.TAHUN = rg.TAHUN AND rr.BULAN = rg.BULAN)
			WHERE rg.GAJI_ID  = "' . $_GET['idx'] . '"';
$get_gaji = mysql_query($sql_gaji) or die(mysql_error());
$dat_gaji = mysql_fetch_assoc($get_gaji);		

class PDF extends PDFB {
		function Header() {
		}
		function Footer() {
		}
}

$pdf = new PDF("p", "mm", array(210,330));
$pdf->SetAuthor("PDFB Library");
$pdf->SetTitle("Slip Gaji Pegawai");
$pdf->SetFont("Arial", "", 11);
$pdf->SetAutoPageBreak(false);
$pdf->setSourceFile("slip_gaji.pdf");
$tplidx = $pdf->ImportPage(1);
$pdf->AddPage();
$pdf->useTemplate($tplidx);	

$pdf->Line(15, 44, 203, 44);
$pdf->SetLineWidth(0.5);
$pdf->Line(15, 45, 203, 45);

$pdf->Text(56.5, 51.5, 'UM. 05.02/XXXI.2.2.3/       /2022');
$pdf->Text(56.5, 61.2, $dat_gaji['NAMA_PEGAWAI']);

$pdf->Text(97, 85.5, $dat_gaji['NAMA_PEGAWAI']);
$pdf->Text(97, 90.3, $dat_gaji['NIP']);
$pdf->Text(97, 95.1, $dat_gaji['GOLONGAN']);
$pdf->Text(97, 99.9, $dat_gaji['JABATAN']);

$pdf->SetRightMargin(17);
$pdf->SetXY(96.5,101.5);
$pdf->MultiCell(0,4.5,$dat_gaji['ALAMAT'],0,"J");

$pdf->SetRightMargin(60);
$pdf->SetXY(70,121.2);
$pdf->MultiCell(0,3.5, '    ' . $bulan_array[$dat_gaji['BULAN']] . ' ' . $dat_gaji['TAHUN'],0,"C");

$pdf->SetRightMargin(85);
$pdf->SetXY(70,131);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['GAJI_POKOK'],0) . ' ,-',0,"R");
$pdf->SetXY(70,135.8);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TUNJANGAN_ISTERI_SUAMI'],0) . ' ,-',0,"R");
$pdf->SetXY(70,140.6);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TUNJANGAN_ANAK'],0) . ' ,-',0,"R");
$pdf->SetXY(70,145.4);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['REMUNERASI'],0) . ' ,-',0,"R");
$pdf->SetXY(70,150.2);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TUNJANGAN_STRUKTUR'],0) . ' ,-',0,"R");
$pdf->SetXY(70,155);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TUNJANGAN_WIL_TERPENCIL'],0) . ' ,-',0,"R");
$pdf->SetXY(70,159.8);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TUNJANGAN_TAMB_UMUM'],0) . ' ,-',0,"R");
$pdf->SetXY(70,164.6);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['UANG_MAKAN'],0) . ' ,-',0,"R");
$pdf->SetXY(70,169.4);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TUNJANGAN_BERAS'],0) . ' ,-',0,"R");
$pdf->SetXY(70,174,2);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TUNJANGAN_PAJAK'],0) . ' ,-',0,"R");
$pdf->SetXY(70,179);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['BULAT'],0) . ' ,-',0,"R");

$jumlah_penghasilan = $dat_gaji['GAJI_POKOK'] + 
			$dat_gaji['TUNJANGAN_ISTERI_SUAMI'] + 
			$dat_gaji['TUNJANGAN_ANAK'] + 
			$dat_gaji['REMUNERASI'] + 
			$dat_gaji['TUNJANGAN_STRUKTUR'] + 
			$dat_gaji['TUNJANGAN_WIL_TERPENCIL'] + 
			$dat_gaji['TUNJANGAN_TAMB_UMUM'] + 
			$dat_gaji['UANG_MAKAN'] + 
			$dat_gaji['TUNJANGAN_BERAS'] + 
			$dat_gaji['TUNJANGAN_PAJAK'] +
			$dat_gaji['BULAT'];
$pdf->SetRightMargin(40);
$pdf->SetXY(70,183.8);
$pdf->MultiCell(0,3.5,currFormat($jumlah_penghasilan,0) . ' ,-',0,"R");
$pdf->SetRightMargin(85);
$pdf->SetXY(70,204);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['WP'],0) . ' ,-',0,"R");
$pdf->SetXY(70,208.8);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['POTONGAN_BERAS'],0) . ' ,-',0,"R");
$pdf->SetXY(70,213.6);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['TAPE_RUM'],0) . ' ,-',0,"R");
$pdf->SetXY(70,218.4);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['SEWA_RUMAH'],0) . ' ,-',0,"R");
$pdf->SetXY(70,223.2);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['PPH'],0) . ' ,-',0,"R");
$pdf->SetXY(70,228);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['PAJAK_REMUNERASI'],0) . ' ,-',0,"R");
$pdf->SetXY(70,232.8);
$pdf->MultiCell(0,3.5,currFormat($dat_gaji['PAJAK'],0) . ' ,-',0,"R");
$pdf->SetRightMargin(40);

$jumlah_potongan = $dat_gaji['WP'] +
			$dat_gaji['POTONGAN_BERAS'] +
			$dat_gaji['TAPE_RUM'] +
			$dat_gaji['SEWA_RUMAH'] +
			$dat_gaji['PPH'] +
			$dat_gaji['PAJAK_REMUNERASI'] +
			$dat_gaji['PAJAK'];
$pdf->SetXY(70,237.6);
$pdf->MultiCell(0,3.5,currFormat($jumlah_potongan,0) . ' ,-',0,"R");

$gaji_bersih = $jumlah_penghasilan - $jumlah_potongan;
$pdf->SetXY(70,242.4);
$pdf->MultiCell(0,3.5,currFormat($gaji_bersih,0) . ' ,-',0,"R");

$pdf->SetRightMargin(5);
$pdf->SetXY(100,268);
$pdf->MultiCell(0,3.5,'Tangerang, ' . date('j') . '  ' . $bulan_array[date('m')] . ' ' . date('Y'),0,"C");

$sql_kasubag = 'SELECT NIP,NAMA_PEGAWAI FROM db_sdm.r_pegawai_ori WHERE MARK_SBG = "KPSDM"';
$get_kasubag = mysql_query($sql_kasubag) or die(mysql_error());
$dat_kasubag = mysql_fetch_assoc($get_kasubag);

$sql_bendahara = 'SELECT NIP,NAMA_PEGAWAI FROM db_sdm.r_pegawai_ori WHERE MARK_SBG = "BGPPABP"';
$get_bendahara = mysql_query($sql_bendahara) or die(mysql_error());
$dat_bendahara = mysql_fetch_assoc($get_bendahara);

$pdf->SetRightMargin(110);
$pdf->SetXY(10,295);
$pdf->MultiCell(0,3.5,$dat_kasubag['NAMA_PEGAWAI'],0,"C");

$pdf->SetXY(10,299.8);
$pdf->MultiCell(0,3.5,'NIP. ' . $dat_kasubag['NIP'],0,"C");

$pdf->SetRightMargin(20);
$pdf->SetXY(120,295);
$pdf->MultiCell(0,3.5,$dat_bendahara['NAMA_PEGAWAI'],0,"C");

$pdf->SetXY(120,299.8);
$pdf->MultiCell(0,3.5,'NIP. ' . $dat_bendahara['NIP'],0,"C");

$pdf->Output();
$pdf->closeParsers();
}
?>