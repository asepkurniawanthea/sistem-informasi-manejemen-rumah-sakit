<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_pengkajian_awal_medis_anak($idx,$ls_assesment='',$tgl_skr='',$final=''){
	global $rmfile_path, $app_path;

	$checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
    $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\pengkajian_awal_medis_anak.docx');
	
	$qry_pasien = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,t_irna.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,t_irna.RUANG_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irna.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				CONCAT(m_ruang.NAMA_RUANG," KELAS ",m_ruang.KELAS_RAWAT) AS NAMA_RUANG
				FROM t_irna
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $idx . '"';
	$get_pasien = mysql_query($qry_pasien);
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);
	$alamat = $dat_pasien['ALAMAT'];
	$nik = $dat_pasien['NIK'];
	$jns_pembayaran = $dat_pasien['NAMA_JAMINAN'];
	$jenis_bayar_id = $dat_pasien['JENIS_BAYAR_ID'];

	$irja_id = $dat_pasien['IRNA_ID'];
	$pegawai_id = $dat_pasien['PEGAWAI_ID'];
	//$asal_pasien_id = $dat_pasien['ASAL_PASIEN_ID'];
	//$ket_asal_pasien = $dat_pasien['KET_ASAL_PASIEN'];
	$pasien_masuk = $dat_pasien['PASIEN_MASUK'];

	$no_telepon = $dat_pasien['NO_TELEPON'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	$nama_unit = $dat_pasien['NAMA_RUANG'];
	$nama_dokter = $dat_pasien['NAMA_PEGAWAI'];

	$umur = getUmurDaftar($tgl_lahir,$tgl_daftar);
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	$templateklinik->setValue('tgl_masuk', $pasien_masuk);
	$templateklinik->setValue('nama_dokter', htmlspecialchars($nama_dokter));
	
	$qry_pengkajian = 'SELECT IRNA_ID,NAMA_AYAH,NAMA_IBU,PEKERJAAN_AYAH,PEKERJAAN_IBU,PENDIDIKAN_AYAH,PENDIDIKAN_IBU,
            UMUR_AYAH,UMUR_IBU,ALAMAT,KELUHAN_UTAMA,RIWAYAT_PENY_SKRG,RIWAYAT_PENY_DAHULU,RIWAYAT_PENY_KELUARGA,RIWAYAT_PRIBADI,RIWAYAT_KEHAMILAN_KELAHIRAN,
            RIWAYAT_MAKANAN,PERKEMBANGAN_KEPANDAIAN,VAKSINASI,TANDA_UTAMA,NADI,SUHU_BADAN,PERNAPASAN,BERAT_BADAN,UBUN_BESAR,KESIMPULAN_GIZI,KELENJAR_LIMPA,
            LEHER,DADA,JANTUNG,PARU_PARU,PERUT,HATI,LIMPA_ANOGENITAL,EKTERMITAS,
            GERAKAN,TONUS,TROFI,CLONUS,REFLEKS_FISILOGIS,REFLEKS_PATOLOGIS,KEPALA,
            MATA,HIDUNG,TELINGA,MULUT,PHARING,GIGI,PEMERIKSAAN_LAB,PEMERIKSAAN_RAD,
            RENCANA_TATALAKSANA,FINAL,REGISTER,DATE_FORMAT(TGL_ASSESMENT,"%d/%m/%Y") AS TGL_ASSESMENT,
            PEGAWAI_ID,DATE_FORMAT(NOW(),"%d/%m/%Y") AS TGL_SKR,DATE_FORMAT(TGL_ASSESMENT,"%d-%m-%Y %H:%i") AS REGISTER_DT
            NAMA_PEGAWAI
			FROM t_irna_pengkajian_awal_medis_anak
			INNER JOIN m_pegawai ON (t_irna_pengkajian_awal_medis_anak.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			WHERE IRNA_ID = "' . $idx . '"';
	$get_pengkajian = mysql_query($qry_pengkajian) or die(mysql_error());
	$dat_pengkajian = mysql_fetch_assoc($get_pengkajian);
	$idx = $dat_pengkajian['IRNA_ID'];
	$templateklinik->setValue('tgl_assesment', $dat_pengkajian['TGL_REGISTER_DT']);
	$templateklinik->setValue('dicetak_oleh', '');
	$templateklinik->setValue('nama_dokter', htmlspecialchars($dat_pengkajian['NAMA_PEGAWAI']));
    $templateklinik->setvalue('nama_ayah', $dat_pengkajian['NAMA_AYAH']);
    $templateklinik->setValue('nama_ibu', $dat_pengkajian['NAMA_IBU']);
    $templateklinik->setValue('pekerjaan_ayah', $dat_pengkajian['PEKERJAAN_AYAH']);
    $templateklinik->setValue('pekerjaan_ibu', $dat_pengkajian['PEKERJAAN_IBU']);
    $templateklinik->setValue('pendidikan_ayah', $dat_pengkajian['PENDIDIKAN_AYAH']);
    $templateklinik->setValue('pendidikan_ibu', $dat_pengkajian['PENDIDIKAN_IBU']);
    $templateklinik->setValue('umur_ayah', $dat_pengkajian['UMUR_AYAH']);
    $templateklinik->setValue('umur_ibu', $dat_pengkajian['UMUR_IBU']);
    $templateklinik->setValue('alamat_ot', $dat_pengkajian['ALAMAT']);

    $keluhan_utama = $dat_pengkajian['KELUHAN_UTAMA'];
    $keluhan_utama = replace_newline($keluhan_utama);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($keluhan_utama);
	$templateklinik->setValue('keluhan_utama',$toOpenXML);

    $riwayat_skrg = $dat_pengkajian['RIWAYAT_PENY_SKRG'];
    $riwayat_skrg = replace_newline($riwayat_skrg);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_skrg);
    $templateklinik->setValue('riwayat_peny_skrg',$toOpenXML);

    $riwayat_dahulu = $dat_pengkajian['RIWAYAT_PENY_DAHULU'];
    $riwayat_dahulu = replace_newline($riwayat_dahulu);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_dahulu);
    $templateklinik->setValue('riwayat_peny_dahulu',$toOpenXML);

    $riwayat_keluarga = $dat_pengkajian['RIWAYAT_PENY_KELUARGA'];
    $riwayat_keluarga = replace_newline($riwayat_keluarga);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_keluarga);
    $templateklinik->setValue('riwayat_peny_keluarga',$toOpenXML);

    $riwayat_pribadi = $dat_pengkajian['RIWAYAT_PRIBADI'];
    $riwayat_pribadi = replace_newline($riwayat_pribadi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_pribadi);
    $templateklinik->setValue('riwayat_pribadi',$toOpenXML);

    $riwayat_makanan = $dat_pengkajian['RIWAYAT_MAKANAN'];
    $riwayat_makanan = replace_newline($riwayat_makanan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($riwayat_makanan);
    $templateklinik->setValue('riwayat_makanan',$toOpenXML);

    $tanda_utama = $dat_pengkajian['TANDA_UTAMA'];
    $tanda_utama = replace_newline($tanda_utama);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tanda_utama);
    $templateklinik->setValue('tanda_utama',$toOpenXML);

    $kesimpulan_gizi = $dat_pengkajian['KESIMPULAN_GIZI'];
    $kesimpulan_gizi = replace_newline($kesimpulan_gizi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($kesimpulan_gizi);
    $templateklinik->setValue('kesimpulan_gizi',$toOpenXML);

    $kelenjar_limpa = $dat_pengkajian['KELENJAR_LIMPA'];
    $kelenjar_limpa = replace_newline($kelenjar_limpa);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($kelenjar_limpa);
    $templateklinik->setValue('kelenjar_limpa',$toOpenXML);
    
    $leher = $dat_pengkajian['LEHER'];
    $leher = replace_newline($leher);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($leher);
    $templateklinik->setValue('leher',$toOpenXML);

    $dada = $dat_pengkajian['DADA'];
    $dada = replace_newline($dada);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($dada);
    $templateklinik->setValue('dada',$toOpenXML);

    $jantung = $dat_pengkajian['JANTUNG'];
    $dada = replace_newline($jantung);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($jantung);
    $templateklinik->setValue('jantung',$toOpenXML);

    $paru_paru = $dat_pengkajian['PARU_PARU'];
    $paru_paru = replace_newline($paru_paru);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($paru_paru);
    $templateklinik->setValue('paru_paru',$toOpenXML);

    $perut = $dat_pengkajian['PERUT'];
    $perut = replace_newline($perut);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($perut);
    $templateklinik->setValue('perut',$toOpenXML);

    $hati = $dat_pengkajian['hati'];
    $hati = replace_newline($hati);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hati);
    $templateklinik->setValue('hati',$toOpenXML);

    $limpa_anogenital = $dat_pengkajian['LIMPA_ANOGENITAL'];
    $limpa_anogenital = replace_newline($limpa_anogenital);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($limpa_anogenital);
    $templateklinik->setValue('limpa_anogenital',$toOpenXML);

    $ektermitas = $dat_pengkajian['EKTERMITAS'];
    $ektermitas = replace_newline($ektermitas);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($ektermitas);
    $templateklinik->setValue('ektermitas',$toOpenXML);

    $gerakan = $dat_pengkajian['GERAKAN'];
    $gerakan = replace_newline($gerakan);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($gerakan);
    $templateklinik->setValue('gerakan',$toOpenXML);

    $tonus = $dat_pengkajian['TONUS'];
    $tonus = replace_newline($tonus);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tonus);
    $templateklinik->setValue('tonus',$toOpenXML);

    $trofi = $dat_pengkajian['TROFI'];
    $trofi = replace_newline($trofi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($trofi);
    $templateklinik->setValue('trofi',$toOpenXML);

    $clonus = $dat_pengkajian['CLONUS'];
    $clonus = replace_newline($clonus);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($clonus);
    $templateklinik->setValue('clonus',$toOpenXML);

    $refleks_fisilogis = $dat_pengkajian['REFLEKS_FISILOGIS'];
    $refleks_fisilogis = replace_newline($refleks_fisilogis);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($refleks_fisilogis);
    $templateklinik->setValue('refleks_fisilogis',$toOpenXML);

    $refleks_patologis = $dat_pengkajian['REFLEKS_PATOLOGIS'];
    $refleks_patologis = replace_newline($refleks_patologis);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($refleks_patologis);
    $templateklinik->setValue('refleks_patologis',$toOpenXML);

    $mata = $dat_pengkajian['MATA'];
    $mata = replace_newline($mata);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($mata);
    $templateklinik->setValue('mata',$toOpenXML);

    $hidung = $dat_pengkajian['HIDUNG'];
    $hidung = replace_newline($hidung);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hidung);
    $templateklinik->setValue('hidung',$toOpenXML);

    $telinga = $dat_pengkajian['TELINGA'];
    $telinga = replace_newline($telinga);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($telinga);
    $templateklinik->setValue('telinga',$toOpenXML);

    $mulut = $dat_pengkajian['MULUT'];
    $mulut = replace_newline($mulut);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($mulut);
    $templateklinik->setValue('mulut',$toOpenXML);

    $pharing = $dat_pengkajian['PHARING'];
    $pharing = replace_newline($pharing);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pharing);
    $templateklinik->setValue('perut',$toOpenXML);

    $gigi = $dat_pengkajian['GIGI'];
    $gigi = replace_newline($gigi);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($gigi);
    $templateklinik->setValue('gigi',$toOpenXML);

    $pemeriksaan_lab = $dat_pengkajian['PEMERIKSAAN_LAB'];
    $pemeriksaan_lab = replace_newline($pemeriksaan_lab);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_lab);
    $templateklinik->setValue('pemeriksaan_lab',$toOpenXML);

    $pemeriksaan_rad = $dat_pengkajian['PEMERIKSAAN_RAD'];
    $pemeriksaan_rad = replace_newline($pemeriksaan_rad);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($pemeriksaan_rad);
    $templateklinik->setValue('pemeriksaan_rad',$toOpenXML);

    $rencana_tatalaksana = $dat_pengkajian['RENCANA_TATALAKSANA'];
    $rencana_tatalaksana = replace_newline($rencana_tatalaksana);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($rencana_tatalaksana);
    $templateklinik->setValue('rencana_tatalaksana',$toOpenXML);
   

    $riwayat_hamil = str_replace('|','"',$dat_pengkajian['RIWAYAT_KEHAMILAN_KELAHIRAN']);
    $riwayat_hamil = preg_replace('/\r|\n/','\n',trim($riwayat_hamil));
    $riwayat_hamil = json_decode($riwayat_hamil,true);

    $kehamilan = replace_newline($riwayat_hamil['riwayat']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($kehamilan);
	$templateklinik->setValue('riwayat_kehamilan',$toOpenXML);
	$templateklinik->setValue('anc',htmlspecialchars($riwayat_hamil['anc']));
	$templateklinik->setValue('natal_care',htmlspecialchars($riwayat_hamil['natal_care']));
	$templateklinik->setValue('periode_neonatal',htmlspecialchars($riwayat_hamil['periode_neonatal']));

    $perkembangan_kepandaian = str_replace('|','"',$dat_pasien['PERKEMBANGAN_KEPANDAIAN']);
    $perkembangan_kepandaian = preg_replace('/\r|\n/','\n',trim($perkembangan_kepandaian));
    $perkembangan_kepandaian = json_decode($perkembangan_kepandaian,true);
	$templateklinik->setValue('motorik_kasar',htmlspecialchars($perkembangan_kepandaian['motorik_kasar']));
	$templateklinik->setValue('motorik_halus',htmlspecialchars($perkembangan_kepandaian['motorik_halus']));
	$templateklinik->setValue('bicara',htmlspecialchars($perkembangan_kepandaian['bicara']));
	$templateklinik->setValue('sosial',htmlspecialchars($perkembangan_kepandaian['sosial']));

    
    $vaksinasi = str_replace('|','"',$dat_pasien['VAKSINASI']);
    $vaksinasi = preg_replace('/\r|\n/','\n',trim($vaksinasi));
    $vaksinasi = json_decode($vaksinasi,true);
    $vaksin = replace_newline($vaksinasi['vaksinasi']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($vaksin);
	$templateklinik->setValue('vaksinasi',$toOpenXML);
	$templateklinik->setValue('bcg',htmlspecialchars($vaksinasi['bcg']));
	$templateklinik->setValue('hepa_b',htmlspecialchars($vaksinasi['hepatitis_b']));
	$templateklinik->setValue('dpt',htmlspecialchars($vaksinasi['dpt']));
    $templateklinik->setValue('polio',htmlspecialchars($vaksinasi['polio']));
    $templateklinik->setValue('cpk',htmlspecialchars($vaksinasi['campak']));
    $templateklinik->setValue('hib',htmlspecialchars($vaksinasi['hib']));
    $templateklinik->setValue('ipd',htmlspecialchars($vaksinasi['ipd']));
    $templateklinik->setValue('inf',htmlspecialchars($vaksinasi['influenza']));
    $templateklinik->setValue('ccr',htmlspecialchars($vaksinasi['cacar_air']));
    $templateklinik->setValue('mmr',htmlspecialchars($vaksinasi['mmr']));


    $nadi = str_replace('|','"',$dat_pasien['NADI']);
    $nadi = preg_replace('/\r|\n/','\n',trim($nadi));
    $nadi = json_decode($nadi,true);
	$templateklinik->setValue('ir_nadi',htmlspecialchars($nadi['irama_nadi']));
	$templateklinik->setValue('nadi',htmlspecialchars($nadi['nadi']));
	$templateklinik->setValue('tegangan_nadi',htmlspecialchars($nadi['tegangan_nadi']));
	
    $suhu_badan = str_replace('|','"',$dat_pasien['SUHU_BADAN']);
    $suhu_badan = preg_replace('/\r|\n/','\n',trim($suhu_badan));
    $suhu_badan = json_decode($suhu_badan,true);
	$templateklinik->setValue('suhu_b',htmlspecialchars($suhu_badan['suhu_badan']));
	$templateklinik->setValue('tekanan_d',htmlspecialchars($suhu_badan['tekanan_darah']));
	

    $pernapasan = str_replace('|','"',$dat_pasien['PERNAPASAN']);
    $pernapasan = preg_replace('/\r|\n/','\n',trim($pernapasan));
    $pernapasan = json_decode($pernapasan,true);
	$templateklinik->setValue('napas',htmlspecialchars($pernapasan['pernapasan']));
	$templateklinik->setValue('tipe_napas',htmlspecialchars($pernapasan['tipe_pernapasan']));

    $berat_badan = str_replace('|','"',$dat_pasien['BERAT_BADAN']);
    $berat_badan = preg_replace('/\r|\n/','\n',trim($berat_badan));
    $berat_badan = json_decode($berat_badan,true);
	$templateklinik->setValue('berat_b',htmlspecialchars($pernapasan['berat_b']));
	$templateklinik->setValue('tinggi_b',htmlspecialchars($pernapasan['tinggi_b']));
    $templateklinik->setValue('lingkar_kepala',htmlspecialchars($pernapasan['lingkar_kepala']));

    $ubun = str_replace('|','"',$dat_pasien['UBUN_BESAR']);
    $ubun = preg_replace('/\r|\n/','\n',trim($ubun));
    $ubun = json_decode($ubun,true);
	$templateklinik->setValue('uub',htmlspecialchars($ubun['uub']));
	$templateklinik->setValue('lla',htmlspecialchars($ubun['lla']));

    $qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irja_diagnosa
		WHERE IRJA_ID = "' . $idx . '"
		AND DIAGNOSA_ORDER <= 3
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dno', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dno#' . $d,'VI.');
				$templateklinik->setValue('dj#' . $d,':');
				$templateklinik->setValue('dhd#' . $d,'<w:r><w:rPr><w:b/></w:rPr><w:t>Diagnosa</w:t></w:r>');
			}else{
				$templateklinik->setValue('dno#' . $d,'');
				$templateklinik->setValue('dj#' . $d,'');
				$templateklinik->setValue('dhd#' . $d,'');
			}		
		$templateklinik->setValue('dtx#' . $d,'- ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dno','VI.');
		$templateklinik->setValue('dj',':');
		$templateklinik->setValue('dhd','<w:r><w:rPr><w:b/></w:rPr><w:t>Diagnosa</w:t></w:r>');
		$templateklinik->setValue('dtx','');
	}		
/*	
	$qry_diagnosa = 'SELECT DIAGNOSA_ORDER,DIAGNOSA
		FROM t_irja_diagnosa
		WHERE IRJA_ID = "' . $idx . '"
		AND DIAGNOSA_ORDER >= 4
		ORDER BY DIAGNOSA_ORDER';
	$get_diagnosa = mysql_query($qry_diagnosa) or die(mysql_error());
	$j_row = mysql_num_rows($get_diagnosa);
	if($j_row > 0){
		$templateklinik->cloneRow('dni', $j_row);
		$d=1;
		while($dat_diagnosa= mysql_fetch_array($get_diagnosa)){
			if($d==1) {
				$templateklinik->setValue('dni#' . $d,'6.');
				$templateklinik->setValue('dk#' . $d,':');
				$templateklinik->setValue('dhe#' . $d,'<w:r><w:rPr><w:b/></w:rPr><w:t>Diagnosa Banding</w:t></w:r>');
			}else{
				$templateklinik->setValue('dni#' . $d,'');
				$templateklinik->setValue('dk#' . $d,'');
				$templateklinik->setValue('dhe#' . $d,'');
			}		
			$templateklinik->setValue('dty#' . $d,'- ' . htmlspecialchars($dat_diagnosa['DIAGNOSA']));
		$d++;
		}
	}else{
		$templateklinik->setValue('dni','6.');
		$templateklinik->setValue('dk',':');
		$templateklinik->setValue('dhe','<w:r><w:rPr><w:b/></w:rPr><w:t>Diagnosa Banding</w:t></w:r>');
		$templateklinik->setValue('dty','');
	}		
*/	
	
	if(!file_exists($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/pdf/2/' . $nomr . '/' . $idx, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/2/' . $nomr . '/' . $idx)){
		@mkdir($rmfile_path . '/doc/2/' . $nomr . '/' . $idx, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idx . '_70';	
	/*
	if($final == '1' and $ls_assesment != $tgl_skr){
		$qry_rev = 'SELECT COUNT(FILE_ID) + 1 AS REV FROM t_rm_dokumen_file
			WHERE RAWAT_ID = "' . $idx . '"
			AND JNS_PERAWATAN = "1"
			AND JENIS_DOKUMEN_ID = "25"';
		$get_rev = mysql_query($qry_rev) or die(mysql_error());
		$dat_rev = mysql_fetch_assoc($get_rev);
		$nama_file .= '_' . $dat_rev['REV'];	
	}
	*/
	$templateklinik->saveAs($rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $idx . '"
				AND JNS_PERAWATAN = "2"
				AND JENIS_DOKUMEN_ID = "70"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("25","' . $nomr . '","' . $idx . '","2","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/2/' . $nomr . '/' . $idx . '/' . $nama_file . '.pdf';
	$target_file = str_replace('/','\\',$target_file);
	
	try{
		$word = new COM("Word.Application") or die ("Could not initialise Object.");
		$word->Visible = 0;
		$word->DisplayAlerts = 0;
		$word->Documents->Open($source_file,false,true);
		if(file_exists($target_file)){
			unlink($target_file);
		}
		$word->ActiveDocument->ExportAsFixedFormat($target_file, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
		$word->Quit(false);
		unset($word);
	} catch (Exception $e) {
		echo $e;
	}
	
}	
?>