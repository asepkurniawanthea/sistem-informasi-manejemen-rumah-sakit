<?php
$irja_id = $_GET['idx'];
$qry_askep = 'SELECT t_irja_askep.IRJA_ASKEP_ID,t_irja_askep.KELUHAN_UTAMA,t_irja_askep.RIWAYAT_PENYAKIT,
				t_irja_askep.RIWAYAT_PENYAKIT_KELUARGA,t_irja_askep.GENOGRAM,t_irja_askep.TEKANAN_DARAH,
				t_irja_askep.FREKUENSI_NAFAS,t_irja_askep.SUHU_TUBUH,t_irja_askep.FREKUENSI_NADI,
				t_irja_askep.BERAT_BADAN,t_irja_askep.TINGGI_BADAN,t_irja_askep.PEMERIKSA_FISIK_TERKAIT_KELUHAN,
				t_irja_askep.HUBUNGAN_KELUARGA,t_irja_askep.STATUS_PSIKOLOGIS,
				t_irja_askep.KETERANGAN_STATUS_PSIKOLOGIS,t_irja_askep.PENURUNAN_BERAT_BADAN,t_irja_askep.TIDAK_NAFSU_MAKAN,
				t_irja_askep.DIAGNOSIS_KHUSUS,t_irja_askep.KETERANGAN_DIAGNOSIS_KHUSUS,t_irja_askep.STATUS_FUNGSIONAL,
				t_irja_askep.KETERANGAN_STATUS_FUNGSIONAL,t_irja_askep.CARA_BERJALAN,t_irja_askep.CARA_DUDUK,t_irja_askep.NYERI,
				t_irja_askep.SKALA_NYERI,t_irja_askep.LOKASI_NYERI,t_irja_askep.DURASI_NYERI,t_irja_askep.FREKUENSI_NYERI,
				t_irja_askep.NYERI_HILANG,t_irja_askep.KETERANGAN_NYERI_HILANG,t_irja_askep.ST_SELESAI
				FROM t_irja_askep
				WHERE t_irja_askep.IRJA_ASKEP_ID = "' . $irja_id . '"';
$get_askep = mysql_query($qry_askep);
$dat_askep = mysql_fetch_assoc($get_askep);

$keluhan_utama = $dat_askep['KELUHAN_UTAMA']; 
$riwayat_penyakit = $dat_askep['RIWAYAT_PENYAKIT']; 
$riwayat_penyakit_keluarga = $dat_askep['RIWAYAT_PENYAKIT_KELUARGA']; 
$genogram = $dat_askep['GENOGRAM']; 
$tekanan_darah = $dat_askep['TEKANAN_DARAH']; 
$frekuensi_nafas = $dat_askep['FREKUENSI_NAFAS']; 
$suhu_tubuh = $dat_askep['SUHU_TUBUH']; 
$frekuensi_nadi = $dat_askep['FREKUENSI_NADI']; 
$berat_badan = $dat_askep['BERAT_BADAN']; 
$tinggi_badan = $dat_askep['TINGGI_BADAN']; 
$pemeriksaan_fisik_terkait_keluhan = $dat_askep['PEMERIKSA_FISIK_TERKAIT_KELUHAN']; 
$hubungan_keluarga = $dat_askep['HUBUNGAN_KELUARGA']; 
$status_psikologis = $dat_askep['STATUS_PSIKOLOGIS']; 
$keterangan_status_psikologis = $dat_askep['KETERANGAN_STATUS_PSIKOLOGIS']; 
$penurunan_berat_badan = $dat_askep['PENURUNAN_BERAT_BADAN']; 
$tidak_nafsu_makan = $dat_askep['TIDAK_NAFSU_MAKAN']; 
$diagnosis_khusus = $dat_askep['DIAGNOSIS_KHUSUS']; 
$keterangan_diagnosis_khusus = $dat_askep['KETERANGAN_DIAGNOSIS_KHUSUS'];
$status_fungsional = $dat_askep['STATUS_FUNGSIONAL'];
$keterangan_status_fungsional = $dat_askep['KETERANGAN_STATUS_FUNGSIONAL'];
$cara_berjalan = $dat_askep['CARA_BERJALAN'];
$cara_duduk = $dat_askep['CARA_DUDUK'];
$nyeri = $dat_askep['NYERI'];
$skala_nyeri = $dat_askep['SKALA_NYERI'];
$lokasi_nyeri = $dat_askep['LOKASI_NYERI'];
$durasi_nyeri = $dat_askep['DURASI_NYERI'];
$frekuensi_nyeri = $dat_askep['FREKUENSI_NYERI'];
$nyeri_hilang = $dat_askep['NYERI_HILANG'];
$keterangan_nyeri_hilang = $dat_askep['KETERANGAN_NYERI_HILANG'];

$selesai = '';
if($dat_askep['ST_SELESAI'] == '1') $selesai = '1';
?>
    <table border="0">
        <tr>
            <td valign="top">Keluhan Utama</td>
            <td colspan="3">
                <textarea name="keluhan_utama" id="keluhan_utama" cols="80" rows="5" class="text_dt2"><?php echo $keluhan_utama; ?></textarea>
            </td>
        </tr>
        <tr>
            <td valign="top">Riwayat Penyakit Dahulu</td>
            <td colspan="3">
                <textarea name="riwayat_penyakit" id="riwayat_penyakit" cols="80" rows="5" class="text_dt2"><?php echo $riwayat_penyakit; ?></textarea>
            </td>
        </tr>
        <tr>
            <td valign="top">Riwayat Penyakit Keluarga</td>
            <td colspan="3">
                <textarea name="riwayat_penyakit_keluarga" id="riwayat_penyakit_keluarga" cols="80" rows="5" class="text_dt2"><?php echo $riwayat_penyakit_keluarga; ?></textarea>
            </td>
        </tr>
		<tr>
            <td valign="top">Genogram</td>
            <td colspan="3">
                <textarea name="genogram" id="genogram" cols="80" rows="5" class="text_dt2"><?php echo $genogram; ?></textarea>
            </td>
        </tr>
		<tr>
            <td valign="top">Pemeriksaan Fisik</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Tekanan Darah</td>
					<td><input type="text" name="tekanan_darah" value="<?php echo $tekanan_darah; ?>" class="text_dt" />&nbsp;mmHg</td>
					<td width="50px">&nbsp;</td>
					<td>Frekuensi Nafas</td>
					<td><input type="text" name="frekuensi_nafas" value="<?php echo $frekuensi_nafas; ?>" class="text_dt" />&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Suhu Tubuh</td>
					<td><input type="text" name="suhu_tubuh" value="<?php echo $suhu_tubuh; ?>" class="text_dt" />&nbsp;oC</td>
					<td width="50px">&nbsp;</td>
					<td>Frekuensi Nadi</td>
					<td><input type="text" name="frekuensi_nadi" value="<?php echo $frekuensi_nadi; ?>" class="text_dt" />&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Berat Badan</td>
					<td><input type="text" name="berat_badan" value="<?php echo $berat_badan; ?>" class="text_dt" />&nbsp;Kg</td>
					<td width="50px">&nbsp;</td>
					<td>Tinggi Badan</td>
					<td><input type="text" name="tinggi_badan" value="<?php echo $tinggi_badan; ?>" class="text_dt" />&nbsp;Cm</td>
				</tr>	
				<tr>	
					<td>Pemeriksaan Fisik <br>Terkait Keluhan Utama</td>
					<td colspan="4"><textarea name="pemeriksaan_fisik_terkait_keluhan" class="text_dt3" ><?php echo $pemeriksaan_fisik_terkait_keluhan; ?></textarea></td>
				</tr>	
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Riwayat Psikososial</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Hubungan Dgn Anggota Keluarga</td>
					<td><input type="radio" name="hubungan_keluarga" value="Baik" class="text_dt" 
					<?php if($hubungan_keluarga == 'Baik') echo 'checked="checked"'; ?>/>&nbsp;Baik
					&nbsp;&nbsp;<input type="radio" name="hubungan_keluarga" value="Tidak Baik" class="text_dt" 
					<?php if($hubungan_keluarga == 'Tidak Baik') echo 'checked="checked"'; ?> />&nbsp;Tidak Baik</td>
				</tr>	
				<tr>	
					<td>Status Psikologis</td>
					<td><input type="radio" name="status_psikologis" value="Tenang" class="text_dt" 
					<?php if($status_psikologis == 'Tenang') echo 'checked="checked"'; ?>/>&nbsp;Tenang
					<input type="radio" name="status_psikologis" value="Cemas" class="text_dt" 
					<?php if($status_psikologis == 'Cemas') echo 'checked="checked"'; ?>/>&nbsp;Cemas
					<input type="radio" name="status_psikologis" value="Takut" class="text_dt" 
					<?php if($status_psikologis == 'Takut') echo 'checked="checked"'; ?>/>&nbsp;Takut
					<br>
					<input type="radio" name="status_psikologis" value="Marah" class="text_dt" 
					<?php if($status_psikologis == 'Marah') echo 'checked="checked"'; ?>/>&nbsp;Marah
					<input type="radio" name="status_psikologis" value="Sedih" class="text_dt" 
					<?php if($status_psikologis == 'Sedih') echo 'checked="checked"'; ?>/>&nbsp;Sedih
					<input type="radio" name="status_psikologis" value="Kecendrungan Bunuh" class="text_dt" 
					<?php if($status_psikologis == 'Kecendrungan Bunuh') echo 'checked="checked"'; ?>/>&nbsp;Kecendrungan Bunuh
					<input type="radio" name="status_psikologis" value="Lain-lain" class="text_dt" 
					<?php if($status_psikologis == 'Lain-lain') echo 'checked="checked"'; ?>/>&nbsp;Lain-lain</td>
				</tr>	
				<tr>	
					<td>Sebutkan</td>
					<td colspan="4"><textarea name="keterangan_status_psikologis" class="text_dt3" ><?php echo $keterangan_status_psikologis; ?></textarea></td>
				</tr>	
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Skrining Gizi</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Berdasarkan Malnutrition Screening Tooll</td>
					<td>&nbsp;</td>
					<td width="50px">&nbsp;</td>
				</tr>
				<tr>	
					<td colspan="2"><i>Parameter</i></td>
					<td width="50px"><i>Skors</i></td>
				</tr>	
				<tr>	
					<td>Apakah Pasien Mengalami Penurunan BB<br>Dlm 6 Bulan Terakhir?</td>
					<td><input type="radio" name="penurunan_berat_badan" value="Tidak Ada" class="text_dt" 
					<?php if($penurunan_berat_badan == 'Tidak Ada') echo 'checked="checked"'; ?>/>&nbsp;Tidak Ada Penurunan BB</td>
					<td width="50px" align="center">0</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="radio" name="penurunan_berat_badan" value="Tidak Yakin" class="text_dt" 
					<?php if($penurunan_berat_badan == 'Tidak Yakin') echo 'checked="checked"'; ?>/>&nbsp;Tidak Yakin /Tidak Tahu /Baju Terasa Longgar</td>
					<td width="50px" align="center">2</td>
				</tr>
				<tr>	
					<td>Jika Ya, Berapa Penurunan Berat Badan Tersebut</td>
					<td><input type="radio" name="penurunan_berat_badan" value="Ada|1 - 5 kg" class="text_dt" 
					<?php if($penurunan_berat_badan == 'Ada|1 - 5 kg') echo 'checked="checked"'; ?>/>&nbsp;1 - 5 kg</td>
					<td width="50px" align="center">1</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="radio" name="penurunan_berat_badan" value="Ada|6 - 10 kg" class="text_dt" 
					<?php if($penurunan_berat_badan == 'Ada|6 - 10 kg') echo 'checked="checked"'; ?>/>&nbsp;6 - 10 kg</td>
					<td width="50px" align="center">2</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="radio" name="penurunan_berat_badan" value="Ada|- 15 kg" class="text_dt" 
					<?php if($penurunan_berat_badan == 'Ada|- 15 kg') echo 'checked="checked"'; ?>/>&nbsp;- 15 kg</td>
					<td width="50px" align="center">3</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="radio" name="penurunan_berat_badan" value="Ada|> 15 kg" class="text_dt" 
					<?php if($penurunan_berat_badan == 'Ada|> 15 kg') echo 'checked="checked"'; ?>/>&nbsp;> 15 kg</td>
					<td width="50px" align="center">4</td>
				</tr>
				<tr>	
					<td>Apakah Asupan Makanan Berkurang<br>Karena Tdk Nafsu makan?</td>
					<td><input type="radio" name="tidak_nafsu_makan" value="Tidak" class="text_dt" 
					<?php if($tidak_nafsu_makan == 'Tidak') echo 'checked="checked"'; ?>/>&nbsp;Tidak
					</td>
					<td width="50px" align="center">0</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="radio" name="tidak_nafsu_makan" value="Ya" class="text_dt" 
					<?php if($tidak_nafsu_makan == 'Ya') echo 'checked="checked"'; ?>/>&nbsp;Ya
					</td>
					<td width="50px" align="center">1</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td align="right"><i>Total Skors</i>&nbsp;</td>
					<td width="50px" align="center">&nbsp;</td>
				</tr>
				<tr>	
					<td>Pasien Dgn Diagnosis Khusus</td>
					<td><input type="radio" name="diagnosis_khusus" value="Ya" class="text_dt" 
					<?php if($diagnosis_khusus == 'Ya') echo 'checked="checked"'; ?>/>&nbsp;Ya
					<input type="radio" name="diagnosis_khusus" value="Tidak" class="text_dt" 
					<?php if($diagnosis_khusus == 'Tidak') echo 'checked="checked"'; ?>/>&nbsp;Tidak</td>
					<td width="50px" align="center">&nbsp;</td>
				</tr>
				<tr>	
					<td>DM/ Kemoterapi/ Hemodialisa/ Geriatri/ <br>Imunitas Menurun/ Lain-lain</td>
					<td colspan="2"><textarea name="keterangan_diagnosis_khusus" class="text_dt3" ><?php echo $keterangan_diagnosis_khusus; ?></textarea></td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Status Fungsional</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td colspan="2"><input type="radio" name="status_fungsional" value="Mandiri" class="text_dt" 
					<?php if($status_fungsional == 'Mandiri') echo 'checked="checked"'; ?>/>&nbsp;Mandiri
					<input type="radio" name="status_fungsional" value="Perlu Bantuan" class="text_dt" 
					<?php if($status_fungsional == 'Perlu Bantuan') echo 'checked="checked"'; ?>/>&nbsp;Perlu Bantuan</td>
				</tr>
				<tr>	
					<td>Sebutkan</td>
					<td><textarea name="keterangan_status_fungsional" class="text_dt3" ><?php echo $keterangan_status_fungsional; ?></textarea></td>
				</tr>	
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Skrining Resiko Cedera/ Jatuh</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Perhatikan Cara Berjalan Saat Akan Duduk Di Kursi<br>Apakah Pasien Tampak Tdk Seimbang</td>
					<td colspan="2"><input type="radio" name="cara_berjalan" value="Ya" class="text_dt" 
					<?php if($cara_berjalan == 'Ya') echo 'checked="checked"'; ?>/>&nbsp;Ya
					<input type="radio" name="cara_berjalan" value="Tidak" class="text_dt" 
					<?php if($cara_berjalan == 'Tidak') echo 'checked="checked"'; ?>/>&nbsp;Tidak</td>
				</tr>
				<tr>	
					<td>Apakah Pasien Memegang Pinggiran Kursi/ Meja/ Benda Lain<br>Sebaga Penopang Saat Akan Duduk</td>
					<td colspan="2"><input type="radio" name="cara_duduk" value="Ya" class="text_dt" 
					<?php if($cara_duduk == 'Ya') echo 'checked="checked"'; ?>/>&nbsp;Ya
					<input type="radio" name="cara_duduk" value="Tidak" class="text_dt" 
					<?php if($cara_duduk == 'Tidak') echo 'checked="checked"'; ?>/>&nbsp;Tidak</td>
				</tr>
				<tr>	
					<td>Hasil :</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Skrining Nyeri</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td colspan="2"><input type="radio" name="nyeri" value="Tidak Ada" class="text_dt" 
					<?php if($nyeri == 'Tidak Ada') echo 'checked="checked"'; ?>/>&nbsp;Tidak Ada
					<input type="radio" name="nyeri" value="Nyeri Kronis" class="text_dt" 
					<?php if($nyeri == 'Nyeri Kronis') echo 'checked="checked"'; ?>/>&nbsp;Nyeri Kronis
					<input type="radio" name="nyeri" value="Nyeri Akut" class="text_dt" 
					<?php if($nyeri == 'Nyeri Akut') echo 'checked="checked"'; ?>/>&nbsp;Nyeri Akut</td>
				</tr>
				<tr>	
					<td>Skala Nyeri</td>
					<td><input type="radio" name="skala_nyeri" value="0" class="text_dt" <?php if($skala_nyeri == '0') echo 'checked="checked"'; ?> />&nbsp;0
					<input type="radio" name="skala_nyeri" value="1" class="text_dt" <?php if($skala_nyeri == '1') echo 'checked="checked"'; ?> />&nbsp;1
					<input type="radio" name="skala_nyeri" value="2" class="text_dt" <?php if($skala_nyeri == '2') echo 'checked="checked"'; ?> />&nbsp;2
					<input type="radio" name="skala_nyeri" value="3" class="text_dt" <?php if($skala_nyeri == '3') echo 'checked="checked"'; ?> />&nbsp;3
					<input type="radio" name="skala_nyeri" value="4" class="text_dt" <?php if($skala_nyeri == '4') echo 'checked="checked"'; ?> />&nbsp;4
					<input type="radio" name="skala_nyeri" value="5" class="text_dt" <?php if($skala_nyeri == '5') echo 'checked="checked"'; ?> />&nbsp;5
					<input type="radio" name="skala_nyeri" value="6" class="text_dt" <?php if($skala_nyeri == '6') echo 'checked="checked"'; ?> />&nbsp;6
					<input type="radio" name="skala_nyeri" value="7" class="text_dt" <?php if($skala_nyeri == '7') echo 'checked="checked"'; ?> />&nbsp;7
					<input type="radio" name="skala_nyeri" value="8" class="text_dt" <?php if($skala_nyeri == '8') echo 'checked="checked"'; ?> />&nbsp;8
					<input type="radio" name="skala_nyeri" value="9" class="text_dt" <?php if($skala_nyeri == '9') echo 'checked="checked"'; ?> />&nbsp;9
					<input type="radio" name="skala_nyeri" value="10" class="text_dt" <?php if($skala_nyeri == '10') echo 'checked="checked"'; ?> />&nbsp;10</td>
				</tr>
				<tr>	
					<td>Lokasi</td>
					<td><input type="text" name="lokasi_nyeri" value="<?php echo $lokasi_nyeri; ?>" class="text_dt" /></td>
				</tr>	
				<tr>	
					<td>Durasi</td>
					<td><input type="text" name="durasi_nyeri" value="<?php echo $durasi_nyeri; ?>" class="text_dt" /></td>
				</tr>
				<tr>	
					<td>Frekuensi</td>
					<td><input type="text" name="frekuensi_nyeri" value="<?php echo $frekuensi_nyeri; ?>" class="text_dt" /></td>
				</tr>
				<tr>	
					<td>Nyeri Hilang Bila</td>
					<td><input type="radio" name="nyeri_hilang" value="Minum Obat" class="text_dt" 
					<?php if($nyeri_hilang == 'Minum Obat') echo 'checked="checked"'; ?>/>&nbsp;Minum Obat
					<input type="radio" name="nyeri_hilang" value="Istirahat" class="text_dt" 
					<?php if($nyeri_hilang == 'Istirahat') echo 'checked="checked"'; ?>/>&nbsp;Istirahat
					<input type="radio" name="nyeri_hilang" value="Mendengar Musik" class="text_dt" 
					<?php if($nyeri_hilang == 'Mendengar Musik') echo 'checked="checked"'; ?> />&nbsp;Mendengar Musik
					<input type="radio" name="nyeri_hilang" value="Berubah Posisi" class="text_dt" 
					<?php if($nyeri_hilang == 'Berubah Posisi') echo 'checked="checked"'; ?>/>&nbsp;Berubah Posisi/ Tidur
					<input type="radio" name="nyeri_hilang" value="Lain-lain" class="text_dt" 
					<?php if($nyeri_hilang == 'Lain-lain') echo 'checked="checked"'; ?>/>&nbsp;Lain-lain</td>
				</tr>
				<tr>	
					<td>Sebutkan</td>
					<td><textarea name="keterangan_nyeri_hilang" class="text_dt3" ><?php echo $keterangan_nyeri_hilang; ?></textarea></td>
				</tr>
				 <tr><td colspan="4" align="right">
					<input type="checkbox" name="selesai" value="1" <?php if($selesai == '1') echo 'checked="checked"'; ?> />&nbsp;Selesai</td>
					</tr>
				</table>
            </td>
        </tr>
    </table>