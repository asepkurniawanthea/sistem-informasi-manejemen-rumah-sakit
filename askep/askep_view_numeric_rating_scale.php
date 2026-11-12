<?php
$irna_id = $_GET['idx'];

$sql_numeric = 'SELECT t_irna_askep_numeric_rating_scale.NUMERIC_RATING_SCALE_ID,
				t_irna_askep_numeric_rating_scale.SKOR,t_irna_askep_numeric_rating_scale.PERAWAT,
				t_irna_askep_numeric_rating_scale.TANGGAL,t_irna_askep_numeric_rating_scale.USER_ASKEP
				FROM t_irna_askep_numeric_rating_scale
				WHERE t_irna_askep_numeric_rating_scale.NUMERIC_RATING_SCALE_ID = "' . $_GET['idx'] . '"';
$get_numeric = mysql_query($sql_numeric) or die(mysql_error());
$dat_numeric = mysql_fetch_array($get_numeric);

$numeric_rating_scale_id = $dat_numeric['NUMERIC_RATING_SCALE_ID'];
$skor = explode('|',$dat_numeric['SKOR']);
$perawat = explode('|',$dat_numeric['PERAWAT']);
$tanggal = explode('|',$dat_numeric['TANGGAL']);
?>
<form name="formedukasi" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="irna_id" value="<?php echo $irna_id; ?>" />
	<input type="hidden" name="numeric_rating_scale_id" value="<?php echo $numeric_rating_scale_id; ?>" />
	<table align="center" class="tableData">
		<tr style="height:30px; background-color:#666666; color:#FFFFFF; ">
			<th>Skala</th>		
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
			<td align="center">0</td>
		    <td align="center"><input type="radio" name="skor_1" value="0" <?php if(isset($skor[0]) and $skor[0] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="0" <?php if(isset($skor[1]) and $skor[1] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="0" <?php if(isset($skor[2]) and $skor[2] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="0" <?php if(isset($skor[3]) and $skor[3] == '0') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="0" <?php if(isset($skor[4]) and $skor[4] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="0" <?php if(isset($skor[5]) and $skor[5] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="0" <?php if(isset($skor[6]) and $skor[6] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="0" <?php if(isset($skor[7]) and $skor[7] == '0') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="0" <?php if(isset($skor[8]) and $skor[8] == '0') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">1</td>
		    <td align="center"><input type="radio" name="skor_1" value="1" <?php if(isset($skor[0]) and $skor[0] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="1" <?php if(isset($skor[1]) and $skor[1] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="1" <?php if(isset($skor[2]) and $skor[2] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="1" <?php if(isset($skor[3]) and $skor[3] == '1') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="1" <?php if(isset($skor[4]) and $skor[4] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="1" <?php if(isset($skor[5]) and $skor[5] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="1" <?php if(isset($skor[6]) and $skor[6] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="1" <?php if(isset($skor[7]) and $skor[7] == '1') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="1" <?php if(isset($skor[8]) and $skor[8] == '1') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">2</td>
		    <td align="center"><input type="radio" name="skor_1" value="2" <?php if(isset($skor[0]) and $skor[0] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="2" <?php if(isset($skor[1]) and $skor[1] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="2" <?php if(isset($skor[2]) and $skor[2] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="2" <?php if(isset($skor[3]) and $skor[3] == '2') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="2" <?php if(isset($skor[4]) and $skor[4] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="2" <?php if(isset($skor[5]) and $skor[5] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="2" <?php if(isset($skor[6]) and $skor[6] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="2" <?php if(isset($skor[7]) and $skor[7] == '2') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="2" <?php if(isset($skor[8]) and $skor[8] == '2') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">3</td>
		    <td align="center"><input type="radio" name="skor_1" value="3" <?php if(isset($skor[0]) and $skor[0] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="3" <?php if(isset($skor[1]) and $skor[1] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="3" <?php if(isset($skor[2]) and $skor[2] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="3" <?php if(isset($skor[3]) and $skor[3] == '3') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="3" <?php if(isset($skor[4]) and $skor[4] == '3') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="3" <?php if(isset($skor[5]) and $skor[5] == '3') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="3" <?php if(isset($skor[6]) and $skor[6] == '3') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="3" <?php if(isset($skor[7]) and $skor[7] == '3') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="3" <?php if(isset($skor[8]) and $skor[8] == '3') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">4</td>
		    <td align="center"><input type="radio" name="skor_1" value="4" <?php if(isset($skor[0]) and $skor[0] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="4" <?php if(isset($skor[1]) and $skor[1] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="4" <?php if(isset($skor[2]) and $skor[2] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="4" <?php if(isset($skor[3]) and $skor[3] == '4') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="4" <?php if(isset($skor[4]) and $skor[4] == '4') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="4" <?php if(isset($skor[5]) and $skor[5] == '4') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="4" <?php if(isset($skor[6]) and $skor[6] == '4') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="4" <?php if(isset($skor[7]) and $skor[7] == '4') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="4" <?php if(isset($skor[8]) and $skor[8] == '4') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">5</td>
		    <td align="center"><input type="radio" name="skor_1" value="5" <?php if(isset($skor[0]) and $skor[0] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="5" <?php if(isset($skor[1]) and $skor[1] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="5" <?php if(isset($skor[2]) and $skor[2] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="5" <?php if(isset($skor[3]) and $skor[3] == '5') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="5" <?php if(isset($skor[4]) and $skor[4] == '5') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="5" <?php if(isset($skor[5]) and $skor[5] == '5') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="5" <?php if(isset($skor[6]) and $skor[6] == '5') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="5" <?php if(isset($skor[7]) and $skor[7] == '5') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="5" <?php if(isset($skor[8]) and $skor[8] == '5') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">6</td>
		    <td align="center"><input type="radio" name="skor_1" value="6" <?php if(isset($skor[0]) and $skor[0] == '6') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="6" <?php if(isset($skor[1]) and $skor[1] == '6') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="6" <?php if(isset($skor[2]) and $skor[2] == '6') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="6" <?php if(isset($skor[3]) and $skor[3] == '6') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="6" <?php if(isset($skor[4]) and $skor[4] == '6') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="6" <?php if(isset($skor[5]) and $skor[5] == '6') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="6" <?php if(isset($skor[6]) and $skor[6] == '6') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="6" <?php if(isset($skor[7]) and $skor[7] == '6') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="6" <?php if(isset($skor[8]) and $skor[8] == '6') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">7</td>
		    <td align="center"><input type="radio" name="skor_1" value="7" <?php if(isset($skor[0]) and $skor[0] == '7') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="7" <?php if(isset($skor[1]) and $skor[1] == '7') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="7" <?php if(isset($skor[2]) and $skor[2] == '7') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="7" <?php if(isset($skor[3]) and $skor[3] == '7') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="7" <?php if(isset($skor[4]) and $skor[4] == '7') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="7" <?php if(isset($skor[5]) and $skor[5] == '7') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="7" <?php if(isset($skor[6]) and $skor[6] == '7') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="7" <?php if(isset($skor[7]) and $skor[7] == '7') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="7" <?php if(isset($skor[8]) and $skor[8] == '7') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">8</td>
		    <td align="center"><input type="radio" name="skor_1" value="8" <?php if(isset($skor[0]) and $skor[0] == '8') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="8" <?php if(isset($skor[1]) and $skor[1] == '8') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="8" <?php if(isset($skor[2]) and $skor[2] == '8') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="8" <?php if(isset($skor[3]) and $skor[3] == '8') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="8" <?php if(isset($skor[4]) and $skor[4] == '8') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="8" <?php if(isset($skor[5]) and $skor[5] == '8') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="8" <?php if(isset($skor[6]) and $skor[6] == '8') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="8" <?php if(isset($skor[7]) and $skor[7] == '8') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="8" <?php if(isset($skor[8]) and $skor[8] == '8') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">9</td>
		    <td align="center"><input type="radio" name="skor_1" value="9" <?php if(isset($skor[0]) and $skor[0] == '9') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="9" <?php if(isset($skor[1]) and $skor[1] == '9') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="9" <?php if(isset($skor[2]) and $skor[2] == '9') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="9" <?php if(isset($skor[3]) and $skor[3] == '9') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="9" <?php if(isset($skor[4]) and $skor[4] == '9') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="9" <?php if(isset($skor[5]) and $skor[5] == '9') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="9" <?php if(isset($skor[6]) and $skor[6] == '9') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="9" <?php if(isset($skor[7]) and $skor[7] == '9') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="9" <?php if(isset($skor[8]) and $skor[8] == '9') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td align="center">10</td>
		    <td align="center"><input type="radio" name="skor_1" value="10" <?php if(isset($skor[0]) and $skor[0] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_2" value="10" <?php if(isset($skor[1]) and $skor[1] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_3" value="10" <?php if(isset($skor[2]) and $skor[2] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_4" value="10" <?php if(isset($skor[3]) and $skor[3] == '10') echo 'checked="checked"'; ?> /></td>
		    <td align="center"><input type="radio" name="skor_5" value="10" <?php if(isset($skor[4]) and $skor[4] == '10') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_6" value="10" <?php if(isset($skor[5]) and $skor[5] == '10') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_7" value="10" <?php if(isset($skor[6]) and $skor[6] == '10') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_8" value="10" <?php if(isset($skor[7]) and $skor[7] == '10') echo 'checked="checked"'; ?> /></td>
			<td align="center"><input type="radio" name="skor_9" value="10" <?php if(isset($skor[8]) and $skor[8] == '10') echo 'checked="checked"'; ?> /></td>
		</tr>
		<tr>
			<td style=" font-weight:bold;">PERAWAT</td>
		    <td align="center"><select name="perawat_1" id="perawat_1" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[0])) $xperawat = $perawat[0]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_2" id="perawat_2" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[1])) $xperawat = $perawat[1]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_3" id="perawat_3" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[2])) $xperawat = $perawat[2]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_4" id="perawat_4" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[3])) $xperawat = $perawat[3]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_5" id="perawat_5" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[4])) $xperawat = $perawat[4]; 
				echo getPerawat($xperawat); ?>
				</select></td>
		    <td align="center"><select name="perawat_6" id="perawat_6" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[5])) $xperawat = $perawat[5]; 
				echo getPerawat($xperawat); ?>
				</select></td>
			<td align="center"><select name="perawat_7" id="perawat_7" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[6])) $xperawat = $perawat[6]; 
				echo getPerawat($xperawat); ?>
				</select></td>
			<td align="center"><select name="perawat_8" id="perawat_8" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[7])) $xperawat = $perawat[7]; 
				echo getPerawat($xperawat); ?>
				</select></td>	
			<td align="center"><select name="perawat_9" id="perawat_9" class="text_dt" style="width:110px;">
				<option> - </option>
				<?php if(isset($perawat[8])) $xperawat = $perawat[8]; 
				echo getPerawat($xperawat); ?>
				</select></td>	
		</tr>
		<tr>
			<td style=" font-weight:bold;">TANGGAL</td>
		    <td><input type="text" name="tanggal_1" id="tgl_edu_1" value="<?php if(isset($tanggal[0])) echo $tanggal[0]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu1')"/></td>
		    <td><input type="text" name="tanggal_2" id="tgl_edu_2" value="<?php if(isset($tanggal[1])) echo $tanggal[1]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu2')"/></td>
		    <td><input type="text" name="tanggal_3" id="tgl_edu_3" value="<?php if(isset($tanggal[2])) echo $tanggal[2]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu3')"/></td>
		    <td><input type="text" name="tanggal_4" id="tgl_edu_4" value="<?php if(isset($tanggal[3])) echo $tanggal[3]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu4')"/></td>
		    <td><input type="text" name="tanggal_5" id="tgl_edu_5" value="<?php if(isset($tanggal[4])) echo $tanggal[4]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu5')"/></td>
			<td><input type="text" name="tanggal_6" id="tgl_edu_6" value="<?php if(isset($tanggal[5])) echo $tanggal[5]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu6')"/></td>
			<td><input type="text" name="tanggal_7" id="tgl_edu_7" value="<?php if(isset($tanggal[6])) echo $tanggal[6]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu7')"/></td>
			<td><input type="text" name="tanggal_8" id="tgl_edu_8" value="<?php if(isset($tanggal[7])) echo $tanggal[7]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu8')"/></td>
			<td><input type="text" name="tanggal_9" id="tgl_edu_9" value="<?php if(isset($tanggal[8])) echo $tanggal[8]; ?>" class="text_dt" style="width:78px;" />
			<img align="top" src="image/date.png" border="0"  onclick="showCal('CalEdu9')"/></td>
		</tr>
		<tr>
			<td colspan="13" align="right" style="font-size:15px; ">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" >
			Keterangan Skala Nyeri Wong Baker :<br />
			0	=	tidak ada nyeri<br />
			2	= 	nyeri sangat ringan<br />
			4	=	nyeri ringan (agak mengganggu)<br />
			6	= 	nyeri sedang (mengganggu aktivitas)<br />
			8 	=	nyeri berat (sangat mengganggu)<br />
			10	=	nyeri tidak dapat ditahan	
			</td>
			<td colspan="4" valign="top">
			Keterangan Skala Nyeri Numeric Rating Scale :<br />
			0	=	tidak nyeri<br />
			1-3	=	nyeri ringan<br />
			4-6 =	nyeri sedang<br />
			7-10 =	nyeri berat
			</td>
			<td colspan="4" valign="top">
			* Untuk anak umur diatas 3 tahun dan dewasa
			</td>
		</tr>	
    </table>
</form>