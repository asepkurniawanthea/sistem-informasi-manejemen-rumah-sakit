<?php
$irna_id = $_POST['irna_id'];
$id_konsul = $_POST['id_konsul'];
$sebab_konsul = $_POST['sebab_konsul'];
$hasil_konsul = $_POST['hasil_konsul'];
$dokter = $_POST['dokter'];

if($id_konsul == ''){
	mysql_query('INSERT INTO t_irna_lembar_konsul (IRNA_ID,SEBAB_KONSUL,TGL_ASSESMENT,
		POD,ST_CREATE_ERM,PEGAWAI_ID,PEGAWAI_ID_PENGIRIM) 
		VALUES ("' . $irna_id . '","' . $sebab_konsul . '",NOW(),
		"' . $pod . '",NULL,"' . $dokter . '","' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '")') or die(mysql_error());
}else{
	mysql_query('UPDATE t_irna_lembar_konsul 
			SET SEBAB_KONSUL = "' . $sebab_konsul . '",
			TGL_ASSESMENT = NOW(),
			POD = "' . $pod . '",
			ST_CREATE_ERM = NULL,
			PEGAWAI_ID = "' . $dokter . '",
			PEGAWAI_ID_PENGIRIM = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '"
			WHERE IRNA_KONSUL_ID = "' . $id_konsul . '"') or die(mysql_error());	
}	
						
	/*
	include('lib/vendor/autoload.php');
	include('lib/html2openxml/HTMLtoOpenXML.php');
	include('edoc_rekammedik/new/erm_create_lembar_konsultasi.php');
	erm_lembar_konsultasi($irnanya,'','','');					
	*/
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Lembar Konsul Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>