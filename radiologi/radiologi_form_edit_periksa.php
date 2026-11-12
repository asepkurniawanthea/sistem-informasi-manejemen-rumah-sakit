<?php if(isset($_GET['idx']) and isset($_GET['ord']) and isset($_GET['no'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];
$no = $_GET['no'];
$selesai = '';

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

if(isset($_POST['simpan'])) include('radiologi/radiologi_save_periksa.php');
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
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th rowspan="2">No</th>
	<th colspan="2" rowspan="2">Permintaan Foto</th>
	<th colspan="3">Tanggal - Jam </th>
	<th rowspan="2">Jenis Film</th>
	<th rowspan="2">Jenis Foto</th>
	<th width="150" rowspan="2">Radiografer</th>
	<th width="150" rowspan="2">Dokter Diagnosa</th>
	<th width="100" rowspan="2">Nomor<br />DICOM ID</th>
	<th width="100" rowspan="2">Foto</th>
	<th width="100" rowspan="2">Selesai</th>
  </tr>
 <tr>
   <th width="100">Order</th>
   <th width="100">Ambil Foto</th>
   <th width="100">Diagnosa</th>
 </tr>
	<?php 
			$x = 1;
			if($ord != 'aps'){
			$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
							t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
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
							t_ipenunjang_tarif.JENIS_FOTO
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
							t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
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
							t_ipenunjang_tarif.JENIS_FOTO
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
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
				<tr>
				<td colspan="2" align="center"><?php echo $x; ?></td>
				<td width="200px;"><?php echo $dat_tarif_detail['NAMA_TARIF']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_DAFTAR']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_PERIKSA']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_DIAGNOSA']; ?></td>
				<td><select name="jenis_film<?php echo $x; ?>" id="jenis_film<?php echo $x; ?>" class="text_dt" style="width:100px;" >
						<option value="" > - </option>
						<?php echo getJenisFilm($dat_tarif_detail['JENIS_FILM']); ?>
					</select></td>
				<td><select name="jenis_foto<?php echo $x; ?>" id="jenis_foto<?php echo $x; ?>" class="text_dt" style="width:100px;" >
						<option value="" > - </option>
						<?php $get_foto = mysql_query('SELECT * FROM m_radiologi_template_ekspertise ORDER BY JENIS_FOTO') or die(mysql_error()); 
							while($dat_foto = mysql_fetch_array($get_foto)){
								echo '<option value="' . $dat_foto['JENIS_FOTO'] . '" ' . (($dat_foto['JENIS_FOTO'] == $dat_tarif_detail['JENIS_FOTO']) ? 'selected="selected"' : '') . '>' . $dat_foto['JENIS_FOTO'] . '</option>';	
							}
						?>
					</select></td>					
				<td><select name="pegawai_id<?php echo $x; ?>" id="pegawai_id<?php echo $x; ?>" style="width:128px;" class="text_dt" >
					<option value=""> - </option>
					<?php echo getPelaksanaPenunjang($dat_tarif_detail['PEGAWAI_PERIKSA_ID'],'17'); ?>
					</select></td>
				<td><?php echo $dat_tarif_detail['NAMA_DOKTER']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['NO_TP']; ?></td> 
				<td align="center">
				<?php
					echo '<div id="dicom_image' . $x . '">';
					$sql_photo = 'SELECT DISTINCT t_ipenunjang_tarif_photo.PHOTO_FILE FROM t_ipenunjang_tarif_photo
								WHERE t_ipenunjang_tarif_photo.PENUNJANG_TARIF_ID = "' . $dat_tarif_detail['PENUNJANG_TARIF_ID'] . '"';
					$get_photo = mysql_query($sql_photo) or die(mysql_error());
						if(mysql_num_rows($get_photo) > 0){
						echo '<table width="100%" class="bta">';
							$z = 1;
							while($dat_photo = mysql_fetch_array($get_photo)){
								echo '<tr><td align="center">';
								echo '<img id="image' . $z . '" src="http://' . $_SERVER['SERVER_NAME'] . '/radiologi/assets/radiologi/jpeg/thumbnail/' . $dat_photo['PHOTO_FILE'] . '.jpg" height="120" >';
								echo '</td></tr>';
							$z++; }
						echo '</table>';
						}
					echo '</div>';	
				?>
				</td>
				<td align="center"><input type="checkbox" name="selesai<?php echo $x; ?>" value="1" <?php if($dat_tarif_detail['ST_PERIKSA'] == '1') echo 'checked="checked"'; ?> />
				<?php
					$sql_print = 'SELECT tp.ST_DIAGNOSA,tp.PENUNJANG_TARIF_PEMERIKSAAN_ID 
								FROM t_ipenunjang_tarif_pemeriksaan tp
								WHERE tp.PENUNJANG_TARIF_ID = "' . $dat_tarif_detail['PENUNJANG_TARIF_ID'] . '"
								ORDER BY tp.PENUNJANG_TARIF_PEMERIKSAAN_ID DESC LIMIT 1';
					$get_print = mysql_query($sql_print) or die(mysql_error());
					$dat_print = mysql_fetch_assoc($get_print);
					if($dat_print['ST_DIAGNOSA'] == '1'){	
				?>
				<a href="#" onclick="javascript : print(<?php echo $dat_print['PENUNJANG_TARIF_PEMERIKSAAN_ID']; ?>,'<?php echo $ord; ?>');return false;" >print</a>
					<?php } ?>
				<input type="hidden" name="penunjang_tarif_id<?php echo $x; ?>" id="penunjang_tarif_id<?php echo $x; ?>" value="<?php echo $dat_tarif_detail['PENUNJANG_TARIF_ID']; ?>" /> </td>
				</tr>
			<?php $x++; }  ?>		
</table>
<table border="0" width="100%">
	<tr>
		<td align="right">
		<input type="submit" name="simpan" value="simpan" class="myButton1" />
		<input type="hidden" name="cnt" value="<?php echo $x; ?>" />
		<input type="hidden" name="idx_rawat" value="<?php echo $idx; ?>" />
		<input type="hidden" name="jns_ord" value="<?php echo $ord; ?>" />
		<input type="hidden" name="no_ord" value="<?php echo $no; ?>" />
		<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('radiologisearchorder'); ?>');return false;" /></td>
	</tr>
</table>
</div>
</form>
</div>
<script type="text/javascript" src="script/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="script/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<?php } ?>
<script language="JavaScript" >
function selesai(link){
window.location = link;
}

$(document).ready(function(){
	setInterval(function(){refresh_dicom()},3000);
});
				
function refresh_dicom(){
	<?php $w = 1;
		while ($w < $x){
		?>
			MyAjaxRequest('dicom_image<?php echo $w; ?>','index.php?ajaxrequest=getdicomimage&id=' + document.getElementById('penunjang_tarif_id<?php echo $w; ?>').value);
		<?php
		$w++; } ?>
	return false;
}

function print(idx,ord){
	window.open("index.php?print=radiologidiagnosa&idx="+ idx + "&ord=" + ord,"Diagnosa Radiologi");
}
</script>