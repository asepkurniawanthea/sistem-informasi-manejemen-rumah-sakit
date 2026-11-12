<?php 
$irja_id = $_GET['idx'];

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_resep.php');

if (isset($_GET['idr']))
    include('hemodialisa/hemodialisa_del_add_resep.php');
	
if (isset($_GET['idrc']))
    include('hemodialisa/hemodialisa_del_add_resep_racikan.php');	

?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('hemodialisa/hemodialisa_tmp_resep.php'); ?>
		</table>
		<table width="100%">
        <tr>
            <td colspan="9" align="right">
			<?php if($hemodialisa_final == ''){ ?>
			<a href="#" onclick="window.open('index.php?popup=hemodialisaformresep&idx=<?php echo $irja_id; ?>&nomr=<?php echo $nomr; ?>&ord=<?php echo $jns_order; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=620')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?></td>	
        </tr>
		</table>
</form>