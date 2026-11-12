<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$status_fungsional_id = $_POST['status_fungsional_id'];
$tanggal = $_POST['tanggal'];
$user_name = currentUser();

$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
	if (empty($dat_cek_no_rawat['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		
		$mengendalikan_rangsang_defekasi_0 = '';
		$mengendalikan_rangsang_defekasi_1 = '';	
		$mengendalikan_rangsang_defekasi_2 = '';
		$mengendalikan_rangsang_berkemih_0 = '';
		$mengendalikan_rangsang_berkemih_1 = '';
		$mengendalikan_rangsang_berkemih_2 = '';
		$membersihkan_diri_0 = '';
		$membersihkan_diri_1 = '';
		$penggunaan_jamban_0 = '';
		$penggunaan_jamban_1 = '';
		$penggunaan_jamban_2 = '';
		$makan_0 = '';
		$makan_1 = '';
		$makan_2 = '';
		$berbaring_ke_duduk_0 = '';
		$berbaring_ke_duduk_1 = '';
		$berbaring_ke_duduk_2 = '';
		$berbaring_ke_duduk_3 = '';
		$berjalan_0 = '';
		$berjalan_1 = '';
		$berjalan_2 = '';
		$berjalan_3 = '';
		$memakai_baju_0 = '';
		$memakai_baju_1 = '';
		$memakai_baju_2 = '';
		$naik_turun_tangga_0 = '';
		$naik_turun_tangga_1 = '';
		$naik_turun_tangga_2 = '';
		$mandi_0 = '';
		$mandi_2 = '';
		$perawat = '';
		
		$x = 0;
		while($x <= 6){
			if(isset($_POST['mengendalikan_rangsang_defekasi_0_' . $x])) {
				$mengendalikan_rangsang_defekasi_0 = $mengendalikan_rangsang_defekasi_0 . $_POST['mengendalikan_rangsang_defekasi_0_' . $x] . '|';
			}else{
				$mengendalikan_rangsang_defekasi_0 = $mengendalikan_rangsang_defekasi_0 . '|';
			}
			if(isset($_POST['mengendalikan_rangsang_defekasi_1_' . $x])) {
				$mengendalikan_rangsang_defekasi_1 = $mengendalikan_rangsang_defekasi_1 . $_POST['mengendalikan_rangsang_defekasi_1_' . $x] . '|';
			}else{
				$mengendalikan_rangsang_defekasi_1 = $mengendalikan_rangsang_defekasi_1 . '|';
			}	
			if(isset($_POST['mengendalikan_rangsang_defekasi_2_' . $x])) {
				$mengendalikan_rangsang_defekasi_2 = $mengendalikan_rangsang_defekasi_2 . $_POST['mengendalikan_rangsang_defekasi_2_' . $x] . '|';
			}else{
				$mengendalikan_rangsang_defekasi_2 = $mengendalikan_rangsang_defekasi_2 . '|';
			}	
			if(isset($_POST['mengendalikan_rangsang_berkemih_0_' . $x])) {
				$mengendalikan_rangsang_berkemih_0 = $mengendalikan_rangsang_berkemih_0 . $_POST['mengendalikan_rangsang_berkemih_0_' . $x] . '|';
			}else{
				$mengendalikan_rangsang_berkemih_0 = $mengendalikan_rangsang_berkemih_0 . '|';
			}	
			if(isset($_POST['mengendalikan_rangsang_berkemih_1_' . $x])) {
				$mengendalikan_rangsang_berkemih_1 = $mengendalikan_rangsang_berkemih_1 . $_POST['mengendalikan_rangsang_berkemih_1_' . $x] . '|';
			}else{
				$mengendalikan_rangsang_berkemih_1 = $mengendalikan_rangsang_berkemih_1 . '|';
			}	
			if(isset($_POST['mengendalikan_rangsang_berkemih_2_' . $x])) {
				$mengendalikan_rangsang_berkemih_2 = $mengendalikan_rangsang_berkemih_2 . $_POST['mengendalikan_rangsang_berkemih_2_' . $x] . '|';
			}else{
				$mengendalikan_rangsang_berkemih_2 = $mengendalikan_rangsang_berkemih_2 . '|';
			}	
			if(isset($_POST['membersihkan_diri_0_' . $x])) {
				$membersihkan_diri_0 = $membersihkan_diri_0 . $_POST['membersihkan_diri_0_' . $x] . '|';
			}else{
				$membersihkan_diri_0 = $membersihkan_diri_0 . '|';
			}	
			if(isset($_POST['membersihkan_diri_1_' . $x])) {
				$membersihkan_diri_1 = $membersihkan_diri_1. $_POST['membersihkan_diri_1_' . $x] . '|';
			}else{
				$membersihkan_diri_1 = $membersihkan_diri_1. '|';
			}	
			if(isset($_POST['penggunaan_jamban_0_' . $x])) {
				$penggunaan_jamban_0 = $penggunaan_jamban_0 . $_POST['penggunaan_jamban_0_' . $x] . '|';
			}else{
				$penggunaan_jamban_0 = $penggunaan_jamban_0 . '|';
			}	
			if(isset($_POST['penggunaan_jamban_1_' . $x])) {
				$penggunaan_jamban_1 = $penggunaan_jamban_1 . $_POST['penggunaan_jamban_1_' . $x] . '|';
			}else{
				$penggunaan_jamban_1 = $penggunaan_jamban_1 . '|';
			}	
			if(isset($_POST['penggunaan_jamban_2_' . $x])) {
				$penggunaan_jamban_2 = $penggunaan_jamban_2 . $_POST['penggunaan_jamban_2_' . $x] . '|';
			}else{
				$penggunaan_jamban_2 = $penggunaan_jamban_2 . '|';
			}	
			if(isset($_POST['makan_0_' . $x])) {
				$makan_0 = $makan_0 . $_POST['makan_0_' . $x] . '|';
			}else{
				$makan_0 = $makan_0 . '|';
			}	
			if(isset($_POST['makan_1_' . $x])) {
				$makan_1 = $makan_1 . $_POST['makan_1_' . $x] . '|';
			}else{
				$makan_1 = $makan_1 . '|';
			}	
			if(isset($_POST['makan_2_' . $x])) {
				$makan_2 = $makan_2 . $_POST['makan_2_' . $x] . '|';
			}else{
				$makan_2 = $makan_2 . '|';
			}	
			if(isset($_POST['berbaring_ke_duduk_0_' . $x])) {
				$berbaring_ke_duduk_0 = $berbaring_ke_duduk_0 . $_POST['berbaring_ke_duduk_0_' . $x] . '|';
			}else{
				$berbaring_ke_duduk_0 = $berbaring_ke_duduk_0 . '|';
			}	
			if(isset($_POST['berbaring_ke_duduk_1_' . $x])) {
				$berbaring_ke_duduk_1 = $berbaring_ke_duduk_1 . $_POST['berbaring_ke_duduk_1_' . $x] . '|';
			}else{
				$berbaring_ke_duduk_1 = $berbaring_ke_duduk_1 . '|';
			}	
			if(isset($_POST['berbaring_ke_duduk_2_' . $x])) {
				$berbaring_ke_duduk_2 = $berbaring_ke_duduk_2 . $_POST['berbaring_ke_duduk_2_' . $x] . '|';
			}else{
				$berbaring_ke_duduk_2 = $berbaring_ke_duduk_2 . '|';
			}	
			if(isset($_POST['berbaring_ke_duduk_3_' . $x])) {
				$berbaring_ke_duduk_3 = $berbaring_ke_duduk_3 . $_POST['berbaring_ke_duduk_3_' . $x] . '|';
			}else{
				$berbaring_ke_duduk_3 = $berbaring_ke_duduk_3 . '|';
			}	
			if(isset($_POST['berjalan_0_' . $x])) {
				$berjalan_0 = $berjalan_0 . $_POST['berjalan_0_' . $x] . '|';
			}else{
				$berjalan_0 = $berjalan_0 . '|';
			}	
			if(isset($_POST['berjalan_1_' . $x])) {
				$berjalan_1 = $berjalan_1 . $_POST['berjalan_1_' . $x] . '|';
			}else{
				$berjalan_1 = $berjalan_1 . '|';
			}	
			if(isset($_POST['berjalan_2_' . $x])) {
				$berjalan_2 = $berjalan_2 . $_POST['berjalan_2_' . $x] . '|';
			}else{
				$berjalan_2 = $berjalan_2 . '|';
			}	
			if(isset($_POST['berjalan_3_' . $x])) {
				$berjalan_3 = $berjalan_3 . $_POST['berjalan_3_' . $x] . '|';
			}else{
				$berjalan_3 = $berjalan_3 . '|';
			}	
			if(isset($_POST['memakai_baju_0_' . $x])){
				$memakai_baju_0 = $memakai_baju_0 . $_POST['memakai_baju_0_' . $x] . '|';
			}else{
				$memakai_baju_0 = $memakai_baju_0 . '|';
			}	
			if(isset($_POST['memakai_baju_1_' . $x])) {
				$memakai_baju_1 = $memakai_baju_1 . $_POST['memakai_baju_1_' . $x] . '|';
			}else{
				$memakai_baju_1 = $memakai_baju_1 . '|';
			}	
			if(isset($_POST['memakai_baju_2_' . $x])) {
				$memakai_baju_2 = $memakai_baju_2 . $_POST['memakai_baju_2_' . $x] . '|';
			}else{
				$memakai_baju_2 = $memakai_baju_2 . '|';
			}	
			if(isset($_POST['naik_turun_tangga_0_' . $x])) {
				$naik_turun_tangga_0 = $naik_turun_tangga_0 . $_POST['naik_turun_tangga_0_' . $x] . '|';
			}else{
				$naik_turun_tangga_0 = $naik_turun_tangga_0 . '|';
			}	
			if(isset($_POST['naik_turun_tangga_1_' . $x])) {
				$naik_turun_tangga_1 = $naik_turun_tangga_1 . $_POST['naik_turun_tangga_1_' . $x] . '|';
			}else{
				$naik_turun_tangga_1 = $naik_turun_tangga_1 . '|';
			}	
			if(isset($_POST['naik_turun_tangga_2_' . $x])) {
				$naik_turun_tangga_2 = $naik_turun_tangga_2 . $_POST['naik_turun_tangga_2_' . $x] . '|';
			}else{
				$naik_turun_tangga_2 = $naik_turun_tangga_2 . '|';
			}	
			if(isset($_POST['mandi_0_' . $x])) {
				$mandi_0 = $mandi_0 . $_POST['mandi_0_' . $x] . '|';
			}else{
				$mandi_0 = $mandi_0 . '|';
			}	
			if(isset($_POST['mandi_2_' . $x])) { 
				$mandi_2 = $mandi_2 . $_POST['mandi_2_' . $x] . '|';
			}else{
				$mandi_2 = $mandi_2 . '|';
			}	
			
			if(isset($_POST['perawat_' . $x])) { 
				$perawat = $perawat . $_POST['perawat_' . $x] . '|';
			}else{
				$perawat = $perawat . '|';
			}	
		$x++;
		}
	if(empty($status_fungsional_id)){
		mysql_query('INSERT INTO t_irna_askep_status_fungsional (STATUS_FUNGSIONAL_ID,MENGENDALIKAN_RANGSANG_DEFEKASI_0,
					MENGENDALIKAN_RANGSANG_DEFEKASI_1,MENGENDALIKAN_RANGSANG_DEFEKASI_2,MENGENDALIKAN_RANGSANG_BERKEMIH_0,
					MENGENDALIKAN_RANGSANG_BERKEMIH_1,MENGENDALIKAN_RANGSANG_BERKEMIH_2,MEMBERSIHKAN_DIRI_0,
					MEMBERSIHKAN_DIRI_1,PENGGUNAAN_JAMBAN_0,PENGGUNAAN_JAMBAN_1,PENGGUNAAN_JAMBAN_2,MAKAN_0,MAKAN_1,
					MAKAN_2,BERBARING_KE_DUDUK_0,BERBARING_KE_DUDUK_1,BERBARING_KE_DUDUK_2,BERBARING_KE_DUDUK_3,
					BERJALAN_0,BERJALAN_1,BERJALAN_2,BERJALAN_3,MEMAKAI_BAJU_0,MEMAKAI_BAJU_1,MEMAKAI_BAJU_2,
					NAIK_TURUN_TANGGA_0,NAIK_TURUN_TANGGA_1,NAIK_TURUN_TANGGA_2,MANDI_0,MANDI_2,TANGGAL,PERAWAT) 
					VALUES ("'.$irna_id.'","'.$mengendalikan_rangsang_defekasi_0.'","'.$mengendalikan_rangsang_defekasi_1.'",
					"'.$mengendalikan_rangsang_defekasi_2.'","'.$mengendalikan_rangsang_berkemih_0.'",
					"'.$mengendalikan_rangsang_berkemih_1.'","'.$mengendalikan_rangsang_berkemih_2.'",
					"'.$membersihkan_diri_0.'","'.$membersihkan_diri_1.'","'.$penggunaan_jamban_0.'",
					"'.$penggunaan_jamban_1.'","'.$penggunaan_jamban_2.'","'.$makan_0.'","'.$makan_1.'","'.$makan_2.'",
					"'.$berbaring_ke_duduk_0.'","'.$berbaring_ke_duduk_1.'","'.$berbaring_ke_duduk_2.'",
					"'.$berbaring_ke_duduk_3.'","'.$berjalan_0.'","'.$berjalan_1.'","'.$berjalan_2.'",
					"'.$berjalan_3.'","'.$memakai_baju_0.'","'.$memakai_baju_1.'","'.$memakai_baju_2.'",
					"'.$naik_turun_tangga_0.'","'.$naik_turun_tangga_1.'","'.$naik_turun_tangga_2.'","'.$mandi_0.'",
					"'.$mandi_2.'",STR_TO_DATE("'.$tanggal.'","%d/%m/%Y"),"'.$perawat.'")') or die(mysql_error());
	}else{
		mysql_query('UPDATE t_irna_askep_status_fungsional SET MENGENDALIKAN_RANGSANG_DEFEKASI_0 = "'.$mengendalikan_rangsang_defekasi_0.'",
					MENGENDALIKAN_RANGSANG_DEFEKASI_1 = "'.$mengendalikan_rangsang_defekasi_1.'",
					MENGENDALIKAN_RANGSANG_DEFEKASI_2 = "'.$mengendalikan_rangsang_defekasi_2.'",
					MENGENDALIKAN_RANGSANG_BERKEMIH_0 = "'.$mengendalikan_rangsang_berkemih_0.'",
					MENGENDALIKAN_RANGSANG_BERKEMIH_1 = "'.$mengendalikan_rangsang_berkemih_1.'",
					MENGENDALIKAN_RANGSANG_BERKEMIH_2 = "'.$mengendalikan_rangsang_berkemih_2.'",
					MEMBERSIHKAN_DIRI_0 = "'.$membersihkan_diri_0.'",MEMBERSIHKAN_DIRI_1 = "'.$membersihkan_diri_1.'",
					PENGGUNAAN_JAMBAN_0 = "'.$penggunaan_jamban_0.'",PENGGUNAAN_JAMBAN_1 = "'.$penggunaan_jamban_1.'",
					PENGGUNAAN_JAMBAN_2 = "'.$penggunaan_jamban_2.'",MAKAN_0 = "'.$makan_0.'",MAKAN_1 = "'.$makan_1.'",
					MAKAN_2 = "'.$makan_2.'",BERBARING_KE_DUDUK_0 = "'.$berbaring_ke_duduk_0.'",
					BERBARING_KE_DUDUK_1 = "'.$berbaring_ke_duduk_1.'",
					BERBARING_KE_DUDUK_2 = "'.$berbaring_ke_duduk_2.'",
					BERBARING_KE_DUDUK_3 = "'.$berbaring_ke_duduk_3.'",BERJALAN_0 = "'.$berjalan_0.'",
					BERJALAN_1 = "'.$berjalan_1.'",BERJALAN_2 = "'.$berjalan_2.'",BERJALAN_3 = "'.$berjalan_3.'",
					MEMAKAI_BAJU_0 = "'.$memakai_baju_0.'",MEMAKAI_BAJU_1 = "'.$memakai_baju_1.'",
					MEMAKAI_BAJU_2 = "'.$memakai_baju_2.'",NAIK_TURUN_TANGGA_0 = "'.$naik_turun_tangga_0.'",
					NAIK_TURUN_TANGGA_1 = "'.$naik_turun_tangga_1.'",NAIK_TURUN_TANGGA_2 = "'.$naik_turun_tangga_2.'",
					MANDI_0 = "'.$mandi_0.'",MANDI_2 = "'.$mandi_2.'",TANGGAL = STR_TO_DATE("'.$tanggal.'","%d/%m/%Y"),PERAWAT = "'.$perawat.'"
					WHERE STATUS_FUNGSIONAL_ID = "'.$status_fungsional_id.'"') or die(mysql_error());
	}	
?>
<script language="JavaScript" >
	alert('Simpan Data Status Fungsional Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php		
		}else{
			$msg_info = $_err;
		}
	}
?>