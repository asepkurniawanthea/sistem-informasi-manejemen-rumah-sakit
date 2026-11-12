<?php
$diagnosa = '';
$icd_code = '';
$irna_id = $_POST['irna_id'];
$q = $_POST['q'];
$_err = '';
if (empty($q))
    $_err = $_err . 'Diagnosa Harus Diisi. \n';
	
if(!empty($q)){
	$temp_icd_code = $_POST['q'];
	$diagnosa_array = explode('--', $temp_icd_code);
	if(count($diagnosa_array) >= 2){
		$icd_code = $diagnosa_array[0];
		$diagnosa = $diagnosa_array[1];
	}else{
		$_err = $_err . 'Diagnosa Belum Lengkap. \n';
	}
}	

if (!empty($_err)) {
?>
	 <script language="JavaScript" >
        alert('<?php echo $_err; ?>');
    </script>
<?php
} else {
		
		if (currentModul() == 'rekam medik' and $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		$qry_order = 'SELECT DIAGNOSA_ORDER FROM t_irna_diagnosa WHERE IRNA_ID = "' . $irna_id . '"
				ORDER BY DIAGNOSA_ORDER DESC LIMIT 1';
        $get_order = mysql_query($qry_order);
        $dat_order = mysql_fetch_assoc($get_order);
        $diagnosa_order = 0;
        if (mysql_num_rows($get_order) > 0)
            $diagnosa_order = $dat_order['DIAGNOSA_ORDER'] + 1;
        
            
			mysql_query('INSERT INTO t_irna_diagnosa (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE,USER_RM)
					VALUES("' . $irna_id . '","' . $diagnosa_order . '","' . $diagnosa . '","' . $icd_code . '", "' . $user_name . '")') or die(mysql_error());
		}			
}
	$temp_icd_code = '';
    ?>
    <script language="JavaScript" >
		opener.location.reload();
		document.getElementById("diagnosa").focus();
    </script>
