<?php
$irja_id = $_POST['irja_id'];
$q = $_POST['q'];
$_err = '';
if (empty($q))
    $_err = $_err . 'Diagnosa Harus Diisi. \n';
	
if(isset($_POST['gigi'])){
 if(!empty($_POST['gigi'])) $gigi = ' /' . $_POST['gigi'];
} 

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
	
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		$qry_order = 'SELECT DIAGNOSA_ORDER FROM t_irja_diagnosa WHERE IRJA_ID = "' . $irja_id . '"
				ORDER BY DIAGNOSA_ORDER DESC LIMIT 1';
        $get_order = mysql_query($qry_order);
        $dat_order = mysql_fetch_assoc($get_order);
        $diagnosa_order = 0;
        if (mysql_num_rows($get_order) > 0)
            $diagnosa_order = $dat_order['DIAGNOSA_ORDER'] + 1;
        
            
			mysql_query('INSERT INTO t_irja_diagnosa (IRJA_ID,DIAGNOSA_ORDER,DIAGNOSA,ICD_CODE)
					VALUES("' . $irja_id . '","' . $diagnosa_order . '","' . $diagnosa . $gigi . '","' . $icd_code . '")') or die(mysql_error());
		}			
}
	$temp_icd_code = '';
	$gigi = '';
    ?>
    <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
		document.getElementById("diagnosa").focus();
    </script>
