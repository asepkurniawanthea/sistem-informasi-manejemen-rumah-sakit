<?php
$_err = '';
$irja_id = $_POST['irja_id'];
$cnr = $_POST['cnr'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_irja_diagnosa WHERE IRJA_ID = "' . $irja_id . '"
			ORDER BY DIAGNOSA_ORDER';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Diagnosa Harus Diisi. \n';
		
    $sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
	$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
	$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
	if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		$i = 1;
        while ($i < $cnr) {
            mysql_query('UPDATE t_irja_diagnosa SET DIAGNOSA_ORDER = "' . $_POST['diagnosa_order' . $i] . '"
				WHERE IRJA_DIAGNOSA_ID = "' . $_POST['diagnosa_id' . $i] . '"') or die(mysql_error());
            $i++;
        }
		mysql_query('UPDATE t_irja SET USER_IRJA = "' . $user_name . '" WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
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
}
?>