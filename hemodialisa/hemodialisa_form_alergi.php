<?php
$irja_id = $_GET['idx'];
if($status_anamnesis == '1' && $status_diagnosa == '1'){

$alergi = '';

if(empty($jns_order)){
	$qry_pasien = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.ALERGI
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
}else{
	$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID, t_hemodialisa.NOMR, t_hemodialisa.ALERGI
				FROM t_hemodialisa
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $irja_id . '"';
}				
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irja_id = $dat_pasien['IRJA_ID'];
$alergi = $dat_pasien['ALERGI'];

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_alergi.php');
if (isset($_GET['idg']))
    include('hemodialisa/hemodialisa_del_add_alergi.php');	
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="jns_order" id="jns_order" value="<?php echo $jns_order; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('hemodialisa/hemodialisa_tmp_alergi.php'); ?>        
    </table>
	<table width="100%">
	<tr>
            <td colspan="5" align="right">
			<a href="#" onclick="window.open('index.php?popup=hemodialisaformalergi&idx=<?php echo $irja_id; ?>&ord=<?php echo $jns_order; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="cnr" value="<?php echo $i; ?>" /></td>	
        </tr>
	</table>
</form>
<?php }else{ ?>
 <script language="JavaScript" >
    window.location = "index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $irja_id; ?>&ord=<?php echo $jns_order; ?>";
 </script>
<?php } ?>