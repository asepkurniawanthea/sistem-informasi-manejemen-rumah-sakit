<?php
$penunjang_id = $_POST['penunjang_id'];
$penunjang_tarif_id = $_POST['penunjang_tarif_id'];
$hasil_tindakan = $_POST['hasil_tindakan'];
$pemeriksa = $_POST['pemeriksa'];

$selesai = 'NULL';
if(isset($_POST['selesai'])) $selesai = '"1"';
$ret = true;

function cekStatus($id){
	$ret = false;
	$sql_status = 'SELECT DISTINCT ST_DIAGNOSA FROM t_ipenunjang_tarif
					WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"';
	$get_status = mysql_query($sql_status) or die(mysql_error());
	$dat_status = mysql_fetch_assoc($get_status);
	if($dat_status['ST_DIAGNOSA'] == '1') $ret = true;
return $ret;	
}


if($selesai == 'NULL'){
	if($_SESSION['SES_SIMRS_ADMIN'] == '1'){
		mysql_query('UPDATE t_ipenunjang_tarif SET ST_DIAGNOSA = NULL
					WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"') or die(mysql_error());
		}			
}

$nomor = getNomorHarian('Penunjang');
mysql_query('UPDATE t_ipenunjang_tarif SET ST_DIAGNOSA = ' . $selesai . ',
			ST_PERIKSA = ' . $selesai . ',
			TANGGAL_DIAGNOSA = NOW(),
			HASIL_DIAGNOSA = "' . $hasil_tindakan . '",
			PEGAWAI_PERIKSA_ID = "' . $pemeriksa . '",
			USER_DIAGNOSA = "' . $user_name . '",
			TANGGAL_PERIKSA = NOW(),
			SHIFT_PENUNJANG = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
			NO_TP = "' . $nomor . '"
			WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"
			AND ST_DIAGNOSA IS NULL') or die(mysql_error());
					
if($selesai == '"1"'){				
	mysql_query('UPDATE t_ipenunjang SET NO_PENUNJANG = "' . $nomor . '", USER_PENUNJANG = "' . $user_name . '"
				WHERE PENUNJANG_ID = "' . 	$penunjang_id . '" AND NO_PENUNJANG IS NULL') or die(mysql_error());
}
				

?>
<script language="JavaScript" >
	alert('Simpan Data Diagnosa Laboratorium Berhasil.');
</script> 