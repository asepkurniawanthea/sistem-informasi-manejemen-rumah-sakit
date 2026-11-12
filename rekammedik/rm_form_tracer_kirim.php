<?php
if(isset($_GET['idx']) and isset($_GET['nomr'])){

$irja_id = $_GET['idx'];
$nomr = $_GET['nomr'];
$keterangan = '';

if (isset($_POST['irja_id']))
    include('rekammedik/rm_save_tracer_kirim.php');
?>
<form name="tracerkirim" method="post" action="<?php echo currentUrl(); ?>" >
<fieldset style="margin-top:5px; border-radius:5px; height:auto; margin:0; padding:0; padding-bottom:5px; stroke:red; ">
<legend style="font-weight:bold; height:25px; width:auto; padding-left:15px; margin-top:5px; margin-left:25px; padding-right:15px; text-align:center; border:-radius:5px; border:1px solid black; box-shadow:1px 1px 1px 1px rgba(0,0,0,2);">Kirim RM
</legend>		
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <table class="tableform">
        <tr><th colspan="3">Nomor MR : <?php echo formatNoMR(sprintf('%06d',$nomr)); ?></th></tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr><td>Keterangan</td><td><textarea name="keterangan" id="keterangan" style="width:328px;" rows="5" class="text_dt2" ><?php echo $keterangan; ?></textarea></td></tr>
        <tr><td colspan="3">&nbsp;</td></tr>
        <tr><td colspan="3" align="right"><input type="submit" value="simpan" class="myButton1" /></td></tr>
    </table>
</fieldset>	
</form>	
<?php } ?>