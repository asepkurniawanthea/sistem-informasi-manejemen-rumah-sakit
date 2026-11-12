<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#jenis_keluar_masuk").autocomplete("index.php?autocomp=autocompranapkeluarmasuk",{width: 260});
    });
</script>
<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];

$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$keluar_masuk_id ='';
$jenis_keluar_masuk ='';
$catatan ='';
$perawat ='';
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="keluar_masuk_id" id="keluar_masuk_id" value="<?php echo $keluar_masuk_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('askep/askep_tmp_catatan_keluar_masuk.php'); ?>        
    </table>
</form>