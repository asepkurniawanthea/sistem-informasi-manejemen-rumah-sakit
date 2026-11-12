<?php
$irna_id = $_POST['irna_id'];
$cndiagnosa = $_POST['cndiagnosa'];
$cntindakan = $_POST['cntindakan'];
$cnpenunjang = $_POST['cnpenunjang'];
$nama_user = currentUser();

$_err = '';
$st_code = '';

$i = 1;
while ($i <= 4) {
    $irna_diagnosa_idx = $_POST['irna_diagnosa_id' . $i];
	$icdx = $_POST['icd_code' . $i];
	$diagnosa = $_POST['icd_code' . $i];
	$icd_code_array = explode('--', $icdx);
	if(sizeof($icd_code_array) == 2) {
		$icdx = $icd_code_array[0];
		$diagnosa = $icd_code_array[1];
	}	
	$kasus_barux = '';
	if(isset($_POST['kasus_baru' . $i])) $kasus_barux = '1';
	$diagnosa_order = $i - 1;
	if($irna_diagnosa_idx != ''){
		if(!empty($icdx)){
			mysql_query('UPDATE t_irna_diagnosa SET
				ICD_CODE = "' . $icdx . '",
				KASUS_BARU = "' . $kasus_barux . '"
				WHERE IRNA_DIAGNOSA_ID = "' . $irna_diagnosa_idx . '"') or die(mysql_error());
		}else{
			$_err = '';
			$st_code = '1';
		}	
	}else{
		if(!empty($icdx)){	
			mysql_query('INSERT INTO t_irna_diagnosa (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE,USER_RM)
					VALUES("' . $irna_id . '","' . $diagnosa_order . '","' . $diagnosa . '",
					"' . $icdx . '", "' . $user_name . '")') or die(mysql_error());
		}			
	}
		
$i++;
}

$i = 1;
$st_code_pulang = '';
while ($i <= 4) {
    $irna_diagnosa_idx = $_POST['irna_diagnosa_id_plg' . $i];
	$icdx = $_POST['icd_code_plg' . $i];
	$diagnosa = $_POST['icd_code_plg' . $i];
	$icd_code_array = explode('--', $icdx);
	if(sizeof($icd_code_array) == 2) {
		$icdx = $icd_code_array[0];
		$diagnosa = $icd_code_array[1];
	}	
	$kasus_barux = '';
	if(isset($_POST['kasus_baru_plg' . $i])) $kasus_barux = '1';
	$diagnosa_order = $i - 1;
	if($irna_diagnosa_idx != ''){
		if(!empty($icdx)){
			mysql_query('UPDATE t_irna_diagnosa_pulang SET
				ICD_CODE = "' . $icdx . '",
				KASUS_BARU = "' . $kasus_barux . '"
				WHERE IRNA_DIAGNOSA_PULANG_ID = "' . $irna_diagnosa_idx . '"') or die(mysql_error());
				$st_code_pulang = '1';
		}else{
			$_err = '';
			$st_code = '1';
		}	
	}else{
		if(!empty($icdx)){	
			mysql_query('INSERT INTO t_irna_diagnosa_pulang (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE,USER_RM)
					VALUES("' . $irna_id . '","' . $diagnosa_order . '","' . $diagnosa . '",
					"' . $icdx . '", "' . $user_name . '")') or die(mysql_error());
			$st_code_pulang = '1';		
		}			
	}
		
$i++;
}


/*if ($cndiagnosa > 0) {
    $i = 1;
    while ($i <= $cndiagnosa) {
        if (!empty($_POST['icd_code' . $i])) {
            $irna_diagnosa_idx = $_POST['irna_diagnosa_id' . $i];
            $icdx = $_POST['icd_code' . $i];
            $icd_code_array = explode('--', $icdx);
            $icd_codex = $icd_code_array[0];
            
			if($_POST['diagnosa_tbl' . $i] == '0'){
				mysql_query('UPDATE t_irna_diagnosa SET
							ICD_CODE = "' . $icd_codex . '"
							WHERE IRNA_DIAGNOSA_ID = "' . $irna_diagnosa_idx . '"') or die(mysql_error());
			}else{
				mysql_query('UPDATE t_hemodialisa_diagnosa SET
							ICD_CODE = "' . $icd_codex . '"
							WHERE HEMODIALISA_DIAGNOSA_ID = "' . $irna_diagnosa_idx . '"') or die(mysql_error());
			}				
        } else {
            $_err = '';
			$st_code = '1';
        }
        $i++;
    }
	
}*/

if(currentModul() == 'rekam medik'){ 
if ($cntindakan > 0) {
    $i = 1;
    while ($i <= $cntindakan) {
        if (!empty($_POST['icd_cm_code' . $i])) {
            $irna_tarif_idx = $_POST['irna_tarif_id' . $i];
            $icd_cmx = $_POST['icd_cm_code' . $i];
            $icd_cm_code_array = explode('--', $icd_cmx);
            $icd_cm_codex = $icd_cm_code_array[0];
            
			if($_POST['tindakan_tbl' . $i] == '0'){
				mysql_query('UPDATE t_irna_tarif SET
							ICD_CODE = "' . $icd_cm_codex . '"
							WHERE IRNA_TARIF_ID = "' . $irna_tarif_idx . '"') or die(mysql_error());
			}else if($_POST['tindakan_tbl' . $i] == '1'){
				mysql_query('UPDATE t_hemodialisa_tarif SET
							ICD_CODE = "' . $icd_cm_codex . '"
							WHERE HEMODIALISA_TARIF_ID = "' . $irna_tarif_idx . '"') or die(mysql_error());
			}else if($_POST['tindakan_tbl' . $i] == '2'){
				mysql_query('UPDATE t_operasi_tarif SET
							ICD_CODE = "' . $icd_cm_codex . '"
							WHERE OPERASI_TARIF_ID = "' . $irna_tarif_idx . '"') or die(mysql_error());				
			}				
        } else {
            $_err = '';
			$st_code = '1';
        }
        $i++;
    }
	
}
if ($cnpenunjang > 0) {
    $i = 1;
    while ($i <= $cnpenunjang) {
        if (!empty($_POST['icd_cm_code_penunjang' . $i])) {
            $penunjang_tarif_idx = $_POST['penunjang_tarif_id' . $i];
            $icd_cmx_penunjang = $_POST['icd_cm_code_penunjang' . $i];
            $icd_cmx_penunjang_array = explode('--', $icd_cmx_penunjang);
            $icd_cmx_penunjang_codex = $icd_cmx_penunjang_array[0];
            mysql_query('UPDATE t_ipenunjang_tarif SET
						ICD_CODE = "' . $icd_cmx_penunjang_codex . '"
						WHERE PENUNJANG_TARIF_ID = "' . $penunjang_tarif_idx . '"') or die(mysql_error());
        } else {
            $_err = '';
			$st_code = '1';
        }
        $i++;
    }
	
	$nomor_order = getNomorBulanan('IPENUNJANG');
	$sql_irna = 'SELECT t_irna.PEGAWAI_ID,t_irna.NOMR,t_irna.RUANG_ID,t_irna.JENIS_BAYAR_ID
				FROM t_irna
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
	$get_irna = mysql_query($sql_irna) or die(mysql_error());
	$dat_irna = mysql_fetch_assoc($get_irna);
	$pegawai_id = $dat_irna['PEGAWAI_ID']; 
	$nomr = $dat_irna['NOMR']; 
	$unit_id = $dat_irna['RUANG_ID']; 
	$jenis_bayar_id = $dat_irna['JENIS_BAYAR_ID']; 
	
	mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					RUANG_ID = "' . $unit_id . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "PNJ" AND t_ipenunjang.JNS_ORDER = "IRN"
					AND t_ipenunjang.NO_ORDER IS NULL
					AND t_ipenunjang.DESKRIPSI = "Penunjang (MR)"') or die(mysql_error());
	
	$nomor = getNomorHarian('Tarif');
	$no_bayar = '"' . getNomorHarian('Kasir') . '"';	
	mysql_query('UPDATE t_irna_tarif SET NO_TARIF = "' . $nomor . '", NO_PEMBAYARAN = ' . $no_bayar . ',
					PEGAWAI_ID = "' . $pegawai_id . '"
					WHERE IRNA_ID = "' . $irna_id . '" AND NO_TARIF IS NULL
					AND DESKRIPSI = "Tindakan (MR)"') or die(mysql_error());
}

}
if (!empty($_err)) {
    $msg_info = 'Isian ICD Belum Lengkap.';
} else {
	$query_ext = '';
	if($st_code == '') $query_ext = ',ST_CODING = "1"'; 
	$code_pulang = 'NULL';
	if($st_code_pulang == '1') $code_pulang = '"1"';
    mysql_query('UPDATE t_irna SET USER_RM = "' . $nama_user . '" ' . $query_ext . ',
				ST_CODING_ERM = ' . $code_pulang . '
				WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
	mysql_query('UPDATE t_hemodialisa SET USER_RM = "' . $nama_user . '" 
				WHERE RAWAT_ID = "' . $irna_id . '" AND JNS_ORDER = "IRN"') or die(mysql_error());
	mysql_query('UPDATE t_operasi SET USER_RM = "' . $nama_user . '" 
				WHERE RAWAT_ID = "' . $irna_id . '" AND (JNS_ORDER = "IRN"
				OR ST_MASUK = "2")') or die(mysql_error());
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=3515cdea0931ecbbd0b55f592acad787&idx=<?php echo $irna_id; ?>";
    </script>
    <?php
}
?>