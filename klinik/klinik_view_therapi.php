<?php
$irja_id = $_GET['idx'];
$qry_pasien = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.THERAPI,
				t_irja.MONITORING, t_irja.EVALUASI
				FROM t_irja
				WHERE t_irja.IRJA_ID = "' . $irja_id . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irja_id = $dat_pasien['IRJA_ID'];
$therapi = $dat_pasien['THERAPI'];
$monitoring = $dat_pasien['MONITORING'];
$evaluasi = $dat_pasien['EVALUASI'];
?>
<form name="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
    <table border="0">
        <tr>
            <td valign="top">Therapi</td>
            <td colspan="3">
                <textarea name="therapi" id="therapi" cols="80" rows="5" class="text_dt2"><?php echo $therapi; ?></textarea>
            </td>
        </tr>
        <tr>
            <td valign="top">Monitoring</td>
            <td colspan="3">
                <textarea name="monitoring" id="monitoring" cols="80" rows="5" class="text_dt2"><?php echo $monitoring; ?></textarea>
            </td>
        </tr>
        <tr>
            <td valign="top">Evaluasi</td>
            <td colspan="3">
                <textarea name="evaluasi" id="evaluasi" cols="80" rows="5" class="text_dt2"><?php echo $evaluasi; ?></textarea>
            </td>
        </tr>
     </table>
</form>