<?php 
$irja_id = $_GET['idx'];

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_laboratorium.php');

if (isset($_GET['idk']))
    include('hemodialisa/hemodialisa_del_add_laboratorium.php');

?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="idxord" id="idxord" value="<?php echo $idxord; ?>" />
	<input type="hidden" name="jnsp" id="jnsp" value="<?php echo $jnsp; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('hemodialisa/hemodialisa_tmp_laboratorium.php'); ?>
    </table>
	<table width="100%" >	
		<tr>
            <td colspan="7" align="right">
			<?php if($hemodialisa_final == ''){ ?>
			<a href="#" onclick="window.open('index.php?popup=hemodialisaformlaboratorium&idx=<?php echo $irja_id; ?>&grp=15&ord=<?php echo $jnsp; ?>&idxord=<?php echo $idxord; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?></td>	
        </tr>
	</table>	
</form>