<?php if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];
$selesai = '';

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
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa",m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
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
								ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
} else if($ord == 'irn' or $ord == 'ori'){
	$qry_diagnosa = 'SELECT t_irna_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irna_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irna_diagnosa.ICD_CODE
								ELSE CONCAT(t_irna_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irna_diagnosa
								LEFT JOIN m_icd_x ON (t_irna_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irna_diagnosa.IRNA_ID = "' . $rawat_id . '"
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
								ORDER BY t_hemodialisa_diagnosa.DIAGNOSA_ORDER';
} else if($ord == 'hri'){
	$qry_diagnosa = 'SELECT t_hemodialisa_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_hemodialisa_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_hemodialisa_diagnosa.ICD_CODE
								ELSE CONCAT(t_hemodialisa_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_hemodialisa_diagnosa
								LEFT JOIN m_icd_x ON (t_hemodialisa_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_hemodialisa_diagnosa.HEMODIALISA_ID = "' . $hemodialisa_id . '"
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
<form name="form1" method="post" >  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php 
if($ord != 'aps'){
	$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
		t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
		t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,mpegawai2.NAMA_PEGAWAI AS NAMA_DOKTER,
		m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
		t_ipenunjang_tarif.HASIL_DIAGNOSA,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,
		t_ipenunjang_tarif.NO_PHOTO,t_ipenunjang_tarif.ST_PHOTO,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
		LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
		LEFT JOIN m_pegawai mpegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = mpegawai2.PEGAWAI_ID)
		WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx . '" 
		AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
		GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
}else{
	$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,t_ipenunjang_tarif.TANGGAL_PERIKSA,
		t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
		t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,mpegawai2.NAMA_PEGAWAI AS NAMA_DOKTER,
		m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
		t_ipenunjang_tarif.HASIL_DIAGNOSA,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
		DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,
		t_ipenunjang_tarif.NO_PHOTO,t_ipenunjang_tarif.ST_PHOTO,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID
		FROM t_ipenunjang
		INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
		LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
		LEFT JOIN m_pegawai mpegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = mpegawai2.PEGAWAI_ID)
		WHERE t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $idx . '" 
		AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
		GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
		m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
}	
$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());
$dat_tarif_detail = mysql_fetch_assoc($get_tarif_detail); 
$hasil_diagnosa = $dat_tarif_detail['HASIL_DIAGNOSA'];
$pegawai_diagnosa_id = $dat_tarif_detail['PEGAWAI_DIAGNOSA_ID']; 
$st_diagnosa = $dat_tarif_detail['ST_DIAGNOSA']; 
if(empty($pegawai_diagnosa_id)) $pegawai_diagnosa_id = $_SESSION['SES_SIMRS_PEGAWAI_ID'];
?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Jenis Photo</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:400px; float:left; text-indent:5px; " align="left">&nbsp;<?php echo $dat_tarif_detail['NAMA_TARIF']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;<?php echo $dat_tarif_detail['TANGGAL_PERIKSA']; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Photo</div><br><br>	
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
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
 
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		 
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
<tr><td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Photo :</td><td>Diagnosa :</td></tr>
<tr><td width="20%" align="center">
	<div id="image">
	<?php
			$sql_photo = 'SELECT DISTINCT t_ipenunjang_tarif_photo.PHOTO_FILE FROM t_ipenunjang_tarif_photo
						WHERE t_ipenunjang_tarif_photo.PENUNJANG_TARIF_ID = "' . $_GET['idx'] . '"';
			$get_photo = mysql_query($sql_photo) or die(mysql_error());
			if(mysql_num_rows($get_photo) > 0){
				echo '<table width="100%" border="0">';
				$z = 1;
				while($dat_photo = mysql_fetch_array($get_photo)){
						echo '<tr>';
						echo '<td align="center">';
						echo '<a href="#" id="image' . $z . '">';
						echo '<div style="width:120px;border:1px solid #999; border-radius:3px;padding:1px;">'; 
						echo '<img src="dicom/thumbnail/' . $dat_photo['PHOTO_FILE'] . '" height="130px" >';
						echo '</div>';
						echo '</a>';
						?>
						<script type="text/javascript" >
						$("#image<?php echo $z; ?>").click(function() {
							$.fancybox.open({
								href : 'index.php?dicom=<?php echo $dat_photo['PHOTO_FILE']; ?>',
								type : 'iframe',
								padding : 1,
								width    : '1100px'
								});
						});
						</script>
						<?php
						echo '</td>';
						echo '</tr>';
				$z++; }
				echo '</table>';
			}
		?>
	</div>		
	</td>
	<td><textarea name="hasil_diagnosa" cols="100" rows="30" ><?php echo $hasil_diagnosa; ?></textarea></td>
</tr>
<tr><td width="20%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dokter Diagnosa</td>
<td><select name="pegawai_diagnosa_id" id="pegawai_diagnosa_id" style="width:328px;" class="text_dt" >
		<?php echo getDokter($pegawai_diagnosa_id,'17'); ?>
		</select></td>	
</tr>
<tr><td width="20%" align="center">&nbsp;</td>
<td>
	<table width="100%" border="0">
		<tr>
			<td align="right"><input type="checkbox" name="selesai" value="1" <?php if($st_diagnosa == '1') echo 'checked="checked"'; ?>/>&nbsp;&nbsp;Selesai&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" value="print" class="myButton1" onclick="javascript : print(<?php echo $_GET['idx']; ?>,'<?php echo $_GET['ord']; ?>');return false;" />
			<input type="button" value="tutup" class="myButton1" onclick="javascript : selesaikan('index.php?link=<?php echo md5('radiologisearchdiagnosa'); ?>');return false;" /></td></td>
			<td width="20%">&nbsp;</td>
		</tr>
	</table>
</td>	
</tr>
</table>
</div>
<input type="hidden" name="penunjang_tarif_id" value="<?php echo $_GET['idx']; ?>" />
</form>
</div>
<?php } ?>
<script type="text/javascript" src="script/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="script/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<script language="JavaScript" >
function selesaikan(link){
window.location = link;
}
function print(idx,ord){
	window.open("index.php?print=radiologidiagnosa&idx="+ idx + "&ord=" + ord,"Diagnosa Radiologi");
}			
</script>