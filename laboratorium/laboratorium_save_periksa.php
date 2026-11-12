<?php
$cnt = $_POST['cnt'];
$penunjang_id = $_POST['penunjang_id'];

$sql_cek_no = 'SELECT NO_PENUNJANG FROM t_ipenunjang WHERE PENUNJANG_ID = "' . $penunjang_id . '"';
$get_cek_no = mysql_query($sql_cek_no) or die(mysql_error());
$dat_cek_no = mysql_fetch_assoc($get_cek_no);
if(empty($dat_cek_no['NO_PENUNJANG']) or $_SESSION['SES_SIMRS_ADMIN'] == '1'){ 

if($cnt > 1){
$ret = true;
$l = 1;
while ($l < $cnt){
	if(isset($_POST['id' . $l]) and isset($_POST['pegawai_id' . $l]) and isset($_POST['nomor_id' . $l])){
	$penunjang_tarif_id = $_POST['id' . $l];
	$pegawai_id = $_POST['pegawai_id' . $l];
	$nomor_id = $_POST['nomor_id' . $l];
	if(!empty($pegawai_id)){
		mysql_query('UPDATE t_ipenunjang_tarif SET
				PEGAWAI_PERIKSA_ID = "' . $pegawai_id . '",
				TANGGAL_PERIKSA = NOW(),ST_PERIKSA = "1",
				SHIFT_PENUNJANG = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
				NO_TP = "' . $nomor_id . '"
				WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_id . '"') or die(mysql_error());
		}else{
		$ret = false;
	}	
	}	
$l++;	}
mysql_query('UPDATE t_ipenunjang SET USER_PENUNJANG = "' . $user_name . '"
			WHERE PENUNJANG_ID = "' . 	$penunjang_id . '"') or die(mysql_error());
if($ret == true){
	$nomor = getNomorHarian('Laboratorium');			
	mysql_query('UPDATE t_ipenunjang SET NO_PENUNJANG = "' . $nomor . '"
			WHERE PENUNJANG_ID = "' . 	$penunjang_id . '" AND NO_PENUNJANG IS NULL') or die(mysql_error());
		}
	}
}			
?>
<script language="JavaScript" >
	alert('Simpan Data Pemeriksaan Laboratorium Berhasil.');
</script> 