<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = preg_replace('~\r\n?~', "\n", $ret);
	$ret = str_replace('\n','<br>',$ret);
	$ret = htmlspecialchars($ret);
	return $ret;
}

$irna_id = $_POST['irna_id'];
$nomr = $_POST['nomr'];
$ruang_id = $_POST['ruang_id'];
$pemberi_asuhan = $_POST['pemberi_asuhan'];
$hasil_asesmen = array('s'=>replace_quote($_POST['hasil_asesmen_subjective']),
					'o'=>replace_quote($_POST['hasil_asesmen_objective']),
					'a'=>replace_quote($_POST['hasil_asesmen']),
					'd0'=>replace_quote($_POST['diagnosa_0']),
					'd1'=>replace_quote($_POST['diagnosa_1']),
					'd2'=>replace_quote($_POST['diagnosa_2']),
					'd3'=>replace_quote($_POST['diagnosa_3']),
					'd4'=>replace_quote($_POST['diagnosa_4']),
					'd5'=>replace_quote($_POST['diagnosa_5']),
					'd6'=>replace_quote($_POST['diagnosa_6']),
					'd7'=>replace_quote($_POST['diagnosa_7']),
					'p'=>replace_quote($_POST['hasil_asesmen_plan']));
$hasil_asesmen = json_encode($hasil_asesmen);
$hasil_asesmen = str_replace('"','|',$hasil_asesmen);					
$intruksi_ppa = replace_quote($_POST['intruksi_ppa']);
$verifikasi_dpjp = '';
if(isset($_POST['verifikasi_dpjp'])) $verifikasi_dpjp = $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '|' . getDateTimeSkr();

$_err = '';
if (empty($_err)) {
	if(empty($_POST['perkembangan_id'])){
		mysql_query('INSERT INTO t_irna_perkembangan (IRNA_ID,NOMR,RUANG_ID,TANGGAL_PERIKSA,PEGAWAI_ID,HASIL_ASESMEN,
			INTRUKSI_PPA,VERIFIKASI_DPJP,REGISTER) 
			VALUES ("'.$irna_id.'","'.$nomr.'","'.$ruang_id.'",NOW(),
			"'.$pemberi_asuhan.'","'. $hasil_asesmen .'","'.$intruksi_ppa.'","'.$verifikasi_dpjp.'",
			"' . $user_name . '")') or die(mysql_error());	
	}else{
		mysql_query('UPDATE t_irna_perkembangan 
			SET IRNA_ID = "'.$irna_id.'",
			NOMR = "'.$nomr.'",
			RUANG_ID = "'.$ruang_id.'",
			HASIL_ASESMEN = "'.$hasil_asesmen.'",
			INTRUKSI_PPA = "'.$intruksi_ppa.'",
			VERIFIKASI_DPJP = "'.$verifikasi_dpjp.'",
			REGISTER = "' . $user_name . '"
			WHERE IRNA_PERKEMBANGAN_ID= "' . $_POST['perkembangan_id'] . '"') or die(mysql_error());	
	}	
	
	if(isset($_POST['verifikasi_dpjp'])){
		mysql_query('DELETE FROM t_irna_diagnosa WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
		$d=0;
		while($d <= 7){
			if(!empty($_POST['diagnosa_'. $d])){
					$diagnosa = replace_quote($_POST['diagnosa_'. $d]);
				
					mysql_query('INSERT INTO t_irna_diagnosa (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA) 
					VALUES("' . $irna_id . '","' . $d . '","' . $diagnosa . '")') or die(mysql_error());
			}
		$d++;
		}
	}	
		
	/*
	include('lib/vendor/autoload.php');
	include('lib/html2openxml/HTMLtoOpenXML.php');
	include('edoc_rekammedik/new/erm_create_perkembangan_pasien_terintegrasi_ranap.php');
	erm_perkembangan_pasien_terintegrasi_ranap($_POST['irna_id']);
	*/
	
	mysql_query('UPDATE t_irna SET ST_CREATE_ERM_CPPT = NULL WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
	
	$tanggal = date('d/m/Y');
	$jam = date('H');
	$menit = date('i');
	$pemberi_asuhan = '';
	$hasil_asesmen = '';
	$intruksi_ppa = '';
	$verifikasi_dpjp = '';	
?>
    <script language="JavaScript" >
        alert('Simpan Data Perkembangan Pasien Berhasil.');
		window.location = "index.php?link=<?php echo $_GET['link']; ?>&smn=cppt&idx=<?php echo $_GET['idx']; ?>";
    </script>
    <?php
} else {
    $msg_info = $_err;
}
?>