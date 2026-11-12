<?php
$irja_id = $_POST['irja_id'];
$pegawai_id = $_POST['pegawai_id'];
$pasien_masuk = $_POST['pasien_masuk'];
$nomr = $_POST['nomr'];
$user_name = currentUser();

if(isset($_POST['pasien_batal'])){
		if($_POST['keterangan_batal'] == ''){
			$msg_info = 'Keterangan Batal Harus Diisi';	
		}else{
			mysql_query('UPDATE t_irja SET ST_BATAL = "1",KETERANGAN_BATAL = "' . $_POST['keterangan_batal'] . '",
						USER_IRJA_MASUK = "' . $user_name . '"
						WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
			mysql_query('UPDATE t_irja_tarif SET ST_BAYAR = "Batal" WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());			
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
		$_err = $_err . 'Dokter DPJP Harus Diisi. \n';

	if (empty($_err)) {
					mysql_query('UPDATE t_irja SET PEGAWAI_ID = "' . $pegawai_id . '",PASIEN_MASUK = NOW(),
						USER_IRJA_MASUK = "' . $user_name . '",NEW_RM = "1",ST_CREATE_ERM_RRKRJ = NULL
						WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
					//include('lib/vendor/autoload.php');
					//include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
					//include('edoc_rekammedik/new/erm_create_rrkrj.php');
					//erm_create_rrkrj($irja_id,$nomr);	
	?>
		   <script language="JavaScript" >
				alert('Simpan Pasien Masuk Berhasil.');
				window.location = "index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&idx=<?php echo $_POST['irja_id']; ?>";
			</script>
	<?php
	} else {
		$msg_info = $_err;
	}
}
?>