<?php
$irja_id = $_POST['irja_id'];
$cndiagnosa = $_POST['cndiagnosa'];
$cntindakan = $_POST['cntindakan'];
$cnpenunjang = $_POST['cnpenunjang'];
$nama_user = currentUser();

$_err = '';
$st_code = '';
$i = 1;
while ($i <= 4) {
    $irja_diagnosa_idx = $_POST['irja_diagnosa_id' . $i];
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
	if($irja_diagnosa_idx != ''){
		if(!empty($icdx)){
			mysql_query('UPDATE t_irja_diagnosa SET
				ICD_CODE = "' . $icdx . '",
				KASUS_BARU = "' . $kasus_barux . '"
				WHERE IRJA_DIAGNOSA_ID = "' . $irja_diagnosa_idx . '"') or die(mysql_error());
		}else{
			$_err = '';
			$st_code = '1';
		}	
	}else{
		if(!empty($icdx)){	
			mysql_query('INSERT INTO t_irja_diagnosa (IRJA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE,USER_RM)
					VALUES("' . $irja_id . '","' . $diagnosa_order . '","' . $diagnosa . '",
					"' . $icdx . '", "' . $user_name . '")') or die(mysql_error());
		}			
	}
		
$i++;
}

if(currentModul() == 'rekam medik'){ 
if ($cntindakan > 0) {
    $i = 1;
    while ($i <= $cntindakan) {
        if (!empty($_POST['icd_cm_code' . $i])) {
            $irja_tarif_idx = $_POST['irja_tarif_id' . $i];
            $icd_cmx = $_POST['icd_cm_code' . $i];
            $icd_cm_code_array = explode('--', $icd_cmx);
            $icd_cm_codex = $icd_cm_code_array[0];
            if($_POST['tindakan_tbl' . $i] == '0'){
				mysql_query('UPDATE t_irja_tarif SET
							ICD_CODE = "' . $icd_cm_codex . '"
							WHERE IRJA_TARIF_ID = "' . $irja_tarif_idx . '"') or die(mysql_error());
			}else if($_POST['tindakan_tbl' . $i] == '1'){
				mysql_query('UPDATE t_hemodialisa_tarif SET
							ICD_CODE = "' . $icd_cm_codex . '"
							WHERE HEMODIALISA_TARIF_ID = "' . $irja_tarif_idx . '"') or die(mysql_error());
			}else if($_POST['tindakan_tbl' . $i] == '2'){
				mysql_query('UPDATE t_operasi_tarif SET
							ICD_CODE = "' . $icd_cm_codex . '"
							WHERE OPERASI_TARIF_ID = "' . $irja_tarif_idx . '"') or die(mysql_error());				
			}				
        } else {
            $_err = '';
			$st_code = '1';
        }
        $i++;
    }
	
	$nomor = getNomorHarian('Tarif');
	$sql_irja = 'SELECT t_irja.PEGAWAI_ID,t_irja.NOMR,t_irja.UNIT_ID,t_irja.JENIS_BAYAR_ID
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
	$get_irja = mysql_query($sql_irja) or die(mysql_error());
	$dat_irja = mysql_fetch_assoc($get_irja);
	$pegawai_id = $dat_irja['PEGAWAI_ID']; 
	$nomr = $dat_irja['NOMR']; 
	$unit_id = $dat_irja['UNIT_ID']; 
	$jenis_bayar_id = $dat_irja['JENIS_BAYAR_ID']; 
	
	$no_bayar = 'NULL';
	$st_bayar = 'NULL';
	if($jenis_bayar_id <> '1'){
		$no_bayar = '"' . getNomorHarian('Kasir') . '"';
		$st_bayar = '"Lunas"';
	}
					
	mysql_query('UPDATE t_irja_tarif SET NO_TARIF = "' . $nomor . '", 
					NO_PEMBAYARAN = ' . $no_bayar . ',
					ST_BAYAR = ' . $st_bayar . ',
					JENIS_BAYAR_ID = "' . $jenis_bayar_id . '"
					WHERE IRJA_ID = "' . $irja_id . '" 
					AND NO_TARIF IS NULL
					AND DESKRIPSI = "Tindakan (MR)"') or die(mysql_error());
	
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
	$sql_irja = 'SELECT t_irja.PEGAWAI_ID,t_irja.NOMR,t_irja.UNIT_ID,t_irja.JENIS_BAYAR_ID
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
	$get_irja = mysql_query($sql_irja) or die(mysql_error());
	$dat_irja = mysql_fetch_assoc($get_irja);
	$pegawai_id = $dat_irja['PEGAWAI_ID']; 
	$nomr = $dat_irja['NOMR']; 
	$unit_id = $dat_irja['UNIT_ID']; 
	$jenis_bayar_id = $dat_irja['JENIS_BAYAR_ID']; 
	
	mysql_query('UPDATE t_ipenunjang SET NO_ORDER = "' . $nomor_order . '", 
					PEGAWAI_ID = "' . $pegawai_id . '",
					NOMR = "' . $nomr . '",TANGGAL_ORDER = NOW(),
					UNIT_ID = "' . $unit_id . '",JENIS_BAYAR_ID = "' . $jenis_bayar_id . '",
					USER_ORDER = "' . $user_name . '"
					WHERE RAWAT_ID = "' . $irja_id . '" 
					AND t_ipenunjang.JNS_PENUNJANG = "PNJ" 
					AND t_ipenunjang.JNS_ORDER = "IRJ"
					AND t_ipenunjang.NO_ORDER IS NULL
					AND t_ipenunjang.DESKRIPSI = "Penunjang (MR)"') or die(mysql_error());								
}

}
if (!empty($_err)) {
    $msg_info = 'Isian ICD Belum Lengkap.';
} else {
    $query_ext = '';
	if($st_code == '') $query_ext = ',ST_CODING = "1"';  
	mysql_query('UPDATE t_irja SET USER_RM = "' . $nama_user . '" ' . $query_ext . ',
				ST_CREATE_ERM_RRKRJ = NULL
				WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
	/*include('lib/vendor/autoload.php');
	include('lib/vendor/rkorebrits/htmltoopenxml/Archives/Scripts/HTMLtoOpenXML.php');
	include('edoc_rekammedik/new/erm_create_rrkrj.php');
	erm_create_rrkrj($irja_id,$_POST['nomr']);*/				
    ?>
    <script language="JavaScript" >
        window.location = "index.php?link=9cc744cfe67b7f278c46982ee05214a5&idx=<?php echo $irja_id; ?>";
    </script>
    <?php
}
?>