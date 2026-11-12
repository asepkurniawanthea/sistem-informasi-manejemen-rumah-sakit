<?php 
$irja_id = $_GET['idx'];

if (isset($_POST['irja_id']) and isset($_POST['simpan']))
    include('klinik/klinik_save_penunjang.php');

if (isset($_POST['irja_id']) and isset($_POST['order']))
    include('klinik/klinik_save_order_penunjang.php');

if (isset($_GET['idk']))
    include('klinik/klinik_del_add_penunjang.php');

if (isset($_GET['idp']))
    include('klinik/klinik_del_order_penunjang.php');
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
	<?php if(currentModul() == 'klinik' or currentModul() == 'kusta'){ ?>
        <?php include('klinik/klinik_tmp_penunjang.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="4">&nbsp;</td>
        </tr>
    </table>
	<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			<?php if($irja_final == ''){ ?>
			Penunjang Tujuan&nbsp;&nbsp;<select name="penunjang_unit_id" id="penunjang_unit_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <option value="31"  >Fisioterapi</option> 
					<option value="41"  >Okupasi Terapi</option> 
					<option value="51"  >Perawatan Luka</option> 
					<option value="47"  >Psikologi</option> 
					<option value="40"  >Terapi Wicara</option>
					<option value="42"  >Prothesa</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />	
			<input type="submit" name="order" value="order" class="myButton1" />	
			<a href="#" onclick="window.open('index.php?popup=klinikformpenunjang&idx=<?php echo $irja_id; ?>&grp=41','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?>
			</td>	
        </tr>
		</table>	
		<?php }else if(currentModul() == 'igd' or currentModul() == 'casemix'){ ?>
		<?php include('klinik/klinik_tmp_penunjang_igd.php'); ?>
		</table>
		<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			<?php if($irja_final == ''){ ?>
			Penunjang Tujuan&nbsp;&nbsp;<select name="penunjang_unit_id" id="penunjang_unit_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <option value="31"  >Fisioterapi</option> 
					<option value="41"  >Okupasi Terapi</option> 
					<option value="51"  >Perawatan Luka</option> 
					<option value="47"  >Psikologi</option> 
					<option value="40"  >Terapi Wicara</option>
					<option value="42"  >Prothesa</option>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
				<input type="hidden" name="pegawai_id" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" />
			<?php }else{ ?>	
				Dokter Pengirim&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php if(currentModul() == 'igd') echo getDokter($pegawai_id, '9'); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php } ?>	
			<input type="submit" name="order" value="order" class="myButton1" />	
			<a href="#" onclick="window.open('index.php?popup=klinikformpenunjang&idx=<?php echo $irja_id; ?>&grp=41','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?></td>	
        </tr>
		</table>
		<?php } ?>
</form>
