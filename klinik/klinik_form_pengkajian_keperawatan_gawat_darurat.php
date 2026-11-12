<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|','!',$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}
	
if (isset($_POST['irja_id'])){
	$st_save = true;
	if($st_save){
		$st_final = 'NULL';
		if(isset($_POST['final'])) $st_final = '"1"';
		
		$triase = array('triage_emergency'=>((isset($_POST['triage_emergency'])) ? $_POST['triage_emergency'] : ''),
						'triage_urgent'=>((isset($_POST['triage_urgent'])) ? $_POST['triage_urgent'] : ''),
						'triage_non_urgent'=>((isset($_POST['triage_non_urgent'])) ? $_POST['triage_non_urgent'] : ''),
						'triage_false_emergency'=>((isset($_POST['triage_false_emergency'])) ? $_POST['triage_false_emergency'] : ''),
						'triage_doa'=>((isset($_POST['triage_doa'])) ? $_POST['triage_doa'] : ''));
		$triase = json_encode($triase);
		$triase = str_replace('"','|',$triase);
		
		$riwayat_masuk = array('informasi_dapat'=>((isset($_POST['informasi_dapat'])) ? $_POST['informasi_dapat'] : ''),
						'anamnesa_nama'=>replace_quote($_POST['anamnesa_nama']),
						'anamnesa_hubungan'=>replace_quote($_POST['anamnesa_hubungan']),
						'cara_masuk'=>((isset($_POST['cara_masuk'])) ? $_POST['cara_masuk'] : ''),
						'asal_masuk'=>((isset($_POST['asal_masuk'])) ? $_POST['asal_masuk'] : ''));
		$riwayat_masuk = json_encode($riwayat_masuk);
		$riwayat_masuk = str_replace('"','|',$riwayat_masuk);
		
		$riwayat_penyakit = array('sekarang'=>replace_quote($_POST['sekarang']),
						'rp_tb'=>replace_quote($_POST['rp_tb']),
						'rp_bb'=>replace_quote($_POST['rp_bb']),
						'dahulu'=>replace_quote($_POST['dahulu']),
						'pengobatan'=>replace_quote($_POST['pengobatan']));
		$riwayat_penyakit = json_encode($riwayat_penyakit);
		$riwayat_penyakit = str_replace('"','|',$riwayat_penyakit);
		
		$general_impression = array('keluhan_utama'=>replace_quote($_POST['keluhan_utama']),
						'mekanisme_cedera'=>replace_quote($_POST['mekanisme_cedera']),
						'orientasi'=>((isset($_POST['orientasi'])) ? $_POST['orientasi'] : ''));
		$general_impression = json_encode($general_impression);
		$general_impression = str_replace('"','|',$general_impression);

		$tanda_vital = array('gcs_e'=>replace_quote($_POST['gcs_e']),
						'gcs_m'=>replace_quote($_POST['gcs_m']),
						'gcs_v'=>replace_quote($_POST['gcs_v']),
						'spo'=>replace_quote($_POST['spo']),
						'td'=>replace_quote($_POST['td']),
						'reflex_cahaya_l'=>replace_quote($_POST['reflex_cahaya_l']),
						'reflex_cahaya_r'=>replace_quote($_POST['reflex_cahaya_r']),
						'nafas'=>replace_quote($_POST['nafas']),
						'suhu'=>replace_quote($_POST['suhu']),
						'nadi'=>replace_quote($_POST['nadi']),
						'nadi_reguler'=>((isset($_POST['nadi_reguler'])) ? $_POST['nadi_reguler'] : ''),
						'akral'=>replace_quote($_POST['akral']),
						'respon'=>((isset($_POST['respon'])) ? $_POST['respon'] : ''),
						'kesadaran'=>((isset($_POST['kesadaran'])) ? $_POST['kesadaran'] : ''),
						'gcs_e2'=>replace_quote($_POST['gcs_e2']),
						'gcs_m2'=>replace_quote($_POST['gcs_m2']),
						'gcs_v2'=>replace_quote($_POST['gcs_v2']),
						'pupil'=>((isset($_POST['pupil'])) ? $_POST['pupil'] : ''),
						'pupil_ket'=>replace_quote($_POST['pupil_ket']),
						'reflex_cahaya'=>((isset($_POST['reflex_cahaya'])) ? $_POST['reflex_cahaya'] : ''),
						'crt'=>((isset($_POST['crt'])) ? $_POST['crt'] : ''),
						'sianosis'=>((isset($_POST['sianosis'])) ? $_POST['sianosis'] : ''),
						'nadi_teraba'=>((isset($_POST['nadi_teraba'])) ? $_POST['nadi_teraba'] : ''),
						'sesak_nafas'=>((isset($_POST['sesak_nafas'])) ? $_POST['sesak_nafas'] : ''),
						'sesak_nafas_ket'=>replace_quote($_POST['sesak_nafas_ket']),
						'jalan_nafas'=>((isset($_POST['jalan_nafas'])) ? $_POST['jalan_nafas'] : ''),
						'obstruksi'=>((isset($_POST['obstruksi'])) ? $_POST['obstruksi'] : ''),
						'suara_nafas'=>((isset($_POST['suara_nafas'])) ? $_POST['suara_nafas'] : ''),
						'gerakan_dada'=>((isset($_POST['gerakan_dada'])) ? $_POST['gerakan_dada'] : ''),
						'irama_nafas'=>((isset($_POST['irama_nafas'])) ? $_POST['irama_nafas'] : ''),
						'pola_nafas'=>((isset($_POST['pola_nafas'])) ? $_POST['pola_nafas'] : ''),
						'retraksi_otot'=>((isset($_POST['retraksi_otot'])) ? $_POST['retraksi_otot'] : ''),
						'pendarahan'=>((isset($_POST['pendarahan'])) ? $_POST['pendarahan'] : ''),
						'deformitas'=>((isset($_POST['deformitas'])) ? $_POST['deformitas'] : ''),
						'contusio'=>((isset($_POST['contusio'])) ? $_POST['contusio'] : ''),
						'abrasi'=>((isset($_POST['abrasi'])) ? $_POST['abrasi'] : ''),
						'penetrasi'=>((isset($_POST['penetrasi'])) ? $_POST['penetrasi'] : ''),
						'leserasi'=>((isset($_POST['leserasi'])) ? $_POST['leserasi'] : ''),
						'edema'=>((isset($_POST['edema'])) ? $_POST['edema'] : ''),
						'kejang'=>((isset($_POST['kejang'])) ? $_POST['kejang'] : ''),
						'lama_kejang'=>replace_quote($_POST['lama_kejang']),
						'skala_nyeri'=>replace_quote($_POST['skala_nyeri']),
						'frekuensi_nyeri'=>((isset($_POST['frekuensi_nyeri'])) ? $_POST['frekuensi_nyeri'] : ''),
						'lama_nyeri'=>replace_quote($_POST['lama_nyeri']),
						'nyeri_menjalar'=>((isset($_POST['nyeri_menjalar'])) ? $_POST['nyeri_menjalar'] : ''),
						'kualitas_nyeri'=>((isset($_POST['kualitas_nyeri'])) ? $_POST['kualitas_nyeri'] : ''),
						'pemicu_nyeri'=>replace_quote($_POST['pemicu_nyeri']),
						'pengurang_nyeri'=>replace_quote($_POST['pengurang_nyeri']),
						'pengkajian_fungsi'=>((isset($_POST['pengkajian_fungsi'])) ? $_POST['pengkajian_fungsi'] : ''),
						'keluhan_tambahan'=>replace_quote($_POST['keluhan_tambahan']));
		$tanda_vital = json_encode($tanda_vital);
		$tanda_vital = str_replace('"','|',$tanda_vital);
		
		$risiko_pasien_jatuh = array('pasien_jatuh_1'=>((isset($_POST['pasien_jatuh_1'])) ? $_POST['pasien_jatuh_1'] : ''),
						'pasien_jatuh_2'=>((isset($_POST['pasien_jatuh_2'])) ? $_POST['pasien_jatuh_2'] : ''),
						'pasien_jatuh_3'=>((isset($_POST['pasien_jatuh_3'])) ? $_POST['pasien_jatuh_3'] : ''),
						'intervensi_pasien_jatuh_1'=>((isset($_POST['intervensi_pasien_jatuh_1'])) ? $_POST['intervensi_pasien_jatuh_1'] : ''),
						'intervensi_pasien_jatuh_2'=>((isset($_POST['intervensi_pasien_jatuh_2'])) ? $_POST['intervensi_pasien_jatuh_2'] : ''),
						'intervensi_pasien_jatuh_3'=>((isset($_POST['intervensi_pasien_jatuh_3'])) ? $_POST['intervensi_pasien_jatuh_3'] : ''));
		$risiko_pasien_jatuh = json_encode($risiko_pasien_jatuh);
		$risiko_pasien_jatuh = str_replace('"','|',$risiko_pasien_jatuh);
		
		$risiko_pasien_dekubitus = array('pasien_dekubitus_1'=>((isset($_POST['pasien_dekubitus_1'])) ? $_POST['pasien_dekubitus_1'] : ''),
						'pasien_dekubitus_2'=>((isset($_POST['pasien_dekubitus_2'])) ? $_POST['pasien_dekubitus_2'] : ''),
						'pasien_dekubitus_3'=>((isset($_POST['pasien_dekubitus_3'])) ? $_POST['pasien_dekubitus_3'] : ''),
						'pasien_dekubitus_4'=>((isset($_POST['pasien_dekubitus_4'])) ? $_POST['pasien_dekubitus_4'] : ''),
						'pasien_dekubitus_5'=>((isset($_POST['pasien_dekubitus_5'])) ? $_POST['pasien_dekubitus_5'] : ''));
		$risiko_pasien_dekubitus = json_encode($risiko_pasien_dekubitus);
		$risiko_pasien_dekubitus = str_replace('"','|',$risiko_pasien_dekubitus);
		
		$status_kehamilan = array('hamil'=>((isset($_POST['hamil'])) ? $_POST['hamil'] : ''),
						'gravida'=>replace_quote($_POST['gravida']),
						'hpht'=>replace_quote($_POST['hpht']),
						'para'=>replace_quote($_POST['para']),
						'abortus'=>replace_quote($_POST['abortus']));
		$status_kehamilan = json_encode($status_kehamilan);
		$status_kehamilan = str_replace('"','|',$status_kehamilan);
		
		$pemeriksaan_penunjang = array('radiologi'=>((isset($_POST['radiologi'])) ? $_POST['radiologi'] : ''),
									'radiologi_1'=>((isset($_POST['radiologi_1'])) ? $_POST['radiologi_1'] : ''),
									'radiologi_2'=>((isset($_POST['radiologi_2'])) ? $_POST['radiologi_2'] : ''),
									'laboratorium'=>((isset($_POST['laboratorium'])) ? $_POST['laboratorium'] : ''),
									'usg'=>((isset($_POST['usg'])) ? $_POST['usg'] : ''),
									'ekg'=>((isset($_POST['ekg'])) ? $_POST['ekg'] : ''),
									'lain_lain'=>((isset($_POST['lain_lain'])) ? $_POST['lain_lain'] : ''));
		$pemeriksaan_penunjang = json_encode($pemeriksaan_penunjang);
		$pemeriksaan_penunjang = str_replace('"','|',$pemeriksaan_penunjang);
		
		$diagnosa_keperawatan = array('diagkep_1'=>((isset($_POST['diagkep_1'])) ? $_POST['diagkep_1'] : ''),
									'diagkep_2'=>((isset($_POST['diagkep_2'])) ? $_POST['diagkep_2'] : ''),
									'diagkep_3'=>((isset($_POST['diagkep_3'])) ? $_POST['diagkep_3'] : ''),
									'diagkep_4'=>((isset($_POST['diagkep_4'])) ? $_POST['diagkep_4'] : ''),
									'diagkep_5'=>((isset($_POST['diagkep_5'])) ? $_POST['diagkep_5'] : ''),
									'diagkep_6'=>((isset($_POST['diagkep_6'])) ? $_POST['diagkep_6'] : ''),
									'diagkep_7'=>((isset($_POST['diagkep_7'])) ? $_POST['diagkep_7'] : ''),
									'diagkep_8'=>((isset($_POST['diagkep_8'])) ? $_POST['diagkep_8'] : ''),
									'diagkep_9'=>((isset($_POST['diagkep_9'])) ? $_POST['diagkep_9'] : ''),
									'diagkep_10'=>((isset($_POST['diagkep_10'])) ? $_POST['diagkep_10'] : ''),
									'diagkep_11'=>((isset($_POST['diagkep_11'])) ? $_POST['diagkep_11'] : ''),
									'diagkep_12'=>((isset($_POST['diagkep_12'])) ? $_POST['diagkep_12'] : ''),
									'diagkep_13'=>((isset($_POST['diagkep_13'])) ? $_POST['diagkep_13'] : ''),
									'diagkep_14'=>((isset($_POST['diagkep_14'])) ? $_POST['diagkep_14'] : ''),
									'diagkep_15'=>((isset($_POST['diagkep_15'])) ? $_POST['diagkep_15'] : ''),
									'diagkep_16'=>((isset($_POST['diagkep_16'])) ? $_POST['diagkep_16'] : ''),
									'diagkep_17'=>replace_quote($_POST['diagkep_17']));
		$diagnosa_keperawatan = json_encode($diagnosa_keperawatan);
		$diagnosa_keperawatan = str_replace('"','|',$diagnosa_keperawatan);
		
		$intervensi_keperawatan = array('intkep_1'=>((isset($_POST['intkep_1'])) ? $_POST['intkep_1'] : ''),
									'intkep_2'=>((isset($_POST['intkep_2'])) ? $_POST['intkep_2'] : ''),
									'intkep_3'=>((isset($_POST['intkep_3'])) ? $_POST['intkep_3'] : ''),
									'intkep_4'=>((isset($_POST['intkep_4'])) ? $_POST['intkep_4'] : ''),
									'intkep_5'=>((isset($_POST['intkep_5'])) ? $_POST['intkep_5'] : ''),
									'intkep_6'=>((isset($_POST['intkep_6'])) ? $_POST['intkep_6'] : ''),
									'intkep_7'=>((isset($_POST['intkep_7'])) ? $_POST['intkep_7'] : ''),
									'intkep_8'=>((isset($_POST['intkep_8'])) ? $_POST['intkep_8'] : ''),
									'intkep_9'=>((isset($_POST['intkep_9'])) ? $_POST['intkep_9'] : ''),
									'intkep_10'=>((isset($_POST['intkep_10'])) ? $_POST['intkep_10'] : ''),
									'intkep_11'=>((isset($_POST['intkep_11'])) ? $_POST['intkep_11'] : ''),
									'intkep_12'=>((isset($_POST['intkep_12'])) ? $_POST['intkep_12'] : ''),
									'intkep_13'=>((isset($_POST['intkep_13'])) ? $_POST['intkep_13'] : ''),
									'intkep_14'=>((isset($_POST['intkep_14'])) ? $_POST['intkep_14'] : ''),
									'intkep_15'=>((isset($_POST['intkep_15'])) ? $_POST['intkep_15'] : ''),
									'intkep_16'=>((isset($_POST['intkep_16'])) ? $_POST['intkep_16'] : ''),
									'intkep_17'=>replace_quote($_POST['intkep_17']),
									'intkep_1_1'=>((isset($_POST['intkep_1_1'])) ? $_POST['intkep_1_1'] : ''),
									'intkep_5_1'=>replace_quote($_POST['intkep_5_1']),
									'intkep_5_2'=>replace_quote($_POST['intkep_5_2']));
		$intervensi_keperawatan = json_encode($intervensi_keperawatan);
		$intervensi_keperawatan = str_replace('"','|',$intervensi_keperawatan);
		
		$implementasi_keperawatan = array('impkep_pukul_1'=>replace_quote($_POST['impkep_pukul_1']),'impkep_tindakan_1'=>replace_quote($_POST['impkep_tindakan_1']),'impkep_nama_1'=>replace_quote($_POST['impkep_nama_1']),
										'impkep_pukul_2'=>replace_quote($_POST['impkep_pukul_2']),'impkep_tindakan_2'=>replace_quote($_POST['impkep_tindakan_2']),'impkep_nama_2'=>replace_quote($_POST['impkep_nama_2']),
										'impkep_pukul_3'=>replace_quote($_POST['impkep_pukul_3']),'impkep_tindakan_3'=>replace_quote($_POST['impkep_tindakan_3']),'impkep_nama_3'=>replace_quote($_POST['impkep_nama_3']),
										'impkep_pukul_4'=>replace_quote($_POST['impkep_pukul_4']),'impkep_tindakan_4'=>replace_quote($_POST['impkep_tindakan_4']),'impkep_nama_4'=>replace_quote($_POST['impkep_nama_4']),
										'impkep_pukul_5'=>replace_quote($_POST['impkep_pukul_5']),'impkep_tindakan_5'=>replace_quote($_POST['impkep_tindakan_5']),'impkep_nama_5'=>replace_quote($_POST['impkep_nama_5']),
										'impkep_pukul_6'=>replace_quote($_POST['impkep_pukul_6']),'impkep_tindakan_6'=>replace_quote($_POST['impkep_tindakan_6']),'impkep_nama_6'=>replace_quote($_POST['impkep_nama_6']),
										'impkep_pukul_7'=>replace_quote($_POST['impkep_pukul_7']),'impkep_tindakan_7'=>replace_quote($_POST['impkep_tindakan_7']),'impkep_nama_7'=>replace_quote($_POST['impkep_nama_7']),
										'impkep_pukul_8'=>replace_quote($_POST['impkep_pukul_8']),'impkep_tindakan_8'=>replace_quote($_POST['impkep_tindakan_8']),'impkep_nama_8'=>replace_quote($_POST['impkep_nama_8']),
										'impkep_pukul_9'=>replace_quote($_POST['impkep_pukul_9']),'impkep_tindakan_9'=>replace_quote($_POST['impkep_tindakan_9']),'impkep_nama_9'=>replace_quote($_POST['impkep_nama_9']),
										'impkep_pukul_10'=>replace_quote($_POST['impkep_pukul_10']),'impkep_tindakan_10'=>replace_quote($_POST['impkep_tindakan_10']),'impkep_nama_10'=>replace_quote($_POST['impkep_nama_10']),
										'impkep_pukul_11'=>replace_quote($_POST['impkep_pukul_11']),'impkep_tindakan_11'=>replace_quote($_POST['impkep_tindakan_11']),'impkep_nama_11'=>replace_quote($_POST['impkep_nama_11']),
										'impkep_pukul_12'=>replace_quote($_POST['impkep_pukul_12']),'impkep_tindakan_12'=>replace_quote($_POST['impkep_tindakan_12']),'impkep_nama_12'=>replace_quote($_POST['impkep_nama_12']),
										'impkep_pukul_13'=>replace_quote($_POST['impkep_pukul_13']),'impkep_tindakan_13'=>replace_quote($_POST['impkep_tindakan_13']),'impkep_nama_13'=>replace_quote($_POST['impkep_nama_13']),
										'impkep_pukul_14'=>replace_quote($_POST['impkep_pukul_14']),'impkep_tindakan_14'=>replace_quote($_POST['impkep_tindakan_14']),'impkep_nama_14'=>replace_quote($_POST['impkep_nama_14']));
		$implementasi_keperawatan = json_encode($implementasi_keperawatan);
		$implementasi_keperawatan = str_replace('"','|',$implementasi_keperawatan);
		
		$infus_obat = array('infus_obat_pukul_1'=>replace_quote($_POST['infus_obat_pukul_1']),
							'infus_obat_nama_1'=>replace_quote($_POST['infus_obat_nama_1']),
							'infus_obat_dosis_1'=>replace_quote($_POST['infus_obat_dosis_1']),
							'infus_obat_rute_1'=>replace_quote($_POST['infus_obat_rute_1']),
							'infus_obat_periksa_1'=>replace_quote($_POST['infus_obat_periksa_1']),
							'infus_obat_beri_1'=>replace_quote($_POST['infus_obat_beri_1']),
							
							'infus_obat_pukul_2'=>replace_quote($_POST['infus_obat_pukul_2']),
							'infus_obat_nama_2'=>replace_quote($_POST['infus_obat_nama_2']),
							'infus_obat_dosis_2'=>replace_quote($_POST['infus_obat_dosis_2']),
							'infus_obat_rute_2'=>replace_quote($_POST['infus_obat_rute_2']),
							'infus_obat_periksa_2'=>replace_quote($_POST['infus_obat_periksa_2']),
							'infus_obat_beri_2'=>replace_quote($_POST['infus_obat_beri_2']),
							
							'infus_obat_pukul_3'=>replace_quote($_POST['infus_obat_pukul_3']),
							'infus_obat_nama_3'=>replace_quote($_POST['infus_obat_nama_3']),
							'infus_obat_dosis_3'=>replace_quote($_POST['infus_obat_dosis_3']),
							'infus_obat_rute_3'=>replace_quote($_POST['infus_obat_rute_3']),
							'infus_obat_periksa_3'=>replace_quote($_POST['infus_obat_periksa_3']),
							'infus_obat_beri_3'=>replace_quote($_POST['infus_obat_beri_3']),
							
							'infus_obat_pukul_4'=>replace_quote($_POST['infus_obat_pukul_4']),
							'infus_obat_nama_4'=>replace_quote($_POST['infus_obat_nama_4']),
							'infus_obat_dosis_4'=>replace_quote($_POST['infus_obat_dosis_4']),
							'infus_obat_rute_4'=>replace_quote($_POST['infus_obat_rute_4']),
							'infus_obat_periksa_4'=>replace_quote($_POST['infus_obat_periksa_4']),
							'infus_obat_beri_4'=>replace_quote($_POST['infus_obat_beri_4']),
							
							'infus_obat_pukul_5'=>replace_quote($_POST['infus_obat_pukul_5']),
							'infus_obat_nama_5'=>replace_quote($_POST['infus_obat_nama_5']),
							'infus_obat_dosis_5'=>replace_quote($_POST['infus_obat_dosis_5']),
							'infus_obat_rute_5'=>replace_quote($_POST['infus_obat_rute_5']),
							'infus_obat_periksa_5'=>replace_quote($_POST['infus_obat_periksa_5']),
							'infus_obat_beri_5'=>replace_quote($_POST['infus_obat_beri_5']),
							
							'infus_obat_pukul_6'=>replace_quote($_POST['infus_obat_pukul_6']),
							'infus_obat_nama_6'=>replace_quote($_POST['infus_obat_nama_6']),
							'infus_obat_dosis_6'=>replace_quote($_POST['infus_obat_dosis_6']),
							'infus_obat_rute_6'=>replace_quote($_POST['infus_obat_rute_6']),
							'infus_obat_periksa_6'=>replace_quote($_POST['infus_obat_periksa_6']),
							'infus_obat_beri_6'=>replace_quote($_POST['infus_obat_beri_6']),
							
							'infus_obat_pukul_7'=>replace_quote($_POST['infus_obat_pukul_7']),
							'infus_obat_nama_7'=>replace_quote($_POST['infus_obat_nama_7']),
							'infus_obat_dosis_7'=>replace_quote($_POST['infus_obat_dosis_7']),
							'infus_obat_rute_7'=>replace_quote($_POST['infus_obat_rute_7']),
							'infus_obat_periksa_7'=>replace_quote($_POST['infus_obat_periksa_7']),
							'infus_obat_beri_7'=>replace_quote($_POST['infus_obat_beri_7']),
							
							'infus_obat_pukul_8'=>replace_quote($_POST['infus_obat_pukul_8']),
							'infus_obat_nama_8'=>replace_quote($_POST['infus_obat_nama_8']),
							'infus_obat_dosis_8'=>replace_quote($_POST['infus_obat_dosis_8']),
							'infus_obat_rute_8'=>replace_quote($_POST['infus_obat_rute_8']),
							'infus_obat_periksa_8'=>replace_quote($_POST['infus_obat_periksa_8']),
							'infus_obat_beri_8'=>replace_quote($_POST['infus_obat_beri_8']),
							
							'infus_obat_pukul_9'=>replace_quote($_POST['infus_obat_pukul_9']),
							'infus_obat_nama_9'=>replace_quote($_POST['infus_obat_nama_9']),
							'infus_obat_dosis_9'=>replace_quote($_POST['infus_obat_dosis_9']),
							'infus_obat_rute_9'=>replace_quote($_POST['infus_obat_rute_9']),
							'infus_obat_periksa_9'=>replace_quote($_POST['infus_obat_periksa_9']),
							'infus_obat_beri_9'=>replace_quote($_POST['infus_obat_beri_9']),
							
							'infus_obat_pukul_10'=>replace_quote($_POST['infus_obat_pukul_10']),
							'infus_obat_nama_10'=>replace_quote($_POST['infus_obat_nama_10']),
							'infus_obat_dosis_10'=>replace_quote($_POST['infus_obat_dosis_10']),
							'infus_obat_rute_10'=>replace_quote($_POST['infus_obat_rute_10']),
							'infus_obat_periksa_10'=>replace_quote($_POST['infus_obat_periksa_10']),
							'infus_obat_beri_10'=>replace_quote($_POST['infus_obat_beri_10']),
							
							'infus_obat_pukul_11'=>replace_quote($_POST['infus_obat_pukul_11']),
							'infus_obat_nama_11'=>replace_quote($_POST['infus_obat_nama_11']),
							'infus_obat_dosis_11'=>replace_quote($_POST['infus_obat_dosis_11']),
							'infus_obat_rute_11'=>replace_quote($_POST['infus_obat_rute_11']),
							'infus_obat_periksa_11'=>replace_quote($_POST['infus_obat_periksa_11']),
							'infus_obat_beri_11'=>replace_quote($_POST['infus_obat_beri_11']),
							
							'infus_obat_pukul_12'=>replace_quote($_POST['infus_obat_pukul_12']),
							'infus_obat_nama_12'=>replace_quote($_POST['infus_obat_nama_12']),
							'infus_obat_dosis_12'=>replace_quote($_POST['infus_obat_dosis_12']),
							'infus_obat_rute_12'=>replace_quote($_POST['infus_obat_rute_12']),
							'infus_obat_periksa_12'=>replace_quote($_POST['infus_obat_periksa_12']),
							'infus_obat_beri_12'=>replace_quote($_POST['infus_obat_beri_12']),
							
							'infus_obat_pukul_13'=>replace_quote($_POST['infus_obat_pukul_13']),
							'infus_obat_nama_13'=>replace_quote($_POST['infus_obat_nama_13']),
							'infus_obat_dosis_13'=>replace_quote($_POST['infus_obat_dosis_13']),
							'infus_obat_rute_13'=>replace_quote($_POST['infus_obat_rute_13']),
							'infus_obat_periksa_13'=>replace_quote($_POST['infus_obat_periksa_13']),
							'infus_obat_beri_13'=>replace_quote($_POST['infus_obat_beri_13']),
							
							'infus_obat_pukul_14'=>replace_quote($_POST['infus_obat_pukul_14']),
							'infus_obat_nama_14'=>replace_quote($_POST['infus_obat_nama_14']),
							'infus_obat_dosis_14'=>replace_quote($_POST['infus_obat_dosis_14']),
							'infus_obat_rute_14'=>replace_quote($_POST['infus_obat_rute_14']),
							'infus_obat_periksa_14'=>replace_quote($_POST['infus_obat_periksa_14']),
							'infus_obat_beri_14'=>replace_quote($_POST['infus_obat_beri_14']));
		$infus_obat = json_encode($infus_obat);
		$infus_obat = str_replace('"','|',$infus_obat);
		
		$evaluasi_keperawatan = array('subjective'=>replace_quote($_POST['subjective']),
								'objective'=>replace_quote($_POST['objective']),
								'eva_gcs_e'=>replace_quote($_POST['eva_gcs_e']),
								'eva_gcs_m'=>replace_quote($_POST['eva_gcs_m']),
								'eva_gcs_v'=>replace_quote($_POST['eva_gcs_v']),
								'eva_spo'=>replace_quote($_POST['eva_spo']),
								'eva_td'=>replace_quote($_POST['eva_td']),
								'eva_reflex_cahaya_l'=>replace_quote($_POST['eva_reflex_cahaya_l']),
								'eva_reflex_cahaya_r'=>replace_quote($_POST['eva_reflex_cahaya_r']),
								'eva_nafas'=>replace_quote($_POST['eva_nafas']),
								'eva_suhu'=>replace_quote($_POST['eva_suhu']),
								'eva_nadi'=>replace_quote($_POST['eva_nadi']),
								'eva_nadi_reguler'=>((isset($_POST['eva_nadi_reguler'])) ? $_POST['eva_nadi_reguler'] : ''),
								'eva_akral'=>replace_quote($_POST['eva_akral']),
								'eva_assesment'=>replace_quote($_POST['eva_assesment']),
								'eva_planning'=>replace_quote($_POST['eva_planning']));
		$evaluasi_keperawatan = json_encode($evaluasi_keperawatan);
		$evaluasi_keperawatan = str_replace('"','|',$evaluasi_keperawatan);
		
		$followup = array('masuk_rs'=>((isset($_POST['masuk_rs'])) ? $_POST['masuk_rs'] : ''),
						'masuk_ruang'=>replace_quote($_POST['masuk_ruang']),
						'petugas_penerima'=>replace_quote($_POST['petugas_penerima']),
						'tindakan_lanjutan'=>((isset($_POST['tindakan_lanjutan'])) ? $_POST['tindakan_lanjutan'] : ''),
						'tindakan_lanjutan_ok'=>((isset($_POST['tindakan_lanjutan_ok'])) ? $_POST['tindakan_lanjutan_ok'] : ''),
						'tindakan_lanjutan_opd'=>((isset($_POST['tindakan_lanjutan_opd'])) ? $_POST['tindakan_lanjutan_opd'] : ''),
						'tindakan_lanjutan_kb'=>((isset($_POST['tindakan_lanjutan_kb'])) ? $_POST['tindakan_lanjutan_kb'] : ''),
						'tindakan_lanjutan_hd'=>((isset($_POST['tindakan_lanjutan_hd'])) ? $_POST['tindakan_lanjutan_hd'] : ''),
						'rujuk_ke_rs'=>((isset($_POST['rujuk_ke_rs'])) ? $_POST['rujuk_ke_rs'] : ''),
						'rujuk_ke_rs_nama'=>replace_quote($_POST['rujuk_ke_rs_nama']),
						'dipulangkan'=>((isset($_POST['dipulangkan'])) ? $_POST['dipulangkan'] : ''),
						'dipulangkan_pukul'=>replace_quote($_POST['dipulangkan_pukul']),
						'meninggal'=>((isset($_POST['meninggal'])) ? $_POST['meninggal'] : ''),
						'meninggal_pukul'=>replace_quote($_POST['meninggal_pukul']),
						'doa'=>((isset($_POST['doa'])) ? $_POST['doa'] : ''),
						'transportasi_pl'=>((isset($_POST['transportasi_pl'])) ? $_POST['transportasi_pl'] : ''),
						'pendidikan_pl_makan'=>((isset($_POST['pendidikan_pl_makan'])) ? $_POST['pendidikan_pl_makan'] : ''),
						'pendidikan_pl_diet'=>((isset($_POST['pendidikan_pl_diet'])) ? $_POST['pendidikan_pl_diet'] : ''),
						'pendidikan_pl_bersih'=>((isset($_POST['pendidikan_pl_bersih'])) ? $_POST['pendidikan_pl_bersih'] : ''),
						'pendidikan_pl_lain'=>((isset($_POST['pendidikan_pl_lain'])) ? $_POST['pendidikan_pl_lain'] : ''),
						'pendidikan_pl_lain_ket'=>replace_quote($_POST['pendidikan_pl_lain_ket']),
						'followup_ya'=>((isset($_POST['followup_ya'])) ? $_POST['followup_ya'] : ''),
						'followup_tgl'=>replace_quote($_POST['followup_tgl']),
						'poliklinik'=>replace_quote($_POST['poliklinik']),
						'followup_hsl'=>replace_quote($_POST['followup_hsl']));
		$followup = json_encode($followup);
		$followup = str_replace('"','|',$followup);
	
		if(empty($_POST['idx_pengkajian'])){		
			mysql_query('INSERT INTO t_igd_pengkajian_keperawatan (IRJA_ID,
				TRIASE,RIWAYAT_MASUK,RIWAYAT_PENYAKIT,GENERAL_IMPRESSION,TANDA_VITAL,RESIKO_PASIEN_JATUH,
				RESIKO_PASIEN_DEKUBITUS,STATUS_KEHAMILAN,PEMERIKSAAN_PENUNJANG,DIAGNOSA_KEPERAWATAN,
				RENCANA_KEPERAWATAN,INTERVENSI_KEPERAWATAN,IMPLEMENTASI_KEPERAWATAN,PEMBERIAN_INFUS_OBAT,
				EVALUASI_KEPERAWATAN,FOLLOWUP,SELESAI_PUKUL,TGL_ASSESMENT,PEGAWAI_ID,FINAL,REGISTER) 
				VALUES ("' . $_POST['irja_id'] . '","' . $triase . '","' . $riwayat_masuk . '",
				"' . $riwayat_penyakit . '","' . $general_impression . '","' . $tanda_vital . '",
				"' . $risiko_pasien_jatuh . '","' . $risiko_pasien_dekubitus . '","' . $status_kehamilan . '",
				"' . $pemeriksaan_penunjang . '","' . $diagnosa_keperawatan . '","' . $_POST['rencana_keperawatan'] . '",
				"' . $intervensi_keperawatan . '","' . $implementasi_keperawatan . '","' . $infus_obat . '",
				"' . $evaluasi_keperawatan . '","' . $followup . '",
				STR_TO_DATE("' . $_POST['jam_selesai'] . ':' . $_POST['menit_selesai'] . '","%H:%i"),
				NOW(),"' . $_SESSION['SES_SIMRS_PEGAWAI_ID'] . '",' . $st_final . ',"' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_igd_pengkajian_keperawatan 
				SET TRIASE = "' . $triase . '",
				SELESAI_PUKUL = STR_TO_DATE("' . $_POST['jam_selesai'] . ':' . $_POST['menit_selesai'] . '","%H:%i"),
				RIWAYAT_MASUK = "' . $riwayat_masuk . '",
				RIWAYAT_PENYAKIT = "' . $riwayat_penyakit . '",
				GENERAL_IMPRESSION = "' . $general_impression . '",
				TANDA_VITAL = "' . $tanda_vital . '",
				RESIKO_PASIEN_JATUH = "' . $risiko_pasien_jatuh . '",
				RESIKO_PASIEN_DEKUBITUS = "' . $risiko_pasien_dekubitus . '",
				STATUS_KEHAMILAN = "' . $status_kehamilan . '",
				PEMERIKSAAN_PENUNJANG = "' . $pemeriksaan_penunjang . '",
				DIAGNOSA_KEPERAWATAN = "' . $diagnosa_keperawatan . '",
				RENCANA_KEPERAWATAN = "' . $_POST['rencana_keperawatan'] . '",
				INTERVENSI_KEPERAWATAN = "' . $intervensi_keperawatan . '",
				IMPLEMENTASI_KEPERAWATAN = "' . $implementasi_keperawatan . '",
				PEMBERIAN_INFUS_OBAT = "' . $infus_obat . '",
				EVALUASI_KEPERAWATAN = "' . $evaluasi_keperawatan . '",
				FOLLOWUP = "' . $followup . '",
				TGL_ASSESMENT = NOW(),
				FINAL = ' . $st_final . ',
				REGISTER = "' . $_SESSION['SES_SIMRS_NAMA_PEGAWAI'] . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
	
		/*
		include('lib/vendor/autoload.php');
		include('lib/html2openxml/HTMLtoOpenXML.php');
		include('edoc_rekammedik/new/erm_create_pengkajian_keperawatan_gawat_darurat.php');
		erm_pengkajian_keperawatan_gawat_darurat($_POST['irja_id'],$_POST['ls_assesment'],$_POST['tgl_skr'],$_POST['ls_final']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pengkajian Keperawatan Gawat Darurat Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Perawat.';
	}	
}

$jam = date('H');
$menit = date('i');

$qry_pasien = 'SELECT IRJA_ID,
			DATE_FORMAT(SELESAI_PUKUL,"%H") AS JAM_SELESAI,
			DATE_FORMAT(SELESAI_PUKUL,"%i") AS MENIT_SELESAI,
			TRIASE,RIWAYAT_MASUK,RIWAYAT_PENYAKIT,GENERAL_IMPRESSION,TANDA_VITAL,
			RESIKO_PASIEN_JATUH,RESIKO_PASIEN_DEKUBITUS,STATUS_KEHAMILAN,
			PEMERIKSAAN_PENUNJANG,DIAGNOSA_KEPERAWATAN,RENCANA_KEPERAWATAN,
			INTERVENSI_KEPERAWATAN,IMPLEMENTASI_KEPERAWATAN,PEMBERIAN_INFUS_OBAT,
			EVALUASI_KEPERAWATAN,FOLLOWUP,
			FINAL,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
			DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR
			FROM t_igd_pengkajian_keperawatan
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx_pengkajian = $dat_pasien['IRJA_ID'];

$jam_selesai = $dat_pasien['JAM_SELESAI']; 
$menit_selesai = $dat_pasien['MENIT_SELESAI']; 

$triase = str_replace('|','"',$dat_pasien['TRIASE']);
$triase = preg_replace('/\r|\n/','\n',trim($triase));
$triase = json_decode($triase,true);

$riwayat_masuk = str_replace('|','"',$dat_pasien['RIWAYAT_MASUK']);
$riwayat_masuk = preg_replace('/\r|\n/','\n',trim($riwayat_masuk));
$riwayat_masuk = json_decode($riwayat_masuk,true);

$riwayat_penyakit = str_replace('|','"',$dat_pasien['RIWAYAT_PENYAKIT']);
$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
$riwayat_penyakit = json_decode($riwayat_penyakit,true);

$general_impression = str_replace('|','"',$dat_pasien['GENERAL_IMPRESSION']);
$general_impression = preg_replace('/\r|\n/','\n',trim($general_impression));
$general_impression = json_decode($general_impression,true);

$tanda_vital = str_replace('|','"',$dat_pasien['TANDA_VITAL']);
$tanda_vital = preg_replace('/\r|\n/','\n',trim($tanda_vital));
$tanda_vital = json_decode($tanda_vital,true);

$risiko_pasien_jatuh = str_replace('|','"',$dat_pasien['RESIKO_PASIEN_JATUH']);
$risiko_pasien_jatuh = preg_replace('/\r|\n/','\n',trim($risiko_pasien_jatuh));
$risiko_pasien_jatuh = json_decode($risiko_pasien_jatuh,true);

$risiko_pasien_dekubitus = str_replace('|','"',$dat_pasien['RESIKO_PASIEN_DEKUBITUS']);
$risiko_pasien_dekubitus = preg_replace('/\r|\n/','\n',trim($risiko_pasien_dekubitus));
$risiko_pasien_dekubitus = json_decode($risiko_pasien_dekubitus,true);

$status_kehamilan = str_replace('|','"',$dat_pasien['STATUS_KEHAMILAN']);
$status_kehamilan = preg_replace('/\r|\n/','\n',trim($status_kehamilan));
$status_kehamilan = json_decode($status_kehamilan,true);

$pemeriksaan_penunjang = str_replace('|','"',$dat_pasien['PEMERIKSAAN_PENUNJANG']);
$pemeriksaan_penunjang = preg_replace('/\r|\n/','\n',trim($pemeriksaan_penunjang));
$pemeriksaan_penunjang = json_decode($pemeriksaan_penunjang,true);

$diagnosa_keperawatan = str_replace('|','"',$dat_pasien['DIAGNOSA_KEPERAWATAN']);
$diagnosa_keperawatan = preg_replace('/\r|\n/','\n',trim($diagnosa_keperawatan));
$diagnosa_keperawatan = json_decode($diagnosa_keperawatan,true);

$rencana_keperawatan = $dat_pasien['RENCANA_KEPERAWATAN'];

$intervensi_keperawatan = str_replace('|','"',$dat_pasien['INTERVENSI_KEPERAWATAN']);
$intervensi_keperawatan = preg_replace('/\r|\n/','\n',trim($intervensi_keperawatan));
$intervensi_keperawatan = json_decode($intervensi_keperawatan,true);

$implementasi_keperawatan = str_replace('|','"',$dat_pasien['IMPLEMENTASI_KEPERAWATAN']);
$implementasi_keperawatan = preg_replace('/\r|\n/','\n',trim($implementasi_keperawatan));
$implementasi_keperawatan = json_decode($implementasi_keperawatan,true);

$infus_obat = str_replace('|','"',$dat_pasien['PEMBERIAN_INFUS_OBAT']);
$infus_obat = preg_replace('/\r|\n/','\n',trim($infus_obat));
$infus_obat = json_decode($infus_obat,true);

$evaluasi_keperawatan = str_replace('|','"',$dat_pasien['EVALUASI_KEPERAWATAN']);
$evaluasi_keperawatan = preg_replace('/\r|\n/','\n',trim($evaluasi_keperawatan));
$evaluasi_keperawatan = json_decode($evaluasi_keperawatan,true);

$followup = str_replace('|','"',$dat_pasien['FOLLOWUP']);
$followup = preg_replace('/\r|\n/','\n',trim($followup));
$followup = json_decode($followup,true);

$final = $dat_pasien['FINAL'];
$tgl_assesment = $dat_pasien['TGL_ASSESMENT'];
$tgl_skr = $dat_pasien['TGL_SKR'];
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx_pengkajian" id="idx_pengkajian" value="<?php echo $idx_pengkajian; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<input type="hidden" name="ls_assesment" id="ls_assesment" value="<?php echo $tgl_assesment; ?>" />	
	<input type="hidden" name="ls_final" id="ls_final" value="<?php echo $final; ?>" />	
	<input type="hidden" name="tgl_skr" id="tgl_skr" value="<?php echo $tgl_skr; ?>" />
	<table border="0" align="center" style="position:static; " width="90%">
        <tr>
			<td valign="top" width="220px" colspan="2">Triage</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5">
				<input type="checkbox" name="triage_emergency" value="1" 
				<?php echo ((isset($triase['triage_emergency']) and $triase['triage_emergency'] == '1') ? 'checked' : ''); ?> />Emergency
				<input type="checkbox" name="triage_urgent" value="1" 
				<?php echo ((isset($triase['triage_urgent']) and $triase['triage_urgent'] == '1') ? 'checked' : ''); ?> />Urgent
				<input type="checkbox" name="triage_non_urgent" value="1" 
				<?php echo ((isset($triase['triage_non_urgent']) and $triase['triage_non_urgent'] == '1') ? 'checked' : ''); ?> />Non Urgent
				<input type="checkbox" name="triage_false_emergency" value="1" 
				<?php echo ((isset($triase['triage_false_emergency']) and $triase['triage_false_emergency'] == '1') ? 'checked' : ''); ?> />False Emergency
				<input type="checkbox" name="triage_doa" value="1" 
				<?php echo ((isset($triase['triage_doa']) and $triase['triage_doa'] == '1') ? 'checked' : ''); ?> />D.O.A
			</td>
		</tr>	
		<tr>
			<td valign="top" width="220px" colspan="2">Selesai pukul</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><select name="jam_selesai" id="jam_selesai" style="width:50px;" class="text_dt" >
			<?php echo getJam((($jam_selesai != '') ? $jam_selesai : $jam)); ?>
			</select>
			<select name="menit_selesai" id="menit_selesai" style="width:50px;" class="text_dt" >
			<?php echo getMenit((($menit_selesai != '') ? $menit_selesai : $menit)); ?>
			</select></td>
		</tr>
		<tr>
			<td valign="top" width="220px" colspan="2">Informasi didapat dari</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5">
				<input type="radio" name="informasi_dapat" value="1" 
				<?php echo ((isset($riwayat_masuk['informasi_dapat']) and $riwayat_masuk['informasi_dapat'] == '1') ? 'checked' : ''); ?> />Autoanamnesa
				
			</td>
		</tr>
		<tr>
			<td valign="top" width="220px" colspan="2">&nbsp;</td>
			<td valign="top" width="10px">&nbsp;</td>
			<td colspan="5">
				<input type="radio" name="informasi_dapat" value="2" 
				<?php echo ((isset($riwayat_masuk['informasi_dapat']) and $riwayat_masuk['informasi_dapat'] == '2') ? 'checked' : ''); ?> />Heteroanamnesa
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Nama : <input type="text" name="anamnesa_nama" value="<?php echo ((isset($riwayat_masuk['anamnesa_nama'])) ? $riwayat_masuk['anamnesa_nama'] : ''); ?>" class="text_dt" >
				Hubungan : <input type="text" name="anamnesa_hubungan" value="<?php echo ((isset($riwayat_masuk['anamnesa_hubungan'])) ? $riwayat_masuk['anamnesa_hubungan'] : ''); ?>" class="text_dt" >
			</td>
		</tr>
		<tr>
			<td valign="top" width="220px" colspan="2">Cara Masuk</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5">
				<input type="radio" name="cara_masuk" value="1" 
				<?php echo ((isset($riwayat_masuk['cara_masuk']) and $riwayat_masuk['cara_masuk'] == '1') ? 'checked' : ''); ?> />Jalan tanpa bantuan
				<input type="radio" name="cara_masuk" value="2" 
				<?php echo ((isset($riwayat_masuk['cara_masuk']) and $riwayat_masuk['cara_masuk'] == '2') ? 'checked' : ''); ?> />Jalan dengan bantuan
				<input type="radio" name="cara_masuk" value="3" 
				<?php echo ((isset($riwayat_masuk['cara_masuk']) and $riwayat_masuk['cara_masuk'] == '3') ? 'checked' : ''); ?> />Kursi roda
				<input type="radio" name="cara_masuk" value="4" 
				<?php echo ((isset($riwayat_masuk['cara_masuk']) and $riwayat_masuk['cara_masuk'] == '4') ? 'checked' : ''); ?> />Tempat tidur dorong
			</td>
		</tr>
		<tr>
			<td valign="top" width="220px" colspan="2">Asal Masuk</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5">
				<input type="radio" name="asal_masuk" value="1" 
				<?php echo ((isset($riwayat_masuk['asal_masuk']) and $riwayat_masuk['asal_masuk'] == '1') ? 'checked' : ''); ?> />Non rujukan
				<input type="radio" name="asal_masuk" value="2" 
				<?php echo ((isset($riwayat_masuk['asal_masuk']) and $riwayat_masuk['asal_masuk'] == '2') ? 'checked' : ''); ?> />Rujukan
			</td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td width="40px" colspan="2" valign="top">Riwayat Penyakit Sekarang</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="sekarang" id="sekarang" class="text_dt2"><?php echo ((isset($riwayat_penyakit['sekarang'])) ? $riwayat_penyakit['sekarang'] : ''); ?></textarea></td>
		</tr>	
		<tr>
			<td width="40px" colspan="2" valign="top">Tinggi Badan/ Berat Badan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><input type="text" name="rp_tb" id="rp_tb" class="text_dt" 
				value="<?php echo ((isset($riwayat_penyakit['rp_tb'])) ? $riwayat_penyakit['rp_tb'] : ''); ?>" /> cm
				<input type="text" name="rp_bb" id="rp_bb" class="text_dt" 
				value="<?php echo ((isset($riwayat_penyakit['rp_bb'])) ? $riwayat_penyakit['rp_bb'] : ''); ?>" /> kg
				</td>
		</tr>
		<tr>
			<td width="40px" colspan="2" valign="top">Riwayat Penyakit Dahulu</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="dahulu" id="dahulu" class="text_dt2"><?php echo ((isset($riwayat_penyakit['dahulu'])) ? $riwayat_penyakit['dahulu'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td width="40px" colspan="2" valign="top">Riwayat Pengobatan</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="pengobatan" id="pengobatan" class="text_dt2"><?php echo ((isset($riwayat_penyakit['pengobatan'])) ? $riwayat_penyakit['pengobatan'] : ''); ?></textarea></td>
		</tr>
		<tr>
            <td valign="top" colspan="2">General Impression</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Keluhan Utama</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="keluhan_utama" class="text_dt2" ><?php echo ((isset($general_impression['keluhan_utama'])) ? $general_impression['keluhan_utama'] : ''); ?></textarea></td>
		</tr>
			<tr>
			<td>&nbsp;</td>
			<td valign="top">Mekanisme Cedera</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="mekanisme_cedera" class="text_dt2" ><?php echo ((isset($general_impression['mekanisme_cedera'])) ? $general_impression['mekanisme_cedera'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Orientasi (Tempat, Waktu dan Orang)</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="orientasi" value="1" class="text_dt" <?php echo ((isset($general_impression['orientasi']) and $general_impression['orientasi']=='1') ? 'checked' : ''); ?>>&nbsp;Baik
				&nbsp;<input type="radio" name="orientasi" value="2" class="text_dt" <?php echo ((isset($general_impression['orientasi']) and $general_impression['orientasi']=='2') ? 'checked' : ''); ?>>&nbsp;Tidak Baik</td>
		</tr>
		<tr>
			<td colspan="8">Tanda-tanda Vital</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>GCS</td>
			<td>:</td>
			<td colspan="2">E&nbsp;<input type="text" name="gcs_e" value="<?php echo ((isset($tanda_vital['gcs_e'])) ? $tanda_vital['gcs_e'] : ''); ?>" class="text_dt" style="width:80px;" >
			M&nbsp;<input type="text" name="gcs_m" value="<?php echo ((isset($tanda_vital['gcs_m'])) ? $tanda_vital['gcs_m'] : ''); ?>" class="text_dt" style="width:80px;" >
			V&nbsp;<input type="text" name="gcs_v" value="<?php echo ((isset($tanda_vital['gcs_v'])) ? $tanda_vital['gcs_v'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
			<td width="95px">SpO</td>
			<td width="10px">:</td>
			<td width="200px"><input type="text" name="spo" value="<?php echo ((isset($tanda_vital['spo'])) ? $tanda_vital['spo'] : ''); ?>" class="text_dt" >&nbsp;%</td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="200px"><input type="text" name="td" value="<?php echo ((isset($tanda_vital['td'])) ? $tanda_vital['td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">Reflex Cahaya</td>
			<td>:</td>
			<td><input type="text" name="reflex_cahaya_l" value="<?php echo ((isset($tanda_vital['reflex_cahaya_l'])) ? $tanda_vital['reflex_cahaya_l'] : ''); ?>" class="text_dt" style="width:80px;" >/
			<input type="text" name="reflex_cahaya_r" value="<?php echo ((isset($tanda_vital['reflex_cahaya_r'])) ? $tanda_vital['reflex_cahaya_r'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Pernafasan</td>
			<td>:</td>
			<td><input type="text" name="nafas" value="<?php echo ((isset($tanda_vital['nafas'])) ? $tanda_vital['nafas'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="suhu" value="<?php echo ((isset($tanda_vital['suhu'])) ? $tanda_vital['suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Nadi</td>
			<td>:</td>
			<td><input type="text" name="nadi" value="<?php echo ((isset($tanda_vital['nadi'])) ? $tanda_vital['nadi'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td width="150px">
			<input type="radio" name="nadi_reguler" value="1" 
				<?php echo ((isset($tanda_vital['nadi_reguler']) and $tanda_vital['nadi_reguler'] == '1') ? 'checked' : ''); ?> />Reguler
			<input type="radio" name="nadi_reguler" value="2" 
				<?php echo ((isset($tanda_vital['nadi_reguler']) and $tanda_vital['nadi_reguler'] == '2') ? 'checked' : ''); ?> />Ireguler
			</td>
			<td>Akral</td>
			<td>:</td>
			<td><input type="text" name="akral" value="<?php echo ((isset($tanda_vital['akral'])) ? $tanda_vital['akral'] : ''); ?>" class="text_dt" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Respon</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="respon" value="1" 
				<?php echo ((isset($tanda_vital['respon']) and $tanda_vital['respon'] == '1') ? 'checked' : ''); ?> />Alert
				<input type="radio" name="respon" value="2" 
				<?php echo ((isset($tanda_vital['respon']) and $tanda_vital['respon'] == '2') ? 'checked' : ''); ?> />Verbal
				<input type="radio" name="respon" value="3" 
				<?php echo ((isset($tanda_vital['respon']) and $tanda_vital['respon'] == '3') ? 'checked' : ''); ?> />Unrespon
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Kesadaran</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="kesadaran" value="1" 
				<?php echo ((isset($tanda_vital['kesadaran']) and $tanda_vital['kesadaran'] == '1') ? 'checked' : ''); ?> />CM
				<input type="radio" name="kesadaran" value="2" 
				<?php echo ((isset($tanda_vital['kesadaran']) and $tanda_vital['kesadaran'] == '2') ? 'checked' : ''); ?> />Delirium
				<input type="radio" name="kesadaran" value="3" 
				<?php echo ((isset($tanda_vital['kesadaran']) and $tanda_vital['kesadaran'] == '3') ? 'checked' : ''); ?> />Sommolen
				<input type="radio" name="kesadaran" value="4" 
				<?php echo ((isset($tanda_vital['kesadaran']) and $tanda_vital['kesadaran'] == '4') ? 'checked' : ''); ?> />Sopor Coma
				<input type="radio" name="kesadaran" value="5" 
				<?php echo ((isset($tanda_vital['kesadaran']) and $tanda_vital['kesadaran'] == '5') ? 'checked' : ''); ?> />Coma
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">GCS</td>
			<td valign="top">:</td>
			<td colspan="5">Eye&nbsp;<input type="text" name="gcs_e2" value="<?php echo ((isset($tanda_vital['gcs_e2'])) ? $tanda_vital['gcs_e2'] : ''); ?>" class="text_dt" style="width:80px;" >
			Motorik&nbsp;<input type="text" name="gcs_m2" value="<?php echo ((isset($tanda_vital['gcs_m2'])) ? $tanda_vital['gcs_m2'] : ''); ?>" class="text_dt" style="width:80px;" >
			Verbal&nbsp;<input type="text" name="gcs_v2" value="<?php echo ((isset($tanda_vital['gcs_v2'])) ? $tanda_vital['gcs_v2'] : ''); ?>" class="text_dt" style="width:80px;" >
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pupil</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="pupil" value="1" 
				<?php echo ((isset($tanda_vital['pupil']) and $tanda_vital['pupil'] == '1') ? 'checked' : ''); ?> />Isokor
				<input type="radio" name="pupil" value="2" 
				<?php echo ((isset($tanda_vital['pupil']) and $tanda_vital['pupil'] == '2') ? 'checked' : ''); ?> />Unisokor
				<input type="radio" name="pupil" value="3" 
				<?php echo ((isset($tanda_vital['pupil']) and $tanda_vital['pupil'] == '3') ? 'checked' : ''); ?> />Pinpoin
				<input type="radio" name="pupil" value="4" 
				<?php echo ((isset($tanda_vital['pupil']) and $tanda_vital['pupil'] == '4') ? 'checked' : ''); ?> />
				<input type="text" name="pupil_ket" value="<?php echo ((isset($tanda_vital['pupil_ket'])) ? $tanda_vital['pupil_ket'] : ''); ?>" class="text_dt" >
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Reflex Cahaya</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="reflex_cahaya" value="1" 
				<?php echo ((isset($tanda_vital['reflex_cahaya']) and $tanda_vital['reflex_cahaya'] == '1') ? 'checked' : ''); ?> />Ada
				<input type="radio" name="reflex_cahaya" value="2" 
				<?php echo ((isset($tanda_vital['reflex_cahaya']) and $tanda_vital['reflex_cahaya'] == '2') ? 'checked' : ''); ?> />Tidak ada
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">CRT</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="crt" value="1" 
				<?php echo ((isset($tanda_vital['crt']) and $tanda_vital['crt'] == '1') ? 'checked' : ''); ?> />< 2 detik
				<input type="radio" name="crt" value="2" 
				<?php echo ((isset($tanda_vital['crt']) and $tanda_vital['crt'] == '2') ? 'checked' : ''); ?> />> 2 detik
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Sianosis</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="sianosis" value="1" 
				<?php echo ((isset($tanda_vital['sianosis']) and $tanda_vital['sianosis'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="sianosis" value="2" 
				<?php echo ((isset($tanda_vital['sianosis']) and $tanda_vital['sianosis'] == '2') ? 'checked' : ''); ?> />Tidak
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Nadi</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="nadi_teraba" value="1" 
				<?php echo ((isset($tanda_vital['nadi_teraba']) and $tanda_vital['nadi_teraba'] == '1') ? 'checked' : ''); ?> />Teraba
				<input type="radio" name="nadi_teraba" value="2" 
				<?php echo ((isset($tanda_vital['nadi_teraba']) and $tanda_vital['nadi_teraba'] == '2') ? 'checked' : ''); ?> />Tidak teraba
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Sesak Nafas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="sesak_nafas" value="1" 
				<?php echo ((isset($tanda_vital['sesak_nafas']) and $tanda_vital['sesak_nafas'] == '1') ? 'checked' : ''); ?> />Ada
				<input type="radio" name="sesak_nafas" value="2" 
				<?php echo ((isset($tanda_vital['sesak_nafas']) and $tanda_vital['sesak_nafas'] == '2') ? 'checked' : ''); ?> />N/A
				<input type="radio" name="sesak_nafas" value="3" 
				<?php echo ((isset($tanda_vital['sesak_nafas']) and $tanda_vital['sesak_nafas'] == '3') ? 'checked' : ''); ?> />RR
				<input type="text" name="sesak_nafas_ket" value="<?php echo ((isset($tanda_vital['sesak_nafas_ket'])) ? $tanda_vital['sesak_nafas_ket'] : ''); ?>" class="text_dt" >x/menit
			</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Jalan Nafas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="jalan_nafas" value="1" 
				<?php echo ((isset($tanda_vital['jalan_nafas']) and $tanda_vital['jalan_nafas'] == '1') ? 'checked' : ''); ?> />Paten
				<input type="radio" name="jalan_nafas" value="2" 
				<?php echo ((isset($tanda_vital['jalan_nafas']) and $tanda_vital['jalan_nafas'] == '2') ? 'checked' : ''); ?> />Tidak paten
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Obstruksi</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="obstruksi" value="1" 
				<?php echo ((isset($tanda_vital['obstruksi']) and $tanda_vital['obstruksi'] == '1') ? 'checked' : ''); ?> />Lidah
				<input type="radio" name="obstruksi" value="2" 
				<?php echo ((isset($tanda_vital['obstruksi']) and $tanda_vital['obstruksi'] == '2') ? 'checked' : ''); ?> />Cairan
				<input type="radio" name="obstruksi" value="3" 
				<?php echo ((isset($tanda_vital['obstruksi']) and $tanda_vital['obstruksi'] == '3') ? 'checked' : ''); ?> />Benda asing
				<input type="radio" name="obstruksi" value="4" 
				<?php echo ((isset($tanda_vital['obstruksi']) and $tanda_vital['obstruksi'] == '4') ? 'checked' : ''); ?> />N/A
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Suara Nafas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="suara_nafas" value="1" 
				<?php echo ((isset($tanda_vital['suara_nafas']) and $tanda_vital['suara_nafas'] == '1') ? 'checked' : ''); ?> />Snoring
				<input type="radio" name="suara_nafas" value="2" 
				<?php echo ((isset($tanda_vital['suara_nafas']) and $tanda_vital['suara_nafas'] == '2') ? 'checked' : ''); ?> />Gurgling
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Gerakan Dada</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="gerakan_dada" value="1" 
				<?php echo ((isset($tanda_vital['gerakan_dada']) and $tanda_vital['gerakan_dada'] == '1') ? 'checked' : ''); ?> />Simetris
				<input type="radio" name="gerakan_dada" value="2" 
				<?php echo ((isset($tanda_vital['gerakan_dada']) and $tanda_vital['gerakan_dada'] == '2') ? 'checked' : ''); ?> />Asimetris
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Irama Nafas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="irama_nafas" value="1" 
				<?php echo ((isset($tanda_vital['irama_nafas']) and $tanda_vital['irama_nafas'] == '1') ? 'checked' : ''); ?> />Cepat
				<input type="radio" name="irama_nafas" value="2" 
				<?php echo ((isset($tanda_vital['irama_nafas']) and $tanda_vital['irama_nafas'] == '2') ? 'checked' : ''); ?> />Dangkal
				<input type="radio" name="irama_nafas" value="3" 
				<?php echo ((isset($tanda_vital['irama_nafas']) and $tanda_vital['irama_nafas'] == '3') ? 'checked' : ''); ?> />Normal
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pola Nafas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="pola_nafas" value="1" 
				<?php echo ((isset($tanda_vital['pola_nafas']) and $tanda_vital['pola_nafas'] == '1') ? 'checked' : ''); ?> />Teratur
				<input type="radio" name="pola_nafas" value="2" 
				<?php echo ((isset($tanda_vital['pola_nafas']) and $tanda_vital['pola_nafas'] == '2') ? 'checked' : ''); ?> />Tidak teratur
				</td>
		</tr>
			<tr>
            <td valign="top" colspan="2" width="200px;">Retraksi Otot Dada</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="retraksi_otot" value="1" 
				<?php echo ((isset($tanda_vital['retraksi_otot']) and $tanda_vital['retraksi_otot'] == '1') ? 'checked' : ''); ?> />Ada
				<input type="radio" name="retraksi_otot" value="2" 
				<?php echo ((isset($tanda_vital['retraksi_otot']) and $tanda_vital['retraksi_otot'] == '2') ? 'checked' : ''); ?> />N/A
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pendarahan</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="pendarahan" value="1" 
				<?php echo ((isset($tanda_vital['pendarahan']) and $tanda_vital['pendarahan'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pendarahan" value="2" 
				<?php echo ((isset($tanda_vital['pendarahan']) and $tanda_vital['pendarahan'] == '2') ? 'checked' : ''); ?> />Tidak ada
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Deformitas</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="deformitas" value="1" 
				<?php echo ((isset($tanda_vital['deformitas']) and $tanda_vital['deformitas'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="deformitas" value="2" 
				<?php echo ((isset($tanda_vital['deformitas']) and $tanda_vital['deformitas'] == '2') ? 'checked' : ''); ?> />Tidak
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Contusio</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="contusio" value="1" 
				<?php echo ((isset($tanda_vital['contusio']) and $tanda_vital['contusio'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="contusio" value="2" 
				<?php echo ((isset($tanda_vital['contusio']) and $tanda_vital['contusio'] == '2') ? 'checked' : ''); ?> />Tidak
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Abrasi</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="abrasi" value="1" 
				<?php echo ((isset($tanda_vital['abrasi']) and $tanda_vital['abrasi'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="abrasi" value="2" 
				<?php echo ((isset($tanda_vital['abrasi']) and $tanda_vital['abrasi'] == '2') ? 'checked' : ''); ?> />Tidak
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Penetrasi</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="penetrasi" value="1" 
				<?php echo ((isset($tanda_vital['penetrasi']) and $tanda_vital['penetrasi'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="penetrasi" value="2" 
				<?php echo ((isset($tanda_vital['penetrasi']) and $tanda_vital['penetrasi'] == '2') ? 'checked' : ''); ?> />Tidak
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Leserasi</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="leserasi" value="1" 
				<?php echo ((isset($tanda_vital['leserasi']) and $tanda_vital['leserasi'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="leserasi" value="2" 
				<?php echo ((isset($tanda_vital['leserasi']) and $tanda_vital['leserasi'] == '2') ? 'checked' : ''); ?> />Tidak
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Edema</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="edema" value="1" 
				<?php echo ((isset($tanda_vital['edema']) and $tanda_vital['edema'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="edema" value="2" 
				<?php echo ((isset($tanda_vital['edema']) and $tanda_vital['edema'] == '2') ? 'checked' : ''); ?> />Tidak
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Kejang</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="kejang" value="1" 
				<?php echo ((isset($tanda_vital['kejang']) and $tanda_vital['kejang'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="kejang" value="2" 
				<?php echo ((isset($tanda_vital['kejang']) and $tanda_vital['kejang'] == '2') ? 'checked' : ''); ?> />Tidak
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Lama Kejang</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="lama_kejang" value="<?php echo ((isset($tanda_vital['lama_kejang'])) ? $tanda_vital['lama_kejang'] : ''); ?>" class="text_dt" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Skala Nyeri</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="skala_nyeri" value="<?php echo ((isset($tanda_vital['skala_nyeri'])) ? $tanda_vital['skala_nyeri'] : ''); ?>" class="text_dt" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Frekuensi Nyeri</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="frekuensi_nyeri" value="1" 
				<?php echo ((isset($tanda_vital['frekuensi_nyeri']) and $tanda_vital['frekuensi_nyeri'] == '1') ? 'checked' : ''); ?> />Jarang
				<input type="radio" name="frekuensi_nyeri" value="2" 
				<?php echo ((isset($tanda_vital['frekuensi_nyeri']) and $tanda_vital['frekuensi_nyeri'] == '2') ? 'checked' : ''); ?> />Hilang timbul
				<input type="radio" name="frekuensi_nyeri" value="3" 
				<?php echo ((isset($tanda_vital['frekuensi_nyeri']) and $tanda_vital['frekuensi_nyeri'] == '3') ? 'checked' : ''); ?> />Terus menerus
				
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Lama Nyeri</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="lama_nyeri" value="<?php echo ((isset($tanda_vital['lama_nyeri'])) ? $tanda_vital['lama_nyeri'] : ''); ?>" class="text_dt" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Menjalar</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="nyeri_menjalar" value="1" 
				<?php echo ((isset($tanda_vital['nyeri_menjalar']) and $tanda_vital['nyeri_menjalar'] == '1') ? 'checked' : ''); ?> />Tidak
				<input type="radio" name="nyeri_menjalar" value="2" 
				<?php echo ((isset($tanda_vital['nyeri_menjalar']) and $tanda_vital['nyeri_menjalar'] == '2') ? 'checked' : ''); ?> />Ya
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Kualitas Nyeri</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="kualitas_nyeri" value="1" 
				<?php echo ((isset($tanda_vital['kualitas_nyeri']) and $tanda_vital['kualitas_nyeri'] == '1') ? 'checked' : ''); ?> />Nyeri tumpul
				<input type="radio" name="kualitas_nyeri" value="2" 
				<?php echo ((isset($tanda_vital['kualitas_nyeri']) and $tanda_vital['kualitas_nyeri'] == '2') ? 'checked' : ''); ?> />Nyeri tajam
				<input type="radio" name="kualitas_nyeri" value="3" 
				<?php echo ((isset($tanda_vital['kualitas_nyeri']) and $tanda_vital['kualitas_nyeri'] == '3') ? 'checked' : ''); ?> />Panas/ terbakar
				</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Faktor Pemicu</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="pemicu_nyeri" value="<?php echo ((isset($tanda_vital['pemicu_nyeri'])) ? $tanda_vital['pemicu_nyeri'] : ''); ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Faktor Pengurang/ Penghilang Nyeri</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="pengurang_nyeri" value="<?php echo ((isset($tanda_vital['pengurang_nyeri'])) ? $tanda_vital['pengurang_nyeri'] : ''); ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Pengkajian Fungsi - Aktifitas Sehari-hari</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="pengkajian_fungsi" value="1" 
				<?php echo ((isset($tanda_vital['pengkajian_fungsi']) and $tanda_vital['pengkajian_fungsi'] == '1') ? 'checked' : ''); ?> />Mandiri
				<input type="radio" name="pengkajian_fungsi" value="2" 
				<?php echo ((isset($tanda_vital['pengkajian_fungsi']) and $tanda_vital['pengkajian_fungsi'] == '2') ? 'checked' : ''); ?> />Dengan bantuan</td>
		</tr>
		<tr>
            <td valign="top" colspan="2" width="200px;">Keluhan Tambahan</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="keluhan_tambahan" class="text_dt11" style="width:500px;" ><?php echo ((isset($tanda_vital['keluhan_tambahan'])) ? $tanda_vital['keluhan_tambahan'] : ''); ?></textarea></td>
		</tr>
		<tr>
            <td colspan="8">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top" colspan="2">Pengkajian Risiko Pasien Jatuh</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah pernah jatuh dalam 3 bulan terakhir</td>
			<td colspan="2"><input type="radio" name="pasien_jatuh_1" value="1" 
				<?php echo ((isset($risiko_pasien_jatuh['pasien_jatuh_1']) and $risiko_pasien_jatuh['pasien_jatuh_1'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_jatuh_1" value="2" 
				<?php echo ((isset($risiko_pasien_jatuh['pasien_jatuh_1']) and $risiko_pasien_jatuh['pasien_jatuh_1'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah menggunakan alat bantu? (Alat bantu jalan, tongkat, dll)</td>
			<td colspan="2"><input type="radio" name="pasien_jatuh_2" value="1" 
				<?php echo ((isset($risiko_pasien_jatuh['pasien_jatuh_2']) and $risiko_pasien_jatuh['pasien_jatuh_2'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_jatuh_2" value="2" 
				<?php echo ((isset($risiko_pasien_jatuh['pasien_jatuh_2']) and $risiko_pasien_jatuh['pasien_jatuh_2'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah ada kesulitan berjalan?</td>
			<td colspan="2"><input type="radio" name="pasien_jatuh_3" value="1" 
				<?php echo ((isset($risiko_pasien_jatuh['pasien_jatuh_3']) and $risiko_pasien_jatuh['pasien_jatuh_3'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_jatuh_3" value="2" 
				<?php echo ((isset($risiko_pasien_jatuh['pasien_jatuh_3']) and $risiko_pasien_jatuh['pasien_jatuh_3'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7">Apabila salah satu jawaban adalah "Ya", maka lakukan intervensi Pasien Risiko Jatuh dibawah ini :</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7"><input type="checkbox" name="intervensi_pasien_jatuh_1" value="1" 
				<?php echo ((isset($risiko_pasien_jatuh['intervensi_pasien_jatuh_1']) and $risiko_pasien_jatuh['intervensi_pasien_jatuh_1'] == '1') ? 'checked' : ''); ?> />Pasang pagar pengaman dan kunci roda tempat tidur</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7"><input type="checkbox" name="intervensi_pasien_jatuh_2" value="1" 
				<?php echo ((isset($risiko_pasien_jatuh['intervensi_pasien_jatuh_2']) and $risiko_pasien_jatuh['intervensi_pasien_jatuh_2'] == '1') ? 'checked' : ''); ?> />Edukasi pencegahan pasien risiko jatuh</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7"><input type="checkbox" name="intervensi_pasien_jatuh_3" value="1" 
				<?php echo ((isset($risiko_pasien_jatuh['intervensi_pasien_jatuh_3']) and $risiko_pasien_jatuh['intervensi_pasien_jatuh_3'] == '1') ? 'checked' : ''); ?> />Pasang sign clip "Fall Risk" pada gelang identitas pasien (untuk pasien rawat inap)</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		  <tr>
            <td valign="top" colspan="2">Pengkajian Risiko Pasien Dekubitus</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah pasien menggunakan kursi roda atau membutuhkan bantuan ?</td>
			<td colspan="2"><input type="radio" name="pasien_dekubitus_1" value="1" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_1']) and $risiko_pasien_dekubitus['pasien_dekubitus_1'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_dekubitus_1" value="2" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_1']) and $risiko_pasien_dekubitus['pasien_dekubitus_1'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah ada inkontinensia uri atau alvi ?</td>
			<td colspan="2"><input type="radio" name="pasien_dekubitus_2" value="1" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_2']) and $risiko_pasien_dekubitus['pasien_dekubitus_2'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_dekubitus_2" value="2" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_2']) and $risiko_pasien_dekubitus['pasien_dekubitus_2'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah ada riwayat dekubitus atau luka dekubitus ?</td>
			<td colspan="2"><input type="radio" name="pasien_dekubitus_3" value="1" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_3']) and $risiko_pasien_dekubitus['pasien_dekubitus_3'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_dekubitus_3" value="2" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_3']) and $risiko_pasien_dekubitus['pasien_dekubitus_3'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah pasien diatas 65 tahun ?</td>
			<td colspan="2"><input type="radio" name="pasien_dekubitus_4" value="1" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_4']) and $risiko_pasien_dekubitus['pasien_dekubitus_4'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_dekubitus_4" value="2" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_4']) and $risiko_pasien_dekubitus['pasien_dekubitus_4'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Khusus Anak</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5">Apakah extrimitas dan badan tidak sesuai dengan usia perkembangan ?</td>
			<td colspan="2"><input type="radio" name="pasien_dekubitus_5" value="1" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_5']) and $risiko_pasien_dekubitus['pasien_dekubitus_5'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="pasien_dekubitus_5" value="2" 
				<?php echo ((isset($risiko_pasien_dekubitus['pasien_dekubitus_5']) and $risiko_pasien_dekubitus['pasien_dekubitus_5'] == '2') ? 'checked' : ''); ?> />Tidak</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7">Apabila salah satu jawaban adalah "Ya", maka lakukan edukasi pencegahan dekubitus</td>
		</tr>
			<tr>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		  <tr>
            <td valign="top" colspan="2">Status Kehamilan</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="5"><input type="radio" name="hamil" value="1" 
				<?php echo ((isset($status_kehamilan['hamil']) and $status_kehamilan['hamil'] == '1') ? 'checked' : ''); ?> />Tidak hamil
				<input type="radio" name="hamil" value="2" 
				<?php echo ((isset($status_kehamilan['hamil']) and $status_kehamilan['hamil'] == '2') ? 'checked' : ''); ?> />Hamil</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Gravida</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="gravida" value="<?php echo ((isset($status_kehamilan['gravida'])) ? $status_kehamilan['gravida'] : ''); ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>HPHT</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="hpht" value="<?php echo ((isset($status_kehamilan['hpht'])) ? $status_kehamilan['hpht'] : ''); ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Para</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="para" value="<?php echo ((isset($status_kehamilan['para'])) ? $status_kehamilan['para'] : ''); ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>Abortus</td>
			<td>:</td>
			<td colspan="5"><input type="text" name="abortus" value="<?php echo ((isset($status_kehamilan['abortus'])) ? $status_kehamilan['abortus'] : ''); ?>" class="text_dt" style="width:500px;" ></td>
		</tr>
				<tr>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
            <td valign="top" colspan="2">Pemeriksan Penunjang</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="radiologi" value="1" 
				<?php echo ((isset($pemeriksaan_penunjang['radiologi']) and $pemeriksaan_penunjang['radiologi'] == '1') ? 'checked' : ''); ?> />Radiologi</td>
			<td>:</td>
			<td colspan="5"><input type="checkbox" name="radiologi_1" value="1" 
				<?php echo ((isset($pemeriksaan_penunjang['radiologi_1']) and $pemeriksaan_penunjang['radiologi_1'] == '1') ? 'checked' : ''); ?> />Thorax PA/AP
				<input type="checkbox" name="radiologi_2" value="1" 
				<?php echo ((isset($pemeriksaan_penunjang['radiologi_2']) and $pemeriksaan_penunjang['radiologi_2'] == '1') ? 'checked' : ''); ?> />Pelvis AP</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="laboratorium" value="1" 
				<?php echo ((isset($pemeriksaan_penunjang['laboratorium']) and $pemeriksaan_penunjang['laboratorium'] == '1') ? 'checked' : ''); ?> />Laboratorium</td>
			<td></td>
			<td colspan="5"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="usg" value="1" 
				<?php echo ((isset($pemeriksaan_penunjang['usg']) and $pemeriksaan_penunjang['usg'] == '1') ? 'checked' : ''); ?> />USG
				<input type="checkbox" name="ekg" value="1" 
				<?php echo ((isset($pemeriksaan_penunjang['ekg']) and $pemeriksaan_penunjang['ekg'] == '1') ? 'checked' : ''); ?> />EKG</td>
			<td></td>
			<td colspan="5"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="lain_lain" value="1" 
				<?php echo ((isset($pemeriksaan_penunjang['lain_lain']) and $pemeriksaan_penunjang['lain_lain'] == '1') ? 'checked' : ''); ?> />Lain-lain
				</td>
			<td></td>
			<td colspan="5"></td>
		</tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Diagnosa Keperawatan</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_1" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_1']) and $diagnosa_keperawatan['diagkep_1'] == '1') ? 'checked' : ''); ?> />Inefektif airway</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="diagkep_2" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_2']) and $diagnosa_keperawatan['diagkep_2'] == '1') ? 'checked' : ''); ?> />Kerusakan integritas jaringan</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_3" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_3']) and $diagnosa_keperawatan['diagkep_3'] == '1') ? 'checked' : ''); ?> />Inefektif pola nafas</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="diagkep_4" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_4']) and $diagnosa_keperawatan['diagkep_4'] == '1') ? 'checked' : ''); ?> />Kerusakan mobilitas fisik</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_5" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_5']) and $diagnosa_keperawatan['diagkep_5'] == '1') ? 'checked' : ''); ?> />Kerusakan pertukaran gas</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="diagkep_6" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_6']) and $diagnosa_keperawatan['diagkep_6'] == '1') ? 'checked' : ''); ?> />Nyeri</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_7" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_7']) and $diagnosa_keperawatan['diagkep_7'] == '1') ? 'checked' : ''); ?> />Penurunan curah jantung</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="diagkep_8" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_8']) and $diagnosa_keperawatan['diagkep_8'] == '1') ? 'checked' : ''); ?> />Sesak</td>
		</tr>
			<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_9" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_9']) and $diagnosa_keperawatan['diagkep_9'] == '1') ? 'checked' : ''); ?> />Inefektif perfusi jaringan</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="diagkep_10" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_10']) and $diagnosa_keperawatan['diagkep_10'] == '1') ? 'checked' : ''); ?> />Resiko kejang berulang</td>
		</tr>
			<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_11" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_11']) and $diagnosa_keperawatan['diagkep_11'] == '1') ? 'checked' : ''); ?> />Inefektif perfusi serebral</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="diagkep_12" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_12']) and $diagnosa_keperawatan['diagkep_12'] == '1') ? 'checked' : ''); ?> />Peningkatan suhu tubuh</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_13" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_13']) and $diagnosa_keperawatan['diagkep_13'] == '1') ? 'checked' : ''); ?> />Intoleransi aktifitas</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="diagkep_14" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_14']) and $diagnosa_keperawatan['diagkep_14'] == '1') ? 'checked' : ''); ?> />Ketidakefektifan/ ketidakbersihan jalan nafas</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="diagkep_15" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_15']) and $diagnosa_keperawatan['diagkep_15'] == '1') ? 'checked' : ''); ?> />Gangguan hemodinamik</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7"><input type="checkbox" name="diagkep_16" value="1" 
				<?php echo ((isset($diagnosa_keperawatan['diagkep_16']) and $diagnosa_keperawatan['diagkep_16'] == '1') ? 'checked' : ''); ?> />Lain-lain
			<input type="text" name="diagkep_17" value="<?php echo ((isset($diagnosa_keperawatan['diagkep_17'])) ? $diagnosa_keperawatan['diagkep_17'] : ''); ?>" class="text_dt" style="width:850px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Rencana Keperawatan</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7">Tujuan dan Kriteria Hasil</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7"><textarea name="rencana_keperawatan" class="text_dt2" style="width:930px;" ><?php echo $rencana_keperawatan; ?></textarea></td>
		</tr>
		        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Intervensi Keperawatan</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_1" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_1']) and $intervensi_keperawatan['intkep_1'] == '1') ? 'checked' : ''); ?> />Manajemen airway : 
				<input type="radio" name="intkep_1_1" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_1_1']) and $intervensi_keperawatan['intkep_1_1'] == '1') ? 'checked' : ''); ?> />headtilt-chin lift/ 
				<input type="radio" name="intkep_1_1" value="2" 
				<?php echo ((isset($intervensi_keperawatan['intkep_1_1']) and $intervensi_keperawatan['intkep_1_1'] == '2') ? 'checked' : ''); ?> />jaw thrust</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="intkep_2" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_2']) and $intervensi_keperawatan['intkep_2'] == '1') ? 'checked' : ''); ?> />Perawatan luka</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_3" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_3']) and $intervensi_keperawatan['intkep_3'] == '1') ? 'checked' : ''); ?> />Pengambilan benda asing dengan forcep</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="intkep_4" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_4']) and $intervensi_keperawatan['intkep_4'] == '1') ? 'checked' : ''); ?> />Lakukan kompres hangat</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_5" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_5']) and $intervensi_keperawatan['intkep_5'] == '1') ? 'checked' : ''); ?> />Pemberian terapi oksigen
				<input type="text" name="intkep_5_1" value="<?php echo ((isset($intervensi_keperawatan['intkep_5_1'])) ? $intervensi_keperawatan['intkep_5_1'] : ''); ?>" class="text_dt" style="width:50px;" >ltr/menit,<br/>
				Via <input type="text" name="intkep_5_2" value="<?php echo ((isset($intervensi_keperawatan['intkep_5_2'])) ? $intervensi_keperawatan['intkep_5_2'] : ''); ?>" class="text_dt" style="width:205px;" ></td>
			<td>&nbsp;</td>
			<td colspan="5" valign="top"><input type="checkbox" name="intkep_6" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_6']) and $intervensi_keperawatan['intkep_6'] == '1') ? 'checked' : ''); ?> />Ajarkan teknik relaksasi</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_7" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_7']) and $intervensi_keperawatan['intkep_7'] == '1') ? 'checked' : ''); ?> />Bantuan dengan bag valve mask</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="intkep_8" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_8']) and $intervensi_keperawatan['intkep_8'] == '1') ? 'checked' : ''); ?> />Ajarkan batuk efektif</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_9" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_9']) and $intervensi_keperawatan['intkep_9'] == '1') ? 'checked' : ''); ?> />Persiapan ventilator mekanik</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="intkep_10" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_10']) and $intervensi_keperawatan['intkep_10'] == '1') ? 'checked' : ''); ?> />Heatcing</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_11" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_11']) and $intervensi_keperawatan['intkep_11'] == '1') ? 'checked' : ''); ?> />Berikan posisi head up 30 derajat</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="intkep_12" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_12']) and $intervensi_keperawatan['intkep_12'] == '1') ? 'checked' : ''); ?> />Kolaborasi dengan dokter dalam pemberian terapi</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_13" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_13']) and $intervensi_keperawatan['intkep_13'] == '1') ? 'checked' : ''); ?> />Periksa kesadaran dan GCS tiap 5 menit</td>
			<td>&nbsp;</td>
			<td colspan="5"><input type="checkbox" name="intkep_14" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_14']) and $intervensi_keperawatan['intkep_14'] == '1') ? 'checked' : ''); ?> />Kontrol pendarahan</td>
		</tr>
				<tr>
			<td>&nbsp;</td>
			<td><input type="checkbox" name="intkep_15" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_15']) and $intervensi_keperawatan['intkep_15'] == '1') ? 'checked' : ''); ?> />Lakukan CPR dan defibilasi</td>
			<td>&nbsp;</td>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7"><input type="checkbox" name="intkep_16" value="1" 
				<?php echo ((isset($intervensi_keperawatan['intkep_16']) and $intervensi_keperawatan['intkep_16'] == '1') ? 'checked' : ''); ?> />Lain-lain
			<input type="text" name="intkep_17" value="<?php echo ((isset($intervensi_keperawatan['intkep_17'])) ? $intervensi_keperawatan['intkep_17'] : ''); ?>" class="text_dt" style="width:850px;" ></td>
		</tr>
		<tr>
            <td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Implementasi Keperawatan</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td colspan="7">
				<table width="100%" border="0" class="tableData">
					<tr>
						<th><strong>Pukul</strong></th>
						<th><strong>Tindakan</strong></th>
						<th><strong>Nama</strong></th>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_1" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_1'])) ? $implementasi_keperawatan['impkep_pukul_1'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_1" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_1'])) ? $implementasi_keperawatan['impkep_tindakan_1'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_1" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_1'])) ? $implementasi_keperawatan['impkep_nama_1'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>	
					<tr>
						<td><input type="text" name="impkep_pukul_2" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_2'])) ? $implementasi_keperawatan['impkep_pukul_2'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_2" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_2'])) ? $implementasi_keperawatan['impkep_tindakan_2'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_2" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_2'])) ? $implementasi_keperawatan['impkep_nama_2'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_3" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_3'])) ? $implementasi_keperawatan['impkep_pukul_3'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_3" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_3'])) ? $implementasi_keperawatan['impkep_tindakan_3'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_3" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_3'])) ? $implementasi_keperawatan['impkep_nama_3'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_4" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_4'])) ? $implementasi_keperawatan['impkep_pukul_4'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_4" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_4'])) ? $implementasi_keperawatan['impkep_tindakan_4'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_4" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_4'])) ? $implementasi_keperawatan['impkep_nama_4'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_5" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_5'])) ? $implementasi_keperawatan['impkep_pukul_5'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_5" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_5'])) ? $implementasi_keperawatan['impkep_tindakan_5'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_5" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_5'])) ? $implementasi_keperawatan['impkep_nama_5'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_6" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_6'])) ? $implementasi_keperawatan['impkep_pukul_6'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_6" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_6'])) ? $implementasi_keperawatan['impkep_tindakan_6'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_6" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_6'])) ? $implementasi_keperawatan['impkep_nama_6'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_7" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_7'])) ? $implementasi_keperawatan['impkep_pukul_7'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_7" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_7'])) ? $implementasi_keperawatan['impkep_tindakan_7'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_7" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_7'])) ? $implementasi_keperawatan['impkep_nama_7'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_8" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_8'])) ? $implementasi_keperawatan['impkep_pukul_8'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_8" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_8'])) ? $implementasi_keperawatan['impkep_tindakan_8'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_8" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_8'])) ? $implementasi_keperawatan['impkep_nama_8'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_9" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_9'])) ? $implementasi_keperawatan['impkep_pukul_9'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_9" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_9'])) ? $implementasi_keperawatan['impkep_tindakan_9'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_9" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_9'])) ? $implementasi_keperawatan['impkep_nama_9'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_10" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_10'])) ? $implementasi_keperawatan['impkep_pukul_10'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_10" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_10'])) ? $implementasi_keperawatan['impkep_tindakan_10'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_10" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_10'])) ? $implementasi_keperawatan['impkep_nama_10'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_11" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_11'])) ? $implementasi_keperawatan['impkep_pukul_11'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_11" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_11'])) ? $implementasi_keperawatan['impkep_tindakan_11'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_11" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_11'])) ? $implementasi_keperawatan['impkep_nama_11'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_12" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_12'])) ? $implementasi_keperawatan['impkep_pukul_12'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_12" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_12'])) ? $implementasi_keperawatan['impkep_tindakan_12'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_12" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_12'])) ? $implementasi_keperawatan['impkep_nama_12'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_13" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_13'])) ? $implementasi_keperawatan['impkep_pukul_13'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_13" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_13'])) ? $implementasi_keperawatan['impkep_tindakan_13'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_13" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_13'])) ? $implementasi_keperawatan['impkep_nama_13'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="impkep_pukul_14" value="<?php echo ((isset($implementasi_keperawatan['impkep_pukul_14'])) ? $implementasi_keperawatan['impkep_pukul_14'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="impkep_tindakan_14" value="<?php echo ((isset($implementasi_keperawatan['impkep_tindakan_14'])) ? $implementasi_keperawatan['impkep_tindakan_14'] : ''); ?>" class="text_dt" style="width:750px;" ></td>
						<td><input type="text" name="impkep_nama_14" value="<?php echo ((isset($implementasi_keperawatan['impkep_nama_14'])) ? $implementasi_keperawatan['impkep_nama_14'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
					</tr>
				</table>
			</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Pemberian Obat/ Infus</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td>&nbsp;</td>
			<td colspan="7">
				<table width="100%" border="0" class="tableData">
					<tr>
						<th><strong>Pukul</strong></th>
						<th><strong>Nama Obat/ Infus</strong></th>
						<th><strong>Dosis</strong></th>
						<th><strong>Rute</strong></th>
						<th><strong>Diperiksa oleh</strong></th>
						<th><strong>Diberikan oleh</strong></th>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_1" value="<?php echo ((isset($infus_obat['infus_obat_pukul_1'])) ? $infus_obat['infus_obat_pukul_1'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_1" value="<?php echo ((isset($infus_obat['infus_obat_nama_1'])) ? $infus_obat['infus_obat_nama_1'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_1" value="<?php echo ((isset($infus_obat['infus_obat_dosis_1'])) ? $infus_obat['infus_obat_dosis_1'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_1" value="<?php echo ((isset($infus_obat['infus_obat_rute_1'])) ? $infus_obat['infus_obat_rute_1'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_1" value="<?php echo ((isset($infus_obat['infus_obat_periksa_1'])) ? $infus_obat['infus_obat_periksa_1'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_1" value="<?php echo ((isset($infus_obat['infus_obat_beri_1'])) ? $infus_obat['infus_obat_beri_1'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_2" value="<?php echo ((isset($infus_obat['infus_obat_pukul_2'])) ? $infus_obat['infus_obat_pukul_2'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_2" value="<?php echo ((isset($infus_obat['infus_obat_nama_2'])) ? $infus_obat['infus_obat_nama_2'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_2" value="<?php echo ((isset($infus_obat['infus_obat_dosis_2'])) ? $infus_obat['infus_obat_dosis_2'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_2" value="<?php echo ((isset($infus_obat['infus_obat_rute_2'])) ? $infus_obat['infus_obat_rute_2'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_2" value="<?php echo ((isset($infus_obat['infus_obat_periksa_2'])) ? $infus_obat['infus_obat_periksa_2'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_2" value="<?php echo ((isset($infus_obat['infus_obat_beri_2'])) ? $infus_obat['infus_obat_beri_2'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_3" value="<?php echo ((isset($infus_obat['infus_obat_pukul_3'])) ? $infus_obat['infus_obat_pukul_3'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_3" value="<?php echo ((isset($infus_obat['infus_obat_nama_3'])) ? $infus_obat['infus_obat_nama_3'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_3" value="<?php echo ((isset($infus_obat['infus_obat_dosis_3'])) ? $infus_obat['infus_obat_dosis_3'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_3" value="<?php echo ((isset($infus_obat['infus_obat_rute_3'])) ? $infus_obat['infus_obat_rute_3'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_3" value="<?php echo ((isset($infus_obat['infus_obat_periksa_3'])) ? $infus_obat['infus_obat_periksa_3'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_3" value="<?php echo ((isset($infus_obat['infus_obat_beri_3'])) ? $infus_obat['infus_obat_beri_3'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_4" value="<?php echo ((isset($infus_obat['infus_obat_pukul_4'])) ? $infus_obat['infus_obat_pukul_4'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_4" value="<?php echo ((isset($infus_obat['infus_obat_nama_4'])) ? $infus_obat['infus_obat_nama_4'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_4" value="<?php echo ((isset($infus_obat['infus_obat_dosis_4'])) ? $infus_obat['infus_obat_dosis_4'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_4" value="<?php echo ((isset($infus_obat['infus_obat_rute_4'])) ? $infus_obat['infus_obat_rute_4'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_4" value="<?php echo ((isset($infus_obat['infus_obat_periksa_4'])) ? $infus_obat['infus_obat_periksa_4'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_4" value="<?php echo ((isset($infus_obat['infus_obat_beri_4'])) ? $infus_obat['infus_obat_beri_4'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_5" value="<?php echo ((isset($infus_obat['infus_obat_pukul_5'])) ? $infus_obat['infus_obat_pukul_5'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_5" value="<?php echo ((isset($infus_obat['infus_obat_nama_5'])) ? $infus_obat['infus_obat_nama_5'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_5" value="<?php echo ((isset($infus_obat['infus_obat_dosis_5'])) ? $infus_obat['infus_obat_dosis_5'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_5" value="<?php echo ((isset($infus_obat['infus_obat_rute_5'])) ? $infus_obat['infus_obat_rute_5'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_5" value="<?php echo ((isset($infus_obat['infus_obat_periksa_5'])) ? $infus_obat['infus_obat_periksa_5'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_5" value="<?php echo ((isset($infus_obat['infus_obat_beri_5'])) ? $infus_obat['infus_obat_beri_5'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_6" value="<?php echo ((isset($infus_obat['infus_obat_pukul_6'])) ? $infus_obat['infus_obat_pukul_6'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_6" value="<?php echo ((isset($infus_obat['infus_obat_nama_6'])) ? $infus_obat['infus_obat_nama_6'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_6" value="<?php echo ((isset($infus_obat['infus_obat_dosis_6'])) ? $infus_obat['infus_obat_dosis_6'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_6" value="<?php echo ((isset($infus_obat['infus_obat_rute_6'])) ? $infus_obat['infus_obat_rute_6'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_6" value="<?php echo ((isset($infus_obat['infus_obat_periksa_6'])) ? $infus_obat['infus_obat_periksa_6'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_6" value="<?php echo ((isset($infus_obat['infus_obat_beri_6'])) ? $infus_obat['infus_obat_beri_6'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_7" value="<?php echo ((isset($infus_obat['infus_obat_pukul_7'])) ? $infus_obat['infus_obat_pukul_7'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_7" value="<?php echo ((isset($infus_obat['infus_obat_nama_7'])) ? $infus_obat['infus_obat_nama_7'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_7" value="<?php echo ((isset($infus_obat['infus_obat_dosis_7'])) ? $infus_obat['infus_obat_dosis_7'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_7" value="<?php echo ((isset($infus_obat['infus_obat_rute_7'])) ? $infus_obat['infus_obat_rute_7'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_7" value="<?php echo ((isset($infus_obat['infus_obat_periksa_7'])) ? $infus_obat['infus_obat_periksa_7'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_7" value="<?php echo ((isset($infus_obat['infus_obat_beri_7'])) ? $infus_obat['infus_obat_beri_7'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_8" value="<?php echo ((isset($infus_obat['infus_obat_pukul_8'])) ? $infus_obat['infus_obat_pukul_8'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_8" value="<?php echo ((isset($infus_obat['infus_obat_nama_8'])) ? $infus_obat['infus_obat_nama_8'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_8" value="<?php echo ((isset($infus_obat['infus_obat_dosis_8'])) ? $infus_obat['infus_obat_dosis_8'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_8" value="<?php echo ((isset($infus_obat['infus_obat_rute_8'])) ? $infus_obat['infus_obat_rute_8'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_8" value="<?php echo ((isset($infus_obat['infus_obat_periksa_8'])) ? $infus_obat['infus_obat_periksa_8'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_8" value="<?php echo ((isset($infus_obat['infus_obat_beri_8'])) ? $infus_obat['infus_obat_beri_8'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_9" value="<?php echo ((isset($infus_obat['infus_obat_pukul_9'])) ? $infus_obat['infus_obat_pukul_9'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_9" value="<?php echo ((isset($infus_obat['infus_obat_nama_9'])) ? $infus_obat['infus_obat_nama_9'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_9" value="<?php echo ((isset($infus_obat['infus_obat_dosis_9'])) ? $infus_obat['infus_obat_dosis_9'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_9" value="<?php echo ((isset($infus_obat['infus_obat_rute_9'])) ? $infus_obat['infus_obat_rute_9'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_9" value="<?php echo ((isset($infus_obat['infus_obat_periksa_9'])) ? $infus_obat['infus_obat_periksa_9'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_9" value="<?php echo ((isset($infus_obat['infus_obat_beri_9'])) ? $infus_obat['infus_obat_beri_9'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_10" value="<?php echo ((isset($infus_obat['infus_obat_pukul_10'])) ? $infus_obat['infus_obat_pukul_10'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_10" value="<?php echo ((isset($infus_obat['infus_obat_nama_10'])) ? $infus_obat['infus_obat_nama_10'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_10" value="<?php echo ((isset($infus_obat['infus_obat_dosis_10'])) ? $infus_obat['infus_obat_dosis_10'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_10" value="<?php echo ((isset($infus_obat['infus_obat_rute_10'])) ? $infus_obat['infus_obat_rute_10'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_10" value="<?php echo ((isset($infus_obat['infus_obat_periksa_10'])) ? $infus_obat['infus_obat_periksa_10'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_10" value="<?php echo ((isset($infus_obat['infus_obat_beri_10'])) ? $infus_obat['infus_obat_beri_10'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_11" value="<?php echo ((isset($infus_obat['infus_obat_pukul_11'])) ? $infus_obat['infus_obat_pukul_11'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_11" value="<?php echo ((isset($infus_obat['infus_obat_nama_11'])) ? $infus_obat['infus_obat_nama_11'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_11" value="<?php echo ((isset($infus_obat['infus_obat_dosis_11'])) ? $infus_obat['infus_obat_dosis_11'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_11" value="<?php echo ((isset($infus_obat['infus_obat_rute_11'])) ? $infus_obat['infus_obat_rute_11'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_11" value="<?php echo ((isset($infus_obat['infus_obat_periksa_11'])) ? $infus_obat['infus_obat_periksa_11'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_11" value="<?php echo ((isset($infus_obat['infus_obat_beri_11'])) ? $infus_obat['infus_obat_beri_11'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_12" value="<?php echo ((isset($infus_obat['infus_obat_pukul_12'])) ? $infus_obat['infus_obat_pukul_12'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_12" value="<?php echo ((isset($infus_obat['infus_obat_nama_12'])) ? $infus_obat['infus_obat_nama_12'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_12" value="<?php echo ((isset($infus_obat['infus_obat_dosis_12'])) ? $infus_obat['infus_obat_dosis_12'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_12" value="<?php echo ((isset($infus_obat['infus_obat_rute_12'])) ? $infus_obat['infus_obat_rute_12'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_12" value="<?php echo ((isset($infus_obat['infus_obat_periksa_12'])) ? $infus_obat['infus_obat_periksa_12'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_12" value="<?php echo ((isset($infus_obat['infus_obat_beri_12'])) ? $infus_obat['infus_obat_beri_12'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_13" value="<?php echo ((isset($infus_obat['infus_obat_pukul_13'])) ? $infus_obat['infus_obat_pukul_13'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_13" value="<?php echo ((isset($infus_obat['infus_obat_nama_13'])) ? $infus_obat['infus_obat_nama_13'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_13" value="<?php echo ((isset($infus_obat['infus_obat_dosis_13'])) ? $infus_obat['infus_obat_dosis_13'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_13" value="<?php echo ((isset($infus_obat['infus_obat_rute_13'])) ? $infus_obat['infus_obat_rute_13'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_13" value="<?php echo ((isset($infus_obat['infus_obat_periksa_13'])) ? $infus_obat['infus_obat_periksa_13'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_13" value="<?php echo ((isset($infus_obat['infus_obat_beri_13'])) ? $infus_obat['infus_obat_beri_13'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
					<tr>
						<td><input type="text" name="infus_obat_pukul_14" value="<?php echo ((isset($infus_obat['infus_obat_pukul_14'])) ? $infus_obat['infus_obat_pukul_14'] : ''); ?>" class="text_dt" style="width:50px;" ></td>
						<td><input type="text" name="infus_obat_nama_14" value="<?php echo ((isset($infus_obat['infus_obat_nama_14'])) ? $infus_obat['infus_obat_nama_14'] : ''); ?>" class="text_dt" style="width:350px;" ></td>
						<td><input type="text" name="infus_obat_dosis_14" value="<?php echo ((isset($infus_obat['infus_obat_dosis_14'])) ? $infus_obat['infus_obat_dosis_14'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_rute_14" value="<?php echo ((isset($infus_obat['infus_obat_rute_14'])) ? $infus_obat['infus_obat_rute_14'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_periksa_14" value="<?php echo ((isset($infus_obat['infus_obat_periksa_14'])) ? $infus_obat['infus_obat_periksa_14'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
						<td><input type="text" name="infus_obat_beri_14" value="<?php echo ((isset($infus_obat['infus_obat_beri_14'])) ? $infus_obat['infus_obat_beri_14'] : ''); ?>" class="text_dt" style="width:125px;" ></td>
					</tr>
				</table>	
			</td>		
		</tr>
		<tr>
            <td valign="top" colspan="2">&nbsp;</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
            <td valign="top" colspan="2">Evaluasi Keperawatan</td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Subjective</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="subjective" class="text_dt2" ><?php echo ((isset($evaluasi_keperawatan['subjective'])) ? $evaluasi_keperawatan['subjective'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Objective</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="objective" class="text_dt2" ><?php echo ((isset($evaluasi_keperawatan['objective'])) ? $evaluasi_keperawatan['objective'] : ''); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="7">Tanda-tanda Vital</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>GCS</td>
			<td>:</td>
			<td colspan="2">E&nbsp;<input type="text" name="eva_gcs_e" value="<?php echo ((isset($evaluasi_keperawatan['eva_gcs_e'])) ? $evaluasi_keperawatan['eva_gcs_e'] : ''); ?>" class="text_dt" style="width:80px;" >
			M&nbsp;<input type="text" name="eva_gcs_m" value="<?php echo ((isset($evaluasi_keperawatan['eva_gcs_m'])) ? $evaluasi_keperawatan['eva_gcs_m'] : ''); ?>" class="text_dt" style="width:80px;" >
			V&nbsp;<input type="text" name="eva_gcs_v" value="<?php echo ((isset($evaluasi_keperawatan['eva_gcs_v'])) ? $evaluasi_keperawatan['eva_gcs_v'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
			<td width="95px">SpO</td>
			<td width="10px">:</td>
			<td width="200px"><input type="text" name="eva_spo" value="<?php echo ((isset($evaluasi_keperawatan['eva_spo'])) ? $evaluasi_keperawatan['eva_spo'] : ''); ?>" class="text_dt" >&nbsp;%</td>
		</tr>	
		<tr>	
			<td>&nbsp;</td>	
			<td>TD</td>
			<td>:</td>
			<td width="200px"><input type="text" name="eva_td" value="<?php echo ((isset($evaluasi_keperawatan['eva_td'])) ? $evaluasi_keperawatan['eva_td'] : ''); ?>" class="text_dt" >&nbsp;mmHg</td>
			<td width="130px">&nbsp;</td>
			<td width="95px">Reflex Cahaya</td>
			<td>:</td>
			<td><input type="text" name="eva_reflex_cahaya_l" value="<?php echo ((isset($evaluasi_keperawatan['eva_reflex_cahaya_l'])) ? $evaluasi_keperawatan['eva_reflex_cahaya_l'] : ''); ?>" class="text_dt" style="width:80px;" >/
			<input type="text" name="eva_reflex_cahaya_r" value="<?php echo ((isset($evaluasi_keperawatan['eva_reflex_cahaya_r'])) ? $evaluasi_keperawatan['eva_reflex_cahaya_r'] : ''); ?>" class="text_dt" style="width:80px;" ></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Pernafasan</td>
			<td>:</td>
			<td><input type="text" name="eva_nafas" value="<?php echo ((isset($evaluasi_keperawatan['eva_nafas'])) ? $evaluasi_keperawatan['eva_nafas'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td>&nbsp;</td>
			<td>Suhu</td>
			<td>:</td>
			<td><input type="text" name="eva_suhu" value="<?php echo ((isset($evaluasi_keperawatan['eva_suhu'])) ? $evaluasi_keperawatan['eva_suhu'] : ''); ?>" class="text_dt" >&nbsp;<span>&#8451;</span></td>
		</tr>
		<tr>	
			<td>&nbsp;</td>			
			<td>Nadi</td>
			<td>:</td>
			<td><input type="text" name="eva_nadi" value="<?php echo ((isset($evaluasi_keperawatan['eva_nadi'])) ? $evaluasi_keperawatan['eva_nadi'] : ''); ?>" class="text_dt" >&nbsp;x/menit</td>
			<td width="150px">
			<input type="radio" name="eva_nadi_reguler" value="1" 
				<?php echo ((isset($evaluasi_keperawatan['eva_nadi_reguler']) and $evaluasi_keperawatan['eva_nadi_reguler'] == '1') ? 'checked' : ''); ?> />Reguler
			<input type="radio" name="eva_nadi_reguler" value="2" 
				<?php echo ((isset($evaluasi_keperawatan['eva_nadi_reguler']) and $evaluasi_keperawatan['eva_nadi_reguler'] == '2') ? 'checked' : ''); ?> />Ireguler
			</td>
			<td>Akral</td>
			<td>:</td>
			<td><input type="text" name="eva_akral" value="<?php echo ((isset($evaluasi_keperawatan['eva_akral'])) ? $evaluasi_keperawatan['eva_akral'] : ''); ?>" class="text_dt" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Assesment</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="eva_assesment" class="text_dt2" ><?php echo ((isset($evaluasi_keperawatan['eva_assesment'])) ? $evaluasi_keperawatan['eva_assesment'] : ''); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Planning</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="eva_planning" class="text_dt2" ><?php echo ((isset($evaluasi_keperawatan['eva_planning'])) ? $evaluasi_keperawatan['eva_planning'] : ''); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top"><input type="checkbox" name="masuk_rs" value="1" 
				<?php echo ((isset($followup['masuk_rs']) and $followup['masuk_rs'] == '1') ? 'checked' : ''); ?> />Masuk rumah sakit, di ruang
				<input type="text" name="masuk_ruang" value="<?php echo ((isset($followup['masuk_ruang'])) ? $followup['masuk_ruang'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
			<td valign="top">&nbsp;</td>
			<td colspan="5">Petugas yang menerima
			<input type="text" name="petugas_penerima" value="<?php echo ((isset($followup['petugas_penerima'])) ? $followup['petugas_penerima'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top"><input type="checkbox" name="tindakan_lanjutan" value="1" 
				<?php echo ((isset($followup['tindakan_lanjutan']) and $followup['tindakan_lanjutan'] == '1') ? 'checked' : ''); ?> />Tindakan lanjutan di
				</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="checkbox" name="tindakan_lanjutan_ok" value="1" 
				<?php echo ((isset($followup['tindakan_lanjutan_ok']) and $followup['tindakan_lanjutan_ok'] == '1') ? 'checked' : ''); ?> />Kamar Operasi
				<input type="checkbox" name="tindakan_lanjutan_opd" value="1" 
				<?php echo ((isset($followup['tindakan_lanjutan_opd']) and $followup['tindakan_lanjutan_opd'] == '1') ? 'checked' : ''); ?> />OPD Spesialis
				<input type="checkbox" name="tindakan_lanjutan_kb" value="1" 
				<?php echo ((isset($followup['tindakan_lanjutan_kb']) and $followup['tindakan_lanjutan_kb'] == '1') ? 'checked' : ''); ?> />Kamar Bersalin
				<input type="checkbox" name="tindakan_lanjutan_hd" value="1" 
				<?php echo ((isset($followup['tindakan_lanjutan_hd']) and $followup['tindakan_lanjutan_hd'] == '1') ? 'checked' : ''); ?> />Hemodialisa</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top"><input type="checkbox" name="rujuk_ke_rs" value="1" 
				<?php echo ((isset($followup['rujuk_ke_rs']) and $followup['rujuk_ke_rs'] == '1') ? 'checked' : ''); ?> />Rujuk ke rumah sakit
				</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="rujuk_ke_rs_nama" value="<?php echo ((isset($followup['rujuk_ke_rs_nama'])) ? $followup['rujuk_ke_rs_nama'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top"><input type="checkbox" name="dipulangkan" value="1" 
				<?php echo ((isset($followup['dipulangkan']) and $followup['dipulangkan'] == '1') ? 'checked' : ''); ?> />Dipulangkan pukul
				</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="dipulangkan_pukul" value="<?php echo ((isset($followup['dipulangkan_pukul'])) ? $followup['dipulangkan_pukul'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top"><input type="checkbox" name="meninggal" value="1" 
				<?php echo ((isset($followup['meninggal']) and $followup['meninggal'] == '1') ? 'checked' : ''); ?> />Meninggal pukul
				</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="text" name="meninggal_pukul" value="<?php echo ((isset($followup['meninggal_pukul'])) ? $followup['meninggal_pukul'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top"><input type="checkbox" name="doa" value="1" 
				<?php echo ((isset($followup['doa']) and $followup['doa'] == '1') ? 'checked' : ''); ?> />DOA
				</td>
			<td valign="top"></td>
			<td colspan="5"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Transportasi Pulang</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="radio" name="transportasi_pl" value="1" 
				<?php echo ((isset($followup['transportasi_pl']) and $followup['transportasi_pl'] == '1') ? 'checked' : ''); ?> />Kendaraan pribadi
				<input type="radio" name="transportasi_pl" value="2" 
				<?php echo ((isset($followup['transportasi_pl']) and $followup['transportasi_pl'] == '2') ? 'checked' : ''); ?> />Ambulan
				<input type="radio" name="transportasi_pl" value="3" 
				<?php echo ((isset($followup['transportasi_pl']) and $followup['transportasi_pl'] == '3') ? 'checked' : ''); ?> />Kendaraan jenazah</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Pendidikan kesehatan pasien pulang</td>
			<td valign="top">:</td>
			<td colspan="5"><input type="checkbox" name="pendidikan_pl_makan" value="1" 
				<?php echo ((isset($followup['pendidikan_pl_makan']) and $followup['pendidikan_pl_makan'] == '1') ? 'checked' : ''); ?> />Makan/ minum obat teratur
				<input type="checkbox" name="pendidikan_pl_diet" value="1" 
				<?php echo ((isset($followup['pendidikan_pl_diet']) and $followup['pendidikan_pl_diet'] == '1') ? 'checked' : ''); ?> />Diet
				<input type="checkbox" name="pendidikan_pl_bersih" value="1" 
				<?php echo ((isset($followup['pendidikan_pl_bersih']) and $followup['pendidikan_pl_bersih'] == '1') ? 'checked' : ''); ?> />Jaga kebersihan luka
				<input type="checkbox" name="pendidikan_pl_lain" value="1" 
				<?php echo ((isset($followup['pendidikan_pl_lain']) and $followup['pendidikan_pl_lain'] == '1') ? 'checked' : ''); ?> />Lain-lain
				<input type="text" name="pendidikan_pl_lain_ket" value="<?php echo ((isset($followup['pendidikan_pl_lain_ket'])) ? $followup['pendidikan_pl_lain_ket'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Followup</td>
			<td valign="top"></td>
			<td colspan="5"></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top"><input type="radio" name="followup_ya" value="1" 
				<?php echo ((isset($followup['followup_ya']) and $followup['followup_ya'] == '1') ? 'checked' : ''); ?> />Ya
				<input type="radio" name="followup_ya" value="2" 
				<?php echo ((isset($followup['followup_ya']) and $followup['followup_ya'] == '2') ? 'checked' : ''); ?> />Tidak,
				tanggal <input type="text" name="followup_tgl" value="<?php echo ((isset($followup['followup_tgl'])) ? $followup['followup_tgl'] : ''); ?>" class="text_dt" style="width:200px;" ></td>
			<td valign="top"></td>
			<td colspan="5">
						Instalasi Rawat Jalan, Poliklinik <input type="text" name="poliklinik" value="<?php echo ((isset($followup['poliklinik'])) ? $followup['poliklinik'] : ''); ?>" class="text_dt" style="width:200px;" >,
						IGD
			</textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top">Hasil</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="followup_hsl" class="text_dt2" ><?php echo ((isset($followup['followup_hsl'])) ? $followup['followup_hsl'] : ''); ?></textarea>
			</td>
		</tr>
		
        <tr><td colspan="8" align="right" >
			<?php if(isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) and $irja_final == ''){ ?>
			<input type="checkbox" name="final" id="final" value="1" <?php echo (($final == '1') ? 'checked' : ''); ?> />&nbsp;Final&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" value="simpan" class="myButton1" onclick="simpan();"/>
			<?php if(!empty($idx_pengkajian)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "41"
						ORDER BY FILE_ID DESC LIMIT 1';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				$dat_view_rm = mysql_fetch_assoc($get_view_rm);
			?>
				<input type="button" value="lihat" class="myButton1" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" />
			<?php } } ?>
			</td>
        </tr>
    </table>
</form>
<script>
<?php if(!isPerawat($_SESSION['SES_SIMRS_TIPE_PEGAWAI'])){ ?>
$(':input').attr('readonly','readonly');
<?php } ?>

function simpan(){
	_haschange = false;
	
	if($('#idx').val() != ''){
		if($('#ls_final').val() == '1'){
			if($('#ls_assesment').val() != $('#tgl_skr').val()){
				if(confirm('Revisi ?')){
					$('#formperiksa').submit();
				}	
			}else{
				$('#formperiksa').submit();
			}	
		}else{
			if($("#final").is(':checked')){
				if(confirm('Final ?')){
					$('#formperiksa').submit();
				}
			}else{
				$('#formperiksa').submit();
			}
		}
	}else{
		if($("#final").is(':checked')){
			if(confirm('Final ?')){
				$('#formperiksa').submit();
			}
		}else{
			$('#formperiksa').submit();
		}	
	}
}	
</script>