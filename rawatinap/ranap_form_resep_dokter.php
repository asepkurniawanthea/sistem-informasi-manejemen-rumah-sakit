<?php 
$irna_id = $_GET['idx'];

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_resep.php');

if (isset($_GET['idr']))
    include('rawatinap/ranap_del_add_resep.php');
	
if (isset($_GET['idrc']))
    include('rawatinap/ranap_del_add_resep_racikan.php');	

if (isset($_GET['idu']))
    include('rawatinap/ranap_ubah_resep.php');

$irna_id = $_GET['idx'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
    <table class="tableData" id="tfhover" >
		<?php include('rawatinap/ranap_tmp_resep_dokter.php'); ?>
		<?php if($irna_final == ''){ ?>
		<table width="100%" >
		<tr>
            <td colspan="12" align="right">
			<a href="#" onclick="window.open('index.php?popup=ranapformresep&idx=<?php echo $irna_id; ?>&nomr=<?php echo $nomr; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=620')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="hidden" name="pegawai_id" id="pegawai_id" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" >
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			</td>	
        </tr>
		</table>
		<?php } ?>
</form>