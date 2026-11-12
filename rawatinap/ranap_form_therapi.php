<?php
$irna_id = $_GET['idx'];
if($status_anamnesis == '1' && $status_diagnosa == '1'){

$therapi = '';
$monitoring = '';
$evaluasi = '';

$qry_pasien = 'SELECT t_irna.IRNA_ID, t_irna.NOMR, t_irna.THERAPI,
				t_irna.MONITORING, t_irna.EVALUASI
				FROM t_irna
				WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irna_id = $dat_pasien['IRNA_ID'];
$therapi = $dat_pasien['THERAPI'];
$monitoring = $dat_pasien['MONITORING'];
$evaluasi = $dat_pasien['EVALUASI'];

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_therapi.php');
?>
<form name="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />
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
        <tr><td colspan="4" align="right">
           <input type="submit" name="simpan" value="simpan" class="myButton1" /></td>
        </tr>
    </table>
</form>
<?php } ?>