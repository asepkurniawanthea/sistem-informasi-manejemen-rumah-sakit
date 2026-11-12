<?php
$irja_id = $_POST['irja_id'];
$pegawai_id = $_POST['pegawai_id'];
$pasien_masuk = $_POST['pasien_masuk'];
$user_name = currentUser();

if(isset($_POST['pasien_batal'])){
		if($_POST['keterangan_batal'] == ''){
			$msg_info = 'Keterangan Batal Harus Diisi';	
		}else{
			mysql_query('UPDATE t_irja SET ST_BATAL = "1",KETERANGAN_BATAL = "' . $_POST['keterangan_batal'] . '",
						USER_IRJA_MASUK = "' . $user_name . '"
						WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
			?>
			<script language="JavaScript" >
				alert('Simpan Pasien Batal Berhasil.');
				window.location = "index.php?link=7fe087b7b879fb29c65cc85dbcdf6560";
			</script>
<?php			
		}
}else{

$_err = '';
if (empty($pegawai_id))
    $_err = $_err . 'Dokter Pelaksana Harus Diisi. \n';

if (empty($_err)) {
			mysql_query('UPDATE t_irja SET PEGAWAI_ID = "' . $pegawai_id . '",
					USER_IRJA_MASUK = "' . $user_name . '"
					WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());	
?>
       <script language="JavaScript" >
            alert('Simpan Pasien Masuk Berhasil.');
			window.location = "index.php?link=<?php echo md5('klinikpasienmasuk'); ?>";
        </script>
<?php
} else {
    $msg_info = $_err;
}
}
?>