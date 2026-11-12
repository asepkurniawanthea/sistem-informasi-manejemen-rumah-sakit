<?php
$askep_praoperasi_id = $_POST['askep_praoperasi_id'];
$tanda_vital_suhu = $_POST['tanda_vital_suhu'];
$tanda_vital_nadi = $_POST['tanda_vital_nadi'];
$tanda_vital_rr = $_POST['tanda_vital_rr'];
$tanda_vital_td = $_POST['tanda_vital_td'];
$tanda_vital_skor_nyeri = $_POST['tanda_vital_skor_nyeri'];
$tanda_vital_tb = $_POST['tanda_vital_tb'];
$tanda_vital_bb = $_POST['tanda_vital_bb'];
$kesadaran = '';
if(isset($_POST['kesadaran'])) $kesadaran = $_POST['kesadaran'];
$riwayat_penyakit_hipertensi = '';
if(isset($_POST['riwayat_penyakit_hipertensi'])) $riwayat_penyakit_hipertensi = $_POST['riwayat_penyakit_hipertensi'];
$riwayat_penyakit_diabetes = '';
if(isset($_POST['riwayat_penyakit_diabetes'])) $riwayat_penyakit_diabetes = $_POST['riwayat_penyakit_diabetes'];
$riwayat_penyakit_hepatitis = '';
if(isset($_POST['riwayat_penyakit_hepatitis'])) $riwayat_penyakit_hepatitis = $_POST['riwayat_penyakit_hepatitis'];
$riwayat_penyakit_lain = '';
if(isset($_POST['riwayat_penyakit_lain'])) $riwayat_penyakit_lain = $_POST['riwayat_penyakit_lain'];
$riwayat_penyakit_lain_ket = $_POST['riwayat_penyakit_lain_ket'];
$pengobatan_saat_ini = $_POST['pengobatan_saat_ini'];
$alat_bantu = $_POST['alat_bantu'];
$operasi_sebelum_jenis = $_POST['operasi_sebelum_jenis'];
$operasi_sebelum_kapan = $_POST['operasi_sebelum_kapan'];
$operasi_sebelum_di = $_POST['operasi_sebelum_di'];
$alergi = '';
if(isset($_POST['alergi'])) $alergi = $_POST['alergi'];
$alergi_ket = $_POST['alergi_ket'];
$hasil_lab_hb = '';
if(isset($_POST['hasil_lab_hb'])) $hasil_lab_hb = $_POST['hasil_lab_hb'];
$hasil_lab_bt = '';
if(isset($_POST['hasil_lab_bt'])) $hasil_lab_bt = $_POST['hasil_lab_bt'];
$hasil_lab_ct_aptt = '';
if(isset($_POST['hasil_lab_ct_aptt'])) $hasil_lab_ct_aptt = $_POST['hasil_lab_ct_aptt'];
$hasil_lab_urine = '';
if(isset($_POST['hasil_lab_urine'])) $hasil_lab_urine = $_POST['hasil_lab_urine'];
$hasil_lab_lain = '';
if(isset($_POST['hasil_lab_lain'])) $hasil_lab_lain = $_POST['hasil_lab_lain'];
$hasil_lab_lain_ket = $_POST['hasil_lab_lain_ket'];
$batuk_flu_demam = '';
if(isset($_POST['batuk_flu_demam'])) $batuk_flu_demam = $_POST['batuk_flu_demam'];
$sedang_haid = '';
if(isset($_POST['sedang_haid'])) $sedang_haid = $_POST['sedang_haid'];
$periksa_identitas = '';
if(isset($_POST['periksa_identitas'])) $periksa_identitas = $_POST['periksa_identitas'];
$periksa_identitas_ket = $_POST['periksa_identitas_ket'];
$periksa_gelang_identitas = '';
if(isset($_POST['periksa_gelang_identitas'])) $periksa_gelang_identitas = $_POST['periksa_gelang_identitas'];
$periksa_gelang_identitas_ket = $_POST['periksa_gelang_identitas_ket'];
$periksa_gelang_resiko = '';
if(isset($_POST['periksa_gelang_resiko'])) $periksa_gelang_resiko = $_POST['periksa_gelang_resiko'];
$periksa_gelang_resiko_ket = $_POST['periksa_gelang_resiko_ket'];
$periksa_surat_pengantar_operasi = '';
if(isset($_POST['periksa_surat_pengantar_operasi'])) $periksa_surat_pengantar_operasi = $_POST['periksa_surat_pengantar_operasi'];
$periksa_surat_pengantar_operasi_ket = $_POST['periksa_surat_pengantar_operasi_ket'];
$periksa_jenis_lokasi_pembedahan = '';
if(isset($_POST['periksa_jenis_lokasi_pembedahan'])) $periksa_jenis_lokasi_pembedahan = $_POST['periksa_jenis_lokasi_pembedahan'];
$periksa_jenis_lokasi_pembedahan_ket = $_POST['periksa_jenis_lokasi_pembedahan_ket'];
$periksa_masalah_komunikasi = '';
if(isset($_POST['periksa_masalah_komunikasi'])) $periksa_masalah_komunikasi = $_POST['periksa_masalah_komunikasi'];
$periksa_masalah_komunikasi_ket = $_POST['periksa_masalah_komunikasi_ket'];
$periksa_surat_ijin_operasi = '';
if(isset($_POST['periksa_surat_ijin_operasi'])) $periksa_surat_ijin_operasi = $_POST['periksa_surat_ijin_operasi'];
$periksa_surat_ijin_operasi_ket = $_POST['periksa_surat_ijin_operasi_ket'];
$periksa_persetujuan_anestesi = '';
if(isset($_POST['periksa_persetujuan_anestesi'])) $periksa_persetujuan_anestesi = $_POST['periksa_persetujuan_anestesi'];
$periksa_persetujuan_anestesi_ket = $_POST['periksa_persetujuan_anestesi_ket'];
$periksa_kelengkapan_internist = '';
if(isset($_POST['periksa_kelengkapan_internist'])) $periksa_kelengkapan_internist = $_POST['periksa_kelengkapan_internist'];
$periksa_kelengkapan_internist_ket = $_POST['periksa_kelengkapan_internist_ket'];
$periksa_kelengkapan_anestesi = '';
if(isset($_POST['periksa_kelengkapan_anestesi'])) $periksa_kelengkapan_anestesi = $_POST['periksa_kelengkapan_anestesi'];
$periksa_kelengkapan_anestesi_ket = $_POST['periksa_kelengkapan_anestesi_ket'];
$periksa_kelengkapan_lain = '';
if(isset($_POST['periksa_kelengkapan_lain'])) $periksa_kelengkapan_lain = $_POST['periksa_kelengkapan_lain'];
$periksa_kelengkapan_lain_ket = $_POST['periksa_kelengkapan_lain_ket'];
$periksa_ketersediaan_hcu = '';
if(isset($_POST['periksa_ketersediaan_hcu'])) $periksa_ketersediaan_hcu = $_POST['periksa_ketersediaan_hcu'];
$periksa_ketersediaan_hcu_ket = $_POST['periksa_ketersediaan_hcu_ket'];
$periksa_kelengkapan_rm = '';
if(isset($_POST['periksa_kelengkapan_rm'])) $periksa_kelengkapan_rm = $_POST['periksa_kelengkapan_rm'];
$periksa_kelengkapan_rm_ket = $_POST['periksa_kelengkapan_rm_ket'];
$periksa_kelengkapan_rothgen = '';
if(isset($_POST['periksa_kelengkapan_rothgen'])) $periksa_kelengkapan_rothgen = $_POST['periksa_kelengkapan_rothgen'];
$periksa_kelengkapan_rothgen_ket = $_POST['periksa_kelengkapan_rothgen_ket'];
$persiapan_puasa = '';
if(isset($_POST['persiapan_puasa'])) $persiapan_puasa = $_POST['persiapan_puasa'];
$persiapan_puasa_ket = $_POST['persiapan_puasa_ket'];
$persiapan_prothese_luar = '';
if(isset($_POST['persiapan_prothese_luar'])) $persiapan_prothese_luar = $_POST['persiapan_prothese_luar'];
$persiapan_prothese_luar_ket = $_POST['persiapan_prothese_luar_ket'];
$persiapan_prothese_dalam = '';
if(isset($_POST['persiapan_prothese_dalam'])) $persiapan_prothese_dalam = $_POST['persiapan_prothese_dalam'];
$persiapan_prothese_dalam_ket = $_POST['persiapan_prothese_dalam_ket'];
$persiapan_perhiasan = '';
if(isset($_POST['persiapan_perhiasan'])) $persiapan_perhiasan = $_POST['persiapan_perhiasan'];
$persiapan_perhiasan_ket = $_POST['persiapan_perhiasan_ket'];
$persiapan_pengosongan_kandung_kemih = '';
if(isset($_POST['persiapan_pengosongan_kandung_kemih'])) $persiapan_pengosongan_kandung_kemih = $_POST['persiapan_pengosongan_kandung_kemih'];
$persiapan_pengosongan_kandung_kemih_ket = $_POST['persiapan_pengosongan_kandung_kemih_ket'];
$persiapan_ketersediaan_kantung_darah = '';
if(isset($_POST['persiapan_ketersediaan_kantung_darah'])) $persiapan_ketersediaan_kantung_darah = $_POST['persiapan_ketersediaan_kantung_darah'];
$persiapan_ketersediaan_kantung_darah_ket = $_POST['persiapan_ketersediaan_kantung_darah_ket'];
$persiapan_alat_bantu = '';
if(isset($_POST['persiapan_alat_bantu'])) $persiapan_alat_bantu = $_POST['persiapan_alat_bantu'];
$persiapan_alat_bantu_ket = $_POST['persiapan_alat_bantu_ket'];
$persiapan_obat_disertakan = '';
if(isset($_POST['persiapan_obat_disertakan'])) $persiapan_obat_disertakan = $_POST['persiapan_obat_disertakan'];
$persiapan_obat_disertakan_ket = $_POST['persiapan_obat_disertakan_ket'];
$persiapan_obat_diberikan = '';
if(isset($_POST['persiapan_obat_diberikan'])) $persiapan_obat_diberikan = $_POST['persiapan_obat_diberikan'];
$persiapan_obat_diberikan_ket = $_POST['persiapan_obat_diberikan_ket'];
$persiapan_vaskuleraksis = '';
if(isset($_POST['persiapan_vaskuleraksis'])) $persiapan_vaskuleraksis = $_POST['persiapan_vaskuleraksis'];
$persiapan_vaskuleraksis_ket = $_POST['persiapan_vaskuleraksis_ket'];
$perawat_ruangan = $_POST['perawat_ruangan'];
$perawat_bedah = $_POST['perawat_bedah'];
$perawat_ruangan_tanggal = $_POST['perawat_ruangan_tanggal'];
$perawat_ruangan_jam = $_POST['perawat_ruangan_jam'];
$perawat_ruangan_menit = $_POST['perawat_ruangan_menit'];
$perawat_bedah_tanggal = $_POST['perawat_bedah_tanggal'];
$perawat_bedah_jam = $_POST['perawat_bedah_jam'];
$perawat_bedah_menit = $_POST['perawat_bedah_menit'];
$persiapan_site_marking = '';
if(isset($_POST['persiapan_site_marking'])) $persiapan_site_marking = $_POST['persiapan_site_marking'];
$persiapan_site_marking_ket = $_POST['persiapan_site_marking_ket'];
$persiapan_penjelasan_dokter = '';
if(isset($_POST['persiapan_penjelasan_dokter'])) $persiapan_penjelasan_dokter = $_POST['persiapan_penjelasan_dokter'];
$persiapan_penjelasan_dokter_ket = $_POST['persiapan_penjelasan_dokter_ket'];
$perawat_penerima = $_POST['perawat_penerima'];
$perawat_penerima_tanggal = $_POST['perawat_penerima_tanggal'];
$perawat_penerima_jam = $_POST['perawat_penerima_jam'];
$perawat_penerima_menit = $_POST['perawat_penerima_menit'];
	
$user_name = currentUser();
$operasi_id = $_POST['operasi_id'];
$irna_id = $_POST['irna_id'];

if(currentModul() == 'rawat inap'){
$_err = '';

if (empty($_err)) {
			$sql_cek_no_ranap = 'SELECT NO_RAWAT,NOMR,JENIS_BAYAR_ID,
								RUANG_ID,PEGAWAI_ID,
								PEGAWAI_RAWAT_ID,PEGAWAI_RAWAT_ID_2,PEGAWAI_RAWAT_ID_3	
								FROM t_irna WHERE IRNA_ID = "' . $irna_id . '"';
			$get_cek_no_ranap = mysql_query($sql_cek_no_ranap) or die(mysql_error());
			$dat_cek_no_ranap = mysql_fetch_assoc($get_cek_no_ranap);
			if (empty($dat_cek_no_ranap['NO_RAWAT'])){ 
				if(empty($askep_praoperasi_id)){
					mysql_query('INSERT INTO t_operasi_askep_praoperasi(IRNA_ID,OPERASI_ID,TANDA_VITAL_SUHU,TANDA_VITAL_NADI,
								TANDA_VITAL_RR,TANDA_VITAL_TD,TANDA_VITAL_SKOR_NYERI,TANDA_VITAL_TB,TANDA_VITAL_BB,KESADARAN,
								RIWAYAT_PENYAKIT_HIPERTENSI,RIWAYAT_PENYAKIT_DIABETES,RIWAYAT_PENYAKIT_HEPATITIS,RIWAYAT_PENYAKIT_LAIN,
								RIWAYAT_PENYAKIT_LAIN_KET,PENGOBATAN_SAAT_INI,ALAT_BANTU,OPERASI_SEBELUM_JENIS,OPERASI_SEBELUM_KAPAN,
								OPERASI_SEBELUM_DI,ALERGI,ALERGI_KET,HASIL_LAB_HB,HASIL_LAB_BT,HASIL_LAB_CT_APTT,HASIL_LAB_URINE,
								HASIL_LAB_LAIN,HASIL_LAB_LAIN_KET,BATUK_FLU_DEMAM,SEDANG_HAID,PERAWAT_RUANGAN,PERAWAT_RUANGAN_JAM,USER_RANAP)
								VALUES("' . $irna_id. '","' . $operasi_id. '","' . $tanda_vital_suhu. '","' . $tanda_vital_nadi. '","' . 
								$tanda_vital_rr. '","' . $tanda_vital_td. '","' . $tanda_vital_skor_nyeri. '","' . $tanda_vital_tb. '",
								"' . $tanda_vital_bb. '","' . $kesadaran. '","' . $riwayat_penyakit_hipertensi. '",
								"' . $riwayat_penyakit_diabetes. '","' . $riwayat_penyakit_hepatitis. '","' . $riwayat_penyakit_lain. '",
								"' . $riwayat_penyakit_lain_ket. '","' . $pengobatan_saat_ini. '","' . $alat_bantu. '","' . $operasi_sebelum_jenis. '",
								"' . $operasi_sebelum_kapan. '","' . $operasi_sebelum_di. '","' . $alergi. '","' . $alergi_ket. '","' . $hasil_lab_hb. '",
								"' . $hasil_lab_bt. '","' . $hasil_lab_ct_aptt. '","' . $hasil_lab_urine. '","' . $hasil_lab_lain. '",
								"' . $hasil_lab_lain_ket. '","' . $batuk_flu_demam. '","' . $sedang_haid. '","' . $perawat_ruangan. '",
								' . fieldDatetime($perawat_ruangan_tanggal . ' ' . $perawat_ruangan_jam . ':' . $perawat_ruangan_menit) . ',"' . $user_name . '")') or die(mysql_error());
				}else{
					mysql_query('UPDATE t_operasi_askep_praoperasi
							SET TANDA_VITAL_SUHU = "' . $tanda_vital_suhu . '",
							TANDA_VITAL_NADI = "' . $tanda_vital_nadi . '",
							TANDA_VITAL_RR = "' . $tanda_vital_rr . '",
							TANDA_VITAL_TD = "' . $tanda_vital_td . '",
							TANDA_VITAL_SKOR_NYERI = "' . $tanda_vital_skor_nyeri . '",
							TANDA_VITAL_TB = "' . $tanda_vital_tb . '",
							TANDA_VITAL_BB = "' . $tanda_vital_bb . '",
							KESADARAN = "' . $kesadaran . '",
							RIWAYAT_PENYAKIT_HIPERTENSI = "' . $riwayat_penyakit_hipertensi . '",
							RIWAYAT_PENYAKIT_DIABETES = "' . $riwayat_penyakit_diabetes . '",
							RIWAYAT_PENYAKIT_HEPATITIS = "' . $riwayat_penyakit_hepatitis . '",
							RIWAYAT_PENYAKIT_LAIN = "' . $riwayat_penyakit_lain . '",
							RIWAYAT_PENYAKIT_LAIN_KET = "' . $riwayat_penyakit_lain_ket . '",
							PENGOBATAN_SAAT_INI = "' . $pengobatan_saat_ini . '",
							ALAT_BANTU = "' . $alat_bantu . '",
							OPERASI_SEBELUM_JENIS = "' . $operasi_sebelum_jenis . '",
							OPERASI_SEBELUM_KAPAN = "' . $operasi_sebelum_kapan . '",
							OPERASI_SEBELUM_DI = "' . $operasi_sebelum_di . '",
							ALERGI = "' . $alergi . '",
							ALERGI_KET = "' . $alergi_ket . '",
							HASIL_LAB_HB = "' . $hasil_lab_hb . '",
							HASIL_LAB_BT = "' . $hasil_lab_bt . '",
							HASIL_LAB_CT_APTT = "' . $hasil_lab_ct_aptt . '",
							HASIL_LAB_URINE = "' . $hasil_lab_urine . '",
							HASIL_LAB_LAIN = "' . $hasil_lab_lain . '",
							HASIL_LAB_LAIN_KET = "' . $hasil_lab_lain_ket . '",
							BATUK_FLU_DEMAM = "' . $batuk_flu_demam . '",
							SEDANG_HAID = "' . $sedang_haid . '",
							PERAWAT_RUANGAN = "' . $perawat_ruangan . '",
							PERAWAT_RUANGAN_JAM = ' . fieldDatetime($perawat_ruangan_tanggal . ' ' . $perawat_ruangan_jam . ':' . $perawat_ruangan_menit) . ',
							USER_RANAP = "' . $user_name . '"
							WHERE ASKEP_PRAOPERASI_ID = "' . $askep_praoperasi_id . '"') or die(mysql_error());
				}
				
			?>
			<script language="JavaScript" >
				alert('Simpan Data Catatan Keperawatan Pra Operasi Berhasil.');
				window.location = "<?php echo currentUrl(); ?>";
			</script>
			<?php
			}		

} else {
    $msg_info = $_err;
}
}

if(currentModul() == 'kamar operasi'){
	$sql_cek_no_operasi = 'SELECT NO_OPERASI FROM t_operasi WHERE OPERASI_ID = "' . $operasi_id . '"';
	$get_cek_no_operasi = mysql_query($sql_cek_no_operasi) or die(mysql_error());
	$dat_cek_no_operasi = mysql_fetch_assoc($get_cek_no_operasi);
	if (empty($dat_cek_no_operasi['NO_OPERASI']) or $_SESSION['SES_SIMRS_ADMIN'] == '1') {
	
	$_err = '';
	if (empty($_err)) {
		if(empty($askep_praoperasi_id)){
			mysql_query('INSERT INTO t_operasi_askep_praoperasi(IRNA_ID,OPERASI_ID,PERIKSA_IDENTITAS,PERIKSA_IDENTITAS_KET,
						PERIKSA_GELANG_IDENTITAS,PERIKSA_GELANG_IDENTITAS_KET,PERIKSA_GELANG_RESIKO,PERIKSA_GELANG_RESIKO_KET,
						PERIKSA_SURAT_PENGANTAR_OPERASI,PERIKSA_SURAT_PENGANTAR_OPERASI_KET,PERIKSA_JENIS_LOKASI_PEMBEDAHAN,
						PERIKSA_JENIS_LOKASI_PEMBEDAHAN_KET,PERIKSA_MASALAH_KOMUNIKASI,PERIKSA_MASALAH_KOMUNIKASI_KET,PERIKSA_SURAT_IJIN_OPERASI,
						PERIKSA_SURAT_IJIN_OPERASI_KET,PERIKSA_PERSETUJUAN_ANESTESI,PERIKSA_PERSETUJUAN_ANESTESI_KET,
						PERIKSA_KELENGKAPAN_INTERNIST,PERIKSA_KELENGKAPAN_INTERNIST_KET,PERIKSA_KELENGKAPAN_ANESTESI,PERIKSA_KELENGKAPAN_ANESTESI_KET,
						PERIKSA_KELENGKAPAN_LAIN,PERIKSA_KELENGKAPAN_LAIN_KET,PERIKSA_KETERSEDIAAN_HCU,PERIKSA_KETERSEDIAAN_HCU_KET,
						PERIKSA_KELENGKAPAN_RM,PERIKSA_KELENGKAPAN_RM_KET,PERIKSA_KELENGKAPAN_ROTHGEN,PERIKSA_KELENGKAPAN_ROTHGEN_KET,
						PERSIAPAN_PUASA,PERSIAPAN_PUASA_KET,PERSIAPAN_PROTHESE_LUAR,PERSIAPAN_PROTHESE_LUAR_KET,PERSIAPAN_PROTHESE_DALAM,
						PERSIAPAN_PROTHESE_DALAM_KET,PERSIAPAN_PERHIASAN,PERSIAPAN_PERHIASAN_KET,PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH,
						PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH_KET,PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH,PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH_KET,
						PERSIAPAN_ALAT_BANTU,PERSIAPAN_ALAT_BANTU_KET,PERSIAPAN_OBAT_DISERTAKAN,PERSIAPAN_OBAT_DISERTAKAN_KET,
						PERSIAPAN_OBAT_DIBERIKAN,PERSIAPAN_OBAT_DIBERIKAN_KET,PERSIAPAN_VASKULERAKSIS,PERSIAPAN_VASKULERAKSIS_KET,
						PERAWAT_BEDAH,PERAWAT_BEDAH_JAM,PERSIAPAN_SITE_MARKING,PERSIAPAN_SITE_MARKING_KET,PERSIAPAN_PENJELASAN_DOKTER,
						PERSIAPAN_PENJELASAN_DOKTER_KET,PERAWAT_PENERIMA,PERAWAT_PENERIMA_JAM,USER_OPERASI)
						VALUES("' . $irna_id . '","' . $operasi_id . '","' . $periksa_identitas . '","' . $periksa_identitas_ket . '",
						"' . $periksa_gelang_identitas . '","' . $periksa_gelang_identitas_ket . '","' . $periksa_gelang_resiko . '",
						"' . $periksa_gelang_resiko_ket . '","' . $periksa_surat_pengantar_operasi . '","' . $periksa_surat_pengantar_operasi_ket . '",
						"' . $periksa_jenis_lokasi_pembedahan . '","' . $periksa_jenis_lokasi_pembedahan_ket . '","' . $periksa_masalah_komunikasi . '",
						"' . $periksa_masalah_komunikasi_ket . '","' . $periksa_surat_ijin_operasi . '","' . $periksa_surat_ijin_operasi_ket . '",
						"' . $periksa_persetujuan_anestesi . '","' . $periksa_persetujuan_anestesi_ket . '","' . $periksa_kelengkapan_internist . '",
						"' . $periksa_kelengkapan_internist_ket . '","' . $periksa_kelengkapan_anestesi . '","' . $periksa_kelengkapan_anestesi_ket . '",
						"' . $periksa_kelengkapan_lain . '","' . $periksa_kelengkapan_lain_ket . '","' . $periksa_ketersediaan_hcu . '",
						"' . $periksa_ketersediaan_hcu_ket . '","' . $periksa_kelengkapan_rm . '","' . $periksa_kelengkapan_rm_ket . '",
						"' . $periksa_kelengkapan_rothgen . '","' . $periksa_kelengkapan_rothgen_ket . '","' . $persiapan_puasa . '",
						"' . $persiapan_puasa_ket . '","' . $persiapan_prothese_luar . '","' . $persiapan_prothese_luar_ket . '",
						"' . $persiapan_prothese_dalam . '","' . $persiapan_prothese_dalam_ket . '","' . $persiapan_perhiasan . '",
						"' . $persiapan_perhiasan_ket . '","' . $persiapan_pengosongan_kandung_kemih . '","' . $persiapan_pengosongan_kandung_kemih_ket . '",
						"' . $persiapan_ketersediaan_kantung_darah . '","' . $persiapan_ketersediaan_kantung_darah_ket . '",
						"' . $persiapan_alat_bantu . '","' . $persiapan_alat_bantu_ket . '","' . $persiapan_obat_disertakan . '",
						"' . $persiapan_obat_disertakan_ket . '","' . $persiapan_obat_diberikan . '","' . $persiapan_obat_diberikan_ket . '",
						"' . $persiapan_vaskuleraksis . '","' . $persiapan_vaskuleraksis_ket . '","' . $perawat_bedah . '",
						' . fieldDatetime($perawat_bedah_tanggal . ' ' . $perawat_bedah_jam . ':' . $perawat_bedah_menit) . ',
						"' . $persiapan_site_marking . '","' . $persiapan_site_marking_ket . '",
						"' . $persiapan_penjelasan_dokter . '","' . $persiapan_penjelasan_dokter_ket . '","' . $perawat_penerima . '",
						' . fieldDatetime($perawat_penerima_tanggal . ' ' . $perawat_penerima_jam . ':' . $perawat_penerima_menit) . ',"' . $user_name . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_operasi_askep_praoperasi
						SET PERIKSA_IDENTITAS = "' . $periksa_identitas . '",
						  PERIKSA_IDENTITAS_KET = "' . $periksa_identitas_ket . '",
						  PERIKSA_GELANG_IDENTITAS = "' . $periksa_gelang_identitas . '",
						  PERIKSA_GELANG_IDENTITAS_KET = "' . $periksa_gelang_identitas_ket . '",
						  PERIKSA_GELANG_RESIKO = "' . $periksa_gelang_resiko . '",
						  PERIKSA_GELANG_RESIKO_KET = "' . $periksa_gelang_resiko_ket . '",
						  PERIKSA_SURAT_PENGANTAR_OPERASI = "' . $periksa_surat_pengantar_operasi . '",
						  PERIKSA_SURAT_PENGANTAR_OPERASI_KET = "' . $periksa_surat_pengantar_operasi_ket . '",
						  PERIKSA_JENIS_LOKASI_PEMBEDAHAN = "' . $periksa_jenis_lokasi_pembedahan . '",
						  PERIKSA_JENIS_LOKASI_PEMBEDAHAN_KET = "' . $periksa_jenis_lokasi_pembedahan_ket . '",
						  PERIKSA_MASALAH_KOMUNIKASI = "' . $periksa_masalah_komunikasi . '",
						  PERIKSA_MASALAH_KOMUNIKASI_KET = "' . $periksa_masalah_komunikasi_ket . '",
						  PERIKSA_SURAT_IJIN_OPERASI = "' . $periksa_surat_ijin_operasi . '",
						  PERIKSA_SURAT_IJIN_OPERASI_KET = "' . $periksa_surat_ijin_operasi_ket . '",
						  PERIKSA_PERSETUJUAN_ANESTESI = "' . $periksa_persetujuan_anestesi . '",
						  PERIKSA_PERSETUJUAN_ANESTESI_KET = "' . $periksa_persetujuan_anestesi_ket . '",
						  PERIKSA_KELENGKAPAN_INTERNIST = "' . $periksa_kelengkapan_internist . '",
						  PERIKSA_KELENGKAPAN_INTERNIST_KET = "' . $periksa_kelengkapan_internist_ket . '",
						  PERIKSA_KELENGKAPAN_ANESTESI = "' . $periksa_kelengkapan_anestesi . '",
						  PERIKSA_KELENGKAPAN_ANESTESI_KET = "' . $periksa_kelengkapan_anestesi_ket . '",
						  PERIKSA_KELENGKAPAN_LAIN = "' . $periksa_kelengkapan_lain . '",
						  PERIKSA_KELENGKAPAN_LAIN_KET = "' . $periksa_kelengkapan_lain_ket . '",
						  PERIKSA_KETERSEDIAAN_HCU = "' . $periksa_ketersediaan_hcu . '",
						  PERIKSA_KETERSEDIAAN_HCU_KET = "' . $periksa_ketersediaan_hcu_ket . '",
						  PERIKSA_KELENGKAPAN_RM = "' . $periksa_kelengkapan_rm . '",
						  PERIKSA_KELENGKAPAN_RM_KET = "' . $periksa_kelengkapan_rm_ket . '",
						  PERIKSA_KELENGKAPAN_ROTHGEN = "' . $periksa_kelengkapan_rothgen . '",
						  PERIKSA_KELENGKAPAN_ROTHGEN_KET = "' . $periksa_kelengkapan_rothgen_ket . '",
						  PERSIAPAN_PUASA = "' . $persiapan_puasa . '",
						  PERSIAPAN_PUASA_KET = "' . $persiapan_puasa_ket . '",
						  PERSIAPAN_PROTHESE_LUAR = "' . $persiapan_prothese_luar . '",
						  PERSIAPAN_PROTHESE_LUAR_KET = "' . $persiapan_prothese_luar_ket . '",
						  PERSIAPAN_PROTHESE_DALAM = "' . $persiapan_prothese_dalam . '",
						  PERSIAPAN_PROTHESE_DALAM_KET = "' . $persiapan_prothese_dalam_ket . '",
						  PERSIAPAN_PERHIASAN = "' . $persiapan_perhiasan . '",
						  PERSIAPAN_PERHIASAN_KET = "' . $persiapan_perhiasan_ket . '",
						  PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH = "' . $persiapan_pengosongan_kandung_kemih . '",
						  PERSIAPAN_PENGOSONGAN_KANDUNG_KEMIH_KET = "' . $persiapan_pengosongan_kandung_kemih_ket . '",
						  PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH = "' . $persiapan_ketersediaan_kantung_darah . '",
						  PERSIAPAN_KETERSEDIAAN_KANTUNG_DARAH_KET = "' . $persiapan_ketersediaan_kantung_darah_ket . '",
						  PERSIAPAN_ALAT_BANTU = "' . $persiapan_alat_bantu . '",
						  PERSIAPAN_ALAT_BANTU_KET = "' . $persiapan_alat_bantu_ket . '",
						  PERSIAPAN_OBAT_DISERTAKAN = "' . $persiapan_obat_disertakan . '",
						  PERSIAPAN_OBAT_DISERTAKAN_KET = "' . $persiapan_obat_disertakan_ket . '",
						  PERSIAPAN_OBAT_DIBERIKAN = "' . $persiapan_obat_diberikan . '",
						  PERSIAPAN_OBAT_DIBERIKAN_KET = "' . $persiapan_obat_diberikan_ket . '",
						  PERSIAPAN_VASKULERAKSIS = "' . $persiapan_vaskuleraksis . '",
						  PERSIAPAN_VASKULERAKSIS_KET = "' . $persiapan_vaskuleraksis_ket . '",
						  PERAWAT_BEDAH = "' . $perawat_bedah . '",
						  PERAWAT_BEDAH_JAM = ' . fieldDatetime($perawat_bedah_tanggal . ' ' . $perawat_bedah_jam . ':' . $perawat_bedah_menit) . ',
						  PERSIAPAN_SITE_MARKING = "' . $persiapan_site_marking . '",
						  PERSIAPAN_SITE_MARKING_KET = "' . $persiapan_site_marking_ket . '",
						  PERSIAPAN_PENJELASAN_DOKTER = "' . $persiapan_penjelasan_dokter . '",
						  PERSIAPAN_PENJELASAN_DOKTER_KET = "' . $persiapan_penjelasan_dokter_ket . '",
						  PERAWAT_PENERIMA = "' . $perawat_penerima . '",
						  PERAWAT_PENERIMA_JAM = ' . fieldDatetime($perawat_penerima_tanggal . ' ' . $perawat_penerima_jam . ':' . $perawat_penerima_menit) . ',
						  USER_OPERASI = "' . $user_name . '"
						  WHERE ASKEP_PRAOPERASI_ID = "' . $askep_praoperasi_id . '"') or die(mysql_error());
		}			  
?>
<script language="JavaScript" >
	alert('Simpan Data Catatan Keperawatan Pra Operasi Jatuh Berhasil.');
	window.location = "<?php echo currentUrl(); ?>";
</script>
<?php			
		}else{
			$msg_info = $_err;
		}
	}
}
?>