<?php 
$irna_id = $_GET['idx'];

if (isset($_POST['irna_id']))
    include('askep/askep_save_diagnosa.php');

if (isset($_GET['idd']))
    include('askep/askep_del_add_diagnosa.php');

$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('askep/askep_tmp_diagnosa.php'); ?>
		<table width="100%" >
        <tr>
            <td colspan="12" align="right">&nbsp;
			<a href="#" onclick="window.open('index.php?popup=askepformdiagnosa&idx=<?php echo $irna_id; ?>&nomr=<?php echo $nomr; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=850,height=500')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
		    </table>
</form>