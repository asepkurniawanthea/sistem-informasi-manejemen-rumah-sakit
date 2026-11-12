<?php
$irna_id = $_GET['idx'];
$alergi = '';

$qry_pasien = 'SELECT t_irna.IRNA_ID, t_irna.NOMR, t_irna.ALERGI
				FROM t_irna
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irna_id = $dat_pasien['IRNA_ID'];
$alergi = $dat_pasien['ALERGI'];

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_alergi.php');
if (isset($_GET['idg']))
    include('rawatinap/ranap_del_add_alergi.php');	
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('rawatinap/ranap_tmp_alergi.php'); ?>        
    </table>
	<table width="100%">
	<tr>
            <td colspan="5" align="right">
			<a href="#" onclick="window.open('index.php?popup=rawatinapformalergi&idx=<?php echo $irna_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=250')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="cnr" value="<?php echo $i; ?>" /></td>	
        </tr>
	</table>
</form>