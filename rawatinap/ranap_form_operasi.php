<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

if (isset($_POST['dokter_operasi']))
    include('rawatinap/ranap_save_operasi.php');

if (isset($_GET['iop']))
    include('rawatinap/ranap_del_add_operasi.php');
?>
<table class="tableData" id="tfhover" >
	<?php include('rawatinap/ranap_tmp_operasi.php'); ?>
</table>
<br />
<form name="formedit" id="formedit" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="rawat_id" id="rawat_id" value="<?php echo $irna_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table border="0" width="100%">
	<tr><td>
	<table border="0" width="100%">
	<tr>
    <td>&nbsp;</td>
    <td width="180">Dokter Pelaksana Operasi</td>
    <td width="200"><select name="dokter_operasi" id="dokter_operasi" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter(''); ?>
                </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Tanggal Rencana Operasi</td>
    <td><input type="text" name="tgl_rencana" id="tgl_1" size="15" class="text_dt" />
	  <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar8')"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="180">Dokter Pengirim</td>
    <td width="200"><select name="dokter_pengirim" id="dokter_pengirim" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokterRanap($pegawai_id); ?>
                </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php if($irna_final == ''){ ?><input type="button" value="simpan" class="myButton1" onclick="simpan();" /><?php } ?></td>
    <td>&nbsp;</td>
  </tr>
  </table>
	</td>
	<td>
	</td></tr></table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#formedit').submit();
}	
</script>