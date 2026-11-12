<?php
$select_jatuh='SELECT t_operasi_humpty_dumpty.HUNPTY_DUMPTY_ID,t_operasi_humpty_dumpty.USIA_MIN_3_SKOR,
				t_operasi_humpty_dumpty.USIA_3_7_SKOR,t_operasi_humpty_dumpty.USIA_7_13_SKOR,
				t_operasi_humpty_dumpty.USIA_MAX_13_SKOR,t_operasi_humpty_dumpty.JNS_KEL_L_SKOR,
				t_operasi_humpty_dumpty.JNS_KEL_P_SKOR,t_operasi_humpty_dumpty.DIAGNOSIS_NEUROLOGI_SKOR,
				t_operasi_humpty_dumpty.PERUBAHAN_OKSIGENASI_SKOR,t_operasi_humpty_dumpty.GANGGUAN_PERILAKU_SKOR,
				t_operasi_humpty_dumpty.DIAGNOSIS_LAINYA_SKOR,t_operasi_humpty_dumpty.SADAR_KETERBATASAN_DIRI_SKOR,
				t_operasi_humpty_dumpty.LUPA_KETERBATASAN_DIRI_SKOR,t_operasi_humpty_dumpty.ORIENTASI_BAIK_SKOR,
				t_operasi_humpty_dumpty.RIWAYAT_JATUH_BAYI_SKOR,t_operasi_humpty_dumpty.ALAT_BANTU_SKOR,
				t_operasi_humpty_dumpty.TMP_TIDUR_STANDAR_SKOR,t_operasi_humpty_dumpty.RAWAT_JALAN_SKOR,
				t_operasi_humpty_dumpty.RESPONSE_24_JAM_SKOR,t_operasi_humpty_dumpty.RESPONSE_48_JAM_SKOR,
				t_operasi_humpty_dumpty.RESPONSE_48_JAM_MAX_SKOR,t_operasi_humpty_dumpty.MULTIPLE_OBAT_SKOR,
				t_operasi_humpty_dumpty.SATU_OBAT_SKOR,t_operasi_humpty_dumpty.MEDIKASI_LAIN_SKOR
				FROM t_operasi_humpty_dumpty
				WHERE t_operasi_humpty_dumpty.OPERASI_ID = "' . $idx . '"';
	$query_jatuh=mysql_query($select_jatuh) or die(mysql_error());
	$row_jatuh=mysql_fetch_array($query_jatuh);	
	$hunpty_dumpty_id = $row_jatuh['HUNPTY_DUMPTY_ID'];
	$usia_min_3_skor = $row_jatuh['USIA_MIN_3_SKOR'];
	$usia_3_7_skor = $row_jatuh['USIA_3_7_SKOR'];
	$usia_7_13_skor = $row_jatuh['USIA_7_13_SKOR'];
	$usia_max_13_skor = $row_jatuh['USIA_MAX_13_SKOR'];
	$jns_kel_l_skor = $row_jatuh['JNS_KEL_L_SKOR'];
	$jns_kel_p_skor = $row_jatuh['JNS_KEL_P_SKOR'];
	$diagnosis_neurologi_skor = $row_jatuh['DIAGNOSIS_NEUROLOGI_SKOR'];
	$perubahan_oksigenasi_skor = $row_jatuh['PERUBAHAN_OKSIGENASI_SKOR'];
	$gangguan_perilaku_skor = $row_jatuh['GANGGUAN_PERILAKU_SKOR'];
	$diagnosis_lainya_skor = $row_jatuh['DIAGNOSIS_LAINYA_SKOR'];
	$sadar_keterbatasan_diri_skor = $row_jatuh['SADAR_KETERBATASAN_DIRI_SKOR'];
	$lupa_keterbatasan_diri_skor = $row_jatuh['LUPA_KETERBATASAN_DIRI_SKOR'];
	$orientasi_baik_skor = $row_jatuh['ORIENTASI_BAIK_SKOR'];
	$riwayat_jatuh_bayi_skor = $row_jatuh['RIWAYAT_JATUH_BAYI_SKOR'];
	$alat_bantu_skor = $row_jatuh['ALAT_BANTU_SKOR'];
	$tmp_tidur_standar_skor = $row_jatuh['TMP_TIDUR_STANDAR_SKOR'];
	$rawat_jalan_skor = $row_jatuh['RAWAT_JALAN_SKOR'];
	$response_24_jam_skor = $row_jatuh['RESPONSE_24_JAM_SKOR'];
	$response_48_jam_skor = $row_jatuh['RESPONSE_48_JAM_SKOR'];
	$response_48_jam_max_skor = $row_jatuh['RESPONSE_48_JAM_MAX_SKOR'];
	$multiple_obat_skor = $row_jatuh['MULTIPLE_OBAT_SKOR'];
	$satu_obat_skor = $row_jatuh['SATU_OBAT_SKOR'];
	$medikasi_lain_skor = $row_jatuh['MEDIKASI_LAIN_SKOR'];
	
	$skor = 0;
	for($x = 1; $x < 24; $x++){
		$skor = $skor + $row_jatuh[$x];	
	}
?>
	<table border="1" cellpadding="0" cellspacing="0" align="center" style="position:static; padding:5px; border:1px dashed #ccc;" width="80%" class="tableData">
		<tr>
			<td colspan="4">* Untuk Pasien Pediatri</td>
		</tr>
		<tr style="height:30px; background-color:#666666; color:#FFFFFF; ">
			<th>Parameter</th>
			<th colspan="2">Kriteria</th>
			<th width="150">Nilai</th>
		</tr>		
		<tr>
			<td rowspan="4" valign="top">USIA</td>
			<td width="5"><input type="checkbox" value="4" name="usia_min_3_skor" class="text_dt" <?php if($usia_min_3_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>< 3 Tahun</td>
			<td width="5" align="center">4</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" value="3" name="usia_3_7_skor" class="text_dt" <?php if($usia_3_7_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>3 - 7 Tahun</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" value="2" name="usia_7_13_skor" class="text_dt" <?php if($usia_7_13_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>7 - 13 Tahun</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" value="1" name="usia_max_13_skor" class="text_dt" <?php if($usia_max_13_skor > 0) echo 'checked="checked"'; ?>></td>
			<td><u>></u> 13 Tahun</td>
			<td width="5" align="center">1</td>
		</tr>
		
		<tr>
			<td rowspan="2" valign="top">JENIS KELAMIN</td>
			<td width="5"><input type="checkbox" name="jns_kel_l_skor" value="2" class="text_dt" <?php if($jns_kel_l_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Laki-Laki</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="jns_kel_p_skor" value="1" class="text_dt" <?php if($jns_kel_p_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Perempuan</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td rowspan="4" valign="top">DIAGNOSIS</td>
			<td width="5"><input type="checkbox" name="diagnosis_neurologi_skor" value="4" class="text_dt" <?php if($diagnosis_neurologi_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Diagnosis Neurologi</td>
			<td width="5" align="center">4</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="perubahan_oksigenasi_skor" value="3" class="text_dt" <?php if($perubahan_oksigenasi_skor > 0) echo 'checked="checked"'; ?>></td>
			<td wrap style="text-align:justify; ">Perubahan Oksigenasi (diagnosis respiratorik, dehidrasi, anemia, anoreksia, sinkop, pusing, dsb)</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="gangguan_perilaku_skor" value="2" class="text_dt" <?php if($gangguan_perilaku_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Gangguan Perilaku/ Psikiatri</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="diagnosis_lainya_skor" value="1" class="text_dt" <?php if($diagnosis_lainya_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Diagnosis Lainnya</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td rowspan="3" valign="top">GANGGUAN KOGNITIF</td>
			<td width="5"><input type="checkbox" name="sadar_keterbatasan_diri_skor" value="3" class="text_dt"<?php if($sadar_keterbatasan_diri_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Tidak Menyadari Keterbatasan Dirinya</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="lupa_keterbatasan_diri_skor" value="2" class="text_dt" <?php if($lupa_keterbatasan_diri_skor > 0) echo 'checked="checked"'; ?>></td>
			<td wrap style="text-align:justify; ">Lupa Akan Adanya Keterbatasan</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="orientasi_baik_skor" value="1" class="text_dt" <?php if($orientasi_baik_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Orientasi Baik Terhadap Diri Sendiri</td>
			<td width="5" align="center">1</td>
		</tr>	
		
		<tr>
			<td rowspan="4" valign="top">FAKTOR LINGKUNGAN</td>
			<td width="5"><input type="checkbox" name="riwayat_jatuh_bayi_skor" value="4" class="text_dt" <?php if($riwayat_jatuh_bayi_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Riwayat jatuh bayi/ balita yang diletakkan di tempat tidur dewasa</td>
			<td width="5" align="center">4</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="alat_bantu_skor" value="3" class="text_dt" <?php if($alat_bantu_skor > 0) echo 'checked="checked"'; ?>></td>
			<td wrap style="text-align:justify; ">Pasien menggunakan alat bantu/ bayi diletakkan di tempat tidur balita dalam ayunan.</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="tmp_tidur_standar_skor" value="2" class="text_dt" <?php if($tmp_tidur_standar_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Pasien diletakkan di tempat tidur standar</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="rawat_jalan_skor" value="1" class="text_dt" <?php if($rawat_jalan_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Area pasien rawat jalan</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td rowspan="3" valign="top">RESPONS TERHADAP PEMBEDAHAN/<br>SEDASI/ANESTESI</td>
			<td width="5"><input type="checkbox" name="response_24_jam_skor" value="3" class="text_dt" <?php if($response_24_jam_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Dalam 24 Jam</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="response_48_jam_skor" value="2" class="text_dt" <?php if($response_48_jam_skor > 0) echo 'checked="checked"'; ?>></td>
			<td wrap style="text-align:justify; ">Dalam 48 Jam</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="response_48_jam_max_skor" value="1" class="text_dt" <?php if($response_48_jam_max_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>> 48 Jam atau tidak menjalani pembedahan/sedasi/anestesi</td>
			<td width="5" align="center">1</td>
		</tr>
		
		<tr>
			<td rowspan="3" valign="top">PENGGUNAAN MEDIKAMENTOSA</td>
			<td width="5"><input type="checkbox" name="multiple_obat_skor" value="3" class="text_dt" <?php if($multiple_obat_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Penggunaan multipel : sedatif, obat hipnosis, barbiturat, fenotizin, antidepresan, pencahar, diuretik, narkose.</td>
			<td width="5" align="center">3</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="satu_obat_skor" value="2" class="text_dt" <?php if($satu_obat_skor > 0) echo 'checked="checked"'; ?>></td>
			<td wrap style="text-align:justify; ">Penggunaan salah satu obat diatas.</td>
			<td width="5" align="center">2</td>
		</tr>
		<tr>
			<td width="5"><input type="checkbox" name="medikasi_lain_skor" value="1" class="text_dt" <?php if($medikasi_lain_skor > 0) echo 'checked="checked"'; ?>></td>
			<td>Penggunaan medikasi lainnya/tidak ada medikasi</td>
			<td width="5" align="center">1</td>
		</tr>
		<tr>
			<td colspan="3" style=" font-weight:bold;">TOTAL SKOR</td>
			<td width="5" align="center"><?php echo $skor; ?></td>			
		</tr>
    </table>
</form>