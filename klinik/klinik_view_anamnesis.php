<?php
$qry_pasien = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.ANAMNESIS,
				t_irja.PEMERIKSAAN_FISIK, t_irja.PEMERIKSAAN_PENUNJANG,t_irja.STATUS_LOKALIS
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irja_id = $dat_pasien['IRJA_ID'];
$anamnesis = $dat_pasien['ANAMNESIS'];
$pemeriksaan_fisik = $dat_pasien['PEMERIKSAAN_FISIK'];
$pemeriksaan_penunjang = $dat_pasien['PEMERIKSAAN_PENUNJANG'];
$status_lokalis = $dat_pasien['STATUS_LOKALIS'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />		   
	<table border="0" align="center" style="position:static; " width="80%">
        <tr>
            <td valign="top">Anamnesis</td>
            <td width="85%">
            	<?php include('klinik/klinik_form_anamnesis_detail.php'); ?>
            </td>
        </tr>
		<tr>
            <td valign="top">Pemeriksaan Fisik</td>
            <td >
                <?php include('klinik/klinik_form_pemeriksaan_fisik.php'); ?>
            </td>
        </tr>
		<tr>
            <td valign="top">Status Lokalis</td>
            <td>
                <textarea  class="text_dt2" name="status_lokalis" id="status_lokalis" cols="80" rows="5"><?php echo $status_lokalis; ?></textarea>
            </td>
        </tr>
        <tr>
            <td valign="top">Pemeriksaan Penunjang</td>
            <td>
                <textarea  class="text_dt2" name="pemeriksaan_penunjang" id="pemeriksaan_penunjang" cols="80" rows="5"><?php echo $pemeriksaan_penunjang; ?></textarea>
            </td>
        </tr>
    </table>
</form>