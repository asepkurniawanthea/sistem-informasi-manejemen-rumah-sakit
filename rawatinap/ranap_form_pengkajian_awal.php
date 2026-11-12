<?php
/*
include('lib/vendor/autoload.php');
include('lib/html2openxml/HTMLtoOpenXML.php');
*/
		
if(isset($_POST['pam'])) $pam = $_POST['pam'];
if($pam == '') $pam = '38';

function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
?>		
<table border="0" align="center" style="position:static; " width="95%">
<tr>
	<td>Form</td>
	<td><input type="radio" name="pam" id="pam_1" value="38" <?php if($pam == '' or $pam == '38') echo 'checked'; ?> onclick="loadPAM(38);" >&nbsp;Umum&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pam" id="pam_2" value="5" <?php if($pam == '5') echo 'checked'; ?> onclick="loadPAM(5);" >&nbsp;Gigi&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pam" id="pam_3" value="29" <?php if($pam == '29') echo 'checked'; ?> onclick="loadPAM(29);" >&nbsp;Mata&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pam" id="pam_6" value="2" <?php if($pam == '2') echo 'checked'; ?> onclick="loadPAM(2);" >&nbsp;Kandungan&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pam" id="pam_7" value="3" <?php if($pam == '3') echo 'checked'; ?> onclick="loadPAM(3);" >&nbsp;Anak&nbsp;&nbsp;&nbsp;
	<input type="radio" name="pam" id="pam_4" value="35" <?php if($pam == '35') echo 'checked'; ?> onclick="loadPAM(35);" >&nbsp;Kusta</td>
</tr>
</table>
</br>
<div id="pam_38">	
<?php include('rawatinap/ranap_form_pengkajian_awal_medis_umum.php'); ?>	
</div>
<div id="pam_5">	
<?php include('rawatinap/ranap_form_pengkajian_awal_medis_gigi.php'); ?>	
</div>
<div id="pam_29">	
<?php include('rawatinap/ranap_form_pengkajian_awal_medis_mata.php'); ?>	
</div>
<div id="pam_35">	
<?php include('rawatinap/ranap_form_pengkajian_awal_medis_kusta.php'); ?>
</div>
<div id="pam_36">	
<?php include('rawatinap/ranap_form_pengkajian_awal_medis_kandungan.php'); ?>
</div>
<div id="pam_37">	
<?php include('rawatinap/ranap_form_pengkajian_awal_medis_anak.php'); ?>
</div>
<script language="javascript" type="text/javascript">
function loadPAM(id){
	$('#pam_38').hide(); 
	$('#pam_5').hide();
	$('#pam_29').hide();
	$('#pam_35').hide();
	$('#pam_36').hide();
	$('#pam_37').hide();
	
	if(id == 38) $('#pam_38').show(); 
	if(id == 5) $('#pam_5').show();
	if(id == 29) $('#pam_29').show();
	if(id == 35) $('#pam_35').show();
	if(id == 2) $('#pam_36').show();
	if(id == 3) $('#pam_37').show();
}

loadPAM(<?php echo $pam; ?>);
</script>