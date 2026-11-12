<?php
function replace_quote($str){
	$ret = str_replace('"',"'",$str);
	$ret = str_replace('|',"!",$str);
	$ret = htmlspecialchars($ret);
	return $ret;
}

if (isset($_POST['irja_id'])){
	$st_save = true;
	if($st_save){
		$arr_riwayat = array('rpenyakit_is'=>replace_quote($_POST['rpenyakit_is']),
						'rpenyakit_io'=>replace_quote($_POST['rpenyakit_io']),
						'rpenyakit_pr'=>replace_quote($_POST['rpenyakit_pr']));
		$arr_riwayat_penyakit = json_encode($arr_riwayat);
		$arr_riwayat_penyakit = str_replace('"','|',$arr_riwayat_penyakit);	
		
		$arr_pem_aktifitas = array('berhias_01'=>replace_quote($_POST['berhias_01']),
							'berhias_02'=>replace_quote($_POST['berhias_02']),
							'berhias_03'=>replace_quote($_POST['berhias_03']),
							'berhias_04'=>replace_quote($_POST['berhias_04']),
							'berhias_05'=>replace_quote($_POST['berhias_05']),
							'berhias_06'=>replace_quote($_POST['berhias_06']),
							'berhias_ket'=>replace_quote($_POST['berhias_ket']),
							'gigi_01'=>replace_quote($_POST['gigi_01']),
							'gigi_02'=>replace_quote($_POST['gigi_02']),
							'gigi_03'=>replace_quote($_POST['gigi_03']),
							'gigi_04'=>replace_quote($_POST['gigi_04']),
							'gigi_05'=>replace_quote($_POST['gigi_05']),
							'gigi_06'=>replace_quote($_POST['gigi_06']),
							'gigi_ket'=>replace_quote($_POST['gigi_ket']),
							'mandi_01'=>replace_quote($_POST['mandi_01']),
							'mandi_02'=>replace_quote($_POST['mandi_02']),
							'mandi_03'=>replace_quote($_POST['mandi_03']),
							'mandi_04'=>replace_quote($_POST['mandi_04']),
							'mandi_05'=>replace_quote($_POST['mandi_05']),
							'mandi_06'=>replace_quote($_POST['mandi_06']),
							'mandi_ket'=>replace_quote($_POST['mandi_ket']),
							'berpakaian_01'=>replace_quote($_POST['berpakaian_01']),
							'berpakaian_02'=>replace_quote($_POST['berpakaian_02']),
							'berpakaian_03'=>replace_quote($_POST['berpakaian_03']),
							'berpakaian_04'=>replace_quote($_POST['berpakaian_04']),
							'berpakaian_05'=>replace_quote($_POST['berpakaian_05']),
							'berpakaian_06'=>replace_quote($_POST['berpakaian_06']),
							'berpakaian_ket'=>replace_quote($_POST['berpakaian_ket']),
							'bab_01'=>replace_quote($_POST['bab_01']),
							'bab_02'=>replace_quote($_POST['bab_02']),
							'bab_03'=>replace_quote($_POST['bab_03']),
							'bab_04'=>replace_quote($_POST['bab_04']),
							'bab_05'=>replace_quote($_POST['bab_05']),
							'bab_06'=>replace_quote($_POST['bab_06']),
							'bab_ket'=>replace_quote($_POST['bab_ket']),
							'makan_01'=>replace_quote($_POST['makan_01']),
							'makan_02'=>replace_quote($_POST['makan_02']),
							'makan_03'=>replace_quote($_POST['makan_03']),
							'makan_04'=>replace_quote($_POST['makan_04']),
							'makan_05'=>replace_quote($_POST['makan_05']),
							'makan_06'=>replace_quote($_POST['makan_06']),
							'makan_ket'=>replace_quote($_POST['makan_ket']),
							'sosialisasi_01'=>replace_quote($_POST['sosialisasi_01']),
							'sosialisasi_02'=>replace_quote($_POST['sosialisasi_02']),
							'sosialisasi_03'=>replace_quote($_POST['sosialisasi_03']),
							'sosialisasi_04'=>replace_quote($_POST['sosialisasi_04']),
							'sosialisasi_05'=>replace_quote($_POST['sosialisasi_05']),
							'sosialisasi_06'=>replace_quote($_POST['sosialisasi_06']),
							'sosialisasi_ket'=>replace_quote($_POST['sosialisasi_ket']),
							'komunikasi_01'=>replace_quote($_POST['komunikasi_01']),
							'komunikasi_02'=>replace_quote($_POST['komunikasi_02']),
							'komunikasi_03'=>replace_quote($_POST['komunikasi_03']),
							'komunikasi_04'=>replace_quote($_POST['komunikasi_04']),
							'komunikasi_05'=>replace_quote($_POST['komunikasi_05']),
							'komunikasi_06'=>replace_quote($_POST['komunikasi_06']),
							'komunikasi_ket'=>replace_quote($_POST['komunikasi_ket']),
							'mobilitas_01'=>replace_quote($_POST['mobilitas_01']),
							'mobilitas_02'=>replace_quote($_POST['mobilitas_02']),
							'mobilitas_03'=>replace_quote($_POST['mobilitas_03']),
							'mobilitas_04'=>replace_quote($_POST['mobilitas_04']),
							'mobilitas_05'=>replace_quote($_POST['mobilitas_05']),
							'mobilitas_06'=>replace_quote($_POST['mobilitas_06']),
							'mobilitas_ket'=>replace_quote($_POST['mobilitas_ket']),
							'seksual_01'=>replace_quote($_POST['seksual_01']),
							'seksual_02'=>replace_quote($_POST['seksual_02']),
							'seksual_03'=>replace_quote($_POST['seksual_03']),
							'seksual_04'=>replace_quote($_POST['seksual_04']),
							'seksual_05'=>replace_quote($_POST['seksual_05']),
							'seksual_06'=>replace_quote($_POST['seksual_06']),
							'seksual_ket'=>replace_quote($_POST['seksual_ket']));
		$arr_pem_aktifitas_sehari = json_encode($arr_pem_aktifitas);
		$arr_pem_aktifitas_sehari = str_replace('"','|',$arr_pem_aktifitas_sehari);
		
		$arr_pem_bekerja = array('rumah_01'=>replace_quote($_POST['rumah_01']),
						'rumah_02'=>replace_quote($_POST['rumah_02']),
						'rumah_03'=>replace_quote($_POST['rumah_03']),
						'rumah_04'=>replace_quote($_POST['rumah_04']),
						'rumah_05'=>replace_quote($_POST['rumah_05']),
						'rumah_06'=>replace_quote($_POST['rumah_06']),
						'rumah_ket'=>replace_quote($_POST['rumah_ket']),
						'sekolah_01'=>replace_quote($_POST['sekolah_01']),
						'sekolah_02'=>replace_quote($_POST['sekolah_02']),
						'sekolah_03'=>replace_quote($_POST['sekolah_03']),
						'sekolah_04'=>replace_quote($_POST['sekolah_04']),
						'sekolah_05'=>replace_quote($_POST['sekolah_05']),
						'sekolah_06'=>replace_quote($_POST['sekolah_06']),
						'sekolah_ket'=>replace_quote($_POST['sekolah_ket']),
						'bekerja_01'=>replace_quote($_POST['bekerja_01']),
						'bekerja_02'=>replace_quote($_POST['bekerja_02']),
						'bekerja_03'=>replace_quote($_POST['bekerja_03']),
						'bekerja_04'=>replace_quote($_POST['bekerja_04']),
						'bekerja_05'=>replace_quote($_POST['bekerja_05']),
						'bekerja_06'=>replace_quote($_POST['bekerja_06']),
						'bekerja_ket'=>replace_quote($_POST['bekerja_ket']));
		$arr_pem_aktifitas_bekerja = json_encode($arr_pem_bekerja);
		$arr_pem_aktifitas_bekerja = str_replace('"','|',$arr_pem_aktifitas_bekerja);
		
		$arr_pem_waktu = array('kinerja_01'=>replace_quote($_POST['kinerja_01']),
						'kinerja_02'=>replace_quote($_POST['kinerja_02']),
						'kinerja_03'=>replace_quote($_POST['kinerja_03']),
						'kinerja_04'=>replace_quote($_POST['kinerja_04']),
						'kinerja_05'=>replace_quote($_POST['kinerja_05']),
						'kinerja_06'=>replace_quote($_POST['kinerja_06']),
						'kinerja_ket'=>replace_quote($_POST['kinerja_ket']),
						'eksporasi_01'=>replace_quote($_POST['eksporasi_01']),
						'eksporasi_02'=>replace_quote($_POST['eksporasi_02']),
						'eksporasi_03'=>replace_quote($_POST['eksporasi_03']),
						'eksporasi_04'=>replace_quote($_POST['eksporasi_04']),
						'eksporasi_05'=>replace_quote($_POST['eksporasi_05']),
						'eksporasi_06'=>replace_quote($_POST['eksporasi_06']),
						'eksporasi_ket'=>replace_quote($_POST['eksporasi_ket']));
		$arr_pem_waktu_luang = json_encode($arr_pem_waktu);
		$arr_pem_waktu_luang = str_replace('"','|',$arr_pem_waktu_luang);
		
		$arr_pem_motorik = array('m_kasar_01'=>replace_quote($_POST['m_kasar_01']),
						'm_kasar_02'=>replace_quote($_POST['m_kasar_02']),
						'm_kasar_03'=>replace_quote($_POST['m_kasar_03']),
						'm_kasar_04'=>replace_quote($_POST['m_kasar_04']),
						'm_kasar_05'=>replace_quote($_POST['m_kasar_05']),
						'm_kasar_06'=>replace_quote($_POST['m_kasar_06']),
						'm_kasar_ket'=>replace_quote($_POST['m_kasar_ket']),
						'miring_01'=>replace_quote($_POST['miring_01']),
						'miring_02'=>replace_quote($_POST['miring_02']),
						'miring_03'=>replace_quote($_POST['miring_03']),
						'miring_04'=>replace_quote($_POST['miring_04']),
						'miring_05'=>replace_quote($_POST['miring_05']),
						'miring_06'=>replace_quote($_POST['miring_06']),
						'miring_ket'=>replace_quote($_POST['miring_ket']),
						'duduk_01'=>replace_quote($_POST['duduk_01']),
						'duduk_02'=>replace_quote($_POST['duduk_02']),
						'duduk_03'=>replace_quote($_POST['duduk_03']),
						'duduk_04'=>replace_quote($_POST['duduk_04']),
						'duduk_05'=>replace_quote($_POST['duduk_05']),
						'duduk_06'=>replace_quote($_POST['duduk_06']),
						'duduk_ket'=>replace_quote($_POST['duduk_ket']),
						'berdiri_01'=>replace_quote($_POST['berdiri_01']),
						'berdiri_02'=>replace_quote($_POST['berdiri_02']),
						'berdiri_03'=>replace_quote($_POST['berdiri_03']),
						'berdiri_04'=>replace_quote($_POST['berdiri_04']),
						'berdiri_05'=>replace_quote($_POST['berdiri_05']),
						'berdiri_06'=>replace_quote($_POST['berdiri_06']),
						'berdiri_ket'=>replace_quote($_POST['berdiri_ket']),
						'berjalan_01'=>replace_quote($_POST['berjalan_01']),
						'berjalan_02'=>replace_quote($_POST['berjalan_02']),
						'berjalan_03'=>replace_quote($_POST['berjalan_03']),
						'berjalan_04'=>replace_quote($_POST['berjalan_04']),
						'berjalan_05'=>replace_quote($_POST['berjalan_05']),
						'berjalan_06'=>replace_quote($_POST['berjalan_06']),
						'berjalan_ket'=>replace_quote($_POST['berjalan_ket']),
						'm_halus_01'=>replace_quote($_POST['m_halus_01']),
						'm_halus_02'=>replace_quote($_POST['m_halus_02']),
						'm_halus_03'=>replace_quote($_POST['m_halus_03']),
						'm_halus_04'=>replace_quote($_POST['m_halus_04']),
						'm_halus_05'=>replace_quote($_POST['m_halus_05']),
						'm_halus_06'=>replace_quote($_POST['m_halus_06']),
						'm_halus_ket'=>replace_quote($_POST['m_halus_ket']),
						'reach_01'=>replace_quote($_POST['reach_01']),
						'reach_02'=>replace_quote($_POST['reach_02']),
						'reach_03'=>replace_quote($_POST['reach_03']),
						'reach_04'=>replace_quote($_POST['reach_04']),
						'reach_05'=>replace_quote($_POST['reach_05']),
						'reach_06'=>replace_quote($_POST['reach_06']),
						'reach_ket'=>replace_quote($_POST['reach_ket']),
						'grasp_01'=>replace_quote($_POST['grasp_01']),
						'grasp_02'=>replace_quote($_POST['grasp_02']),
						'grasp_03'=>replace_quote($_POST['grasp_03']),
						'grasp_04'=>replace_quote($_POST['grasp_04']),
						'grasp_05'=>replace_quote($_POST['grasp_05']),
						'grasp_06'=>replace_quote($_POST['grasp_06']),
						'grasp_ket'=>replace_quote($_POST['grasp_ket']),
						'hook_01'=>replace_quote($_POST['hook_01']),
						'hook_02'=>replace_quote($_POST['hook_02']),
						'hook_03'=>replace_quote($_POST['hook_03']),
						'hook_04'=>replace_quote($_POST['hook_04']),
						'hook_05'=>replace_quote($_POST['hook_05']),
						'hook_06'=>replace_quote($_POST['hook_06']),
						'hook_ket'=>replace_quote($_POST['hook_ket']),
						'power_01'=>replace_quote($_POST['power_01']),
						'power_02'=>replace_quote($_POST['power_02']),
						'power_03'=>replace_quote($_POST['power_03']),
						'power_04'=>replace_quote($_POST['power_04']),
						'power_05'=>replace_quote($_POST['power_05']),
						'power_06'=>replace_quote($_POST['power_06']),
						'power_ket'=>replace_quote($_POST['power_ket']),
						'lateral_01'=>replace_quote($_POST['lateral_01']),
						'lateral_02'=>replace_quote($_POST['lateral_02']),
						'lateral_03'=>replace_quote($_POST['lateral_03']),
						'lateral_04'=>replace_quote($_POST['lateral_04']),
						'lateral_05'=>replace_quote($_POST['lateral_05']),
						'lateral_06'=>replace_quote($_POST['lateral_06']),
						'lateral_ket'=>replace_quote($_POST['lateral_ket']),
						'pad_01'=>replace_quote($_POST['pad_01']),
						'pad_02'=>replace_quote($_POST['pad_02']),
						'pad_03'=>replace_quote($_POST['pad_03']),
						'pad_04'=>replace_quote($_POST['pad_04']),
						'pad_05'=>replace_quote($_POST['pad_05']),
						'pad_06'=>replace_quote($_POST['pad_06']),
						'pad_ket'=>replace_quote($_POST['pad_ket']),
						'three_01'=>replace_quote($_POST['three_01']),
						'three_02'=>replace_quote($_POST['three_02']),
						'three_03'=>replace_quote($_POST['three_03']),
						'three_04'=>replace_quote($_POST['three_04']),
						'three_05'=>replace_quote($_POST['three_05']),
						'three_06'=>replace_quote($_POST['three_06']),
						'three_ket'=>replace_quote($_POST['three_ket']),
						'tip_01'=>replace_quote($_POST['tip_01']),
						'tip_02'=>replace_quote($_POST['tip_02']),
						'tip_03'=>replace_quote($_POST['tip_03']),
						'tip_04'=>replace_quote($_POST['tip_04']),
						'tip_05'=>replace_quote($_POST['tip_05']),
						'tip_06'=>replace_quote($_POST['tip_06']),
						'tip_ket'=>replace_quote($_POST['tip_ket']),
						'speherical_01'=>replace_quote($_POST['speherical_01']),
						'speherical_02'=>replace_quote($_POST['speherical_02']),
						'speherical_03'=>replace_quote($_POST['speherical_03']),
						'speherical_04'=>replace_quote($_POST['speherical_04']),
						'speherical_05'=>replace_quote($_POST['speherical_05']),
						'speherical_06'=>replace_quote($_POST['speherical_06']),
						'speherical_ket'=>replace_quote($_POST['speherical_ket']),
						'cylindrical_01'=>replace_quote($_POST['cylindrical_01']),
						'cylindrical_02'=>replace_quote($_POST['cylindrical_02']),
						'cylindrical_03'=>replace_quote($_POST['cylindrical_03']),
						'cylindrical_04'=>replace_quote($_POST['cylindrical_04']),
						'cylindrical_05'=>replace_quote($_POST['cylindrical_05']),
						'cylindrical_06'=>replace_quote($_POST['cylindrical_06']),
						'cylindrical_ket'=>replace_quote($_POST['cylindrical_ket']),
						'disc_01'=>replace_quote($_POST['disc_01']),
						'disc_02'=>replace_quote($_POST['disc_02']),
						'disc_03'=>replace_quote($_POST['disc_03']),
						'disc_04'=>replace_quote($_POST['disc_04']),
						'disc_05'=>replace_quote($_POST['disc_05']),
						'disc_06'=>replace_quote($_POST['disc_06']),
						'disc_ket'=>replace_quote($_POST['disc_ket']),
						'manipulasi_01'=>replace_quote($_POST['manipulasi_01']),
						'manipulasi_02'=>replace_quote($_POST['manipulasi_02']),
						'manipulasi_03'=>replace_quote($_POST['manipulasi_03']),
						'manipulasi_04'=>replace_quote($_POST['manipulasi_04']),
						'manipulasi_05'=>replace_quote($_POST['manipulasi_05']),
						'manipulasi_06'=>replace_quote($_POST['manipulasi_06']),
						'manipulasi_ket'=>replace_quote($_POST['manipulasi_ket']),
						'memutar_01'=>replace_quote($_POST['memutar_01']),
						'memutar_02'=>replace_quote($_POST['memutar_02']),
						'memutar_03'=>replace_quote($_POST['memutar_03']),
						'memutar_04'=>replace_quote($_POST['memutar_04']),
						'memutar_05'=>replace_quote($_POST['memutar_05']),
						'memutar_06'=>replace_quote($_POST['memutar_06']),
						'memutar_ket'=>replace_quote($_POST['memutar_ket']),
						'benda_01'=>replace_quote($_POST['benda_01']),
						'benda_02'=>replace_quote($_POST['benda_02']),
						'benda_03'=>replace_quote($_POST['benda_03']),
						'benda_04'=>replace_quote($_POST['benda_04']),
						'benda_05'=>replace_quote($_POST['benda_05']),
						'benda_06'=>replace_quote($_POST['benda_06']),
						'benda_ket'=>replace_quote($_POST['benda_ket']),
						'carry_01'=>replace_quote($_POST['carry_01']),
						'carry_02'=>replace_quote($_POST['carry_02']),
						'carry_03'=>replace_quote($_POST['carry_03']),
						'carry_04'=>replace_quote($_POST['carry_04']),
						'carry_05'=>replace_quote($_POST['carry_05']),
						'carry_06'=>replace_quote($_POST['carry_06']),
						'carry_ket'=>replace_quote($_POST['carry_ket']),
						'voluntary_01'=>replace_quote($_POST['voluntary_01']),
						'voluntary_02'=>replace_quote($_POST['voluntary_02']),
						'voluntary_03'=>replace_quote($_POST['voluntary_03']),
						'voluntary_04'=>replace_quote($_POST['voluntary_04']),
						'voluntary_05'=>replace_quote($_POST['voluntary_05']),
						'voluntary_06'=>replace_quote($_POST['voluntary_06']),
						'voluntary_ket'=>replace_quote($_POST['voluntary_ket']),
						'melepas_01'=>replace_quote($_POST['melepas_01']),
						'melepas_02'=>replace_quote($_POST['melepas_02']),
						'melepas_03'=>replace_quote($_POST['melepas_03']),
						'melepas_04'=>replace_quote($_POST['melepas_04']),
						'melepas_05'=>replace_quote($_POST['melepas_05']),
						'melepas_06'=>replace_quote($_POST['melepas_06']),
						'melepas_ket'=>replace_quote($_POST['melepas_ket']),
						'bilateral_01'=>replace_quote($_POST['bilateral_01']),
						'bilateral_02'=>replace_quote($_POST['bilateral_02']),
						'bilateral_03'=>replace_quote($_POST['bilateral_03']),
						'bilateral_04'=>replace_quote($_POST['bilateral_04']),
						'bilateral_05'=>replace_quote($_POST['bilateral_05']),
						'bilateral_06'=>replace_quote($_POST['bilateral_06']),
						'bilateral_ket'=>replace_quote($_POST['bilateral_ket']));
		$arr_pem_akt_motorik = json_encode($arr_pem_motorik);
		$arr_pem_akt_motorik = str_replace('"','|',$arr_pem_akt_motorik);
		
		$arr_pem_sensorik = array('sensorik_01'=>replace_quote($_POST['sensorik_01']),
						'sensorik_02'=>replace_quote($_POST['sensorik_02']),
						'sensorik_03'=>replace_quote($_POST['sensorik_03']),
						'sensorik_04'=>replace_quote($_POST['sensorik_04']),
						'sensorik_05'=>replace_quote($_POST['sensorik_05']),
						'sensorik_06'=>replace_quote($_POST['sensorik_06']),
						'sensorik_ket'=>replace_quote($_POST['sensorik_ket']),
						'taktil_01'=>replace_quote($_POST['taktil_01']),
						'taktil_02'=>replace_quote($_POST['taktil_02']),
						'taktil_03'=>replace_quote($_POST['taktil_03']),
						'taktil_04'=>replace_quote($_POST['taktil_04']),
						'taktil_05'=>replace_quote($_POST['taktil_05']),
						'taktil_06'=>replace_quote($_POST['taktil_06']),
						'taktil_ket'=>replace_quote($_POST['taktil_ket']),
						'stereogonis_01'=>replace_quote($_POST['stereogonis_01']),
						'stereogonis_02'=>replace_quote($_POST['stereogonis_02']),
						'stereogonis_03'=>replace_quote($_POST['stereogonis_03']),
						'stereogonis_04'=>replace_quote($_POST['stereogonis_04']),
						'stereogonis_05'=>replace_quote($_POST['stereogonis_05']),
						'stereogonis_06'=>replace_quote($_POST['stereogonis_06']),
						'stereogonis_ket'=>replace_quote($_POST['stereogonis_ket']),
						'kognitif_01'=>replace_quote($_POST['kognitif_01']),
						'kognitif_02'=>replace_quote($_POST['kognitif_02']),
						'kognitif_03'=>replace_quote($_POST['kognitif_03']),
						'kognitif_04'=>replace_quote($_POST['kognitif_04']),
						'kognitif_05'=>replace_quote($_POST['kognitif_05']),
						'kognitif_06'=>replace_quote($_POST['kognitif_06']),
						'kognitif_ket'=>replace_quote($_POST['kognitif_ket']),
						'motivasi_01'=>replace_quote($_POST['motivasi_01']),
						'motivasi_02'=>replace_quote($_POST['motivasi_02']),
						'motivasi_03'=>replace_quote($_POST['motivasi_03']),
						'motivasi_04'=>replace_quote($_POST['motivasi_04']),
						'motivasi_05'=>replace_quote($_POST['motivasi_05']),
						'motivasi_06'=>replace_quote($_POST['motivasi_06']),
						'motivasi_ket'=>replace_quote($_POST['motivasi_ket']),
						'atensi_01'=>replace_quote($_POST['atensi_01']),
						'atensi_02'=>replace_quote($_POST['atensi_02']),
						'atensi_03'=>replace_quote($_POST['atensi_03']),
						'atensi_04'=>replace_quote($_POST['atensi_04']),
						'atensi_05'=>replace_quote($_POST['atensi_05']),
						'atensi_06'=>replace_quote($_POST['atensi_06']),
						'atensi_ket'=>replace_quote($_POST['atensi_ket']),
						'problem_01'=>replace_quote($_POST['problem_01']),
						'problem_02'=>replace_quote($_POST['problem_02']),
						'problem_03'=>replace_quote($_POST['problem_03']),
						'problem_04'=>replace_quote($_POST['problem_04']),
						'problem_05'=>replace_quote($_POST['problem_05']),
						'problem_06'=>replace_quote($_POST['problem_06']),
						'problem_ket'=>replace_quote($_POST['problem_ket']),
						'rentang_01'=>replace_quote($_POST['rentang_01']),
						'rentang_02'=>replace_quote($_POST['rentang_02']),
						'rentang_03'=>replace_quote($_POST['rentang_03']),
						'rentang_04'=>replace_quote($_POST['rentang_04']),
						'rentang_05'=>replace_quote($_POST['rentang_05']),
						'rentang_06'=>replace_quote($_POST['rentang_06']),
						'rentang_ket'=>replace_quote($_POST['rentang_ket']));
		$arr_pem_akt_sensorik = json_encode($arr_pem_sensorik);
		$arr_pem_akt_sensorik = str_replace('"','|',$arr_pem_akt_sensorik);
		
		$arr_intervensi = array('intenvensi_jp'=>replace_quote($_POST['intenvensi_jp']),
						'intenvensi_jk'=>replace_quote($_POST['intenvensi_jk']),
						'intenvensi_ab'=>replace_quote($_POST['intenvensi_ab']),
						'intenvensi_aa'=>replace_quote($_POST['intenvensi_aa']));
		$arr_pem_intervensi = json_encode($arr_intervensi);
		$arr_pem_intervensi = str_replace('"','|',$arr_pem_intervensi);
	
		if(empty($_POST['idx'])){				
			mysql_query('INSERT INTO t_pemeriksaan_okupasi_terapi (IRJA_ID,RIWAYAT_PENYAKIT,PEMERIKSAAN_AKTIFITAS_SEHARI_HARI,
			PEMERIKSAAN_AKTIFITAS_BEKERJA,PEMERIKSAAN_AKTIFITAS_WAKTU_LUANG,PEMERIKSAAN_AKTIFITAS_MOTORIK,PEMERIKSAAN_AKTIFITAS_SENSORIK, 
			INTERVENSI_OKUPASI_TERAPI,TGL_ASSESMENT,REGISTER) VALUES ("' . $_POST['irja_id'] . '","' . $arr_riwayat_penyakit . '",
				"' . $arr_pem_aktifitas_sehari . '","' . $arr_pem_aktifitas_bekerja . '",
				"' . $arr_pem_waktu_luang . '","' . $arr_pem_akt_motorik . '",
				"' . $arr_pem_akt_sensorik . '","' . $arr_pem_intervensi . '",
				NOW(),"' . $user_name . '")') or die(mysql_error());
		}else{
			mysql_query('UPDATE t_pemeriksaan_okupasi_terapi 
				SET RIWAYAT_PENYAKIT = "' . $arr_riwayat_penyakit . '",
				PEMERIKSAAN_AKTIFITAS_SEHARI_HARI = "' . $arr_pem_aktifitas_sehari . '",
				PEMERIKSAAN_AKTIFITAS_BEKERJA = "' . $arr_pem_aktifitas_bekerja . '",
				PEMERIKSAAN_AKTIFITAS_WAKTU_LUANG = "' . $arr_pem_waktu_luang . '",
				PEMERIKSAAN_AKTIFITAS_MOTORIK = "' . $arr_pem_akt_motorik . '",
				PEMERIKSAAN_AKTIFITAS_SENSORIK = "' . $arr_pem_akt_sensorik . '",
				INTERVENSI_OKUPASI_TERAPI = "' . $arr_pem_intervensi . '",
				TGL_ASSESMENT = NOW(),
				REGISTER = "' . $user_name . '",
				ST_CREATE_ERM = NULL
				WHERE IRJA_ID = "' . $_POST['irja_id'] . '"') or die(mysql_error());
		}
		
		/*
		include('lib/vendor/autoload.php');
		include('edoc_rekammedik/new/erm_create_pemeriksaan_okupasi_terapi.php');
		erm_pemeriksaan_okupasi_terapi($_POST['irja_id']);
		*/
		?>
		<script language="JavaScript" >
			alert('Simpan Pemeriksaan Okupasi Terapi Berhasil.');
			window.location = "<?php echo currentUrl(); ?>";
		</script>
		<?php 
	}else{
		$msg_info = 'Harus Oleh Dokter DPJP.';
	}	
}

$qry_pasien = 'SELECT IRJA_ID,RIWAYAT_PENYAKIT,PEMERIKSAAN_AKTIFITAS_SEHARI_HARI,PEMERIKSAAN_AKTIFITAS_BEKERJA,
			PEMERIKSAAN_AKTIFITAS_WAKTU_LUANG,PEMERIKSAAN_AKTIFITAS_MOTORIK,PEMERIKSAAN_AKTIFITAS_SENSORIK, 
			INTERVENSI_OKUPASI_TERAPI
			FROM t_pemeriksaan_okupasi_terapi
			WHERE IRJA_ID = "' . $_GET['idx'] . '"';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
$dat_pasien = mysql_fetch_assoc($get_pasien);
$idx = $dat_pasien['IRJA_ID'];
$riwayat_penyakit = str_replace('|','"',$dat_pasien['RIWAYAT_PENYAKIT']);
$riwayat_penyakit = preg_replace('/\r|\n/','\n',trim($riwayat_penyakit));
$riwayat_penyakit = json_decode($riwayat_penyakit,true);	

$pem_aktifitas_sehari = str_replace('|','"',$dat_pasien['PEMERIKSAAN_AKTIFITAS_SEHARI_HARI']);
$pem_aktifitas_sehari = preg_replace('/\r|\n/','\n',trim($pem_aktifitas_sehari));
$pem_aktifitas_sehari = json_decode($pem_aktifitas_sehari,true);

$pem_bekerja = str_replace('|','"',$dat_pasien['PEMERIKSAAN_AKTIFITAS_BEKERJA']);
$pem_bekerja = preg_replace('/\r|\n/','\n',trim($pem_bekerja));
$pem_bekerja = json_decode($pem_bekerja,true);

$pem_waktu_luang = str_replace('|','"',$dat_pasien['PEMERIKSAAN_AKTIFITAS_WAKTU_LUANG']);
$pem_waktu_luang = preg_replace('/\r|\n/','\n',trim($pem_waktu_luang));
$pem_waktu_luang = json_decode($pem_waktu_luang,true);

$pem_motorik = str_replace('|','"',$dat_pasien['PEMERIKSAAN_AKTIFITAS_MOTORIK']);
$pem_motorik = preg_replace('/\r|\n/','\n',trim($pem_motorik));
$pem_motorik = json_decode($pem_motorik,true);

$pem_sensorik = str_replace('|','"',$dat_pasien['PEMERIKSAAN_AKTIFITAS_SENSORIK']);
$pem_sensorik = preg_replace('/\r|\n/','\n',trim($pem_sensorik));
$pem_sensorik = json_decode($pem_sensorik,true);

$intervensi = str_replace('|','"',$dat_pasien['INTERVENSI_OKUPASI_TERAPI']);
$intervensi = preg_replace('/\r|\n/','\n',trim($intervensi));
$intervensi = json_decode($intervensi,true);
?>
<form name="formperiksa" id="formperiksa" method="post" action="<?php echo currentUrl(); ?>" >
    <input type="hidden" name="idx" id="idx" value="<?php echo $idx; ?>" />	
	<input type="hidden" name="irja_id" id="irja_id" value="<?php echo $irja_id; ?>" />	
	<table border="0" align="center" style="position:static; " width="100%">
        <tr>
			<td colspan="8">RIWAYAT PENYAKIT</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">Informasi Subyektif</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="rpenyakit_is" class="text_dt10" ><?php echo ((isset($riwayat_penyakit['rpenyakit_is'])) ? $riwayat_penyakit['rpenyakit_is'] : ''); ?></textarea></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Informasi Obyektif</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="rpenyakit_io" class="text_dt10" ><?php echo ((isset($riwayat_penyakit['rpenyakit_io'])) ? $riwayat_penyakit['rpenyakit_io'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Problem Okupasi Terapi</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="rpenyakit_pr" class="text_dt10" ><?php echo ((isset($riwayat_penyakit['rpenyakit_pr'])) ? $riwayat_penyakit['rpenyakit_pr'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>		
		<tr>
			<td colspan="8">PEMERIKSAAN AREA OKUPASI TERAPI</td>
		</tr>
		<tr>
			<td colspan="8">Pemeriksaan Komponen Okupasi Terapi</td>
		</tr>	
		<tr>	
			<td colspan="8">Aktifitas Kehidupan Sehari-Hari</td>
		</tr>
		<tr>	
			<td colspan="8">
				<table width="100%" class="tableData">
					<tr>
						<th width="30%" align="center"><strong>Aktifitas</strong></th>
						<th width="30%" colspan="6" align="center"><strong>Tanggal / Tinggal Kemandirian</strong></th>
						<th width="30%" align="center"><strong>Keterangan</strong></th>
					</tr>
					<tr>
						<td>Berhias</td>
						<td><input type="text" name="berhias_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berhias_01'])) ? $pem_aktifitas_sehari['berhias_01'] : ''); ?>" /></td>
						<td><input type="text" name="berhias_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berhias_02'])) ? $pem_aktifitas_sehari['berhias_02'] : ''); ?>" /></td>
						<td><input type="text" name="berhias_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berhias_03'])) ? $pem_aktifitas_sehari['berhias_03'] : ''); ?>" /></td>
						<td><input type="text" name="berhias_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berhias_04'])) ? $pem_aktifitas_sehari['berhias_04'] : ''); ?>" /></td>
						<td><input type="text" name="berhias_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berhias_05'])) ? $pem_aktifitas_sehari['berhias_05'] : ''); ?>" /></td>
						<td><input type="text" name="berhias_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berhias_06'])) ? $pem_aktifitas_sehari['berhias_06'] : ''); ?>" /></td>
						<td><input type="text" name="berhias_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['berhias_ket'])) ? $pem_aktifitas_sehari['berhias_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Menggosok Gigi</td>
						<td><input type="text" name="gigi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['gigi_01'])) ? $pem_aktifitas_sehari['gigi_01'] : ''); ?>" /></td>
						<td><input type="text" name="gigi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['gigi_02'])) ? $pem_aktifitas_sehari['gigi_02'] : ''); ?>" /></td>
						<td><input type="text" name="gigi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['gigi_03'])) ? $pem_aktifitas_sehari['gigi_03'] : ''); ?>" /></td>
						<td><input type="text" name="gigi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['gigi_04'])) ? $pem_aktifitas_sehari['gigi_04'] : ''); ?>" /></td>
						<td><input type="text" name="gigi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['gigi_05'])) ? $pem_aktifitas_sehari['gigi_05'] : ''); ?>" /></td>
						<td><input type="text" name="gigi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['gigi_06'])) ? $pem_aktifitas_sehari['gigi_06'] : ''); ?>" /></td>
						<td><input type="text" name="gigi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['gigi_ket'])) ? $pem_aktifitas_sehari['gigi_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Mandi</td>
						<td><input type="text" name="mandi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mandi_01'])) ? $pem_aktifitas_sehari['mandi_01'] : ''); ?>" /></td>
						<td><input type="text" name="mandi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mandi_02'])) ? $pem_aktifitas_sehari['mandi_02'] : ''); ?>" /></td>
						<td><input type="text" name="mandi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mandi_03'])) ? $pem_aktifitas_sehari['mandi_03'] : ''); ?>" /></td>
						<td><input type="text" name="mandi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mandi_04'])) ? $pem_aktifitas_sehari['mandi_04'] : ''); ?>" /></td>
						<td><input type="text" name="mandi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mandi_05'])) ? $pem_aktifitas_sehari['mandi_05'] : ''); ?>" /></td>
						<td><input type="text" name="mandi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mandi_06'])) ? $pem_aktifitas_sehari['mandi_06'] : ''); ?>" /></td>
						<td><input type="text" name="mandi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['mandi_ket'])) ? $pem_aktifitas_sehari['mandi_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Berpakaian</td>
						<td><input type="text" name="berpakaian_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berpakaian_01'])) ? $pem_aktifitas_sehari['berpakaian_01'] : ''); ?>" /></td>
						<td><input type="text" name="berpakaian_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berpakaian_02'])) ? $pem_aktifitas_sehari['berpakaian_02'] : ''); ?>" /></td>
						<td><input type="text" name="berpakaian_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berpakaian_03'])) ? $pem_aktifitas_sehari['berpakaian_03'] : ''); ?>" /></td>
						<td><input type="text" name="berpakaian_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berpakaian_04'])) ? $pem_aktifitas_sehari['berpakaian_04'] : ''); ?>" /></td>
						<td><input type="text" name="berpakaian_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berpakaian_05'])) ? $pem_aktifitas_sehari['berpakaian_05'] : ''); ?>" /></td>
						<td><input type="text" name="berpakaian_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['berpakaian_06'])) ? $pem_aktifitas_sehari['berpakaian_06'] : ''); ?>" /></td>
						<td><input type="text" name="berpakaian_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['berpakaian_ket'])) ? $pem_aktifitas_sehari['berpakaian_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>BAB/BAK</td>
						<td><input type="text" name="bab_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['bab_01'])) ? $pem_aktifitas_sehari['bab_01'] : ''); ?>" /></td>
						<td><input type="text" name="bab_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['bab_02'])) ? $pem_aktifitas_sehari['bab_02'] : ''); ?>" /></td>
						<td><input type="text" name="bab_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['bab_03'])) ? $pem_aktifitas_sehari['bab_03'] : ''); ?>" /></td>
						<td><input type="text" name="bab_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['bab_04'])) ? $pem_aktifitas_sehari['bab_04'] : ''); ?>" /></td>
						<td><input type="text" name="bab_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['bab_05'])) ? $pem_aktifitas_sehari['bab_05'] : ''); ?>" /></td>
						<td><input type="text" name="bab_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['bab_06'])) ? $pem_aktifitas_sehari['bab_06'] : ''); ?>" /></td>
						<td><input type="text" name="bab_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['bab_ket'])) ? $pem_aktifitas_sehari['bab_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Makan / Minum</td>
						<td><input type="text" name="makan_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['makan_01'])) ? $pem_aktifitas_sehari['makan_01'] : ''); ?>" /></td>
						<td><input type="text" name="makan_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['makan_02'])) ? $pem_aktifitas_sehari['makan_02'] : ''); ?>" /></td>
						<td><input type="text" name="makan_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['makan_03'])) ? $pem_aktifitas_sehari['makan_03'] : ''); ?>" /></td>
						<td><input type="text" name="makan_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['makan_04'])) ? $pem_aktifitas_sehari['makan_04'] : ''); ?>" /></td>
						<td><input type="text" name="makan_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['makan_05'])) ? $pem_aktifitas_sehari['makan_05'] : ''); ?>" /></td>
						<td><input type="text" name="makan_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['makan_06'])) ? $pem_aktifitas_sehari['makan_06'] : ''); ?>" /></td>
						<td><input type="text" name="makan_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['makan_ket'])) ? $pem_aktifitas_sehari['makan_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Sosialisasi</td>
						<td><input type="text" name="sosialisasi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['sosialisasi_01'])) ? $pem_aktifitas_sehari['sosialisasi_01'] : ''); ?>" /></td>
						<td><input type="text" name="sosialisasi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['sosialisasi_02'])) ? $pem_aktifitas_sehari['sosialisasi_02'] : ''); ?>" /></td>
						<td><input type="text" name="sosialisasi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['sosialisasi_03'])) ? $pem_aktifitas_sehari['sosialisasi_03'] : ''); ?>" /></td>
						<td><input type="text" name="sosialisasi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['sosialisasi_04'])) ? $pem_aktifitas_sehari['sosialisasi_04'] : ''); ?>" /></td>
						<td><input type="text" name="sosialisasi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['sosialisasi_05'])) ? $pem_aktifitas_sehari['sosialisasi_05'] : ''); ?>" /></td>
						<td><input type="text" name="sosialisasi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['sosialisasi_06'])) ? $pem_aktifitas_sehari['sosialisasi_06'] : ''); ?>" /></td>
						<td><input type="text" name="sosialisasi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['sosialisasi_ket'])) ? $pem_aktifitas_sehari['sosialisasi_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Komunikasi Fungsional</td>
						<td><input type="text" name="komunikasi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['komunikasi_01'])) ? $pem_aktifitas_sehari['komunikasi_01'] : ''); ?>" /></td>
						<td><input type="text" name="komunikasi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['komunikasi_02'])) ? $pem_aktifitas_sehari['komunikasi_02'] : ''); ?>" /></td>
						<td><input type="text" name="komunikasi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['komunikasi_03'])) ? $pem_aktifitas_sehari['komunikasi_03'] : ''); ?>" /></td>
						<td><input type="text" name="komunikasi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['komunikasi_04'])) ? $pem_aktifitas_sehari['komunikasi_04'] : ''); ?>" /></td>
						<td><input type="text" name="komunikasi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['komunikasi_05'])) ? $pem_aktifitas_sehari['komunikasi_05'] : ''); ?>" /></td>
						<td><input type="text" name="komunikasi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['komunikasi_06'])) ? $pem_aktifitas_sehari['komunikasi_06'] : ''); ?>" /></td>
						<td><input type="text" name="komunikasi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['komunikasi_ket'])) ? $pem_aktifitas_sehari['komunikasi_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Mobilitas Fungsional</td>
						<td><input type="text" name="mobilitas_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mobilitas_01'])) ? $pem_aktifitas_sehari['mobilitas_01'] : ''); ?>" /></td>
						<td><input type="text" name="mobilitas_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mobilitas_02'])) ? $pem_aktifitas_sehari['mobilitas_02'] : ''); ?>" /></td>
						<td><input type="text" name="mobilitas_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mobilitas_03'])) ? $pem_aktifitas_sehari['mobilitas_03'] : ''); ?>" /></td>
						<td><input type="text" name="mobilitas_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mobilitas_04'])) ? $pem_aktifitas_sehari['mobilitas_04'] : ''); ?>" /></td>
						<td><input type="text" name="mobilitas_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mobilitas_05'])) ? $pem_aktifitas_sehari['mobilitas_05'] : ''); ?>" /></td>
						<td><input type="text" name="mobilitas_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['mobilitas_06'])) ? $pem_aktifitas_sehari['mobilitas_06'] : ''); ?>" /></td>
						<td><input type="text" name="mobilitas_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['mobilitas_ket'])) ? $pem_aktifitas_sehari['mobilitas_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Aktifitas Seksual</td>
						<td><input type="text" name="seksual_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['seksual_01'])) ? $pem_aktifitas_sehari['seksual_01'] : ''); ?>" /></td>
						<td><input type="text" name="seksual_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['seksual_02'])) ? $pem_aktifitas_sehari['seksual_02'] : ''); ?>" /></td>
						<td><input type="text" name="seksual_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['seksual_03'])) ? $pem_aktifitas_sehari['seksual_03'] : ''); ?>" /></td>
						<td><input type="text" name="seksual_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['seksual_04'])) ? $pem_aktifitas_sehari['seksual_04'] : ''); ?>" /></td>
						<td><input type="text" name="seksual_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['seksual_05'])) ? $pem_aktifitas_sehari['seksual_05'] : ''); ?>" /></td>
						<td><input type="text" name="seksual_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_aktifitas_sehari['seksual_06'])) ? $pem_aktifitas_sehari['seksual_06'] : ''); ?>" /></td>
						<td><input type="text" name="seksual_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_aktifitas_sehari['seksual_ket'])) ? $pem_aktifitas_sehari['seksual_ket'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
		<tr>	
			<td colspan="8">Aktifitas Bekerja</td>
		</tr>
		<tr>	
			<td colspan="8">
				<table width="100%" class="tableData">
					<tr>
						<th width="30%" align="center"><strong>Aktifitas</strong></th>
						<th width="30%" colspan="6" align="center"><strong>Tanggal / Tinggal Kemandirian</strong></th>
						<th width="30%" align="center"><strong>Keterangan</strong></th>
					</tr>
					<tr>
						<td>Manajemen Rumah Tangga</td>
						<td><input type="text" name="rumah_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['rumah_01'])) ? $pem_bekerja['rumah_01'] : ''); ?>" /></td>
						<td><input type="text" name="rumah_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['rumah_02'])) ? $pem_bekerja['rumah_02'] : ''); ?>" /></td>
						<td><input type="text" name="rumah_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['rumah_03'])) ? $pem_bekerja['rumah_03'] : ''); ?>" /></td>
						<td><input type="text" name="rumah_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['rumah_04'])) ? $pem_bekerja['rumah_04'] : ''); ?>" /></td>
						<td><input type="text" name="rumah_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['rumah_05'])) ? $pem_bekerja['rumah_05'] : ''); ?>" /></td>
						<td><input type="text" name="rumah_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['rumah_06'])) ? $pem_bekerja['rumah_06'] : ''); ?>" /></td>
						<td><input type="text" name="rumah_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_bekerja['rumah_ket'])) ? $pem_bekerja['rumah_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Aktifitas Sekolah</td>
						<td><input type="text" name="sekolah_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['sekolah_01'])) ? $pem_bekerja['sekolah_01'] : ''); ?>" /></td>
						<td><input type="text" name="sekolah_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['sekolah_02'])) ? $pem_bekerja['sekolah_02'] : ''); ?>" /></td>
						<td><input type="text" name="sekolah_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['sekolah_03'])) ? $pem_bekerja['sekolah_03'] : ''); ?>" /></td>
						<td><input type="text" name="sekolah_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['sekolah_04'])) ? $pem_bekerja['sekolah_04'] : ''); ?>" /></td>
						<td><input type="text" name="sekolah_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['sekolah_05'])) ? $pem_bekerja['sekolah_05'] : ''); ?>" /></td>
						<td><input type="text" name="sekolah_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['sekolah_06'])) ? $pem_bekerja['sekolah_06'] : ''); ?>" /></td>
						<td><input type="text" name="sekolah_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_bekerja['sekolah_ket'])) ? $pem_bekerja['sekolah_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Aktifitas Vokasional / bekerja</td>
						<td><input type="text" name="bekerja_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['bekerja_01'])) ? $pem_bekerja['bekerja_01'] : ''); ?>" /></td>
						<td><input type="text" name="bekerja_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['bekerja_02'])) ? $pem_bekerja['bekerja_02'] : ''); ?>" /></td>
						<td><input type="text" name="bekerja_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['bekerja_03'])) ? $pem_bekerja['bekerja_03'] : ''); ?>" /></td>
						<td><input type="text" name="bekerja_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['bekerja_04'])) ? $pem_bekerja['bekerja_04'] : ''); ?>" /></td>
						<td><input type="text" name="bekerja_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['bekerja_05'])) ? $pem_bekerja['bekerja_05'] : ''); ?>" /></td>
						<td><input type="text" name="bekerja_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_bekerja['bekerja_06'])) ? $pem_bekerja['bekerja_06'] : ''); ?>" /></td>
						<td><input type="text" name="bekerja_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_bekerja['bekerja_ket'])) ? $pem_bekerja['bekerja_ket'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
		<tr>	
			<td colspan="8">Aktifitas Waktu Luang</td>
		</tr>
		<tr>	
			<td colspan="8">
				<table width="100%" class="tableData">
					<tr>
						<th width="30%" align="center"><strong>Aktifitas</strong></th>
						<th width="30%" colspan="6" align="center"><strong>Tanggal / Tinggal Kemandirian</strong></th>
						<th width="30%" align="center"><strong>Keterangan</strong></th>
					</tr>
					<tr>
						<td>Kinerja Leisure</td>
						<td><input type="text" name="kinerja_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['kinerja_01'])) ? $pem_waktu_luang['kinerja_01'] : ''); ?>" /></td>
						<td><input type="text" name="kinerja_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['kinerja_02'])) ? $pem_waktu_luang['kinerja_02'] : ''); ?>" /></td>
						<td><input type="text" name="kinerja_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['kinerja_03'])) ? $pem_waktu_luang['kinerja_03'] : ''); ?>" /></td>
						<td><input type="text" name="kinerja_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['kinerja_04'])) ? $pem_waktu_luang['kinerja_04'] : ''); ?>" /></td>
						<td><input type="text" name="kinerja_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['kinerja_05'])) ? $pem_waktu_luang['kinerja_05'] : ''); ?>" /></td>
						<td><input type="text" name="kinerja_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['kinerja_06'])) ? $pem_waktu_luang['kinerja_06'] : ''); ?>" /></td>
						<td><input type="text" name="kinerja_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_waktu_luang['kinerja_ket'])) ? $pem_waktu_luang['kinerja_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>Eksplorasi Leisure</td>
						<td><input type="text" name="eksporasi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['eksporasi_01'])) ? $pem_waktu_luang['eksporasi_01'] : ''); ?>" /></td>
						<td><input type="text" name="eksporasi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['eksporasi_02'])) ? $pem_waktu_luang['eksporasi_02'] : ''); ?>" /></td>
						<td><input type="text" name="eksporasi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['eksporasi_03'])) ? $pem_waktu_luang['eksporasi_03'] : ''); ?>" /></td>
						<td><input type="text" name="eksporasi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['eksporasi_04'])) ? $pem_waktu_luang['eksporasi_04'] : ''); ?>" /></td>
						<td><input type="text" name="eksporasi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['eksporasi_05'])) ? $pem_waktu_luang['eksporasi_05'] : ''); ?>" /></td>
						<td><input type="text" name="eksporasi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_waktu_luang['eksporasi_06'])) ? $pem_waktu_luang['eksporasi_06'] : ''); ?>" /></td>
						<td><input type="text" name="eksporasi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_waktu_luang['eksporasi_ket'])) ? $pem_waktu_luang['eksporasi_ket'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>		
		<tr>
			<td colspan="8">Pemeriksaan Komponen Kinerja Okupasi Terapi</td>
		</tr>	
		<tr>	
			<td colspan="8">Motorik</td>
		</tr>
		<tr>	
			<td colspan="8">
				<table width="100%" class="tableData">
					<tr>
						<th width="30%" align="center"><strong>Aktifitas</strong></th>
						<th width="30%" colspan="6" align="center"><strong>Tanggal / Tinggal Kemampuan (+/-)</strong></th>
						<th width="30%" align="center"><strong>Keterangan</strong></th>
					</tr>
					<tr>
						<td><strong>Kemampuan Fungsi Motorik Kasar</strong></td>
						<td><input type="text" name="m_kasar_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_kasar_01'])) ? $pem_motorik['m_kasar_01'] : ''); ?>" /></td>
						<td><input type="text" name="m_kasar_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_kasar_02'])) ? $pem_motorik['m_kasar_02'] : ''); ?>" /></td>
						<td><input type="text" name="m_kasar_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_kasar_03'])) ? $pem_motorik['m_kasar_03'] : ''); ?>" /></td>
						<td><input type="text" name="m_kasar_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_kasar_04'])) ? $pem_motorik['m_kasar_04'] : ''); ?>" /></td>
						<td><input type="text" name="m_kasar_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_kasar_05'])) ? $pem_motorik['m_kasar_05'] : ''); ?>" /></td>
						<td><input type="text" name="m_kasar_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_kasar_06'])) ? $pem_motorik['m_kasar_06'] : ''); ?>" /></td>
						<td><input type="text" name="m_kasar_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['m_kasar_ket'])) ? $pem_motorik['m_kasar_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Miring ke kanan dan ke kiri</td>
						<td><input type="text" name="miring_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['miring_01'])) ? $pem_motorik['miring_01'] : ''); ?>" /></td>
						<td><input type="text" name="miring_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['miring_02'])) ? $pem_motorik['miring_02'] : ''); ?>" /></td>
						<td><input type="text" name="miring_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['miring_03'])) ? $pem_motorik['miring_03'] : ''); ?>" /></td>
						<td><input type="text" name="miring_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['miring_04'])) ? $pem_motorik['miring_04'] : ''); ?>" /></td>
						<td><input type="text" name="miring_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['miring_05'])) ? $pem_motorik['miring_05'] : ''); ?>" /></td>
						<td><input type="text" name="miring_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['miring_06'])) ? $pem_motorik['miring_06'] : ''); ?>" /></td>
						<td><input type="text" name="miring_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['miring_ket'])) ? $pem_motorik['miring_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Duduk</td>
						<td><input type="text" name="duduk_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['duduk_01'])) ? $pem_motorik['duduk_01'] : ''); ?>" /></td>
						<td><input type="text" name="duduk_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['duduk_02'])) ? $pem_motorik['duduk_02'] : ''); ?>" /></td>
						<td><input type="text" name="duduk_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['duduk_03'])) ? $pem_motorik['duduk_03'] : ''); ?>" /></td>
						<td><input type="text" name="duduk_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['duduk_04'])) ? $pem_motorik['duduk_04'] : ''); ?>" /></td>
						<td><input type="text" name="duduk_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['duduk_05'])) ? $pem_motorik['duduk_05'] : ''); ?>" /></td>
						<td><input type="text" name="duduk_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['duduk_06'])) ? $pem_motorik['duduk_06'] : ''); ?>" /></td>
						<td><input type="text" name="duduk_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['duduk_ket'])) ? $pem_motorik['duduk_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Berdiri</td>
						<td><input type="text" name="berdiri_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berdiri_01'])) ? $pem_motorik['berdiri_01'] : ''); ?>" /></td>
						<td><input type="text" name="berdiri_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berdiri_02'])) ? $pem_motorik['berdiri_02'] : ''); ?>" /></td>
						<td><input type="text" name="berdiri_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berdiri_03'])) ? $pem_motorik['berdiri_03'] : ''); ?>" /></td>
						<td><input type="text" name="berdiri_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berdiri_04'])) ? $pem_motorik['berdiri_04'] : ''); ?>" /></td>
						<td><input type="text" name="berdiri_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berdiri_05'])) ? $pem_motorik['berdiri_05'] : ''); ?>" /></td>
						<td><input type="text" name="berdiri_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berdiri_06'])) ? $pem_motorik['berdiri_06'] : ''); ?>" /></td>
						<td><input type="text" name="berdiri_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['berdiri_ket'])) ? $pem_motorik['berdiri_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Berjalan</td>
						<td><input type="text" name="berjalan_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berjalan_01'])) ? $pem_motorik['berjalan_01'] : ''); ?>" /></td>
						<td><input type="text" name="berjalan_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berjalan_02'])) ? $pem_motorik['berjalan_02'] : ''); ?>" /></td>
						<td><input type="text" name="berjalan_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berjalan_03'])) ? $pem_motorik['berjalan_03'] : ''); ?>" /></td>
						<td><input type="text" name="berjalan_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berjalan_04'])) ? $pem_motorik['berjalan_04'] : ''); ?>" /></td>
						<td><input type="text" name="berjalan_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berjalan_05'])) ? $pem_motorik['berjalan_05'] : ''); ?>" /></td>
						<td><input type="text" name="berjalan_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['berjalan_06'])) ? $pem_motorik['berjalan_06'] : ''); ?>" /></td>
						<td><input type="text" name="berjalan_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['berjalan_ket'])) ? $pem_motorik['berjalan_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td><strong>Kemampuan Fungsi Motorik Halus</strong></td>
						<td><input type="text" name="m_halus_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_halus_01'])) ? $pem_motorik['m_halus_01'] : ''); ?>" /></td>
						<td><input type="text" name="m_halus_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_halus_02'])) ? $pem_motorik['m_halus_02'] : ''); ?>" /></td>
						<td><input type="text" name="m_halus_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_halus_03'])) ? $pem_motorik['m_halus_03'] : ''); ?>" /></td>
						<td><input type="text" name="m_halus_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_halus_04'])) ? $pem_motorik['m_halus_04'] : ''); ?>" /></td>
						<td><input type="text" name="m_halus_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_halus_05'])) ? $pem_motorik['m_halus_05'] : ''); ?>" /></td>
						<td><input type="text" name="m_halus_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['m_halus_06'])) ? $pem_motorik['m_halus_06'] : ''); ?>" /></td>
						<td><input type="text" name="m_halus_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['m_halus_ket'])) ? $pem_motorik['m_halus_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>a. Reach</td>
						<td><input type="text" name="reach_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['reach_01'])) ? $pem_motorik['reach_01'] : ''); ?>" /></td>
						<td><input type="text" name="reach_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['reach_02'])) ? $pem_motorik['reach_02'] : ''); ?>" /></td>
						<td><input type="text" name="reach_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['reach_03'])) ? $pem_motorik['reach_03'] : ''); ?>" /></td>
						<td><input type="text" name="reach_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['reach_04'])) ? $pem_motorik['reach_04'] : ''); ?>" /></td>
						<td><input type="text" name="reach_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['reach_05'])) ? $pem_motorik['reach_05'] : ''); ?>" /></td>
						<td><input type="text" name="reach_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['reach_06'])) ? $pem_motorik['reach_06'] : ''); ?>" /></td>
						<td><input type="text" name="reach_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['reach_ket'])) ? $pem_motorik['reach_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>b. Grasp</td>
						<td><input type="text" name="grasp_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['grasp_01'])) ? $pem_motorik['grasp_01'] : ''); ?>" /></td>
						<td><input type="text" name="grasp_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['grasp_02'])) ? $pem_motorik['grasp_02'] : ''); ?>" /></td>
						<td><input type="text" name="grasp_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['grasp_03'])) ? $pem_motorik['grasp_03'] : ''); ?>" /></td>
						<td><input type="text" name="grasp_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['grasp_04'])) ? $pem_motorik['grasp_04'] : ''); ?>" /></td>
						<td><input type="text" name="grasp_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['grasp_05'])) ? $pem_motorik['grasp_05'] : ''); ?>" /></td>
						<td><input type="text" name="grasp_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['grasp_06'])) ? $pem_motorik['grasp_06'] : ''); ?>" /></td>
						<td><input type="text" name="grasp_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['grasp_ket'])) ? $pem_motorik['grasp_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Hook grasp</td>
						<td><input type="text" name="hook_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['hook_01'])) ? $pem_motorik['hook_01'] : ''); ?>" /></td>
						<td><input type="text" name="hook_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['hook_02'])) ? $pem_motorik['hook_02'] : ''); ?>" /></td>
						<td><input type="text" name="hook_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['hook_03'])) ? $pem_motorik['hook_03'] : ''); ?>" /></td>
						<td><input type="text" name="hook_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['hook_04'])) ? $pem_motorik['hook_04'] : ''); ?>" /></td>
						<td><input type="text" name="hook_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['hook_05'])) ? $pem_motorik['hook_05'] : ''); ?>" /></td>
						<td><input type="text" name="hook_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['hook_06'])) ? $pem_motorik['hook_06'] : ''); ?>" /></td>
						<td><input type="text" name="hook_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['hook_ket'])) ? $pem_motorik['hook_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Power grasp</td>
						<td><input type="text" name="power_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['power_01'])) ? $pem_motorik['power_01'] : ''); ?>" /></td>
						<td><input type="text" name="power_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['power_02'])) ? $pem_motorik['power_02'] : ''); ?>" /></td>
						<td><input type="text" name="power_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['power_03'])) ? $pem_motorik['power_03'] : ''); ?>" /></td>
						<td><input type="text" name="power_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['power_04'])) ? $pem_motorik['power_04'] : ''); ?>" /></td>
						<td><input type="text" name="power_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['power_05'])) ? $pem_motorik['power_05'] : ''); ?>" /></td>
						<td><input type="text" name="power_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['power_06'])) ? $pem_motorik['power_06'] : ''); ?>" /></td>
						<td><input type="text" name="power_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['power_ket'])) ? $pem_motorik['power_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Lateral inch</td>
						<td><input type="text" name="lateral_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['lateral_01'])) ? $pem_motorik['lateral_01'] : ''); ?>" /></td>
						<td><input type="text" name="lateral_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['lateral_02'])) ? $pem_motorik['lateral_02'] : ''); ?>" /></td>
						<td><input type="text" name="lateral_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['lateral_03'])) ? $pem_motorik['lateral_03'] : ''); ?>" /></td>
						<td><input type="text" name="lateral_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['lateral_04'])) ? $pem_motorik['lateral_04'] : ''); ?>" /></td>
						<td><input type="text" name="lateral_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['lateral_05'])) ? $pem_motorik['lateral_05'] : ''); ?>" /></td>
						<td><input type="text" name="lateral_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['lateral_06'])) ? $pem_motorik['lateral_06'] : ''); ?>" /></td>
						<td><input type="text" name="lateral_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['lateral_ket'])) ? $pem_motorik['lateral_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Pad to pad</td>
						<td><input type="text" name="pad_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['pad_01'])) ? $pem_motorik['pad_01'] : ''); ?>" /></td>
						<td><input type="text" name="pad_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['pad_02'])) ? $pem_motorik['pad_02'] : ''); ?>" /></td>
						<td><input type="text" name="pad_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['pad_03'])) ? $pem_motorik['pad_03'] : ''); ?>" /></td>
						<td><input type="text" name="pad_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['pad_04'])) ? $pem_motorik['pad_04'] : ''); ?>" /></td>
						<td><input type="text" name="pad_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['pad_05'])) ? $pem_motorik['pad_05'] : ''); ?>" /></td>
						<td><input type="text" name="pad_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['pad_06'])) ? $pem_motorik['pad_06'] : ''); ?>" /></td>
						<td><input type="text" name="pad_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['pad_ket'])) ? $pem_motorik['pad_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Three jaw chuck</td>
						<td><input type="text" name="three_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['three_01'])) ? $pem_motorik['three_01'] : ''); ?>" /></td>
						<td><input type="text" name="three_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['three_02'])) ? $pem_motorik['three_02'] : ''); ?>" /></td>
						<td><input type="text" name="three_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['three_03'])) ? $pem_motorik['three_03'] : ''); ?>" /></td>
						<td><input type="text" name="three_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['three_04'])) ? $pem_motorik['three_04'] : ''); ?>" /></td>
						<td><input type="text" name="three_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['three_05'])) ? $pem_motorik['three_05'] : ''); ?>" /></td>
						<td><input type="text" name="three_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['three_06'])) ? $pem_motorik['three_06'] : ''); ?>" /></td>
						<td><input type="text" name="three_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['three_ket'])) ? $pem_motorik['three_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Tip pinch</td>
						<td><input type="text" name="tip_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['tip_01'])) ? $pem_motorik['tip_01'] : ''); ?>" /></td>
						<td><input type="text" name="tip_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['tip_02'])) ? $pem_motorik['tip_02'] : ''); ?>" /></td>
						<td><input type="text" name="tip_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['tip_03'])) ? $pem_motorik['tip_03'] : ''); ?>" /></td>
						<td><input type="text" name="tip_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['tip_04'])) ? $pem_motorik['tip_04'] : ''); ?>" /></td>
						<td><input type="text" name="tip_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['tip_05'])) ? $pem_motorik['tip_05'] : ''); ?>" /></td>
						<td><input type="text" name="tip_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['tip_06'])) ? $pem_motorik['tip_06'] : ''); ?>" /></td>
						<td><input type="text" name="tip_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['tip_ket'])) ? $pem_motorik['tip_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Speherical grasp</td>
						<td><input type="text" name="speherical_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['speherical_01'])) ? $pem_motorik['speherical_01'] : ''); ?>" /></td>
						<td><input type="text" name="speherical_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['speherical_02'])) ? $pem_motorik['speherical_02'] : ''); ?>" /></td>
						<td><input type="text" name="speherical_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['speherical_03'])) ? $pem_motorik['speherical_03'] : ''); ?>" /></td>
						<td><input type="text" name="speherical_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['speherical_04'])) ? $pem_motorik['speherical_04'] : ''); ?>" /></td>
						<td><input type="text" name="speherical_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['speherical_05'])) ? $pem_motorik['speherical_05'] : ''); ?>" /></td>
						<td><input type="text" name="speherical_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['speherical_06'])) ? $pem_motorik['speherical_06'] : ''); ?>" /></td>
						<td><input type="text" name="speherical_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['speherical_ket'])) ? $pem_motorik['speherical_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Cylindrical grasp</td>
						<td><input type="text" name="cylindrical_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['cylindrical_01'])) ? $pem_motorik['cylindrical_01'] : ''); ?>" /></td>
						<td><input type="text" name="cylindrical_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['cylindrical_02'])) ? $pem_motorik['cylindrical_02'] : ''); ?>" /></td>
						<td><input type="text" name="cylindrical_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['cylindrical_03'])) ? $pem_motorik['cylindrical_03'] : ''); ?>" /></td>
						<td><input type="text" name="cylindrical_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['cylindrical_04'])) ? $pem_motorik['cylindrical_04'] : ''); ?>" /></td>
						<td><input type="text" name="cylindrical_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['cylindrical_05'])) ? $pem_motorik['cylindrical_05'] : ''); ?>" /></td>
						<td><input type="text" name="cylindrical_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['cylindrical_06'])) ? $pem_motorik['cylindrical_06'] : ''); ?>" /></td>
						<td><input type="text" name="cylindrical_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['cylindrical_ket'])) ? $pem_motorik['cylindrical_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Disc grasp</td>
						<td><input type="text" name="disc_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['disc_01'])) ? $pem_motorik['disc_01'] : ''); ?>" /></td>
						<td><input type="text" name="disc_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['disc_02'])) ? $pem_motorik['disc_02'] : ''); ?>" /></td>
						<td><input type="text" name="disc_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['disc_03'])) ? $pem_motorik['disc_03'] : ''); ?>" /></td>
						<td><input type="text" name="disc_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['disc_04'])) ? $pem_motorik['disc_04'] : ''); ?>" /></td>
						<td><input type="text" name="disc_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['disc_05'])) ? $pem_motorik['disc_05'] : ''); ?>" /></td>
						<td><input type="text" name="disc_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['disc_06'])) ? $pem_motorik['disc_06'] : ''); ?>" /></td>
						<td><input type="text" name="disc_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['disc_ket'])) ? $pem_motorik['disc_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>c. Manipulasi Tangan</td>
						<td><input type="text" name="manipulasi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['manipulasi_01'])) ? $pem_motorik['manipulasi_01'] : ''); ?>" /></td>
						<td><input type="text" name="manipulasi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['manipulasi_02'])) ? $pem_motorik['manipulasi_02'] : ''); ?>" /></td>
						<td><input type="text" name="manipulasi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['manipulasi_03'])) ? $pem_motorik['manipulasi_03'] : ''); ?>" /></td>
						<td><input type="text" name="manipulasi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['manipulasi_04'])) ? $pem_motorik['manipulasi_04'] : ''); ?>" /></td>
						<td><input type="text" name="manipulasi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['manipulasi_05'])) ? $pem_motorik['manipulasi_05'] : ''); ?>" /></td>
						<td><input type="text" name="manipulasi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['manipulasi_06'])) ? $pem_motorik['manipulasi_06'] : ''); ?>" /></td>
						<td><input type="text" name="manipulasi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['manipulasi_ket'])) ? $pem_motorik['manipulasi_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Memutar</td>
						<td><input type="text" name="memutar_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['memutar_01'])) ? $pem_motorik['memutar_01'] : ''); ?>" /></td>
						<td><input type="text" name="memutar_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['memutar_02'])) ? $pem_motorik['memutar_02'] : ''); ?>" /></td>
						<td><input type="text" name="memutar_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['memutar_03'])) ? $pem_motorik['memutar_03'] : ''); ?>" /></td>
						<td><input type="text" name="memutar_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['memutar_04'])) ? $pem_motorik['memutar_04'] : ''); ?>" /></td>
						<td><input type="text" name="memutar_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['memutar_05'])) ? $pem_motorik['memutar_05'] : ''); ?>" /></td>
						<td><input type="text" name="memutar_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['memutar_06'])) ? $pem_motorik['memutar_06'] : ''); ?>" /></td>
						<td><input type="text" name="memutar_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['memutar_ket'])) ? $pem_motorik['memutar_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Memanipulasi benda</td>
						<td><input type="text" name="benda_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['benda_01'])) ? $pem_motorik['benda_01'] : ''); ?>" /></td>
						<td><input type="text" name="benda_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['benda_02'])) ? $pem_motorik['benda_02'] : ''); ?>" /></td>
						<td><input type="text" name="benda_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['benda_03'])) ? $pem_motorik['benda_03'] : ''); ?>" /></td>
						<td><input type="text" name="benda_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['benda_04'])) ? $pem_motorik['benda_04'] : ''); ?>" /></td>
						<td><input type="text" name="benda_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['benda_05'])) ? $pem_motorik['benda_05'] : ''); ?>" /></td>
						<td><input type="text" name="benda_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['benda_06'])) ? $pem_motorik['benda_06'] : ''); ?>" /></td>
						<td><input type="text" name="benda_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['benda_ket'])) ? $pem_motorik['benda_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>d. Carry</td>
						<td><input type="text" name="carry_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['carry_01'])) ? $pem_motorik['carry_01'] : ''); ?>" /></td>
						<td><input type="text" name="carry_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['carry_02'])) ? $pem_motorik['carry_02'] : ''); ?>" /></td>
						<td><input type="text" name="carry_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['carry_03'])) ? $pem_motorik['carry_03'] : ''); ?>" /></td>
						<td><input type="text" name="carry_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['carry_04'])) ? $pem_motorik['carry_04'] : ''); ?>" /></td>
						<td><input type="text" name="carry_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['carry_05'])) ? $pem_motorik['carry_05'] : ''); ?>" /></td>
						<td><input type="text" name="carry_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['carry_06'])) ? $pem_motorik['carry_06'] : ''); ?>" /></td>
						<td><input type="text" name="carry_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['carry_ket'])) ? $pem_motorik['carry_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>e. Voluntary Release</td>
						<td><input type="text" name="voluntary_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['voluntary_01'])) ? $pem_motorik['voluntary_01'] : ''); ?>" /></td>
						<td><input type="text" name="voluntary_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['voluntary_02'])) ? $pem_motorik['voluntary_02'] : ''); ?>" /></td>
						<td><input type="text" name="voluntary_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['voluntary_03'])) ? $pem_motorik['voluntary_03'] : ''); ?>" /></td>
						<td><input type="text" name="voluntary_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['voluntary_04'])) ? $pem_motorik['voluntary_04'] : ''); ?>" /></td>
						<td><input type="text" name="voluntary_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['voluntary_05'])) ? $pem_motorik['voluntary_05'] : ''); ?>" /></td>
						<td><input type="text" name="voluntary_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['voluntary_06'])) ? $pem_motorik['voluntary_06'] : ''); ?>" /></td>
						<td><input type="text" name="voluntary_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['voluntary_ket'])) ? $pem_motorik['voluntary_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Melepas (sadar)</td>
						<td><input type="text" name="melepas_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['melepas_01'])) ? $pem_motorik['melepas_01'] : ''); ?>" /></td>
						<td><input type="text" name="melepas_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['melepas_02'])) ? $pem_motorik['melepas_02'] : ''); ?>" /></td>
						<td><input type="text" name="melepas_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['melepas_03'])) ? $pem_motorik['melepas_03'] : ''); ?>" /></td>
						<td><input type="text" name="melepas_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['melepas_04'])) ? $pem_motorik['melepas_04'] : ''); ?>" /></td>
						<td><input type="text" name="melepas_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['melepas_05'])) ? $pem_motorik['melepas_05'] : ''); ?>" /></td>
						<td><input type="text" name="melepas_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['melepas_06'])) ? $pem_motorik['melepas_06'] : ''); ?>" /></td>
						<td><input type="text" name="melepas_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['melepas_ket'])) ? $pem_motorik['melepas_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>f. Bilateral Skill</td>
						<td><input type="text" name="bilateral_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['bilateral_01'])) ? $pem_motorik['bilateral_01'] : ''); ?>" /></td>
						<td><input type="text" name="bilateral_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['bilateral_02'])) ? $pem_motorik['bilateral_02'] : ''); ?>" /></td>
						<td><input type="text" name="bilateral_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['bilateral_03'])) ? $pem_motorik['bilateral_03'] : ''); ?>" /></td>
						<td><input type="text" name="bilateral_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['bilateral_04'])) ? $pem_motorik['bilateral_04'] : ''); ?>" /></td>
						<td><input type="text" name="bilateral_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['bilateral_05'])) ? $pem_motorik['bilateral_05'] : ''); ?>" /></td>
						<td><input type="text" name="bilateral_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_motorik['bilateral_06'])) ? $pem_motorik['bilateral_06'] : ''); ?>" /></td>
						<td><input type="text" name="bilateral_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_motorik['bilateral_ket'])) ? $pem_motorik['bilateral_ket'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>			
		<tr>	
			<td colspan="8">Sensorik dan Kognitif</td>
		</tr>
		<tr>	
			<td colspan="8">
				<table width="100%" class="tableData">
					<tr>
						<th width="30%" align="center"><strong>Aktifitas</strong></th>
						<th width="30%" colspan="6" align="center"><strong>Tanggal / Tinggal Kemampuan (+/-)</strong></th>
						<th width="30%" align="center"><strong>Keterangan</strong></th>
					</tr>
					<tr>
						<td><strong>Kemampuan Fungsi Sensorik</strong></td>
						<td><input type="text" name="sensorik_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['sensorik_01'])) ? $pem_sensorik['sensorik_01'] : ''); ?>" /></td>
						<td><input type="text" name="sensorik_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['sensorik_02'])) ? $pem_sensorik['sensorik_02'] : ''); ?>" /></td>
						<td><input type="text" name="sensorik_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['sensorik_03'])) ? $pem_sensorik['sensorik_03'] : ''); ?>" /></td>
						<td><input type="text" name="sensorik_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['sensorik_04'])) ? $pem_sensorik['sensorik_04'] : ''); ?>" /></td>
						<td><input type="text" name="sensorik_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['sensorik_05'])) ? $pem_sensorik['sensorik_05'] : ''); ?>" /></td>
						<td><input type="text" name="sensorik_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['sensorik_06'])) ? $pem_sensorik['sensorik_06'] : ''); ?>" /></td>
						<td><input type="text" name="sensorik_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['sensorik_ket'])) ? $pem_sensorik['sensorik_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Taktil</td>
						<td><input type="text" name="taktil_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['taktil_01'])) ? $pem_sensorik['taktil_01'] : ''); ?>" /></td>
						<td><input type="text" name="taktil_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['taktil_02'])) ? $pem_sensorik['taktil_02'] : ''); ?>" /></td>
						<td><input type="text" name="taktil_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['taktil_03'])) ? $pem_sensorik['taktil_03'] : ''); ?>" /></td>
						<td><input type="text" name="taktil_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['taktil_04'])) ? $pem_sensorik['taktil_04'] : ''); ?>" /></td>
						<td><input type="text" name="taktil_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['taktil_05'])) ? $pem_sensorik['taktil_05'] : ''); ?>" /></td>
						<td><input type="text" name="taktil_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['taktil_06'])) ? $pem_sensorik['taktil_06'] : ''); ?>" /></td>
						<td><input type="text" name="taktil_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['taktil_ket'])) ? $pem_sensorik['taktil_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Stereogonis</td>
						<td><input type="text" name="stereogonis_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['stereogonis_01'])) ? $pem_sensorik['stereogonis_01'] : ''); ?>" /></td>
						<td><input type="text" name="stereogonis_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['stereogonis_02'])) ? $pem_sensorik['stereogonis_02'] : ''); ?>" /></td>
						<td><input type="text" name="stereogonis_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['stereogonis_03'])) ? $pem_sensorik['stereogonis_03'] : ''); ?>" /></td>
						<td><input type="text" name="stereogonis_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['stereogonis_04'])) ? $pem_sensorik['stereogonis_04'] : ''); ?>" /></td>
						<td><input type="text" name="stereogonis_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['stereogonis_05'])) ? $pem_sensorik['stereogonis_05'] : ''); ?>" /></td>
						<td><input type="text" name="stereogonis_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['stereogonis_06'])) ? $pem_sensorik['stereogonis_06'] : ''); ?>" /></td>
						<td><input type="text" name="stereogonis_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['stereogonis_ket'])) ? $pem_sensorik['stereogonis_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td><strong>Kemampuan Fungsi Kognitif</strong></td>
						<td><input type="text" name="kognitif_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['kognitif_01'])) ? $pem_sensorik['kognitif_01'] : ''); ?>" /></td>
						<td><input type="text" name="kognitif_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['kognitif_02'])) ? $pem_sensorik['kognitif_02'] : ''); ?>" /></td>
						<td><input type="text" name="kognitif_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['kognitif_03'])) ? $pem_sensorik['kognitif_03'] : ''); ?>" /></td>
						<td><input type="text" name="kognitif_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['kognitif_04'])) ? $pem_sensorik['kognitif_04'] : ''); ?>" /></td>
						<td><input type="text" name="kognitif_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['kognitif_05'])) ? $pem_sensorik['kognitif_05'] : ''); ?>" /></td>
						<td><input type="text" name="kognitif_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['kognitif_06'])) ? $pem_sensorik['kognitif_06'] : ''); ?>" /></td>
						<td><input type="text" name="kognitif_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['kognitif_ket'])) ? $pem_sensorik['kognitif_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Motivasi</td>
						<td><input type="text" name="motivasi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['motivasi_01'])) ? $pem_sensorik['motivasi_01'] : ''); ?>" /></td>
						<td><input type="text" name="motivasi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['motivasi_02'])) ? $pem_sensorik['motivasi_02'] : ''); ?>" /></td>
						<td><input type="text" name="motivasi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['motivasi_03'])) ? $pem_sensorik['motivasi_03'] : ''); ?>" /></td>
						<td><input type="text" name="motivasi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['motivasi_04'])) ? $pem_sensorik['motivasi_04'] : ''); ?>" /></td>
						<td><input type="text" name="motivasi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['motivasi_05'])) ? $pem_sensorik['motivasi_05'] : ''); ?>" /></td>
						<td><input type="text" name="motivasi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['motivasi_06'])) ? $pem_sensorik['motivasi_06'] : ''); ?>" /></td>
						<td><input type="text" name="motivasi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['motivasi_ket'])) ? $pem_sensorik['motivasi_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Atensi</td>
						<td><input type="text" name="atensi_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['atensi_01'])) ? $pem_sensorik['atensi_01'] : ''); ?>" /></td>
						<td><input type="text" name="atensi_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['atensi_02'])) ? $pem_sensorik['atensi_02'] : ''); ?>" /></td>
						<td><input type="text" name="atensi_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['atensi_03'])) ? $pem_sensorik['atensi_03'] : ''); ?>" /></td>
						<td><input type="text" name="atensi_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['atensi_04'])) ? $pem_sensorik['atensi_04'] : ''); ?>" /></td>
						<td><input type="text" name="atensi_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['atensi_05'])) ? $pem_sensorik['atensi_05'] : ''); ?>" /></td>
						<td><input type="text" name="atensi_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['atensi_06'])) ? $pem_sensorik['atensi_06'] : ''); ?>" /></td>
						<td><input type="text" name="atensi_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['atensi_ket'])) ? $pem_sensorik['atensi_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Problem Solving</td>
						<td><input type="text" name="problem_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['problem_01'])) ? $pem_sensorik['problem_01'] : ''); ?>" /></td>
						<td><input type="text" name="problem_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['problem_02'])) ? $pem_sensorik['problem_02'] : ''); ?>" /></td>
						<td><input type="text" name="problem_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['problem_03'])) ? $pem_sensorik['problem_03'] : ''); ?>" /></td>
						<td><input type="text" name="problem_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['problem_04'])) ? $pem_sensorik['problem_04'] : ''); ?>" /></td>
						<td><input type="text" name="problem_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['problem_05'])) ? $pem_sensorik['problem_05'] : ''); ?>" /></td>
						<td><input type="text" name="problem_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['problem_06'])) ? $pem_sensorik['problem_06'] : ''); ?>" /></td>
						<td><input type="text" name="problem_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['problem_ket'])) ? $pem_sensorik['problem_ket'] : ''); ?>" /></td>
					</tr>
					<tr>
						<td>&nbsp;- Rentang Atensi</td>
						<td><input type="text" name="rentang_01" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['rentang_01'])) ? $pem_sensorik['rentang_01'] : ''); ?>" /></td>
						<td><input type="text" name="rentang_02" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['rentang_02'])) ? $pem_sensorik['rentang_02'] : ''); ?>" /></td>
						<td><input type="text" name="rentang_03" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['rentang_03'])) ? $pem_sensorik['rentang_03'] : ''); ?>" /></td>
						<td><input type="text" name="rentang_04" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['rentang_04'])) ? $pem_sensorik['rentang_04'] : ''); ?>" /></td>
						<td><input type="text" name="rentang_05" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['rentang_05'])) ? $pem_sensorik['rentang_05'] : ''); ?>" /></td>
						<td><input type="text" name="rentang_06" class="text_dt" style="width:100px;" value="<?php echo ((isset($pem_sensorik['rentang_06'])) ? $pem_sensorik['rentang_06'] : ''); ?>" /></td>
						<td><input type="text" name="rentang_ket" class="text_dt" style="width:200px;" value="<?php echo ((isset($pem_sensorik['rentang_ket'])) ? $pem_sensorik['rentang_ket'] : ''); ?>" /></td>
					</tr>
				</table>
			</td>
		</tr>
        <tr>
            <td colspan="8">&nbsp;</td>
        </tr>
		<tr>
			<td colspan="8">INTERVENSI OKUPASI TERAPI</td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" colspan="7">Tujuan Terapi</td>
		</tr>	
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;- Jangka Panjang</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="intenvensi_jp" class="text_dt10" ><?php echo ((isset($intervensi['intenvensi_jp'])) ? $intervensi['intenvensi_jp'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td width="40px">&nbsp;</td>
			<td valign="top" width="220px">&nbsp;- Jangka Pendek</td>
			<td valign="top" width="10px">:</td>
			<td colspan="5"><textarea name="intenvensi_jk" class="text_dt10" ><?php echo ((isset($intervensi['intenvensi_jk'])) ? $intervensi['intenvensi_jk'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Alat Bantu</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="intenvensi_ab" class="text_dt10" ><?php echo ((isset($intervensi['intenvensi_ab'])) ? $intervensi['intenvensi_ab'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td valign="top" >Adaptasi Aktifitas</td>
			<td valign="top">:</td>
			<td colspan="5"><textarea name="intenvensi_aa" class="text_dt10" ><?php echo ((isset($intervensi['intenvensi_aa'])) ? $intervensi['intenvensi_aa'] : ''); ?></textarea></td>
		</tr>
		<tr>
			<td colspan="8">&nbsp;</td>
		</tr>
        <tr><td colspan="8" align="right" >
			<?php if($irja_final == ''){ ?>
			<input type="button" value="simpan" onclick="simpan();" class="myButton1" />
			<?php if(!empty($idx)){ 
				$sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $idx . '"
						AND JENIS_DOKUMEN_ID = "26"
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
function simpan(){
	_haschange = false;
	$('#formperiksa').submit();
}	
</script>