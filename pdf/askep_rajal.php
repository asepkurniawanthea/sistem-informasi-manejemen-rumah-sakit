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

$bulan_array = array('1'=>'Januari', '2'=>'Pebruari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni',
					'7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember');
$jnskel_array = array('L'=>'Laki-laki', 'P'=>'Perempuan');					

$idx	= $_GET['idx'];
$ord 	= '';
if(isset($_GET['ord'])) $ord = $_GET['ord'];

class PDF extends PDFB {
		function Header() {
		}
		function Footer() {
		}
}

if(empty($ord)){
	$sql_pasien = 'SELECT DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y") AS KUNJUNGAN,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%h:%i:%s") AS PUKUL,
				m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,m_pasien.PEKERJAAN,
				t_irja.JENIS_BAYAR_ID
				FROM t_irja
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
}else{
	$sql_pasien = 'SELECT DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d-%m-%Y") AS KUNJUNGAN,
				DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%h:%i:%s") AS PUKUL,
				m_unit.NAMA_UNIT,m_pasien.NOMR,m_pasien.NAMA_PASIEN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pasien.JNS_KELAMIN,m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,m_pasien.PEKERJAAN,
				t_hemodialisa.JENIS_BAYAR_ID
				FROM t_hemodialisa
				INNER JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
				INNER JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
				LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
}				
$get_pasien = mysql_query($sql_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$tgl_kunjungan = $dat_pasien['KUNJUNGAN']; 	
$tanggal_kunjungan_array = explode('-',$tgl_kunjungan);
$hari_kunjungan = $tanggal_kunjungan_array[0] + 0;
$bulan_kunjungan = $tanggal_kunjungan_array[1] + 0;

$bulan_kunjungan = $bulan_array[$bulan_kunjungan];
$tgl_kunjungan = $hari_kunjungan . ' ' . $bulan_kunjungan . ' ' . $tanggal_kunjungan_array[2];							
$pukul = $dat_pasien['PUKUL']; 
$poliklinik = $dat_pasien['NAMA_UNIT']; 				
$nama_pasien = getInisial($dat_pasien['NAMA_PASIEN']); 				
$nomr = $dat_pasien['NOMR'];
$nomr = substr($nomr,0,2) . '.' . substr($nomr,2,2) . '.'. substr($nomr,4,2);
 				
$tgl_lahir = $dat_pasien['TGL_LAHIR']; 	
$tanggal_lahir_array = explode('-',$tgl_lahir);
$hari_lahir = $tanggal_lahir_array[0] + 0;
$bulan_lahir = $tanggal_lahir_array[1] + 0;
$bulan_lahir = $bulan_array[$bulan_lahir];
$tgl_lahir = $hari_lahir . ' ' . $bulan_lahir . ' ' . $tanggal_lahir_array[2];

$jenis_kelamin = $jnskel_array[$dat_pasien['JNS_KELAMIN']];
$agama = $dat_pasien['NAMA_AGAMA'];
$pendidikan = $dat_pasien['NAMA_PENDIDIKAN'];
$pekerjaan = $dat_pasien['PEKERJAAN'];
$jns_pembayaran = $dat_pasien['JENIS_BAYAR_ID'];

if(empty($ord)){
	$qry_askep = 'SELECT t_irja_askep.IRJA_ASKEP_ID,t_irja_askep.KELUHAN_UTAMA,t_irja_askep.RIWAYAT_PENYAKIT,
				t_irja_askep.RIWAYAT_PENYAKIT_KELUARGA,t_irja_askep.GENOGRAM,t_irja_askep.TEKANAN_DARAH,
				t_irja_askep.FREKUENSI_NAFAS,t_irja_askep.SUHU_TUBUH,t_irja_askep.FREKUENSI_NADI,
				t_irja_askep.BERAT_BADAN,t_irja_askep.TINGGI_BADAN,t_irja_askep.PEMERIKSA_FISIK_TERKAIT_KELUHAN,
				t_irja_askep.HUBUNGAN_KELUARGA,t_irja_askep.STATUS_PSIKOLOGIS,
				t_irja_askep.KETERANGAN_STATUS_PSIKOLOGIS,t_irja_askep.PENURUNAN_BERAT_BADAN,t_irja_askep.TIDAK_NAFSU_MAKAN,
				t_irja_askep.DIAGNOSIS_KHUSUS,t_irja_askep.KETERANGAN_DIAGNOSIS_KHUSUS,t_irja_askep.STATUS_FUNGSIONAL,
				t_irja_askep.KETERANGAN_STATUS_FUNGSIONAL,t_irja_askep.CARA_BERJALAN,t_irja_askep.CARA_DUDUK,t_irja_askep.NYERI,
				t_irja_askep.SKALA_NYERI,t_irja_askep.LOKASI_NYERI,t_irja_askep.DURASI_NYERI,t_irja_askep.FREKUENSI_NYERI,
				t_irja_askep.NYERI_HILANG,t_irja_askep.KETERANGAN_NYERI_HILANG,t_irja_askep.ST_SELESAI,
				t_irja_askep.STATUS_PSIKOLOGIS_BUNUH_DIRI,
				t_irja_askep.DIAGNOSA_KHUSUS_DM,t_irja_askep.DIAGNOSA_KHUSUS_KEMOTERAPI,
				t_irja_askep.DIAGNOSA_KHUSUS_HEMODIALISA,t_irja_askep.DIAGNOSA_KHUSUS_GERIATRI,
				t_irja_askep.DIAGNOSA_KHUSUS_IMUNITAS,t_irja_askep.DIAGNOSA_KHUSUS_LAIN,
				t_irja_askep.KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,
				t_irja_askep.RESIKO_JATUH,t_irja_askep.KETERANGAN_RESIKO_JATUH,
				t_irja_askep.STATUS_NYERI_HILANG,t_irja_askep.KETERANGAN_STATUS_NYERI_HILANG,
				t_irja_askep.RIWAYAT_ALERGI_OBAT,t_irja_askep.DIAGNOSA_KEPERAWATAN,
				t_irja_askep.RENCANA_KEPERAWATAN,t_irja_askep.IMPELEMENTASI_KEPERAWATAN,
				t_irja_askep.EVALUASI_KEPERAWATAN
				FROM t_irja_askep
				WHERE t_irja_askep.IRJA_ASKEP_ID = "' . $idx . '"';
}else{
	$qry_askep = 'SELECT t_hemodialisa_askep.HEMODIALISA_ASKEP_ID,t_hemodialisa_askep.KELUHAN_UTAMA,t_hemodialisa_askep.RIWAYAT_PENYAKIT,
				t_hemodialisa_askep.RIWAYAT_PENYAKIT_KELUARGA,t_hemodialisa_askep.GENOGRAM,t_hemodialisa_askep.TEKANAN_DARAH,
				t_hemodialisa_askep.FREKUENSI_NAFAS,t_hemodialisa_askep.SUHU_TUBUH,t_hemodialisa_askep.FREKUENSI_NADI,
				t_hemodialisa_askep.BERAT_BADAN,t_hemodialisa_askep.TINGGI_BADAN,t_hemodialisa_askep.PEMERIKSA_FISIK_TERKAIT_KELUHAN,
				t_hemodialisa_askep.HUBUNGAN_KELUARGA,t_hemodialisa_askep.STATUS_PSIKOLOGIS,
				t_hemodialisa_askep.KETERANGAN_STATUS_PSIKOLOGIS,t_hemodialisa_askep.PENURUNAN_BERAT_BADAN,t_hemodialisa_askep.TIDAK_NAFSU_MAKAN,
				t_hemodialisa_askep.DIAGNOSIS_KHUSUS,t_hemodialisa_askep.KETERANGAN_DIAGNOSIS_KHUSUS,t_hemodialisa_askep.STATUS_FUNGSIONAL,
				t_hemodialisa_askep.KETERANGAN_STATUS_FUNGSIONAL,t_hemodialisa_askep.CARA_BERJALAN,t_hemodialisa_askep.CARA_DUDUK,t_hemodialisa_askep.NYERI,
				t_hemodialisa_askep.SKALA_NYERI,t_hemodialisa_askep.LOKASI_NYERI,t_hemodialisa_askep.DURASI_NYERI,t_hemodialisa_askep.FREKUENSI_NYERI,
				t_hemodialisa_askep.NYERI_HILANG,t_hemodialisa_askep.KETERANGAN_NYERI_HILANG,t_hemodialisa_askep.ST_SELESAI,
				t_hemodialisa_askep.STATUS_PSIKOLOGIS_BUNUH_DIRI,
				t_hemodialisa_askep.DIAGNOSA_KHUSUS_DM,t_hemodialisa_askep.DIAGNOSA_KHUSUS_KEMOTERAPI,
				t_hemodialisa_askep.DIAGNOSA_KHUSUS_HEMODIALISA,t_hemodialisa_askep.DIAGNOSA_KHUSUS_GERIATRI,
				t_hemodialisa_askep.DIAGNOSA_KHUSUS_IMUNITAS,t_hemodialisa_askep.DIAGNOSA_KHUSUS_LAIN,
				t_hemodialisa_askep.KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,
				t_hemodialisa_askep.RESIKO_JATUH,t_hemodialisa_askep.KETERANGAN_RESIKO_JATUH,
				t_hemodialisa_askep.STATUS_NYERI_HILANG,t_hemodialisa_askep.KETERANGAN_STATUS_NYERI_HILANG,
				t_hemodialisa_askep.RIWAYAT_ALERGI_OBAT,t_hemodialisa_askep.DIAGNOSA_KEPERAWATAN,
				t_hemodialisa_askep.RENCANA_KEPERAWATAN,t_hemodialisa_askep.IMPELEMENTASI_KEPERAWATAN,
				t_hemodialisa_askep.EVALUASI_KEPERAWATAN
				FROM t_hemodialisa_askep
				WHERE t_hemodialisa_askep.HEMODIALISA_ASKEP_ID = "' . $idx . '"';
}				
$get_askep = mysql_query($qry_askep);
$dat_askep = mysql_fetch_assoc($get_askep);

$keluhan_utama = $dat_askep['KELUHAN_UTAMA']; 
$riwayat_penyakit = $dat_askep['RIWAYAT_PENYAKIT']; 
$riwayat_penyakit_keluarga = $dat_askep['RIWAYAT_PENYAKIT_KELUARGA']; 
$genogram = $dat_askep['GENOGRAM']; 
$tekanan_darah = $dat_askep['TEKANAN_DARAH']; 
$frekuensi_nafas = $dat_askep['FREKUENSI_NAFAS']; 
$suhu_tubuh = $dat_askep['SUHU_TUBUH']; 
$frekuensi_nadi = $dat_askep['FREKUENSI_NADI']; 
$berat_badan = $dat_askep['BERAT_BADAN']; 
$tinggi_badan = $dat_askep['TINGGI_BADAN']; 
$pemeriksaan_fisik_terkait_keluhan = $dat_askep['PEMERIKSA_FISIK_TERKAIT_KELUHAN']; 
$hubungan_keluarga = $dat_askep['HUBUNGAN_KELUARGA']; 
$status_psikologis = $dat_askep['STATUS_PSIKOLOGIS']; 
$keterangan_status_psikologis = $dat_askep['KETERANGAN_STATUS_PSIKOLOGIS']; 
$penurunan_berat_badan = $dat_askep['PENURUNAN_BERAT_BADAN']; 
$tidak_nafsu_makan = $dat_askep['TIDAK_NAFSU_MAKAN']; 
$diagnosis_khusus = $dat_askep['DIAGNOSIS_KHUSUS']; 
$keterangan_diagnosis_khusus = $dat_askep['KETERANGAN_DIAGNOSIS_KHUSUS'];
$status_fungsional = $dat_askep['STATUS_FUNGSIONAL'];
$keterangan_status_fungsional = $dat_askep['KETERANGAN_STATUS_FUNGSIONAL'];
$cara_berjalan = $dat_askep['CARA_BERJALAN'];
$cara_duduk = $dat_askep['CARA_DUDUK'];
$nyeri = $dat_askep['NYERI'];
$skala_nyeri = $dat_askep['SKALA_NYERI'];
$lokasi_nyeri = $dat_askep['LOKASI_NYERI'];
$durasi_nyeri = $dat_askep['DURASI_NYERI'];
$frekuensi_nyeri = $dat_askep['FREKUENSI_NYERI'];
$nyeri_hilang = $dat_askep['NYERI_HILANG'];
$keterangan_nyeri_hilang = $dat_askep['KETERANGAN_NYERI_HILANG'];

$status_bunuh_diri = $dat_askep['STATUS_PSIKOLOGIS_BUNUH_DIRI'];
$diagnosis_khusus_dm = $dat_askep['DIAGNOSA_KHUSUS_DM'];
$diagnosis_khusus_kemoterapi = $dat_askep['DIAGNOSA_KHUSUS_KEMOTERAPI'];
$diagnosis_khusus_hemodialisa = $dat_askep['DIAGNOSA_KHUSUS_HEMODIALISA'];
$diagnosis_khusus_geriatri = $dat_askep['DIAGNOSA_KHUSUS_GERIATRI'];
$diagnosis_khusus_imunitas = $dat_askep['DIAGNOSA_KHUSUS_IMUNITAS'];
$diagnosis_khusus_lain = $dat_askep['DIAGNOSA_KHUSUS_LAIN'];
$keterangan_status_fungsional_ketergantungan = $dat_askep['KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN'];
$resiko_jatuh = $dat_askep['RESIKO_JATUH'];
$keterangan_resiko_jatuh = $dat_askep['KETERANGAN_RESIKO_JATUH'];

$status_nyeri_hilang = $dat_askep['STATUS_NYERI_HILANG'];
$keterangan_status_nyeri_hilang = $dat_askep['KETERANGAN_STATUS_NYERI_HILANG'];
$riwayat_alergi_obat = $dat_askep['RIWAYAT_ALERGI_OBAT'];
$diagnosa_keperawatan = $dat_askep['DIAGNOSA_KEPERAWATAN'];
$rencana_keperawatan = $dat_askep['RENCANA_KEPERAWATAN'];
$implementasi_keperawatan = $dat_askep['IMPELEMENTASI_KEPERAWATAN'];
$evaluasi_keperawatan = $dat_askep['EVALUASI_KEPERAWATAN'];
				
$pdf = new PDF("p", "mm", array(216,280));
$pdf->SetAuthor("PDFB Library");
$pdf->SetTitle("Askep Rajal");

$pdf->SetFont("Arial", "", 9);
$pdf->SetAutoPageBreak(false);
	
$pdf->setSourceFile("askep_rajal.pdf");
$tplidx = $pdf->ImportPage(1);
$pdf->AddPage();
$pdf->useTemplate($tplidx);	

$pdf->Text(55, 30, $tgl_kunjungan);
$pdf->Text(104, 30, $pukul);
$pdf->Text(147, 30, $poliklinik);

$pdf->Text(77, 58, $nama_pasien);
$pdf->Text(77, 63, $nomr);
$pdf->Text(77, 68, $tgl_lahir);
$pdf->Text(77, 73, $jenis_kelamin);
$pdf->Text(77, 78, $agama);
$pdf->Text(77, 83, $pendidikan);
$pdf->Text(77, 88, $pekerjaan);

if($jns_pembayaran == '12') {
	$pdf->Text(78, 91, 'x');
}else if($jns_pembayaran == '13'){
	$pdf->Text(99.5, 91, 'x');
}else if($jns_pembayaran == '14'){
	$pdf->Text(120.5, 91, 'x');	
}else if($jns_pembayaran == '1'){
	$pdf->Text(132.5, 91, 'x');		
}else{
	$pdf->Text(150.5, 91, 'x');		
}	

$pdf->SetXY(76,98);
$pdf->MultiCell(0,3.5,$keluhan_utama,0,"J");

$pdf->SetXY(76,111.5);
$pdf->MultiCell(0,3.5,$riwayat_penyakit,0,"J");

$pdf->SetXY(76,125);
$pdf->MultiCell(0,3.5,$riwayat_penyakit_keluarga,0,"J");

$pdf->Text(77, 145, $tekanan_darah);
$pdf->Text(77, 150, $frekuensi_nafas);
$pdf->Text(77, 155, $suhu_tubuh);
$pdf->Text(77, 160, $frekuensi_nadi);
$pdf->Text(77, 164.5, $berat_badan);
$pdf->Text(77, 169.5, $tinggi_badan);

$pdf->SetXY(127,172);
$pdf->MultiCell(0,3.5,$pemeriksaan_fisik_terkait_keluhan,0,"J");

if($hubungan_keluarga == 'Baik') $pdf->Text(101.5, 190, 'x');		
if($hubungan_keluarga == 'Tidak Baik') $pdf->Text(127, 190, 'x');

if($status_psikologis == 'Tenang') $pdf->Text(31.5, 202.5, 'x');		
if($status_psikologis == 'Cemas') $pdf->Text(63.5, 202.5, 'x');			
if($status_psikologis == 'Takut') $pdf->Text(101.5, 202.5, 'x');			
if($status_psikologis == 'Marah') $pdf->Text(127, 202.5, 'x');			
if($status_psikologis == 'Sedih') $pdf->Text(165, 202.5, 'x');			
if($status_psikologis == 'Kecendrungan Bunuh') {
	$pdf->Text(31.5, 209, 'x');	
	$pdf->Text(100, 209, $status_bunuh_diri);	
}		
if($status_psikologis == 'Lain-lain') {
	$pdf->Text(127, 209, 'x');
	$pdf->SetXY(160,206);
	$pdf->MultiCell(0,3.5,$keterangan_status_psikologis,0,"J");			
}	

$skor = 0;
if($penurunan_berat_badan == 'Tidak Ada'){
	$skor = $skor + 0;
	$pdf->Text(33, 240, 'x');
}

if($penurunan_berat_badan == 'Tidak Yakin'){
	$skor = $skor + 2;
	$pdf->Text(33, 244, 'x');
}

if($penurunan_berat_badan == 'Ada|1 - 5 kg'){
	$skor = $skor + 1;
	$pdf->Text(37, 254, 'x');
}

if($penurunan_berat_badan == 'Ada|6 - 10 kg'){
	$skor = $skor + 2;
	$pdf->Text(37, 258, 'x');
}

if($penurunan_berat_badan == 'Ada|- 15 kg'){
	$skor = $skor + 3;
	$pdf->Text(37, 263, 'x');
}

if($penurunan_berat_badan == 'Ada|> 15 kg'){
	$skor = $skor + 4;
	$pdf->Text(37, 268, 'x');
}

$tplidx = $pdf->ImportPage(2);
$pdf->AddPage();
$pdf->useTemplate($tplidx);	

if($tidak_nafsu_makan == 'Tidak'){
	$skor = $skor + 0;
	$pdf->Text(31, 25.5, 'x');
}

if($tidak_nafsu_makan == 'Ya'){
	$skor = $skor + 1;
	$pdf->Text(34, 31, 'x');
}

$pdf->Text(187, 39.5, $skor);	

if($diagnosis_khusus == 'Ya') $pdf->Text(89, 44.5, 'x');	
if($diagnosis_khusus == 'Tidak') $pdf->Text(115, 44.5, 'x');
if($diagnosis_khusus_dm == '1') $pdf->Line(38, 49, 45, 49);
if($diagnosis_khusus_kemoterapi == '1') $pdf->Line(45, 49, 64, 49);
if($diagnosis_khusus_hemodialisa == '1') $pdf->Line(64, 49, 85, 49);
if($diagnosis_khusus_geriatri == '1') $pdf->Line(85, 49, 99, 49);
if($diagnosis_khusus_imunitas == '1') $pdf->Line(99, 49, 132, 49);
if($diagnosis_khusus_lain == '1') $pdf->Line(132, 49, 146, 49);

$pdf->Text(162, 49, $keterangan_diagnosis_khusus);

if($status_fungsional == 'Mandiri') $pdf->Text(33, 71, 'x');
if($status_fungsional == 'Perlu Bantuan') {
	$pdf->Text(50, 71, 'x');
	$pdf->Text(93, 70, $keterangan_status_fungsional);
}
if($status_fungsional == 'Ketergantungan Total') {
	$pdf->Text(33, 76.5, 'x');
	$pdf->Text(115, 76.5, $keterangan_status_fungsional_ketergantungan);
}	

if($cara_berjalan == 'Ya') $pdf->Text(88, 100, 'x');		
if($cara_berjalan == 'Tidak') $pdf->Text(100.5, 100, 'x');		

if($cara_duduk == 'Ya') $pdf->Text(37, 112.5, 'x');		
if($cara_duduk == 'Tidak') $pdf->Text(50, 112.5, 'x');

if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Tidak')) $pdf->Text(47.5, 118.5, 'x');
if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Ya')) $pdf->Text(128, 118.5, 'x');
if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Ya')) $pdf->Text(47, 124.5, 'x');
if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Tidak')) $pdf->Text(47, 124.5, 'x');
 		
if($resiko_jatuh == 'Ya'){
	$pdf->Text(72.5, 130.5, 'x');
	$pdf->Text(92, 130.5, $keterangan_resiko_jatuh);	
}

if($resiko_jatuh == 'Tidak') $pdf->Text(122.5, 130.5, 'x');

if($nyeri == 'Tidak Ada') $pdf->Text(126.5, 151.5, 'x');
if($nyeri == 'Nyeri Kronis') $pdf->Text(158.5, 151.5, 'x');
if($nyeri == 'Nyeri Akut') $pdf->Text(186, 151.5, 'x');
$pdf->Text(148, 164.5, $skala_nyeri);
$pdf->Text(173, 164.5, $lokasi_nyeri);
$pdf->Text(137, 170.5, $durasi_nyeri);
$pdf->Text(177, 170.5, $frekuensi_nyeri);
if($nyeri_hilang == 'Minum Obat') $pdf->Text(126.5, 183, 'x');
if($nyeri_hilang == 'Istirahat') $pdf->Text(126.5, 189, 'x');
if($nyeri_hilang == 'Mendengar Musik') $pdf->Text(155, 183, 'x');
if($nyeri_hilang == 'Berubah Posisi') $pdf->Text(155, 189, 'x');
if($nyeri_hilang == 'Lain-lain') {
	$pdf->Text(126.5, 195.5, 'x');
	$pdf->SetXY(162,192);
	$pdf->MultiCell(0,3.5,$keterangan_nyeri_hilang,0,"L");
}

if($status_nyeri_hilang == 'Ya'){
	$pdf->Text(126.5, 207.5, 'x');
	$pdf->Text(147, 207.5, $keterangan_status_nyeri_hilang);
}	
if($status_nyeri_hilang == 'Tidak') $pdf->Text(177.5, 207.5, 'x');

$pdf->SetXY(30,228);
$pdf->MultiCell(0,3.5,$riwayat_alergi_obat,0,"J");

$tplidx = $pdf->ImportPage(3);	
$pdf->AddPage();
$pdf->useTemplate($tplidx);

$pdf->SetXY(115,20);
$pdf->MultiCell(0,3.5,$rencana_keperawatan,0,"J");

$pdf->SetXY(115,123);
$pdf->MultiCell(0,3.5,$evaluasi_keperawatan,0,"J");

$pdf->SetRightMargin(108);
$pdf->SetXY(17,20);
$pdf->MultiCell(0,3.5,$diagnosa_keperawatan,0,"J");

$pdf->SetXY(17,123);
$pdf->MultiCell(0,3.5,$implementasi_keperawatan,0,"J");

$pdf->Output();
$pdf->closeParsers();
}
?>