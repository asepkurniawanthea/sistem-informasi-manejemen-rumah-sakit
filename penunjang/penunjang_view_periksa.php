<?php if(isset($_GET['idx']) and isset($_GET['ord'])){
$idx = $_GET['idx'];
$ord = $_GET['ord'];
$selesai = '';
if($ord == 'irj'){
$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'irn'){
$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'aps'){
	$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				t_ipenunjang.NAMA_PASIEN,t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,t_ipenunjang.ALAMAT,
				t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN, "" AS RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang.PENGIRIM AS NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,"" AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,t_ipenunjang.JNS_KELAMIN,t_ipenunjang.NIK,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "APS"
				AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'hrj'){
$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';
}else if($ord == 'hri'){
$qry_pasien = 'SELECT t_ipenunjang.PENUNJANG_ID,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,m_pasien.ALAMAT,
				CONCAT(m_ruang.NAMA_RUANG," Kelas",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
				m_jaminan.NAMA_JAMINAN,t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.TANGGAL_BAYAR,
				t_ipenunjang_tarif.NO_PEMBAYARAN,m_pegawai.NAMA_PEGAWAI,t_ipenunjang.JNS_ORDER,t_ipenunjang.RUANG_ID AS UNIT_ID,
				t_ipenunjang_tarif.ST_BAYAR,m_pasien.JNS_KELAMIN,m_pasien.NIK,t_ipenunjang.RAWAT_ID,
				t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,t_ipenunjang_tarif.HASIL_DIAGNOSA,
				t_ipenunjang.HEMODIALISA_ID
				FROM t_ipenunjang
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_ipenunjang.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID) 
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"';				
}				
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$nama_pasien = $dat_pasien['NAMA_PASIEN'];
$tgl_lahir = $dat_pasien['TGL_LAHIR'];
$jns_kelamin = $dat_pasien['JNS_KELAMIN'];
$alamat = $dat_pasien['ALAMAT'];
$nik = $dat_pasien['NIK'];
$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];

$penunjang_id = $dat_pasien['PENUNJANG_ID'];
$pegawai_id = $dat_pasien['NAMA_PEGAWAI'];
$nama_unit = $dat_pasien['NAMA_UNIT'] . ' (' .$dat_pasien['NAMA_PEGAWAI'] . ')';
$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
$rawat_id = $dat_pasien['RAWAT_ID'];

$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);

$hasil_diagnosa = $dat_pasien['HASIL_DIAGNOSA'];
$pegawai_id = $dat_pasien['PEGAWAI_PERIKSA_ID'];
$selesai = $dat_pasien['ST_PERIKSA'];
$hemodialisa_id = $dat_pasien['HEMODIALISA_ID'];
?>
<div style=" height:auto; padding:15px; ">

<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
   <?php include('pasien/pasien_view_short.php'); ?>
	<div style=" width:250px; float:left; text-indent:25px; " align="left">Klinik/Ruang/Instansi</div>
	<div style=" width:20px; float:left; ">:</div>
	<div style=" width:250px; float:left; text-indent:5px; " align="left"><?php echo $nama_unit; ?></div>
	<div style=" width:250px; float:right; text-indent:5px; " align="left"><?php echo $tgl_daftar; ?></div>
	<div style=" width:20px; float:right; ">:</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="left">Tanggal Daftar</div><br><br>
<?php 
if($ord == 'irj'){
	$qry_diagnosa = 'SELECT t_irja_diagnosa.DIAGNOSA,
								CASE WHEN TRIM(t_irja_diagnosa.DIAGNOSA) = TRIM(m_icd_x.DESKRIPSI) THEN t_irja_diagnosa.ICD_CODE
								ELSE CONCAT(t_irja_diagnosa.ICD_CODE,"--",m_icd_x.DESKRIPSI) END AS ICD
								FROM t_irja_diagnosa
								LEFT JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								WHERE t_irja_diagnosa.IRJA_ID = "' . $rawat_id . '"
								ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER';
} else if($ord == 'irn'){
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
	<div style=" width:250px; float:right; text-indent:5px; " align="right"><input type="button" value="tutup" class="myButton1" onclick="javascript : selesai('index.php?link=<?php echo md5('penunjangsearchorder'); ?>');return false;" /></div>
	<div style=" width:20px; float:right; ">&nbsp;</div>
	<div style=" width:250px; float:right; text-indent:25px; " align="right">&nbsp;</div><br>
</div>
  
   <div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<?php
$qry_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				t_ipenunjang_tarif.ST_BAYAR,m_pegawai.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
				AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
				AND (m_tarif_group.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" OR m_tarif.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '")
				ORDER BY t_ipenunjang.NO_ORDER';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<table class="tableData" id="tfhover" >
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
    <th colspan="3">Nama Pemeriksaan</th>
    <th>Tarif (Rp.)</th>
	<th>Pemeriksa</th>
	<th>Tanggal Periksa</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>	
		<td align="center"><?php echo $dat_tarif['TANGGAL_ORDER']; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_TARIF']; ?></td>
		<td colspan="3">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td><?php echo $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td align="center"><?php echo $dat_tarif['TANGGAL_PERIKSA']; ?></td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['TANGGAL_PERIKSA'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">&nbsp;</td>
    </tr>
    <?php
		if(empty($dat_tarif['NO_TARIF'])){
		$qry_det_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.USER_PENDAFTARAN
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
				AND t_ipenunjang_tarif.NO_SJP = "' . $_GET['no'] . '"
				AND (m_tarif_group.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" OR m_tarif.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '")
				AND t_ipenunjang_tarif.NO_TARIF IS NULL';
		}else{
		$qry_det_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,t_ipenunjang_tarif.USER_PENDAFTARAN
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $_GET['idx'] . '"
				AND t_ipenunjang.JNS_ORDER = "' . $ord . '" 
				AND t_ipenunjang_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"
				AND (m_tarif_group.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '" OR m_tarif.UNIT_ID = "' . $_SESSION['SES_SIMRS_UNIT_ID'] . '")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL';
		}		
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
		?>
		<tr>
        <td colspan="3">&nbsp;</td>	
		<td width="10"><?php echo $y; ?></td>
		<td colspan="2"><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td align="right"><?php echo currFormat($dat_det_tarif['TARIF_NON_KELAS']); ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>	
		<td>&nbsp;</td>	
		<td align="center" width="110">&nbsp;</td>
    </tr>
		<?php
		$y++; $total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
		}
		?>
		<tr>
		<td align="right" colspan="7">Total : Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
    </tr>
		<?php
    $i++;
	} 
if(mysql_num_rows($get_tarif) == 0){
	?>
	<tr>
		<td colspan="11">&nbsp;</td>
	</tr>
	<?php
}	
?>
</table>
<br />
<form name="formedit" method="post">
<table width="100%" border="0">	
        <tr>
			<td>&nbsp;</td>
			<td>Catatan</td>
            <td><textarea name="hasil_diagnosa" class="text_dt5"><?php echo $hasil_diagnosa; ?></textarea></td>	
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td>Pemeriksa</td>
            <td><select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getPelaksanaPenunjang($pegawai_id, $_SESSION['SES_SIMRS_UNIT_ID']); ?>
                </select></td>	
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
            <td align="right">
			<input type="checkbox" name="selesai" value="1" <?php if($selesai == '1') echo 'checked="checked"'; ?> />&nbsp;Selesai</td>	
        </tr>
</table>
<input type="hidden" name="penunjang_id" value="<?php echo $_GET['idx']; ?>" />
<input type="hidden" name="no_sjp" value="<?php echo $_GET['no']; ?>" />
</form>
</div>
</div>
<?php } ?>
<script language="JavaScript" >
function selesai(link){
window.location = link;
}
</script>