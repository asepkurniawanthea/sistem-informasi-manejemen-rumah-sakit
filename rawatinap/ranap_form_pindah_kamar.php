<?php 
$irna_id = $_GET['idx'];
$ruang_id_baru = '';
$tmp_tidur_baru = '';
$keterangan = '';
$idlog = '';

if(isset($_POST['irna_id']))
	include('rawatinap/ranap_save_pindah_kamar.php');

if(isset($_GET['idlog'])){
	$idlog = $_GET['idlog'];
	$sql_pindah = 'SELECT t_irna_log.*,t_irna.NO_TMP_TIDUR,
				t_irna.PEGAWAI_ID,t_irna.PEGAWAI_RAWAT_ID,t_irna.PEGAWAI_RAWAT_ID_2,
				t_irna.PEGAWAI_RAWAT_ID_3
				FROM t_irna_log 
				INNER JOIN t_irna
				ON (t_irna_log.IRNA_ID = t_irna.IRNA_ID)
				WHERE t_irna_log.IRNA_LOG_ID = "' . $idlog . '"';
	$get_pindah = mysql_query($sql_pindah) or die(mysql_error());
	$dat_pindah = mysql_fetch_assoc($get_pindah);
	$ruang_id_baru = $dat_pindah['RUANG_ID_BARU'];
	$tmp_tidur_baru = $dat_pindah['NO_TMP_TIDUR'];
	$dokter_pjawab = $dat_pindah['PEGAWAI_ID'];
	$dokter_prawat = $dat_pindah['PEGAWAI_RAWAT_ID'];
	$dokter_prawat_2 = $dat_pindah['PEGAWAI_RAWAT_ID_2'];
	$dokter_prawat_3 = $dat_pindah['PEGAWAI_RAWAT_ID_3'];
	$keterangan = $dat_pindah['KETERANGAN_PINDAH'];
}
?>
    <table class="tableData" id="tfhover" >
		<?php include('rawatinap/ranap_tmp_pindah_kamar.php'); ?>
	</table>
	<br />
	<form name="form1" id="form1" method="post" action="<?php echo currentUrl(); ?>">
	<table width="100%" border="0">
		<tr>
			<td colspan="5"><input type="radio" name="pindah" value="1" />&nbsp;Pindah Ruang Rawat</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Ruang Rawat Baru</td>
			<td><select name="ruang_id_baru" id="ruang_id_baru" style="width:228px;" class="text_dt" onchange="javascript : MyAjaxRequest('ctmptidur','index.php?ajaxrequest=ctmptidur&ruang_id=' + this.value);return false;" >
				<option value=""> - </option>
				<?php echo getRuangRawat($ruang_id_baru); ?>
				</select></td>
			<td>Kamar - Nomor Tempat Tidur</td>
			<td><div id="ctmptidur">
				<select name="tmp_tidur" id="tmp_tidur" style="width:128px;" class="text_dt" >
				<option value=""> - </option>
				<?php echo getTempatTidurEdit($ruang_id_baru,$tmp_tidur_baru); ?>
				</select>
				</div></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Dokter Penanggungjawab</td>
			<td><select name="dokter_pjawab" id="dokter_pjawab" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($dokter_pjawab); ?>
			</select></td>
			<td>Tim Dokter Yang Merawat</td>
			<td><select name="dokter_prawat" id="dokter_prawat" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($dokter_prawat); ?>
			</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><select name="dokter_prawat_2" id="dokter_prawat_2" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($dokter_prawat_2); ?>
			</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><select name="dokter_prawat_3" id="dokter_prawat_3" style="width:228px;" class="text_dt" >
			<option value=""> - </option>
			<?php echo getDokterRanap($dokter_prawat_3); ?>
			</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Keterangan</td>
			<td><textarea name="keterangan" class="text_dt3" ><?php echo $keterangan; ?></textarea></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="5"><input type="radio" name="pindah" value="2" checked />&nbsp;Pindah Kamar</td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Kamar - Nomor Tempat Tidur</td>
			<td><div id="ctmptidurnew">
				<select name="tmp_tidur_new_kamar" id="tmp_tidur_new_kamar" style="width:128px;" class="text_dt" >
					<option value=""> - </option>
					<?php echo getTempatTidurEdit($ruang_id,$tmp_tidur_baru); ?>
				</select>
		</div></td>
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
			<td align="right">
			<?php if($irna_final == ''){ ?>
			<input type="button" value="simpan" class="myButton1" onclick="simpan();" />
			<?php } ?>
			</td>
		</tr>
	</table>
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="idlog" id="idlog" value="<?php echo $idlog; ?>" />
	</form>
<script>
function simpan(){
	_haschange = false;
	$('#form1').submit();
}	

MyAjaxRequest('ctmptidurnew','index.php?ajaxrequest=ctmptidurnew_kamar&ruang_id=<?php echo $ruang_id; ?>&no=<?php echo $tmp_tidur_baru; ?>');
</script>	