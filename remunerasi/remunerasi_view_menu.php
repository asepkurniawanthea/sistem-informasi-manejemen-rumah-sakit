<?php
$tgl_1 = date('d/m/Y');
$tgl_2 = date('d/m/Y');

if(isset($_POST['cari'])) {
	$tgl_1 = $_POST['tgl_1'];
	$tgl_2 = $_POST['tgl_2'];	
}
?>
<style>
.list_isi{
	height:550px;
}
</style>
<form name="search" method="post" action="">
<div style="padding:5px; margin-bottom:25px;">
	<div style="float:left; padding-top:25px; margin-left:15px; margin-right:15px;">Periode :</div>
	<div style="float:left; padding-top:25px; margin-right:15px;">
		<input type="text" name="tgl_1" id="tgl_1" value="<?php echo $tgl_1; ?>" size="15" class="text_dt" />
                <img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar6')"/>
	</div>
	<div style="float:left; padding-top:25px; margin-right:15px;">s/d</div>
	<div style="float:left; padding-top:25px; margin-right:15px;">
		<input type="text" name="tgl_2" id="tgl_2" class="text_dt" size="10" value="<?php echo $tgl_2; ?>" readonly="readonly" />
		<img align="top" src="image/date.png" border="0"  onclick="showCal('Calendar7')"/>
	</div>
	<div style="float:left; padding-top:25px; margin-right:15px;"><input type="submit" value="cari" name="cari" class="myButton1" /></div>	
</div>
</form>
<br>
<br>
<?php
$date1 = DateTime::createFromFormat('d/m/Y', $tgl_1);
$date2 = DateTime::createFromFormat('d/m/Y', $tgl_2);
$sql='SELECT * FROM t_irja_tarif 	 
	WHERE TGL_TARIF BETWEEN "' . $date1->format('Y-m-d') . '" AND "' . $date2->format('Y-m-d') . '"
	AND t_irja_tarif.PEGAWAI_ID IS NOT NULL'; 
/*
$sql='SELECT * FROM t_remon 
LEFT JOIN m_pegawai on (m_pegawai.PEGAWAI_ID=t_remon.PEGAWAI_ID)
WHERE t_remon.TGL_INPUT BETWEEN "' . $date1->format('Y-m-d') . '" AND "' . $date2->format('Y-m-d') . '"';
*/
$extparam = '&date1=' . $date1->format('Y-m-d') . '&date2=' . $date2->format('Y-m-d');

include('remunerasi/remunerasi_list_menu.php');
?>

