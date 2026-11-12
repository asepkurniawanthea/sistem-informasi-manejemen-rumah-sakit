<?php 
$irna_id = $_GET['idx'];
if (isset($_POST['simpan'])){
	$sql_cek_st_askep = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
	$get_cek_st_askep = mysql_query($sql_cek_st_askep) or die(mysql_error());
	$dat_cek_st_askep = mysql_fetch_assoc($get_cek_st_askep);
	if (empty($dat_cek_st_askep['ST_ASKEP'])  or $_SESSION['SES_SIMRS_ADMIN'] == '1') {	
		$st_askep = '';
		if(isset($_POST['st_askep'])) $st_askep = '1';
		mysql_query('UPDATE t_irna SET ST_ASKEP = "' . $st_askep . '" 
					WHERE IRNA_ID = "' . $irna_id . '"') or die(mysql_error());
		//edoc rekam medic
		include('edoc_rekammedik/edoc_main.php');
		create_pdf_asuhan_keperawatan_rawat_inap($irna_id);
		//			
	}	
}

$qry_askep = 'SELECT ST_ASKEP FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
$get_askep = mysql_query($qry_askep) or die(mysql_error());
$dat_askep = mysql_fetch_assoc($get_askep);
$st_askep = $dat_askep['ST_ASKEP']; 
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
		<table width="100%" >
        <tr>
            <td colspan="12" align="center">	
			<input type="checkbox" name="st_askep" value="1" <?php if($st_askep == '1') echo 'checked="checked"'; ?> />&nbsp;Selesai&nbsp;&nbsp;
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
		</table>
</form>