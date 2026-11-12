<?php
if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_anamnesis.php');

$qry_pasien = 'SELECT t_irna.IRNA_ID, t_irna.NOMR, t_irna.ANAMNESIS,
				t_irna.PEMERIKSAAN_FISIK, t_irna.PEMERIKSAAN_PENUNJANG,
				t_irna.ALASAN_DIRAWAT,t_irna.THERAPI,t_irna.MONITORING,
				t_irna.EVALUASI,t_irna.DIET
				FROM t_irna
				WHERE t_irna.IRNA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien);
$dat_pasien = mysql_fetch_assoc($get_pasien);
$nomr = $dat_pasien['NOMR'];
$irna_id = $dat_pasien['IRNA_ID'];
$alasan_dirawat = $dat_pasien['ALASAN_DIRAWAT'];
$anamnesis = $dat_pasien['ANAMNESIS'];
$pemeriksaan_fisik = $dat_pasien['PEMERIKSAAN_FISIK'];
$pemeriksaan_penunjang = $dat_pasien['PEMERIKSAAN_PENUNJANG'];
$terapi = $dat_pasien['THERAPI'];
$hasil_konsul = $dat_pasien['MONITORING'];
$diet = $dat_pasien['DIET'];
$intruksi = $dat_pasien['EVALUASI'];
?>
<form name="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />		   
	<table border="0" align="center" style="position:static; " width="80%">
        <tr>
            <td valign="top">Alasan Masuk Dirawat</td>
            <td width="50%">
            	<textarea class="text_dt2" name="alasan_dirawat" id="alasan_dirawat" cols="80" rows="5"><?php echo $alasan_dirawat; ?></textarea>    
            </td>
        </tr>
		<tr>
            <td valign="top">Ringkasan Riwayat Penyakit</td>
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
            <td valign="top">Pemeriksaan Penunjang/ <br />Diagnostik Terpenting</td>
            <td>
                <textarea  class="text_dt2" name="pemeriksaan_penunjang" id="pemeriksaan_penunjang" cols="80" rows="5"><?php echo $pemeriksaan_penunjang; ?></textarea>
            </td>
        </tr>
		<tr>
            <td valign="top">Terapi/ Pengobatan Selama<br />Di RSK. Dr. Sitanala</td>
            <td>
                <textarea  class="text_dt2" name="terapi" id="terapi" cols="80" rows="5"><?php echo $terapi; ?></textarea>
            </td>
        </tr>
		<tr>
            <td valign="top">Hasil Konsultasi</td>
            <td>
                <textarea  class="text_dt2" name="hasil_konsul" id="hasil_konsul" cols="80" rows="5"><?php echo $hasil_konsul; ?></textarea>
            </td>
        </tr>
		<tr>
            <td valign="top">Diet</td>
            <td>
                <textarea  class="text_dt2" name="diet" id="diet" cols="80" rows="5"><?php echo $diet; ?></textarea>
            </td>
        </tr>
		<tr>
            <td valign="top">Intruksi/Anjuran dan <br />Edukasi (Folow up)</td>
            <td>
                <textarea  class="text_dt2" name="intruksi" id="intruksi" cols="80" rows="5"><?php echo $intruksi; ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr><td colspan="2" align="right" ><input type="submit" value="simpan" class="myButton1" /></td>
        </tr>
    </table>
</form>
