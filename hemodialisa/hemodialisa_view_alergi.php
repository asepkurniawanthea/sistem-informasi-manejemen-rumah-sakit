<?php
if(empty($jns_order)){
	$qry_pasien = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.ALERGI
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
}else{
	$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID, t_hemodialisa.NOMR, t_hemodialisa.ALERGI
				FROM t_hemodialisa
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $irja_id . '"';
}				
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irja_id = $dat_pasien['IRJA_ID'];
$alergi = $dat_pasien['ALERGI'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="jns_order" id="jns_order" value="<?php echo $jns_order; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('hemodialisa/hemodialisa_tmp_alergi.php'); ?>        
    </table>
</form>