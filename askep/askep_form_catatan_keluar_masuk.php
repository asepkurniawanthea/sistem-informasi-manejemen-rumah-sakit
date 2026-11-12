<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#jenis_keluar_masuk").autocomplete("index.php?autocomp=autocompranapkeluarmasuk",{width: 260});
    });
</script>
<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

if (isset($_GET['idc']))
    include('askep/askep_del_add_catatan_keluar_masuk.php');

if (isset($_POST['simpan']))
    include('askep/askep_save_catatan_keluar_masuk.php');

$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$keluar_masuk_id ='';
$jenis_keluar_masuk ='';
$catatan ='';
$perawat ='';

if(isset($_GET['idce'])){
	
$sql_ubah = 'SELECT KELUAR_MASUK_ID,IRNA_ID,
			DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,
			DATE_FORMAT(TANGGAL,"%H") AS JAM,
			DATE_FORMAT(TANGGAL,"%i") AS MENIT,
			JENIS_KELUAR_MASUK,CATATAN,PERAWAT
			FROM t_irna_askep_catatan_keluar_masuk
			WHERE KELUAR_MASUK_ID = "' . $_GET['idce'] . '"';
$get_ubah = mysql_query($sql_ubah) or die(mysql_error());		
$dat_ubah = mysql_fetch_assoc($get_ubah);						
$keluar_masuk_id = $dat_ubah['KELUAR_MASUK_ID'];
$tanggal = $dat_ubah['TANGGAL'];
$jam = $dat_ubah['JAM'];
$menit = $dat_ubah['MENIT'];
$jenis_keluar_masuk = $dat_ubah['JENIS_KELUAR_MASUK'];
$catatan = $dat_ubah['CATATAN'];
$perawat = $dat_ubah['PERAWAT'];
}
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="keluar_masuk_id" id="keluar_masuk_id" value="<?php echo $keluar_masuk_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('askep/askep_tmp_catatan_keluar_masuk.php'); ?>        
    </table>
	 <table border="0" width="95%" cellpadding="0" cellspacing="0" align="center">
        <tr><td colspan="2">&nbsp;</td></tr>						
		<tr>
			<td width="200px;">Tanggal</td>
            <td>
			<input type="text" name="tanggal" id="tgl_1" class="text_dt" size="10" value="<?php echo $tanggal; ?>" readonly="readonly" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select>
			</td>
		</tr>
        <tr>
			<td>Intake/Output</td>
            <td><input type="text" name="jenis_keluar_masuk" id="jenis_keluar_masuk" class="text_dt" size="40" value="<?php echo $jenis_keluar_masuk; ?>"/></td>
		</tr>
		<tr>
			<td>Catatan</td>
            <td><textarea name="catatan" class="text_dt3" ><?php echo $catatan; ?></textarea></td>
		</tr>
		<tr>
			<td>Perawat</td>
            <td><select name="perawat" class="text_dt" >
			<option value="" > -- </option>
			<?php echo getPelaksanaRanap($_SESSION['SES_SIMRS_PEGAWAI_ID'], $_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select></td>
		</tr>	
		<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" value="simpan" name="simpan" class="myButton1" /></td>
	</tr>
	</table>
</form>