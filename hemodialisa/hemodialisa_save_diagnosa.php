<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$jns_order = $_POST['jns_order'];
$cnr = $_POST['cnr'];
$user_name = currentUser();

$_err = '';
if (isset($_POST['simpan'])) {
	if(empty($jns_order)){
	
		$qry_tmp = 'SELECT * FROM t_irja_diagnosa WHERE IRJA_ID = "' . $irja_id . '"
				ORDER BY DIAGNOSA_ORDER';
		$get_tmp = mysql_query($qry_tmp);
		if (mysql_num_rows($get_tmp) == 0)
			$_err = 'Diagnosa Harus Diisi. \n';
			
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($_err) and (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1')) {
			$i = 1;
			while ($i < $cnr) {
				mysql_query('UPDATE t_irja_diagnosa SET DIAGNOSA_ORDER = "' . $_POST['diagnosa_order' . $i] . '"
					WHERE IRJA_DIAGNOSA_ID = "' . $_POST['diagnosa_id' . $i] . '"') or die(mysql_error());
				$i++;
			}
			mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());	
		}	
	}else{
		
		$qry_tmp = 'SELECT * FROM t_hemodialisa_diagnosa WHERE HEMODIALISA_ID = "' . $irja_id . '"
				ORDER BY DIAGNOSA_ORDER';
		$get_tmp = mysql_query($qry_tmp);
		if (mysql_num_rows($get_tmp) == 0)
			$_err = 'Diagnosa Harus Diisi. \n';
			
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($_err) and (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1')) {
			$i = 1;
			while ($i < $cnr) {
				mysql_query('UPDATE t_hemodialisa_diagnosa SET DIAGNOSA_ORDER = "' . $_POST['diagnosa_order' . $i] . '"
					WHERE HEMODIALISA_DIAGNOSA_ID = "' . $_POST['diagnosa_id' . $i] . '"') or die(mysql_error());
				$i++;
			}
			mysql_query('UPDATE t_hemodialisa SET USER_IRJA = "' . $user_name . '" WHERE HEMODIALISA_ID = "' . $irja_id . '"') or die(mysql_error());		
		}
	}	
	
if (empty($_err)) {	
?>
<script language="JavaScript" >
	alert('Simpan Data Diagnosa Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
}
?>