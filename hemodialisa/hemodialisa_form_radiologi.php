<?php 
$irja_id = $_GET['idx'];
$jns_order = $_GET['ord'];

if($status_anamnesis == '1' && $status_diagnosa == '1'){

if (isset($_POST['irja_id']))
    include('hemodialisa/hemodialisa_save_radiologi.php');

if (isset($_GET['idk']))
    include('hemodialisa/hemodialisa_del_add_radiologi.php');

?>
<script type="text/javascript" src="script/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="script/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
	<input type="hidden" name="idxord" id="idxord" value="<?php echo $idxord; ?>" />
	<input type="hidden" name="jnsp" id="jnsp" value="<?php echo $jnsp; ?>" />
	<input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table class="tableData" id="tfhover" >
	  <?php include('hemodialisa/hemodialisa_tmp_radiologi.php'); ?>
        <tr>
            <td colspan="5" align="right">Total Rp.&nbsp;&nbsp;<?php echo currFormat($total); ?> </td>
			<td colspan="5">&nbsp;</td>
        </tr>
    </table>
	<table width="100%" >	
		<tr>
            <td colspan="7" align="right">
			<a href="#" onclick="window.open('index.php?popup=hemodialisaformradiologi&idx=<?php echo $irja_id; ?>&grp=27&ord=<?php echo $jnsp; ?>&idxord=<?php echo $idxord; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=650,height=700')" ><input type="button" value="tambah" class="myButton1" /></a>
			<input type="hidden" name="jenis_bayar_id" value="<?php echo $jenis_bayar_id; ?>" />
			<input type="submit" name="simpan" value="simpan" class="myButton1" /></td>	
        </tr>
	</table>	
</form>
<?php }else{ ?>
 <script language="JavaScript" >
    window.location = "index.php?link=<?php echo md5('hemodialisaformpasienperiksa'); ?>&smn=dgns&idx=<?php echo $irja_id; ?>&ord=<?php echo $jns_order; ?>";
 </script>
<?php } ?>