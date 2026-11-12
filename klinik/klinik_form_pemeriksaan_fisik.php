<?php
$p_fisik[1] = '';	
$p_fisik[2] = '';	
$p_fisik[3] = '';	
$p_fisik[4] = '';	
$p_fisik[5] = '';	
$p_fisik[6] = '';	
$p_fisik[7] = '';
$p_fisik[8] = '';
$p_fisik[9] = '';
$p_fisik[10] = '';

$p_fisik[11] = '';
$p_fisik[12] = '';
$p_fisik[13] = '';
$p_fisik[14] = '';
$p_fisik[15] = '';
$p_fisik[16] = '';
$p_fisik[17] = '';
$p_fisik[18] = '';
$p_fisik[19] = '';
$p_fisik[20] = '';

$p_fisik[21] = '';	
$p_fisik[22] = '';	
$p_fisik[23] = '';	
$p_fisik[24] = '';	
$p_fisik[25] = '';	
$p_fisik[26] = '';	
$p_fisik[27] = '';
$p_fisik[28] = '';
$p_fisik[29] = '';
$p_fisik[30] = '';

$p_fisik[31] = '';	
$p_fisik[32] = '';	
$p_fisik[33] = '';	
$p_fisik[34] = '';	
$p_fisik[35] = '';	
$p_fisik[36] = '';	
$p_fisik[37] = '';
$p_fisik[38] = '';
$p_fisik[39] = '';
$p_fisik[40] = '';

$p_fisik[41] = '';	
$p_fisik[42] = '';	
$p_fisik[43] = '';	
$p_fisik[44] = '';	
$p_fisik[45] = '';	
$p_fisik[46] = '';	
$p_fisik[47] = '';
$p_fisik[48] = '';
$p_fisik[49] = '';
$p_fisik[50] = '';

$p_fisik[51] = '';	
$p_fisik[52] = '';	
$p_fisik[53] = '';	
$p_fisik[54] = '';	
$p_fisik[55] = '';	
$p_fisik[56] = '';	
$p_fisik[57] = '';
$p_fisik[58] = '';
$p_fisik[59] = '';
$p_fisik[60] = '';

$p_fisik[61] = '';	
$p_fisik[62] = '';

$p_fisik_array = explode('|*|',$pemeriksaan_fisik); 
$fisik_count = sizeof($p_fisik_array); 

if($fisik_count >= 62){
	$x = 1;
	while($x <= 62){
		$p_fisik[$x] = $p_fisik_array[$x - 1]; 	
	$x++;
	}
}

if(currentModul() != 'igd'){
	if(!empty($pemeriksaan_fisik) and ($fisik_count == 1)){ ?>
	<textarea  class="text_dt2" name="pemeriksaan_fisik" id="pemeriksaan_fisik" cols="80" rows="5"><?php echo $pemeriksaan_fisik; ?></textarea>
<?php 
	}else{ ?> 
		<table border="0" width="100%">
					<tr>
						<td>Keadaan Umum</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="p_fisik_1" value="<?php echo $p_fisik[1]; ?>" class="text_dt" size="70"></td>
					</tr>	
					<tr>	
						<td>Tekanan Darah</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_2" value="<?php echo $p_fisik[2]; ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>GCS</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_3" value="<?php echo $p_fisik[3]; ?>" class="text_dt" ></td>
					</tr>
					<tr>	
						<td>Nadi</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_4" value="<?php echo $p_fisik[4]; ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Suhu</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_5" value="<?php echo $p_fisik[5]; ?>" class="text_dt" ></td>
					</tr>
					<tr>	
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="checkbox" name="p_fisik_6" value="1" class="text_dt" <?php if($p_fisik[6] == '1') echo 'checked="checked"'; ?> >&nbsp;Teratur
						&nbsp;<input type="checkbox" name="p_fisik_7" value="1" class="text_dt" <?php if($p_fisik[7] == '1') echo 'checked="checked"'; ?> >&nbsp;Tidak Teratur</td>
						<td>&nbsp;</td>
						<td>Tinggi Badan</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_8" value="<?php echo $p_fisik[8]; ?>" class="text_dt" ></td>
					</tr>
					<tr>	
						<td>Kepala</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_9" value="<?php echo $p_fisik[9]; ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Berat Badan</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_10" value="<?php echo $p_fisik[10]; ?>" class="text_dt" ></td>
					</tr>
					<tr>	
						<td>Leher</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_11" value="<?php echo $p_fisik[11]; ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>RR</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_12" value="<?php echo $p_fisik[12]; ?>" class="text_dt" ></td>
					</tr>
					<tr>	
						<td>Dada</td>
						<td>:</td>
						<td colspan="5">a. Jantung&nbsp;&nbsp;
						<input type="text" name="p_fisik_13" value="<?php echo $p_fisik[13]; ?>" class="text_dt" size="70" ></td>
					</tr>
					<tr>	
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">b. Dada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="text" name="p_fisik_14" value="<?php echo $p_fisik[14]; ?>" class="text_dt" size="70" ></td>
					</tr>
					<tr>
						<td>Abdomen</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="p_fisik_15" value="<?php echo $p_fisik[15]; ?>" class="text_dt" size="70"></td>
					</tr>
					<tr>
						<td>Extremitas</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="p_fisik_16" value="<?php echo $p_fisik[16]; ?>" class="text_dt" size="70"></td>
					</tr>
		</table>			
<?php	}	
} else{ ?>

                <table border="0" width="100%">
					<tr>
						<td>Keadaan Umum</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="p_fisik_1" value="<?php echo $p_fisik[1]; ?>" class="text_dt" size="70"></td>
					</tr>	
					<tr>	
						<td>Tekanan Darah</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_2" value="<?php echo $p_fisik[2]; ?>" class="text_dt" ></td>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>Nadi</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_3" value="<?php echo $p_fisik[3]; ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Suhu</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_4" value="<?php echo $p_fisik[4]; ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td>Respirasi</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_5" value="<?php echo $p_fisik[5]; ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Berat Badan</td>
						<td>:</td>
						<td><input type="text" name="p_fisik_6" value="<?php echo $p_fisik[6]; ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>A. Status Neurologis</td>
						<td>:</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_7" value="1" class="text_dt" <?php if($p_fisik[7] == '1') echo 'checked="checked"'; ?> >&nbsp;Kaku Kuduk (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_8" value="1" class="text_dt" <?php if($p_fisik[8] == '1') echo 'checked="checked"'; ?> >&nbsp;Kaku Kuduk (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>GCS: E,M,V</td>
						<td>:</td>
						<td colspan="3"><input type="text" name="p_fisik_9" value="<?php echo $p_fisik[9]; ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3"><input type="text" name="p_fisik_10" value="<?php echo $p_fisik[10]; ?>" class="text_dt" size="42" ></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>B. Kepala Leher</td>
						<td>:</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_11" value="1" class="text_dt" <?php if($p_fisik[11] == '1') echo 'checked="checked"'; ?> >&nbsp;Nafas Cufing Hidung (NCH) (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_12" value="1" class="text_dt" <?php if($p_fisik[12] == '1') echo 'checked="checked"'; ?> >&nbsp;Nafas Cufing Hidung (NCH) (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_13" value="1" class="text_dt" <?php if($p_fisik[13] == '1') echo 'checked="checked"'; ?> >&nbsp;Congjungtira Anemis (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_14" value="1" class="text_dt" <?php if($p_fisik[14] == '1') echo 'checked="checked"'; ?> >&nbsp;Congjungtira Anemis (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_15" value="1" class="text_dt" <?php if($p_fisik[15] == '1') echo 'checked="checked"'; ?> >&nbsp;Sklera Ikterik (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_16" value="1" class="text_dt" <?php if($p_fisik[16] == '1') echo 'checked="checked"'; ?> >&nbsp;Sklera Ikterik (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">JVP&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_17" value="1" class="text_dt" <?php if($p_fisik[17] == '1') echo 'checked="checked"'; ?> >&nbsp;Meningkat&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_18" value="1" class="text_dt" <?php if($p_fisik[18] == '1') echo 'checked="checked"'; ?> >&nbsp;Tidak Meningkat</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3"><input type="text" name="p_fisik_19" value="<?php echo $p_fisik[19]; ?>" class="text_dt" size="42" ></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>C. Thorax</td>
						<td>:&nbsp;&nbsp;1.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_20" value="1" class="text_dt" <?php if($p_fisik[20] == '1') echo 'checked="checked"'; ?> >&nbsp;Retraksi (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_21" value="1" class="text_dt" <?php if($p_fisik[21] == '1') echo 'checked="checked"'; ?> >&nbsp;Retraksi (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;2.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_22" value="1" class="text_dt" <?php if($p_fisik[22] == '1') echo 'checked="checked"'; ?> >&nbsp;Fraktur (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_23" value="1" class="text_dt" <?php if($p_fisik[23] == '1') echo 'checked="checked"'; ?> >&nbsp;Fraktur (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;3.</td>
						<td colspan="5">Cor=S1-S2&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_24" value="1" class="text_dt" <?php if($p_fisik[24] == '1') echo 'checked="checked"'; ?> >&nbsp;Irreguler&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_25" value="1" class="text_dt" <?php if($p_fisik[25] == '1') echo 'checked="checked"'; ?> >&nbsp;Reguler</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;4.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_26" value="1" class="text_dt" <?php if($p_fisik[26] == '1') echo 'checked="checked"'; ?> >&nbsp;Murmur (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_27" value="1" class="text_dt" <?php if($p_fisik[27] == '1') echo 'checked="checked"'; ?> >&nbsp;Murmur (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;5.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_28" value="1" class="text_dt" <?php if($p_fisik[28] == '1') echo 'checked="checked"'; ?> >&nbsp;Gallop (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_29" value="1" class="text_dt" <?php if($p_fisik[29] == '1') echo 'checked="checked"'; ?> >&nbsp;Gallop (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;6.</td>
						<td colspan="5">Pulmo&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_30" value="1" class="text_dt" <?php if($p_fisik[30] == '1') echo 'checked="checked"'; ?> >&nbsp;So Verikuler (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_31" value="1" class="text_dt" <?php if($p_fisik[31] == '1') echo 'checked="checked"'; ?> >&nbsp;So Verikuler (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_32" value="1" class="text_dt" <?php if($p_fisik[32] == '1') echo 'checked="checked"'; ?> >&nbsp;Ronkhi (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_33" value="1" class="text_dt" <?php if($p_fisik[33] == '1') echo 'checked="checked"'; ?> >&nbsp;Ronkhi (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_34" value="1" class="text_dt" <?php if($p_fisik[34] == '1') echo 'checked="checked"'; ?> >&nbsp;Wheezing (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_35" value="1" class="text_dt" <?php if($p_fisik[35] == '1') echo 'checked="checked"'; ?> >&nbsp;Wheezing (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3"><input type="text" name="p_fisik_36" value="<?php echo $p_fisik[36]; ?>" class="text_dt" size="42" ></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>D. Abdomen</td>
						<td>:&nbsp;&nbsp;1.</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_37" value="1" class="text_dt" <?php if($p_fisik[37] == '1') echo 'checked="checked"'; ?> >&nbsp;Supel&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_38" value="1" class="text_dt" <?php if($p_fisik[38] == '1') echo 'checked="checked"'; ?> >&nbsp;Keras&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_39" value="1" class="text_dt" <?php if($p_fisik[39] == '1') echo 'checked="checked"'; ?> >&nbsp;Datar</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;2.</td>
						<td colspan="5">Bissing Usus&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_40" value="1" class="text_dt" <?php if($p_fisik[40] == '1') echo 'checked="checked"'; ?> >&nbsp;Normal&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_41" value="1" class="text_dt" <?php if($p_fisik[41] == '1') echo 'checked="checked"'; ?> >&nbsp;Menurun&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_42" value="1" class="text_dt" <?php if($p_fisik[42] == '1') echo 'checked="checked"'; ?> >&nbsp;Meningkat&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_43" value="1" class="text_dt" <?php if($p_fisik[43] == '1') echo 'checked="checked"'; ?> >&nbsp;Menghilang</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;3.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_44" value="1" class="text_dt" <?php if($p_fisik[44] == '1') echo 'checked="checked"'; ?> >&nbsp;Nyeri Tekan Epigastrium (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_45" value="1" class="text_dt" <?php if($p_fisik[45] == '1') echo 'checked="checked"'; ?> >&nbsp;Nyeri Tekan Epigastrium (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;4.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_46" value="1" class="text_dt" <?php if($p_fisik[46] == '1') echo 'checked="checked"'; ?> >&nbsp;Nyeri Tekan MC Burney (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_47" value="1" class="text_dt" <?php if($p_fisik[47] == '1') echo 'checked="checked"'; ?> >&nbsp;Nyeri Tekan MC Burney (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;5.</td>
						<td colspan="5">Hepar&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_48" value="1" class="text_dt" <?php if($p_fisik[48] == '1') echo 'checked="checked"'; ?> >&nbsp;Teraba&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_49" value="1" class="text_dt" <?php if($p_fisik[49] == '1') echo 'checked="checked"'; ?> >&nbsp;Tidak Teraba</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;6.</td>
						<td colspan="5">Lien&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p_fisik_50" value="1" class="text_dt" <?php if($p_fisik[50] == '1') echo 'checked="checked"'; ?> >&nbsp;Membesar&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_51" value="1" class="text_dt" <?php if($p_fisik[51] == '1') echo 'checked="checked"'; ?> >&nbsp;Tidak Membesar</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>Lain-lain</td>
						<td>:</td>
						<td colspan="3"><input type="text" name="p_fisik_52" value="<?php echo $p_fisik[52]; ?>" class="text_dt" size="42" ></td>
					</tr>
					<tr>
						<td colspan="7">&nbsp;</td>
					</tr>
					<tr>
						<td>E. Ekstremitas</td>
						<td>:</td>
						<td colspan="5"><input type="checkbox" name="p_fisik_53" value="1" class="text_dt" <?php if($p_fisik[53] == '1') echo 'checked="checked"'; ?> >&nbsp;Atas&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_54" value="1" class="text_dt" <?php if($p_fisik[54] == '1') echo 'checked="checked"'; ?> >&nbsp;Bawah&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_55" value="1" class="text_dt" <?php if($p_fisik[55] == '1') echo 'checked="checked"'; ?> >&nbsp;Kanan&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_56" value="1" class="text_dt" <?php if($p_fisik[56] == '1') echo 'checked="checked"'; ?> >&nbsp;Kiri</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;1.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_57" value="1" class="text_dt" <?php if($p_fisik[57] == '1') echo 'checked="checked"'; ?> >&nbsp;Sianosi (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_58" value="1" class="text_dt" <?php if($p_fisik[58] == '1') echo 'checked="checked"'; ?> >&nbsp;Sianosi (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;2.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_59" value="1" class="text_dt" <?php if($p_fisik[59] == '1') echo 'checked="checked"'; ?> >&nbsp;Udem (-)&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_60" value="1" class="text_dt" <?php if($p_fisik[60] == '1') echo 'checked="checked"'; ?> >&nbsp;Udem (+)</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;3.</td>
						<td colspan="5">
						<input type="checkbox" name="p_fisik_61" value="1" class="text_dt" <?php if($p_fisik[61] == '1') echo 'checked="checked"'; ?> >&nbsp;Akral Hangat&nbsp;&nbsp;&nbsp;
						<input type="checkbox" name="p_fisik_62" value="1" class="text_dt" <?php if($p_fisik[62] == '1') echo 'checked="checked"'; ?> >&nbsp;Akral Dingin</td>
					</tr>
				</table>
<?php } ?>				