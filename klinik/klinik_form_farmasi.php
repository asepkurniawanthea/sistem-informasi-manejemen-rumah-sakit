<?php 
$irja_id = $_GET['idx'];
?>
    <table class="tableData" id="tfhover" >
	<?php if(currentModul() == 'klinik' or currentModul() == 'kusta' ){ ?>
        <?php include('klinik/klinik_tmp_farmasi.php'); ?>
		
		<?php }else if(currentModul() == 'igd' or currentModul() == 'casemix'){ ?>
		<?php include('klinik/klinik_tmp_farmasi_igd.php'); ?>
		<?php } ?>
	</table>	
</form>