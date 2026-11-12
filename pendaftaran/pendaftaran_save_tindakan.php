<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$user_name = currentUser();
$jenis_bayar_id = $_POST['jenis_bayar_id'];

$un = $_POST['un'];
$pu = $_POST['pu'];
$se = $_POST['se'];
$tg = $_POST['tg'];
$by = $_POST['by'];
$ps = $_POST['ps'];

if (isset($_POST['simpan'])) {
    	$no_bayar = 'NULL';
		$st_bayar = 'NULL';
		if($jenis_bayar_id <> '1'){
			$no_bayar = '"' . getNomorHarian('Kasir') . '"';
			$st_bayar = '"Lunas"';
		}
		$deskripsi = 'Tindakan (Pendaftaran)';
		$nomor = getNomorHarian('Tarif');
		
		mysql_query('UPDATE t_irja_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					ST_BAYAR = ' . $st_bayar . ',
					PEGAWAI_ID = (SELECT PEGAWAI_ID FROM t_irja WHERE IRJA_ID = "' . $irja_id . '")
					WHERE IRJA_ID = "' . $irja_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "' . $deskripsi . '"') or die(mysql_error());
?>
<script language="JavaScript" >
	alert('Simpan Data Tindakan Berhasil.');
	window.location = "index.php?link=<?php echo md5('pendaftaranformdaftarpenunjang'); ?>&idx=<?php echo $irja_id; ?>&un=<?php echo $un; ?>&pu=<?php echo $pu; ?>&se=<?php echo $se; ?>&tg=<?php echo $tg; ?>&by=<?php echo $by; ?>&ps=<?php echo $ps; ?>";
</script>
<?php		
}
?>