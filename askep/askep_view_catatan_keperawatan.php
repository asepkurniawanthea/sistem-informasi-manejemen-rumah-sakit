<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<?php 
$irna_id = $_GET['idx'];
$catatan_keperawatan_id = '';
$tanggal = date('d/m/Y');
$jam = date('H');
$menit = date('i');
$soap = '';
$perawat = '';
?>
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="catatan_keperawatan_id" id="catatan_keperawatan_id" value="<?php echo $catatan_keperawatan_id; ?>" />
    <table class="tableData" id="tfhover" >
        <?php include('askep/askep_tmp_catatan_keperawatan.php'); ?>        
    </table>
</form>