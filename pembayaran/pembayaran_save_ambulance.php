<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$ord = $_POST['ord'];
$jenis_bayar_id = $_POST['jenis_bayar_id'];
$tuj_ambulance = $_POST['tuj_ambulance'];
$user_name = currentUser();
$tgl_tarif = getDatetimeSkr();

$st_save = false;
$cn_t = $_POST['cn_t'];
$x = 1;
while($x < $cn_t){
	if(isset($_POST['tarif' . $x])) $st_save = true;
$x++;
}	

if($st_save){

	$no_bayar = 'NULL';
	$tgl_bayar = 'NULL';
	$st_bayar = 'NULL';
	if($jenis_bayar_id <> '1'){
		$no_bayar = '"' . getNomorHarian('Kasir') . '"';
		$tgl_bayar = 'STR_TO_DATE("' . getDatetimeSkr() . '","%d/%m/%Y %H:%i:%s")';
		$st_bayar = '"Lunas"';
	}

	$deskripsi = 'Tindakan (Kasir)';
	$nomor = getNomorHarian('Tarif');
	$no_sjp = getNomorHarian('SJP');
	
	$y = 1;
	while($y < $cn_t){
		
			if(isset($_POST['tarif' . $y])){
				mysql_query('INSERT INTO t_ambulance_tarif(RAWAT_ID,JNS_ORDER,GMAP_DIRECTION,JENIS_BAYAR_ID,
					TGL_TARIF,TARIF_ID,KUANTITI,PEGAWAI_ID,NO_TARIF,NO_PEMBAYARAN,TGL_BAYAR,ST_BAYAR,SHIFT_ID,
					USER_KASIR,NO_POLISI,PENDAMPING_1,PENDAMPING_2,PENDAMPING_3,RUANG_ID) 
					VALUES("' . $irja_id . '","' . strtoupper($ord) . '","' . $tuj_ambulance . '",
					"' . $jenis_bayar_id . '",STR_TO_DATE("' . $tgl_tarif . '","%d/%m/%Y %H:%i:%s"),"' . $_POST['tarif' . $y] . '",
					"' . $_POST['jumlah' . $y] . '","' . $_POST['driver'] . '","' . $nomor . '",' . $no_bayar . ',' . $tgl_bayar . ',
					' . $st_bayar . ',"' . $_SESSION['SES_SIMRS_SHIFT'] . '","' . $user_name . '",
					"' . $_POST['no_polisi'] . '","' . $_POST['pendamping_1'] . '","' . $_POST['pendamping_2'] . '",
					"' . $_POST['pendamping_3'] . '","' . $_POST['unit_id'] . '")') or die(mysql_error());
			}		
	$y++;
	}	
		
?>
<script language="JavaScript" >
	alert('Simpan Data Pembayaran Berhasil.');
	window.location = "index.php?link=a24012d326ea009a2cdc16f4ed6b8894&idx=<?php echo $irja_id; ?>&ord=<?php echo $ord; ?>";
</script>
<?php
}
?>