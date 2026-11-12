<?php 
$irja_id = $_GET['idx'];

if (isset($_POST['irja_id']))
    include('klinik/klinik_save_hemodialisa.php');

if (isset($_GET['idk']))
    include('klinik/klinik_del_add_hemodialisa.php');
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
		<?php if(currentModul() == 'igd' or currentModul() == 'casemix'){ ?>
		<?php include('klinik/klinik_tmp_igd_hemodialisa.php'); ?>
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
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="order" class="myButton1" /></td>		
        </tr>
		</table>
		<?php } } ?>
</form>