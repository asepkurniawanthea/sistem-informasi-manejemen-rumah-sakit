<?php
$_err = '';
$penunjang_id = $_POST['penunjang_id'];

$un = $_POST['un'];
$in = $_POST['in'];
$do = $_POST['do'];
$al = $_POST['al'];
$te = $_POST['te'];
$ta = $_POST['ta'];	
$di = $_POST['di'];


if (isset($_POST['simpan'])) {
		$deskripsi = 'Penunjang (APS)';
		$no_tarif = getNomorHarian('Tarif');
		
		$no_sjp = getNomorHarian('SJP');
		$reg_user = $user_name;
		$tgl_daftar = getNow();
		
		mysql_query('UPDATE t_ipenunjang_tarif SET TANGGAL_DAFTAR = "' . $tgl_daftar . '",
							UNIT_PENUNJANG_ID = "' . $un . '",NO_TARIF = "' . $no_tarif . '",
							NO_SJP = "' . $no_sjp . '",SHIFT_PENDAFTARAN = "' . $_SESSION['SES_SIMRS_SHIFT'] . '",
							USER_PENDAFTARAN = "' . $reg_user . '",JENIS_BAYAR_ID = "1"
							WHERE PENUNJANG_ID =  "' . $penunjang_id . '"') or die(mysql_error());			
?>
<script language="JavaScript" >
	alert('Simpan Data Penunjang Berhasil.');
	window.location = "index.php?link=<?php echo md5('pendaftaranformeditdaftaraps'); ?>&idx=<?php echo $penunjang_id; ?>&no=<?php echo $no_sjp; ?>&un=<?php echo $un; ?>&in=<?php echo $in; ?>&do=<?php echo $do; ?>&al=<?php echo $al; ?>&te=<?php echo $te; ?>&ta=<?php echo $ta; ?>&di=<?php echo $di; ?>";
</script>
<?php		
		
	}
?>