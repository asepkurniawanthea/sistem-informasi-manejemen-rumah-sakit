<?php
$irna_id = $_POST['irna_id'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$menit = $_POST['menit'];
$jenis_keluar_masuk = $_POST['jenis_keluar_masuk'];
$catatan = $_POST['catatan'];
$pegawai_id = $_POST['pegawai_id'];

$_err = '';
if(empty($jenis_keluar_masuk)) $_err = $_err . 'Jenis Keluar Masuk Belum Diisi. \n';
if(empty($catatan)) $_err = $_err . 'Catatan Belum Diisi. \n';
if(empty($pegawai_id)) $_err = $_err . 'Petugas Belum Diisi. \n';

if(empty($_err)){
	$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);

	if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {		       
			mysql_query('INSERT INTO t_irna_catatan_keluar_masuk(
						IRNA_ID,TANGGAL,JENIS_KELUAR_MASUK,CATATAN,PEGAWAI_ID)
						VALUES("' . $irna_id . '",' . fieldDatetime($tanggal . ' ' . $jam . ':' . $menit . ':01') . ',
						"' . $jenis_keluar_masuk . '","' . $catatan . '","' . $pegawai_id . '")') or die(mysql_error());
		}	 
?>
 <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
</script>
<?php
}else{
?>
	<script language="JavaScript" >
        alert('<?php echo $_err; ?>');
    </script>
<?php
}
?>