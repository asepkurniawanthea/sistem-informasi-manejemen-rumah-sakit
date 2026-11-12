<?php
$irna_id = $_POST['irna_id'];
$q = $_POST['q'];
$_err = '';
if (empty($q))
    $_err = $_err . 'Diagnosa Harus Diisi. \n';
	
if (!empty($_err)) {
?>
	 <script language="JavaScript" >
        alert('<?php echo $_err; ?>');
    </script>
<?php
} else {
	$temp_icd_code = $_POST['q'];
	$diagnosa_array = explode('--', $temp_icd_code);
	if(count($diagnosa_array) >= 2){
		$icd_code = $diagnosa_array[0];
		$diagnosa = $diagnosa_array[1];
	}else{
		$icd_code = '';
		$diagnosa = $_POST['q'];
	}	
	
		$sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
		$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
		$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
		if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
			if($diagmasuk == '1'){
				$qry_order = 'SELECT DIAGNOSA_ORDER FROM t_irna_diagnosa WHERE IRNA_ID = "' . $irna_id . '"
						ORDER BY DIAGNOSA_ORDER DESC LIMIT 1';
				$get_order = mysql_query($qry_order);
				$dat_order = mysql_fetch_assoc($get_order);
				$diagnosa_order = 0;
				if (mysql_num_rows($get_order) > 0)
					$diagnosa_order = $dat_order['DIAGNOSA_ORDER'] + 1;
					mysql_query('INSERT INTO t_irna_diagnosa (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE)
							VALUES("' . $irna_id . '","' . $diagnosa_order . '","' . $diagnosa . '","' . $icd_code . '")') or die(mysql_error());
				
			}else{
	
				$qry_order = 'SELECT DIAGNOSA_ORDER FROM t_irna_diagnosa_pulang WHERE IRNA_ID = "' . $irna_id . '"
						ORDER BY DIAGNOSA_ORDER DESC LIMIT 1';
				$get_order = mysql_query($qry_order);
				$dat_order = mysql_fetch_assoc($get_order);
				$diagnosa_order = 0;
				if (mysql_num_rows($get_order) > 0)
					$diagnosa_order = $dat_order['DIAGNOSA_ORDER'] + 1;
					mysql_query('INSERT INTO t_irna_diagnosa_pulang (IRNA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE)
							VALUES("' . $irna_id . '","' . $diagnosa_order . '","' . $diagnosa . '","' . $icd_code . '")') or die(mysql_error());
			}
		}	
	}
	$temp_icd_code = '';
    ?>
    <script language="JavaScript" >
		opener.location.reload();
		document.getElementById("diagnosa").focus();
    </script>
