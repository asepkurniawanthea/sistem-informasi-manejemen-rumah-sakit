<?php 
$idx = $_GET['idx'];

if (isset($_POST['idx']))
    include('hemodialisa/hemodialisa_save_tindakan.php');

if (isset($_GET['idk']))
    include('hemodialisa/hemodialisa_del_add_tindakan.php');
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />
	<input type="hidden" name="jns_order" id="jns_order" value="<?php echo $jns_order; ?>" />
    <table class="tableData" id="tfhover" >
	<?php include('hemodialisa/hemodialisa_tmp_tindakan.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="3">&nbsp;</td>
        </tr>
    </table>
	<table width="100%" >	
		<tr>
            <td colspan="7" align="right">
			<?php if($hemodialisa_final == ''){ ?>
			<a href="#" onclick="window.open('index.php?popup=hemodialisaformtindakan&idx=<?php echo $idx; ?>&grp=95&ord=<?php echo $jns_order; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" />
			<?php } ?></td>	
        </tr>
	</table>	
</form>
<script type="text/javascript">
    function copykePAM(idx,nomor,unit){
		$.ajax({
			type: 'POST',
			url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=hmdcopytindakankepam&irja_id=' + idx + '&nomor=' + nomor + '&unit=' + unit,
			data: { idx : 'idx'},
			cache: false,
			success: function(data) {
				alert(data);		
			}
		});
	}
</script>	