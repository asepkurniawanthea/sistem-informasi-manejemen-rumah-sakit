<?php 
$idx = $_GET['idx'];
$irja_id = $_GET['idx'];

$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');

if (isset($_POST['idx']))
    include('klinik/klinik_save_tindakan.php');

if (isset($_GET['idk']))
    include('klinik/klinik_del_add_tindakan.php');
?>
<form name="formedit" method="post" action="<?php echo currentUrl(); ?>" onchange="false_kan();" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <table class="tableData" id="tfhover" >
	<?php if(currentModul() == 'klinik' or currentModul() == 'kusta' ){ ?>
        <?php include('klinik/klinik_tmp_tindakan.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="3">&nbsp;</td>
        </tr>
    </table>
	<table width="100%" >	
		<tr>
            <td colspan="7" align="right">
			<?php if($_SESSION['SES_SIMRS_UNIT_ID'] == '54'){
				$grp = '94';
			}else{
				$grp = '03';	
			} ?>
			<?php if($irja_final == ''){ ?>
			<a href="#" onclick="window.open('index.php?popup=klinikformtindakan&idx=<?php echo $idx; ?>&grp=<?php echo $grp; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?>
			</td>	
        </tr>
	</table>	
		<?php }else if(currentModul() == 'igd' or currentModul() == 'casemix'){ ?>
		<?php include('klinik/klinik_tmp_tindakan_igd.php'); ?>
		</table>
		<table width="100%">	
        <tr>
            <td colspan="9" align="right">
			<?php if($irja_final == ''){ ?>
			Tanggal&nbsp;&nbsp;
			<input type="text" name="tanggal" id="tgl_3" class="text_dt" size="10" value="<?php echo $tanggal; ?>" readonly="readonly" onblur="false_kan();" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar11')"/>
			<select name="jam" id="jam" style="width:50px;" class="text_dt" onblur="false_kan();" >
			<?php echo getJam($jam); ?>
			</select>
			<select name="menit" id="menit" style="width:50px;" class="text_dt" onblur="false_kan();" >
			<?php echo getMenit($menit); ?>
			</select>&nbsp;&nbsp;
			<a href="#" onclick="window.open('index.php?popup=klinikformtindakan&idx=<?php echo $idx; ?>&grp=10','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?>
			</td>	
        </tr>
		</table>
		<?php } ?>
</form>
<script type="text/javascript">
    function copykePAM(idx,nomor,unit){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=copytindakankepam&irja_id=' + idx + '&nomor=' + nomor + '&unit=' + unit,
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				alert(data);		
			}
		});
	}
</script>	