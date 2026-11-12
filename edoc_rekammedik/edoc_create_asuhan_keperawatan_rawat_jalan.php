<?php
function create_pdf_asuhan_keperawatan_rawat_jalan($idx){
global $rmfile_path;
global $user_name;	
global $edoc_logo;
global $paper_width;
global $paper_height;
$jenis_document = 'Pengkajian Awal Keperawatan Rawat Jalan';
$id_document = '8';	

$jns_rawat = '1';
$qry_keperawatan = 'SELECT m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,t_irja.UNIT_ID,m_unit.NAMA_UNIT,
					m_pegawai.NAMA_PEGAWAI,"" AS JNS_ORDER, "" AS RAWAT_ID,
					DATE_FORMAT(t_irja.PASIEN_MASUK,"%d/%m/%Y") AS TANGGAL_MASUK,
					DATE_FORMAT(t_irja.PASIEN_MASUK,"%H:%i:%s") AS JAM_MASUK,
					m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,m_pasien.PEKERJAAN,m_jaminan.NAMA_JAMINAN
					FROM t_irja
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
					LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
					LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
					WHERE t_irja.IRJA_ID = "' . $idx . '"';
$qry_askep = 'SELECT t_irja_askep.IRJA_ASKEP_ID,t_irja_askep.KELUHAN_UTAMA,t_irja_askep.RIWAYAT_PENYAKIT,t_irja_askep.RIWAYAT_PENYAKIT_KELUARGA,
					t_irja_askep.GENOGRAM,t_irja_askep.TEKANAN_DARAH,t_irja_askep.FREKUENSI_NAFAS,t_irja_askep.SUHU_TUBUH,t_irja_askep.FREKUENSI_NADI,
					t_irja_askep.BERAT_BADAN,t_irja_askep.TINGGI_BADAN,t_irja_askep.PEMERIKSA_FISIK_TERKAIT_KELUHAN,t_irja_askep.HUBUNGAN_KELUARGA,
					t_irja_askep.STATUS_PSIKOLOGIS,t_irja_askep.STATUS_PSIKOLOGIS_BUNUH_DIRI,t_irja_askep.KETERANGAN_STATUS_PSIKOLOGIS,
					t_irja_askep.PENURUNAN_BERAT_BADAN,t_irja_askep.TIDAK_NAFSU_MAKAN,t_irja_askep.DIAGNOSIS_KHUSUS,t_irja_askep.DIAGNOSA_KHUSUS_DM,
					t_irja_askep.DIAGNOSA_KHUSUS_KEMOTERAPI,t_irja_askep.DIAGNOSA_KHUSUS_HEMODIALISA,t_irja_askep.DIAGNOSA_KHUSUS_GERIATRI,
					t_irja_askep.DIAGNOSA_KHUSUS_IMUNITAS,t_irja_askep.DIAGNOSA_KHUSUS_LAIN,t_irja_askep.KETERANGAN_DIAGNOSIS_KHUSUS,
					t_irja_askep.STATUS_FUNGSIONAL,t_irja_askep.KETERANGAN_STATUS_FUNGSIONAL,t_irja_askep.KETERANGAN_STATUS_FUNGSIONAL_KETERGANTUNGAN,
					t_irja_askep.CARA_BERJALAN,t_irja_askep.CARA_DUDUK,t_irja_askep.RESIKO_JATUH,t_irja_askep.KETERANGAN_RESIKO_JATUH,
					t_irja_askep.NYERI,t_irja_askep.SKALA_NYERI,t_irja_askep.LOKASI_NYERI,t_irja_askep.DURASI_NYERI,t_irja_askep.FREKUENSI_NYERI,
					t_irja_askep.NYERI_HILANG,t_irja_askep.KETERANGAN_NYERI_HILANG,t_irja_askep.STATUS_NYERI_HILANG,
					t_irja_askep.KETERANGAN_STATUS_NYERI_HILANG,t_irja_askep.RIWAYAT_ALERGI_OBAT,t_irja_askep.DIAGNOSA_KEPERAWATAN,
					t_irja_askep.RENCANA_KEPERAWATAN,t_irja_askep.IMPELEMENTASI_KEPERAWATAN,t_irja_askep.EVALUASI_KEPERAWATAN,t_irja_askep.ST_SELESAI
					FROM t_irja_askep
					WHERE t_irja_askep.IRJA_ASKEP_ID = "' . $idx . '"';				
$get_askep = mysql_query($qry_askep) or die(mysql_error());
if(mysql_num_rows($get_askep) > 0){
	$dat_askep = mysql_fetch_assoc($get_askep);
	
	$get_keperawatan = mysql_query($qry_keperawatan) or die(mysql_error());
	$dat_keperawatan = mysql_fetch_assoc($get_keperawatan);

	$nomr = $dat_keperawatan['NOMR'];
	$nama_pasien = $dat_keperawatan['NAMA_PASIEN'];
	$tgl_lahir = $dat_keperawatan['TGL_LAHIR'];
	$jns_kelamin = $dat_keperawatan['JNS_KELAMIN'];
	$unit_id = $dat_keperawatan['NAMA_UNIT'];
	$dokter = $dat_keperawatan['NAMA_PEGAWAI'];
	$agama = $dat_keperawatan['NAMA_AGAMA'];
	$pendidikan = $dat_keperawatan['NAMA_PENDIDIKAN'];
	$pekerjaan = $dat_keperawatan['PEKERJAAN'];
	$jaminan = $dat_keperawatan['NAMA_JAMINAN'];
	$igd = false;
	if($dat_keperawatan['UNIT_ID'] == '9') $igd = true;

	$edoc_norm = formatNoMR($nomr);
	$edoc_nama_pasien = $nama_pasien;
	$edoc_tanggal_lahir = changeDateFormat($tgl_lahir);
	$edoc_jenis_kelamin = jenisKelamin($jns_kelamin);
	$edoc_unit = $unit_id;
	$edoc_nama_documen = strtoupper($jenis_document);
	$edoc_tanggal_masuk = $dat_keperawatan['TANGGAL_MASUK'];
	$edoc_jam_masuk = $dat_keperawatan['JAM_MASUK'];

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
	
	$skor = 0;
	if($penurunan_berat_badan == 'Tidak Ada') $skor = $skor + 0;
	if($penurunan_berat_badan == 'Tidak Yakin') $skor = $skor + 2;
	if($penurunan_berat_badan == 'Ada|1 - 5 kg') $skor = $skor + 1;
	if($penurunan_berat_badan == 'Ada|6 - 10 kg') $skor = $skor + 2;
	if($penurunan_berat_badan == 'Ada|- 15 kg') $skor = $skor + 3;
	if($penurunan_berat_badan == 'Ada|> 15 kg') $skor = $skor + 4;
	if($tidak_nafsu_makan == 'Tidak') $skor = $skor + 0;
	if($tidak_nafsu_makan == 'Ya') $skor = $skor + 1;
	
	$hasil_cara_duduk = '';
	if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Tidak')) $hasil_cara_duduk = 'Tidak Berisiko';
	if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Ya')) $hasil_cara_duduk = 'Risiko Tinggi';
	if(($cara_berjalan == 'Tidak') and ($cara_duduk == 'Ya')) $hasil_cara_duduk = 'Risiko Rendah';
	if(($cara_berjalan == 'Ya') and ($cara_duduk == 'Tidak')) $hasil_cara_duduk = 'Risiko Rendah';

	$edoc_content = '<table width="100%" border="0" autosize="1">
	<tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
	<tr>
		  <td colspan="5" valign="top">Tanggal Kunjungan : ' . $edoc_tanggal_masuk . '&nbsp;&nbsp;&nbsp;&nbsp;Pukul : ' . $edoc_jam_masuk . 
		'&nbsp;&nbsp;&nbsp;&nbsp;Nama Klinik : ' . $edoc_unit . '</td>
	</tr>
		<tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td width="10px" valign="top" >1.</td>
          <td width="160px" valign="top">Identitas Pasien </td>
          <td width="10px">a.</td>
          <td width="160px">Nama</td>
          <td >:&nbsp;' . $edoc_nama_pasien . '</td>
        </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>b.</td>
		  <td>No Rekam Medik </td>
		  <td>:&nbsp;' . $edoc_norm . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>c.</td>
		  <td>Tanggal Lahir </td>
		  <td>:&nbsp;' . $edoc_tanggal_lahir . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>d.</td>
		  <td>Jenis Kelamin </td>
		  <td>:&nbsp;' . $edoc_jenis_kelamin . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>e.</td>
		  <td>Agama</td>
		  <td>:&nbsp;' . $agama . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>f.</td>
		  <td>Pendidikan</td>
		  <td>:&nbsp;' . $pendidikan . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>g.</td>
		  <td>Pekerjaan</td>
		  <td>:&nbsp;' . $pekerjaan . '</td>
  </tr>
		<tr>
		  <td valign="top">&nbsp;</td>
		  <td valign="top">&nbsp;</td>
		  <td>h.</td>
		  <td>Status Pembayaran </td>
		  <td>:&nbsp;' . $jaminan . '</td>
  </tr>
		
		
        <tr>
            <td valign="top">2.</td>
            <td valign="top">Keluhan Utama</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($keluhan_utama) . '</td>
        </tr>
        <tr>
            <td valign="top">3.</td>
            <td valign="top">Riwayat Penyakit Dahulu</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($riwayat_penyakit) . '</td>
        </tr>
        <tr>
            <td valign="top">4.</td>
            <td valign="top">Riwayat Penyakit Keluarga</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($riwayat_penyakit_keluarga) . '</td>
        </tr>
		<tr>
            <td valign="top">5.</td>
            <td valign="top">Genogram</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($genogram) . '</td>
        </tr>
		<tr>
            <td valign="top">6.</td>
            <td valign="top">Pemeriksaan Fisik</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Tekanan Darah</td>
					<td>:&nbsp;' . setGarisIfNull($tekanan_darah) . '&nbsp;mmHg</td>
					<td width="50px">&nbsp;</td>
					<td>Frekuensi Nafas</td>
					<td>:&nbsp;' . setGarisIfNull($frekuensi_nafas) . '&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Suhu Tubuh</td>
					<td>:&nbsp;' . setGarisIfNull($suhu_tubuh) . '&nbsp;oC</td>
					<td width="50px">&nbsp;</td>
					<td>Frekuensi Nadi</td>
					<td>:&nbsp;' . setGarisIfNull($frekuensi_nadi) . '&nbsp;x/menit</td>
				</tr>	
				<tr>	
					<td>Berat Badan</td>
					<td>:&nbsp;' . setGarisIfNull($berat_badan) . '&nbsp;Kg</td>
					<td width="50px">&nbsp;</td>
					<td>Tinggi Badan</td>
					<td>:&nbsp;' . setGarisIfNull($tinggi_badan) . '&nbsp;Cm</td>
				</tr>	
				<tr>	
					<td>Pemeriksaan Fisik <br>Terkait Keluhan Utama</td>
					<td colspan="4">:&nbsp;' . setGarisIfNull($pemeriksaan_fisik_terkait_keluhan) . '</td>
				</tr>	
				</table></td>
        </tr>
		<tr>
            <td valign="top">7.</td>
            <td valign="top">Riwayat Psikososial</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Hubungan Dgn Anggota Keluarga</td>
					<td>:&nbsp;<input type="checkbox" name="hubungan_keluarga" value="Baik" class="text_dt" 
					' . (($hubungan_keluarga == 'Baik') ? 'checked="checked"' : '') . ' />&nbsp;Baik
					&nbsp;&nbsp;<input type="checkbox" name="hubungan_keluarga" value="Tidak Baik" class="text_dt" 
					' . (($hubungan_keluarga == 'Tidak Baik') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Baik</td>
				</tr>	
				<tr>	
					<td valign="top">Status Psikologis</td>
					<td>:&nbsp;<input type="checkbox" name="status_psikologis" value="Tenang" class="text_dt" 
					' . (($status_psikologis == 'Tenang')  ? 'checked="checked"' : '') . ' />&nbsp;Tenang
					<input type="checkbox" name="status_psikologis" value="Cemas" class="text_dt" 
					' . (($status_psikologis == 'Cemas')  ? 'checked="checked"' : '') . ' />&nbsp;Cemas
					<input type="checkbox" name="status_psikologis" value="Takut" class="text_dt" 
					' . (($status_psikologis == 'Takut')  ? 'checked="checked"' : '') . ' />&nbsp;Takut
					<br>
					<input type="checkbox" name="status_psikologis" value="Marah" class="text_dt" 
					' . (($status_psikologis == 'Marah')  ? 'checked="checked"' : '') . ' />&nbsp;Marah
					<input type="checkbox" name="status_psikologis" value="Sedih" class="text_dt" 
					' . (($status_psikologis == 'Sedih')  ? 'checked="checked"' : '') . ' />&nbsp;Sedih
					<input type="checkbox" name="status_psikologis" value="Kecendrungan Bunuh" class="text_dt" 
					' . (($status_psikologis == 'Kecendrungan Bunuh')  ? 'checked="checked"' : '') . ' />&nbsp;Kecendrungan Bunuh Diri
					Dilaporkan Ke&nbsp;' . setGarisIfNull($status_bunuh_diri) . '
					<br />
					<input type="checkbox" name="status_psikologis" value="Lain-lain" class="text_dt" 
					' . (($status_psikologis == 'Lain-lain')  ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain, Sebutkan ' . setGarisIfNull($keterangan_status_psikologis) . '</td>
				</tr>	
				</table></td>
        </tr>
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>';
	
	$edoc_content_2 = '<table width="100%" border="0" autosize="1">
	<tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top">8.</td>
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
					<td>:&nbsp;<input type="checkbox" name="penurunan_berat_badan" value="Tidak Ada" class="text_dt" 
					' . (($penurunan_berat_badan == 'Tidak Ada') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Ada Penurunan BB</td>
					<td width="50px" align="center">0</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Tidak Yakin" class="text_dt" 
					' . (($penurunan_berat_badan == 'Tidak Yakin') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Yakin /Tidak Tahu /Baju Terasa Longgar</td>
					<td width="50px" align="center">2</td>
				</tr>
				<tr>	
					<td>Jika Ya, Berapa Penurunan Berat Badan Tersebut</td>
					<td>:&nbsp;<input type="checkbox" name="penurunan_berat_badan" value="Ada|1 - 5 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|1 - 5 kg') ? 'checked="checked"' : '') . ' />&nbsp;1 - 5 kg</td>
					<td width="50px" align="center">1</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Ada|6 - 10 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|6 - 10 kg') ? 'checked="checked"' : '') . ' />&nbsp;6 - 10 kg</td>
					<td width="50px" align="center">2</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Ada|- 15 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|- 15 kg') ? 'checked="checked"' : '') . ' />&nbsp;- 15 kg</td>
					<td width="50px" align="center">3</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="penurunan_berat_badan" value="Ada|> 15 kg" class="text_dt" 
					' . (($penurunan_berat_badan == 'Ada|> 15 kg') ? 'checked="checked"' : '') . ' />&nbsp;> 15 kg</td>
					<td width="50px" align="center">4</td>
				</tr>
				<tr>	
					<td>Apakah Asupan Makanan Berkurang<br>Karena Tdk Nafsu makan?</td>
					<td>:&nbsp;<input type="checkbox" name="tidak_nafsu_makan" value="Tidak" class="text_dt" 
					' . (($tidak_nafsu_makan == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak					</td>
					<td width="50px" align="center">0</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="tidak_nafsu_makan" value="Ya" class="text_dt" 
					' . (($tidak_nafsu_makan == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya					</td>
					<td width="50px" align="center">1</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td align="right"><i>Total Skors</i>&nbsp;</td>
					<td width="50px" align="center">' . setGarisIfNull($skor) . '</td>
				</tr>
				<tr>	
					<td>Pasien Dgn Diagnosis Khusus</td>
					<td>:&nbsp;<input type="checkbox" name="diagnosis_khusus" value="Ya" class="text_dt" 
					' . (($diagnosis_khusus == 'Ya') ? 'checked="checked"' : '') . '/>&nbsp;Ya
					<input type="checkbox" name="diagnosis_khusus" value="Tidak" class="text_dt" 
					' . (($diagnosis_khusus == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
					<td width="50px" align="center">&nbsp;</td>
				</tr>
				<tr>	
					<td>&nbsp;</td>
					<td><input type="checkbox" name="diagnosis_khusus_dm" value="1" class="text_dt" ' . (($diagnosis_khusus_dm == '1') ? 'checked="checked"' : '') . ' />DM
					<input type="checkbox" name="diagnosis_khusus_kemoterapi" value="1" class="text_dt" ' . (($diagnosis_khusus_kemoterapi == '1') ? 'checked="checked"' : '') . ' />Kemoterapi
					<input type="checkbox" name="diagnosis_khusus_hemodialisa" value="1" class="text_dt" ' . (($diagnosis_khusus_hemodialisa == '1') ? 'checked="checked"' : '') . ' />Hemodialisa
					<input type="checkbox" name="diagnosis_khusus_geriatri" value="1" class="text_dt" ' . (($diagnosis_khusus_geriatri == '1') ? 'checked="checked"' : '') . ' />Geriatri
					<input type="checkbox" name="diagnosis_khusus_imunitas" value="1" class="text_dt" ' . (($diagnosis_khusus_imunitas == '1') ? 'checked="checked"' : '') . ' />Imunitas Menurun
					<input type="checkbox" name="diagnosis_khusus_lain" value="1" class="text_dt" ' . (($diagnosis_khusus_lain == '1') ? 'checked="checked"' : '') . ' />Lain-lain
					' . setGarisIfNull($keterangan_diagnosis_khusus) . '</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">9.</td>
            <td valign="top">Status Fungsional</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td colspan="2">:&nbsp;<input type="checkbox" name="status_fungsional" value="Mandiri" class="text_dt" 
					' . (($status_fungsional == 'Mandiri') ? 'checked="checked"' : '') . ' />&nbsp;Mandiri
					<input type="checkbox" name="status_fungsional" value="Perlu Bantuan" class="text_dt" 
					' . (($status_fungsional == 'Perlu Bantuan') ? 'checked="checked"' : '') . ' />&nbsp;Perlu Bantuan, Sebutkan&nbsp;
					' . setGarisIfNull($keterangan_status_fungsional) . '</td>
				</tr>
				<tr>	
					<td colspan="2"><input type="checkbox" name="status_fungsional" value="Ketergantungan Total" class="text_dt" 
					' . (($status_fungsional == 'Ketergantungan Total') ? 'checked="checked"' : '') . '/>&nbsp;Ketergantungan Total, Dilaporkan Ke Dokter Pukul&nbsp;
					' . setGarisIfNull($keterangan_status_fungsional_ketergantungan) . '</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">10.</td>
            <td valign="top">Skrining Resiko Cedera/ Jatuh</td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td>Perhatikan Cara Berjalan Saat Akan Duduk Di Kursi<br>Apakah Pasien Tampak Tdk Seimbang</td>
					<td colspan="2">:&nbsp;<input type="checkbox" name="cara_berjalan" value="Ya" class="text_dt" 
					' . (($cara_berjalan == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya
					<input type="checkbox" name="cara_berjalan" value="Tidak" class="text_dt" 
					' . (($cara_berjalan == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				<tr>	
					<td>Apakah Pasien Memegang Pinggiran Kursi/ Meja/ Benda Lain<br>Sebaga Penopang Saat Akan Duduk</td>
					<td colspan="2">:&nbsp;<input type="checkbox" name="cara_duduk" value="Ya" class="text_dt" 
					' . (($cara_duduk == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya
					<input type="checkbox" name="cara_duduk" value="Tidak" class="text_dt" 
					' . (($cara_duduk == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				<tr>	
					<td>Hasil :&nbsp;' . setGarisIfNull($hasil_cara_duduk) . '</td>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>	
					<td>Diberitahukan Ke Dokter</td>
					<td colspan="2">:&nbsp;<input type="checkbox" name="resiko_jatuh" value="Ya" class="text_dt" 
					' . (($resiko_jatuh == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya, Pukul &nbsp; ' . setGarisIfNull($keterangan_resiko_jatuh) . '
					<input type="checkbox" name="resiko_jatuh" value="Tidak" class="text_dt" 
					' . (($resiko_jatuh == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">11.</td>
            <td valign="top">Skrining Nyeri (Metode Numerik Wong Baker -Face) </td>
            <td colspan="3">
                <table border="0">
				<tr>	
					<td colspan="2">:&nbsp;<input type="checkbox" name="nyeri" value="Tidak Ada" class="text_dt" 
					' . (($nyeri == 'Tidak Ada') ? 'checked="checked"' : '') . ' />&nbsp;Tidak Ada
					<input type="checkbox" name="nyeri" value="Nyeri Kronis" class="text_dt" 
					' . (($nyeri == 'Nyeri Kronis') ? 'checked="checked"' : '') . ' />&nbsp;Nyeri Kronis
					<input type="checkbox" name="nyeri" value="Nyeri Akut" class="text_dt" 
					' . (($nyeri == 'Nyeri Akut') ? 'checked="checked"' : '') . ' />&nbsp;Nyeri Akut</td>
				</tr>
				<tr>	
					<td>Skala Nyeri</td>
					<td>:&nbsp;<input type="checkbox" name="skala_nyeri" value="0" class="text_dt"' . (($skala_nyeri == '0') ? 'checked="checked"' : '') . ' />&nbsp;0
					<input type="checkbox" name="skala_nyeri" value="1" class="text_dt"' . (($skala_nyeri == '1') ? 'checked="checked"' : '') . ' />&nbsp;1
					<input type="checkbox" name="skala_nyeri" value="2" class="text_dt"' . (($skala_nyeri == '2') ? 'checked="checked"' : '') . ' />&nbsp;2
					<input type="checkbox" name="skala_nyeri" value="3" class="text_dt"' . (($skala_nyeri == '3') ? 'checked="checked"' : '') . ' />&nbsp;3
					<input type="checkbox" name="skala_nyeri" value="4" class="text_dt"' . (($skala_nyeri == '4') ? 'checked="checked"' : '') . ' />&nbsp;4
					<input type="checkbox" name="skala_nyeri" value="5" class="text_dt"' . (($skala_nyeri == '5') ? 'checked="checked"' : '') . ' />&nbsp;5
					<input type="checkbox" name="skala_nyeri" value="6" class="text_dt"' . (($skala_nyeri == '6') ? 'checked="checked"' : '') . ' />&nbsp;6
					<input type="checkbox" name="skala_nyeri" value="7" class="text_dt"' . (($skala_nyeri == '7') ? 'checked="checked"' : '') . ' />&nbsp;7
					<input type="checkbox" name="skala_nyeri" value="8" class="text_dt"' . (($skala_nyeri == '8') ? 'checked="checked"' : '') . ' />&nbsp;8
					<input type="checkbox" name="skala_nyeri" value="9" class="text_dt"' . (($skala_nyeri == '9') ? 'checked="checked"' : '') . ' />&nbsp;9
					<input type="checkbox" name="skala_nyeri" value="10" class="text_dt"' . (($skala_nyeri == '10') ? 'checked="checked"' : '') . ' />&nbsp;10</td>
				</tr>
				<tr>	
					<td>Lokasi</td>
					<td>:&nbsp;' . setGarisIfNull($lokasi_nyeri) . '</td>
				</tr>	
				<tr>	
					<td>Durasi</td>
					<td>:&nbsp;' . setGarisIfNull($durasi_nyeri) . '</td>
				</tr>
				<tr>	
					<td>Frekuensi</td>
					<td>:&nbsp;' . setGarisIfNull($frekuensi_nyeri) . '</td>
				</tr>
				<tr>	
					<td>Nyeri Hilang Bila</td>
					<td>:&nbsp;<input type="checkbox" name="nyeri_hilang" value="Minum Obat" class="text_dt" 
					' . (($nyeri_hilang == 'Minum Obat') ? 'checked="checked"' : '') . ' />&nbsp;Minum Obat
					<input type="checkbox" name="nyeri_hilang" value="Istirahat" class="text_dt" 
					' . (($nyeri_hilang == 'Istirahat') ? 'checked="checked"' : '') . ' />&nbsp;Istirahat
					<input type="checkbox" name="nyeri_hilang" value="Mendengar Musik" class="text_dt" 
					' . (($nyeri_hilang == 'Mendengar Musik') ? 'checked="checked"' : '') . '  />&nbsp;Mendengar Musik
					<input type="checkbox" name="nyeri_hilang" value="Berubah Posisi" class="text_dt" 
					' . (($nyeri_hilang == 'Berubah Posisi') ? 'checked="checked"' : '') . ' />&nbsp;Berubah Posisi/ Tidur
					<input type="checkbox" name="nyeri_hilang" value="Lain-lain" class="text_dt" 
					' . (($nyeri_hilang == 'Lain-lain') ? 'checked="checked"' : '') . ' />&nbsp;Lain-lain, Sebutkan ' . setGarisIfNull($keterangan_nyeri_hilang) . '</td>
				</tr>
				<tr>	
					<td>Diberitahukan Ke Dokter</td>
					<td>:&nbsp;<input type="checkbox" name="status_nyeri_hilang" value="Ya" class="text_dt" 
					' . (($status_nyeri_hilang == 'Ya') ? 'checked="checked"' : '') . ' />&nbsp;Ya, Pukul &nbsp; ' . setGarisIfNull($keterangan_status_nyeri_hilang) .'
					<input type="checkbox" name="status_nyeri_hilang" value="Tidak" class="text_dt" 
					' . (($status_nyeri_hilang == 'Tidak') ? 'checked="checked"' : '') . ' />&nbsp;Tidak</td>
				</tr>
				</table></td>
        </tr>
		<tr>
            <td valign="top">12.</td>
            <td valign="top">Riwayat Alergi Obat</td>
            <td colspan="3">:&nbsp;' . setGarisIfNull($riwayat_alergi_obat) . '</td>
        </tr>
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>';
	
	$edoc_content_3 = '<style>.tbl tr td {
   border: 1px solid black;
   padding-left:1px;
   border-collapse: collapse;
}</style><table width="100%" border="0" autosize="1">
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
		<tr>
		  <td colspan="5" valign="top">
		    <table width="100%" border="1" cellspacing="0" class="tbl" cellpadding="0">
              <tr>
                <td width="50%" align="center" bgcolor="#CCCCCC" ><strong>Diagnosa Keperawatan</strong></td>
                <td width="50%" align="center" bgcolor="#CCCCCC" ><strong>Rencana Keperawatan</strong></td>
              </tr>
              <tr>
                <td>' . setGarisIfNull($diagnosa_keperawatan) . '</td>
                <td>' . setGarisIfNull($rencana_keperawatan) . '</td>
              </tr>
              <tr>
                <td>Tanggal &amp; Jam </td>
                <td>Nama &amp; Tandatangan</td>
              </tr>
			<tr>
				<td>:&nbsp;</td>
				<td>:&nbsp;</td>
			</tr>	
			<tr>
				<td style="border: 0px;">&nbsp;</td>
				<td style="border: 0px;">&nbsp;</td>
			</tr>	
              <tr>
                <td align="center" bgcolor="#CCCCCC" ><strong>Implementasi Keperawatan</strong></td>
                <td align="center" bgcolor="#CCCCCC" ><strong>Evaluasi Keperawatan</strong></td>
              </tr>
              <tr>
                <td>' . setGarisIfNull($implementasi_keperawatan) . '</td>
                <td>' . setGarisIfNull($evaluasi_keperawatan) . '</td>
              </tr>
              <tr>
                <td>Tanggal &amp; Jam</td>
                <td>Nama &amp; Tandatangan</td>
              </tr>
			  <tr>
                <td>:&nbsp;</td>
                <td>:&nbsp;</td>
              </tr>
            </table>
		  </td>
	  </tr>
        <tr>
            <td colspan="2" valign="top">&nbsp;</td>
            <td colspan="3">&nbsp;</td>
        </tr>
    </table>';
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_main_2.php');
	$html = ob_get_contents();
	ob_end_clean();
	
	ob_start();
	include('edoc_rekammedik/edoc_frame_add.php');
	$html_2 = ob_get_contents();
	ob_end_clean();
	
	ob_start();
	$edoc_content_2 = $edoc_content_3;
	include('edoc_rekammedik/edoc_frame_add.php');
	$html_3 = ob_get_contents();
	ob_end_clean();

	createFolder($nomr);
	$filename = $nomr . '_RJ' . $idx . '_' . $id_document . '.pdf' ;

	$mpdf = new mPDF('utf-8', array($paper_width,$paper_height));
	$mpdf->autoPageBreak = false;
	$mpdf->SetHTMLHeader(setHeader($nomr,$nama_pasien));
	$mpdf->SetHTMLFooter(setFooter($jenis_document));
	$mpdf->WriteHTML($html);
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html_2);
	$mpdf->AddPage('P');
	$mpdf->WriteHTML($html_3);
	$mpdf->Output($rmfile_path . '/' . $nomr . '/' . $filename);	

	saveData($nomr,$idx,$jns_rawat,$id_document,$filename,$user_name,'','');
}
}
?>