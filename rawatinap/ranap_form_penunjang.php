<?php 
$irna_id = $_GET['idx'];

if (isset($_POST['irna_id']) and isset($_POST['simpan']))
    include('rawatinap/ranap_save_penunjang.php');

if (isset($_POST['irna_id']) and isset($_POST['order']))
    include('rawatinap/ranap_save_order_penunjang.php');

if (isset($_GET['idk']))
    include('rawatinap/ranap_del_add_penunjang.php');

if (isset($_GET['idp']))
    include('rawatinap/ranap_del_order_penunjang.php');

$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('rawatinap/ranap_tmp_penunjang.php'); ?>
	</table>
	<?php if($irna_final == ''){ ?>
	<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			Penunjang Tujuan&nbsp;&nbsp;<select name="penunjang_unit_id" id="penunjang_unit_id" style="width:228px;" class="text_dt" onblur="false_kan();" >
                    <option value="" > - </option>
                    <option value="31"  >Fisioterapi</option> 
					<option value="41"  >Okupasi Terapi</option> 
					<option value="51"  >Perawatan Luka</option> 
					<option value="47"  >Psikologi</option> 
					<option value="40"  >Terapi Wicara</option>
					<option value="42"  >Phrotesa</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			Dokter Pengirim&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" onblur="false_kan();" >
                    <option value="" > - </option>
                    <?php echo getDokterRanap($pegawai_id); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="order" value="order" class="myButton1" />	
			<a href="#" onclick="window.open('index.php?popup=ranapformpenunjang&idx=<?php echo $irna_id; ?>&grp=41','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
			<input type="hidden" name="kelas_rawat" value="<?php echo $kelas_rawat; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
	</table>
	<?php } ?>
</form>