<?php
$sql_jatuh = 'SELECT t_operasi_morse_fall_scale.MORSE_FALL_SCALE_ID,
			  t_operasi_morse_fall_scale.RIWAYAT_JATUH,
			  t_operasi_morse_fall_scale.DIAGNOSIS_SEKUNDER,
			  t_operasi_morse_fall_scale.ALAT_BANTU,
			  t_operasi_morse_fall_scale.TERPASANG_INFUS,
			  t_operasi_morse_fall_scale.GAYA_BERJALAN,
			  t_operasi_morse_fall_scale.STATUS_MENTAL
			FROM t_operasi_morse_fall_scale
			WHERE t_operasi_morse_fall_scale.OPERASI_ID = "' . $_GET['idx'] . '"';
$get_jatuh = mysql_query($sql_jatuh) or die(mysql_error());
$dat_jatuh = mysql_fetch_array($get_jatuh);

$morse_fall_scale_id = $dat_jatuh['MORSE_FALL_SCALE_ID'];
$riwayat_jatuh = $dat_jatuh['RIWAYAT_JATUH'];
$diagnosis_sekunder = $dat_jatuh['DIAGNOSIS_SEKUNDER'];
$alat_bantu = $dat_jatuh['ALAT_BANTU'];
$terpasang_infus = $dat_jatuh['TERPASANG_INFUS'];
$gaya_berjalan = $dat_jatuh['GAYA_BERJALAN'];
$status_mental = $dat_jatuh['STATUS_MENTAL'];

$skor = 0;
for($x = 1; $x < 7; $x++){
	$skor = $skor + $dat_jatuh[$x];	
}
			
if (isset($_POST['simpan']))  	
	include('operasi/operasi_save_morse_fall_scare.php'); 
?>
<form name="formontorio" method="post" action="<?php echo currentUrl(); ?>" >
	<input type="hidden" name="irna_id" value="<?php echo $rawat_id; ?>" />
	<input type="hidden" name="operasi_id" value="<?php echo $_GET['idx']; ?>" />
	<input type="hidden" name="morse_fall_scale_id" value="<?php echo $morse_fall_scale_id; ?>" />
	<table align="center" width="80%" class="tableData">
		<tr style="height:30px; background-color:#666666; color:#FFFFFF; ">
			<th>Faktor Risiko</th>
			<th>Skala</th>		
			<th>Point</th>
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">RIWAYAT JATUH</td>			
			<td>
				<input name="riwayat_jatuh" id="riwayat_jatuh" value="25" type="radio" <?php if($riwayat_jatuh == '25') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;							
			</td>
			<td align="center">25</td>
		</tr>
		<tr>			
			<td>				
				<input name="riwayat_jatuh" id="riwayat_jatuh" value="0" type="radio" <?php if($riwayat_jatuh == '0') echo 'checked="checked"'; ?>>Tidak
			</td>		
			<td align="center">0</td>	
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">DIAGNOSIS SEKUNDER ( <u>></u> 2 DIAGNOSISIS MEDIS)</td>			
			<td>
				<input name="diagnosis_sekunder" id="diagnosis_sekunder" value="15" type="radio" <?php if($diagnosis_sekunder == '15') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
			</td>
			<td align="center">15</td>
		</tr>
		<tr>			
			<td>				
				<input name="diagnosis_sekunder" id="diagnosis_sekunder" value="0" type="radio" <?php if($diagnosis_sekunder == '0') echo 'checked="checked"'; ?> >Tidak
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">ALAT BANTU</td>
			<td>
				<input name="alat_bantu" id="alat_bantu" value="30" type="radio" <?php if($alat_bantu == '30') echo 'checked="checked"'; ?> >Berpegangan pada perabot&nbsp;&nbsp;							
			</td>
			<td align="center">30</td>
		</tr>
		<tr>			
			<td>				
				<input name="alat_bantu" id="alat_bantu" value="15" type="radio" <?php if($alat_bantu == '15') echo 'checked="checked"'; ?> >Tongkat / alat penopang
			</td>			
			<td align="center">15</td>
		</tr>		
		<tr>			
			<td>				
				<input name="alat_bantu" id="alat_bantu" value="0" type="radio" <?php if($alat_bantu == '0') echo 'checked="checked"'; ?> >Tidak ada / kursi roda / perawat / tirah baring
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">TERPASANG INFUS</td>
			<td>
				<input name="terpasang_infus" id="terpasang_infus" value="20" type="radio" <?php if($terpasang_infus == '20') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;							
			</td>
			<td align="center">20</td>
		</tr>
		<tr>			
			<td>				
				<input name="terpasang_infus" id="terpasang_infus" value="0" type="radio" <?php if($terpasang_infus == '0') echo 'checked="checked"'; ?> >Tidak
			</td>			
			<td align="center">0</td>
		</tr>		
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">GAYA BERJALAN</td>
			<td>
				<input name="gaya_berjalan" id="gaya_berjalan" value="20" type="radio" <?php if($gaya_berjalan == '20') echo 'checked="checked"'; ?> >Terganggu&nbsp;&nbsp;							
			</td>
			<td align="center">20</td>
		</tr>
		<tr>			
			<td>				
				<input name="gaya_berjalan" id="gaya_berjalan" value="10" type="radio" <?php if($gaya_berjalan == '10') echo 'checked="checked"'; ?> >Lemah
			</td>			
			<td align="center">10</td>
		</tr>		
		<tr>			
			<td>				
				<input name="gaya_berjalan" id="gaya_berjalan" value="0" type="radio" <?php if($gaya_berjalan == '0') echo 'checked="checked"'; ?> >Normal / Tirah baring / Immobilisasi
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">STATUS MENTAL</td>
			<td>
				<input name="status_mental" id="status_mental" value="15" type="radio" <?php if($status_mental == '15') echo 'checked="checked"'; ?> >Sering lupa akan keterbatasan yang dimiliki&nbsp;&nbsp;						
			</td>
			<td align="center">15</td>
		</tr>
		<tr>			
			<td>				
				<input name="status_mental" id="status_mental" value="0" type="radio" <?php if($status_mental == '0') echo 'checked="checked"'; ?> >Sadar akan kemampuan diri sendiri
			</td>			
			<td align="center">0</td>
		</tr>
		<tr>
			<td colspan="2" style=" font-weight:bold;">TOTAL SKOR</td>
			<td align="center"><?php echo $skor; ?></td>			
		</tr>
		<tr>
			<td colspan="3" align="right" style="font-size:15px; "><input name="simpan" type="submit" class="myButton1" value="Simpan"></td>
		</tr>		
    </table>
</form>