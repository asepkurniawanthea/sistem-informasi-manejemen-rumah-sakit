<?php
$_err = '';
$irja_id = $_POST['penunjang_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$pegawai_id = $_POST['pegawai_id'];
$unit_id = $_POST['unit_id'];
$nomr = $_POST['nomr'];

$un = $_POST['un'];
$pu = $_POST['pu'];
$se = $_POST['se'];
$tg = $_POST['tg'];
$by = $_POST['by'];
$ps = $_POST['ps'];
$no = $_POST['no'];

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_ipenunjang WHERE RAWAT_ID = "' . $irja_id . '"';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Penunjang Harus Diisi. \n';
		
	if (empty($_err)) {
		$deskripsi = 'Penunjang (Pendaftaran)';
		$nomor_order = getNomorBulanan('IPENUNJANG');
		
		mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					DESKRIPSI = "' . $deskripsi . '",PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $unit_id . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND NO_ORDER IS NULL') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Penunjang Berhasil.');
	window.location = "index.php?link=<?php echo md5('pendaftaranformeditdaftarpenunjang'); ?>&idx=<?php echo $irja_id; ?>&un=<?php echo $un; ?>&pu=<?php echo $pu; ?>&se=<?php echo $se; ?>&tg=<?php echo $tg; ?>&by=<?php echo $by; ?>&ps=<?php echo $ps; ?>&no=<?php echo $no; ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>