<?php
$irna_id = $_POST['irna_id'];
$nama_obat = $_POST['nama_obat'];
$dosis = $_POST['dosis'];
$jumlah = $_POST['jumlah'];
$frekuensi = $_POST['frekuensi'];
$cara_pemberian = $_POST['cara_pemberian'];

$_err = '';
if(empty($nama_obat))
	$_err = 'Nama Obat Harus Diisi.';	

if($_err == ''){	
	$sql_cek_no_rawat = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
	$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
	if (empty($dat_cek_no_rawat['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
			mysql_query('INSERT INTO t_irna_terapi_pulang(IRNA_ID,NAMA_OBAT,JUMLAH,DOSIS,FREKUENSI,CARA_PEMBERIAN)
						VALUES("' . $irna_id . '","' . $nama_obat . '","' . $jumlah . '","' . $dosis . '",
						"' . $frekuensi . '","' . $cara_pemberian . '")') or die(mysql_error());
			 
	}
$nama_obat = '';
$jumlah = '';
$dosis = '';
$frekuensi = '';
$cara_pemberian = '';
?>
	  <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
		document.getElementById("resep").focus();
    </script>
<?php	
}else{
?>
	<script language="JavaScript" >
		alert('<?php echo $_err; ?>');
		document.getElementById("resep").focus();
    </script>

<?php
}	
?>