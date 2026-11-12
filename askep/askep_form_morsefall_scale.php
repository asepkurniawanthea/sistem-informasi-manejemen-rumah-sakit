<?php
$irna_id = $_GET['idx'];

if (isset($_POST['simpan']))  	
	include('askep/askep_save_morse_fall_scare.php'); 

$sql_jatuh = 'SELECT t_irna_askep_morse_fall_scale.MORSE_FALL_SCALE_ID,
			  t_irna_askep_morse_fall_scale.RIWAYAT_JATUH,
			  t_irna_askep_morse_fall_scale.DIAGNOSIS_SEKUNDER,
			  t_irna_askep_morse_fall_scale.ALAT_BANTU,
			  t_irna_askep_morse_fall_scale.TERPASANG_INFUS,
			  t_irna_askep_morse_fall_scale.GAYA_BERJALAN,
			  t_irna_askep_morse_fall_scale.STATUS_MENTAL,
			  t_irna_askep_morse_fall_scale.PERAWAT
			FROM t_irna_askep_morse_fall_scale
			WHERE t_irna_askep_morse_fall_scale.MORSE_FALL_SCALE_ID = "' . $_GET['idx'] . '"';
$get_jatuh = mysql_query($sql_jatuh) or die(mysql_error());
$dat_jatuh = mysql_fetch_array($get_jatuh);

$morse_fall_scale_id = $dat_jatuh['MORSE_FALL_SCALE_ID'];
$riwayat_jatuh = explode('|',$dat_jatuh['RIWAYAT_JATUH']);
$diagnosis_sekunder = explode('|',$dat_jatuh['DIAGNOSIS_SEKUNDER']);
$alat_bantu = explode('|',$dat_jatuh['ALAT_BANTU']);
$terpasang_infus = explode('|',$dat_jatuh['TERPASANG_INFUS']);
$gaya_berjalan = explode('|',$dat_jatuh['GAYA_BERJALAN']);
$status_mental = explode('|',$dat_jatuh['STATUS_MENTAL']);
$perawat = explode('|',$dat_jatuh['PERAWAT']);
?>
<form name="formontorio" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="morse_fall_scale_id" value="<?php echo $morse_fall_scale_id; ?>" />
	<table align="center" width="80%" class="tableData">
		<tr style="height:30px; background-color:#666666; color:#FFFFFF; ">
			<th>Faktor Risiko</th>
			<th>Skala</th>		
			<th width="60px">Point</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		    <th>Skor</th>
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">RIWAYAT JATUH</td>			
			<td>Ya</td>
			<td align="center">25</td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_1" value="25" <?php if(isset($riwayat_jatuh[0]) and $riwayat_jatuh[0] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_2" value="25" <?php if(isset($riwayat_jatuh[1]) and $riwayat_jatuh[1] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_3" value="25" <?php if(isset($riwayat_jatuh[2]) and $riwayat_jatuh[2] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_4" value="25" <?php if(isset($riwayat_jatuh[3]) and $riwayat_jatuh[3] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_5" value="25" <?php if(isset($riwayat_jatuh[4]) and $riwayat_jatuh[4] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_6" value="25" <?php if(isset($riwayat_jatuh[5]) and $riwayat_jatuh[5] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_7" value="25" <?php if(isset($riwayat_jatuh[6]) and $riwayat_jatuh[6] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_8" value="25" <?php if(isset($riwayat_jatuh[7]) and $riwayat_jatuh[7] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_9" value="25" <?php if(isset($riwayat_jatuh[8]) and $riwayat_jatuh[8] == '25') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_10" value="25" <?php if(isset($riwayat_jatuh[9]) and $riwayat_jatuh[9] == '25') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>Tidak</td>		
			<td align="center">0</td>	
		    <td align="center"><input type="radio" name="riwayat_jatuh_1" value="0" <?php if(isset($riwayat_jatuh[0]) and $riwayat_jatuh[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_2" value="0" <?php if(isset($riwayat_jatuh[1]) and $riwayat_jatuh[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_3" value="0" <?php if(isset($riwayat_jatuh[2]) and $riwayat_jatuh[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_4" value="0" <?php if(isset($riwayat_jatuh[3]) and $riwayat_jatuh[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_5" value="0" <?php if(isset($riwayat_jatuh[4]) and $riwayat_jatuh[4] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_6" value="0" <?php if(isset($riwayat_jatuh[5]) and $riwayat_jatuh[5] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_7" value="0" <?php if(isset($riwayat_jatuh[6]) and $riwayat_jatuh[6] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_8" value="0" <?php if(isset($riwayat_jatuh[7]) and $riwayat_jatuh[7] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_9" value="0" <?php if(isset($riwayat_jatuh[8]) and $riwayat_jatuh[8] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="riwayat_jatuh_10" value="0" <?php if(isset($riwayat_jatuh[9]) and $riwayat_jatuh[9] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">DIAGNOSIS SEKUNDER ( <u>></u> 2 DIAGNOSISIS MEDIS)</td>			
			<td>Ya</td>
			<td align="center">15</td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_1" value="15" <?php if(isset($diagnosis_sekunder[0]) and $diagnosis_sekunder[0] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_2" value="15" <?php if(isset($diagnosis_sekunder[1]) and $diagnosis_sekunder[1] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_3" value="15" <?php if(isset($diagnosis_sekunder[2]) and $diagnosis_sekunder[2] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_4" value="15" <?php if(isset($diagnosis_sekunder[3]) and $diagnosis_sekunder[3] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_5" value="15" <?php if(isset($diagnosis_sekunder[4]) and $diagnosis_sekunder[4] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_6" value="15" <?php if(isset($diagnosis_sekunder[5]) and $diagnosis_sekunder[5] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_7" value="15" <?php if(isset($diagnosis_sekunder[6]) and $diagnosis_sekunder[6] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_8" value="15" <?php if(isset($diagnosis_sekunder[7]) and $diagnosis_sekunder[7] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_9" value="15" <?php if(isset($diagnosis_sekunder[8]) and $diagnosis_sekunder[8] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_10" value="15" <?php if(isset($diagnosis_sekunder[9]) and $diagnosis_sekunder[9] == '15') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>Tidak</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_1" value="0" <?php if(isset($diagnosis_sekunder[0]) and $diagnosis_sekunder[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_2" value="0" <?php if(isset($diagnosis_sekunder[1]) and $diagnosis_sekunder[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_3" value="0" <?php if(isset($diagnosis_sekunder[2]) and $diagnosis_sekunder[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_4" value="0" <?php if(isset($diagnosis_sekunder[3]) and $diagnosis_sekunder[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_5" value="0" <?php if(isset($diagnosis_sekunder[4]) and $diagnosis_sekunder[4] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_6" value="0" <?php if(isset($diagnosis_sekunder[5]) and $diagnosis_sekunder[5] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_7" value="0" <?php if(isset($diagnosis_sekunder[6]) and $diagnosis_sekunder[6] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_8" value="0" <?php if(isset($diagnosis_sekunder[7]) and $diagnosis_sekunder[7] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_9" value="0" <?php if(isset($diagnosis_sekunder[8]) and $diagnosis_sekunder[8] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="diagnosis_sekunder_10" value="0" <?php if(isset($diagnosis_sekunder[9]) and $diagnosis_sekunder[9] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">ALAT BANTU</td>
			<td>Berpegangan pada perabot</td>
			<td align="center">30</td>
		    <td align="center"><input type="radio" name="alat_bantu_1" value="30" <?php if(isset($alat_bantu[0]) and $alat_bantu[0] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_2" value="30" <?php if(isset($alat_bantu[1]) and $alat_bantu[1] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_3" value="30" <?php if(isset($alat_bantu[2]) and $alat_bantu[2] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_4" value="30" <?php if(isset($alat_bantu[3]) and $alat_bantu[3] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_5" value="30" <?php if(isset($alat_bantu[4]) and $alat_bantu[4] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_6" value="30" <?php if(isset($alat_bantu[5]) and $alat_bantu[5] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_7" value="30" <?php if(isset($alat_bantu[6]) and $alat_bantu[6] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_8" value="30" <?php if(isset($alat_bantu[7]) and $alat_bantu[7] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_9" value="30" <?php if(isset($alat_bantu[8]) and $alat_bantu[8] == '30') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_10" value="30" <?php if(isset($alat_bantu[9]) and $alat_bantu[9] == '30') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>Tongkat / alat penopang</td>			
			<td align="center">15</td>
		    <td align="center"><input type="radio" name="alat_bantu_1" value="15" <?php if(isset($alat_bantu[0]) and $alat_bantu[0] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_2" value="15" <?php if(isset($alat_bantu[1]) and $alat_bantu[1] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_3" value="15" <?php if(isset($alat_bantu[2]) and $alat_bantu[2] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_4" value="15" <?php if(isset($alat_bantu[3]) and $alat_bantu[3] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_5" value="15" <?php if(isset($alat_bantu[4]) and $alat_bantu[4] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_6" value="15" <?php if(isset($alat_bantu[5]) and $alat_bantu[5] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_7" value="15" <?php if(isset($alat_bantu[6]) and $alat_bantu[6] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_8" value="15" <?php if(isset($alat_bantu[7]) and $alat_bantu[7] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_9" value="15" <?php if(isset($alat_bantu[8]) and $alat_bantu[8] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_10" value="15" <?php if(isset($alat_bantu[9]) and $alat_bantu[9] == '15') echo 'checked="checked"'; ?> /></td>
		</tr>		
		<tr>			
			<td>Tidak ada / kursi roda / perawat / tirah baring</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="alat_bantu_1" value="0" <?php if(isset($alat_bantu[0]) and $alat_bantu[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_2" value="0" <?php if(isset($alat_bantu[1]) and $alat_bantu[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_3" value="0" <?php if(isset($alat_bantu[2]) and $alat_bantu[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_4" value="0" <?php if(isset($alat_bantu[3]) and $alat_bantu[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_5" value="0" <?php if(isset($alat_bantu[4]) and $alat_bantu[4] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_6" value="0" <?php if(isset($alat_bantu[5]) and $alat_bantu[5] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_7" value="0" <?php if(isset($alat_bantu[6]) and $alat_bantu[6] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_8" value="0" <?php if(isset($alat_bantu[7]) and $alat_bantu[7] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_9" value="0" <?php if(isset($alat_bantu[8]) and $alat_bantu[8] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="alat_bantu_10" value="0" <?php if(isset($alat_bantu[9]) and $alat_bantu[9] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">TERPASANG INFUS</td>
			<td>Ya</td>
			<td align="center">20</td>
		    <td align="center"><input type="radio" name="terpasang_infus_1" value="20" <?php if(isset($terpasang_infus[0]) and $terpasang_infus[0] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_2" value="20" <?php if(isset($terpasang_infus[1]) and $terpasang_infus[1] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_3" value="20" <?php if(isset($terpasang_infus[2]) and $terpasang_infus[2] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_4" value="20" <?php if(isset($terpasang_infus[3]) and $terpasang_infus[3] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_5" value="20" <?php if(isset($terpasang_infus[4]) and $terpasang_infus[4] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_6" value="20" <?php if(isset($terpasang_infus[5]) and $terpasang_infus[5] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_7" value="20" <?php if(isset($terpasang_infus[6]) and $terpasang_infus[6] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_8" value="20" <?php if(isset($terpasang_infus[7]) and $terpasang_infus[7] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_9" value="20" <?php if(isset($terpasang_infus[8]) and $terpasang_infus[8] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_10" value="20" <?php if(isset($terpasang_infus[9]) and $terpasang_infus[9] == '20') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>Tidak</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="terpasang_infus_1" value="0" <?php if(isset($terpasang_infus[0]) and $terpasang_infus[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_2" value="0" <?php if(isset($terpasang_infus[1]) and $terpasang_infus[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_3" value="0" <?php if(isset($terpasang_infus[2]) and $terpasang_infus[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_4" value="0" <?php if(isset($terpasang_infus[3]) and $terpasang_infus[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_5" value="0" <?php if(isset($terpasang_infus[4]) and $terpasang_infus[4] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_6" value="0" <?php if(isset($terpasang_infus[5]) and $terpasang_infus[5] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_7" value="0" <?php if(isset($terpasang_infus[6]) and $terpasang_infus[6] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_8" value="0" <?php if(isset($terpasang_infus[7]) and $terpasang_infus[7] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_9" value="0" <?php if(isset($terpasang_infus[8]) and $terpasang_infus[8] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="terpasang_infus_10" value="0" <?php if(isset($terpasang_infus[9]) and $terpasang_infus[9] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>		
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">GAYA BERJALAN</td>
			<td>Terganggu</td>
			<td align="center">20</td>
		    <td align="center"><input type="radio" name="gaya_berjalan_1" value="20" <?php if(isset($gaya_berjalan[0]) and $gaya_berjalan[0] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_2" value="20" <?php if(isset($gaya_berjalan[1]) and $gaya_berjalan[1] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_3" value="20" <?php if(isset($gaya_berjalan[2]) and $gaya_berjalan[2] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_4" value="20" <?php if(isset($gaya_berjalan[3]) and $gaya_berjalan[3] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_5" value="20" <?php if(isset($gaya_berjalan[4]) and $gaya_berjalan[4] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_6" value="20" <?php if(isset($gaya_berjalan[5]) and $gaya_berjalan[5] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_7" value="20" <?php if(isset($gaya_berjalan[6]) and $gaya_berjalan[6] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_8" value="20" <?php if(isset($gaya_berjalan[7]) and $gaya_berjalan[7] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_9" value="20" <?php if(isset($gaya_berjalan[8]) and $gaya_berjalan[8] == '20') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_10" value="20" <?php if(isset($gaya_berjalan[9]) and $gaya_berjalan[9] == '20') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>Lemah</td>			
			<td align="center">10</td>
		    <td align="center"><input type="radio" name="gaya_berjalan_1" value="10" <?php if(isset($gaya_berjalan[0]) and $gaya_berjalan[0] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_2" value="10" <?php if(isset($gaya_berjalan[1]) and $gaya_berjalan[1] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_3" value="10" <?php if(isset($gaya_berjalan[2]) and $gaya_berjalan[2] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_4" value="10" <?php if(isset($gaya_berjalan[3]) and $gaya_berjalan[3] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_5" value="10" <?php if(isset($gaya_berjalan[4]) and $gaya_berjalan[4] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_6" value="10" <?php if(isset($gaya_berjalan[5]) and $gaya_berjalan[5] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_7" value="10" <?php if(isset($gaya_berjalan[6]) and $gaya_berjalan[6] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_8" value="10" <?php if(isset($gaya_berjalan[7]) and $gaya_berjalan[7] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_9" value="10" <?php if(isset($gaya_berjalan[8]) and $gaya_berjalan[8] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_10" value="10" <?php if(isset($gaya_berjalan[9]) and $gaya_berjalan[9] == '10') echo 'checked="checked"'; ?> /></td>
		</tr>
		</tr>		
		<tr>			
			<td>Normal / Tirah baring / Immobilisasi</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="gaya_berjalan_1" value="0" <?php if(isset($gaya_berjalan[0]) and $gaya_berjalan[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_2" value="0" <?php if(isset($gaya_berjalan[1]) and $gaya_berjalan[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_3" value="0" <?php if(isset($gaya_berjalan[2]) and $gaya_berjalan[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_4" value="0" <?php if(isset($gaya_berjalan[3]) and $gaya_berjalan[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_5" value="0" <?php if(isset($gaya_berjalan[4]) and $gaya_berjalan[4] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_6" value="0" <?php if(isset($gaya_berjalan[5]) and $gaya_berjalan[5] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_7" value="0" <?php if(isset($gaya_berjalan[6]) and $gaya_berjalan[6] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_8" value="0" <?php if(isset($gaya_berjalan[7]) and $gaya_berjalan[7] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_9" value="0" <?php if(isset($gaya_berjalan[8]) and $gaya_berjalan[8] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="gaya_berjalan_10" value="0" <?php if(isset($gaya_berjalan[9]) and $gaya_berjalan[9] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">STATUS MENTAL</td>
			<td>Sering lupa akan keterbatasan yang dimiliki</td>
			<td align="center">15</td>
		    <td align="center"><input type="radio" name="status_mental_1" value="15" <?php if(isset($status_mental[0]) and $status_mental[0] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_2" value="15" <?php if(isset($status_mental[1]) and $status_mental[1] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_3" value="15" <?php if(isset($status_mental[2]) and $status_mental[2] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_4" value="15" <?php if(isset($status_mental[3]) and $status_mental[3] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_5" value="15" <?php if(isset($status_mental[4]) and $status_mental[4] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_6" value="15" <?php if(isset($status_mental[5]) and $status_mental[5] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_7" value="15" <?php if(isset($status_mental[6]) and $status_mental[6] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_8" value="15" <?php if(isset($status_mental[7]) and $status_mental[7] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_9" value="15" <?php if(isset($status_mental[8]) and $status_mental[8] == '15') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_10" value="15" <?php if(isset($status_mental[9]) and $status_mental[9] == '15') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>			
			<td>Sadar akan kemampuan diri sendiri</td>			
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="status_mental_1" value="0" <?php if(isset($status_mental[0]) and $status_mental[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_2" value="0" <?php if(isset($status_mental[1]) and $status_mental[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_3" value="0" <?php if(isset($status_mental[2]) and $status_mental[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_4" value="0" <?php if(isset($status_mental[3]) and $status_mental[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_5" value="0" <?php if(isset($status_mental[4]) and $status_mental[4] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_6" value="0" <?php if(isset($status_mental[5]) and $status_mental[5] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_7" value="0" <?php if(isset($status_mental[6]) and $status_mental[6] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_8" value="0" <?php if(isset($status_mental[7]) and $status_mental[7] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_9" value="0" <?php if(isset($status_mental[8]) and $status_mental[8] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="status_mental_10" value="0" <?php if(isset($status_mental[9]) and $status_mental[9] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<?php
		$total_skor_1 = 0;
		$total_skor_2 = 0;
		$total_skor_3 = 0;
		$total_skor_4 = 0;
		$total_skor_5 = 0;
		$total_skor_6 = 0;
		$total_skor_7 = 0;
		$total_skor_8 = 0;
		$total_skor_9 = 0;
		$total_skor_10 = 0;
		if(!empty($morse_fall_scale_id)){
			$total_skor_1 = $riwayat_jatuh[0] + $diagnosis_sekunder[0] + $alat_bantu[0] + $terpasang_infus[0] + $gaya_berjalan[0] + $status_mental[0];
			$total_skor_2 = $riwayat_jatuh[1] + $diagnosis_sekunder[1] + $alat_bantu[1] + $terpasang_infus[1] + $gaya_berjalan[1] + $status_mental[1];
			$total_skor_3 = $riwayat_jatuh[2] + $diagnosis_sekunder[2] + $alat_bantu[2] + $terpasang_infus[2] + $gaya_berjalan[2] + $status_mental[2];
			$total_skor_4 = $riwayat_jatuh[3] + $diagnosis_sekunder[3] + $alat_bantu[3] + $terpasang_infus[3] + $gaya_berjalan[3] + $status_mental[3];
			$total_skor_5 = $riwayat_jatuh[4] + $diagnosis_sekunder[4] + $alat_bantu[4] + $terpasang_infus[4] + $gaya_berjalan[4] + $status_mental[4];
			$total_skor_6 = $riwayat_jatuh[5] + $diagnosis_sekunder[5] + $alat_bantu[5] + $terpasang_infus[5] + $gaya_berjalan[5] + $status_mental[5];
			$total_skor_7 = $riwayat_jatuh[6] + $diagnosis_sekunder[6] + $alat_bantu[6] + $terpasang_infus[6] + $gaya_berjalan[6] + $status_mental[6];
			$total_skor_8 = $riwayat_jatuh[7] + $diagnosis_sekunder[7] + $alat_bantu[7] + $terpasang_infus[7] + $gaya_berjalan[7] + $status_mental[7];
			$total_skor_9 = $riwayat_jatuh[8] + $diagnosis_sekunder[8] + $alat_bantu[8] + $terpasang_infus[8] + $gaya_berjalan[8] + $status_mental[8];
			$total_skor_10 = $riwayat_jatuh[9] + $diagnosis_sekunder[9] + $alat_bantu[9] + $terpasang_infus[9] + $gaya_berjalan[9] + $status_mental[9];
		}	
		?>
		<tr>
			<td colspan="3" style=" font-weight:bold;">TOTAL SKOR</td>
		    <td align="center"><?php echo $total_skor_1; ?></td>
		    <td align="center"><?php echo $total_skor_2; ?></td>
		    <td align="center"><?php echo $total_skor_3; ?></td>
		    <td align="center"><?php echo $total_skor_4; ?></td>
		    <td align="center"><?php echo $total_skor_5; ?></td>
		    <td align="center"><?php echo $total_skor_6; ?></td>
		    <td align="center"><?php echo $total_skor_7; ?></td>
		    <td align="center"><?php echo $total_skor_8; ?></td>
		    <td align="center"><?php echo $total_skor_9; ?></td>
		    <td align="center"><?php echo $total_skor_10; ?></td>
		</tr>
		<tr>
			<td colspan="3" style=" font-weight:bold;">PERAWAT</td>
		    <td align="center"><select name="perawat_1" id="perawat_1" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[0])) $xperawat = $perawat[0]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_2" id="perawat_2" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[1])) $xperawat = $perawat[1]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_3" id="perawat_3" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[2])) $xperawat = $perawat[2]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_4" id="perawat_4" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[3])) $xperawat = $perawat[3]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_5" id="perawat_5" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[4])) $xperawat = $perawat[4]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_6" id="perawat_6" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[5])) $xperawat = $perawat[5]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_7" id="perawat_7" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[6])) $xperawat = $perawat[6]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_8" id="perawat_8" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[7])) $xperawat = $perawat[7]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_9" id="perawat_9" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[8])) $xperawat = $perawat[8]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_10" id="perawat_10" class="text_dt" style="width:40px;">
				<option> - </option>
				<?php if(isset($perawat[9])) $xperawat = $perawat[9]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		</tr>
		<tr>
			<td colspan="13" align="right" style="font-size:15px; "><input name="simpan" type="submit" class="myButton1" value="simpan"></td>
		</tr>
		<tr>
			<td colspan="2">
			Keterangan :<br />
			Risiko tinggi : >= 45<br />
			Risiko sedang : 25 - 44<br />
			Risiko rendah : 0 - 24</td>
			<td colspan="11" valign="top">
			* Untuk pasien dewasa
			</td>
		</tr>	
    </table>
</form>