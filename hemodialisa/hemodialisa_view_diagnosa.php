<style>
html {
	background:url(image/bg_pattern1.jpg);

}
</style>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <table class="tableData" id="tfhover" >
    <?php include('hemodialisa/hemodialisa_tmp_diagnosa.php'); ?>  		
    </table>
</form>