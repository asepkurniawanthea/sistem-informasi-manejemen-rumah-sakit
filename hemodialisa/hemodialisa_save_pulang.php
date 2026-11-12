<?php
$irja_id = $_POST['irja_id'];

if($jns_order == ''){
	$pasien_pulang_id = $_POST['pasien_pulang_id'];
	$nomr = $_POST['nomr'];
	$mt_rujukan = 'NULL';
	if(isset($_POST['mt_rujukan'])) $mt_rujukan = '"1"';
	$ket_pasien_pulang = $_POST['ket_pasien_pulang'];
	$rujukan_unit_id = $_POST['rujukan_unit_id'];
	$rujukan_ruang_id = $_POST['rujukan_ruang_id'];
	$user_name = currentUser();

	$jenis_bayar_id = $_POST['jenis_bayar_id'];
	if(isset($_POST['pasien_keadaan_id'])) $pasien_keadaan_id = $_POST['pasien_keadaan_id'];
	if(isset($_POST['jns_pelayanan'])) $jns_pelayanan = $_POST['jns_pelayanan'];
	if(isset($_POST['rujuk_balik'])) $rujuk_balik = '1';

	$_err = '';
	if (empty($pasien_pulang_id))
		$_err = $_err . 'Status Pasien Pulang Harus Diisi. \n';

	if(!empty($pasien_pulang_id)){
		if($pasien_pulang_id == '5'){
			if(empty($rujukan_unit_id)){
				$_err = $_err . 'Poliklinik Tujuan Harus Diisi. \n';
			}
		}
	}	
	if (empty($_err)) {
        $no_klinik = 'NULL';
		if(isset($_POST['selesai'])) $no_klinik = getNomorBulanan('IRJA');
			mysql_query('UPDATE t_irja SET PASIEN_PULANG_ID = "' . $pasien_pulang_id . '", PASIEN_KELUAR = NOW(),
					KET_PASIEN_PULANG = "' . $ket_pasien_pulang . '",
					MT_RUJUKAN = ' . $mt_rujukan . ',
					NO_KLINIK = ' . $no_klinik . ',
					USER_IRJA = "' . $user_name . '",
					RUJUKAN_UNIT_ID = "' . $rujukan_unit_id . '",
					RUJUKAN_RUANG_ID = "' . $rujukan_ruang_id . '",
					JNS_PELAYANAN = "' . $jns_pelayanan . '",
					PASIEN_KEADAAN_ID = "' . $pasien_keadaan_id . '",
					RUJUK_BALIK = "' . $rujuk_balik . '",
					ST_CREATE_ERM_RRKRJ = NULL
					WHERE IRJA_ID = "' . $irja_id  . '"') or die(mysql_error());
			
			/*
			include('lib/vendor/autoload.php');
			include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
			include('edoc_rekammedik/new/erm_create_rrkrj.php');
			erm_create_rrkrj($irja_id,$nomr);
			*/
				
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Pasien Pulang Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}

}else{
	
	$ket_pasien_pulang = $_POST['ket_pasien_pulang'];
	$user_name = currentUser();

	$_err = '';
		
	if (empty($_err)) {
        $no_klinik = 'NULL';
		if(isset($_POST['selesai'])) $no_klinik = getNomorBulanan('IRJA');
			mysql_query('UPDATE t_hemodialisa SET PASIEN_KELUAR = NOW(),
					KET_PASIEN_PULANG = "' . $ket_pasien_pulang . '",
					NO_KLINIK = ' . $no_klinik . ',
					USER_IRJA = "' . $user_name . '"
					WHERE HEMODIALISA_ID = "' . $irja_id  . '"') or die(mysql_error());
			
			/*include('lib/vendor/autoload.php');
			include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
			include('edoc_rekammedik/new/erm_create_rrkrj.php');
			erm_create_rrkrj($irja_id,$nomr);*/
				
    ?>
    <script language="JavaScript" >
        alert('Simpan Data Pasien Pulang Berhasil.');
		window.location = "<?php echo currentUrl(); ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
}
?>