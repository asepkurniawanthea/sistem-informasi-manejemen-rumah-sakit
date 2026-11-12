<?php if(isset($_GET['icd'])){ 

$icd_code = $_GET['icd'];

if (isset($_POST['icd_code']))
    include('rekammedik/rm_save_icd_9.php');
	
$qry_icd = 'SELECT m_icd_9cm.DESKRIPSI
			FROM m_icd_9cm
			WHERE m_icd_9cm.ICD_CODE = "' . $_GET['icd'] . '"';
$get_icd = mysql_query($qry_icd) or die(mysql_error());
$dat_icd = mysql_fetch_assoc($get_icd);
$deskripsi = $dat_icd['DESKRIPSI'];
?>
<form name="icd" id="frmicd" method="post" action="<?php echo currentUrl(); ?>" >
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table class="tableform" border="0" width="100%" >
	<tr>
		<td width="180px;">ICD Code</td>
		<td width="1px;">:</td>
		<td><input type="text" name="icd_code" value="<?php echo $icd_code; ?>" class="text_dt" readonly="readonly"/></td>
	</tr>
	<tr>
		<td>Deskripsi</td>
		<td>:</td>
		<td><input type="text" name="deskripsi" value="<?php echo $deskripsi; ?>" class="text_dt" size="100"/></td>
	</tr>
</table>
</div>
<div class="div_menu" style=" height:auto; position:relative; padding:15px; border:1px solid #999; border-radius:5px; margin:5px; background-color:#C8EFAD;">
<table width="100%" border="0">
<tr>
		<td width="180px;">&nbsp;</td>
		<td width="50px;">&nbsp;</td>
		<td><input type="button" name="simpan" value="simpan" class="myButton1" onclick="javascript: simpanicd(); return false;" />&nbsp;
		<a href="#" onclick="javascript: selesai('index.php?link=<?php echo 'd5e85c3801a298f3f5b1fe328e6a1f58'; ?>');"><input type="button" name="batal" value="batal" class="myButton1" /></a></td>
	</tr>
</table>
</div>
</form>
<?php } ?>
<script language="JavaScript" >
function selesai(link){
	window.location = link;
}
function simpanicd(){
	if(confirm('Yakin Disimpan ?')){
		document.getElementById("frmicd").submit();
	}
}
</script>