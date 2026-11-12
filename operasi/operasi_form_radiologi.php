<?php 
$operasi_id = $_GET['idx'];

if (isset($_POST['operasi_id']))
    include('operasi/operasi_save_radiologi.php');

if (isset($_GET['idk']))
    include('operasi/operasi_del_add_radiologi.php');

$operasi_id = $_GET['idx'];
$order_operasi = 'ORJ';
if($st_masuk == '2') $order_operasi = 'ORI';
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="operasi_id" id="operasi_id" value="<?php echo $operasi_id; ?>" />
	<input type="hidden" name="rawat_id" id="rawat_id" value="<?php echo $rawat_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
	<?php include('operasi/operasi_tmp_radiologi.php'); ?>
		</table>
		<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			Dokter Pengirim&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokterRanap($pegawai_id); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="#" onclick="window.open('index.php?popup=operasiformradiologi&idx=<?php echo $operasi_id; ?>&grp=27&ord=<?php echo $order_operasi; ?>&rid=<?php echo $rawat_id; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="ruang_id" value="<?php echo $ruang_id; ?>" />
			<input type="hidden" name="unit_id" value="<?php echo $unit_id; ?>" />
			<input type="hidden" name="kelas_rawat" value="<?php echo $kelas_rawat; ?>" />
			<input type="hidden" name="order_operasi" value="<?php echo $order_operasi; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
		</table>
</form>