<?php
$irja_id = $_GET['idx'];
if (isset($_POST['irja_id']))
    include('klinik/klinik_save_askep.php');

$qry_askep = 'SELECT t_irja_askep.IRJA_ASKEP_ID,t_irja_askep.KELUHAN_UTAMA,t_irja_askep.RIWAYAT_PENYAKIT,
				t_irja_askep.RIWAYAT_PENYAKIT_KELUARGA,t_irja_askep.GENOGRAM,t_irja_askep.TEKANAN_DARAH,
				t_irja_askep.FREKUENSI_NAFAS,t_irja_askep.SUHU_TUBUH,t_irja_askep.FREKUENSI_NADI,
				t_irja_askep.BERAT_BADAN,t_irja_askep.TINGGI_BADAN,t_irja_askep.PEMERIKSA_FISIK_TERKAIT_KELUHAN,
				t_irja_askep.HUBUNGAN_KELUARGA,t_irja_askep.STATUS_PSIKOLOGIS,
				t_irja_askep.KETERANGAN_STATUS_PSIKOLOGIS,t_irja_askep.PENURUNAN_BERAT_BADAN,t_irja_askep.TIDAK_NAFSU_MAKAN,
				t_irja_askep.DIAGNOSIS_KHUSUS,t_irja_askep.KETERANGAN_DIAGNOSIS_KHUSUS,t_irja_askep.STATUS_FUNGSIONAL,
				t_irja_askep.KETERANGAN_STATUS_FUNGSIONAL,t_irja_askep.CARA_BERJALAN,t_irja_askep.CARA_DUDUK,t_irja_askep.NYERI,
				t_irja_askep.SKALA_NYERI,t_irja_askep.LOKASI_NYERI,t_irja_askep.DURASI_NYERI,t_irja_askep.FREKUENSI_NYERI,
				t_irja_askep.NYERI_HILANG,t_irja_askep.KETERANGAN_NYERI_HILANG,t_irja_askep.ST_SELESAI,
				t_irja_askep.STATUS_PSIKOLOGIS_BUNUH_DIRI,
				t_irja_askep.DIAGNOSA_KHUSUS_DM,t_irja_askep.DIAGNOSA_KHUSUS_KEMOTERAPI,
				t_irja_askep.DIAGNOSA_KHUSUS_HEMODIALISA,t_irja_askep.DIAGNOSA_KHUSUS_GERIATRI,
				t_irja_askep.DIAGNOSA_KHUSUS_IMUNITAS,t_irja_askep.DIAGNOSA_KHUSUS_LAIN,
				t_irja_askep.KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,
				t_irja_askep.RESIKO_JATUH,t_irja_askep.KETERANGAN_RESIKO_JATUH,
				t_irja_askep.STATUS_NYERI_HILANG,t_irja_askep.KETERANGAN_STATUS_NYERI_HILANG,
				t_irja_askep.RIWAYAT_ALERGI_OBAT,t_irja_askep.DIAGNOSA_KEPERAWATAN,
				t_irja_askep.RENCANA_KEPERAWATAN,t_irja_askep.IMPELEMENTASI_KEPERAWATAN,
				t_irja_askep.EVALUASI_KEPERAWATAN,
				t_irja_askep.ST_SELESAI,DATE_FORMAT(t_irja_askep.TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
				DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,
				t_irja_askep.PEMICU_NYERI,
				t_irja_askep.KUALITAS_NYERI
				FROM t_irja_askep
				WHERE t_irja_askep.IRJA_ASKEP_ID = "' . $irja_id . '"';
$get_askep = mysql_query($qry_askep);
$dat_askep = mysql_fetch_assoc($get_askep);

$idx_askep = $dat_askep['IRJA_ASKEP_ID']; 
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
$pemicu_nyeri = $dat_askep['PEMICU_NYERI'];
$kualitas_nyeri = $dat_askep['KUALITAS_NYERI'];
$nyeri_hilang = $dat_askep['NYERI_HILANG'];
$keterangan_nyeri_hilang = $dat_askep['KETERANGAN_NYERI_HILANG'];

$status_bunuh_diri = $dat_askep['STATUS_PSIKOLOGIS_BUNUH_DIRI'];
$diagnosis_khusus_dm = $dat_askep['DIAGNOSA_KHUSUS_DM'];
$diagnosis_khusus_kemoterapi = $dat_askep['DIAGNOSA_KHUSUS_KEMOTERAPI'];
$diagnosis_khusus_hemodialisa = $dat_askep['DIAGNOSA_KHUSUS_HEMODIALISA'];
$diagnosis_khusus_geriatri = $dat_askep['DIAGNOSA_KHUSUS_GERIATRI'];
$diagnosis_khusus_imunitas = $dat_askep['DIAGNOSA_KHUSUS_IMUNITAS'];
$diagnosis_khusus_lain = $dat_askep['DIAGNOSA_KHUSUS_LAIN'];
$keterangan_status_fungsional_ketergantungan = $dat_askep['KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN'];
$resiko_jatuh = $dat_askep['RESIKO_JATUH'];
$keterangan_resiko_jatuh = $dat_askep['KETERANGAN_RESIKO_JATUH'];

$status_nyeri_hilang = $dat_askep['STATUS_NYERI_HILANG'];
$keterangan_status_nyeri_hilang = $dat_askep['KETERANGAN_STATUS_NYERI_HILANG'];
$riwayat_alergi_obat = $dat_askep['RIWAYAT_ALERGI_OBAT'];
$diagnosa_keperawatan = $dat_askep['DIAGNOSA_KEPERAWATAN'];
$rencana_keperawatan = $dat_askep['RENCANA_KEPERAWATAN'];
$implementasi_keperawatan = $dat_askep['IMPELEMENTASI_KEPERAWATAN'];
$evaluasi_keperawatan = $dat_askep['EVALUASI_KEPERAWATAN'];

$selesai = $dat_askep['ST_SELESAI'];
$tgl_assesment = $dat_askep['TGL_ASSESMENT'];
$tgl_skr = $dat_askep['TGL_SKR'];
?>
<form name="formrujukan" id="formrujukan" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />
    <input type="hidden" name="nomr" id="nomr" value="<?php echo $nomr; ?>" />
	<input type="hidden" name="idx_askep" id="idx_askep" value="<?php echo $idx_askep; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $selesai; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
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
		<!--<tr>
            <td valign="top">Genogram</td>
            <td colspan="3">
                <textarea name="genogram" id="genogram" cols="80" rows="5" class="text_dt2"><?php echo $genogram; ?></textarea>
            </td>
        </tr>-->
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
					<?php if($status_psikologis == 'Kecendrungan Bunuh') echo 'checked="checked"'; ?>/>&nbsp;Kecendrungan Bunuh Diri
					Dilaporkan Ke&nbsp;&nbsp;<input type="text" name="status_bunuh_diri" value="<?php echo $status_bunuh_diri; ?>" class="text_dt" />
					<br />
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
					<td>&nbsp;</td>
					<td><input type="radio" name="penurunan_berat_badan" value="Ada|Tidak Tahu" class="text_dt" 
					<?php if($penurunan_berat_badan == 'Ada|Tidak Tahu') echo 'checked="checked"'; ?>/>&nbsp;Tidak tahu berapa kg penurunannya</td>
					<td width="50px" align="center">2</td>
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
					<td width="50px" align="center">
					<?php
					$skor = 0;
					if($penurunan_berat_badan == 'Tidak Ada') $skor = $skor + 0;
					if($penurunan_berat_badan == 'Tidak Yakin') $skor = $skor + 2;
					if($penurunan_berat_badan == 'Ada|1 - 5 kg') $skor = $skor + 1;
					if($penurunan_berat_badan == 'Ada|6 - 10 kg') $skor = $skor + 2;
					if($penurunan_berat_badan == 'Ada|- 15 kg') $skor = $skor + 3;
					if($penurunan_berat_badan == 'Ada|> 15 kg') $skor = $skor + 4;
					if($penurunan_berat_badan == 'Ada|Tidak Tahu') $skor = $skor + 2;
					if($tidak_nafsu_makan == 'Tidak') $skor = $skor + 0;
					if($tidak_nafsu_makan == 'Ya') $skor = $skor + 1;
					echo $skor;
					?>
					</td>
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
					<td><input type="checkbox" name="diagnosis_khusus_dm" value="1" class="text_dt" <?php if($diagnosis_khusus_dm == '1') echo 'checked="checked"'; ?> />DM
					<input type="checkbox" name="diagnosis_khusus_kemoterapi" value="1" class="text_dt" <?php if($diagnosis_khusus_kemoterapi == '1') echo 'checked="checked"'; ?> />Kemoterapi
					<input type="checkbox" name="diagnosis_khusus_hemodialisa" value="1" class="text_dt" <?php if($diagnosis_khusus_hemodialisa == '1') echo 'checked="checked"'; ?> />Hemodialisa
					<input type="checkbox" name="diagnosis_khusus_geriatri" value="1" class="text_dt" <?php if($diagnosis_khusus_geriatri == '1') echo 'checked="checked"'; ?> />Geriatri
					<input type="checkbox" name="diagnosis_khusus_imunitas" value="1" class="text_dt" <?php if($diagnosis_khusus_imunitas == '1') echo 'checked="checked"'; ?> />Imunitas Menurun
					</td>
					<td colspan="2"><input type="checkbox" name="diagnosis_khusus_lain" value="1" class="text_dt" <?php if($diagnosis_khusus_lain == '1') echo 'checked="checked"'; ?> />Lain-lain
					<input type="text" name="keterangan_diagnosis_khusus" class="text_dt" value="<?php echo $keterangan_diagnosis_khusus; ?>" size="40" /></td>
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
					<?php if($status_fungsional == 'Perlu Bantuan') echo 'checked="checked"'; ?>/>&nbsp;Perlu Bantuan, Sebutkan&nbsp;
					<input type="text" name="keterangan_status_fungsional" class="text_dt" value="<?php echo $keterangan_status_fungsional; ?>" size="47" /></td>
				</tr>
				<tr>	
					<td colspan="2"><input type="radio" name="status_fungsional" value="Ketergantungan Total" class="text_dt" 
					<?php if($status_fungsional == 'Ketergantungan Total') echo 'checked="checked"'; ?>/>&nbsp;Ketergantungan Total, Dilaporkan Ke Dokter Pukul&nbsp;
					<input type="text" name="keterangan_status_fungsional_ketergantungan" class="text_dt" value="<?php echo $keterangan_status_fungsional_ketergantungan; ?>" size="47" /></td>
				</tr>
				<tr>	
					
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
					<td>Hasil : 
					<?php
					if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Tidak')) echo 'Tidak Berisiko';
					if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Ya')) echo 'Risiko Tinggi';
					if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Ya')) echo 'Risiko Rendah';
					if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Tidak')) echo 'Risiko Rendah';
					?>
					</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>	
					<td>Diberitahukan Ke Dokter</td>
					<td colspan="2"><input type="radio" name="resiko_jatuh" value="Ya" class="text_dt" 
					<?php if($resiko_jatuh == 'Ya') echo 'checked="checked"'; ?>/>&nbsp;Ya, Pukul &nbsp; <input type="text" name="keterangan_resiko_jatuh" class="text_dt" value="<?php echo $keterangan_resiko_jatuh; ?>" size="20" />
					<input type="radio" name="resiko_jatuh" value="Tidak" class="text_dt" 
					<?php if($resiko_jatuh == 'Tidak') echo 'checked="checked"'; ?>/>&nbsp;Tidak</td>
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
					<td colspan="2" align="center">
						<img src="edoc_rekammedik/new/skala_nyeri.jpg" width="650px" />
					</td>
				</tr>
				<tr>	
					<td>Durasi & Frekuensi</td>
					<td><input type="text" name="frekuensi_nyeri" value="<?php echo $frekuensi_nyeri; ?>" class="text_dt" /></td>
				</tr>
				<tr>	
					<td>Pemicu</td>
					<td><input type="text" name="pemicu_nyeri" value="<?php echo $pemicu_nyeri; ?>" class="text_dt" /></td>
				</tr>
				<tr>	
					<td>Kualitas</td>
					<td><input type="text" name="kualitas_nyeri" value="<?php echo $kualitas_nyeri; ?>" class="text_dt" /></td>
				</tr>
				<tr>	
					<td>Lokasi</td>
					<td><input type="text" name="lokasi_nyeri" value="<?php echo $lokasi_nyeri; ?>" class="text_dt" /></td>
				</tr>	
				<!--<tr>	
					<td>Durasi</td>
					<td><input type="text" name="durasi_nyeri" value="<?php echo $durasi_nyeri; ?>" class="text_dt" /></td>
				</tr>-->
				
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
				<tr>	
					<td>Diberitahukan Ke Dokter</td>
					<td><input type="radio" name="status_nyeri_hilang" value="Ya" class="text_dt" 
					<?php if($status_nyeri_hilang == 'Ya') echo 'checked="checked"'; ?>/>&nbsp;Ya, Pukul &nbsp; <input type="text" name="keterangan_status_nyeri_hilang" class="text_dt" value="<?php echo $keterangan_status_nyeri_hilang; ?>" size="20" />
					<input type="radio" name="status_nyeri_hilang" value="Tidak" class="text_dt" 
					<?php if($status_nyeri_hilang == 'Tidak') echo 'checked="checked"'; ?>/>&nbsp;Tidak</td>
				</tr>
				</table>
            </td>
        </tr>
		<tr>
            <td valign="top">Riwayat Alergi Obat</td>
            <td colspan="3">
             <textarea name="riwayat_alergi_obat" class="text_dt2" cols="80" rows="5" ><?php echo $riwayat_alergi_obat; ?></textarea>  
            </td>
        </tr>
		<tr>
            <td valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top">Diagnosa Keperawatan</td>
            <td colspan="3">
             <textarea name="diagnosa_keperawatan" class="text_dt2" cols="80" rows="5" ><?php echo $diagnosa_keperawatan; ?></textarea>  
            </td>
        </tr>
		<tr>
            <td valign="top">Rencana Keperawatan</td>
            <td colspan="3">
             <textarea name="rencana_keperawatan" class="text_dt2" cols="80" rows="5" ><?php echo $rencana_keperawatan; ?></textarea>  
            </td>
        </tr>
		<tr>
            <td valign="top">Implementasi Keperawatan</td>
            <td colspan="3">
             <textarea name="implementasi_keperawatan" class="text_dt2" cols="80" rows="5" ><?php echo $implementasi_keperawatan; ?></textarea>  
            </td>
        </tr>
		<tr>
            <td valign="top">Evaluasi Keperawatan</td>
            <td colspan="3">
             <textarea name="evaluasi_keperawatan" class="text_dt2" cols="80" rows="5" ><?php echo $evaluasi_keperawatan; ?></textarea>  
            </td>
        </tr>
        <tr><td colspan="4" align="right">
			<?php if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $irja_final == ''){ ?>
			<input type="checkbox" name="selesai" id="selesai" value="1" <?php if($selesai == '1') echo 'checked="checked"'; ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="button" name="simpan" value="simpan" class="myButton1" onclick="simpan_askep();" />
		    <?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "8"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
			<?php if($irja_final == '' and isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $idx_askep != ''){ ?>
				<input type="button" name="copi" value="copy ke PAM" class="myButton1" onclick="copykePAM(<?php echo $irja_id; ?>,<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>);" />
			<?php } ?>
		   </td>
        </tr>
    </table>
</form>
<script language="javascript" type="text/javascript">
<?php if(!isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
$(':input').attr('readonly','readonly');
<?php } ?>
function simpan_askep(){
	_haschange = false;
	if($('#idx_askep').val() != ''){
		if($('#ls_final').val() == '1'){
			if($('#ls_assesment').val() != $('#tgl_skr').val()){
				if(confirm('Revisi ?')){
					$('#formrujukan').submit();
				}	
			}else{
				$('#formrujukan').submit();
			}	
		}else{
			if($("#selesai").is(':checked')){
				if(confirm('Final ?')){
					$('#formrujukan').submit();
				}
			}else{
				$('#formrujukan').submit();
			}
		}
	}else{
		if($("#selesai").is(':checked')){
			if(confirm('Final ?')){
				$('#formrujukan').submit();
			}
		}else{
			$('#formrujukan').submit();
		}	
	}
}

function copykePAM(irja_id,unit){
	$.ajax({
		type: 'POST',
		url: 'http://<?php echo $_SERVER['SERVER_NAME']?>/nsimrs/index.php?ajaxrequest=copyaskepkepam&irja_id=' + irja_id + '&unit=' + unit,
		data: { idx : 'idx'},
		cache: false,
		success: function(data) {
			alert(data);		
		}
	});
}
</script>