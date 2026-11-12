<?php
$anamnesis = '';
$pemeriksaan_fisik = '';
$pemeriksaan_penunjang = '';

$qry_pasien = 'SELECT t_irna.IRNA_ID, t_irna.NOMR, t_irna.ANAMNESIS,
				t_irna.PEMERIKSAAN_FISIK, t_irna.PEMERIKSAAN_PENUNJANG
				FROM t_irna
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irna_id = $dat_pasien['IRNA_ID'];
$anamnesis = $dat_pasien['ANAMNESIS'];
$pemeriksaan_fisik = $dat_pasien['PEMERIKSAAN_FISIK'];
$pemeriksaan_penunjang = $dat_pasien['PEMERIKSAAN_PENUNJANG'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />		   
	<table border="0" align="center" style="position:static; " width="80%">
        <tr>
            <td valign="top">Anamnesis</td>
            <td width="50%">
            	<textarea class="text_dt2" name="anamnesis" id="anamnesis" cols="80" rows="5"><?php echo $anamnesis; ?></textarea>    
            </td>
        </tr>
        <tr>
            <td valign="top">Pemeriksaan Fisik</td>
            <td >
                <textarea  class="text_dt2" name="pemeriksaan_fisik" id="pemeriksaan_fisik" cols="80" rows="5"><?php echo $pemeriksaan_fisik; ?></textarea>
            </td>
        </tr>
        <tr>
            <td valign="top">Pemeriksaan Penunjang</td>
            <td>
                <textarea  class="text_dt2" name="pemeriksaan_penunjang" id="pemeriksaan_penunjang" cols="80" rows="5"><?php echo $pemeriksaan_penunjang; ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr><td colspan="2" align="right" >&nbsp;</td>
        </tr>
    </table>
</form>