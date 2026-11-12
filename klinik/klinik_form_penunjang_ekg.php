<?php 
$irja_id = $_GET['idx'];

if (isset($_POST['irja_id']))
    include('klinik/klinik_save_penunjang_ekg.php');

if (isset($_GET['idk']))
    include('klinik/klinik_del_add_penunjang_ekg.php');
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
	<?php if(currentModul() == 'klinik' or currentModul() == 'kusta' ){ ?>
        <?php include('klinik/klinik_tmp_penunjang_ekg.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="4">&nbsp;</td>
        </tr>
    </table>
	<table width="100%" >	
		<tr>
            <td colspan="7" align="right">
			<?php if($irja_final == ''){ ?>
			<a href="#" onclick="window.open('index.php?popup=klinikformpenunjangekg&idx=<?php echo $irja_id; ?>&grp=41','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>			
			<input type="hidden" name="pegawai_id" value="<?php echo $pegawai_id; ?>" />
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?>
			</td>	
        </tr>
	</table>	
		<?php }else if(currentModul() == 'igd' or currentModul() == 'casemix'){ ?>
		<?php include('klinik/klinik_tmp_penunjang_igd_ekg.php'); ?>
		</table>
		<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			<?php if($irja_final == ''){ ?>
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
			<input type="hidden" name="pegawai_id" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" />
			<?php }else{ ?>
			<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" onblur="false_kan();" >
			<option value="" > - </option>
			<?php echo getDokter('', $_SESSION['SES_SIMRS_UNIT_ID']); ?>
			</select>	
			<?php } ?>
			<a href="#" onclick="window.open('index.php?popup=klinikformpenunjangekg&idx=<?php echo $irja_id; ?>&grp=41','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?>
			</td>	
        </tr>
		</table>
		<?php } ?>
</form>