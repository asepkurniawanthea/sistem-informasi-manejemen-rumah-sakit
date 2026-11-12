<?php
$irna_id = $_POST['irna_id'];
$tanggal = $_POST['tanggal'] . ' ' . $_POST['jam'] . ':' . $_POST['menit'];
$pemberi_asuhan = $_POST['pemberi_asuhan'];
$hasil_asesmen = $_POST['hasil_asesmen'];
$intruksi_ppa = $_POST['intruksi_ppa'];
$verifikasi_dpjp = $_POST['verifikasi_dpjp'];
$irna_perkembangan_id = $_POST['irna_perkembangan_id'];

$_err = '';
if (empty($_err)) {
		$sql_cek_no_rawat = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
		$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
		if (empty($dat_cek_no_rawat['NO_RAWAT'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
				if(empty($irna_perkembangan_id)){
					mysql_query('INSERT INTO t_irna_perkembangan (IRNA_ID,TANGGAL_PERIKSA,PEGAWAI_ID,HASIL_ASESMEN,INTRUKSI_PPA,VERIFIKASI_DPJP) 
							VALUES ("'.$irna_id.'",STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),
							"'.$pemberi_asuhan.'","'.$hasil_asesmen.'","'.$intruksi_ppa.'","'.$verifikasi_dpjp.'")') or die(mysql_error());	
				}else{
					mysql_query('UPDATE t_irna_perkembangan SET TANGGAL_PERIKSA = STR_TO_DATE("'.$tanggal.'","%d/%m/%Y %H:%i"),
								HASIL_ASESMEN = "' . $hasil_asesmen . '",
								INTRUKSI_PPA = "' . $intruksi_ppa . '",
								PEGAWAI_ID = "' . $pemberi_asuhan . '",
								VERIFIKASI_DPJP = "' . $verifikasi_dpjp . '"
								WHERE IRNA_PERKEMBANGAN_ID = "' . $irna_perkembangan_id . '"') or die(mysql_error());
				}			
		}		
?>
    <script language="JavaScript" >
        alert('Simpan Data Perkembangan Pasien Berhasil.');
		window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=prkb&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>