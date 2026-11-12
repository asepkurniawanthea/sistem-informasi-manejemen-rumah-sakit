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
		DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
		m_pasien.ALAMAT,m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
		m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
		m_pegawai.NAMA_PEGAWAI,
		(SELECT DATE_FORMAT(t_irja2.TANGGAL_DAFTAR,"%d-%m-%Y") FROM t_irja t_irja2
		WHERE t_irja2.NOMR = t_irja.NOMR AND t_irja2.NO_PENDAFTARAN IS NOT NULL
		AND t_irja2.ST_BARU = "1" AND t_irja2.ST_BATAL IS NULL) AS KK1
		FROM m_pasien
		INNER JOIN t_irja ON (m_pasien.NOMR = t_irja.NOMR)
		INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
		INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
		INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
		LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
		LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
		LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
		WHERE t_irja.IRJA_ID = "' . $idx . '"';
$get = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($get) > 0){
	$dat = mysql_fetch_assoc($get);
	$nomr = formatNomr($dat['NOMR']);
	$nama_pasien = $dat['NAMA_PASIEN'];
	$jenis_kelamin = $dat['JNS_KELAMIN'];
	$jnskel = 'Lk.';
	if($jenis_kelamin == 'P') $jnskel = 'Pr.'; 
	
	$tgl_lahir = $dat['TGL_LAHIR'];
	$poli = $dat['NAMA_UNIT'];
	$tgl_daftar = $dat['TANGGAL_DAFTAR'];
	$jns_bayar = $dat['NAMA_JAMINAN'];
	$kk1 = $dat['KK1'];
	$dokter = $dat['NAMA_PEGAWAI'];
	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	$alamat = $dat['ALAMAT'];
	$rt = $dat['ALAMAT_RT'];
	$rw = $dat['ALAMAT_RW'];
	if(!empty($rt)) $alamat = $alamat . ' ' . $rt;
	if(!empty($rw)) $alamat = $alamat . '/' . $rw;
	$desa = $dat['NAMA_KELURAHAN'];
	$kecamatan = $dat['NAMA_KECAMATAN'];
	$kabupaten = $dat['NAMA_KOTA'];
	
	if($poli != 'IGD') $poli = 'Klinik ' . $poli;
	
	class PDF extends PDFB {
		function Header() {
		}
		function Footer() {
		}
	}
	
	$pdf = new PDF("p", "mm", array(120,70));
	$pdf->SetAuthor("PDFB Library");
	$pdf->SetTitle("KIUP");

	$pdf->SetFont("Arial", "B", 10);
	$pdf->SetAutoPageBreak(false);
	
	$pdf->setSourceFile("kiup_mr_pasien.pdf");
	$tplidx = $pdf->ImportPage(1);	
	
	$pdf->AddPage();
	$pdf->useTemplate($tplidx);
	
	$pdf->Text(10, 10, $nama_pasien);
	$pdf->Text(90, 10, $nomr);
	
	$pdf->SetFont("Arial", "", 10);
	$pdf->Text(10, 20, $alamat);
	$pdf->Text(60, 25, $poli);
	
	$pdf->Text(10, 25, trim($desa));
	$pdf->Text(60, 30, $dokter);
	
	$pdf->Text(10, 30, trim($kecamatan));
	$pdf->Text(60, 35, $jnskel . ' ' . $umur);
	
	$pdf->Text(10, 35, trim($kabupaten));
	
	$pdf->Text(70, 45, 'Tangerang, ' . $tgl_daftar);
	$pdf->Text(70, 65, 'KK1 : ' . $kk1);
		
	$pdf->Output();
	$pdf->closeParsers();
}
}
?>