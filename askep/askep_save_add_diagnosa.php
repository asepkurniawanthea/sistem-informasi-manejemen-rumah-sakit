<?php
$irna_id = $_POST['irna_id'];
$nomr = $_POST['nomr'];
$domain = $_POST['domain'];
$diagnosa = $_POST['diagnosa'];
$gejala = $_POST['gejala'];
$etiologi = $_POST['etiologi'];

$_err = '';
/*if(empty($domain))
	$_err = 'Domain Harus Diisi.';	
if(empty($diagnosa))
	$_err = 'Diagnosa Harus Diisi.';	
if(empty($gejala))
	$_err = 'Daftar Gejala Harus Diisi.';	
if(empty($etiologi))
	$_err = 'Daftar Etiologi Harus Diisi.';	*/

if($_err == ''){	
	$sql_cek_no_rawat = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_no_rawat = mysql_query($sql_cek_no_rawat) or die(mysql_error());
	$dat_cek_no_rawat = mysql_fetch_assoc($get_cek_no_rawat);
	if (empty($dat_cek_no_rawat['ST_ASKEP']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
		       
			mysql_query('INSERT INTO t_irna_askep_diagnosa(IRNA_ID,TGL_DIAGNOSA,
							DOMAIN,DIAGNOSIS,DAFTAR_GEJALA,DAFTAR_ETIOLOGI)
							VALUES("' . $irna_id . '",NOW(),"' . $domain . '",
							"' . $diagnosa . '","' . $gejala . '","' . $etiologi . '")') or die(mysql_error());
			 
	}
$askep_diagnosa_id = '';
$domain = '';
$diagnosis = '';
$gejala = '';
$etiologi = '';
?>
	  <script language="JavaScript" >
		setTimeout(opener.location.reload(), 3000);
		document.getElementById("domain").focus();
    </script>
<?php	
}else{
?>
	<script language="JavaScript" >
		alert('<?php echo $_err; ?>');
		document.getElementById("domain").focus();
    </script>

<?php
}	
?>