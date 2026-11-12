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
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_irja.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
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
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_ipenunjang.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
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
				m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
				t_ipenunjang.ALAMAT_RT,t_ipenunjang.ALAMAT_RW,t_ipenunjang.HEMODIALISA_ID,
				"" AS ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (t_ipenunjang.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
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
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_irja.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
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
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_ipenunjang.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
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
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_irja.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
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
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,t_ipenunjang.HEMODIALISA_ID,
				t_ipenunjang.ST_BARU,t_ipenunjang.OPERASI_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
				LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
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
$alamat = $dat_pasien['ALAMAT'] . ' ' . $dat_pasien['ALAMAT_RT'] . ' ' . $dat_pasien['ALAMAT_RW'] . ' ' . $dat_pasien['NAMA_KELURAHAN'] . ' ' . $dat_pasien['NAMA_KECAMATAN'] . ' ' . $dat_pasien['NAMA_KOTA'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

$penunjang_id = $dat_pasien['PENUNJANG_ID'];
$pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
$nama_unit = $dat_pasien['NAMA_UNIT'] . ' (' .$dat_pasien['NAMA_PEGAWAI'] . ')';
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$rawat_id = $dat_pasien['RAWAT_ID'];

$no_telepon = $dat_pasien['NO_TELEPON'];
if($dat_pasien['ST_BARU'] == '1') $tgl_daftar = $tgl_daftar . ' (Pasien Baru)';
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
	<div style=" width:450px; float:left; text-indent:5px; " align="left"><?php echo $i + 1; echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">&nbsp;</div><br><br>
<?php
}else{
?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">&nbsp;</div>
	<div style=" width:20px; float:left; ">&nbsp;</div>
	<div style=" width:450px; float:left; text-indent:5px; " align="left"><?php echo $i + 1; echo '. ' . $dat_diagnosa['DIAGNOSA'] . ' ' . $dat_diagnosa['ICD']; ?></div>
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
</div>
  
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
if($ord != 'aps'){
$sql_form  = 'SELECT DISTINCT m_tarif_pemeriksaan.FORM_HASIL FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
							AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"	
							AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"	
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif.UNIT_ID = "45")
							ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID, 
							m_tarif_pemeriksaan.FORM_HASIL';
}else{
$sql_form  = 'SELECT DISTINCT m_tarif_pemeriksaan.FORM_HASIL
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
							AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"		
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif.UNIT_ID = "45")
							ORDER m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
							BY m_tarif_pemeriksaan.FORM_HASIL';
}							
$get_form = mysql_query($sql_form) or die(mysql_error());				
?>
<table border="1" class="tableData" id="tfhover" >
 <tr>
	<th rowspan="2">No</th>
	<th colspan="2" rowspan="2">Jenis Pemeriksaan</th>
	<th colspan="3">Tanggal - Jam </th>
	<th width="150" rowspan="2">Pemeriksa</th>
	<th width="150" rowspan="2">Penanggung Jawab</th>
	<th width="100" rowspan="2">Nomor</th>
	<th width="100" rowspan="2">Status</th>
	<th width="120" rowspan="2">Option</th>
  </tr>
 <tr>
   <th width="100">Order</th>
   <th width="100">Sampling</th>
   <th width="100">Hasil</th>
 </tr>
<?php
while($dat_form = mysql_fetch_array($get_form)){
if($ord != 'aps'){
$sql_tarif  = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
							SUM(CASE WHEN t_ipenunjang_tarif.ST_DIAGNOSA IS NULL THEN 1 ELSE 0 END) AS ST_DIAGNOSA,
							SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
							m_tarif_pemeriksaan.FORM_HASIL
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
							AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"	
							AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"	
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif.UNIT_ID = "45")
							AND m_tarif_pemeriksaan.FORM_HASIL = "' . $dat_form['FORM_HASIL'] . '"
							GROUP BY m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.FORM_HASIL
							ORDER BY m_tarif_pemeriksaan.FORM_HASIL,m_tarif_pemeriksaan.CH_REPORT';
}else{
$sql_tarif  = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
							SUM(CASE WHEN t_ipenunjang_tarif.ST_DIAGNOSA IS NULL THEN 1 ELSE 0 END) AS ST_DIAGNOSA,
							SUM(CASE WHEN t_ipenunjang_tarif.ST_PERIKSA IS NULL THEN 1 ELSE 0 END) AS ST_PERIKSA,
							m_tarif_pemeriksaan.FORM_HASIL
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
							AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"		
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif.UNIT_ID = "45")
							AND m_tarif_pemeriksaan.FORM_HASIL = "' . $dat_form['FORM_HASIL'] . '"
							GROUP BY m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.FORM_HASIL
							ORDER BY m_tarif_pemeriksaan.FORM_HASIL,m_tarif_pemeriksaan.CH_REPORT';
}							
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());	
	$i = 1;
	$x = 1;
	$st_periksa = true;
	$st_diagnosa = '';
	while($dat_tarif = mysql_fetch_array($get_tarif)){
		?>
		<tr>
		<td width="20" align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_tarif['CH_REPORT']; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		</tr>
	<?php 
			if($ord != 'aps'){
			$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,
							t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
							t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,mpegawai2.NAMA_PEGAWAI AS NAMA_DOKTER,
							m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
							t_ipenunjang_tarif.CATATAN_SPESIMEN,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
							LEFT JOIN m_pegawai mpegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = mpegawai2.PEGAWAI_ID)
							WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
							AND m_tarif_pemeriksaan.CH_REPORT = "' . $dat_tarif['CH_REPORT'] . '"
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif.UNIT_ID = "45")
							AND m_tarif_pemeriksaan.FORM_HASIL = "' . $dat_form['FORM_HASIL'] . '"
							GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
			}else{
			$sql_tarif_detail  = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF AS TARIF_X,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP,t_ipenunjang_tarif.TANGGAL_PERIKSA,
							t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
							t_ipenunjang_tarif.JENIS_FILM,m_pegawai.NAMA_PEGAWAI,mpegawai2.NAMA_PEGAWAI AS NAMA_DOKTER,
							m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,t_ipenunjang_tarif.NO_TP,t_ipenunjang_tarif.NO_PENUNJANG,
							t_ipenunjang_tarif.CATATAN_SPESIMEN,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y %H:%i:%s") AS TANGGAL_DAFTAR,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y %H:%i:%s") AS TANGGAL_PERIKSA,
							DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y %H:%i:%s") AS TANGGAL_SAMPLING
							FROM t_ipenunjang
							INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
							INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
							INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
							INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
							LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
							LEFT JOIN m_pegawai mpegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = mpegawai2.PEGAWAI_ID)
							WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
							AND m_tarif_pemeriksaan.CH_REPORT = "' . $dat_tarif['CH_REPORT'] . '"
							AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif.UNIT_ID = "45")
							AND m_tarif_pemeriksaan.FORM_HASIL = "' . $dat_form['FORM_HASIL'] . '"
							GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.NAMA_TARIF,
							m_tarif.SATUAN,m_tarif_group.NAMA_TARIF_GROUP';
			}	
			$get_tarif_detail = mysql_query($sql_tarif_detail) or die(mysql_error());
			while($dat_tarif_detail = mysql_fetch_array($get_tarif_detail)){
			?>
				<tr>
				<td colspan="2">&nbsp;</td>
				<td><?php echo $dat_tarif_detail['NAMA_TARIF']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_DAFTAR']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_SAMPLING']; ?></td>
				<td align="center"><?php echo $dat_tarif_detail['TANGGAL_PERIKSA']; ?></td>
				<td><?php echo $dat_tarif_detail['NAMA_PEGAWAI']; ?></td>
				<td><?php echo $dat_tarif_detail['NAMA_DOKTER']; ?></td>
				<td><?php echo $dat_tarif_detail['NO_TP']; ?></td> 
				<td align="center"><?php if($dat_tarif_detail['ST_PERIKSA'] == '1'){ echo 'Lengkap'; }else{ echo 'Belum Lengkap'; $st_periksa = false; } ?></td>
				<td align="center">&nbsp;</td>
				</tr>
			<?php $st_diagnosa =  $dat_tarif_detail['ST_DIAGNOSA'];
			$x++; }  ?>	
<?php $i++; } 
?>
<tr>
		<td colspan="9">&nbsp;</td>
		<td align="center" colspan="2">
		<input type="button" value="hasil diagnosa" class="myButton1" onclick="javascript : diagnosa('index.php?link=<?php echo md5('laboratoriumformeditdiagnosa'); ?>&idx=<?php echo $idx; ?>&no=<?php echo $no; ?>&ord=<?php echo $_GET['ord']; ?>&fr=<?php echo $dat_form['FORM_HASIL']; ?>'); return false;" />
		</td></tr>		
<?php } ?> 
<tr>
		<td colspan="9">&nbsp;</td>
		<td align="center" colspan="2"><div id="sdiagnosa"></div> 
		<?php if($st_periksa == true){ ?>
		<input type="checkbox" name="st_diagnosa" id="st_diagnosa" value="1" <?php if($st_diagnosa== '1') echo 'checked="checked"'; ?> onclick="JavaScript : centang_opt('st_diagnosa','<?php echo $idx; ?>','<?php echo $ord; ?>','<?php echo $no; ?>');" />&nbsp;Selesai&nbsp;&nbsp;
		<?php } ?>
		<input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('laboratoriumsearchorder'); ?>');return false;" />
		</td></tr>		
</table>
</div>
</div>
<?php } ?>
<script language="JavaScript" >
function selesai(link){
window.location = link;
}

function diagnosa(link){
window.location = link;
}

function centang_opt(ck,id,ord,no){
	if(document.getElementById(ck).checked){
		if(confirm('Selesai ?')){
			MyAjaxRequest('sdiagnosa','index.php?ajaxrequest=laboratoriumstdiagnosa&opt=1&id=' + id + '&ord=' + ord + '&no=' + no);
		}else{
			document.getElementById(ck).checked = false;
		}
		return false;
	}else{
		MyAjaxRequest('sdiagnosa','index.php?ajaxrequest=laboratoriumstdiagnosa&opt=2&id=' + id + '&ord=' + ord + '&no=' + no);
		return false;
	}
}

</script>