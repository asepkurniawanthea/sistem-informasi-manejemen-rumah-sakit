<?php
$irna_id = $_GET['idx'];

$sebab_kematian[1] = '';
$sebab_kematian[2] = '';
$sebab_kematian[3] = '';
$sebab_kematian[4] = '';

$mati_redupaksa[1] = '';
$mati_redupaksa[2] = '';
$mati_redupaksa[3] = '';

$kelahiran_mati[1] = '';
$kelahiran_mati[2] = '';

$persalinan_mati[1] = '';
$persalinan_mati[2] = '';

$operasi_mati[1] = '';
$operasi_mati[2] = '';

$qry_pasien = 'SELECT t_irna.SEBAB_KEMATIAN,t_irna.SEBAB_KEMATIAN_REDUPAKSA,t_irna.SEBAB_KEMATIAN_KELAHIRAN,
			t_irna.SEBAB_KEMATIAN_PERSALINAN,t_irna.SEBAB_KEMATIAN_OPERASI
			FROM t_irna
			WHERE t_irna.IRNA_ID = "' . $irna_id . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);

$f_sebab_mati = explode('|*|',$dat_pasien['SEBAB_KEMATIAN']);
if(count($f_sebab_mati) > 1){
	$sebab_kematian[1] = $f_sebab_mati[0];
	$sebab_kematian[2] = $f_sebab_mati[1];
	$sebab_kematian[3] = $f_sebab_mati[2];
	$sebab_kematian[4] = $f_sebab_mati[3];
}
$f_mati_redupaksa = explode('|*|',$dat_pasien['SEBAB_KEMATIAN_REDUPAKSA']);
if(count($f_mati_redupaksa) > 1){
	$mati_redupaksa[1] = $f_mati_redupaksa[0];
	$mati_redupaksa[2] = $f_mati_redupaksa[1];
	$mati_redupaksa[3] = $f_mati_redupaksa[2];
}
$f_kelahiran_mati = explode('|*|',$dat_pasien['SEBAB_KEMATIAN_KELAHIRAN']);
if(count($f_kelahiran_mati) > 1){
	$kelahiran_mati[1] = $f_kelahiran_mati[0];
	$kelahiran_mati[2] = $f_kelahiran_mati[1];
}
$f_persalinan_mati = explode('|*|',$dat_pasien['SEBAB_KEMATIAN_PERSALINAN']);
if(count($f_persalinan_mati) > 1){
	$persalinan_mati[1] = $f_persalinan_mati[0];
	$persalinan_mati[2] = $f_persalinan_mati[1];
}
$f_operasi_mati = explode('|*|',$dat_pasien['SEBAB_KEMATIAN_OPERASI']);
if(count($f_operasi_mati) > 1){
	$operasi_mati[1] = $f_operasi_mati[0];
	$operasi_mati[2] = $f_operasi_mati[1];
}

if (isset($_POST['irna_id']))
    include('rawatinap/ranap_save_sebab_kematian.php');

?>
<form name="form_1" id="form_1" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="2" scope="row">a.</td>
    <td rowspan="2" scope="row">&nbsp;</td>
    <td rowspan="2" scope="row" width="350">Penyakit atau keadaan yang langsung mengakibatkan kematian</td>
    <td>&nbsp;</td>
    <td rowspan="2" width="100"><textarea name="sebab_kematian_1" cols="25" class="text_dt6"><?php echo $sebab_kematian[1]; ?></textarea></td>
    <td colspan="2" rowspan="2">&nbsp;Penyakit tersebut dalam ruang adalah disebabkan oleh (atau akibat dari).</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="3" scope="row">b.</td>
    <td rowspan="3" scope="row">&nbsp;</td>
    <td rowspan="3" scope="row">Penyakit-penyakit (bila ada) yang menjadi lantaran timbulnya sebab kematian tersebut pada a, dengan menyebut penyakit yang menjadi poko pangkal terakhir. </td>
    <td>&nbsp;</td>
    <td rowspan="3"><textarea name="sebab_kematian_2" cols="25" class="text_dt6" ><?php echo $sebab_kematian[2]; ?></textarea></td>
    <td colspan="2" rowspan="3">&nbsp;Penyakit tersebut dalam ruang adalah disebabkan oleh (atau akibat dari). c. </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2" scope="row">&nbsp;</td>
    <td rowspan="2" scope="row">&nbsp;</td>
    <td rowspan="2" scope="row">Lamanya (kira-kira) :
    mulai sakit hingga meninggal dunia.</td>
    <td>&nbsp;</td>
    <td rowspan="2"><textarea name="sebab_kematian_3" cols="25" class="text_dt6" ><?php echo $sebab_kematian[3]; ?></textarea></td>
    <td colspan="2" rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">c.</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Penyakit-penyakit lain yang berarti dan mempengaruhi pula kematian itu, tetapi tidak ada hubungannya dengan penyakit-penyakit a,b,c </td>
    <td>&nbsp;</td>
    <td><textarea name="sebab_kematian_4" cols="25" class="text_dt6" ><?php echo $sebab_kematian[4]; ?></textarea></td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td colspan="2" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td colspan="2" scope="row">Keterangan Khusus Untuk : </td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
    <tr>
    <td scope="row">&nbsp;</td>
    <td colspan="2" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Mati Karena Redupaksa</strong> </td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Macam Redupaksa </td>
    <td>&nbsp;</td>
	<td colspan="3"><input type="radio" name="mati_redupaksa_1" value="1" <?php if($mati_redupaksa[1] == '1') echo 'checked="checked"'; ?> />Bunuh Diri 
					<input type="radio" name="mati_redupaksa_1" value="2" <?php if($mati_redupaksa[1] == '2') echo 'checked="checked"'; ?>/>Pembunuhan 
					<input type="radio" name="mati_redupaksa_1" value="3" <?php if($mati_redupaksa[1] == '3') echo 'checked="checked"'; ?>/>Kecelakaan </td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Cara Kejadian Redupaksa </td>
    <td>&nbsp;</td>
	<td><textarea name="mati_redupaksa_2" cols="25" class="text_dt6"><?php echo $mati_redupaksa[2]; ?></textarea></td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Sifat Jelas (Kerusakan Tubuh) </td>
    <td>&nbsp;</td>
	<td><textarea name="mati_redupaksa_3" cols="25" class="text_dt6"><?php echo $mati_redupaksa[3]; ?></textarea></td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Kelahiran Mati </strong></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Ini Janin Lahir Mati </td>
    <td>&nbsp;</td>
	<td><input type="radio" name="kelahiran_mati_1" value="1" <?php if($kelahiran_mati[1] == '1') echo 'checked="checked"'; ?> />Ya 
					<input type="radio" name="kelahiran_mati_1" value="2" <?php if($kelahiran_mati[1] == '2') echo 'checked="checked"'; ?> />Tidak </td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Sebab Kelahiran Mati </td>
    <td>&nbsp;</td>
	<td><textarea name="kelahiran_mati_2" cols="25" class="text_dt6"><?php echo $kelahiran_mati[2]; ?></textarea></td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Persalinan, Kehamilan</strong> </td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Ini Peristiwa Persalinan </td>
    <td>&nbsp;</td>
	<td><input type="radio" name="persalinan_mati_1" value="1" <?php if($persalinan_mati[1] == '1') echo 'checked="checked"'; ?> />Ya 
					<input type="radio" name="persalinan_mati_1" value="2" <?php if($persalinan_mati[1] == '2') echo 'checked="checked"'; ?> />Tidak </td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Ini Peristiwa Kehamilan </td>
    <td>&nbsp;</td>
	<td><input type="radio" name="persalinan_mati_2" value="1" <?php if($persalinan_mati[2] == '1') echo 'checked="checked"'; ?> />Ya 
					<input type="radio" name="persalinan_mati_2" value="2" <?php if($persalinan_mati[2] == '2') echo 'checked="checked"'; ?> />Tidak</td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row"><strong>Operasi</strong></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Apakah Disini Dilakukan Operasi </td>
    <td>&nbsp;</td>
	<td><input type="radio" name="operasi_mati_1" value="1" <?php if($operasi_mati[2] == '1') echo 'checked="checked"'; ?> />Ya 
					<input type="radio" name="operasi_mati_1" value="2" <?php if($operasi_mati[2] == '2') echo 'checked="checked"'; ?> />Tidak</td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td scope="row">&nbsp;</td>
    <td scope="row">&nbsp;</td>
    <td scope="row">Jenis Operasi </td>
    <td>&nbsp;</td>
	<td><textarea name="operasi_mati_2" cols="25" class="text_dt6"><?php echo $operasi_mati[2]; ?></textarea></td>
    
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" scope="row">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td align="right"><input type="button" value="simpan"class="myButton1" onclick="simpan();" />
	<input type="hidden" name="irna_id" value="<?php echo $irna_id; ?>"  /></td>
	<td width="200px">&nbsp;</td>
  </tr>
</table>
</form>
<script>
function simpan(){
	_haschange = false;
	$('#form_1').submit();
}	
</script>