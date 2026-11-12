<?php if(isset($_GET['idx']) and isset($_GET['ord']) and isset($_GET['no'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];
$no = $_GET['no'];
$selesai = '';

if(isset($_POST['simpan'])){
	$tanggal_order_ps = $_POST['tgl_order'] . ' ' . $_POST['jam_order'] . ':' . $_POST['menit_order'] . ':01'; 
	$tanggal_periksa_ps = $_POST['tgl_periksa'] . ' ' . $_POST['jam_periksa'] . ':' . $_POST['menit_periksa'] . ':01';
	
	mysql_query('UPDATE t_ipenunjang 
		JOIN t_ipenunjang_tarif 
		ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
		SET t_ipenunjang.TANGGAL_ORDER_NW = STR_TO_DATE("' . $tanggal_order_ps . '","%d/%m/%Y %H:%i:%s"),
		t_ipenunjang.TANGGAL_PERIKSA_NW = STR_TO_DATE("' . $tanggal_periksa_ps . '","%d/%m/%Y %H:%i:%s"),
		t_ipenunjang.ST_CREATE_ERM_LR = NULL,
		t_ipenunjang.USER_CM = "' . $user_name . '"
		WHERE t_ipenunjang.JNS_ORDER = "' . strtoupper($_POST['ord']) . '"
		' . (($_POST['ord'] == 'aps') ? 'AND t_ipenunjang.PENUNJANG_ID = "' . $_POST['idx'] . '"' : 'AND t_ipenunjang.RAWAT_ID = "' . $_POST['idx'] . '"') . '
		AND t_ipenunjang_tarif.NO_TARIF = "' . $_POST['no'] . '"') or die(mysql_error());
	?>	
	<script language="JavaScript" >
        alert('Simpan Data Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>	
	<?php	
}	

if($ord == 'irj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'irn'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'aps'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,t_ipenunjang.TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,t_ipenunjang.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'hrj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'hri'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"';				
}else if($ord == 'orj'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORJ"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no . '"
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'ori'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,t_ipenunjang_tarif.NO_TARIF,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,m_pasien.NO_TELEPON,
				t_ipenunjang.HEMODIALISA_ID,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.JNS_ORDER = "ORI"
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
				AND t_ipenunjang.RAWAT_ID = "' . $_GET['idx'] . '"';	
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
$operasi_id = $dat_pasien['OPERASI_ID'];
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
<form name="search" method="post" enctype="multipart/form-data">  
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th rowspan="2">No</th>
	<th rowspan="2">Permintaan Foto</th>
	<th colspan="2">Tanggal - Jam </th>
	<th colspan="2">Tanggal - Jam Baru</th>
  </tr>
 <tr>
   <th width="140">Order</th>
   <th width="140">Periksa</th>
   <th width="240">Order</th>
   <th width="240">Periksa</th>
 </tr>
	<?php 
			$x = 1;
			if($ord != 'aps'){
				$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
							t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,
							t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID_2,
							t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID_3,
							t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,
							(SELECT mp.NAMA_PEGAWAI 
								FROM t_ipenunjang_tarif_pemeriksaan tp
								INNER JOIN m_pegawai mp 
								ON (tp.PEGAWAI_ID = mp.PEGAWAI_ID)
								WHERE tp.PENUNJANG_TARIF_ID = t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY tp.PENUNJANG_TARIF_PEMERIKSAAN_ID DESC LIMIT 1) AS NAMA_DOKTER,
							m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
							t_ipenunjang_tarif.CATATAN_SPESIMEN,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
							(SELECT DATE_FORMAT(tp.TGL_DIAGNOSA,"%d/%m/%Y %H:%i:%s") 
								FROM t_ipenunjang_tarif_pemeriksaan tp
								WHERE tp.PENUNJANG_TARIF_ID = t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY tp.PENUNJANG_TARIF_PEMERIKSAAN_ID DESC LIMIT 1) AS TANGGAL_DIAGNOSA,
							t_ipenunjang_tarif.NO_PHOTO,t_ipenunjang_tarif.ST_PHOTO,
							t_ipenunjang_tarif.JENIS_FOTO,
							DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER_NW,
							DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA_NW
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							OR m_tarif.UNIT_ID = "17")
							GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
			}else{
				$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,t_ipenunjang_tarif.TANGGAL_PERIKSA,
							t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,
							t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID_2,
							t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID_3,
							t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,
							(SELECT mp.NAMA_PEGAWAI 
								FROM t_ipenunjang_tarif_pemeriksaan tp
								INNER JOIN m_pegawai mp 
								ON (tp.PEGAWAI_ID = mp.PEGAWAI_ID)
								WHERE tp.PENUNJANG_TARIF_ID = t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY tp.PENUNJANG_TARIF_PEMERIKSAAN_ID DESC LIMIT 1) AS NAMA_DOKTER,
							m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
							t_ipenunjang_tarif.CATATAN_SPESIMEN,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
							(SELECT DATE_FORMAT(tp.TGL_DIAGNOSA,"%d/%m/%Y %H:%i:%s") 
								FROM t_ipenunjang_tarif_pemeriksaan tp
								WHERE tp.PENUNJANG_TARIF_ID = t_ipenunjang_tarif.PENUNJANG_TARIF_ID
								ORDER BY tp.PENUNJANG_TARIF_PEMERIKSAAN_ID DESC LIMIT 1) AS TANGGAL_DIAGNOSA,
							t_ipenunjang_tarif.NO_PHOTO,t_ipenunjang_tarif.ST_PHOTO,
							t_ipenunjang_tarif.JENIS_FOTO,
							DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d/%m/%Y %H:%i:%s") AS TANGGAL_ORDER_NW,
							DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA_NW
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
							AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							OR m_tarif.UNIT_ID = "17")
							GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
			}	
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());
			$tgl_order_new = '';
			$tgl_periksa_new = '';
			$tgl_order_old = '';
			$tgl_periksa_old = '';
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
				$tgl_order_new = $dat_tarif_detail['TANGGAL_ORDER_NW'];
				$tgl_periksa_new = $dat_tarif_detail['TANGGAL_PERIKSA_NW'];
				$tgl_order_old = $dat_tarif_detail['TANGGAL_DAFTAR'];
				$tgl_periksa_old = $dat_tarif_detail['TANGGAL_DIAGNOSA'];
				
				$x_tgl_order_new = '';
				$x_jam_order_new = '';
				$x_mnt_order_new = '';
				$arr_tgl_order_new = explode(' ',$tgl_order_new);
				if(sizeof($arr_tgl_order_new) == 2){
					$x_tgl_order_new = $arr_tgl_order_new[0];
					$arr_jam_order = explode(':',$arr_tgl_order_new[1]);
					$x_jam_order_new = $arr_jam_order[0];
					$x_mnt_order_new = $arr_jam_order[1];
				}else{
					$arr_tgl_order = explode(' ',$tgl_order_old);
					if(sizeof($arr_tgl_order) == 2){
						$x_tgl_order_new = $arr_tgl_order[0];
						$arr_jam_order = explode(':',$arr_tgl_order[1]);
						$x_jam_order_new = $arr_jam_order[0];
						$x_mnt_order_new = $arr_jam_order[1];	
					}	
				}

				$x_tgl_periksa_new = '';
				$x_jam_periksa_new = '';
				$x_mnt_periksa_new = '';
				$arr_tgl_periksa_new = explode(' ',$tgl_periksa_new);
				if(sizeof($arr_tgl_periksa_new) == 2){
					$x_tgl_periksa_new = $arr_tgl_periksa_new[0];
					$arr_jam_periksa = explode(':',$arr_tgl_periksa_new[1]);
					$x_jam_periksa_new = $arr_jam_periksa[0];
					$x_mnt_periksa_new = $arr_jam_periksa[1];
				}else{
					$arr_tgl_periksa = explode(' ',$tgl_periksa_old);
					if(sizeof($arr_tgl_periksa) == 2){
						$x_tgl_periksa_new = $arr_tgl_periksa[0];
						$arr_jam_periksa = explode(':',$arr_tgl_periksa[1]);
						$x_jam_periksa_new = $arr_jam_periksa[0];
						$x_mnt_periksa_new = $arr_jam_periksa[1];	
					}	
				}
			?>
				<tr>
				<td width="20" align="center"><?php echo $x; ?></td>
				<td width="200px;"><?php echo $dat_tarif_detail['NAMA_TARIF']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_DAFTAR']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_DIAGNOSA']; ?></td>
				<td><input type="text" name="tgl_order" id="tgl_1" value="<?php echo $x_tgl_order_new; ?>" size="15" class="text_dt" style="width:80px;"/>
        <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>&nbsp;
		<select name="jam_order" style="width:50px;" class="text_dt" >
			<?php echo getJam($x_jam_order_new); ?>
			</select>:
			<select name="menit_order" style="width:50px;" class="text_dt" >
			<?php echo getMenit($x_mnt_order_new); ?>
			</select></td>					
				<td><input type="text" name="tgl_periksa" id="tgl_2" value="<?php echo $x_tgl_periksa_new; ?>" size="15" class="text_dt" style="width:80px;"/>
        <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>&nbsp;
		<select name="jam_periksa" style="width:50px;" class="text_dt" >
			<?php echo getJam($x_jam_periksa_new); ?>
			</select>:
			<select name="menit_periksa" style="width:50px;" class="text_dt" >
			<?php echo getMenit($x_mnt_periksa_new); ?>
			</select></td>
				</tr>
			<?php $x++; 
		}  ?>
<tr>
	<td align="right" colspan="7"> 
	<input type="hidden" name="idx" value="<?php echo $_GET['idx']; ?>" />
	<input type="hidden" name="ord" value="<?php echo $_GET['ord']; ?>" />
	<input type="hidden" name="no" value="<?php echo $_GET['no']; ?>" />
	<input type="submit" name="simpan" value="simpan" class="myButton1" />&nbsp;
	<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=c13e93fe960017e38bd7829e62113383');return false;" />
	</td>
</tr>					
</table>
</div>
</form>
</div>
<?php } ?>
<script language="JavaScript" >
function selesai(link){
	window.location = link;
}
</script>