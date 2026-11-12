<?php 
if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_hemodialisa.php');

if (isset($_GET['idk']))
    include('rawatinap/ranap_del_add_hemodialisa.php');
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $idx; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('rawatinap/ranap_tmp_hemodialisa.php'); ?>
	</table>
	<?php if($irna_final == ''){ ?>
	<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			Dokter Pengirim&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" onblur="false_kan();" >
                    <option value="" > - </option>
                    <?php echo getDokterRanap($pegawai_id); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="order" class="myButton1" /></td>	
        </tr>
	</table>
	<?php } ?>
</form>