<?php
$shift = getShift();
if(isset($_POST['shift'])){
	$_SESSION['SES_SIMRS_SHIFT'] = $_POST['shift'];
	$_SESSION['SES_SIMRS_SHIFT_KASIR'] = $_POST['shift_kasir'];
?>
<script language="JavaScript" type="text/javascript">
    window.close();
</script>
<?php	
}
?>
<style>
html{
background:url(image/bg_pattern1.jpg);
}
</style>
<form name="form1" method="post" >
<fieldset style="margin-top:5px; border-radius:5px; height:auto; margin:0; padding:0; padding-bottom:5px; stroke:red; ">
<legend style="font-weight:bold; height:25px; width:auto; padding-left:15px; margin-top:5px; margin-left:25px; padding-right:15px; text-align:center; border:-radius:5px; border:1px solid black; box-shadow:1px 1px 1px 1px rgba(0,0,0,2);">Pilih Shift
</legend>		
	<table height="100%" width="100%" border="0">
	<tr>
		<td align="right">&nbsp;</td>
	</tr>
	<tr>
		<td align="center">
			<input type="radio" name="shift" value="1" <?php if($shift == '1') echo 'checked="checked"'; ?> >&nbsp;1&nbsp;
			<input type="radio" name="shift" value="2" <?php if($shift == '2') echo 'checked="checked"'; ?> >&nbsp;2&nbsp;
			<input type="radio" name="shift" value="3" <?php if($shift == '3') echo 'checked="checked"'; ?> >&nbsp;3&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center">
			<input type="radio" name="shift_kasir" value="1" checked="checked" >&nbsp;Rawat Jalan&nbsp;
			<input type="radio" name="shift_kasir" value="2" >&nbsp;IGD&nbsp;
		</td>
	</tr>
	<tr>
		<td align="right">
			<input type="submit" value="simpan" class="myButton1" />	
		</td>
	</tr>
	
	
	</table>
</fieldset>
</form>