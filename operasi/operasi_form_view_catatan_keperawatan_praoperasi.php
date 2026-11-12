<?php 
$idop = $_GET['idx'];
$sql_askep = 'SELECT t_operasi_askep_praoperasi.ASKEP_PRAOPERASI_ID,t_operasi_askep_praoperasi.IRNA_ID,
				t_operasi_askep_praoperasi.OPERASI_ID,t_operasi_askep_praoperasi.TANDA_VITAL_SUHU,
				t_operasi_askep_praoperasi.TANDA_VITAL_NADI,t_operasi_askep_praoperasi.TANDA_VITAL_RR,
				t_operasi_askep_praoperasi.TANDA_VITAL_TD,t_operasi_askep_praoperasi.TANDA_VITAL_SKOR_NYERI,
				t_operasi_askep_praoperasi.TANDA_VITAL_TB,t_operasi_askep_praoperasi.TANDA_VITAL_BB,
				t_operasi_askep_praoperasi.KESADARAN,t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_HIPERTENSI,
				t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_DIABETES,t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_HEPATITIS,
				t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_LAIN,t_operasi_askep_praoperasi.RIWAYAT_PENYAKIT_LAIN_KET,
				t_operasi_askep_praoperasi.PENGOBATAN_SAAT_INI,t_operasi_askep_praoperasi.ALAT_BANTU,
				t_operasi_askep_praoperasi.OPERASI_SEBELUM_JENIS,t_operasi_askep_praoperasi.OPERASI_SEBELUM_KAPAN,
				t_operasi_askep_praoperasi.OPERASI_SEBELUM_DI,t_operasi_askep_praoperasi.ALERGI,
				t_operasi_askep_praoperasi.ALERGI_KET,t_operasi_askep_praoperasi.HASIL_LAB_HB,
				t_operasi_askep_praoperasi.HASIL_LAB_BT,t_operasi_askep_praoperasi.HASIL_LAB_CT_APTT,
				t_operasi_askep_praoperasi.HASIL_LAB_URINE,t_operasi_askep_praoperasi.HASIL_LAB_LAIN,
				t_operasi_askep_praoperasi.HASIL_LAB_LAIN_KET,t_operasi_askep_praoperasi.BATUK_FLU_DEMAM,
				t_operasi_askep_praoperasi.SEDANG_HAID,t_operasi_askep_praoperasi.PERIKSA_IDENTITAS,
				t_operasi_askep_praoperasi.PERIKSA_IDENTITAS_KET,t_operasi_askep_praoperasi.PERIKSA_GELANG_IDENTITAS,
				t_operasi_askep_praoperasi.PERIKSA_GELANG_IDENTITAS_KET,t_operasi_askep_praoperasi.PERIKSA_GELANG_RESIKO,
				t_operasi_askep_praoperasi.PERIKSA_GELANG_RESIKO_KET,t_operasi_askep_praoperasi.PERIKSA_SURAT_PENGANTAR_OPERASI,
				t_operasi_askep_praoperasi.PERIKSA_SURAT_PENGANTAR_OPERASI_KET,t_operasi_askep_praoperasi.PERIKSA_JENIS_LOKASI_PEMBEDAHAN,
				t_operasi_askep_praoperasi.PERIKSA_JENIS_LOKASI_PEMBEDAHAN_KET,t_operasi_askep_praoperasi.PERIKSA_MASALAH_KOMUNIKASI,
				t_operasi_askep_praoperasi.PERIKSA_MASALAH_KOMUNIKASI_KET,t_operasi_askep_praoperasi.PERIKSA_SURAT_IJIN_OPERASI,
				t_operasi_askep_praoperasi.PERIKSA_SURAT_IJIN_OPERASI_KET,t_operasi_askep_praoperasi.PERIKSA_PERSETUJUAN_ANESTESI,
				t_operasi_askep_praoperasi.PERIKSA_PERSETUJUAN_ANESTESI_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_INTERNIST,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_INTERNIST_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ANESTESI,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ANESTESI_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_LAIN,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_LAIN_KET,t_operasi_askep_praoperasi.PERIKSA_KETERSEDIAAN_HCU,
				t_operasi_askep_praoperasi.PERIKSA_KETERSEDIAAN_HCU_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_RM,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_RM_KET,t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ROTHGEN,
				t_operasi_askep_praoperasi.PERIKSA_KELENGKAPAN_ROTHGEN_KET,t_operasi_askep_praoperasi.PERSIAPAN_PUASA,
				t_operasi_askep_praoperasi.PERSIAPAN_PUASA_KET,t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_LUAR,
				t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_LUAR_KET,t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_DALAM,
				t_operasi_askep_praoperasi.PERSIAPAN_PROTHESE_DALAM_KET,t_operasi_askep_praoperasi.PERSIAPAN_PERHIASAN,
				t_operasi_askep_praoperasi.PERSIAPAN_PERHIASAN_KET,t_operasi_askep_praoperasi.PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH,
				t_operasi_askep_praoperasi.PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH_KET,t_operasi_askep_praoperasi.PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH,
				t_operasi_askep_praoperasi.PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH_KET,t_operasi_askep_praoperasi.PERSIAPAN_ALAT_BANTU,
				t_operasi_askep_praoperasi.PERSIAPAN_ALAT_BANTU_KET,t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DISERTAKAN,
				t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DISERTAKAN_KET,t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DIBERIKAN,
				t_operasi_askep_praoperasi.PERSIAPAN_OBAT_DIBERIKAN_KET,t_operasi_askep_praoperasi.PERSIAPAN_VASKULERAKSIS,
				t_operasi_askep_praoperasi.PERSIAPAN_VASKULERAKSIS_KET,t_operasi_askep_praoperasi.PERAWAT_RUANGAN,
				t_operasi_askep_praoperasi.PERAWAT_BEDAH,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_RUANGAN_JAM,"%d/%m/%Y") AS PERAWAT_RUANGAN_TANGGAL,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_RUANGAN_JAM,"%H") AS PERAWAT_RUANGAN_JAM,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_RUANGAN_JAM,"%i") AS PERAWAT_RUANGAN_MENIT,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_BEDAH_JAM,"%d/%m/%Y") AS PERAWAT_BEDAH_TANGGAL,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_BEDAH_JAM,"%H") AS PERAWAT_BEDAH_JAM,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_BEDAH_JAM,"%i") AS PERAWAT_BEDAH_MENIT,
				t_operasi_askep_praoperasi.PERSIAPAN_SITE_MARKING,t_operasi_askep_praoperasi.PERSIAPAN_SITE_MARKING_KET,
				t_operasi_askep_praoperasi.PERSIAPAN_PENJELASAN_DOKTER,t_operasi_askep_praoperasi.PERSIAPAN_PENJELASAN_DOKTER_KET,
				t_operasi_askep_praoperasi.PERAWAT_PENERIMA,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_PENERIMA_JAM,"%d/%m/%Y") AS PERAWAT_PENERIMA_TANGGAL,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_PENERIMA_JAM,"%H") AS PERAWAT_PENERIMA_JAM,
				DATE_FORMAT(t_operasi_askep_praoperasi.PERAWAT_PENERIMA_JAM,"%i") AS PERAWAT_PENERIMA_MENIT
				FROM t_operasi_askep_praoperasi 
				WHERE OPERASI_ID = "' . $idop . '"';
$get_askep = mysql_query($sql_askep) or die(mysql_error());	
$dat_askep = mysql_fetch_assoc($get_askep);

$askep_praoperasi_id = $dat_askep['ASKEP_PRAOPERASI_ID'];
$tanda_vital_suhu = $dat_askep['TANDA_VITAL_SUHU'];
$tanda_vital_nadi = $dat_askep['TANDA_VITAL_NADI'];
$tanda_vital_rr = $dat_askep['TANDA_VITAL_RR'];
$tanda_vital_td = $dat_askep['TANDA_VITAL_TD'];
$tanda_vital_skor_nyeri = $dat_askep['TANDA_VITAL_SKOR_NYERI'];
$tanda_vital_tb = $dat_askep['TANDA_VITAL_TB'];
$tanda_vital_bb = $dat_askep['TANDA_VITAL_BB'];
$kesadaran = $dat_askep['KESADARAN'];
$riwayat_penyakit_hipertensi = $dat_askep['RIWAYAT_PENYAKIT_HIPERTENSI'];
$riwayat_penyakit_diabetes = $dat_askep['RIWAYAT_PENYAKIT_DIABETES'];
$riwayat_penyakit_hepatitis = $dat_askep['RIWAYAT_PENYAKIT_HEPATITIS'];
$riwayat_penyakit_lain = $dat_askep['RIWAYAT_PENYAKIT_LAIN'];
$riwayat_penyakit_lain_ket = $dat_askep['RIWAYAT_PENYAKIT_LAIN_KET'];
$pengobatan_saat_ini = $dat_askep['PENGOBATAN_SAAT_INI'];
$alat_bantu = $dat_askep['ALAT_BANTU'];
$operasi_sebelum_jenis = $dat_askep['OPERASI_SEBELUM_JENIS'];
$operasi_sebelum_kapan = $dat_askep['OPERASI_SEBELUM_KAPAN'];
$operasi_sebelum_di = $dat_askep['OPERASI_SEBELUM_DI'];
$alergi = $dat_askep['ALERGI'];
$alergi_ket = $dat_askep['ALERGI_KET'];
$hasil_lab_hb = $dat_askep['HASIL_LAB_HB'];
$hasil_lab_bt = $dat_askep['HASIL_LAB_BT'];
$hasil_lab_ct_aptt = $dat_askep['HASIL_LAB_CT_APTT'];
$hasil_lab_urine = $dat_askep['HASIL_LAB_URINE'];
$hasil_lab_lain = $dat_askep['HASIL_LAB_LAIN'];
$hasil_lab_lain_ket = $dat_askep['HASIL_LAB_LAIN_KET'];
$batuk_flu_demam = $dat_askep['BATUK_FLU_DEMAM'];
$sedang_haid = $dat_askep['SEDANG_HAID'];
$periksa_identitas = $dat_askep['PERIKSA_IDENTITAS'];
$periksa_identitas_ket = $dat_askep['PERIKSA_IDENTITAS_KET'];
$periksa_gelang_identitas = $dat_askep['PERIKSA_GELANG_IDENTITAS'];
$periksa_gelang_identitas_ket = $dat_askep['PERIKSA_GELANG_IDENTITAS_KET'];
$periksa_gelang_resiko = $dat_askep['PERIKSA_GELANG_RESIKO'];
$periksa_gelang_resiko_ket = $dat_askep['PERIKSA_GELANG_RESIKO_KET'];
$periksa_surat_pengantar_operasi = $dat_askep['PERIKSA_SURAT_PENGANTAR_OPERASI'];
$periksa_surat_pengantar_operasi_ket = $dat_askep['PERIKSA_SURAT_PENGANTAR_OPERASI_KET'];
$periksa_jenis_lokasi_pembedahan = $dat_askep['PERIKSA_JENIS_LOKASI_PEMBEDAHAN'];
$periksa_jenis_lokasi_pembedahan_ket = $dat_askep['PERIKSA_JENIS_LOKASI_PEMBEDAHAN_KET'];
$periksa_masalah_komunikasi = $dat_askep['PERIKSA_MASALAH_KOMUNIKASI'];
$periksa_masalah_komunikasi_ket = $dat_askep['PERIKSA_MASALAH_KOMUNIKASI_KET'];
$periksa_surat_ijin_operasi = $dat_askep['PERIKSA_SURAT_IJIN_OPERASI'];
$periksa_surat_ijin_operasi_ket = $dat_askep['PERIKSA_SURAT_IJIN_OPERASI_KET'];
$periksa_persetujuan_anestesi = $dat_askep['PERIKSA_PERSETUJUAN_ANESTESI'];
$periksa_persetujuan_anestesi_ket = $dat_askep['PERIKSA_PERSETUJUAN_ANESTESI_KET'];
$periksa_kelengkapan_internist = $dat_askep['PERIKSA_KELENGKAPAN_INTERNIST'];
$periksa_kelengkapan_internist_ket = $dat_askep['PERIKSA_KELENGKAPAN_INTERNIST_KET'];
$periksa_kelengkapan_anestesi = $dat_askep['PERIKSA_KELENGKAPAN_ANESTESI'];
$periksa_kelengkapan_anestesi_ket = $dat_askep['PERIKSA_KELENGKAPAN_ANESTESI_KET'];
$periksa_kelengkapan_lain = $dat_askep['PERIKSA_KELENGKAPAN_LAIN'];
$periksa_kelengkapan_lain_ket = $dat_askep['PERIKSA_KELENGKAPAN_LAIN_KET'];
$periksa_ketersediaan_hcu = $dat_askep['PERIKSA_KETERSEDIAAN_HCU'];
$periksa_ketersediaan_hcu_ket = $dat_askep['PERIKSA_KETERSEDIAAN_HCU_KET'];
$periksa_kelengkapan_rm = $dat_askep['PERIKSA_KELENGKAPAN_RM'];
$periksa_kelengkapan_rm_ket = $dat_askep['PERIKSA_KELENGKAPAN_RM_KET'];
$periksa_kelengkapan_rothgen = $dat_askep['PERIKSA_KELENGKAPAN_ROTHGEN'];
$periksa_kelengkapan_rothgen_ket = $dat_askep['PERIKSA_KELENGKAPAN_ROTHGEN_KET'];
$persiapan_puasa = $dat_askep['PERSIAPAN_PUASA'];
$persiapan_puasa_ket = $dat_askep['PERSIAPAN_PUASA_KET'];
$persiapan_prothese_luar = $dat_askep['PERSIAPAN_PROTHESE_LUAR'];
$persiapan_prothese_luar_ket = $dat_askep['PERSIAPAN_PROTHESE_LUAR_KET'];
$persiapan_prothese_dalam = $dat_askep['PERSIAPAN_PROTHESE_DALAM'];
$persiapan_prothese_dalam_ket = $dat_askep['PERSIAPAN_PROTHESE_DALAM_KET'];
$persiapan_perhiasan = $dat_askep['PERSIAPAN_PERHIASAN'];
$persiapan_perhiasan_ket = $dat_askep['PERSIAPAN_PERHIASAN_KET'];
$persiapan_pengosongan_kandung_kemih = $dat_askep['PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH'];
$persiapan_pengosongan_kandung_kemih_ket = $dat_askep['PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH_KET'];
$persiapan_ketersediaan_kantung_darah = $dat_askep['PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH'];
$persiapan_ketersediaan_kantung_darah_ket = $dat_askep['PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH_KET'];
$persiapan_alat_bantu = $dat_askep['PERSIAPAN_ALAT_BANTU'];
$persiapan_alat_bantu_ket = $dat_askep['PERSIAPAN_ALAT_BANTU_KET'];
$persiapan_obat_disertakan = $dat_askep['PERSIAPAN_OBAT_DISERTAKAN'];
$persiapan_obat_disertakan_ket = $dat_askep['PERSIAPAN_OBAT_DISERTAKAN_KET'];
$persiapan_obat_diberikan = $dat_askep['PERSIAPAN_OBAT_DIBERIKAN'];
$persiapan_obat_diberikan_ket = $dat_askep['PERSIAPAN_OBAT_DIBERIKAN_KET'];
$persiapan_vaskuleraksis = $dat_askep['PERSIAPAN_VASKULERAKSIS'];
$persiapan_vaskuleraksis_ket = $dat_askep['PERSIAPAN_VASKULERAKSIS_KET'];
$perawat_ruangan = $dat_askep['PERAWAT_RUANGAN'];
$perawat_bedah = $dat_askep['PERAWAT_BEDAH'];
$perawat_ruangan_tanggal = $dat_askep['PERAWAT_RUANGAN_TANGGAL'];
$perawat_ruangan_jam = $dat_askep['PERAWAT_RUANGAN_JAM'];
$perawat_ruangan_menit = $dat_askep['PERAWAT_RUANGAN_MENIT'];
$perawat_bedah_tanggal = $dat_askep['PERAWAT_BEDAH_TANGGAL'];
$perawat_bedah_jam = $dat_askep['PERAWAT_BEDAH_JAM'];
$perawat_bedah_menit = $dat_askep['PERAWAT_BEDAH_MENIT'];
$persiapan_site_marking = $dat_askep['PERSIAPAN_SITE_MARKING'];
$persiapan_site_marking_ket = $dat_askep['PERSIAPAN_SITE_MARKING_KET'];
$persiapan_penjelasan_dokter = $dat_askep['PERSIAPAN_PENJELASAN_DOKTER'];
$persiapan_penjelasan_dokter_ket = $dat_askep['PERSIAPAN_PENJELASAN_DOKTER_KET'];
$perawat_penerima = $dat_askep['PERAWAT_PENERIMA'];
$perawat_penerima_tanggal = $dat_askep['PERAWAT_PENERIMA_TANGGAL'];
$perawat_penerima_jam = $dat_askep['PERAWAT_PENERIMA_JAM'];
$perawat_penerima_menit = $dat_askep['PERAWAT_PENERIMA_MENIT'];
?>
	<table align="center" width="80%" class="tableData">
		<tr>
			<td colspan="7"><strong>Catatan Keperawatan Pra Operasi</strong><br />
			<i>* Diisi oleh perawat ruangan maksimal 1 jam sebelum diantar ke kamar operasi : </i></td>			
		</tr>		
		<tr>
			<td width="16"><div align="center">1</div></td>
			<td colspan="6">Tanda-tanda Vital</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td width="250">&nbsp;</td>
		  <td width="100">Suhu</td>
		  <td colspan="4"><input name="tanda_vital_suhu" id="tanda_vital_suhu" type="text" class="text_dt" size="20"  value="<?php echo $tanda_vital_suhu; ?>" /></td>
  </tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td>&nbsp;</td>
		  <td>Nadi</td>
		  <td colspan="4"><input name="tanda_vital_nadi" id="tanda_vital_nadi" type="text" class="text_dt" size="20"  value="<?php echo $tanda_vital_nadi; ?>" /></td>
  </tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td>&nbsp;</td>
		  <td>RR</td>
		  <td colspan="4"><input name="tanda_vital_rr" id="tanda_vital_rr" type="text" class="text_dt" size="20"  value="<?php echo $tanda_vital_rr; ?>" /></td>
  </tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td>&nbsp;</td>
		  <td>TD</td>
		  <td colspan="4"><input name="tanda_vital_td" id="tanda_vital_td" type="text" class="text_dt" size="20"  value="<?php echo $tanda_vital_td; ?>" /></td>
  </tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td>&nbsp;</td>
		  <td>Skor Nyeri</td>
		  <td colspan="4"><input name="tanda_vital_skor_nyeri" id="tanda_vital_skor_nyeri" type="text" class="text_dt" size="20"  value="<?php echo $tanda_vital_skor_nyeri; ?>" /></td>
  </tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td>&nbsp;</td>
		  <td>TB</td>
		  <td colspan="4"><input name="tanda_vital_tb" id="tanda_vital_tb" type="text" class="text_dt" size="20"  value="<?php echo $tanda_vital_tb; ?>" /></td>
  </tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td>&nbsp;</td>
		  <td>BB</td>
		  <td colspan="4"><input name="tanda_vital_bb" id="tanda_vital_bb" type="text" class="text_dt" size="20"  value="<?php echo $tanda_vital_bb; ?>" />&nbsp;kg</td>
  </tr>
		<tr>
			<td><div align="center">2</div></td>
			<td colspan="2">Kesadaran</td>
			<td colspan="4">
				<input name="kesadaran" id="sadar"  value="1" type="radio" <?php if($kesadaran == '1') echo 'checked="checked"'; ?> >
				Sadar Penuh&nbsp;&nbsp;			
				<input name="kesadaran" id="bingung"  value="2" type="radio" <?php if($kesadaran == '2') echo 'checked="checked"'; ?> >
				Bingung&nbsp;&nbsp;
				<input name="kesadaran" id="agitasi"  value="3" type="radio" <?php if($kesadaran == '3') echo 'checked="checked"'; ?> >
				Agitasi&nbsp;&nbsp;
				<input name="kesadaran" id="mengantuk"  value="4" type="radio" <?php if($kesadaran == '4') echo 'checked="checked"'; ?> >
				Mengantuk&nbsp;&nbsp;			
				<input name="kesadaran" id="koma"  value="5" type="radio" <?php if($kesadaran == '5') echo 'checked="checked"'; ?>>
			Koma&nbsp;&nbsp;</td>
	    </tr>
		<tr>
			<td><div align="center">3</div></td>
			<td colspan="2">Riwayat Penyakit</td>
			<td colspan="4">
				<input name="riwayat_penyakit_hipertensi" id="sadar"  value="1" type="checkbox" <?php if($riwayat_penyakit_hipertensi == '1') echo 'checked="checked"'; ?> >
				Hipertensi&nbsp;&nbsp;			
				<input name="riwayat_penyakit_diabetes" id="bingung"  value="1" type="checkbox" <?php if($riwayat_penyakit_diabetes == '1') echo 'checked="checked"'; ?> >
				Diabetes&nbsp;&nbsp;
				<input name="riwayat_penyakit_hepatitis" id="agitasi"  value="1" type="checkbox" <?php if($riwayat_penyakit_hepatitis == '1') echo 'checked="checked"'; ?> >
			Hepatitis&nbsp;&nbsp;</td>
	    </tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td colspan="2">&nbsp;</td>
		  <td width="130"><input name="riwayat_penyakit_lain" id="hipertensi"  value="4" type="checkbox" <?php if($riwayat_penyakit_lain == '1') echo 'checked="checked"'; ?> >
Lain-lain&nbsp;</td>
		  <td colspan="3"><input name="riwayat_penyakit_lain_ket" id="riwayat_penyakit_lain_ket" type="text" class="text_dt" size="77"  value="<?php $riwayat_penyakit_lain_ket; ?>" /></td>
  </tr>
		<tr>
			<td><div align="center">4</div></td>
			<td colspan="2">Pengobatan Saat ini</td>
			<td colspan="4"><input name="pengobatan_saat_ini" id="pengobatan" type="text" class="text_dt" size="102"  value="<?php echo $pengobatan_saat_ini; ?>" /></td>
		</tr>
		<tr>
			<td><div align="center">5</div></td>
			<td colspan="2" >Alat bantu yang digunakan</td>
			<td colspan="4" ><input name="alat_bantu" id="lainnya" type="text" class="text_dt" size="102"  value="<?php echo $alat_bantu; ?>" /></td>
		</tr>
		<tr>
			<td><div align="center">6</div></td>
			<td colspan="2">Operasi sebelumnya</td>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Jenis Operasi &nbsp;&nbsp;&nbsp;</td>
		  <td colspan="4"><input name="operasi_sebelum_jenis" id="jns_operasi" type="text" class="text_dt" size="102"  value="<?php echo $operasi_sebelum_jenis; ?>" /></td>
  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Kapan</td>
		  <td colspan="4"><input name="operasi_sebelum_kapan" id="operasi_sebelum_kapan" type="text" class="text_dt" size="102"  value="<?php echo $operasi_sebelum_kapan; ?>" /></td>
  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>Di</td>
		  <td colspan="4"><input name="operasi_sebelum_di" id="operasi_sebelum_di" type="text" class="text_dt" size="102"  value="<?php echo $operasi_sebelum_di; ?>" /></td>
  </tr>
		<tr>
			<td><div align="center">7</div></td>
			<td colspan="2">Alergi</td>
			<td colspan="4">
				<input name="alergi" id="alergi"  value="1" type="radio" <?php if($alergi == '1') echo 'checked="checked"'; ?>>
				Tidak ada&nbsp;&nbsp;			
				<input name="alergi" id="alergi"  value="2" type="radio" <?php if($alergi == '2') echo 'checked="checked"'; ?>>
			Tidak diketahui&nbsp;&nbsp;</td>
		</tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td colspan="2">&nbsp;</td>
		  <td><input name="alergi" id="radio"  value="3" type="radio" <?php if($alergi == '3') echo 'checked="checked"'; ?> />
Ada, 
		  Jelaskan&nbsp;</td>
		  <td colspan="3"><input name="alergi_ket" id="jelas" type="text" class="text_dt" size="77"  value="<?php echo $alergi_ket; ?>" /></td>
  </tr>
		<tr>
			<td><div align="center">8</div></td>
			<td colspan="2">Hasil Laboratorium</td>
			<td colspan="4"><input name="hasil_lab_hb" id="hasil_lab_hb"  value="1" type="checkbox" <?php if($hasil_lab_hb == '1') echo 'checked="checked"'; ?> />
			  HB&nbsp;&nbsp;
              <input name="hasil_lab_bt" id="hasil_lab_bt"  value="1" type="checkbox" <?php if($hasil_lab_bt == '1') echo 'checked="checked"'; ?> />
              BT&nbsp;&nbsp;
              <input name="hasil_lab_ct_aptt" id="hasil_lab_ct_aptt"  value="1" type="checkbox" <?php if($hasil_lab_ct_aptt == '1') echo 'checked="checked"'; ?> />
              CT/APTT&nbsp;&nbsp;
              <input name="hasil_lab_urine" id="hasil_lab_urine"  value="1" type="checkbox" <?php if($hasil_lab_urine == '1') echo 'checked="checked"'; ?> />
            Urine&nbsp;&nbsp;</td>
		</tr>
		<tr>
		  <td><div align="center"></div></td>
		  <td colspan="2">&nbsp;</td>
		  <td><input name="hasil_lab_lain" id="hasil_lab_lain"  value="1" type="checkbox" <?php if($hasil_lab_lain == '1') echo 'checked="checked"'; ?> />
Lain-lain, Jelaskan&nbsp;</td>
		  <td colspan="3"><input name="hasil_lab_lain_ket" id="hasil_lab_lain_ket" type="text" class="text_dt" size="77"  value="<?php echo $hasil_lab_lain_ket; ?>" /></td>
  </tr>
		<tr>
			<td><div align="center">9</div></td>
			<td colspan="2">Batuk/ Flu/ Demam</td>
			<td colspan="4"><input name="batuk_flu_demam" id="hasil_lab"  value="1" type="radio" <?php if($batuk_flu_demam == '1') echo 'checked="checked"'; ?> />
			  Ya&nbsp;&nbsp;
              <input name="batuk_flu_demam" id="hasil_lab"  value="2" type="radio" <?php if($batuk_flu_demam == '2') echo 'checked="checked"'; ?> />
            Tidak </td>
		</tr>
		<tr>
			<td><div align="center">10</div></td>
			<td colspan="2">Bila Pasien perempuan, apakah sedang haid/menstruasi&nbsp;&nbsp;&nbsp;</td>
		    <td colspan="4"><input name="sedang_haid" id="hasil_lab3"  value="1" type="radio" <?php if($sedang_haid == '1') echo 'checked="checked"'; ?> />
Ya&nbsp;&nbsp;
<input name="sedang_haid" id="hasil_lab3"  value="2" type="radio" <?php if($sedang_haid == '2') echo 'checked="checked"'; ?> />
Tidak </td>
	    </tr>
		<tr>
		  <td colspan="7">&nbsp;</td>
  </tr>
		<tr>
			<td colspan="7">Persiapan Operasi<br />
			<i>* Diisi oleh perawat ruangan dan perawat kamar bedah : </i></td>			
		</tr>
		<tr >
			<td colspan="5">Verifikasi Pasien</td>
			<td width="40"><div align="center">Ya</div></td>
			<td width="40"><div align="center">Tidak</div></td>
		</tr>
			
				<tr>
					<td><div align="center">1</div></td>
					<td colspan="2" >Periksa Identitas Pasien&nbsp;</td>
					<td colspan="2" ><input name="periksa_identitas_ket" id="periksa_iden" type="text" class="text_dt" size="102"  value="<?php echo $periksa_identitas_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_identitas" id="periksa_iden1"  value="1" type="radio" <?php if($periksa_identitas == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_identitas" id="periksa_iden1"  value="2" type="radio" <?php if($periksa_identitas == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">2</div></td>
					<td colspan="2" >Periksa Gelang Identitas&nbsp;</td>
					<td colspan="2" ><input name="periksa_gelang_identitas_ket" id="periksa_gelang" type="text" class="text_dt" size="102"  value="<?php echo $periksa_gelang_identitas_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_gelang_identitas" id="periksa_gelang1"  value="1" type="radio" <?php if($periksa_gelang_identitas == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_gelang_identitas" id="periksa_gelang1"  value="2" type="radio" <?php if($periksa_gelang_identitas == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">3</div></td>
					<td colspan="2" >Periksa Gelang Resiko&nbsp;</td>
					<td colspan="2" ><input name="periksa_gelang_resiko_ket" id="periksa_gelang_resiko2" type="text" class="text_dt" size="102"  value="<?php echo $periksa_gelang_resiko_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_gelang_resiko" id="periksa_gelang_resiko1"  value="1" type="radio" <?php if($periksa_gelang_resiko == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_gelang_resiko" id="periksa_gelang_resiko1"  value="2" type="radio" <?php if($periksa_gelang_resiko == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">4</div></td>
					<td colspan="2" >Surat pengantar rawat inap/ surat pengantar operasi&nbsp;</td>
					<td colspan="2" ><input name="periksa_surat_pengantar_operasi_ket" id="periksa_gelang_resiko" type="text" class="text_dt" size="102"  value="<?php echo $periksa_surat_pengantar_operasi_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_surat_pengantar_operasi" id="periksa_gelang_resiko1"  value="1" type="radio" <?php if($periksa_surat_pengantar_operasi == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_surat_pengantar_operasi" id="periksa_gelang_resiko1"  value="2" type="radio" <?php if($periksa_surat_pengantar_operasi == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">5</div></td>
					<td colspan="2" >Jenis dan Lokasi pembedahan dipastikan bersama pasien&nbsp;</td>
					<td colspan="2" ><input name="periksa_jenis_lokasi_pembedahan_ket" id="jns_lokasi" type="text" class="text_dt" size="102"  value="<?php echo $periksa_jenis_lokasi_pembedahan_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_jenis_lokasi_pembedahan" id="jns_lokasi1"  value="1" type="radio" <?php if($periksa_jenis_lokasi_pembedahan == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_jenis_lokasi_pembedahan" id="jns_lokasi1"  value="2" type="radio" <?php if($periksa_jenis_lokasi_pembedahan == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">6</div></td>

					<td colspan="2" >Masalah bahasa/ komunikasi&nbsp;</td>
					<td colspan="2" ><input name="periksa_masalah_komunikasi_ket" id="bahasa" type="text" class="text_dt" size="102"  value="<?php echo $periksa_masalah_komunikasi_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_masalah_komunikasi" id="bahasa1"  value="1" type="radio" <?php if($periksa_masalah_komunikasi == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_masalah_komunikasi" id="bahasa1"  value="2" type="radio" <?php if($periksa_masalah_komunikasi == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">7</div></td>
					<td colspan="2" >Periksa kelengkapan persetujuan pembedahan (surat ijin operasi)&nbsp;</td>
					<td colspan="2" ><input name="periksa_surat_ijin_operasi_ket" id="keleng_pembed" type="text" class="text_dt" size="102"  value="<?php echo $periksa_surat_ijin_operasi_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_surat_ijin_operasi" id="keleng_pembed1"  value="1" type="radio" <?php if($periksa_surat_ijin_operasi == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_surat_ijin_operasi" id="keleng_pembed1"  value="2" type="radio" <?php if($periksa_surat_ijin_operasi == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">8</div></td>
					<td colspan="2" >Periksa kelengkapan persetujuan anestesi&nbsp;</td>
					<td colspan="2" ><input name="periksa_persetujuan_anestesi_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $periksa_persetujuan_anestesi_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_persetujuan_anestesi" id="keleng_anes1"  value="1" type="radio" <?php if($periksa_persetujuan_anestesi == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_persetujuan_anestesi" id="keleng_anes1"  value="2" type="radio" <?php if($periksa_persetujuan_anestesi == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">9</div></td>
					<td  colspan="6">Periksa kelengkapan hasil konsultasi :&nbsp;</td>									
				<tr>
					<td><div align="center"></div></td>					
					<td >&nbsp;<br>					</td>
					<td >Internist</td>
					<td colspan="2"><input name="periksa_kelengkapan_internist_ket" id="periksa_kelengkapan_internist_ket" type="text" class="text_dt" size="102"  value="<?php echo $periksa_kelengkapan_internist_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_internist" id="internist1"  value="1" type="radio" <?php if($periksa_kelengkapan_internist == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_internist" id="internist1"  value="2" type="radio" <?php if($periksa_kelengkapan_internist == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center"></div></td>					
					<td>&nbsp;<br></td>
					<td>Anestesi</td>
					<td colspan="2"><input name="periksa_kelengkapan_anestesi_ket" id="internist" type="text" class="text_dt" size="102"  value="<?php echo $periksa_kelengkapan_anestesi_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_anestesi" id="internist1"  value="1" type="radio" <?php if($periksa_kelengkapan_anestesi == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_anestesi" id="internist1"  value="2" type="radio" <?php if($periksa_kelengkapan_anestesi == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center"></div></td>					
					<td>&nbsp;<br></td>
					<td>Lain-lain</td>
					<td colspan="2"><input name="periksa_kelengkapan_lain_ket" id="internist" type="text" class="text_dt" size="102"  value="<?php echo $periksa_kelengkapan_lain_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_lain" id="internist1"  value="1" type="radio" <?php if($periksa_kelengkapan_lain == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_lain" id="internist1"  value="2" type="radio" <?php if($periksa_kelengkapan_lain == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">10</div></td>
					<td colspan="2" >Surat ketersediaan HCU/ ICU bila dibutuhkan&nbsp;</td>
					<td colspan="2" ><input name="periksa_ketersediaan_hcu_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $periksa_ketersediaan_hcu_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_ketersediaan_hcu" id="keleng_anes1"  value="1" type="radio" <?php if($periksa_ketersediaan_hcu == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_ketersediaan_hcu" id="keleng_anes1"  value="2" type="radio" <?php if($periksa_ketersediaan_hcu == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">11</div></td>
					<td colspan="2" >Periksa kelengkapan rekam medik rawat inap/ rawat jalan&nbsp;</td>
					<td colspan="2" ><input name="periksa_kelengkapan_rm_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $periksa_kelengkapan_rm_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_rm" id="keleng_anes1"  value="1" type="radio" <?php if($periksa_kelengkapan_rm == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_rm" id="keleng_anes1"  value="2" type="radio" <?php if($periksa_kelengkapan_rm == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">12</div></td>
					<td colspan="2" >Periksa Kelengkapan X-ray/ CT-Scan/ MRI/ EKG/ Angiografi/ Echo&nbsp;</td>
					<td colspan="2" ><input name="periksa_kelengkapan_rothgen_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $periksa_kelengkapan_rothgen_ket; ?>" /></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_rothgen" id="keleng_anes1"  value="1" type="radio" <?php if($periksa_kelengkapan_rothgen == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="periksa_kelengkapan_rothgen" id="keleng_anes1"  value="2" type="radio" <?php if($periksa_kelengkapan_rothgen == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>		
		        <tr >
		          <td colspan="8" valign="top" style="font-weight:bold; ">&nbsp;</td>
  </tr>
        <tr >
			<td colspan="8">Persiapan Fisik Pasien</td>
		</tr>	
				<tr>
					<td><div align="center">1</div></td>
					<td colspan="2" >Puasa/ makan dan minum terakhir, Jam </td>
					<td colspan="2" ><input name="persiapan_puasa_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_puasa_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_puasa" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_puasa == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_puasa" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_puasa == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">2</div></td>
					<td colspan="2" >Prothese luar dilepaskan (gigi,palsu,lensa kontak)</td>
					<td colspan="2" ><input name="persiapan_prothese_luar_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_prothese_luar_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_prothese_luar" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_prothese_luar == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_prothese_luar" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_prothese_luar == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">3</div></td>
					<td colspan="2" >Menggunakan prothese dalam <br />(pacemaker, implant, prothese, panggul/ bahu, VP Shunt)&nbsp;</td>
					<td colspan="2" ><input name="persiapan_prothese_dalam_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_prothese_dalam_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_prothese_dalam" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_prothese_dalam == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_prothese_dalam" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_prothese_dalam == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">4</div></td>
					<td colspan="2" >Penjepit rambut/ cat kuku/ perhiasan dilepaskan&nbsp;</td>
					<td colspan="2" ><input name="persiapan_perhiasan_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_perhiasan_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_perhiasan" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_perhiasan == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_perhiasan" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_perhiasan == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">5</div></td>
					<td colspan="2" >Pengosongan kandung kemih/ clysma&nbsp;</td>
					<td colspan="2" ><input name="persiapan_pengosongan_kandung_kemih_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_pengosongan_kandung_kemih_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_pengosongan_kandung_kemih" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_pengosongan_kandung_kemih == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_pengosongan_kandung_kemih" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_pengosongan_kandung_kemih == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">6</div></td>
					<td colspan="2" >Memastikan persediaan darah&nbsp;</td>
					<td colspan="2" ><input name="persiapan_ketersediaan_kantung_darah_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_ketersediaan_kantung_darah_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_ketersediaan_kantung_darah" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_ketersediaan_kantung_darah == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_ketersediaan_kantung_darah" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_ketersediaan_kantung_darah == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">7</div></td>
					<td colspan="2" >Alat bantu (kacamata, alat bantu dengar) disimpan&nbsp;</td>
					<td colspan="2" ><input name="persiapan_alat_bantu_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_alat_bantu_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_alat_bantu" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_alat_bantu == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_alat_bantu" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_alat_bantu == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">8</div></td>
					<td colspan="2" >Obat yang disertakan&nbsp;</td>
					<td colspan="2" ><input name="persiapan_obat_disertakan_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_obat_disertakan_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_obat_disertakan" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_obat_disertakan == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_obat_disertakan" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_obat_disertakan == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">9</div></td>
					<td colspan="2" >Obat terakhir yang diberikan&nbsp;</td>
					<td colspan="2" ><input name="persiapan_obat_diberikan_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_obat_diberikan_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_obat_diberikan" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_obat_diberikan == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_obat_diberikan" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_obat_diberikan == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">10</div></td>
					<td colspan="2" >Vaskuleraksis&nbsp;</td>
					<td colspan="2" ><input name="persiapan_vaskuleraksis_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_vaskuleraksis_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_vaskuleraksis" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_vaskuleraksis == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_vaskuleraksis" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_vaskuleraksis == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
		        <tr >
		          <td colspan="8">&nbsp;</td>
  </tr>
        <tr >
			<td colspan="8">Persiapan Lain-lain</td>
			</tr>
				<tr>
					<td><div align="center">1</div></td>
					<td colspan="2" >Site Marking (terlampir)&nbsp;</td>
					<td colspan="2" ><input name="persiapan_site_marking_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_site_marking_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_site_marking" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_site_marking == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_site_marking" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_site_marking == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
				<tr>
					<td><div align="center">2</div></td>
					<td colspan="2" >Penjelasan singkat oleh dokter bedah <br />tentang prosedur yang akan dilakukan kepada pasien&nbsp;</td>
					<td colspan="2" ><input name="persiapan_penjelasan_dokter_ket" id="keleng_anes" type="text" class="text_dt" size="102"  value="<?php echo $persiapan_penjelasan_dokter_ket; ?>" /></td>
					<td><div align="center">
					  <input name="persiapan_penjelasan_dokter" id="keleng_anes1"  value="1" type="radio" <?php if($persiapan_penjelasan_dokter == '1') echo 'checked="checked"'; ?> >
				    </div></td>
					<td><div align="center">
					  <input name="persiapan_penjelasan_dokter" id="keleng_anes1"  value="2" type="radio" <?php if($persiapan_penjelasan_dokter == '2') echo 'checked="checked"'; ?> >
				    </div></td>
				</tr>
		<tr>
			<td colspan="9" align="right" style="font-size:15px; ">&nbsp;</td>
		</tr>
		<tr>
					<td>&nbsp;</td>
					<td>Perawat Ruangan</td>
					<td colspan="2" ><select name="perawat_ruangan" class="text_dt"  >
					<option value="" > -- </option>
					<?php echo getPelaksanaRanap($perawat_ruangan, $_SESSION['SES_SIMRS_UNIT_ID']); ?>
					</select></td>
					<td colspan="3" >Tanggal Jam
					&nbsp;<input name="perawat_ruangan_tanggal" id="puasa_mulai_1" type="text" size="8"  class="text_dt" value="<?php echo $perawat_ruangan_tanggal; ?>">&nbsp;
					&nbsp;&nbsp;Jam&nbsp;<select name="perawat_ruangan_jam" id="perawat_ruangan_jam"  style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getJam($perawat_ruangan_jam); ?>
												</select>
												<select name="perawat_ruangan_menit" id="perawat_ruangan_menit"  style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getMenit($perawat_ruangan_menit); ?>
												</select></td>
		</tr>
		<tr>
					<td>&nbsp;</td>
					<td>Perawat Kamar Bedah</td>
					<td colspan="2" ><select name="perawat_bedah" class="text_dt"  >
					<option value="" > -- </option>
					<?php echo getPelaksanaRanap($perawat_bedah, $_SESSION['SES_SIMRS_UNIT_ID']); ?>
					</select></td>
					<td colspan="3" >Tanggal Jam
					&nbsp;<input name="perawat_bedah_tanggal" id="kamar_bedah_1" type="text" size="8"  class="text_dt" value="<?php echo $perawat_bedah_tanggal; ?>">
					
					&nbsp;&nbsp;Jam&nbsp;<select name="perawat_bedah_jam" id="perawat_bedah_jam"  style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getJam($perawat_bedah_jam); ?>
												</select>
												<select name="perawat_bedah_menit" id="perawat_bedah_menit"  style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getMenit($perawat_bedah_menit); ?>
												</select></td>
		</tr>
		<tr>
					<td>&nbsp;</td>
					<td>Perawat Penerima</td>
					<td colspan="2" ><select name="perawat_penerima" class="text_dt"  >
					<option value="" > -- </option>
					<?php echo getPelaksanaRanap($perawat_penerima, $_SESSION['SES_SIMRS_UNIT_ID']); ?>
					</select></td>
					<td colspan="3" >Tanggal Jam
					&nbsp;<input name="perawat_penerima_tanggal" id="rencana_operasi_1" type="text" size="8" class="text_dt"  value="<?php echo $perawat_penerima_tanggal; ?>">
					
					&nbsp;&nbsp;Jam&nbsp;<select name="perawat_penerima_jam" id="perawat_penerima_jam"  style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getJam($perawat_penerima_jam); ?>
												</select>
												<select name="perawat_penerima_menit" id="perawat_penerima_menit"  style="width:50px;" class="text_dt" >
												<option value=""></option>
												<?php echo getMenit($perawat_penerima_menit); ?>
												</select></td>
		</tr>		
    </table>
</form>