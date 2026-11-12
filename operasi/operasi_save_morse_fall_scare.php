<?php
$_err = '';
	
$morse_fall_scale_id = $_POST['morse_fall_scale_id'];
$riwayat_jatuh = '';
if(isset($_POST['riwayat_jatuh'])) $riwayat_jatuh = $_POST['riwayat_jatuh'];
$diagnosis_sekunder = '';
if(isset($_POST['diagnosis_sekunder'])) $diagnosis_sekunder = $_POST['diagnosis_sekunder'];
$alat_bantu = '';
if(isset($_POST['alat_bantu'])) $alat_bantu = $_POST['alat_bantu'];
$terpasang_infus = '';
if(isset($_POST['terpasang_infus'])) $terpasang_infus = $_POST['terpasang_infus'];
$gaya_berjalan = '';
if(isset($_POST['gaya_berjalan'])) $gaya_berjalan = $_POST['gaya_berjalan'];
$status_mental = '';
if(isset($_POST['status_mental'])) $status_mental = $_POST['status_mental'];
	
$user_name = currentUser();
$operasi_id = $_POST['operasi_id'];

if (isset($_POST['simpan'])) {
		
    $sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	if (empty($_err)) {
		if(empty($morse_fall_scale_id)){
			mysql_query('INSERT INTO t_operasi_morse_fall_scale (RIWAYAT_JATUH,DIAGNOSIS_SEKUNDER,ALAT_BANTU,TERPASANG_INFUS,GAYA_BERJALAN,STATUS_MENTAL,USER_OPERASI,OPERASI_ID) VALUES ("'.$riwayat_jatuh.'","'.$diagnosis_sekunder.'","'.$alat_bantu.'","'.$terpasang_infus.'","'.$gaya_berjalan.'","'.$status_mental.'","'.$user_name.'","'.$operasi_id.'")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_operasi_morse_fall_scale SET MORSE_FALL_SCALE_ID = "'.$morse_fall_scale_id.'",RIWAYAT_JATUH = "'.$riwayat_jatuh.'",DIAGNOSIS_SEKUNDER = "'.$diagnosis_sekunder.'",ALAT_BANTU = "'.$alat_bantu.'",TERPASANG_INFUS = "'.$terpasang_infus.'",GAYA_BERJALAN = "'.$gaya_berjalan.'",STATUS_MENTAL = "'.$status_mental.'" WHERE MORSE_FALL_SCALE_ID = "'.$morse_fall_scale_id.'"') or die(mysql_error());
		}			  
?>
<script language="JavaScript" >
	alert('Simpan Data Morse Fall Scale Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
	}
}
?>