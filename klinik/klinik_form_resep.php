<?php 
$irja_id = $_GET['idx'];

if (isset($_POST['irja_id']))
    include('klinik/klinik_save_resep.php');

if (isset($_GET['idr']))
    include('klinik/klinik_del_add_resep.php');
	
if (isset($_GET['idrc']))
    include('klinik/klinik_del_add_resep_racikan.php');	

if (isset($_GET['idu']))
    include('klinik/klinik_ubah_resep.php');
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <table class="tableData" id="tfhover" >
	<?php if(currentModul() == 'klinik' or currentModul() == 'kusta' ){ ?>
        <?php include('klinik/klinik_tmp_resep.php'); ?>
		</table>
		<table width="100%">
        <tr>
            <td colspan="9" align="right">
			<?php if($irja_final == '' and isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
			<a href="#" onclick="window.open('index.php?popup=klinikformresep&idx=<?php echo $irja_id; ?>&nomr=<?php echo $nomr; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=620')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?>
			</td>	
        </tr>
		</table>
		<?php }else if(currentModul() == 'igd' or currentModul() == 'casemix'){ ?>
		<?php include('klinik/klinik_tmp_resep_igd.php'); ?>
		<table width="100%" >
        <tr>
            <td colspan="12" align="right">
			<?php if($irja_final == '' and isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
			<input type="hidden" name="pegawai_id" value="<?php echo $_SESSION['SES_SIMRS_PEGAWAI_ID']; ?>" />	
			<a href="#" onclick="window.open('index.php?popup=klinikformresep&idx=<?php echo $irja_id; ?>&nomr=<?php echo $nomr; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=620')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?>
			</td>	
        </tr>
		    </table>
		<?php } ?>
</form>
<script type="text/javascript">
    function copykePAM(irja_id,nomor,unit){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=copyresepkepam&irja_id=' + irja_id + '&nomor=' + nomor + '&unit=' + unit,
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				alert(data);		
			}
		});
	}
	
	function copykeCPPT(irja_id,nomor,unit,nomr){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=copyresepkecppt&irja_id=' + irja_id + '&nomor=' + nomor + '&unit=' + unit + '&nomr=' + nomr,
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				alert(data);		
			}
		});
	}
</script>	