<?php 
if (isset($_POST['irna_id']) and $pam == '2'){
	mysql_query('UPDATE t_irna SET PAM = "2" WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());

	$st_save = true;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['final'])) $st_final = '"1"';
		
		$cara_masuk = '';
		if(isset($_POST['cara_masuk'])) $cara_masuk = $_POST['cara_masuk'];

		$riwayat_menstruasi = array('riwayat'=>replace_quote($_POST['ds_riwayat_menstruasi']),
						'usia_menarche'=>replace_quote($_POST['ds_usia_menarche']),
						'lama_haid'=>replace_quote($_POST['ds_lama_haid']),
						'darah_haid'=>replace_quote($_POST['ds_darah_haid']),
						'hpht'=>replace_quote($_POST['ds_hpht']),
						'tp'=>replace_quote($_POST['ds_tp']),
						'dismenorhoe'=>((isset($_POST['dismenorhoe'])) ? $_POST['dismenorhoe'] : ''),
						'spoting'=>((isset($_POST['spoting'])) ? $_POST['spoting'] : ''),
						'menorraghia'=>((isset($_POST['menorraghia'])) ? $_POST['menorraghia'] : ''),
						'metrorhagia'=>((isset($_POST['metrorhagia'])) ? $_POST['metrorhagia'] : ''),
						'syndrome'=>((isset($_POST['syndrome'])) ? $_POST['syndrome'] : ''));
		$riwayat_menstruasi = json_encode($riwayat_menstruasi);
		$riwayat_menstruasi = str_replace('"','|',$riwayat_menstruasi);

		$riwayat_hamil_ini = array('riwayat'=>replace_quote($_POST['ds_riwayat_hamil_ini']),
						'hm_mual'=>((isset($_POST['hm_mual'])) ? $_POST['hm_mual'] : ''),
						'hm_muntah'=>((isset($_POST['hm_muntah'])) ? $_POST['hm_muntah'] : ''),
						'hm_pendarahan'=>((isset($_POST['hm_pendarahan'])) ? $_POST['hm_pendarahan'] : ''),
						'hm_lainlain'=>((isset($_POST['hm_lainlain'])) ? $_POST['hm_lainlain'] : ''),
						'hm_ket_lainlain'=>replace_quote($_POST['hm_ket_lainlain']),
						'ht_pusing'=>((isset($_POST['ht_pusing'])) ? $_POST['ht_pusing'] : ''),
						'ht_sakit_kepala'=>((isset($_POST['ht_sakit_kepala'])) ? $_POST['ht_sakit_kepala'] : ''),
						'ht_pendarahan'=>((isset($_POST['ht_pendarahan'])) ? $_POST['ht_pendarahan'] : ''),
						'ht_lainlain'=>((isset($_POST['ht_lainlain'])) ? $_POST['ht_lainlain'] : ''),
						'ht_ket_lainlain'=>replace_quote($_POST['ht_ket_lainlain']),
						'gj_pertama'=>replace_quote($_POST['gj_pertama']),
						'gj_terakhir'=>replace_quote($_POST['gj_terakhir']),
						'tanda_penyulit'=>replace_quote($_POST['tanda_penyulit']),
						'obat_jamu'=>replace_quote($_POST['obat_jamu']),
						'keluhan_bak'=>replace_quote($_POST['keluhan_bak']),
						'keluhan_bab'=>replace_quote($_POST['keluhan_bab']),
						'kehawatiran'=>replace_quote($_POST['kehawatiran']));
		$riwayat_hamil_ini = json_encode($riwayat_hamil_ini);
		$riwayat_hamil_ini = str_replace('"','|',$riwayat_hamil_ini);	
		
		$riwayat_hamil_dhl = array('riwayat'=>replace_quote($_POST['ds_riwayat_hamil_dhl']),
						'ds_rh_g'=>replace_quote($_POST['ds_rh_g']),
						'ds_rh_p'=>replace_quote($_POST['ds_rh_p']),
						'ds_rh_a'=>replace_quote($_POST['ds_rh_a']),
						'ds_rh_hidup'=>replace_quote($_POST['ds_rh_hidup']),
						'partus'=>array(1=>array('ds_waktu_partus'=>replace_quote($_POST['ds_waktu_partus_1']),
							'ds_tempat_partus'=>replace_quote($_POST['ds_tempat_partus_1']),
							'ds_umur_partus'=>replace_quote($_POST['ds_umur_partus_1']),
							'ds_jenis_partus'=>replace_quote($_POST['ds_jenis_partus_1']),
							'ds_penolong_partus'=>replace_quote($_POST['ds_penolong_partus_1']),
							'ds_penyulit_partus'=>replace_quote($_POST['ds_penyulit_partus_1']),
							'ds_sex_partus'=>replace_quote($_POST['ds_sex_partus_1']),
							'ds_bb_partus'=>replace_quote($_POST['ds_bb_partus_1']),
							'ds_keadaan_partus'=>replace_quote($_POST['ds_keadaan_partus_1'])),
						2=>array('ds_waktu_partus'=>replace_quote($_POST['ds_waktu_partus_2']),
							'ds_tempat_partus'=>replace_quote($_POST['ds_tempat_partus_2']),
							'ds_umur_partus'=>replace_quote($_POST['ds_umur_partus_2']),
							'ds_jenis_partus'=>replace_quote($_POST['ds_jenis_partus_2']),
							'ds_penolong_partus'=>replace_quote($_POST['ds_penolong_partus_2']),
							'ds_penyulit_partus'=>replace_quote($_POST['ds_penyulit_partus_2']),
							'ds_sex_partus'=>replace_quote($_POST['ds_sex_partus_2']),
							'ds_bb_partus'=>replace_quote($_POST['ds_bb_partus_2']),
							'ds_keadaan_partus'=>replace_quote($_POST['ds_keadaan_partus_2'])),
						3=>array('ds_waktu_partus'=>replace_quote($_POST['ds_waktu_partus_3']),
							'ds_tempat_partus'=>replace_quote($_POST['ds_tempat_partus_3']),
							'ds_umur_partus'=>replace_quote($_POST['ds_umur_partus_3']),
							'ds_jenis_partus'=>replace_quote($_POST['ds_jenis_partus_3']),
							'ds_penolong_partus'=>replace_quote($_POST['ds_penolong_partus_3']),
							'ds_penyulit_partus'=>replace_quote($_POST['ds_penyulit_partus_3']),
							'ds_sex_partus'=>replace_quote($_POST['ds_sex_partus_3']),
							'ds_bb_partus'=>replace_quote($_POST['ds_bb_partus_3']),
							'ds_keadaan_partus'=>replace_quote($_POST['ds_keadaan_partus_3'])),
						4=>array('ds_waktu_partus'=>replace_quote($_POST['ds_waktu_partus_4']),
							'ds_tempat_partus'=>replace_quote($_POST['ds_tempat_partus_4']),
							'ds_umur_partus'=>replace_quote($_POST['ds_umur_partus_4']),
							'ds_jenis_partus'=>replace_quote($_POST['ds_jenis_partus_4']),
							'ds_penolong_partus'=>replace_quote($_POST['ds_penolong_partus_4']),
							'ds_penyulit_partus'=>replace_quote($_POST['ds_penyulit_partus_4']),
							'ds_sex_partus'=>replace_quote($_POST['ds_sex_partus_4']),
							'ds_bb_partus'=>replace_quote($_POST['ds_bb_partus_4']),
							'ds_keadaan_partus'=>replace_quote($_POST['ds_keadaan_partus_4'])),
						5=>array('ds_waktu_partus'=>replace_quote($_POST['ds_waktu_partus_5']),
							'ds_tempat_partus'=>replace_quote($_POST['ds_tempat_partus_5']),
							'ds_umur_partus'=>replace_quote($_POST['ds_umur_partus_5']),
							'ds_jenis_partus'=>replace_quote($_POST['ds_jenis_partus_5']),
							'ds_penolong_partus'=>replace_quote($_POST['ds_penolong_partus_5']),
							'ds_penyulit_partus'=>replace_quote($_POST['ds_penyulit_partus_5']),
							'ds_sex_partus'=>replace_quote($_POST['ds_sex_partus_5']),
							'ds_bb_partus'=>replace_quote($_POST['ds_bb_partus_5']),
							'ds_keadaan_partus'=>replace_quote($_POST['ds_keadaan_partus_5'])),
						6=>array('ds_waktu_partus'=>replace_quote($_POST['ds_waktu_partus_6']),
							'ds_tempat_partus'=>replace_quote($_POST['ds_tempat_partus_6']),
							'ds_umur_partus'=>replace_quote($_POST['ds_umur_partus_6']),
							'ds_jenis_partus'=>replace_quote($_POST['ds_jenis_partus_6']),
							'ds_penolong_partus'=>replace_quote($_POST['ds_penolong_partus_6']),
							'ds_penyulit_partus'=>replace_quote($_POST['ds_penyulit_partus_6']),
							'ds_sex_partus'=>replace_quote($_POST['ds_sex_partus_6']),
							'ds_bb_partus'=>replace_quote($_POST['ds_bb_partus_6']),
							'ds_keadaan_partus'=>replace_quote($_POST['ds_keadaan_partus_6'])),	
						7=>array('ds_waktu_partus'=>replace_quote($_POST['ds_waktu_partus_7']),
							'ds_tempat_partus'=>replace_quote($_POST['ds_tempat_partus_7']),
							'ds_umur_partus'=>replace_quote($_POST['ds_umur_partus_7']),
							'ds_jenis_partus'=>replace_quote($_POST['ds_jenis_partus_7']),
							'ds_penolong_partus'=>replace_quote($_POST['ds_penolong_partus_7']),
							'ds_penyulit_partus'=>replace_quote($_POST['ds_penyulit_partus_7']),
							'ds_sex_partus'=>replace_quote($_POST['ds_sex_partus_7']),
							'ds_bb_partus'=>replace_quote($_POST['ds_bb_partus_7']),
							'ds_keadaan_partus'=>replace_quote($_POST['ds_keadaan_partus_7']))));
		$riwayat_hamil_dhl = json_encode($riwayat_hamil_dhl);
		$riwayat_hamil_dhl = str_replace('"','|',$riwayat_hamil_dhl);
		
		$riwayat_penyakit = array('riwayat'=>replace_quote($_POST['ds_riwayat_penyakit']),
						'pernah_dirawat'=>replace_quote($_POST['ds_pernah_dirawat']),
						'kapan_dirawat'=>replace_quote($_POST['ds_kapan_dirawat']),
						'dimana_dirawat'=>replace_quote($_POST['ds_dimana_dirawat']),
						'pernah_operasi'=>replace_quote($_POST['ds_pernah_operasi']),
						'kapan_operasi'=>replace_quote($_POST['ds_kapan_operasi']),
						'dimana_operasi'=>replace_quote($_POST['ds_dimana_operasi']));
		$riwayat_penyakit = json_encode($riwayat_penyakit);
		$riwayat_penyakit = str_replace('"','|',$riwayat_penyakit);
		
		$status_kawin = array('status_kawin'=>((isset($_POST['ds_status_kawin'])) ? $_POST['ds_status_kawin'] : ''),
						'kali_kawin'=>replace_quote($_POST['ds_kali_kawin']),
						'usia_kawin'=>replace_quote($_POST['ds_usia_kawin']));
		$status_kawin = json_encode($status_kawin);
		$status_kawin = str_replace('"','|',$status_kawin);
		
		$riwayat_sosial = array('respon_ibu'=>replace_quote($_POST['respon_ibu']),
						'keputusan'=>replace_quote($_POST['keputusan']),
						'beban_kerja'=>replace_quote($_POST['beban_kerja']),
						'tempat_persalinan'=>replace_quote($_POST['tempat_persalinan']),
						'penghasilan'=>replace_quote($_POST['penghasilan']));
		$riwayat_sosial = json_encode($riwayat_sosial);
		$riwayat_sosial = str_replace('"','|',$riwayat_sosial);
		
		$riwayat_kb = array('metode_kb'=>replace_quote($_POST['metode_kb']),
						'lama_kb'=>replace_quote($_POST['lama_kb']),
						'komplikasi_kb'=>replace_quote($_POST['komplikasi_kb']));
		$riwayat_kb = json_encode($riwayat_kb);
		$riwayat_kb = str_replace('"','|',$riwayat_kb);
		
		$riwayat_ginekologi = array('infertilitas'=>((isset($_POST['infertilitas'])) ? $_POST['infertilitas'] : ''),
						'infeksi_virus'=>((isset($_POST['infeksi_virus'])) ? $_POST['infeksi_virus'] : ''),
						'pms'=>((isset($_POST['pms'])) ? $_POST['pms'] : ''),
						'endometriosis'=>((isset($_POST['endometriosis'])) ? $_POST['endometriosis'] : ''),
						'polip'=>((isset($_POST['polip'])) ? $_POST['polip'] : ''),
						'kanker'=>((isset($_POST['kanker'])) ? $_POST['kanker'] : ''),
						'operasi_kandungan'=>((isset($_POST['operasi_kandungan'])) ? $_POST['operasi_kandungan'] : ''),
						'perkosaan'=>((isset($_POST['perkosaan'])) ? $_POST['perkosaan'] : ''));
		$riwayat_ginekologi = json_encode($riwayat_ginekologi);
		$riwayat_ginekologi = str_replace('"','|',$riwayat_ginekologi);
		
		$riwayat_pola_makan = array('pola_makan'=>replace_quote($_POST['pola_makan']),
						'pola_minum'=>replace_quote($_POST['pola_minum']),
						'alkohol'=>((isset($_POST['alkohol'])) ? $_POST['alkohol'] : ''),
						'jamu'=>((isset($_POST['jamu'])) ? $_POST['jamu'] : ''),
						'kopi'=>((isset($_POST['kopi'])) ? $_POST['kopi'] : ''),
						'pola_bak'=>replace_quote($_POST['pola_bak']),
						'warna_bak'=>replace_quote($_POST['warna_bak']),
						'jam_bak'=>replace_quote($_POST['jam_bak']),
						'pola_bab'=>replace_quote($_POST['pola_bab']),
						'warna_bab'=>replace_quote($_POST['warna_bab']),
						'jam_bab'=>replace_quote($_POST['jam_bab']),
						'pola_istirahat'=>replace_quote($_POST['pola_istirahat']),
						'jam_tidur'=>replace_quote($_POST['jam_tidur']),
						'terima_kehamilan'=>replace_quote($_POST['terima_kehamilan']),
						'dk_suami'=>((isset($_POST['dk_suami'])) ? $_POST['dk_suami'] : ''),
						'dk_ortu'=>((isset($_POST['dk_ortu'])) ? $_POST['dk_ortu'] : ''),
						'dk_mertua'=>((isset($_POST['dk_mertua'])) ? $_POST['dk_mertua'] : ''),
						'dk_kellain'=>((isset($_POST['dk_kellain'])) ? $_POST['dk_kellain'] : ''));
		$riwayat_pola_makan = json_encode($riwayat_pola_makan);
		$riwayat_pola_makan = str_replace('"','|',$riwayat_pola_makan);
		
		$pemeriksaan_umum = array('keadaan_umum'=>replace_quote($_POST['keadaan_umum']),
						'kesadaran'=>replace_quote($_POST['kesadaran']),
						'pem_td'=>replace_quote($_POST['pem_td']),
						'pem_nadi'=>replace_quote($_POST['pem_nadi']),
						'pem_suhu'=>replace_quote($_POST['pem_suhu']),
						'pem_napas'=>replace_quote($_POST['pem_napas']),
						'pem_bb_sb'=>replace_quote($_POST['pem_bb_sb']),
						'pem_bb_sk'=>replace_quote($_POST['pem_bb_sk']),
						'pem_tb'=>replace_quote($_POST['pem_tb']),
						'pem_lila'=>replace_quote($_POST['pem_lila']));
		$pemeriksaan_umum = json_encode($pemeriksaan_umum);
		$pemeriksaan_umum = str_replace('"','|',$pemeriksaan_umum);
		
		$pemeriksaan_fisik = array('mata_konjuntiva'=>replace_quote($_POST['mata_konjuntiva']),
						'mata_sklera'=>replace_quote($_POST['mata_sklera']),
						'mata_kabur'=>((isset($_POST['mata_kabur'])) ? $_POST['mata_kabur'] : ''),
						'mata_dua'=>((isset($_POST['mata_dua'])) ? $_POST['mata_dua'] : ''),
						'rahang'=>replace_quote($_POST['rahang']),
						'leher'=>replace_quote($_POST['leher']),
						'dada_mamae'=>((isset($_POST['dada_mamae'])) ? $_POST['dada_mamae'] : ''),
						'dada_serola'=>((isset($_POST['dada_serola'])) ? $_POST['dada_serola'] : ''),
						'dada_tumor'=>((isset($_POST['dada_tumor'])) ? $_POST['dada_tumor'] : ''),
						'dada_kolostrum'=>((isset($_POST['dada_kolostrum'])) ? $_POST['dada_kolostrum'] : ''),
						'dada_puting'=>((isset($_POST['dada_puting'])) ? $_POST['dada_puting'] : ''),
						'ekt_tungkai'=>((isset($_POST['ekt_tungkai'])) ? $_POST['ekt_tungkai'] : ''),
						'ekt_odema'=>((isset($_POST['ekt_odema'])) ? $_POST['ekt_odema'] : ''),
						'ekt_refleks'=>((isset($_POST['ekt_refleks'])) ? $_POST['ekt_refleks'] : ''),
						'ekt_varises'=>((isset($_POST['ekt_varises'])) ? $_POST['ekt_varises'] : ''),
						'kar_dyspneu'=>((isset($_POST['kar_dyspneu'])) ? $_POST['kar_dyspneu'] : ''),
						'kar_thacypneu'=>((isset($_POST['kar_thacypneu'])) ? $_POST['kar_thacypneu'] : ''),
						'kar_wheezing'=>((isset($_POST['kar_wheezing'])) ? $_POST['kar_wheezing'] : ''),
						'kar_batuk'=>((isset($_POST['kar_batuk'])) ? $_POST['kar_batuk'] : ''),
						'kar_sputum'=>((isset($_POST['kar_sputum'])) ? $_POST['kar_sputum'] : ''),
						'kar_batuk_darah'=>((isset($_POST['kar_batuk_darah'])) ? $_POST['kar_batuk_darah'] : ''),
						'kar_nyeri'=>((isset($_POST['kar_nyeri'])) ? $_POST['kar_nyeri'] : ''),
						'kar_keringat'=>((isset($_POST['kar_keringat'])) ? $_POST['kar_keringat'] : ''),
						'pinggang'=>replace_quote($_POST['pinggang']));
		$pemeriksaan_fisik = json_encode($pemeriksaan_fisik);
		$pemeriksaan_fisik = str_replace('"','|',$pemeriksaan_fisik);
		
		$pemeriksaan_khusus = array('inf_membesar'=>((isset($_POST['inf_membesar'])) ? $_POST['inf_membesar'] : ''),
						'inf_melebar'=>((isset($_POST['inf_melebar'])) ? $_POST['inf_melebar'] : ''),
						'inf_vena'=>((isset($_POST['inf_vena'])) ? $_POST['inf_vena'] : ''),
						'inf_linea'=>((isset($_POST['inf_linea'])) ? $_POST['inf_linea'] : ''),
						'inf_nigra'=>((isset($_POST['inf_nigra'])) ? $_POST['inf_nigra'] : ''),
						'inf_livide'=>((isset($_POST['inf_livide'])) ? $_POST['inf_livide'] : ''),
						'inf_albican'=>((isset($_POST['inf_albican'])) ? $_POST['inf_albican'] : ''),
						'inf_operasi'=>((isset($_POST['inf_operasi'])) ? $_POST['inf_operasi'] : ''),
						'inf_lain'=>((isset($_POST['inf_lain'])) ? $_POST['inf_lain'] : ''),
						'tfu'=>replace_quote($_POST['tfu']),
						'letak_punggung'=>((isset($_POST['letak_punggung'])) ? $_POST['letak_punggung'] : ''),
						'persentasi'=>replace_quote($_POST['persentasi']),
						'tbj'=>replace_quote($_POST['tbj']),
						'djj'=>replace_quote($_POST['djj']),
						'djj_teratur'=>((isset($_POST['djj_teratur'])) ? $_POST['djj_teratur'] : ''),
						'kontraksi'=>replace_quote($_POST['kontraksi']),
						'kontraksi_detik'=>replace_quote($_POST['kontraksi_detik']),
						'kontraksi_teratur'=>((isset($_POST['kontraksi_teratur'])) ? $_POST['kontraksi_teratur'] : ''),
						'vaginam'=>replace_quote($_POST['vaginam']),
						'inspekulo'=>replace_quote($_POST['inspekulo']),
						'toucher'=>replace_quote($_POST['toucher']),
						'kesan_panggul'=>replace_quote($_POST['kesan_panggul']),
						'tfu_nifas'=>replace_quote($_POST['tfu_nifas']),
						'kon_uterus'=>replace_quote($_POST['kon_uterus']),
						'lochea'=>replace_quote($_POST['lochea']),
						'jalan_lahir'=>replace_quote($_POST['jalan_lahir']));
		$pemeriksaan_khusus = json_encode($pemeriksaan_khusus);
		$pemeriksaan_khusus = str_replace('"','|',$pemeriksaan_khusus);
		
		$penapisan_nyeri = array('skor_nyeri'=>((isset($_POST['skor_nyeri'])) ? $_POST['skor_nyeri'] : ''),
						'nyeri_obat'=>((isset($_POST['nyeri_obat'])) ? $_POST['nyeri_obat'] : ''),
						'nyeri_istirahat'=>((isset($_POST['nyeri_istirahat'])) ? $_POST['nyeri_istirahat'] : ''),
						'nyeri_tidur'=>((isset($_POST['nyeri_tidur'])) ? $_POST['nyeri_tidur'] : ''));
		$penapisan_nyeri = json_encode($penapisan_nyeri);
		$penapisan_nyeri = str_replace('"','|',$penapisan_nyeri);
		
		$pemeriksaan_penunjang = array('penunjang_darah'=>replace_quote($_POST['penunjang_darah']),
						'penunjang_hbsag'=>replace_quote($_POST['penunjang_hbsag']),
						'penunjang_protein'=>replace_quote($_POST['penunjang_protein']),
						'penunjang_janin'=>((isset($_POST['penunjang_janin'])) ? $_POST['penunjang_janin'] : ''),
						'penunjang_usg'=>replace_quote($_POST['penunjang_usg']));
		$pemeriksaan_penunjang = json_encode($pemeriksaan_penunjang);
		$pemeriksaan_penunjang = str_replace('"','|',$pemeriksaan_penunjang);
		
		if(empty($_POST['idx'])){				
			mysql_query('INSERT INTO t_irna_pengkajian_awal_kandungan (IRNA_ID,CARA_MASUK,DS_KELUHAN_UTAMA,DS_RIWAYAT_MENSTUASI,
			DS_RIWAYAT_HAMIL_INI,DS_RIWAYAT_KEHAMILAN_TERDAHULU,DS_RIWAYAT_PENYAKIT_DIDERITA,DS_RIWAYAT_PENYAKIT_KELUARGA,
			DS_STATUS_PERKAWINAN,DS_RIWAYAT_SOSIAL_EKONOMI,DS_RIWAYAT_KB,DS_RIWAYAT_GINEKOLOGI,DS_POLA_MAKAN,DO_PEMERIKSAAN_UMUM,
			DO_PEMERIKSAAN_FISIK,DO_PEMERIKSAAN_KHUSUS,DO_PENAPISAN_NYERI,DO_PEMERIKSAAN_PENUNJANG,ANALISA_DATA,
			PENATALAKSANAAN,FINAL,REGISTER,TGL_ASSESMENT,PEGAWAI_ID) VALUES ("' . $_POST['irna_id'] . '","' . $cara_masuk . '","' . $_POST['ds_keluhan_utama'] . '",
			"' . $riwayat_menstruasi . '","' . $riwayat_hamil_ini . '","' . $riwayat_hamil_dhl . '","' . $riwayat_penyakit . '",
			"' . $_POST['ds_riwayat_penyakit_keluarga'] . '","' . $status_kawin . '","' . $riwayat_sosial . '",
			"' . $riwayat_kb . '","' . $riwayat_ginekologi . '","' . $riwayat_pola_makan . '","' . $pemeriksaan_umum . '",
			"' . $pemeriksaan_fisik . '","' . $pemeriksaan_khusus . '","' . $penapisan_nyeri . '","' . $pemeriksaan_penunjang . '",
			"' . $_POST['analisa_data'] . '", "' . $_POST['penatalaksanaan'] . '",' . $st_final . ',
			"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",NOW(),"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_irna_pengkajian_awal_kandungan 
				SET CARA_MASUK = "' . $cara_masuk . '",
				DS_KELUHAN_UTAMA = "' . $_POST['ds_keluhan_utama'] . '",
				DS_RIWAYAT_MENSTUASI = "' . $riwayat_menstruasi . '",
				DS_RIWAYAT_HAMIL_INI = "' . $riwayat_hamil_ini . '",
				DS_RIWAYAT_KEHAMILAN_TERDAHULU = "' . $riwayat_hamil_dhl . '",
				DS_RIWAYAT_PENYAKIT_DIDERITA = "' . $riwayat_penyakit . '",
				DS_RIWAYAT_PENYAKIT_KELUARGA = "' . $_POST['ds_riwayat_penyakit_keluarga'] . '",
				DS_STATUS_PERKAWINAN = "' . $status_kawin . '",
				DS_RIWAYAT_SOSIAL_EKONOMI = "' . $riwayat_sosial . '",
				DS_RIWAYAT_KB = "' . $riwayat_kb . '",
				DS_RIWAYAT_GINEKOLOGI = "' . $riwayat_ginekologi . '",
				DS_POLA_MAKAN = "' . $riwayat_pola_makan . '",
				DO_PEMERIKSAAN_UMUM = "' . $pemeriksaan_umum . '",
				DO_PEMERIKSAAN_FISIK = "' . $pemeriksaan_fisik . '",
				DO_PEMERIKSAAN_KHUSUS = "' . $pemeriksaan_khusus . '",
				DO_PENAPISAN_NYERI = "' . $penapisan_nyeri . '",
				DO_PEMERIKSAAN_PENUNJANG = "' . $pemeriksaan_penunjang . '",
				ANALISA_DATA = "' . $_POST['analisa_data'] . '",
				PENATALAKSANAAN = "' . $_POST['penatalaksanaan'] . '",
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				TGL_ASSESMENT = NOW(),
				PEGAWAI_ID = "' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
		}
	
			
				mysql_query('UPDATE t_irna SET ST_CREATE_ERM_PAM = NULL WHERE IRNA_ID = "' . $_POST['irna_id'] . '"') or die(mysql_error());
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_awal_kebidanan_d_kandungan.php');
		erm_pengkajian_awal_kebidanan_d_kandungan($_POST['irja_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Awal Medis Kebidanan Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

$qry_pasien = 'SELECT IRNA_ID,CARA_MASUK,DS_KELUHAN_UTAMA,DS_RIWAYAT_MENSTUASI,DS_RIWAYAT_HAMIL_INI,DS_RIWAYAT_KEHAMILAN_TERDAHULU,
			DS_RIWAYAT_PENYAKIT_DIDERITA,DS_RIWAYAT_PENYAKIT_KELUARGA,DS_STATUS_PERKAWINAN,DS_RIWAYAT_SOSIAL_EKONOMI,
			DS_RIWAYAT_KB,DS_RIWAYAT_GINEKOLOGI,DS_POLA_MAKAN,DO_PEMERIKSAAN_UMUM,DO_PEMERIKSAAN_FISIK,DO_PEMERIKSAAN_KHUSUS,
			DO_PENAPISAN_NYERI,DO_PEMERIKSAAN_PENUNJANG,ANALISA_DATA,PENATALAKSANAAN,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,
			REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS REGISTER_DT
			FROM t_irna_pengkajian_awal_kandungan
			WHERE IRNA_ID = "' . $idx . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
//$idx = $dat_pasien['IRNA_ID'];
$idx_pam = $dat_pasien['IRNA_ID'];
$cara_masuk = $dat_pasien['CARA_MASUK'];
$ds_keluhan_utama = $dat_pasien['DS_KELUHAN_UTAMA'];
$ds_riwayat_menstruasi = str_replace('|','"',$dat_pasien['DS_RIWAYAT_MENSTUASI']);
$ds_riwayat_menstruasi = preg_replace('/\r|\n/','\n',trim($ds_riwayat_menstruasi));
$ds_riwayat_menstruasi = json_decode($ds_riwayat_menstruasi,true);

$ds_hamil_ini = str_replace('|','"',$dat_pasien['DS_RIWAYAT_HAMIL_INI']);
$ds_hamil_ini = preg_replace('/\r|\n/','\n',trim($ds_hamil_ini));
$ds_hamil_ini = json_decode($ds_hamil_ini,true);

$ds_riwayat_hamil_dhl = str_replace('|','"',$dat_pasien['DS_RIWAYAT_KEHAMILAN_TERDAHULU']);
$ds_riwayat_hamil_dhl = preg_replace('/\r|\n/','\n',trim($ds_riwayat_hamil_dhl));
$ds_riwayat_hamil_dhl = json_decode($ds_riwayat_hamil_dhl,true);

$ds_penyakit = str_replace('|','"',$dat_pasien['DS_RIWAYAT_PENYAKIT_DIDERITA']);
$ds_penyakit = preg_replace('/\r|\n/','\n',trim($ds_penyakit));
$ds_penyakit = json_decode($ds_penyakit,true);

$ds_penyakit_keluarga = $dat_pasien['DS_RIWAYAT_PENYAKIT_KELUARGA'];
$ds_perkawinan = str_replace('|','"',$dat_pasien['DS_STATUS_PERKAWINAN']);
$ds_perkawinan = preg_replace('/\r|\n/','\n',trim($ds_perkawinan));
$ds_perkawinan = json_decode($ds_perkawinan,true);

$ds_sosial = str_replace('|','"',$dat_pasien['DS_RIWAYAT_SOSIAL_EKONOMI']);
$ds_sosial = preg_replace('/\r|\n/','\n',trim($ds_sosial));
$ds_sosial = json_decode($ds_sosial,true);

$ds_kb = str_replace('|','"',$dat_pasien['DS_RIWAYAT_KB']);
$ds_kb = preg_replace('/\r|\n/','\n',trim($ds_kb));
$ds_kb = json_decode($ds_kb,true);

$ds_ginekologi = str_replace('|','"',$dat_pasien['DS_RIWAYAT_GINEKOLOGI']);
$ds_ginekologi = preg_replace('/\r|\n/','\n',trim($ds_ginekologi));
$ds_ginekologi = json_decode($ds_ginekologi,true);

$ds_pola_makan = str_replace('|','"',$dat_pasien['DS_POLA_MAKAN']);
$ds_pola_makan = preg_replace('/\r|\n/','\n',trim($ds_pola_makan));
$ds_pola_makan = json_decode($ds_pola_makan,true);

$do_pemeriksaan_umum = str_replace('|','"',$dat_pasien['DO_PEMERIKSAAN_UMUM']);
$do_pemeriksaan_umum = preg_replace('/\r|\n/','\n',trim($do_pemeriksaan_umum));
$do_pemeriksaan_umum = json_decode($do_pemeriksaan_umum,true);

$do_pemeriksaan_fisik = str_replace('|','"',$dat_pasien['DO_PEMERIKSAAN_FISIK']);
$do_pemeriksaan_fisik = preg_replace('/\r|\n/','\n',trim($do_pemeriksaan_fisik));
$do_pemeriksaan_fisik = json_decode($do_pemeriksaan_fisik,true);

$do_pemeriksaan_khusus = str_replace('|','"',$dat_pasien['DO_PEMERIKSAAN_KHUSUS']);
$do_pemeriksaan_khusus = preg_replace('/\r|\n/','\n',trim($do_pemeriksaan_khusus));
$do_pemeriksaan_khusus = json_decode($do_pemeriksaan_khusus,true);

$do_penapisan_nyeri = str_replace('|','"',$dat_pasien['DO_PENAPISAN_NYERI']);
$do_penapisan_nyeri = preg_replace('/\r|\n/','\n',trim($do_penapisan_nyeri));
$do_penapisan_nyeri = json_decode($do_penapisan_nyeri,true);

$do_penunjang = str_replace('|','"',$dat_pasien['DO_PEMERIKSAAN_PENUNJANG']);
$do_penunjang = preg_replace('/\r|\n/','\n',trim($do_penunjang));
$do_penunjang = json_decode($do_penunjang,true);
$analisa_data = $dat_pasien['ANALISA_DATA'];
$penatalaksanaan = $dat_pasien['PENATALAKSANAAN'];
$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
$register_kandungan = $dat_pasien['REGISTER'] . ' ' . $dat_pasien['REGISTER_DT'];
?>
<form name="formperiksa_2" id="formperiksa_2" method="post" action="http://<?php echo $_SERVER['SERVER_NAME']; ?>/nsimrs/index.php?link=74ac04efa30ba0f5fb861758cbad5b3a&smn=kjam&idx=<?php echo $idx; ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx_pam; ?>" />	
	<input type="hidden" name="irna_id" id="irna_id" value="<?php echo $irna_id; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />	
	<input type="hidden" name="pam" id="pam" value="2" />
	<table border="0" align="center" style="position:static; " width="90%">
       <tr>
			<td colspan="2">Cara Masuk</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="radio" name="cara_masuk" value="1" <?php if($cara_masuk == '1') echo 'checked'; ?> />&nbsp;IRJ&nbsp;&nbsp;
			<input type="radio" name="cara_masuk" value="2" <?php if($cara_masuk == '2') echo 'checked'; ?> />&nbsp;IGD&nbsp;&nbsp;
			<input type="radio" name="cara_masuk" value="3" <?php if($cara_masuk == '3') echo 'checked'; ?> />&nbsp;Klinik/ RB/ PKM&nbsp;&nbsp;
			<input type="radio" name="cara_masuk" value="4" <?php if($cara_masuk == '4') echo 'checked'; ?> />&nbsp;Kamar Bersalin&nbsp;&nbsp;
			<input type="radio" name="cara_masuk" value="5" <?php if($cara_masuk == '5') echo 'checked'; ?> />&nbsp;Bidan</td>
		</tr>
	   <tr>
			<td colspan="8">DATA SUBJEKTIF</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Keluhan Utama</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="ds_keluhan_utama" class="text_dt10" ><?php echo $ds_keluhan_utama; ?></textarea></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Menstruasi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="ds_riwayat_menstruasi" class="text_dt10" ><?php echo ((isset($ds_riwayat_menstruasi['riwayat'])) ? $ds_riwayat_menstruasi['riwayat'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">
				<table border="0" style="width:850px;">
					<tr>
						<td>Usia menarche</td>
						<td>:</td>
						<td><input type="text" name="ds_usia_menarche" value="<?php echo ((isset($ds_riwayat_menstruasi['usia_menarche'])) ? $ds_riwayat_menstruasi['usia_menarche'] : ''); ?>" class="text_dt" >&nbsp;tahun</td>
						<td>&nbsp;</td>
						<td>Lamanya haid</td>
						<td>:</td>
						<td><input type="text" name="ds_lama_haid" value="<?php echo ((isset($ds_riwayat_menstruasi['lama_haid'])) ? $ds_riwayat_menstruasi['lama_haid'] : ''); ?>" class="text_dt" >&nbsp;hari</td>
					</tr>
					<tr>
						<td>Jumlah darah haid</td>
						<td>:</td>
						<td><input type="text" name="ds_darah_haid" value="<?php echo ((isset($ds_riwayat_menstruasi['darah_haid'])) ? $ds_riwayat_menstruasi['darah_haid'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>HPHT</td>
						<td>:</td>
						<td><input type="text" name="ds_hpht" value="<?php echo ((isset($ds_riwayat_menstruasi['hpht'])) ? $ds_riwayat_menstruasi['hpht'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>TP</td>
						<td>:</td>
						<td><input type="text" name="ds_tp" value="<?php echo ((isset($ds_riwayat_menstruasi['tp'])) ? $ds_riwayat_menstruasi['tp'] : ''); ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td colspan="7">
							<input type="checkbox" name="dismenorhoe" value="1" <?php echo ((isset($ds_riwayat_menstruasi['dismenorhoe']) and $ds_riwayat_menstruasi['dismenorhoe'] == '1') ? 'checked' : ''); ?> />&nbsp;Dismenorhoe&nbsp;&nbsp;
							<input type="checkbox" name="spoting" value="1" <?php echo ((isset($ds_riwayat_menstruasi['spoting']) and $ds_riwayat_menstruasi['spoting'] == '1') ? 'checked' : ''); ?> />&nbsp;Spoting&nbsp;&nbsp;
							<input type="checkbox" name="menorraghia" value="1" <?php echo ((isset($ds_riwayat_menstruasi['menorraghia']) and $ds_riwayat_menstruasi['menorraghia'] == '1') ? 'checked' : ''); ?> />&nbsp;Menorraghia&nbsp;&nbsp;
							<input type="checkbox" name="metrorhagia" value="1" <?php echo ((isset($ds_riwayat_menstruasi['metrorhagia']) and $ds_riwayat_menstruasi['metrorhagia'] == '1') ? 'checked' : ''); ?> />&nbsp;Metrorhagia&nbsp;&nbsp;
							<input type="checkbox" name="syndrome" value="1" <?php echo ((isset($ds_riwayat_menstruasi['syndrome']) and $ds_riwayat_menstruasi['syndrome'] == '1') ? 'checked' : ''); ?> />&nbsp;Pre menstruasi syndrome
						</td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Hamil Ini</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="ds_riwayat_hamil_ini" class="text_dt10" ><?php echo ((isset($ds_hamil_ini['riwayat'])) ? $ds_hamil_ini['riwayat'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">
				<table border="0" style="width:850px;">
					<tr>
						<td>Hamil muda</td>
						<td>:</td>
						<td colspan="5">
							<input type="checkbox" name="hm_mual" value="1" <?php echo ((isset($ds_hamil_ini['hm_mual']) and $ds_hamil_ini['hm_mual'] == '1') ? 'checked' : ''); ?> />&nbsp;Mual&nbsp;&nbsp;
							<input type="checkbox" name="hm_muntah" value="1" <?php echo ((isset($ds_hamil_ini['hm_muntah']) and $ds_hamil_ini['hm_muntah'] == '1') ? 'checked' : ''); ?> />&nbsp;Muntah&nbsp;&nbsp;
							<input type="checkbox" name="hm_pendarahan" value="1" <?php echo ((isset($ds_hamil_ini['hm_pendarahan']) and $ds_hamil_ini['hm_pendarahan'] == '1') ? 'checked' : ''); ?> />&nbsp;Pendarahan&nbsp;&nbsp;
							<input type="checkbox" name="hm_lainlain" value="1" <?php echo ((isset($ds_hamil_ini['hm_lainlain']) and $ds_hamil_ini['hm_lainlain'] == '1') ? 'checked' : ''); ?> />&nbsp;Lain-lain&nbsp;: TT I&nbsp;
							<input type="text" name="hm_ket_lainlain" class="text_dt" value="<?php echo ((isset($ds_hamil_ini['hm_ket_lainlain'])) ? $ds_hamil_ini['hm_ket_lainlain'] : ''); ?>"  />
						</td>
					</tr>
					<tr>
						<td>Hamil tua</td>
						<td>:</td>
						<td colspan="5">
							<input type="checkbox" name="ht_pusing" value="1" <?php echo ((isset($ds_hamil_ini['ht_pusing']) and $ds_hamil_ini['ht_pusing'] == '1') ? 'checked' : ''); ?> />&nbsp;Pusing&nbsp;&nbsp;
							<input type="checkbox" name="ht_sakit_kepala" value="1" <?php echo ((isset($ds_hamil_ini['ht_sakit_kepala']) and $ds_hamil_ini['ht_sakit_kepala'] == '1') ? 'checked' : ''); ?> />&nbsp;Sakit Kepala&nbsp;&nbsp;
							<input type="checkbox" name="ht_pendarahan" value="1" <?php echo ((isset($ds_hamil_ini['ht_pendarahan']) and $ds_hamil_ini['ht_pendarahan'] == '1') ? 'checked' : ''); ?> />&nbsp;Pendarahan&nbsp;&nbsp;
							<input type="checkbox" name="ht_lainlain" value="1" <?php echo ((isset($ds_hamil_ini['ht_lainlain']) and $ds_hamil_ini['ht_lainlain'] == '1') ? 'checked' : ''); ?> />&nbsp;Lain-lain&nbsp;: TT II&nbsp;
							<input type="text" name="ht_ket_lainlain" class="text_dt" value="<?php echo ((isset($ds_hamil_ini['ht_ket_lainlain'])) ? $ds_hamil_ini['ht_ket_lainlain'] : ''); ?>"  />
						</td>
					</tr>
					<tr>
						<td>Gerakan janin pertama</td>
						<td>:</td>
						<td colspan="5">
							<input type="text" name="gj_pertama" value="<?php echo ((isset($ds_hamil_ini['gj_pertama'])) ? $ds_hamil_ini['gj_pertama'] : ''); ?>" class="text_dt" style="width:550px;">
						</td>
					</tr>
					<tr>
						<td>Gerakan janin terakhir</td>
						<td>:</td>
						<td colspan="5">
							<input type="text" name="gj_terakhir" value="<?php echo ((isset($ds_hamil_ini['gj_terakhir'])) ? $ds_hamil_ini['gj_terakhir'] : ''); ?>" class="text_dt" style="width:550px;">
						</td>
					</tr>
					<tr>
						<td>Tanda bahaya dan penyulit kehamilan</td>
						<td>:</td>
						<td colspan="5">
							<input type="text" name="tanda_penyulit" value="<?php echo ((isset($ds_hamil_ini['tanda_penyulit'])) ? $ds_hamil_ini['tanda_penyulit'] : ''); ?>" class="text_dt" style="width:550px;">
						</td>
					</tr>
					<tr>
						<td>Obat/ jamu yang pernah dan sedang dikonsumsi</td>
						<td>:</td>
						<td colspan="5">
							<input type="text" name="obat_jamu" value="<?php echo ((isset($ds_hamil_ini['obat_jamu'])) ? $ds_hamil_ini['obat_jamu'] : ''); ?>" class="text_dt" style="width:550px;">
						</td>
					</tr>
					<tr>
						<td>Keluhan BAK</td>
						<td>:</td>
						<td colspan="5">
							<input type="text" name="keluhan_bak" value="<?php echo ((isset($ds_hamil_ini['keluhan_bak'])) ? $ds_hamil_ini['keluhan_bak'] : ''); ?>" class="text_dt" style="width:550px;">
						</td>
					</tr>
					<tr>
						<td>Keluhan BAB</td>
						<td>:</td>
						<td colspan="5">
							<input type="text" name="keluhan_bab" value="<?php echo ((isset($ds_hamil_ini['keluhan_bab'])) ? $ds_hamil_ini['keluhan_bab'] : ''); ?>" class="text_dt" style="width:550px;">
						</td>
					</tr>
					<tr>
						<td>Kehawatiran khusus</td>
						<td>:</td>
						<td colspan="5">
							<input type="text" name="kehawatiran" value="<?php echo ((isset($ds_hamil_ini['kehawatiran'])) ? $ds_hamil_ini['kehawatiran'] : ''); ?>" class="text_dt" style="width:550px;">
						</td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat kehamilan, persalinan, dan nifas terdahulu</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="ds_riwayat_hamil_dhl" class="text_dt10" ><?php echo ((isset($ds_riwayat_hamil_dhl['riwayat'])) ? $ds_riwayat_hamil_dhl['riwayat'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">
				<table border="0" style="width:850px;">
					<tr>
						<td>G</td>
						<td>:</td>
						<td><input type="text" name="ds_rh_g" value="<?php echo ((isset($ds_riwayat_hamil_dhl['ds_rh_g'])) ? $ds_riwayat_hamil_dhl['ds_rh_g'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>P</td>
						<td>:</td>
						<td><input type="text" name="ds_rh_p" value="<?php echo ((isset($ds_riwayat_hamil_dhl['ds_rh_p'])) ? $ds_riwayat_hamil_dhl['ds_rh_p'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>A</td>
						<td>:</td>
						<td><input type="text" name="ds_rh_a" value="<?php echo ((isset($ds_riwayat_hamil_dhl['ds_rh_a'])) ? $ds_riwayat_hamil_dhl['ds_rh_a'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Hidup</td>
						<td>:</td>
						<td><input type="text" name="ds_rh_hidup" value="<?php echo ((isset($ds_riwayat_hamil_dhl['ds_rh_hidup'])) ? $ds_riwayat_hamil_dhl['ds_rh_hidup'] : ''); ?>" class="text_dt" ></td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">
				<table border="1" style="width:800px;" class="tableData">
					<tr>
						<th rowspan="2">Waktu<br/>Partus</th>
						<th rowspan="2">Tempat<br/>Partus</th>
						<th rowspan="2">Umur<br/>Hamil</th>
						<th rowspan="2">Jenis<br/>Persalinan</th>
						<th rowspan="2">Penolong<br/>Persalinan</th>
						<th rowspan="2">Penyulit</th>
						<th colspan="3">Anak</th>
					</tr>
					<tr>	
						<th>Sex</th>
						<th>BB</th>
						<th>Keadaan</th>
					</tr>
					<tr>
						<td><input type="text" name="ds_waktu_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_waktu_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_waktu_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_tempat_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_tempat_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_tempat_partus'] : ''); ?>" class="text_dt" style="width:50px;"></td>
						<td><input type="text" name="ds_umur_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_umur_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_umur_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_jenis_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_jenis_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_jenis_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penolong_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_penolong_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_penolong_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penyulit_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_penyulit_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_penyulit_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_sex_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_sex_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_sex_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_bb_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_bb_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_bb_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_keadaan_partus_1" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][1]['ds_keadaan_partus'])) ? $ds_riwayat_hamil_dhl['partus'][1]['ds_keadaan_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
					</tr>
					<tr>
						<td><input type="text" name="ds_waktu_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_waktu_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_waktu_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_tempat_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_tempat_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_tempat_partus'] : ''); ?>" class="text_dt" style="width:50px;"></td>
						<td><input type="text" name="ds_umur_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_umur_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_umur_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_jenis_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_jenis_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_jenis_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penolong_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_penolong_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_penolong_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penyulit_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_penyulit_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_penyulit_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_sex_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_sex_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_sex_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_bb_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_bb_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_bb_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_keadaan_partus_2" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][2]['ds_keadaan_partus'])) ? $ds_riwayat_hamil_dhl['partus'][2]['ds_keadaan_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
					</tr>
					<tr>
						<td><input type="text" name="ds_waktu_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_waktu_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_waktu_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_tempat_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_tempat_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_tempat_partus'] : ''); ?>" class="text_dt" style="width:50px;"></td>
						<td><input type="text" name="ds_umur_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_umur_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_umur_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_jenis_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_jenis_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_jenis_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penolong_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_penolong_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_penolong_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penyulit_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_penyulit_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_penyulit_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_sex_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_sex_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_sex_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_bb_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_bb_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_bb_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_keadaan_partus_3" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][3]['ds_keadaan_partus'])) ? $ds_riwayat_hamil_dhl['partus'][3]['ds_keadaan_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
					</tr>
					<tr>
						<td><input type="text" name="ds_waktu_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_waktu_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_waktu_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_tempat_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_tempat_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_tempat_partus'] : ''); ?>" class="text_dt" style="width:50px;"></td>
						<td><input type="text" name="ds_umur_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_umur_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_umur_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_jenis_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_jenis_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_jenis_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penolong_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_penolong_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_penolong_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penyulit_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_penyulit_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_penyulit_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_sex_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_sex_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_sex_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_bb_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_bb_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_bb_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_keadaan_partus_4" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][4]['ds_keadaan_partus'])) ? $ds_riwayat_hamil_dhl['partus'][4]['ds_keadaan_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
					</tr>
						<td><input type="text" name="ds_waktu_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_waktu_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_waktu_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_tempat_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_tempat_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_tempat_partus'] : ''); ?>" class="text_dt" style="width:50px;"></td>
						<td><input type="text" name="ds_umur_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_umur_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_umur_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_jenis_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_jenis_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_jenis_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penolong_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_penolong_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_penolong_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penyulit_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_penyulit_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_penyulit_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_sex_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_sex_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_sex_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_bb_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_bb_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_bb_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_keadaan_partus_5" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][5]['ds_keadaan_partus'])) ? $ds_riwayat_hamil_dhl['partus'][5]['ds_keadaan_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
					</tr>
						<td><input type="text" name="ds_waktu_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_waktu_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_waktu_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_tempat_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_tempat_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_tempat_partus'] : ''); ?>" class="text_dt" style="width:50px;"></td>
						<td><input type="text" name="ds_umur_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_umur_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_umur_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_jenis_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_jenis_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_jenis_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penolong_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_penolong_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_penolong_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penyulit_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_penyulit_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_penyulit_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_sex_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_sex_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_sex_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_bb_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_bb_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_bb_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_keadaan_partus_6" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][6]['ds_keadaan_partus'])) ? $ds_riwayat_hamil_dhl['partus'][6]['ds_keadaan_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
					</tr>
						<td><input type="text" name="ds_waktu_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_waktu_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_waktu_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_tempat_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_tempat_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_tempat_partus'] : ''); ?>" class="text_dt" style="width:50px;"></td>
						<td><input type="text" name="ds_umur_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_umur_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_umur_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_jenis_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_jenis_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_jenis_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penolong_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_penolong_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_penolong_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_penyulit_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_penyulit_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_penyulit_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
						<td><input type="text" name="ds_sex_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_sex_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_sex_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_bb_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_bb_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_bb_partus'] : ''); ?>" class="text_dt" style="width:30px;"></td>
						<td><input type="text" name="ds_keadaan_partus_7" value="<?php echo ((isset($ds_riwayat_hamil_dhl['partus'][7]['ds_keadaan_partus'])) ? $ds_riwayat_hamil_dhl['partus'][7]['ds_keadaan_partus'] : ''); ?>" class="text_dt" style="width:120px;"></td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat penyakit yang pernah diderita/ operasi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="ds_riwayat_penyakit" class="text_dt10" ><?php echo ((isset($ds_penyakit['riwayat'])) ? $ds_penyakit['riwayat'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">
				<table border="0" style="width:850px;">
					<tr>
						<td>Pernah dirawat</td>
						<td>:</td>
						<td><input type="text" name="ds_pernah_dirawat" value="<?php echo ((isset($ds_penyakit['pernah_dirawat'])) ? $ds_penyakit['pernah_dirawat'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Kapan</td>
						<td>:</td>
						<td><input type="text" name="ds_kapan_dirawat" value="<?php echo ((isset($ds_penyakit['kapan_dirawat'])) ? $ds_penyakit['kapan_dirawat'] : ''); ?>" class="text_dt" ></td>
						<td>Dimana</td>
						<td>:</td>
						<td><input type="text" name="ds_dimana_dirawat" value="<?php echo ((isset($ds_penyakit['dimana_dirawat'])) ? $ds_penyakit['dimana_dirawat'] : ''); ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td>Pernah operasi</td>
						<td>:</td>
						<td><input type="text" name="ds_pernah_operasi" value="<?php echo ((isset($ds_penyakit['pernah_operasi'])) ? $ds_penyakit['pernah_operasi'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Kapan</td>
						<td>:</td>
						<td><input type="text" name="ds_kapan_operasi" value="<?php echo ((isset($ds_penyakit['kapan_operasi'])) ? $ds_penyakit['kapan_operasi'] : ''); ?>" class="text_dt" ></td>
						<td>Dimana</td>
						<td>:</td>
						<td><input type="text" name="ds_dimana_operasi" value="<?php echo ((isset($ds_penyakit['dimana_operasi'])) ? $ds_penyakit['dimana_operasi'] : ''); ?>" class="text_dt" ></td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat penyakit keluarga (ayah,ibu,adik,paman,bibi) yang pernah menderita penyakit</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="ds_riwayat_penyakit_keluarga" class="text_dt10" ><?php echo $ds_penyakit_keluarga; ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Status Perkawinan</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="ds_status_kawin" value="1" <?php echo ((isset($ds_perkawinan['status_kawin']) and $ds_perkawinan['status_kawin'] == '1') ? 'checked' : ''); ?>/>&nbsp;Ya
			<input type="radio" name="ds_status_kawin" value="2" <?php echo ((isset($ds_perkawinan['status_kawin']) and $ds_perkawinan['status_kawin'] == '2') ? 'checked' : ''); ?> />&nbsp;Tidak,&nbsp;&nbsp;
			kawin <input type="text" name="ds_kali_kawin" value="<?php echo ((isset($ds_perkawinan['kali_kawin'])) ? $ds_perkawinan['kali_kawin'] : ''); ?>" class="text_dt" >&nbsp;kali</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">Kawin 1 usia <input type="text" name="ds_usia_kawin" value="<?php echo ((isset($ds_perkawinan['usia_kawin'])) ? $ds_perkawinan['usia_kawin'] : ''); ?>" class="text_dt" >&nbsp;tahun</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Sosial Ekonomi</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">Respon ibu dan keluarga terhadap kehamilan</td>
			<td valign="top">:</td>
			<td colspan="3"><input type="text" name="respon_ibu" value="<?php echo ((isset($ds_sosial['respon_ibu'])) ? $ds_sosial['respon_ibu'] : ''); ?>" class="text_dt" style="width:550px;"></td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">Pengambilan keputusan dalam keluarga</td>
			<td valign="top">:</td>
			<td colspan="3"><input type="text" name="keputusan" value="<?php echo ((isset($ds_sosial['keputusan'])) ? $ds_sosial['keputusan'] : ''); ?>" class="text_dt" style="width:550px;"></td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">Beban kerja sehari</td>
			<td valign="top">:</td>
			<td colspan="3"><input type="text" name="beban_kerja" value="<?php echo ((isset($ds_sosial['beban_kerja'])) ? $ds_sosial['beban_kerja'] : ''); ?>" class="text_dt" style="width:550px;"></td>
       </tr> 
	   <tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">Tempat dan penolong persalinan yang diinginkan</td>
			<td valign="top">:</td>
			<td colspan="3"><input type="text" name="tempat_persalinan" value="<?php echo ((isset($ds_sosial['tempat_persalinan'])) ? $ds_sosial['tempat_persalinan'] : ''); ?>" class="text_dt" style="width:550px;"></td>
       </tr> 
	   <tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td valign="top">Penghasilan keluarga</td>
			<td valign="top">:</td>
			<td colspan="3"><input type="text" name="penghasilan" value="<?php echo ((isset($ds_sosial['penghasilan'])) ? $ds_sosial['penghasilan'] : ''); ?>" class="text_dt" style="width:550px;"></td>
       </tr> 
	   <tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Keluarga Berencana</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td colspan="6">			
				<table border="0" style="width:850px;">
					<tr>
						<td>Metode KB yang pernah dipakai</td>
						<td>:</td>
						<td><input type="text" name="metode_kb" value="<?php echo ((isset($ds_kb['metode_kb'])) ? $ds_kb['metode_kb'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>Lamanya</td>
						<td>:</td>
						<td><input type="text" name="lama_kb" value="<?php echo ((isset($ds_kb['lama_kb'])) ? $ds_kb['lama_kb'] : ''); ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td>Komplikasi KB</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="komplikasi_kb" value="<?php echo ((isset($ds_kb['komplikasi_kb'])) ? $ds_kb['komplikasi_kb'] : ''); ?>" class="text_dt" style="width:550px;"></td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Riwayat Ginekologi</td>
			<td valign="top">:</td>
			<td colspan="5">
					<input type="checkbox" name="infertilitas" value="1" <?php echo ((isset($ds_ginekologi['infertilitas']) and $ds_ginekologi['infertilitas'] == '1') ? 'checked' : ''); ?> />&nbsp;Infertilitas&nbsp;&nbsp;
					<input type="checkbox" name="infeksi_virus" value="1" <?php echo ((isset($ds_ginekologi['infeksi_virus']) and $ds_ginekologi['infeksi_virus'] == '1') ? 'checked' : ''); ?> />&nbsp;Infeksi Virus&nbsp;&nbsp;
					<input type="checkbox" name="pms" value="1" <?php echo ((isset($ds_ginekologi['pms']) and $ds_ginekologi['pms'] == '1') ? 'checked' : ''); ?> />&nbsp;PMS&nbsp;&nbsp;
					<input type="checkbox" name="endometriosis" value="1" <?php echo ((isset($ds_ginekologi['endometriosis']) and $ds_ginekologi['endometriosis'] == '1') ? 'checked' : ''); ?> />&nbsp;Endometriosis&nbsp;&nbsp;
					<input type="checkbox" name="polip" value="1" <?php echo ((isset($ds_ginekologi['polip']) and $ds_ginekologi['polip'] == '1') ? 'checked' : ''); ?> />&nbsp;Polip serviks&nbsp;&nbsp;
					<input type="checkbox" name="kanker" value="1" <?php echo ((isset($ds_ginekologi['kanker']) and $ds_ginekologi['kanker'] == '1') ? 'checked' : ''); ?> />&nbsp;Kanker kandungan&nbsp;&nbsp;
					<input type="checkbox" name="operasi_kandungan" value="1" <?php echo ((isset($ds_ginekologi['operasi_kandungan']) and $ds_ginekologi['operasi_kandungan'] == '1') ? 'checked' : ''); ?> />&nbsp;Operasi kandungan&nbsp;&nbsp;
					<input type="checkbox" name="perkosaan" value="1" <?php echo ((isset($ds_ginekologi['perkosaan']) and $ds_ginekologi['perkosaan'] == '1') ? 'checked' : ''); ?> />&nbsp;Perkosaan
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pola makan/ minum/ eliminasi/ istirahat/ psikososial</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td colspan="6">			
				<table border="0" style="width:850px;">
					<tr>
						<td>Pola makan</td>
						<td>:</td>
						<td><input type="text" name="pola_makan" value="<?php echo ((isset($ds_pola_makan['pola_makan'])) ? $ds_pola_makan['pola_makan'] : ''); ?>" class="text_dt" >&nbsp;kali/hari</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Pola minum</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="pola_minum" value="<?php echo ((isset($ds_pola_makan['pola_minum'])) ? $ds_pola_makan['pola_minum'] : ''); ?>" class="text_dt" >&nbsp;cc/hari&nbsp;&nbsp;
								<input type="checkbox" name="alkohol" value="1" <?php echo ((isset($ds_pola_makan['alkohol']) and $ds_pola_makan['alkohol'] == '1') ? 'checked' : ''); ?> />&nbsp;Alkohol&nbsp;&nbsp;
								<input type="checkbox" name="jamu" value="1" <?php echo ((isset($ds_pola_makan['jamu']) and $ds_pola_makan['jamu'] == '1') ? 'checked' : ''); ?> />&nbsp;Jamu&nbsp;&nbsp;
								<input type="checkbox" name="kopi" value="1" <?php echo ((isset($ds_pola_makan['kopi']) and $ds_pola_makan['kopi'] == '1') ? 'checked' : ''); ?> />&nbsp;Kopi</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Pola eliminasi</td>
						<td>:</td>
						<td>BAK&nbsp;<input type="text" name="pola_bak" value="<?php echo ((isset($ds_pola_makan['pola_bak'])) ? $ds_pola_makan['pola_bak'] : ''); ?>" class="text_dt" style="width:80px;" >&nbsp;cc/hari</td>
						<td>&nbsp;</td>
						<td>warna</td>
						<td>:</td>
						<td><input type="text" name="warna_bak" value="<?php echo ((isset($ds_pola_makan['warna_bak'])) ? $ds_pola_makan['warna_bak'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;BAK terakhir jam</td>
						<td>:</td>
						<td><input type="text" name="jam_bak" value="<?php echo ((isset($ds_pola_makan['jam_bak'])) ? $ds_pola_makan['jam_bak'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>:</td>
						<td>BAB&nbsp;<input type="text" name="pola_bab" value="<?php echo ((isset($ds_pola_makan['pola_bab'])) ? $ds_pola_makan['pola_bab'] : ''); ?>" class="text_dt" style="width:80px;" >&nbsp;kali/hari</td>
						<td>&nbsp;</td>
						<td>karakteristik</td>
						<td>:</td>
						<td><input type="text" name="warna_bab" value="<?php echo ((isset($ds_pola_makan['warna_bab'])) ? $ds_pola_makan['warna_bab'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;BAB terakhir jam</td>
						<td>:</td>
						<td><input type="text" name="jam_bab" value="<?php echo ((isset($ds_pola_makan['jam_bab'])) ? $ds_pola_makan['jam_bab'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
					</tr>
					<tr>
						<td>Pola istirahat</td>
						<td>:</td>
						<td><input type="text" name="pola_istirahat" value="<?php echo ((isset($ds_pola_makan['pola_istirahat'])) ? $ds_pola_makan['pola_istirahat'] : ''); ?>" class="text_dt" >&nbsp;jam/hari</td>
						<td>&nbsp;</td>
						<td>Tidur terakhir jam</td>
						<td>:</td>
						<td><input type="text" name="jam_tidur" value="<?php echo ((isset($ds_pola_makan['jam_tidur'])) ? $ds_pola_makan['jam_tidur'] : ''); ?>" class="text_dt" ></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Psikososial</td>
						<td>:</td>
						<td colspan="8">Penerimaan klien terhadap kehamilan ini : <input type="text" name="terima_kehamilan" value="<?php echo ((isset($ds_pola_makan['terima_kehamilan'])) ? $ds_pola_makan['terima_kehamilan'] : ''); ?>" class="text_dt" style="width:470px;" ></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="8">Dukungan keluarga dari : <input type="checkbox" name="dk_suami" value="1" <?php echo ((isset($ds_pola_makan['dk_suami']) and $ds_pola_makan['dk_suami'] == '1') ? 'checked' : ''); ?> />&nbsp;Suami&nbsp;&nbsp;
					<input type="checkbox" name="dk_ortu" value="1" <?php echo ((isset($ds_pola_makan['dk_ortu']) and $ds_pola_makan['dk_ortu'] == '1') ? 'checked' : ''); ?> />&nbsp;Orang Tua&nbsp;&nbsp;
					<input type="checkbox" name="dk_mertua" value="1" <?php echo ((isset($ds_pola_makan['dk_mertua']) and $ds_pola_makan['dk_mertua'] == '1') ? 'checked' : ''); ?> />&nbsp;Mertua&nbsp;&nbsp;
					<input type="checkbox" name="dk_kellain" value="1" <?php echo ((isset($ds_pola_makan['dk_kellain']) and $ds_pola_makan['dk_kellain'] == '1') ? 'checked' : ''); ?> />&nbsp;Keluarga lain</td>
					</tr>
				</table>	
			</td>
		</tr>
			<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="8">DATA OBYEKTIF</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pemeriksaan Umum</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td colspan="6">			
				<table border="0" style="width:850px;">
					<tr>
						<td>Keadaan umum</td>
						<td>:</td>
						<td colspan="8"><input type="text" name="keadaan_umum" value="<?php echo ((isset($do_pemeriksaan_umum['keadaan_umum'])) ? $do_pemeriksaan_umum['keadaan_umum'] : ''); ?>" class="text_dt" style="width:700px;" ></td>
					</tr>
					<tr>
						<td>Kesadaran</td>
						<td>:</td>
						<td colspan="8"><input type="text" name="kesadaran" value="<?php echo ((isset($do_pemeriksaan_umum['kesadaran'])) ? $do_pemeriksaan_umum['kesadaran'] : ''); ?>" class="text_dt" style="width:700px;" ></td>
					</tr>
					<tr>
						<td>TD</td>
						<td>:</td>
						<td><input type="text" name="pem_td" value="<?php echo ((isset($do_pemeriksaan_umum['pem_td'])) ? $do_pemeriksaan_umum['pem_td'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;mmHg</td>
						<td>&nbsp;</td>
						<td>Nadi</td>
						<td>:</td>
						<td><input type="text" name="pem_nadi" value="<?php echo ((isset($do_pemeriksaan_umum['pem_nadi'])) ? $do_pemeriksaan_umum['pem_nadi'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;x/menit</td>
						<td>Suhu</td>
						<td>:</td>
						<td><input type="text" name="pem_suhu" value="<?php echo ((isset($do_pemeriksaan_umum['pem_suhu'])) ? $do_pemeriksaan_umum['pem_suhu'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;<span>&#8451;</span></td>
					</tr>
					<tr>
						<td>Pernapasan</td>
						<td>:</td>
						<td><input type="text" name="pem_napas" value="<?php echo ((isset($do_pemeriksaan_umum['pem_napas'])) ? $do_pemeriksaan_umum['pem_napas'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;x/menit</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>BB sebelum hamil</td>
						<td>:</td>
						<td><input type="text" name="pem_bb_sb" value="<?php echo ((isset($do_pemeriksaan_umum['pem_bb_sb'])) ? $do_pemeriksaan_umum['pem_bb_sb'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;kg</td>
						<td>&nbsp;</td>
						<td>BB saat ini</td>
						<td>:</td>
						<td><input type="text" name="pem_bb_sk" value="<?php echo ((isset($do_pemeriksaan_umum['pem_bb_sk'])) ? $do_pemeriksaan_umum['pem_bb_sk'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;kg</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>TB</td>
						<td>:</td>
						<td><input type="text" name="pem_tb" value="<?php echo ((isset($do_pemeriksaan_umum['pem_tb'])) ? $do_pemeriksaan_umum['pem_tb'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;cm</td>
						<td>&nbsp;</td>
						<td>Lila</td>
						<td>:</td>
						<td><input type="text" name="pem_lila" value="<?php echo ((isset($do_pemeriksaan_umum['pem_lila'])) ? $do_pemeriksaan_umum['pem_lila'] : ''); ?>" class="text_dt" style="width:100px;" >&nbsp;cm</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pemeriksaan Fisik</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td colspan="6">			
				<table border="0" style="width:850px;">
					<tr>
						<td>Mata</td>
						<td>:</td>
						<td>Konjungtiva</td>
						<td>:</td>
						<td><input type="text" name="mata_konjuntiva" value="<?php echo ((isset($do_pemeriksaan_fisik['mata_konjuntiva'])) ? $do_pemeriksaan_fisik['mata_konjuntiva'] : ''); ?>" class="text_dt" ></td>
						<td>Sklera</td>
						<td>:</td>
						<td><input type="text" name="mata_sklera" value="<?php echo ((isset($do_pemeriksaan_fisik['mata_sklera'])) ? $do_pemeriksaan_fisik['mata_sklera'] : ''); ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td colspan="3"><input type="checkbox" name="mata_kabur" value="1" <?php echo ((isset($do_pemeriksaan_fisik['mata_kabur']) and $do_pemeriksaan_fisik['mata_kabur'] == '1') ? 'checked' : ''); ?> />&nbsp;Pandangan kabur</td>
						<td colspan="3"><input type="checkbox" name="mata_dua" value="1" <?php echo ((isset($do_pemeriksaan_fisik['mata_dua']) and $do_pemeriksaan_fisik['mata_dua'] == '1') ? 'checked' : ''); ?> />&nbsp;Adanya pemandangan dua</td>
					</tr>
					<tr>
						<td Colspan="3">Rahang, gigi dan gusi</td>
						<td>:</td>
						<td colspan="4"><input type="text" name="rahang" value="<?php echo ((isset($do_pemeriksaan_fisik['rahang'])) ? $do_pemeriksaan_fisik['rahang'] : ''); ?>" class="text_dt" style="width:570px;"></td>
					</tr>
					<tr>
						<td Colspan="3">Leher</td>
						<td>:</td>
						<td colspan="4"><input type="text" name="leher" value="<?php echo ((isset($do_pemeriksaan_fisik['leher'])) ? $do_pemeriksaan_fisik['leher'] : ''); ?>" class="text_dt" style="width:570px;"></td>
					</tr>
					<tr>
						<td Colspan="3">Dada dan Axyla</td>
						<td>:</td>
						<td colspan="4"><input type="checkbox" name="dada_mamae" value="1" <?php echo ((isset($do_pemeriksaan_fisik['dada_mamae']) and $do_pemeriksaan_fisik['dada_mamae'] == '1') ? 'checked' : ''); ?> />&nbsp;Mammae simetris&nbsp;&nbsp;
						<input type="checkbox" name="dada_serola" value="1" <?php echo ((isset($do_pemeriksaan_fisik['dada_serola']) and $do_pemeriksaan_fisik['dada_serola'] == '1') ? 'checked' : ''); ?> />&nbsp;Serola hiperpigmentasi&nbsp;&nbsp;
						<input type="checkbox" name="dada_tumor" value="1" <?php echo ((isset($do_pemeriksaan_fisik['dada_tumor']) and $do_pemeriksaan_fisik['dada_tumor'] == '1') ? 'checked' : ''); ?> />&nbsp;Tumor&nbsp;&nbsp;
						<input type="checkbox" name="dada_kolostrum" value="1" <?php echo ((isset($do_pemeriksaan_fisik['dada_kolostrum']) and $do_pemeriksaan_fisik['dada_kolostrum'] == '1') ? 'checked' : ''); ?> />&nbsp;Kolostrum&nbsp;&nbsp;
						<input type="checkbox" name="dada_puting" value="1" <?php echo ((isset($do_pemeriksaan_fisik['dada_puting']) and $do_pemeriksaan_fisik['dada_puting'] == '1') ? 'checked' : ''); ?> />&nbsp;Puting susu menonjol&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td Colspan="3">Ekstremitas atas dan bawah</td>
						<td>:</td>
						<td colspan="4"><input type="checkbox" name="ekt_tungkai" value="1" <?php echo ((isset($do_pemeriksaan_fisik['ekt_tungkai']) and $do_pemeriksaan_fisik['ekt_tungkai'] == '1') ? 'checked' : ''); ?> />&nbsp;Tungkai simetris/asimetris&nbsp;&nbsp;
						<input type="checkbox" name="ekt_odema" value="1" <?php echo ((isset($do_pemeriksaan_fisik['ekt_odema']) and $do_pemeriksaan_fisik['ekt_odema'] == '1') ? 'checked' : ''); ?> />&nbsp;Odema&nbsp;&nbsp;
						<input type="checkbox" name="ekt_refleks" value="1" <?php echo ((isset($do_pemeriksaan_fisik['ekt_refleks']) and $do_pemeriksaan_fisik['ekt_refleks'] == '1') ? 'checked' : ''); ?> />&nbsp;Refleks&nbsp;&nbsp;
						<input type="checkbox" name="ekt_varises" value="1" <?php echo ((isset($do_pemeriksaan_fisik['ekt_varises']) and $do_pemeriksaan_fisik['ekt_varises'] == '1') ? 'checked' : ''); ?> />&nbsp;Varises
					</tr>
					<tr>
						<td Colspan="3" valign="top">Sistem Kardio</td>
						<td valign="top">:</td>
						<td colspan="4"><input type="checkbox" name="kar_dyspneu" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_dyspneu']) and $do_pemeriksaan_fisik['kar_dyspneu'] == '1') ? 'checked' : ''); ?> />&nbsp;Dyspneu&nbsp;&nbsp;
						<input type="checkbox" name="kar_thacypneu" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_thacypneu']) and $do_pemeriksaan_fisik['kar_thacypneu'] == '1') ? 'checked' : ''); ?> />&nbsp;Thacypneu&nbsp;&nbsp;
						<input type="checkbox" name="kar_wheezing" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_wheezing']) and $do_pemeriksaan_fisik['kar_wheezing'] == '1') ? 'checked' : ''); ?> />&nbsp;Wheezing&nbsp;&nbsp;
						<input type="checkbox" name="kar_batuk" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_batuk']) and $do_pemeriksaan_fisik['kar_batuk'] == '1') ? 'checked' : ''); ?> />&nbsp;Batuk&nbsp;&nbsp;
						<input type="checkbox" name="kar_sputum" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_sputum']) and $do_pemeriksaan_fisik['kar_sputum'] == '1') ? 'checked' : ''); ?> />&nbsp;Sputum&nbsp;&nbsp;
						<input type="checkbox" name="kar_batuk_darah" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_batuk_darah']) and $do_pemeriksaan_fisik['kar_batuk_darah'] == '1') ? 'checked' : ''); ?> />&nbsp;Batuk darah&nbsp;&nbsp;
						<input type="checkbox" name="kar_nyeri" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_nyeri']) and $do_pemeriksaan_fisik['kar_nyeri'] == '1') ? 'checked' : ''); ?> />&nbsp;Nyeri dada&nbsp;&nbsp;<br/>
						<input type="checkbox" name="kar_keringat" value="1" <?php echo ((isset($do_pemeriksaan_fisik['kar_keringat']) and $do_pemeriksaan_fisik['kar_keringat'] == '1') ? 'checked' : ''); ?> />&nbsp;Keringat malam
					</tr>
					<tr>
						<td Colspan="3">Pinggang</td>
						<td>:</td>
						<td colspan="4"><input type="text" name="pinggang" value="<?php echo ((isset($do_pemeriksaan_fisik['pinggang'])) ? $do_pemeriksaan_fisik['pinggang'] : ''); ?>" class="text_dt" style="width:570px;"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pemeriksaan Khusus</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td colspan="6">			
				<table border="0" style="width:850px;">
					<tr>
						<td>Obstetrik</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Abdomen</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">Inspeksi</td>
						<td valign="top">:</td>
						<td colspan="7"><input type="checkbox" name="inf_membesar" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_membesar']) and $do_pemeriksaan_khusus['inf_membesar'] == '1') ? 'checked' : ''); ?> />&nbsp;Membesar dengan arah memanjang&nbsp;&nbsp;
										<input type="checkbox" name="inf_melebar" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_melebar']) and $do_pemeriksaan_khusus['inf_melebar'] == '1') ? 'checked' : ''); ?> />&nbsp;Melebar&nbsp;&nbsp;
										<input type="checkbox" name="inf_vena" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_vena']) and $do_pemeriksaan_khusus['inf_vena'] == '1') ? 'checked' : ''); ?> />&nbsp;Pelebaran vena&nbsp;&nbsp;
										<input type="checkbox" name="inf_linea" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_linea']) and $do_pemeriksaan_khusus['inf_linea'] == '1') ? 'checked' : ''); ?> />&nbsp;Linea alba&nbsp;&nbsp;
										<input type="checkbox" name="inf_nigra" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_nigra']) and $do_pemeriksaan_khusus['inf_nigra'] == '1') ? 'checked' : ''); ?> />&nbsp;Linea nigra&nbsp;&nbsp;
										<input type="checkbox" name="inf_livide" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_livide']) and $do_pemeriksaan_khusus['inf_livide'] == '1') ? 'checked' : ''); ?> />&nbsp;Striae livide&nbsp;&nbsp;
										<input type="checkbox" name="inf_albican" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_albican']) and $do_pemeriksaan_khusus['inf_albican'] == '1') ? 'checked' : ''); ?> />&nbsp;Striae albican&nbsp;&nbsp;
										<input type="checkbox" name="inf_operasi" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_operasi']) and $do_pemeriksaan_khusus['inf_operasi'] == '1') ? 'checked' : ''); ?> />&nbsp;Luka bekas operasi&nbsp;&nbsp;
										<input type="checkbox" name="inf_lain" value="1" <?php echo ((isset($do_pemeriksaan_khusus['inf_lain']) and $do_pemeriksaan_khusus['inf_lain'] == '1') ? 'checked' : ''); ?> />&nbsp;Lain-lain&nbsp;&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">Palpasi</td>
						<td valign="top">:</td>
						<td>TFU</td>
						<td>:</td>
						<td><input type="text" name="tfu" value="<?php echo ((isset($do_pemeriksaan_khusus['tfu'])) ? $do_pemeriksaan_khusus['tfu'] : ''); ?>" class="text_dt">&nbsp;cm</td>
						<td>&nbsp;</td>
						<td>Letak punggung</td>
						<td>:</td>
						<td><input type="radio" name="letak_punggung" value="1" <?php if(isset($do_pemeriksaan_khusus['letak_punggung']) and $do_pemeriksaan_khusus['letak_punggung'] == '1') echo 'checked'; ?> />&nbsp;Puka&nbsp;&nbsp;
							<input type="radio" name="letak_punggung" value="2" <?php if(isset($do_pemeriksaan_khusus['letak_punggung']) and $do_pemeriksaan_khusus['letak_punggung'] == '2') echo 'checked'; ?> />&nbsp;Puki
						</td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
						<td valign="top">&nbsp;</td>
						<td>Presentasi</td>
						<td>:</td>
						<td><input type="text" name="persentasi" value="<?php echo ((isset($do_pemeriksaan_khusus['persentasi'])) ? $do_pemeriksaan_khusus['persentasi'] : ''); ?>" class="text_dt"></td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">TBJ</td>
						<td valign="top">:</td>
						<td colspan="7"><input type="text" name="tbj" value="<?php echo ((isset($do_pemeriksaan_khusus['tbj'])) ? $do_pemeriksaan_khusus['tbj'] : ''); ?>" class="text_dt">&nbsp;gram</td>
					</tr>
					<tr>
						<td valign="top">Auskultasi</td>
						<td valign="top">:</td>
						<td>DJJ</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="djj" value="<?php echo ((isset($do_pemeriksaan_khusus['djj'])) ? $do_pemeriksaan_khusus['djj'] : ''); ?>" class="text_dt">&nbsp;x/menit&nbsp;&nbsp;
						<input type="radio" name="djj_teratur" value="1" <?php if(isset($do_pemeriksaan_khusus['djj_teratur']) and $do_pemeriksaan_khusus['djj_teratur'] == '1') echo 'checked'; ?> />&nbsp;Teratur&nbsp;&nbsp;
							<input type="radio" name="djj_teratur" value="2" <?php if(isset($do_pemeriksaan_khusus['djj_teratur']) and $do_pemeriksaan_khusus['djj_teratur'] == '2') echo 'checked'; ?> />&nbsp;Tidak teratur</td>
					</tr>
					<tr>
						<td valign="top" colspan="3">His/ Kontraksi</td>
						<td valign="top">:</td>
						<td colspan="5"><input type="text" name="kontraksi" value="<?php echo ((isset($do_pemeriksaan_khusus['kontraksi'])) ? $do_pemeriksaan_khusus['kontraksi'] : ''); ?>" class="text_dt">&nbsp;x/menit
							<input type="text" name="kontraksi_detik" value="<?php echo ((isset($do_pemeriksaan_khusus['kontraksi_detik'])) ? $do_pemeriksaan_khusus['kontraksi_detik'] : ''); ?>" class="text_dt">&nbsp;detik&nbsp;&nbsp;
							<input type="radio" name="kontraksi_teratur" value="1" <?php if(isset($do_pemeriksaan_khusus['kontraksi_teratur']) and $do_pemeriksaan_khusus['kontraksi_teratur'] == '1') echo 'checked'; ?> />&nbsp;Teratur&nbsp;&nbsp;
							<input type="radio" name="kontraksi_teratur" value="2" <?php if(isset($do_pemeriksaan_khusus['kontraksi_teratur']) and $do_pemeriksaan_khusus['kontraksi_teratur'] == '2') echo 'checked'; ?> />&nbsp;Tidak teratur
						</td>
					</tr>
					<tr>
						<td>Gynekologi</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>Ano Genital</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">Inspeksi</td>
						<td valign="top">:</td>
						<td>Pengeluaran per vaginam</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="vaginam" value="<?php echo ((isset($do_pemeriksaan_khusus['vaginam'])) ? $do_pemeriksaan_khusus['vaginam'] : ''); ?>" class="text_dt" style="width:570px;"></td>
					</tr>
					<tr>
						<td valign="top">Inspekulo</td>
						<td valign="top">:</td>
						<td>Vagina</td>
						<td>:</td>
						<td colspan="5"><input type="text" name="inspekulo" value="<?php echo ((isset($do_pemeriksaan_khusus['inspekulo'])) ? $do_pemeriksaan_khusus['inspekulo'] : ''); ?>" class="text_dt" style="width:570px;"></td>
					</tr>
					<tr>
						<td valign="top" colspan="3">Vaginal Toucher</td>
						<td valign="top">:</td>
						<td colspan="5"><input type="text" name="toucher" value="<?php echo ((isset($do_pemeriksaan_khusus['toucher'])) ? $do_pemeriksaan_khusus['toucher'] : ''); ?>" class="text_dt" style="width:570px;"></td>
					</tr>
					<tr>
						<td valign="top" colspan="3">Kesan panggul</td>
						<td valign="top">:</td>
						<td colspan="5"><input type="text" name="kesan_panggul" value="<?php echo ((isset($do_pemeriksaan_khusus['kesan_panggul'])) ? $do_pemeriksaan_khusus['kesan_panggul'] : ''); ?>" class="text_dt" style="width:570px;"></td>
					</tr>
					<tr>
						<td>Nifas</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
						<td valign="top">&nbsp;</td>
						<td>TFU</td>
						<td valign="top">:</td>
						<td><input type="text" name="tfu_nifas" value="<?php echo ((isset($do_pemeriksaan_khusus['tfu_nifas'])) ? $do_pemeriksaan_khusus['tfu_nifas'] : ''); ?>" class="text_dt"></td>
						<td>&nbsp;</td>
						<td>Kontraksi uterus</td>
						<td>:</td>
						<td><input type="text" name="kon_uterus" value="<?php echo ((isset($do_pemeriksaan_khusus['kon_uterus'])) ? $do_pemeriksaan_khusus['kon_uterus'] : ''); ?>" class="text_dt"></td>
					</tr>
					<tr>
						<td valign="top">&nbsp;</td>
						<td valign="top">&nbsp;</td>
						<td>Lochea</td>
						<td valign="top">:</td>
						<td><input type="text" name="lochea" value="<?php echo ((isset($do_pemeriksaan_khusus['lochea'])) ? $do_pemeriksaan_khusus['lochea'] : ''); ?>" class="text_dt"></td>
						<td>&nbsp;</td>
						<td>Luka jalan lahir</td>
						<td>:</td>
						<td><input type="text" name="jalan_lahir" value="<?php echo ((isset($do_pemeriksaan_khusus['jalan_lahir'])) ? $do_pemeriksaan_khusus['jalan_lahir'] : ''); ?>" class="text_dt"></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Penapisan Nyeri</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top" colspan="6">Skor Nyeri : <input type="radio" name="skor_nyeri" value="0" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='0') ? 'checked' : ''); ?>>&nbsp;0&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="1" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='1') ? 'checked' : ''); ?>>&nbsp;1&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="2" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='2') ? 'checked' : ''); ?>>&nbsp;2&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="3" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='3') ? 'checked' : ''); ?>>&nbsp;3&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="4" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='4') ? 'checked' : ''); ?>>&nbsp;4&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="5" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='5') ? 'checked' : ''); ?>>&nbsp;5&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="6" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='6') ? 'checked' : ''); ?>>&nbsp;6&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="7" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='7') ? 'checked' : ''); ?>>&nbsp;7&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="8" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='8') ? 'checked' : ''); ?>>&nbsp;8&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="9" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='9') ? 'checked' : ''); ?>>&nbsp;9&nbsp;&nbsp;
			<input type="radio" name="skor_nyeri" value="10" <?php echo ((isset($do_penapisan_nyeri['skor_nyeri']) and $do_penapisan_nyeri['skor_nyeri']=='10') ? 'checked' : ''); ?>>&nbsp;10&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td colspan="6">
				<img src="edoc_rekammedik/new/skala_nyeri.jpg" width="650px">
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top" colspan="6">Nyeri hilang bila : <input type="checkbox" name="nyeri_obat" value="1" <?php echo ((isset($do_penapisan_nyeri['nyeri_obat']) and $do_penapisan_nyeri['nyeri_obat'] == '1') ? 'checked' : ''); ?> />&nbsp;Minum obat&nbsp;&nbsp;
										<input type="checkbox" name="nyeri_istirahat" value="1" <?php echo ((isset($do_penapisan_nyeri['nyeri_istirahat']) and $do_penapisan_nyeri['nyeri_istirahat'] == '1') ? 'checked' : ''); ?> />&nbsp;Istirahat&nbsp;&nbsp;
										<input type="checkbox" name="nyeri_tidur" value="1" <?php echo ((isset($do_penapisan_nyeri['nyeri_tidur']) and $do_penapisan_nyeri['nyeri_tidur'] == '1') ? 'checked' : ''); ?> />&nbsp;Berubah posisi tidur&nbsp;&nbsp;</td>
		</tr>
			<tr>
			<td>&nbsp;</td>
			<td valign="top" >Pemeriksaan Penunjang</td>
			<td valign="top">:</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">
				<table border="0" style="width:850px;">
					<tr>
						<td>Darah Hb</td>
						<td>:</td>
						<td><input type="text" name="penunjang_darah" value="<?php echo ((isset($do_penunjang['penunjang_darah'])) ? $do_penunjang['penunjang_darah'] : ''); ?>" class="text_dt" >&nbsp;gr%</td>
						<td>&nbsp;</td>
						<td>HbSag</td>
						<td>:</td>
						<td><input type="text" name="penunjang_hbsag" value="<?php echo ((isset($do_penunjang['penunjang_hbsag'])) ? $do_penunjang['penunjang_hbsag'] : ''); ?>" class="text_dt" ></td>
						<td>Protein Urine</td>
						<td>:</td>
						<td><input type="text" name="penunjang_protein" value="<?php echo ((isset($do_penunjang['penunjang_protein'])) ? $do_penunjang['penunjang_protein'] : ''); ?>" class="text_dt" ></td>
					</tr>
					<tr>
						<td>CTG</td>
						<td>:</td>
						<td colspan="5"><input type="radio" name="penunjang_janin" value="1" <?php if(isset($do_penunjang['penunjang_janin']) and $do_penunjang['penunjang_janin'] == '1') echo 'checked'; ?> />&nbsp;Janin reaktif&nbsp;&nbsp;
							<input type="radio" name="penunjang_janin" value="2" <?php if(isset($do_penunjang['penunjang_janin']) and $do_penunjang['penunjang_janin'] == '2') echo 'checked'; ?> />&nbsp;Tidak reaktif</td>
						<td>USG</td>
						<td>:</td>
						<td><input type="text" name="penunjang_usg" value="<?php echo ((isset($do_penunjang['penunjang_usg'])) ? $do_penunjang['penunjang_usg'] : ''); ?>" class="text_dt" ></td>
					</tr>
				</table>	
			</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Analisa Data</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="analisa_data" class="text_dt10" ><?php echo $analisa_data; ?></textarea></td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Penatalaksanaan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="penatalaksanaan" class="text_dt10" ><?php echo $penatalaksanaan; ?></textarea></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr><td colspan="8" align="right" >
		Update : <?php echo $register_kandungan; ?>
		<input type="checkbox" name="final" id="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
				<?php if($final == '1'){ ?>
					<?php if($dokter_pjawab == $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
						<input type="button" value="simpan" class="myButton1" onclick="simpan_2();"/>
					<?php } ?>
				<?php }else{ ?>
					<input type="button" value="simpan" class="myButton1" onclick="simpan_2();"/>
				<?php } ?>
			<?php } ?>
		
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "25"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } ?>
			</td>
        </tr>
    </table>
</form>
<script>
<?php if(isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
	<?php if($final == '1'){ ?>
		<?php if($dokter_pjawab != $_SESSION['SES_SIMRS_PEGAWAI_ID']){ ?>
			$(':input').attr('readonly','readonly');
		<?php } ?>
	<?php } ?>
<?php }else{ ?>
	$(':input').attr('readonly','readonly');
<?php } ?>

function simpan_2(){
	_haschange = false;
	$('#formperiksa_2').submit();
}	

</script>