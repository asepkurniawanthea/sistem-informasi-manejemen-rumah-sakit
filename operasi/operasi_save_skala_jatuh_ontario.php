<?php
$_err = '';
	
$skala_jatuh_id = $_POST['skala_jatuh_id'];
$riwayat_jatuh_datang = '';
if(isset($_POST['riwayat_jatuh_datang'])) $riwayat_jatuh_datang = $_POST['riwayat_jatuh_datang'];
$riwayat_jatuh_2_bulan = '';
if(isset($_POST['riwayat_jatuh_2_bulan'])) $riwayat_jatuh_2_bulan = $_POST['riwayat_jatuh_2_bulan'];
$status_mental_delirium = '';
if(isset($_POST['status_mental_delirium'])) $status_mental_delirium = $_POST['status_mental_delirium'];
$status_mental_disorientasi = '';
if(isset($_POST['status_mental_disorientasi'])) $status_mental_disorientasi = $_POST['status_mental_disorientasi'];
$status_mental_agitasi = '';
if(isset($_POST['status_mental_agitasi'])) $status_mental_agitasi = $_POST['status_mental_agitasi'];
$penglihatan_kacamata = '';
if(isset($_POST['penglihatan_kacamata'])) $penglihatan_kacamata = $_POST['penglihatan_kacamata'];
$penglihatan_buram = '';
if(isset($_POST['penglihatan_buram'])) $penglihatan_buram = $_POST['penglihatan_buram'];
$penglihatan_glukoma = '';
if(isset($_POST['penglihatan_glukoma'])) $penglihatan_glukoma = $_POST['penglihatan_glukoma'];
$kebiasaan_berkemih = '';
if(isset($_POST['kebiasaan_berkemih'])) $kebiasaan_berkemih = $_POST['kebiasaan_berkemih'];
$transfer_mandiri = '';
if(isset($_POST['transfer_mandiri'])) $transfer_mandiri = $_POST['transfer_mandiri'];
$transfer_bantuan_1_orang = '';
if(isset($_POST['transfer_bantuan_1_orang'])) $transfer_bantuan_1_orang = $_POST['transfer_bantuan_1_orang'];
$transfer_bantuan_2_orang = '';
if(isset($_POST['transfer_bantuan_2_orang'])) $transfer_bantuan_2_orang = $_POST['transfer_bantuan_2_orang'];
$transfer_bantuan_total = '';
if(isset($_POST['transfer_bantuan_total'])) $transfer_bantuan_total = $_POST['transfer_bantuan_total'];
$mobilitas_mandiri = '';
if(isset($_POST['mobilitas_mandiri'])) $mobilitas_mandiri = $_POST['mobilitas_mandiri'];
$mobilitas_bantuan_1_orang = '';
if(isset($_POST['mobilitas_bantuan_1_orang'])) $mobilitas_bantuan_1_orang = $_POST['mobilitas_bantuan_1_orang'];
$mobilitas_kursi_roda = '';
if(isset($_POST['mobilitas_kursi_roda'])) $mobilitas_kursi_roda = $_POST['mobilitas_kursi_roda'];
$immobilisasi = '';
if(isset($_POST['immobilisasi'])) $immobilisasi = $_POST['immobilisasi'];
	
$user_name = currentUser();
$operasi_id = $_POST['operasi_id'];

if (isset($_POST['simpan'])) {
		
    $sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	if (empty($_err)) {
		if(empty($skala_jatuh_id)){
			mysql_query('INSERT INTO t_operasi_skala_jatuh_ontario (SKALA_JATUH_ID,OPERASI_ID,RIWAYAT_JATUH_DATANG,RIWAYAT_JATUH_2_BULAN,STATUS_MENTAL_DELIRIUM,STATUS_MENTAL_DISORIENTASI,
			STATUS_MENTAL_AGITASI,PENGLIHATAN_KACAMATA,PENGLIHATAN_BURAM,PENGLIHATAN_GLUKOMA,KEBIASAAN_BERKEMIH,TRANSFER_MANDIRI,
			TRANSFER_BANTUAN_1_ORANG,TRANSFER_BANTUAN_2_ORANG,TRANSFER_BANTUAN_TOTAL,MOBILITAS_MANDIRI,MOBILITAS_BANTUAN_1_ORANG,
			MOBILITAS_KURSI_RODA,IMMOBILISASI,USER_OPERASI) 
			VALUES ("'.$skala_jatuh_id.'","'.$operasi_id.'","'.$riwayat_jatuh_datang.'","'.$riwayat_jatuh_2_bulan.'","'.$status_mental_delirium.'","'.$status_mental_disorientasi.'","'.$status_mental_agitasi.'","'.$penglihatan_kacamata.'","'.$penglihatan_buram.'","'.$penglihatan_glukoma.'","'.$kebiasaan_berkemih.'","'.$transfer_mandiri.'","'.$transfer_bantuan_1_orang.'","'.$transfer_bantuan_2_orang.'","'.$transfer_bantuan_total.'","'.$mobilitas_mandiri.'","'.$mobilitas_bantuan_1_orang.'","'.$mobilitas_kursi_roda.'","'.$immobilisasi.'","'.$user_name.'")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_operasi_skala_jatuh_ontario SET SKALA_JATUH_ID = "'.$skala_jatuh_id.'",OPERASI_ID = "'.$operasi_id.'",RIWAYAT_JATUH_DATANG = "'.$riwayat_jatuh_datang.'",RIWAYAT_JATUH_2_BULAN = "'.$riwayat_jatuh_2_bulan.'",STATUS_MENTAL_DELIRIUM = "'.$status_mental_delirium.'",STATUS_MENTAL_DISORIENTASI = "'.$status_mental_disorientasi.'",STATUS_MENTAL_AGITASI = "'.$status_mental_agitasi.'",PENGLIHATAN_KACAMATA = "'.$penglihatan_kacamata.'",PENGLIHATAN_BURAM = "'.$penglihatan_buram.'",PENGLIHATAN_GLUKOMA = "'.$penglihatan_glukoma.'",KEBIASAAN_BERKEMIH = "'.$kebiasaan_berkemih.'",TRANSFER_MANDIRI = "'.$transfer_mandiri.'",TRANSFER_BANTUAN_1_ORANG = "'.$transfer_bantuan_1_orang.'",TRANSFER_BANTUAN_2_ORANG = "'.$transfer_bantuan_2_orang.'",TRANSFER_BANTUAN_TOTAL = "'.$transfer_bantuan_total.'",MOBILITAS_MANDIRI = "'.$mobilitas_mandiri.'",MOBILITAS_BANTUAN_1_ORANG = "'.$mobilitas_bantuan_1_orang.'",MOBILITAS_KURSI_RODA = "'.$mobilitas_kursi_roda.'",IMMOBILISASI = "'.$immobilisasi.'",USER_OPERASI = "'.$user_name.'" WHERE SKALA_JATUH_ID = "'.$skala_jatuh_id.'"') or die(mysql_error());
		}			  
?>
<script language="JavaScript" >
	alert('Simpan Data Skala Jatuh (OMSSS) Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
	}
}
?>