<?php
$sql_jatuh = 'SELECT t_operasi_skala_jatuh_ontario.SKALA_JATUH_ID,
			  t_operasi_skala_jatuh_ontario.RIWAYAT_JATUH_DATANG,
			  t_operasi_skala_jatuh_ontario.RIWAYAT_JATUH_2_BULAN,
			  t_operasi_skala_jatuh_ontario.STATUS_MENTAL_DELIRIUM,
			  t_operasi_skala_jatuh_ontario.STATUS_MENTAL_DISORIENTASI,
			  t_operasi_skala_jatuh_ontario.STATUS_MENTAL_AGITASI,
			  t_operasi_skala_jatuh_ontario.PENGLIHATAN_KACAMATA,
			  t_operasi_skala_jatuh_ontario.PENGLIHATAN_BURAM,
			  t_operasi_skala_jatuh_ontario.PENGLIHATAN_GLUKOMA,
			  t_operasi_skala_jatuh_ontario.KEBIASAAN_BERKEMIH,
			  t_operasi_skala_jatuh_ontario.TRANSFER_MANDIRI,
			  t_operasi_skala_jatuh_ontario.TRANSFER_BANTUAN_1_ORANG,
			  t_operasi_skala_jatuh_ontario.TRANSFER_BANTUAN_2_ORANG,
			  t_operasi_skala_jatuh_ontario.TRANSFER_BANTUAN_TOTAL,
			  t_operasi_skala_jatuh_ontario.MOBILITAS_MANDIRI,
			  t_operasi_skala_jatuh_ontario.MOBILITAS_BANTUAN_1_ORANG,
			  t_operasi_skala_jatuh_ontario.MOBILITAS_KURSI_RODA,
			  t_operasi_skala_jatuh_ontario.IMMOBILISASI
			FROM t_operasi_skala_jatuh_ontario
			WHERE t_operasi_skala_jatuh_ontario.OPERASI_ID = "' . $_GET['idx'] . '"';
$get_jatuh = mysql_query($sql_jatuh) or die(mysql_error());
$dat_jatuh = mysql_fetch_assoc($get_jatuh);

$skala_jatuh_id = $dat_jatuh['SKALA_JATUH_ID'];
$riwayat_jatuh_datang = $dat_jatuh['RIWAYAT_JATUH_DATANG'];
$riwayat_jatuh_2_bulan = $dat_jatuh['RIWAYAT_JATUH_2_BULAN'];
$status_mental_delirium = $dat_jatuh['STATUS_MENTAL_DELIRIUM'];
$status_mental_disorientasi = $dat_jatuh['STATUS_MENTAL_DISORIENTASI'];
$status_mental_agitasi = $dat_jatuh['STATUS_MENTAL_AGITASI'];
$penglihatan_kacamata = $dat_jatuh['PENGLIHATAN_KACAMATA'];
$penglihatan_buram = $dat_jatuh['PENGLIHATAN_BURAM'];
$penglihatan_glukoma = $dat_jatuh['PENGLIHATAN_GLUKOMA'];
$kebiasaan_berkemih = $dat_jatuh['KEBIASAAN_BERKEMIH'];
$transfer_mandiri = $dat_jatuh['TRANSFER_MANDIRI'];
$transfer_bantuan_1_orang = $dat_jatuh['TRANSFER_BANTUAN_1_ORANG'];
$transfer_bantuan_2_orang = $dat_jatuh['TRANSFER_BANTUAN_2_ORANG'];
$transfer_bantuan_total = $dat_jatuh['TRANSFER_BANTUAN_TOTAL'];
$mobilitas_mandiri = $dat_jatuh['MOBILITAS_MANDIRI'];
$mobilitas_bantuan_1_orang = $dat_jatuh['MOBILITAS_BANTUAN_1_ORANG'];
$mobilitas_kursi_roda = $dat_jatuh['MOBILITAS_KURSI_RODA'];
$immobilisasi = $dat_jatuh['IMMOBILISASI'];

$skor = 0;
if(($riwayat_jatuh_datang == '1') or ($riwayat_jatuh_2_bulan == '1')) $skor = $skor + 6;
if(($status_mental_delirium == '1') or ($status_mental_disorientasi == '1') or ($status_mental_agitasi == '1')) $skor = $skor + 14;
if(($penglihatan_kacamata == '1') or ($penglihatan_buram == '1') or ($penglihatan_glukoma == '1')) $skor = $skor + 1;
if($kebiasaan_berkemih == '1') $skor = $skor + 2;

$transfer = 0;
if($transfer_mandiri == '1') $transfer = $transfer + 0;
if($transfer_bantuan_1_orang == '1') $transfer = $transfer + 1;
if($transfer_bantuan_2_orang == '1') $transfer = $transfer + 2;
if($transfer_bantuan_total == '1') $transfer = $transfer + 3;
if($transfer < 4) $skor = $skor;

$mobilitas = 0;
if($mobilitas_mandiri == '1') $mobilitas = $mobilitas + 0;
if($mobilitas_bantuan_1_orang == '1') $mobilitas = $mobilitas + 1;
if($mobilitas_kursi_roda == '1') $mobilitas = $mobilitas + 2;
if($immobilisasi == '1') $mobilitas = $mobilitas + 3;
if(($mobilitas >= 4) and ($mobilitas <= 6)) $skor = $skor + 7;
?>
	<table align="center" width="80%" class="tableData">
		<tr>
			<td colspan="4" >*Untuk Pasien Geriatri
			</td>
		</tr>
		<tr style="height:30px; background-color:#666666; color:#FFFFFF; ">
			<th>Parameter</th>
			<th>Skrining</th>		
			<th>Jawaban</th>
			<th>Keterangan Nilai</th>
		</tr>		
		<tr>
			<td rowspan="2" valign="top" style="padding-top:15px; ">RIWAYAT JATUH</td>
			<td>Apakah pasien datang ke rumah sakit karena jatuh ?</td>
			<td align="center">
				<input name="riwayat_jatuh_datang" id="riwayat_jatuh_datang" value="1" type="radio" <?php if($riwayat_jatuh_datang == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="riwayat_jatuh_datang" id="riwayat_jatuh_datang" value="2" type="radio" <?php if($riwayat_jatuh_datang == '2') echo 'checked="checked"'; ?> >Tidak
			</td>
			<td rowspan="2">Salah satu jawaban Ya = 6</td>
		</tr>
		<tr>
			<td>Jika tidak, apakah pasien mengalami jatuh dalam 2 bulan terakhir ?</td>
			<td align="center">
				<input name="riwayat_jatuh_2_bulan" id="riwayat_jatuh_2_bulan" value="1" type="radio" <?php if($riwayat_jatuh_2_bulan == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="riwayat_jatuh_2_bulan" id="riwayat_jatuh_2_bulan" value="2" type="radio" <?php if($riwayat_jatuh_2_bulan == '2') echo 'checked="checked"'; ?>>Tidak
			</td>			
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">STATUS MENTAL</td>
			<td>Apakah pasien delirium ? (tidak dapat membuat keputusan, pola pikir tidak terorganisir, gangguan daya ingat)</td>
			<td align="center">
				<input name="status_mental_delirium" id="status_mental_delirium" value="1" type="radio" <?php if($status_mental_delirium == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="status_mental_delirium" id="status_mental_delirium" value="2" type="radio" <?php if($status_mental_delirium == '2') echo 'checked="checked"'; ?>>Tidak
			</td>
			<td rowspan="3" nowrap>Salah satu jawaban Ya = 14</td>
		</tr>
		<tr>
			<td>Apakah pasien disorientasi ? (salah menyebutkan waktu, tempat atau orang)</td>
			<td align="center">
				<input name="status_mental_disorientasi" id="status_mental_disorientasi" value="1" type="radio" <?php if($status_mental_disorientasi == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="status_mental_disorientasi" id="status_mental_disorientasi" value="2" type="radio" <?php if($status_mental_disorientasi == '2') echo 'checked="checked"'; ?> >Tidak
			</td>			
		</tr>
		<tr>
			<td>Apakah pasien mengalami agitasi ? (ketakutan, gelisah dan cemas)</td>
			<td align="center">
				<input name="status_mental_agitasi" id="status_mental_agitasi" value="1" type="radio" <?php if($status_mental_agitasi == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="status_mental_agitasi" id="status_mental_agitasi" value="2" type="radio" <?php if($status_mental_agitasi == '2') echo 'checked="checked"'; ?>>Tidak
			</td>			
		</tr>
		<tr>
			<td rowspan="3" valign="top" style="padding-top:15px; ">PENGLIHATAN</td>
			<td>Apakah pasien memakai kacamata ?</td>
			<td align="center">
				<input name="penglihatan_kacamata" id="penglihatan_kacamata" value="1" type="radio" <?php if($penglihatan_kacamata == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="penglihatan_kacamata" id="penglihatan_kacamata" value="2" type="radio" <?php if($penglihatan_kacamata == '2') echo 'checked="checked"'; ?> >Tidak
			</td>
			<td rowspan="3" >Salah satu jawaban Ya = 1</td>
		</tr>
		<tr>
			<td>Apakah pasien mengeluh adanya penglihatan buram ?</td>
			<td align="center">
				<input name="penglihatan_buram" id="penglihatan_buram" value="1" type="radio" <?php if($penglihatan_buram == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="penglihatan_buram" id="penglihatan_buram" value="2" type="radio" <?php if($penglihatan_buram == '2') echo 'checked="checked"'; ?> >Tidak
			</td>			
		</tr>
		<tr>
			<td>Apakah pasien mempunyai glokoma, katarak atau degerasi makula ?</td>
			<td align="center">
				<input name="penglihatan_glukoma" id="penglihatan_glukoma" value="1" type="radio" <?php if($penglihatan_glukoma == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="penglihatan_glukoma" id="penglihatan_glukoma" value="2" type="radio" <?php if($penglihatan_glukoma == '2') echo 'checked="checked"'; ?> >Tidak
			</td>			
		</tr>
		<tr>
			<td>KEBIASAAN BERKEMIH</td>
			<td>Apakah terdapat perubahan perilaku berkemih ? (frekuensi, urgensi, inkontinensia, nokturia)</td>
			<td align="center" nowrap>
				<input name="kebiasaan_berkemih" id="kebiasaan_berkemih" value="1" type="radio" <?php if($kebiasaan_berkemih == '1') echo 'checked="checked"'; ?> >Ya&nbsp;&nbsp;			
				<input name="kebiasaan_berkemih" id="kebiasaan_berkemih" value="2" type="radio" <?php if($kebiasaan_berkemih == '2') echo 'checked="checked"'; ?> >Tidak
			</td>
			<td>Salah satu jawaban Ya = 2</td>
		</tr>
		<tr>
			<td rowspan="4" valign="top" style="padding-top:15px; ">TRANSFER (dari tempat tidur ke kursi dan kembali ke tempat tidur)</td>
			<td>Mandiri (boleh menggunakan alat bantu)</td>
			<td align="center">
				<input name="transfer_mandiri" id="transfer_mandiri" value="1" type="checkbox" <?php if($transfer_mandiri == '1') echo 'checked="checked"'; ?> >&nbsp;0			
			</td>
			<td rowspan="4">Jumlah nilai Transfer dan Mobilitas.<br><br>Jika nilai total 0-3 maka skor = 0</td>
		</tr>
		<tr>
			<td>Memerlukan sedikir bantuan (1 orang) / dalam pengawasan</td>
			<td align="center">
				<input name="transfer_bantuan_1_orang" id="transfer_bantuan_1_orang" value="1" type="checkbox" <?php if($transfer_bantuan_1_orang == '1') echo 'checked="checked"'; ?> >&nbsp;1			
			</td>			
		</tr>
		<tr>
			<td>Memerlukan bantuan yang nyata (2 orang)</td>
			<td align="center">
				<input name="transfer_bantuan_2_orang" id="transfer_bantuan_2_orang" value="1" type="checkbox" <?php if($transfer_bantuan_2_orang == '1') echo 'checked="checked"'; ?> >&nbsp;2
			</td>			
		</tr>
		<tr>
			<td>Tidak dapat duduk dengan simbang, perlu bantuan total</td>
			<td align="center">
				<input name="transfer_bantuan_total" id="transfer_bantuan_total" value="1" type="checkbox" <?php if($transfer_bantuan_total == '1') echo 'checked="checked"'; ?> >&nbsp;3
			</td>			
		</tr>
		<tr>
			<td rowspan="4" valign="top" style="padding-top:15px; ">MOBILITAS</td>
			<td>Mandiri (boleh menggunakan alat bantu jalan)</td>
			<td align="center">
				<input name="mobilitas_mandiri" id="mobilitas_mandiri" value="1" type="checkbox" <?php if($mobilitas_mandiri == '1') echo 'checked="checked"'; ?> >&nbsp;0			
			</td>
			<td rowspan="4">Jika nilai total 4-6 maka skor = 7</td>
		</tr>
		<tr>
			<td>Berjalan dengan bantuan 1 orang (verbal / fisik)</td>
			<td align="center">
				<input name="mobilitas_bantuan_1_orang" id="mobilitas_bantuan_1_orang" value="1" type="checkbox" <?php if($mobilitas_bantuan_1_orang == '1') echo 'checked="checked"'; ?> >&nbsp;1			
			</td>			
		</tr>
		<tr>
			<td>Menggunakan kursi roda</td>
			<td align="center">
				<input name="mobilitas_kursi_roda" id="mobilitas_kursi_roda" value="1" type="checkbox" <?php if($mobilitas_kursi_roda == '1') echo 'checked="checked"'; ?> >&nbsp;2
			</td>			
		</tr>
		<tr>
			<td>Immobilisasi</td>
			<td align="center">
				<input name="immobilisasi" id="immobilisasi" value="1" type="checkbox" <?php if($immobilisasi == '1') echo 'checked="checked"'; ?> >&nbsp;3
			</td>			
		</tr>
		<tr>
			<td colspan="3" style=" font-weight:bold;">TOTAL SKOR</td>
			<td width="5" align="center"><?php echo $skor; ?></td>			
		</tr>	
    </table>
</form>