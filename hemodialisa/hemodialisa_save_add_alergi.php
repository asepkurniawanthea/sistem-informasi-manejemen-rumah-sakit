<?php
$irja_id = $_POST['irja_id'];
$alergi = $_POST['alergi'];
$jns_order = $_POST['jns_order'];

$_err = '';
if(empty($alergi))
	$_err = 'Alergi Harus Diisi.';	

if($_err == ''){	
	if(empty($jns_order)){
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {

				mysql_query('INSERT INTO t_irja_alergi(IRJA_ID,ALERGI)
							VALUES("' . $irja_id . '","' . $alergi . '")') or die(mysql_error()); 
		}
	}else{
		$sql_cek_no_klinik = 'SELECT NO_KLINIK FROM t_hemodialisa WHERE HEMODIALISA_ID = "' . $irja_id . '"';
		$get_cek_no_klinik = mysql_query($sql_cek_no_klinik) or die(mysql_error());
		$dat_cek_no_klinik = mysql_fetch_assoc($get_cek_no_klinik);
		if (empty($dat_cek_no_klinik['NO_KLINIK']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {

				mysql_query('INSERT INTO t_hemodialisa_alergi(HEMODIALISA_ID,ALERGI)
							VALUES("' . $irja_id . '","' . $alergi . '")') or die(mysql_error()); 
		}
	}	
$alergi = '';
?>
	  <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
		document.getElementById("resep").focus();
    </script>
<?php	
}else{
?>
	<script language="JavaScript" >
		alert('<?php echo $_err; ?>');
		document.getElementById("resep").focus();
    </script>

<?php
}	
?>