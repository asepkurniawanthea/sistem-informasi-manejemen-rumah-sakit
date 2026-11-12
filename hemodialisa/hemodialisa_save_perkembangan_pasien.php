<?php
$irja_id = $_POST['irja_id'];
$jns_order = $_POST['jns_order'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];
$pemberi_asuhan = $_POST['pemberi_asuhan'];
$hasil_asesmen = $_POST['hasil_asesmen'];
$intruksi_ppa = $_POST['intruksi_ppa'];
$verifikasi_dpjp = $_POST['verifikasi_dpjp'];

$_err = '';
if (empty($_err)) {
	if(empty($jns_order)){	
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
				mysql_query('INSERT INTO t_irja_perkembangan (IRJA_ID,TANGGAL,PEMBERI_ASUHAN,HASIL_ASESMEN,INTRUKSI_PPA,VERIFIKASI_DPJP) 
							VALUES ("'.$irja_id.'",STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),
							"'.$pemberi_asuhan.'","'.$hasil_asesmen.'","'.$intruksi_ppa.'","'.$verifikasi_dpjp.'")') or die(mysql_error());	
		}
	}else{
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
				mysql_query('INSERT INTO t_hemodialisa_perkembangan (HEMODIALISA_ID,TANGGAL,PEMBERI_ASUHAN,HASIL_ASESMEN,INTRUKSI_PPA,VERIFIKASI_DPJP) 
							VALUES ("'.$irja_id.'",STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),
							"'.$pemberi_asuhan.'","'.$hasil_asesmen.'","'.$intruksi_ppa.'","'.$verifikasi_dpjp.'")') or die(mysql_error());	
		}
	}	
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Perkembangan Pasien Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>