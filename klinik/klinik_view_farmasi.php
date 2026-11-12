<?php 
$irja_id = $_GET['idx'];
?>
    <table class="tableData" id="tfhover" >
	<?php if($unit_id != '9'){ ?>
        <?php include('klinik/klinik_tmp_farmasi.php'); ?>
		</table>
		<?php }else{ ?>
		<?php include('klinik/klinik_tmp_farmasi_igd.php'); ?>
		</table>
		<?php } ?>
</form>