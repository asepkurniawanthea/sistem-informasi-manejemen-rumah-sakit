<?php 
$irja_id = $_GET['idx'];
if(($status_anamnesis == '1' && $status_diagnosa == '1') or currentModul() == 'igd' or currentModul() == 'casemix' or currentModul() == 'kusta'){

if (isset($_POST['irja_id']))
    include('klinik/klinik_save_penunjang_hemodialisa.php');

if (isset($_GET['idk']))
    include('klinik/klinik_del_add_penunjang_hemodialisa.php');

$irja_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
	<?php if(currentModul() == 'klinik' or currentModul() == 'kusta' ){ ?>
        <?php include('klinik/klinik_tmp_penunjang_hemodialisa.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="4">&nbsp;</td>
        </tr>
    </table>
	<table width="100%" >	
		<tr>
            <td colspan="7" align="right">
			<a href="#" onclick="window.open('index.php?popup=klinikformpenunjanghemodialisa&idx=<?php echo $irja_id; ?>&grp=95','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
	</table>	
		<?php }else if(currentModul() == 'igd' or currentModul() == 'casemix'){ ?>
		<?php include('klinik/klinik_tmp_penunjang_igd_hemodialisa.php'); ?>
		</table>
		<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			Dokter Pengirim&nbsp;&nbsp;<select name="pegawai_id" id="pegawai_id" style="width:228px;" class="text_dt" >
                    <option value="" > - </option>
                    <?php echo getDokter($pegawai_id, '9'); ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="#" onclick="window.open('index.php?popup=klinikformpenunjanghemodialisa&idx=<?php echo $irja_id; ?>&grp=95','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
		</table>
		<?php } ?>
</form>
<?php }else{ ?>
 <script language="JavaScript" >
    window.location = "index.php?link=<?php echo md5('klinikformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $irja_id; ?>";
 </script>
<?php } ?>