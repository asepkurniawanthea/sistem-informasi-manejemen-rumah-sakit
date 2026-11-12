<?php
$irja_id = $_POST['irja_id'];
$pegawai_id = $_POST['pegawai_id'];
$pasien_masuk = $_POST['pasien_masuk'];
$jns_order = $_POST['jns_order'];
$user_name = currentUser();

$_err = '';
if (empty($pegawai_id))
    $_err = $_err . 'Dokter Pelaksana Harus Diisi. \n';

if (empty($_err)) {
		if(empty($jns_order)){
			mysql_query('UPDATE t_irja SET PEGAWAI_ID = "' . $pegawai_id . '",
					USER_IRJA_MASUK = "' . $user_name . '"
					WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());	
		}else{
			mysql_query('UPDATE t_hemodialisa SET PEGAWAI_PERIKSA_ID = "' . $pegawai_id . '",
					USER_IRJA_MASUK = "' . $user_name . '"
					WHERE HEMODIALISA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());	
		}			
?>
       <script language="JavaScript" >
            alert('Simpan Pasien Masuk Berhasil.');
			window.location = "index.php?link=<?php echo md5('hemodialisapasienmasuk'); ?>";
        </script>
<?php
} else {
    $msg_info = $_err;
}
?>