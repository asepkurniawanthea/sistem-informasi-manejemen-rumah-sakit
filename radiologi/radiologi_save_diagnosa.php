<?php
$xhasil_diagnosa = $_POST['hasil_diagnosa'];
$xpenunjang_tarif_id = $_POST['penunjang_tarif_id'];
$xpegawai_diagnosa_id = $_POST['pegawai_diagnosa_id'];
$xtarif_pemeriksaan_id = $_POST['penunjang_tarif_pemeriksaan_id'];

$xhasil_diagnosa = str_replace('<p>','<br />',$xhasil_diagnosa);
$xhasil_diagnosa = str_replace('</p>','',$xhasil_diagnosa);
 
$selesai = 'NULL';
if(isset($_POST['selesai'])) $selesai = '"1"';

$pesan_simpan = 'Simpan Data Diagnosa Radiologi Berhasil.';
$_err = '';
if($_err == ''){
	
	if($xtarif_pemeriksaan_id == ''){
		$sql_revisi = 'SELECT COUNT(PENUNJANG_TARIF_PEMERIKSAAN_ID) AS REVISI
				FROM t_ipenunjang_tarif_pemeriksaan 
				WHERE PENUNJANG_TARIF_ID = "' . $xpenunjang_tarif_id . '"';
		$get_revisi = mysql_query($sql_revisi) or die(mysql_error());
		$dat_revisi = mysql_fetch_assoc($get_revisi);
		mysql_query('INSERT INTO t_ipenunjang_tarif_pemeriksaan (PENUNJANG_TARIF_ID,REVISI,HASIL_DIAGNOSA,PEGAWAI_ID,
				TGL_DIAGNOSA,ST_DIAGNOSA,USER_DIAGNOSA,ST_CREATE_ERM_RADIOLOGI)
				VALUES ("' . $xpenunjang_tarif_id . '","' . $dat_revisi['REVISI'] . '",
				"' . mysql_real_escape_string($xhasil_diagnosa) . '",
				"' . $xpegawai_diagnosa_id . '",NOW(),' . $selesai . ',"' . $user_name . '",
				NULL)') or die(mysql_error());
		$tarif_pemeriksaan_id_erm = '';
		$sql_id = 'SELECT PENUNJANG_TARIF_PEMERIKSAAN_ID
			FROM t_ipenunjang_tarif_pemeriksaan
			WHERE PENUNJANG_TARIF_ID = "' . $xpenunjang_tarif_id . '"
			ORDER BY PENUNJANG_TARIF_PEMERIKSAAN_ID
			DESC LIMIT 1';
		$get_id = mysql_query($sql_id) or die(mysql_error());	
		$dat_id = mysql_fetch_assoc($get_id);
		$tarif_pemeriksaan_id_erm = $dat_id['PENUNJANG_TARIF_PEMERIKSAAN_ID'];
		//edoc rekam medic
		//include('lib/vendor/autoload.php');
		//include('lib/html2openxml/HTMLtoOpenXML.php');
		//include('edoc_rekammedik/new/erm_create_radiologi.php');
		//erm_radiologi($tarif_pemeriksaan_id_erm,$ord,$_SESSION['SES_SIMRS_NAMA_PEGAWAI']);
		//	
	}else{
		$sql_cek_no = 'SELECT tp.PEGAWAI_ID,mp.NAMA_PEGAWAI 
				FROM t_ipenunjang_tarif_pemeriksaan tp
				INNER JOIN m_pegawai mp ON (tp.PEGAWAI_ID = mp.PEGAWAI_ID)
				WHERE tp.PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $xtarif_pemeriksaan_id . '"';
		$get_cek_no = mysql_query($sql_cek_no) or die(mysql_error());
		$dat_cek_no = mysql_fetch_assoc($get_cek_no);
		$pegawai_owner = $dat_cek_no['PEGAWAI_ID'];
		$nama_pegawai_owner = $dat_cek_no['NAMA_PEGAWAI'];
		if($pegawai_owner == $_SESSION['SES_SIMRS_PEGAWAI_ID'] or $_SESSION['SES_SIMRS_ADMIN'] == '1'){
			mysql_query('UPDATE t_ipenunjang_tarif_pemeriksaan 
				SET HASIL_DIAGNOSA = "' . mysql_real_escape_string($xhasil_diagnosa) . '",
				PEGAWAI_ID = "' . $xpegawai_diagnosa_id . '",
				TGL_DIAGNOSA = NOW(),
				ST_DIAGNOSA = ' . $selesai . ',
				USER_DIAGNOSA = "' . $user_name . '",
				ST_CREATE_ERM_RADIOLOGI = NULL
				WHERE PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $xtarif_pemeriksaan_id . '"') or die(mysql_error());
			//edoc rekam medic
			//include('lib/vendor/autoload.php');
			//include('lib/html2openxml/HTMLtoOpenXML.php');
			//include('edoc_rekammedik/new/erm_create_radiologi.php');
			//erm_radiologi($xtarif_pemeriksaan_id,$ord,$_SESSION['SES_SIMRS_NAMA_PEGAWAI']);
			//	
		}else{
			$pesan_simpan = 'Simpan Data Diagnosa Radiologi Gagal. Anda Bukan ' . $nama_pegawai_owner . '.';
		}		
	}	
?>
<script language="JavaScript" >
	alert('<?php echo $pesan_simpan; ?>');
	window.location = "index.php?link=<?php echo $_GET['link']; ?>&idx=<?php echo $_GET['idx']; ?>&ord=<?php echo $_GET['ord']; ?>";
</script> 
<?php
}else{
$msg_info = $_err;
}	
?>