<?php
$_err = '';
$irna_id = $_POST['irna_id'];
$cnr = $_POST['cnr'];
$user_name = currentUser();

if (isset($_POST['simpan'])) {
    $qry_tmp = 'SELECT * FROM t_irna_diagnosa WHERE IRNA_ID = "' . $irna_id . '"
			ORDER BY DIAGNOSA_ORDER';
    $get_tmp = mysql_query($qry_tmp);
    $_err = '';
	if (mysql_num_rows($get_tmp) == 0)
        $_err = 'Diagnosa Harus Diisi. \n';
		
    $sql_cek_no_ranap = 'SELECT NO_RAWAT FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
	$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
	if (empty($dat_cek_no_ranap['NO_RAWAT']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	if (empty($_err)) {
		$i = 1;
        while ($i < $cnr) {
            mysql_query('UPDATE t_irna_diagnosa SET DIAGNOSA_ORDER = "' . $_POST['diagnosa_order' . $i] . '"
				WHERE IRNA_DIAGNOSA_ID = "' . $_POST['diagnosa_id' . $i] . '"') or die(mysql_error());
            $i++;
        }
		mysql_query('UPDATE t_irna SET USER_IRNA = "' . $user_name . '" WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
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