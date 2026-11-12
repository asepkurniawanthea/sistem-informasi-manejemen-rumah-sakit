<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
if (isset($_GET['idc']))
    include('askep/askep_del_add_catatan_keperawatan.php');
if (isset($_POST['irna_id']))
	include('askep/askep_save_catatan_keperawatan.php');

$irna_id = $_GET['idx'];
$catatan_keperawatan_id = '';
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$soap = '';
$perawat = '';

if(isset($_GET['idce'])){
	
$sql_ubah = 'SELECT CATATAN_KEPERAWATAN_ID,
		DATE_FORMAT(TANGGAL,"%d/%m/%Y") AS TANGGAL,
		DATE_FORMAT(TANGGAL,"%H") AS JAM,
		DATE_FORMAT(TANGGAL,"%i") AS MENIT,
		SOAP,PERAWAT,USER_ASKEP
		FROM t_irna_askep_catatan_keperawatan
		WHERE CATATAN_KEPERAWATAN_ID = "' . $_GET['idce'] . '"';
$get_ubah = mysql_query($sql_ubah) or die(mysql_error());		
$dat_ubah = mysql_fetch_assoc($get_ubah);						
$catatan_keperawatan_id = $dat_ubah['CATATAN_KEPERAWATAN_ID'];
$tanggal = $dat_ubah['TANGGAL'];
$jam = $dat_ubah['JAM'];
$menit = $dat_ubah['MENIT'];
$soap = $dat_ubah['SOAP'];
$perawat = $dat_ubah['PERAWAT'];
}

?>
<form name="formedukasi" id="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="catatan_keperawatan_id" id="catatan_keperawatan_id" value="<?php echo $catatan_keperawatan_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('askep/askep_tmp_catatan_keperawatan.php'); ?>        
    </table>
	<br />
	<br />
	<table width="100%" border="0">
	<tr>
		<td>Tanggal</td>
		<td><input type="text" name="tanggal" id="tgl_edu_1" value="<?php echo $tanggal; ?>" class="text_dt" /><img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/>
			Pukul <select name="jam" id="jam" style="width:50px;" class="text_dt" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" >
			<?php echo getMenit($menit); ?>
			</select></td>		
    </tr>
	<tr>
		<td>Implementasi dan Evaluasi Keperawatan (SOAP)</td>
		<td><textarea name="soap" id="soap" class="text_dt2" ><?php echo $soap; ?></textarea></td>		
    </tr>
	<tr>
		<td>Perawat</td>
		<td><select name="perawat" id="perawat" class="text_dt">
		<option> - </option>
		<?php if(empty($perawat)) $perawat = $_SESSION['SES_SIMRS_PEGAWAI_ID']; 
			echo getPerawat($perawat); ?>
		</select></td>		
    </tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
		<?php if($irna_final == ''){ ?>
		<input type="button" value="simpan" class="myButton" onclick="simpan();" />
		<?php } ?>
		</td>
	</tr>
	</table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedukasi').submit();
}	
</script>