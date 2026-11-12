<?php if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];
$selesai = '';

$arr_template = array();
$sql_template = 'SELECT JENIS_FOTO,EKSPERTISE FROM m_radiologi_template_ekspertise';
$get_template = mysql_query($sql_template) or die(mysql_error());
while($dat_template = mysql_fetch_array($get_template)){
	array_push($arr_template,array('JENIS_FOTO'=>$dat_template['JENIS_FOTO'],'EKSPERTISE'=>$dat_template['EKSPERTISE']));
}

if($ord == 'irj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'irn'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'aps'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,t_ipenunjang.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'hrj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'hri'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'orj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORJ"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'ori'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORI"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';				
}				
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = changeDateFormat($dat_pasien['TGL_LAHIR']);
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

$penunjang_id = $dat_pasien['PENUNJANG_ID'];
$pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
$nama_unit = $dat_pasien['NAMA_UNIT'] . ' (' .$dat_pasien['NAMA_PEGAWAI'] . ')';
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$rawat_id = $dat_pasien['RAWAT_ID'];

$no_telepon = $dat_pasien['NO_TELEPON'];
$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
$hemodialisa_id = $dat_pasien['HEMODIALISA_ID'];

$no_tarif = $dat_pasien['NO_TARIF'];

if(isset($_POST['simpan'])) include('radiologi/radiologi_save_diagnosa.php');
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang/Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:400px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
<?php 
if($ord == 'irj' or $ord == 'orj'){
	$qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irja_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irja_diagnosa.ICD_CODE
								ELSE CONCAT(t_irja_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irja_diagnosa
								LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
								AND t_irja_diagnosa.DIAGNOSA_ORDER <= 3
								ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
} else if($ord == 'irn' or $ord == 'ori'){
	$qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irna_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irna_diagnosa.ICD_CODE
								ELSE CONCAT(t_irna_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irna_diagnosa
								LEFT JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irna_diagnosa.IRNA_ID = "' . $rawat_id . '"
								AND t_irna_diagnosa.DIAGNOSA_ORDER <= 3
								ORDER BY t_irna_diagnosa.DIAGNOSA_ORDER';
} else if($ord == 'aps'){
	$qry_diagnosa = 'SELECT t_ipenunjang.DIAGNOSA_PENGIRIM AS DIAGNOSA, "" AS ICD
								FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $idx. '"';
} else if($ord == 'hrj'){
	$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_hemodialisa_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_hemodialisa_diagnosa.ICD_CODE
								ELSE CONCAT(t_hemodialisa_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_hemodialisa_diagnosa
								LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $hemodialisa_id . '"
								AND t_hemodialisa_diagnosa.DIAGNOSA_ORDER <= 3
								ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';
} else if($ord == 'hri'){
	$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_hemodialisa_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_hemodialisa_diagnosa.ICD_CODE
								ELSE CONCAT(t_hemodialisa_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_hemodialisa_diagnosa
								LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $hemodialisa_id . '"
								AND t_hemodialisa_diagnosa.DIAGNOSA_ORDER <= 3
								ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';					
}

$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
$i = 0;
?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Diagnosa</div>
	<div style=" width:20px; float:left; ">:</div>
	
<?php
if(mysql_num_rows($get_diagnosa) > 0){
while($dat_diagnosa = mysql_fetch_array($get_diagnosa)){
if($i == 0){
?>
	<div style=" width:850px; float:left; text-indent:5px; " align="left"><?php echo $i + 1; echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
<?php
}else{
?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:850px; float:left; text-indent:5px; " align="left"><?php echo $i + 1; echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
<?php }
$i++; }	
}else{				
?>
<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br>
<?php } ?>
<div style=" width:250px; float:left; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:5px; " align="right">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
<form name="form1" id= "form1" method="post" >  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php 
if($ord != 'aps'){
	$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
		t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
		t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,mpegawai2.NAMA_PEGAWAI AS NAMA_DOKTER,
		m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
		t_ipenunjang_tarif.HASIL_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,
		t_ipenunjang_tarif.NO_PHOTO,t_ipenunjang_tarif.ST_PHOTO,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,
		t_ipenunjang_tarif.USER_DIAGNOSA
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
		LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
		LEFT JOIN m_pegawai mpegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = mpegawai2.PEGAWAI_ID)
		WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx . '" 
		AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
		OR m_tarif.UNIT_ID = "17")
		GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
}else{
	$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,t_ipenunjang_tarif.TANGGAL_PERIKSA,
		t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
		t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,mpegawai2.NAMA_PEGAWAI AS NAMA_DOKTER,
		m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
		t_ipenunjang_tarif.HASIL_DIAGNOSA,t_ipenunjang_tarif.JENIS_FOTO,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,
		t_ipenunjang_tarif.NO_PHOTO,t_ipenunjang_tarif.ST_PHOTO,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,
		t_ipenunjang_tarif.USER_DIAGNOSA
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
		LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
		LEFT JOIN m_pegawai mpegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = mpegawai2.PEGAWAI_ID)
		WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx . '" 
		AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
		OR m_tarif.UNIT_ID = "17")
		GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
}	
$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());
$dat_tarif_detail = mysql_fetch_assoc($get_tarif_detail); 
$hasil_diagnosa = $dat_tarif_detail['HASIL_DIAGNOSA'];
$jenis_foto = $dat_tarif_detail['JENIS_FOTO'];
$pegawai_diagnosa_id = $dat_tarif_detail['PEGAWAI_DIAGNOSA_ID']; 
$st_diagnosa = $dat_tarif_detail['ST_DIAGNOSA'];
$tgl_diagnosa = $dat_tarif_detail['TANGGAL_DIAGNOSA'];
$user_diagnosa = $dat_tarif_detail['USER_DIAGNOSA'];

if($hasil_diagnosa != ''){
	$sql_ord = 'SELECT * FROM t_ipenunjang_tarif_pemeriksaan
			WHERE PENUNJANG_TARIF_ID = "' . $idx . '"';
	$get_ord = mysql_query($sql_ord) or die(mysql_error());
	if(mysql_num_rows($get_ord) == 0){
		mysql_query('INSERT INTO t_ipenunjang_tarif_pemeriksaan (PENUNJANG_TARIF_ID,REVISI,HASIL_DIAGNOSA,PEGAWAI_ID,
				TGL_DIAGNOSA,ST_DIAGNOSA,USER_DIAGNOSA)
				VALUES ("' . $idx . '","0","' . mysql_real_escape_string($hasil_diagnosa) . '",
				"' . $pegawai_diagnosa_id . '",STR_TO_DATE("' . $tgl_diagnosa . '","%d/%m/%Y %H:%i:%s"),
				"' . $st_diagnosa . '","' . $user_diagnosa . '")') or die(mysql_error());
	}	
} 

if(empty($pegawai_diagnosa_id)) $pegawai_diagnosa_id = $_SESSION['SES_SIMRS_PEGAWAI_ID'];
?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Permintaan Foto</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:400px; float:left; text-indent:5px; " align="left">&nbsp;<?php echo $dat_tarif_detail['NAMA_TARIF']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;<?php echo $dat_tarif_detail['TANGGAL_PERIKSA']; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Foto</div><br><br>	
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Film</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:400px; float:left; text-indent:5px; " align="left">&nbsp;<?php echo $dat_tarif_detail['JENIS_FILM']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;<?php echo $dat_tarif_detail['NAMA_PEGAWAI']; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Pelaksana</div><br>	
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<script type="text/javascript" src="script/tiny_mce/tiny_mce.js" language="javascript"></script>
<script type="text/javascript">
tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
		width: "850",
        height: "550",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
 
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		 
		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",
		 
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
		 
		// Style formats
		style_formats : [
		{title : 'Bold text', inline : 'b'},
		{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
		{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
		{title : 'Example 1', inline : 'span', classes : 'example1'},
		{title : 'Example 2', inline : 'span', classes : 'example2'},
		{title : 'Table styles'},
		{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		 
		// Replace values for the template plugin
		template_replace_values : {
		username : "Some User",
		staffid : "991234"
		}
});
</script>
<table width="100%" border="0">
	<?php	$sql_foto = 'SELECT PHOTO_FILE FROM t_ipenunjang_tarif_photo
				WHERE PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
			$get_foto = mysql_query($sql_foto) or die(mysql_error());
			if(mysql_num_rows($get_foto) > 0){
				$z = 0;
				while($dat_foto = mysql_fetch_array($get_foto)){	
					if($z == 0){ ?>
						<tr><td style="text-indent:22px;width:250px;">Foto</td><td style="text-indent:5px;">:&nbsp;<?php echo $dat_foto['PHOTO_FILE']; ?>&nbsp;<input type="button" value="download" class="myButton1" onclick="download_dicom('<?php echo $dat_foto['PHOTO_FILE']; ?>');" /></td></tr>
					<?php
					}else{ ?>
						<tr><td style="text-indent:22px;width:250px;">&nbsp;</td><td style="text-indent:5px;">&nbsp;&nbsp;<?php echo $dat_foto['PHOTO_FILE']; ?>&nbsp;<input type="button" value="download" class="myButton1" onclick="download_dicom('<?php echo $dat_foto['PHOTO_FILE']; ?>');" /></td></tr>
					<?php }	
					$z++;
				}	
			}else{
				echo '<tr><td style="text-indent:22px;width:250px;">Foto</td><td style="text-indent:5px;">:&nbsp;</td></tr>';
			}
			
			$pemeriksaan_id = '';
			$sql_dg = 'SELECT PENUNJANG_TARIF_PEMERIKSAAN_ID,REVISI,ST_DIAGNOSA,
				NAMA_PEGAWAI,DATE_FORMAT(TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TGL_DIAGNOSA
				FROM t_ipenunjang_tarif_pemeriksaan tp
				INNER JOIN m_pegawai mp ON (tp.PEGAWAI_ID = mp.PEGAWAI_ID)
				WHERE PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"
				ORDER BY PENUNJANG_TARIF_PEMERIKSAAN_ID';
			$get_dg = mysql_query($sql_dg) or die(mysql_error());
			if(mysql_num_rows($get_dg) > 0){
				$z = 0;
				while($dat_dg = mysql_fetch_array($get_dg)){	
					if($z == 0){
						echo '<tr><td style="text-indent:22px;width:250px;">Diagnosa</td><td style="text-indent:5px;">:&nbsp;' . $dat_dg['TGL_DIAGNOSA'] . ' ' . $dat_dg['NAMA_PEGAWAI'] . (($dat_dg['REVISI'] != '0') ? ' Rev ' . $dat_dg['REVISI'] . ' ' : '&nbsp;') . (($dat_dg['ST_DIAGNOSA'] == '1') ? ' -Final ' : '') . '<input type="button" value="buka" class="myButton1" onclick="buka_diagnosa(' . $dat_dg['PENUNJANG_TARIF_PEMERIKSAAN_ID'] . ');" />&nbsp;<input type="button" value="print" class="myButton1" onclick="print(' . $dat_dg['PENUNJANG_TARIF_PEMERIKSAAN_ID'] . ');" /></td></tr>';
					}else{
						echo '<tr><td style="text-indent:22px;width:250px;">&nbsp;</td><td style="text-indent:5px;">&nbsp;&nbsp;' . $dat_dg['TGL_DIAGNOSA'] . ' ' . $dat_dg['NAMA_PEGAWAI'] . (($dat_dg['REVISI'] != '0') ? ' Rev ' . $dat_dg['REVISI'] . ' ' : '&nbsp;') . (($dat_dg['ST_DIAGNOSA'] == '1') ? ' -Final ' : '') . '<input type="button" value="buka" class="myButton1" onclick="buka_diagnosa(' . $dat_dg['PENUNJANG_TARIF_PEMERIKSAAN_ID'] . ');" />&nbsp;<input type="button" value="print" class="myButton1" onclick="print(' . $dat_dg['PENUNJANG_TARIF_PEMERIKSAAN_ID'] . ');" /></td></tr>';
					}	
					$z++;
				}	
			}else{
				echo '<tr><td style="text-indent:22px;width:250px;">Diagnosa</td><td style="text-indent:5px;">:&nbsp;</td></tr>';
			}	
		
		if(isset($_GET['idp'])){
			$sql_dp = 'SELECT PENUNJANG_TARIF_PEMERIKSAAN_ID,REVISI,ST_DIAGNOSA,
				NAMA_PEGAWAI,DATE_FORMAT(TGL_DIAGNOSA,"%d-%m-%Y %H:%i") AS TGL_DIAGNOSA,
				tp.PEGAWAI_ID,tp.HASIL_DIAGNOSA
				FROM t_ipenunjang_tarif_pemeriksaan tp
				INNER JOIN m_pegawai mp ON (tp.PEGAWAI_ID = mp.PEGAWAI_ID)
				WHERE PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"
				AND PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $_GET['idp'] . '"';
			$get_dp = mysql_query($sql_dp) or die(mysql_error());	
			$dat_dp = mysql_fetch_assoc($get_dp);
			$pemeriksaan_id = $dat_dp['PENUNJANG_TARIF_PEMERIKSAAN_ID'];
			$pegawai_diagnosa_id = $dat_dp['PEGAWAI_ID'];
			$hasil_diagnosa = $dat_dp['HASIL_DIAGNOSA'];
			$st_diagnosa = $dat_dp['ST_DIAGNOSA'];
		}
		
		if($hasil_diagnosa == '' and $jenis_foto != '') {
			foreach($arr_template as $row_template){
				if($row_template['JENIS_FOTO'] == $jenis_foto){
					$hasil_diagnosa = $row_template['EKSPERTISE'] . '<br />//========= template ========//';
					break;
				}	
			}
		}		
		?>
<tr><td>
	<table border="0">
		<?php foreach($arr_template as $row_template){ ?>
		<tr>
			<td><input type="radio" name="template" value="<?php echo $row_template['JENIS_FOTO']; ?>" <?php if($row_template['JENIS_FOTO'] == $jenis_foto) echo 'checked';  ?> />&nbsp;<?php echo $row_template['JENIS_FOTO']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<td><input type="button" value="pilih template" class="myButton1" onclick="pilih_template(<?php echo $_GET['idx']; ?>);"/></td>
		</tr>
	</table>
</td><td style="text-indent:5px;"><textarea name="hasil_diagnosa" id="hasil_diagnosa" ><?php echo $hasil_diagnosa; ?></textarea></td></tr>
<tr><td>&nbsp;</td><td style="text-indent:5px;">&nbsp;</td></tr>
<tr><td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokter Diagnosa</td>
<td><select name="pegawai_diagnosa_id" id="pegawai_diagnosa_id" style="width:328px;" class="text_dt" >
		<?php echo getDokter($pegawai_diagnosa_id,'17'); ?>
		</select></td>	
</tr>
<tr><td width="20%" align="center">&nbsp;</td>
<td>
	<table width="100%" border="0">
		<tr>
			<td align="right"><input type="checkbox" name="selesai" value="1" <?php if($st_diagnosa == '1') echo 'checked="checked"'; ?>/>&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="btsimpan" value="simpan" class="myButton1" onclick="simpan_diagnosa();" />
			<input type="button" value="tutup" class="myButton1" onclick="javascript : selesaikan('index.php?link=<?php echo md5('radiologisearchdiagnosa'); ?>');return false;" /></td></td>
			<td width="20%">&nbsp;</td>
		</tr>
	</table>
</td>	
</tr>
</table>
</div>
<input type="hidden" name="penunjang_tarif_id" value="<?php echo $_GET['idx']; ?>" />
<input type="hidden" name="penunjang_tarif_pemeriksaan_id" id="penunjang_tarif_pemeriksaan_id" value="<?php echo $pemeriksaan_id; ?>" />
<input type="hidden" name="idx_rawat" value="<?php echo $rawat_id; ?>" />
<input type="hidden" name="jns_ord" value="<?php echo $ord; ?>" />
<input type="hidden" name="no_ord" value="<?php echo $no_tarif; ?>" />
<input type="hidden" name="simpan" value="1" />
</form>
</div>
<?php } ?>
<script type="text/javascript" src="script/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="script/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script language="JavaScript" >
function selesaikan(link){
window.location = link;
}
function print(idx){
	window.open("index.php?print=radiologidiagnosa&idx="+ idx + "&ord=<?php echo $_GET['ord']; ?>","Diagnosa Radiologi");
}	
function download_dicom(flnm){
	window.open("index.php?dicomdownload=<?php echo $nomr . '-' ?>"+ flnm,"Diagnosa Radiologi");
}		
function simpan_diagnosa(){
	if(jQuery('#penunjang_tarif_pemeriksaan_id').val() == ''){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=cekstatusekspertise',
			data: { idx : <?php echo $_GET['idx']; ?>},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					if(data == 0){
						jQuery('#form1').submit();	
					}else{
						alert('Hasil Ekspertise Sebelumnya Belum Final / Selesai.'); 
					}
				}	
			}
		});
	}else{
		jQuery('#form1').submit();
	}	
}

function buka_diagnosa(idp){
	window.location = "<?php echo currentUrl(); ?>&idp=" + idp
}

function pilih_template(id){
	rad = document.querySelector('input[name="template"]:checked').value;
	if(rad){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=templateekspertise',
			data: { idx : id, template : rad},
			cache: false,
			success: function(data) {
				if (data.length > 0){
					window.location = "<?php echo currentUrl(); ?>"
				}	
			}
		});	
	}
}
</script>