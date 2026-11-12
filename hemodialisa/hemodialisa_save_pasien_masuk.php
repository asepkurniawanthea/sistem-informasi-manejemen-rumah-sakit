<?php
$irja_id = $_POST['irja_id'];
$pegawai_id = $_POST['pegawai_id'];
$pasien_masuk = $_POST['pasien_masuk'];
$jns_order = $_POST['jns_order'];
$user_name = currentUser();

$_err = '';
if (empty($pegawai_id))
    $_err = $_err . 'Dokter DPJP Harus Diisi. \n';

if (empty($_err)) {
			if(empty($jns_order)){
				mysql_query('UPDATE t_irja SET PEGAWAI_ID = "' . $pegawai_id . '",PASIEN_MASUK = NOW(),
						USER_IRJA_MASUK = "' . $user_name . '",ST_CREATE_ERM_RRKRJ = NULL
						WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
				
				/*
				include('lib/vendor/autoload.php');
				include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
				include('edoc_rekammedik/new/erm_create_rrkrj.php');
				erm_create_rrkrj($irja_id,$nomr);			
				*/
			}else{
					mysql_query('UPDATE t_hemodialisa SET PEGAWAI_PERIKSA_ID = "' . $pegawai_id . '",PASIEN_MASUK = NOW(),
						USER_IRJA_MASUK = "' . $user_name . '"
						WHERE HEMODIALISA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
			}	
?>
       <script language="JavaScript" >
            alert('Simpan Pasien Masuk Berhasil.');
			window.location = "index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&idx=<?php echo $_POST['irja_id']; ?>&ord=<?php echo $jns_order; ?>";
        </script>
<?php
} else {
    $msg_info = $_err;
}
?>