<?php
$irja_id = $_GET['idx'];
if (isset($_POST['irja_id'])){
	$suspect_confirm = 'NULL';
	$komorbit = 'NULL';
	
	if(isset($_POST['pasien_covid'])){
		if(isset($_POST['confirm'])) $suspect_confirm = '"' . $_POST['confirm'] . '"'; 
		if(isset($_POST['komorbit'])) $komorbit = '"' . $_POST['komorbit'] . '"'; 	
	}	
	
	mysql_query('UPDATE t_irja 
			SET ST_COVID19 = ' . $suspect_confirm . ',
			ST_COVID19_KOMORBIT = ' . $komorbit . ',
			USER_IRJA = "' . $user_name . '"
			WHERE IRJA_ID = "' . $irja_id . '"') or die(mysql_error());
}

$sql = 'SELECT ST_COVID19,ST_COVID19_KOMORBIT FROM t_irja WHERE IRJA_ID = "' . $irja_id . '"';
$get = mysql_query($sql) or die(mysql_error());
$dat = mysql_fetch_assoc($get);
$st_covid = $dat['ST_COVID19'];
$st_covid_komorbit = $dat['ST_COVID19_KOMORBIT'];
?>
<form name="formrujukan" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
    <table border="0" width="30%">
        <tr>
            <td width="10%">Covid 19</td>
            <td width="30%">
                <input type="checkbox" name="pasien_covid" value="1" 
				<?php if($st_covid != '') echo 'checked'; ?> />
            </td>
        </tr>
		<tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="confirm" value="1" 
			<?php if($st_covid != '' and $st_covid == '1') echo 'checked'; ?>
			/>&nbsp;Suspect&nbsp;&nbsp;&nbsp;<input type="radio" name="confirm" value="2" 
			<?php if($st_covid != '' and $st_covid == '2') echo 'checked'; ?>
			/>&nbsp;Confirm</td>
        </tr>
		<tr>
            <td>&nbsp;</td>
            <td><input type="radio" name="komorbit" value="1" 
			<?php if($st_covid != '' and $st_covid_komorbit == '1') echo 'checked'; ?> 
			/>&nbsp;Non Komorbit&nbsp;&nbsp;&nbsp;<input type="radio" name="komorbit" value="2" 
			<?php if($st_covid != '' and $st_covid_komorbit == '2') echo 'checked'; ?>
			/>&nbsp;Komorbit</td>
        </tr>
		<tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="left">&nbsp;</td>
			<td><?php if($irja_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" /><?php } ?></td>
        </tr>
    </table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>