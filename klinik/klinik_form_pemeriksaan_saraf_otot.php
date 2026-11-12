<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|',"!",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

if (isset($_POST['irja_id'])){
	$st_save = true;
	if($st_save){
		$arr_tanggal = array('01'=>replace_quote($_POST['tanggal_01']),
						'02'=>replace_quote($_POST['tanggal_02']),
						'03'=>replace_quote($_POST['tanggal_03']),
						'04'=>replace_quote($_POST['tanggal_04']),
						'05'=>replace_quote($_POST['tanggal_05']),
						'06'=>replace_quote($_POST['tanggal_06']),
						'07'=>replace_quote($_POST['tanggal_07']),
						'08'=>replace_quote($_POST['tanggal_08']),
						'09'=>replace_quote($_POST['tanggal_09']),
						'10'=>replace_quote($_POST['tanggal_10']),
						'11'=>replace_quote($_POST['tanggal_11']),
						'12'=>replace_quote($_POST['tanggal_12']));
		$arr_tanggal = json_encode($arr_tanggal);
		$arr_tanggal = str_replace('"','|',$arr_tanggal);	
		
		$arr_penilai = array('01'=>replace_quote($_POST['penilai_01']),
						'02'=>replace_quote($_POST['penilai_02']),
						'03'=>replace_quote($_POST['penilai_03']),
						'04'=>replace_quote($_POST['penilai_04']),
						'05'=>replace_quote($_POST['penilai_05']),
						'06'=>replace_quote($_POST['penilai_06']),
						'07'=>replace_quote($_POST['penilai_07']),
						'08'=>replace_quote($_POST['penilai_08']),
						'09'=>replace_quote($_POST['penilai_09']),
						'10'=>replace_quote($_POST['penilai_10']),
						'11'=>replace_quote($_POST['penilai_11']),
						'12'=>replace_quote($_POST['penilai_12']));
		$arr_penilai = json_encode($arr_penilai);
		$arr_penilai = str_replace('"','|',$arr_penilai);
		
		$arr_pem_saraf_kaki = array('common_01'=>replace_quote($_POST['common_01']),
						'common_02'=>replace_quote($_POST['common_02']),
						'common_03'=>replace_quote($_POST['common_03']),
						'common_04'=>replace_quote($_POST['common_04']),
						'common_05'=>replace_quote($_POST['common_05']),
						'common_06'=>replace_quote($_POST['common_06']),
						'common_07'=>replace_quote($_POST['common_07']),
						'common_08'=>replace_quote($_POST['common_08']),
						'common_09'=>replace_quote($_POST['common_09']),
						'common_10'=>replace_quote($_POST['common_10']),
						'common_11'=>replace_quote($_POST['common_11']),
						'common_12'=>replace_quote($_POST['common_12']),
						'posterior_01'=>replace_quote($_POST['posterior_01']),
						'posterior_02'=>replace_quote($_POST['posterior_02']),
						'posterior_03'=>replace_quote($_POST['posterior_03']),
						'posterior_04'=>replace_quote($_POST['posterior_04']),
						'posterior_05'=>replace_quote($_POST['posterior_05']),
						'posterior_06'=>replace_quote($_POST['posterior_06']),
						'posterior_07'=>replace_quote($_POST['posterior_07']),
						'posterior_08'=>replace_quote($_POST['posterior_08']),
						'posterior_09'=>replace_quote($_POST['posterior_09']),
						'posterior_10'=>replace_quote($_POST['posterior_10']),
						'posterior_11'=>replace_quote($_POST['posterior_11']),
						'posterior_12'=>replace_quote($_POST['posterior_12']));
		$arr_pem_saraf_kaki = json_encode($arr_pem_saraf_kaki);
		$arr_pem_saraf_kaki = str_replace('"','|',$arr_pem_saraf_kaki);
		
		$arr_pem_otot_kaki = array('anterior_01'=>replace_quote($_POST['anterior_01']),
						'anterior_02'=>replace_quote($_POST['anterior_02']),
						'anterior_03'=>replace_quote($_POST['anterior_03']),
						'anterior_04'=>replace_quote($_POST['anterior_04']),
						'anterior_05'=>replace_quote($_POST['anterior_05']),
						'anterior_06'=>replace_quote($_POST['anterior_06']),
						'anterior_07'=>replace_quote($_POST['anterior_07']),
						'anterior_08'=>replace_quote($_POST['anterior_08']),
						'anterior_09'=>replace_quote($_POST['anterior_09']),
						'anterior_10'=>replace_quote($_POST['anterior_10']),
						'anterior_11'=>replace_quote($_POST['anterior_11']),
						'anterior_12'=>replace_quote($_POST['anterior_12']),
						'brevis_01'=>replace_quote($_POST['brevis_01']),
						'brevis_02'=>replace_quote($_POST['brevis_02']),
						'brevis_03'=>replace_quote($_POST['brevis_03']),
						'brevis_04'=>replace_quote($_POST['brevis_04']),
						'brevis_05'=>replace_quote($_POST['brevis_05']),
						'brevis_06'=>replace_quote($_POST['brevis_06']),
						'brevis_07'=>replace_quote($_POST['brevis_07']),
						'brevis_08'=>replace_quote($_POST['brevis_08']),
						'brevis_09'=>replace_quote($_POST['brevis_09']),
						'brevis_10'=>replace_quote($_POST['brevis_10']),
						'brevis_11'=>replace_quote($_POST['brevis_11']),
						'brevis_12'=>replace_quote($_POST['brevis_12']),
						'hallucis_01'=>replace_quote($_POST['hallucis_01']),
						'hallucis_02'=>replace_quote($_POST['hallucis_02']),
						'hallucis_03'=>replace_quote($_POST['hallucis_03']),
						'hallucis_04'=>replace_quote($_POST['hallucis_04']),
						'hallucis_05'=>replace_quote($_POST['hallucis_05']),
						'hallucis_06'=>replace_quote($_POST['hallucis_06']),
						'hallucis_07'=>replace_quote($_POST['hallucis_07']),
						'hallucis_08'=>replace_quote($_POST['hallucis_08']),
						'hallucis_09'=>replace_quote($_POST['hallucis_09']),
						'hallucis_10'=>replace_quote($_POST['hallucis_10']),
						'hallucis_11'=>replace_quote($_POST['hallucis_11']),
						'hallucis_12'=>replace_quote($_POST['hallucis_12']),
						'tibialis_01'=>replace_quote($_POST['tibialis_01']),
						'tibialis_02'=>replace_quote($_POST['tibialis_02']),
						'tibialis_03'=>replace_quote($_POST['tibialis_03']),
						'tibialis_04'=>replace_quote($_POST['tibialis_04']),
						'tibialis_05'=>replace_quote($_POST['tibialis_05']),
						'tibialis_06'=>replace_quote($_POST['tibialis_06']),
						'tibialis_07'=>replace_quote($_POST['tibialis_07']),
						'tibialis_08'=>replace_quote($_POST['tibialis_08']),
						'tibialis_09'=>replace_quote($_POST['tibialis_09']),
						'tibialis_10'=>replace_quote($_POST['tibialis_10']),
						'tibialis_11'=>replace_quote($_POST['tibialis_11']),
						'tibialis_12'=>replace_quote($_POST['tibialis_12']));
		$arr_pem_otot_kaki = json_encode($arr_pem_otot_kaki);
		$arr_pem_otot_kaki = str_replace('"','|',$arr_pem_otot_kaki);
		
		$arr_pem_saraf_muka = array('aurikularis_01'=>replace_quote($_POST['aurikularis_01']),
						'aurikularis_02'=>replace_quote($_POST['aurikularis_02']),
						'aurikularis_03'=>replace_quote($_POST['aurikularis_03']),
						'aurikularis_04'=>replace_quote($_POST['aurikularis_04']),
						'aurikularis_05'=>replace_quote($_POST['aurikularis_05']),
						'aurikularis_06'=>replace_quote($_POST['aurikularis_06']),
						'aurikularis_07'=>replace_quote($_POST['aurikularis_07']),
						'aurikularis_08'=>replace_quote($_POST['aurikularis_08']),
						'aurikularis_09'=>replace_quote($_POST['aurikularis_09']),
						'aurikularis_10'=>replace_quote($_POST['aurikularis_10']),
						'aurikularis_11'=>replace_quote($_POST['aurikularis_11']),
						'aurikularis_12'=>replace_quote($_POST['aurikularis_12']));
		$arr_pem_saraf_muka = json_encode($arr_pem_saraf_muka);
		$arr_pem_saraf_muka = str_replace('"','|',$arr_pem_saraf_muka);
		
		$arr_pem_otot_muka = array('orbcularis_01'=>replace_quote($_POST['orbcularis_01']),
						'orbcularis_02'=>replace_quote($_POST['orbcularis_02']),
						'orbcularis_03'=>replace_quote($_POST['orbcularis_03']),
						'orbcularis_04'=>replace_quote($_POST['orbcularis_04']),
						'orbcularis_05'=>replace_quote($_POST['orbcularis_05']),
						'orbcularis_06'=>replace_quote($_POST['orbcularis_06']),
						'orbcularis_07'=>replace_quote($_POST['orbcularis_07']),
						'orbcularis_08'=>replace_quote($_POST['orbcularis_08']),
						'orbcularis_09'=>replace_quote($_POST['orbcularis_09']),
						'orbcularis_10'=>replace_quote($_POST['orbcularis_10']),
						'orbcularis_11'=>replace_quote($_POST['orbcularis_11']),
						'orbcularis_12'=>replace_quote($_POST['orbcularis_12']),
						'oris_01'=>replace_quote($_POST['oris_01']),
						'oris_02'=>replace_quote($_POST['oris_02']),
						'oris_03'=>replace_quote($_POST['oris_03']),
						'oris_04'=>replace_quote($_POST['oris_04']),
						'oris_05'=>replace_quote($_POST['oris_05']),
						'oris_06'=>replace_quote($_POST['oris_06']),
						'oris_07'=>replace_quote($_POST['oris_07']),
						'oris_08'=>replace_quote($_POST['oris_08']),
						'oris_09'=>replace_quote($_POST['oris_09']),
						'oris_10'=>replace_quote($_POST['oris_10']),
						'oris_11'=>replace_quote($_POST['oris_11']),
						'oris_12'=>replace_quote($_POST['oris_12']),
						'lagophthalmus_01'=>replace_quote($_POST['lagophthalmus_01']),
						'lagophthalmus_02'=>replace_quote($_POST['lagophthalmus_02']),
						'lagophthalmus_03'=>replace_quote($_POST['lagophthalmus_03']),
						'lagophthalmus_04'=>replace_quote($_POST['lagophthalmus_04']),
						'lagophthalmus_05'=>replace_quote($_POST['lagophthalmus_05']),
						'lagophthalmus_06'=>replace_quote($_POST['lagophthalmus_06']),
						'lagophthalmus_07'=>replace_quote($_POST['lagophthalmus_07']),
						'lagophthalmus_08'=>replace_quote($_POST['lagophthalmus_08']),
						'lagophthalmus_09'=>replace_quote($_POST['lagophthalmus_09']),
						'lagophthalmus_10'=>replace_quote($_POST['lagophthalmus_10']),
						'lagophthalmus_11'=>replace_quote($_POST['lagophthalmus_11']),
						'lagophthalmus_12'=>replace_quote($_POST['lagophthalmus_12']),
						'kedip_mata_01'=>replace_quote($_POST['kedip_mata_01']),
						'kedip_mata_02'=>replace_quote($_POST['kedip_mata_02']),
						'kedip_mata_03'=>replace_quote($_POST['kedip_mata_03']),
						'kedip_mata_04'=>replace_quote($_POST['kedip_mata_04']),
						'kedip_mata_05'=>replace_quote($_POST['kedip_mata_05']),
						'kedip_mata_06'=>replace_quote($_POST['kedip_mata_06']),
						'kedip_mata_07'=>replace_quote($_POST['kedip_mata_07']),
						'kedip_mata_08'=>replace_quote($_POST['kedip_mata_08']),
						'kedip_mata_09'=>replace_quote($_POST['kedip_mata_09']),
						'kedip_mata_10'=>replace_quote($_POST['kedip_mata_10']),
						'kedip_mata_11'=>replace_quote($_POST['kedip_mata_11']),
						'kedip_mata_12'=>replace_quote($_POST['kedip_mata_12']));
		$arr_pem_otot_muka = json_encode($arr_pem_otot_muka);
		$arr_pem_otot_muka = str_replace('"','|',$arr_pem_otot_muka);
		
		$arr_pem_saraf_tangan = array('ulnaris_01'=>replace_quote($_POST['ulnaris_01']),
						'ulnaris_02'=>replace_quote($_POST['ulnaris_02']),
						'ulnaris_03'=>replace_quote($_POST['ulnaris_03']),
						'ulnaris_04'=>replace_quote($_POST['ulnaris_04']),
						'ulnaris_05'=>replace_quote($_POST['ulnaris_05']),
						'ulnaris_06'=>replace_quote($_POST['ulnaris_06']),
						'ulnaris_07'=>replace_quote($_POST['ulnaris_07']),
						'ulnaris_08'=>replace_quote($_POST['ulnaris_08']),
						'ulnaris_09'=>replace_quote($_POST['ulnaris_09']),
						'ulnaris_10'=>replace_quote($_POST['ulnaris_10']),
						'ulnaris_11'=>replace_quote($_POST['ulnaris_11']),
						'ulnaris_12'=>replace_quote($_POST['ulnaris_12']),
						'medianus_01'=>replace_quote($_POST['medianus_01']),
						'medianus_02'=>replace_quote($_POST['medianus_02']),
						'medianus_03'=>replace_quote($_POST['medianus_03']),
						'medianus_04'=>replace_quote($_POST['medianus_04']),
						'medianus_05'=>replace_quote($_POST['medianus_05']),
						'medianus_06'=>replace_quote($_POST['medianus_06']),
						'medianus_07'=>replace_quote($_POST['medianus_07']),
						'medianus_08'=>replace_quote($_POST['medianus_08']),
						'medianus_09'=>replace_quote($_POST['medianus_09']),
						'medianus_10'=>replace_quote($_POST['medianus_10']),
						'medianus_11'=>replace_quote($_POST['medianus_11']),
						'medianus_12'=>replace_quote($_POST['medianus_12']),
						'radialis_01'=>replace_quote($_POST['radialis_01']),
						'radialis_02'=>replace_quote($_POST['radialis_02']),
						'radialis_03'=>replace_quote($_POST['radialis_03']),
						'radialis_04'=>replace_quote($_POST['radialis_04']),
						'radialis_05'=>replace_quote($_POST['radialis_05']),
						'radialis_06'=>replace_quote($_POST['radialis_06']),
						'radialis_07'=>replace_quote($_POST['radialis_07']),
						'radialis_08'=>replace_quote($_POST['radialis_08']),
						'radialis_09'=>replace_quote($_POST['radialis_09']),
						'radialis_10'=>replace_quote($_POST['radialis_10']),
						'radialis_11'=>replace_quote($_POST['radialis_11']),
						'radialis_12'=>replace_quote($_POST['radialis_12']));
		$arr_pem_saraf_tangan = json_encode($arr_pem_saraf_tangan);
		$arr_pem_saraf_tangan = str_replace('"','|',$arr_pem_saraf_tangan);
		
		$arr_pem_otot_tangan = array('digiti_01'=>replace_quote($_POST['digiti_01']),
						'digiti_02'=>replace_quote($_POST['digiti_02']),
						'digiti_03'=>replace_quote($_POST['digiti_03']),
						'digiti_04'=>replace_quote($_POST['digiti_04']),
						'digiti_05'=>replace_quote($_POST['digiti_05']),
						'digiti_06'=>replace_quote($_POST['digiti_06']),
						'digiti_07'=>replace_quote($_POST['digiti_07']),
						'digiti_08'=>replace_quote($_POST['digiti_08']),
						'digiti_09'=>replace_quote($_POST['digiti_09']),
						'digiti_10'=>replace_quote($_POST['digiti_10']),
						'digiti_11'=>replace_quote($_POST['digiti_11']),
						'digiti_12'=>replace_quote($_POST['digiti_12']),
						'dorsal_01'=>replace_quote($_POST['dorsal_01']),
						'dorsal_02'=>replace_quote($_POST['dorsal_02']),
						'dorsal_03'=>replace_quote($_POST['dorsal_03']),
						'dorsal_04'=>replace_quote($_POST['dorsal_04']),
						'dorsal_05'=>replace_quote($_POST['dorsal_05']),
						'dorsal_06'=>replace_quote($_POST['dorsal_06']),
						'dorsal_07'=>replace_quote($_POST['dorsal_07']),
						'dorsal_08'=>replace_quote($_POST['dorsal_08']),
						'dorsal_09'=>replace_quote($_POST['dorsal_09']),
						'dorsal_10'=>replace_quote($_POST['dorsal_10']),
						'dorsal_11'=>replace_quote($_POST['dorsal_11']),
						'dorsal_12'=>replace_quote($_POST['dorsal_12']),
						'lumbrical_01'=>replace_quote($_POST['lumbrical_01']),
						'lumbrical_02'=>replace_quote($_POST['lumbrical_02']),
						'lumbrical_03'=>replace_quote($_POST['lumbrical_03']),
						'lumbrical_04'=>replace_quote($_POST['lumbrical_04']),
						'lumbrical_05'=>replace_quote($_POST['lumbrical_05']),
						'lumbrical_06'=>replace_quote($_POST['lumbrical_06']),
						'lumbrical_07'=>replace_quote($_POST['lumbrical_07']),
						'lumbrical_08'=>replace_quote($_POST['lumbrical_08']),
						'lumbrical_09'=>replace_quote($_POST['lumbrical_09']),
						'lumbrical_10'=>replace_quote($_POST['lumbrical_10']),
						'lumbrical_11'=>replace_quote($_POST['lumbrical_11']),
						'lumbrical_12'=>replace_quote($_POST['lumbrical_12']),
						'pollicis_01'=>replace_quote($_POST['pollicis_01']),
						'pollicis_02'=>replace_quote($_POST['pollicis_02']),
						'pollicis_03'=>replace_quote($_POST['pollicis_03']),
						'pollicis_04'=>replace_quote($_POST['pollicis_04']),
						'pollicis_05'=>replace_quote($_POST['pollicis_05']),
						'pollicis_06'=>replace_quote($_POST['pollicis_06']),
						'pollicis_07'=>replace_quote($_POST['pollicis_07']),
						'pollicis_08'=>replace_quote($_POST['pollicis_08']),
						'pollicis_09'=>replace_quote($_POST['pollicis_09']),
						'pollicis_10'=>replace_quote($_POST['pollicis_10']),
						'pollicis_11'=>replace_quote($_POST['pollicis_11']),
						'pollicis_12'=>replace_quote($_POST['pollicis_12']),
						'lumbrical2_01'=>replace_quote($_POST['lumbrical2_01']),
						'lumbrical2_02'=>replace_quote($_POST['lumbrical2_02']),
						'lumbrical2_03'=>replace_quote($_POST['lumbrical2_03']),
						'lumbrical2_04'=>replace_quote($_POST['lumbrical2_04']),
						'lumbrical2_05'=>replace_quote($_POST['lumbrical2_05']),
						'lumbrical2_06'=>replace_quote($_POST['lumbrical2_06']),
						'lumbrical2_07'=>replace_quote($_POST['lumbrical2_07']),
						'lumbrical2_08'=>replace_quote($_POST['lumbrical2_08']),
						'lumbrical2_09'=>replace_quote($_POST['lumbrical2_09']),
						'lumbrical2_10'=>replace_quote($_POST['lumbrical2_10']),
						'lumbrical2_11'=>replace_quote($_POST['lumbrical2_11']),
						'lumbrical2_12'=>replace_quote($_POST['lumbrical2_12']),
						'carpi_01'=>replace_quote($_POST['carpi_01']),
						'carpi_02'=>replace_quote($_POST['carpi_02']),
						'carpi_03'=>replace_quote($_POST['carpi_03']),
						'carpi_04'=>replace_quote($_POST['carpi_04']),
						'carpi_05'=>replace_quote($_POST['carpi_05']),
						'carpi_06'=>replace_quote($_POST['carpi_06']),
						'carpi_07'=>replace_quote($_POST['carpi_07']),
						'carpi_08'=>replace_quote($_POST['carpi_08']),
						'carpi_09'=>replace_quote($_POST['carpi_09']),
						'carpi_10'=>replace_quote($_POST['carpi_10']),
						'carpi_11'=>replace_quote($_POST['carpi_11']),
						'carpi_12'=>replace_quote($_POST['carpi_12']),
						'minimi_01'=>replace_quote($_POST['minimi_01']),
						'minimi_02'=>replace_quote($_POST['minimi_02']),
						'minimi_03'=>replace_quote($_POST['minimi_03']),
						'minimi_04'=>replace_quote($_POST['minimi_04']),
						'minimi_05'=>replace_quote($_POST['minimi_05']),
						'minimi_06'=>replace_quote($_POST['minimi_06']),
						'minimi_07'=>replace_quote($_POST['minimi_07']),
						'minimi_08'=>replace_quote($_POST['minimi_08']),
						'minimi_09'=>replace_quote($_POST['minimi_09']),
						'minimi_10'=>replace_quote($_POST['minimi_10']),
						'minimi_11'=>replace_quote($_POST['minimi_11']),
						'minimi_12'=>replace_quote($_POST['minimi_12']));
		$arr_pem_otot_tangan = json_encode($arr_pem_otot_tangan);
		$arr_pem_otot_tangan = str_replace('"','|',$arr_pem_otot_tangan);
		
		mysql_query('UPDATE t_pemeriksaan_saraf_dan_otot 
				SET TANGGAL  = "' . $arr_tanggal . '",
				PENILAI  = "' . $arr_penilai . '",
				PEMERIKSAAN_SARAF_KAKI  = "' . $arr_pem_saraf_kaki . '",
				PEMERIKSAAN_OTOT_KAKI  = "' . $arr_pem_otot_kaki . '",
				KELEMAHAN_OTOT_KAKI  = "' . $_POST['kelemahan_otot_kaki'] . '",
				PEMERIKSAAN_SARAF_MUKA  = "' . $arr_pem_saraf_muka . '",
				PEMERIKSAAN_OTOT_MUKA  = "' . $arr_pem_otot_muka . '",
				PEMERIKSAAN_SARAF_TANGAN  = "' . $arr_pem_saraf_tangan . '",
				PEMERIKSAAN_OTOT_TANGAN  = "' . $arr_pem_otot_tangan . '",
				SAKIT_SARAF_TANGAN  = "' . $_POST['rasa_sakit_pada_saraf'] . '",
				KELEMAHAN_OTOT_TANGAN  = "' . $_POST['kelemahan_otot'] . '",
				TGL_ASSESMENT  = NOW(),
				REGISTER = "'. $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] .'",
				ST_CREATE_ERM = NULL
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
				
		/*
		include('lib/vendor/autoload.php');
		include('edoc_rekammedik/new/erm_create_pemeriksaan_saraf_otot.php');
		erm_pemeriksaan_saraf_otot($_POST['irja_id']);		
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pemeriksaan Saraf dan Otot Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

$qry_pasien = 'SELECT IRJA_ID,TANGGAL,PENILAI,PEMERIKSAAN_SARAF_KAKI,PEMERIKSAAN_OTOT_KAKI,TEST_RASA_KAKI,
			KELEMAHAN_OTOT_KAKI,PEMERIKSAAN_SARAF_MUKA,PEMERIKSAAN_OTOT_MUKA,PEMERIKSAAN_SARAF_TANGAN,
			PEMERIKSAAN_OTOT_TANGAN,TEST_RASA_TANGAN,SAKIT_SARAF_TANGAN,KELEMAHAN_OTOT_TANGAN
			FROM t_pemeriksaan_saraf_dan_otot
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];
$tanggal = str_replace('|','"',$dat_pasien['TANGGAL']);
$tanggal = preg_replace('/\r|\n/','\n',trim($tanggal));
$tanggal = json_decode($tanggal,true);

$penilai = str_replace('|','"',$dat_pasien['PENILAI']);
$penilai = preg_replace('/\r|\n/','\n',trim($penilai));
$penilai = json_decode($penilai,true);

$pem_saraf_kaki = str_replace('|','"',$dat_pasien['PEMERIKSAAN_SARAF_KAKI']);
$pem_saraf_kaki = preg_replace('/\r|\n/','\n',trim($pem_saraf_kaki));
$pem_saraf_kaki = json_decode($pem_saraf_kaki,true);

$pem_otot_kaki = str_replace('|','"',$dat_pasien['PEMERIKSAAN_OTOT_KAKI']);
$pem_otot_kaki = preg_replace('/\r|\n/','\n',trim($pem_otot_kaki));
$pem_otot_kaki = json_decode($pem_otot_kaki,true);

$test_rasa_kaki = $dat_pasien['TEST_RASA_KAKI'];
$kelemahan_otot_kaki = $dat_pasien['KELEMAHAN_OTOT_KAKI'];

$pem_saraf_muka = str_replace('|','"',$dat_pasien['PEMERIKSAAN_SARAF_MUKA']);
$pem_saraf_muka = preg_replace('/\r|\n/','\n',trim($pem_saraf_muka));
$pem_saraf_muka = json_decode($pem_saraf_muka,true);

$pem_otot_muka = str_replace('|','"',$dat_pasien['PEMERIKSAAN_OTOT_MUKA']);
$pem_otot_muka = preg_replace('/\r|\n/','\n',trim($pem_otot_muka));
$pem_otot_muka = json_decode($pem_otot_muka,true);

$pem_saraf_tangan = str_replace('|','"',$dat_pasien['PEMERIKSAAN_SARAF_TANGAN']);
$pem_saraf_tangan = preg_replace('/\r|\n/','\n',trim($pem_saraf_tangan));
$pem_saraf_tangan = json_decode($pem_saraf_tangan,true);

$pem_otot_tangan = str_replace('|','"',$dat_pasien['PEMERIKSAAN_OTOT_TANGAN']);
$pem_otot_tangan = preg_replace('/\r|\n/','\n',trim($pem_otot_tangan));
$pem_otot_tangan = json_decode($pem_otot_tangan,true);

$test_rasa_tangan = $dat_pasien['TEST_RASA_TANGAN'];
$rasa_sakit_pada_saraf = $dat_pasien['SAKIT_SARAF_TANGAN'];
$kelemahan_otot = $dat_pasien['KELEMAHAN_OTOT_TANGAN'];
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="100%">
		<tr>	
			<td colspan="8">
				<table width="100%" class="tableData">
					<tr>
						<td>Tanggal</td>
						<td><input type="text" name="tanggal_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['01'])) ? $tanggal['01'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['02'])) ? $tanggal['02'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['03'])) ? $tanggal['03'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['04'])) ? $tanggal['04'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['05'])) ? $tanggal['05'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['06'])) ? $tanggal['06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="tanggal_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['07'])) ? $tanggal['07'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['08'])) ? $tanggal['08'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['09'])) ? $tanggal['09'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['10'])) ? $tanggal['10'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['11'])) ? $tanggal['11'] : ''); ?>" /></td>
						<td><input type="text" name="tanggal_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($tanggal['12'])) ? $tanggal['12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Penilai</td>
						<td><input type="text" name="penilai_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['01'])) ? $penilai['01'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['02'])) ? $penilai['02'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['03'])) ? $penilai['03'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['04'])) ? $penilai['04'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['05'])) ? $penilai['05'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['06'])) ? $penilai['06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="penilai_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['07'])) ? $penilai['07'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['08'])) ? $penilai['08'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['09'])) ? $penilai['09'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['10'])) ? $penilai['10'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['11'])) ? $penilai['11'] : ''); ?>" /></td>
						<td><input type="text" name="penilai_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($penilai['12'])) ? $penilai['12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<th>Pemeriksaan Kaki</th>
						<th colspan="6">Kanan</th>
						<th>|</th>
						<th colspan="6">Kiri</th>
					</tr>
					<tr>
						<td colspan="14"><strong>Pemeriksaan Saraf : Catat dengan ukuran Normal (N), Tebal (T), Rasa Sakit (S)</strong></td>
					</tr>
					<tr>
						<td>Common Peroneus</td>
						<td><input type="text" name="common_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_01'])) ? $pem_saraf_kaki['common_01'] : ''); ?>" /></td>
						<td><input type="text" name="common_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_02'])) ? $pem_saraf_kaki['common_02'] : ''); ?>" /></td>
						<td><input type="text" name="common_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_03'])) ? $pem_saraf_kaki['common_03'] : ''); ?>" /></td>
						<td><input type="text" name="common_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_04'])) ? $pem_saraf_kaki['common_04'] : ''); ?>" /></td>
						<td><input type="text" name="common_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_05'])) ? $pem_saraf_kaki['common_05'] : ''); ?>" /></td>
						<td><input type="text" name="common_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_06'])) ? $pem_saraf_kaki['common_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="common_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_07'])) ? $pem_saraf_kaki['common_07'] : ''); ?>" /></td>
						<td><input type="text" name="common_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_08'])) ? $pem_saraf_kaki['common_08'] : ''); ?>" /></td>
						<td><input type="text" name="common_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_09'])) ? $pem_saraf_kaki['common_09'] : ''); ?>" /></td>
						<td><input type="text" name="common_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_10'])) ? $pem_saraf_kaki['common_10'] : ''); ?>" /></td>
						<td><input type="text" name="common_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_11'])) ? $pem_saraf_kaki['common_11'] : ''); ?>" /></td>
						<td><input type="text" name="common_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['common_12'])) ? $pem_saraf_kaki['common_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Tibialis Posterior</td>
						<td><input type="text" name="posterior_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_01'])) ? $pem_saraf_kaki['posterior_01'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_02'])) ? $pem_saraf_kaki['posterior_02'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_03'])) ? $pem_saraf_kaki['posterior_03'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_04'])) ? $pem_saraf_kaki['posterior_04'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_05'])) ? $pem_saraf_kaki['posterior_05'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_06'])) ? $pem_saraf_kaki['posterior_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="posterior_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_07'])) ? $pem_saraf_kaki['posterior_07'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_08'])) ? $pem_saraf_kaki['posterior_08'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_09'])) ? $pem_saraf_kaki['posterior_09'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_10'])) ? $pem_saraf_kaki['posterior_10'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_11'])) ? $pem_saraf_kaki['posterior_11'] : ''); ?>" /></td>
						<td><input type="text" name="posterior_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_kaki['posterior_12'])) ? $pem_saraf_kaki['posterior_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td colspan="14"><strong>Pemeriksaan Otot : Catat ukuran kekuatan otot dengan ukuran 0,1,2,3,4 atau 5</strong></td>
					</tr>
					<tr>
						<td>Tibialis Anterior</td>
						<td><input type="text" name="anterior_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_01'])) ? $pem_otot_kaki['anterior_01'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_02'])) ? $pem_otot_kaki['anterior_02'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_03'])) ? $pem_otot_kaki['anterior_03'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_04'])) ? $pem_otot_kaki['anterior_04'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_05'])) ? $pem_otot_kaki['anterior_05'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_06'])) ? $pem_otot_kaki['anterior_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="anterior_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_07'])) ? $pem_otot_kaki['anterior_07'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_08'])) ? $pem_otot_kaki['anterior_08'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_09'])) ? $pem_otot_kaki['anterior_09'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_10'])) ? $pem_otot_kaki['anterior_10'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_11'])) ? $pem_otot_kaki['anterior_11'] : ''); ?>" /></td>
						<td><input type="text" name="anterior_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['anterior_12'])) ? $pem_otot_kaki['anterior_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Peroneus Longus Brevis</td>
						<td><input type="text" name="brevis_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_01'])) ? $pem_otot_kaki['brevis_01'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_02'])) ? $pem_otot_kaki['brevis_02'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_03'])) ? $pem_otot_kaki['brevis_03'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_04'])) ? $pem_otot_kaki['brevis_04'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_05'])) ? $pem_otot_kaki['brevis_05'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_06'])) ? $pem_otot_kaki['brevis_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="brevis_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_07'])) ? $pem_otot_kaki['brevis_07'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_08'])) ? $pem_otot_kaki['brevis_08'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_09'])) ? $pem_otot_kaki['brevis_09'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_10'])) ? $pem_otot_kaki['brevis_10'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_11'])) ? $pem_otot_kaki['brevis_11'] : ''); ?>" /></td>
						<td><input type="text" name="brevis_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['brevis_12'])) ? $pem_otot_kaki['brevis_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Ext.Digitorum.Comm.Hallucis</td>
						<td><input type="text" name="hallucis_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_01'])) ? $pem_otot_kaki['hallucis_01'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_02'])) ? $pem_otot_kaki['hallucis_02'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_03'])) ? $pem_otot_kaki['hallucis_03'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_04'])) ? $pem_otot_kaki['hallucis_04'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_05'])) ? $pem_otot_kaki['hallucis_05'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_06'])) ? $pem_otot_kaki['hallucis_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="hallucis_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_07'])) ? $pem_otot_kaki['hallucis_07'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_08'])) ? $pem_otot_kaki['hallucis_08'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_09'])) ? $pem_otot_kaki['hallucis_09'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_10'])) ? $pem_otot_kaki['hallucis_10'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_11'])) ? $pem_otot_kaki['hallucis_11'] : ''); ?>" /></td>
						<td><input type="text" name="hallucis_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['hallucis_12'])) ? $pem_otot_kaki['hallucis_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Tibialis Posterior</td>
						<td><input type="text" name="tibialis_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_01'])) ? $pem_otot_kaki['tibialis_01'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_02'])) ? $pem_otot_kaki['tibialis_02'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_03'])) ? $pem_otot_kaki['tibialis_03'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_04'])) ? $pem_otot_kaki['tibialis_04'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_05'])) ? $pem_otot_kaki['tibialis_05'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_06'])) ? $pem_otot_kaki['tibialis_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="tibialis_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_07'])) ? $pem_otot_kaki['tibialis_07'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_08'])) ? $pem_otot_kaki['tibialis_08'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_09'])) ? $pem_otot_kaki['tibialis_09'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_10'])) ? $pem_otot_kaki['tibialis_10'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_11'])) ? $pem_otot_kaki['tibialis_11'] : ''); ?>" /></td>
						<td><input type="text" name="tibialis_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_kaki['tibialis_12'])) ? $pem_otot_kaki['tibialis_12'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8">Test Rasa (Sensory Test)</td>
		</tr>
		<tr>	
			<td colspan="8">v : Merasa, x : Tidak merasa, o : Tidak merasa pada mata kaki luar</td>
		</tr>
		<tr>	
			<td colspan="8" align="center">
				<div id="signature-pad" class="signature-pad">
					<canvas style="width:1200px;height:731px;"></canvas>
				</div>
				<button type="button" class="button clear" onclick="clearCanvas();" style="width:1200px;">Clear</button>
			</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
		<tr>	
			<td colspan="2" valign="top">Sudah berapa lama adanya kelemahan otot ?</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="kelemahan_otot_kaki" class="text_dt10" ><?php echo $kelemahan_otot_kaki; ?></textarea></td>
		</tr>
		<tr>
		<td colspan="8">
				<table width="100%" class="tableData">
						<th>Pemeriksaan Muka</th>
						<th colspan="6">Kanan</th>
						<th>|</th>
						<th colspan="6">Kiri</th>
					</tr>
					<tr>
						<td colspan="14"><strong>Pemeriksaan Saraf : Catat dengan ukuran Normal (N), Tebal (T), Rasa Sakit (S)</strong></td>
					</tr>
					<tr>
						<td>Great Aurikularis</td>
						<td><input type="text" name="aurikularis_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_01'])) ? $pem_saraf_muka['aurikularis_01'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_02'])) ? $pem_saraf_muka['aurikularis_02'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_03'])) ? $pem_saraf_muka['aurikularis_03'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_04'])) ? $pem_saraf_muka['aurikularis_04'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_05'])) ? $pem_saraf_muka['aurikularis_05'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_06'])) ? $pem_saraf_muka['aurikularis_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="aurikularis_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_07'])) ? $pem_saraf_muka['aurikularis_07'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_08'])) ? $pem_saraf_muka['aurikularis_08'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_09'])) ? $pem_saraf_muka['aurikularis_09'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_10'])) ? $pem_saraf_muka['aurikularis_10'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_11'])) ? $pem_saraf_muka['aurikularis_11'] : ''); ?>" /></td>
						<td><input type="text" name="aurikularis_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_muka['aurikularis_12'])) ? $pem_saraf_muka['aurikularis_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td colspan="14"><strong>Pemeriksaan Otot : Catat ukuran kekuatan otot dengan ukuran 0,1,2,3,4 atau 5</strong></td>
					</tr>
					<tr>
						<td>Orbcularis Oculli</td>
						<td><input type="text" name="orbcularis_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_01'])) ? $pem_otot_muka['orbcularis_01'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_02'])) ? $pem_otot_muka['orbcularis_02'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_03'])) ? $pem_otot_muka['orbcularis_03'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_04'])) ? $pem_otot_muka['orbcularis_04'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_05'])) ? $pem_otot_muka['orbcularis_05'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_06'])) ? $pem_otot_muka['orbcularis_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="orbcularis_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_07'])) ? $pem_otot_muka['orbcularis_07'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_08'])) ? $pem_otot_muka['orbcularis_08'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_09'])) ? $pem_otot_muka['orbcularis_09'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_10'])) ? $pem_otot_muka['orbcularis_10'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_11'])) ? $pem_otot_muka['orbcularis_11'] : ''); ?>" /></td>
						<td><input type="text" name="orbcularis_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['orbcularis_12'])) ? $pem_otot_muka['orbcularis_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Orbcularis Oris</td>
						<td><input type="text" name="oris_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_01'])) ? $pem_otot_muka['oris_01'] : ''); ?>" /></td>
						<td><input type="text" name="oris_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_02'])) ? $pem_otot_muka['oris_02'] : ''); ?>" /></td>
						<td><input type="text" name="oris_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_03'])) ? $pem_otot_muka['oris_03'] : ''); ?>" /></td>
						<td><input type="text" name="oris_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_04'])) ? $pem_otot_muka['oris_04'] : ''); ?>" /></td>
						<td><input type="text" name="oris_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_05'])) ? $pem_otot_muka['oris_05'] : ''); ?>" /></td>
						<td><input type="text" name="oris_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_06'])) ? $pem_otot_muka['oris_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="oris_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_07'])) ? $pem_otot_muka['oris_07'] : ''); ?>" /></td>
						<td><input type="text" name="oris_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_08'])) ? $pem_otot_muka['oris_08'] : ''); ?>" /></td>
						<td><input type="text" name="oris_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_09'])) ? $pem_otot_muka['oris_09'] : ''); ?>" /></td>
						<td><input type="text" name="oris_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_10'])) ? $pem_otot_muka['oris_10'] : ''); ?>" /></td>
						<td><input type="text" name="oris_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_11'])) ? $pem_otot_muka['oris_11'] : ''); ?>" /></td>
						<td><input type="text" name="oris_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['oris_12'])) ? $pem_otot_muka['oris_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Lagophthalmus</td>
						<td><input type="text" name="lagophthalmus_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_01'])) ? $pem_otot_muka['lagophthalmus_01'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_02'])) ? $pem_otot_muka['lagophthalmus_02'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_03'])) ? $pem_otot_muka['lagophthalmus_03'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_04'])) ? $pem_otot_muka['lagophthalmus_04'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_05'])) ? $pem_otot_muka['lagophthalmus_05'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_06'])) ? $pem_otot_muka['lagophthalmus_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="lagophthalmus_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_07'])) ? $pem_otot_muka['lagophthalmus_07'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_08'])) ? $pem_otot_muka['lagophthalmus_08'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_09'])) ? $pem_otot_muka['lagophthalmus_09'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_10'])) ? $pem_otot_muka['lagophthalmus_10'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_11'])) ? $pem_otot_muka['lagophthalmus_11'] : ''); ?>" /></td>
						<td><input type="text" name="lagophthalmus_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['lagophthalmus_12'])) ? $pem_otot_muka['lagophthalmus_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Kedip Mata</td>
						<td><input type="text" name="kedip_mata_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_01'])) ? $pem_otot_muka['kedip_mata_01'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_02'])) ? $pem_otot_muka['kedip_mata_02'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_03'])) ? $pem_otot_muka['kedip_mata_03'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_04'])) ? $pem_otot_muka['kedip_mata_04'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_05'])) ? $pem_otot_muka['kedip_mata_05'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_06'])) ? $pem_otot_muka['kedip_mata_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="kedip_mata_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_07'])) ? $pem_otot_muka['kedip_mata_07'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_08'])) ? $pem_otot_muka['kedip_mata_08'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_09'])) ? $pem_otot_muka['kedip_mata_09'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_10'])) ? $pem_otot_muka['kedip_mata_10'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_11'])) ? $pem_otot_muka['kedip_mata_11'] : ''); ?>" /></td>
						<td><input type="text" name="kedip_mata_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_muka['kedip_mata_12'])) ? $pem_otot_muka['kedip_mata_12'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>	
			<td colspan="8" valign="top">Catatan : Isi untuk pemeriksaan Lagophthalmus dan Kedip Mata, ada atau tidak dengan tanda (+/-)</td>
		</tr>
		<tr>
		<td colspan="8">
				<table width="100%" class="tableData">
						<th colspan="2">Pemeriksaan Tangan</th>
						<th colspan="6">Kanan</th>
						<th>|</th>
						<th colspan="6">Kiri</th>
					</tr>
					<tr>
						<td colspan="15"><strong>Pemeriksaan Saraf : Catat dengan ukuran Normal (N), Tebal (T), Rasa Sakit (S)</strong></td>
					</tr>
					<tr>
						<td colspan="2">Ulnaris</td>
						<td><input type="text" name="ulnaris_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_01'])) ? $pem_saraf_tangan['ulnaris_01'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_02'])) ? $pem_saraf_tangan['ulnaris_02'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_03'])) ? $pem_saraf_tangan['ulnaris_03'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_04'])) ? $pem_saraf_tangan['ulnaris_04'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_05'])) ? $pem_saraf_tangan['ulnaris_05'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_06'])) ? $pem_saraf_tangan['ulnaris_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="ulnaris_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_07'])) ? $pem_saraf_tangan['ulnaris_07'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_08'])) ? $pem_saraf_tangan['ulnaris_08'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_09'])) ? $pem_saraf_tangan['ulnaris_09'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_10'])) ? $pem_saraf_tangan['ulnaris_10'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_11'])) ? $pem_saraf_tangan['ulnaris_11'] : ''); ?>" /></td>
						<td><input type="text" name="ulnaris_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['ulnaris_12'])) ? $pem_saraf_tangan['ulnaris_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td colspan="2">Medianus</td>
						<td><input type="text" name="medianus_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_01'])) ? $pem_saraf_tangan['medianus_01'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_02'])) ? $pem_saraf_tangan['medianus_02'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_03'])) ? $pem_saraf_tangan['medianus_03'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_04'])) ? $pem_saraf_tangan['medianus_04'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_05'])) ? $pem_saraf_tangan['medianus_05'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_06'])) ? $pem_saraf_tangan['medianus_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="medianus_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_07'])) ? $pem_saraf_tangan['medianus_07'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_08'])) ? $pem_saraf_tangan['medianus_08'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_09'])) ? $pem_saraf_tangan['medianus_09'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_10'])) ? $pem_saraf_tangan['medianus_10'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_11'])) ? $pem_saraf_tangan['medianus_11'] : ''); ?>" /></td>
						<td><input type="text" name="medianus_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['medianus_12'])) ? $pem_saraf_tangan['medianus_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td colspan="2">Radialis</td>
						<td><input type="text" name="radialis_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_01'])) ? $pem_saraf_tangan['radialis_01'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_02'])) ? $pem_saraf_tangan['radialis_02'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_03'])) ? $pem_saraf_tangan['radialis_03'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_04'])) ? $pem_saraf_tangan['radialis_04'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_05'])) ? $pem_saraf_tangan['radialis_05'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_06'])) ? $pem_saraf_tangan['radialis_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="radialis_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_07'])) ? $pem_saraf_tangan['radialis_07'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_08'])) ? $pem_saraf_tangan['radialis_08'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_09'])) ? $pem_saraf_tangan['radialis_09'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_10'])) ? $pem_saraf_tangan['radialis_10'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_11'])) ? $pem_saraf_tangan['radialis_11'] : ''); ?>" /></td>
						<td><input type="text" name="radialis_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_saraf_tangan['radialis_12'])) ? $pem_saraf_tangan['radialis_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td colspan="15"><strong>Pemeriksaan Otot : Catat ukuran kekuatan otot dengan ukuran 0,1,2,3,4 atau 5</strong></td>
					</tr>
					<tr>
						<td rowspan="3" valign="top">Ulnaris</td>
						<td>Abd. Digiti Minimi</td>
						<td><input type="text" name="digiti_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_01'])) ? $pem_otot_tangan['digiti_01'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_02'])) ? $pem_otot_tangan['digiti_02'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_03'])) ? $pem_otot_tangan['digiti_03'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_04'])) ? $pem_otot_tangan['digiti_04'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_05'])) ? $pem_otot_tangan['digiti_05'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_06'])) ? $pem_otot_tangan['digiti_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="digiti_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_07'])) ? $pem_otot_tangan['digiti_07'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_08'])) ? $pem_otot_tangan['digiti_08'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_09'])) ? $pem_otot_tangan['digiti_09'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_10'])) ? $pem_otot_tangan['digiti_10'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_11'])) ? $pem_otot_tangan['digiti_11'] : ''); ?>" /></td>
						<td><input type="text" name="digiti_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['digiti_12'])) ? $pem_otot_tangan['digiti_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Dorsal Interoseus</td>
						<td><input type="text" name="dorsal_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_01'])) ? $pem_otot_tangan['dorsal_01'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_02'])) ? $pem_otot_tangan['dorsal_02'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_03'])) ? $pem_otot_tangan['dorsal_03'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_04'])) ? $pem_otot_tangan['dorsal_04'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_05'])) ? $pem_otot_tangan['dorsal_05'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_06'])) ? $pem_otot_tangan['dorsal_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="dorsal_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_07'])) ? $pem_otot_tangan['dorsal_07'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_08'])) ? $pem_otot_tangan['dorsal_08'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_09'])) ? $pem_otot_tangan['dorsal_09'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_10'])) ? $pem_otot_tangan['dorsal_10'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_11'])) ? $pem_otot_tangan['dorsal_11'] : ''); ?>" /></td>
						<td><input type="text" name="dorsal_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['dorsal_12'])) ? $pem_otot_tangan['dorsal_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>3,4 Lumbricalis</td>
						<td><input type="text" name="lumbrical_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_01'])) ? $pem_otot_tangan['lumbrical_01'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_02'])) ? $pem_otot_tangan['lumbrical_02'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_03'])) ? $pem_otot_tangan['lumbrical_03'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_04'])) ? $pem_otot_tangan['lumbrical_04'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_05'])) ? $pem_otot_tangan['lumbrical_05'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_06'])) ? $pem_otot_tangan['lumbrical_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="lumbrical_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_07'])) ? $pem_otot_tangan['lumbrical_07'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_08'])) ? $pem_otot_tangan['lumbrical_08'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_09'])) ? $pem_otot_tangan['lumbrical_09'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_10'])) ? $pem_otot_tangan['lumbrical_10'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_11'])) ? $pem_otot_tangan['lumbrical_11'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical_12'])) ? $pem_otot_tangan['lumbrical_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td rowspan="2" valign="top">Medianus</td>
						<td>Abd/opp. Pollicis</td>
						<td><input type="text" name="pollicis_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_01'])) ? $pem_otot_tangan['pollicis_01'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_02'])) ? $pem_otot_tangan['pollicis_02'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_03'])) ? $pem_otot_tangan['pollicis_03'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_04'])) ? $pem_otot_tangan['pollicis_04'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_05'])) ? $pem_otot_tangan['pollicis_05'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_06'])) ? $pem_otot_tangan['pollicis_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="pollicis_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_07'])) ? $pem_otot_tangan['pollicis_07'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_08'])) ? $pem_otot_tangan['pollicis_08'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_09'])) ? $pem_otot_tangan['pollicis_09'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_10'])) ? $pem_otot_tangan['pollicis_10'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_11'])) ? $pem_otot_tangan['pollicis_11'] : ''); ?>" /></td>
						<td><input type="text" name="pollicis_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['pollicis_12'])) ? $pem_otot_tangan['pollicis_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>1,2 Lumbricalis</td>
						<td><input type="text" name="lumbrical2_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_01'])) ? $pem_otot_tangan['lumbrical2_01'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_02'])) ? $pem_otot_tangan['lumbrical2_02'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_03'])) ? $pem_otot_tangan['lumbrical2_03'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_04'])) ? $pem_otot_tangan['lumbrical2_04'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_05'])) ? $pem_otot_tangan['lumbrical2_05'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_06'])) ? $pem_otot_tangan['lumbrical2_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="lumbrical2_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_07'])) ? $pem_otot_tangan['lumbrical2_07'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_08'])) ? $pem_otot_tangan['lumbrical2_08'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_09'])) ? $pem_otot_tangan['lumbrical2_09'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_10'])) ? $pem_otot_tangan['lumbrical2_10'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_11'])) ? $pem_otot_tangan['lumbrical2_11'] : ''); ?>" /></td>
						<td><input type="text" name="lumbrical2_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['lumbrical2_12'])) ? $pem_otot_tangan['lumbrical2_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td rowspan="2" valign="top">Radialis</td>
						<td>Ext. Carpi Radialis<br/>Longus/ Brevis</td>
						<td><input type="text" name="carpi_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_01'])) ? $pem_otot_tangan['carpi_01'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_02'])) ? $pem_otot_tangan['carpi_02'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_03'])) ? $pem_otot_tangan['carpi_03'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_04'])) ? $pem_otot_tangan['carpi_04'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_05'])) ? $pem_otot_tangan['carpi_05'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_06'])) ? $pem_otot_tangan['carpi_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="carpi_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_07'])) ? $pem_otot_tangan['carpi_07'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_08'])) ? $pem_otot_tangan['carpi_08'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_09'])) ? $pem_otot_tangan['carpi_09'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_10'])) ? $pem_otot_tangan['carpi_10'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_11'])) ? $pem_otot_tangan['carpi_11'] : ''); ?>" /></td>
						<td><input type="text" name="carpi_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['carpi_12'])) ? $pem_otot_tangan['carpi_12'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Ext. Digitorum Minimi</td>
						<td><input type="text" name="minimi_01" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_01'])) ? $pem_otot_tangan['minimi_01'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_02" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_02'])) ? $pem_otot_tangan['minimi_02'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_03" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_03'])) ? $pem_otot_tangan['minimi_03'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_04" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_04'])) ? $pem_otot_tangan['minimi_04'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_05" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_05'])) ? $pem_otot_tangan['minimi_05'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_06" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_06'])) ? $pem_otot_tangan['minimi_06'] : ''); ?>" /></td>
						<td align="center">|</td>
						<td><input type="text" name="minimi_07" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_07'])) ? $pem_otot_tangan['minimi_07'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_08" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_08'])) ? $pem_otot_tangan['minimi_08'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_09" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_09'])) ? $pem_otot_tangan['minimi_09'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_10" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_10'])) ? $pem_otot_tangan['minimi_10'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_11" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_11'])) ? $pem_otot_tangan['minimi_11'] : ''); ?>" /></td>
						<td><input type="text" name="minimi_12" class="text_dt" style="width:60px;" value="<?php echo ((isset($pem_otot_tangan['minimi_12'])) ? $pem_otot_tangan['minimi_12'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8">Test Rasa (Sensory Test)</td>
		</tr>
		<tr>	
			<td colspan="8">v : Merasa, x : Tidak merasa, o : Tidak merasa pada mata kaki luar</td>
		</tr>
		<tr>	
			<td colspan="8" align="center">
				<div id="signature-pad-2" class="signature-pad-2">
					<canvas style="width:1200px;height:731px;"></canvas>
				</div>
				<button type="button" class="button clear" onclick="clearCanvas_2();" style="width:1200px;">Clear</button>
			</td>
		</tr>
		<tr>	
			<td colspan="2" valign="top" rowspan="2">Keterangan : Sudah berapa lama</td>
			<td valign="top">:</td>
			<td colspan="5">Rasa sakit pada saraf<br/><textarea name="rasa_sakit_pada_saraf" class="text_dt10" ><?php echo $rasa_sakit_pada_saraf; ?></textarea></td>
		</tr>
		<tr>	
			<td valign="top">&nbsp;</td>
			<td colspan="5">Kelemahan otot<br/><textarea name="kelemahan_otot" class="text_dt10" ><?php echo $kelemahan_otot; ?></textarea></td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
        <tr><td colspan="8" align="right" >
			<?php if($irja_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" />
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "28"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
			</td>
        </tr>
    </table>
</form>
<script src="script/signature/js/signature_pad.umd.js"></script>
<script src="script/signature/js/app.js"></script>
<script src="script/signature/js/app_2.js"></script>
<script>
<?php 
	if(empty($test_rasa_kaki)){
		$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pemeriksaan_saraf_d_otot.jpg';
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}else{
		$path_image = $rmfile_path . '/pengkajian_awal_medik_kusta/' . $test_rasa_kaki;
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}	
	if(empty($test_rasa_tangan)){
		$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pemeriksaan_saraf_d_otot2.jpg';
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}else{
		$path_image = $rmfile_path . '/pengkajian_awal_medik_kusta/' . $test_rasa_tangan;
		$type = pathinfo($path_image, PATHINFO_EXTENSION);
		$data = file_get_contents($path_image);
		$image_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	}	
	
	$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pemeriksaan_saraf_d_otot.jpg';
	$type = pathinfo($path_image, PATHINFO_EXTENSION);
	$data = file_get_contents($path_image);
	$image_ori = 'data:image/' . $type . ';base64,' . base64_encode($data);	
	$path_image = $app_path . 'nsimrs/edoc_rekammedik/new/pemeriksaan_saraf_d_otot2.jpg';
	$type = pathinfo($path_image, PATHINFO_EXTENSION);
	$data = file_get_contents($path_image);
	$image_ori_2 = 'data:image/' . $type . ';base64,' . base64_encode($data);	
?>
function clearCanvas(){
	if(confirm('Bersihkan ?')){	
		signaturePad.fromDataURL('<?php echo $image_ori; ?>');
	}
}
function clearCanvas_2(){
	if(confirm('Bersihkan ?')){	
		signaturePad2.fromDataURL('<?php echo $image_ori_2; ?>');
	}
}

function defaultCanvas(){
	signaturePad.fromDataURL('<?php echo $image; ?>');
}
function defaultCanvas2(){
	signaturePad2.fromDataURL('<?php echo $image_2; ?>');
}

function simpan(){
	_haschange = false;
	
	var image = signaturePad.toDataURL("image/jpg");
	var image2 = signaturePad2.toDataURL("image/jpg");	
	$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=klinikaddpemeriksaansarafotot',
			data: { img: image,
				img2: image2,
				idx : '<?php echo $idx; ?>',
				irja_id : '<?php echo $irja_id; ?>',
				nomr : '<?php echo $nomr; ?>'
				},
			cache: false,
			success: function(data) {
				
				if (data != ''){ 
					if(data == 'ok'){
						 $("#formperiksa").submit();
					}else{
						alert(data);
					}		
				}	
				
			},});	
}

defaultCanvas();
defaultCanvas2();
</script>