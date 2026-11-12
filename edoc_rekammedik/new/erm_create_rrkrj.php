<?php
function replace_newline($str){
	$ret = htmlspecialchars(trim($str));
	$ret = preg_replace('/\r|\n/','\n',$ret);
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_create_rrkrj($id,$nomr){
	global $rmfile_path;
	$arr_aturan_pakai = getResepAturanPakai();
	$arr_satuan_resep = getResepSatuan();
	$arr_waktu_pakai = getResepWaktuPakai();
	$arr_nama_racikan = getResepNamaRacikan();

	$templaterrkrj = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\rrkrj.docx');
	//PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);  
	
	$qry_rrkrj = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
			m_pasien.NAMA_PASIEN,m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NAMA_IBU,
			m_pasien.NAMA_AYAH,m_pasien.TMP_LAHIR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
			m_agama.NAMA_AGAMA,m_pasien.PEKERJAAN,
			m_pasien.ALAMAT,m_pasien.ALAMAT_RT,
			m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			m_pasien.JNS_KELAMIN,m_pasien.ST_KAWIN,
			m_asal_pasien.KET_ASAL_PASIEN,t_irja.P_JAWAB_NAMA,
			m_pasien.NO_TELEPON,m_pasien.PENDIDIKAN_ID
			FROM t_irja
			INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
			LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			LEFT JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
			WHERE t_irja.IRJA_ID = "' . $id . '"';
	$get_rrkrj = mysql_query($qry_rrkrj) or die(mysql_error());
	$dat_rrkrj = mysql_fetch_assoc($get_rrkrj);
	
	$templaterrkrj->setValue('nomor_mr', formatNoMR($dat_rrkrj['NOMR']));
	$templaterrkrj->setValue('tanggal_kunjungan', $dat_rrkrj['TANGGAL_DAFTAR']);
	$templaterrkrj->setValue('nama_pasien', htmlspecialchars(strtoupper($dat_rrkrj['NAMA_PASIEN'])));
	$nama_ayah_suami = $dat_rrkrj['NAMA_AYAH'];
	if($nama_ayah_suami != '') {
		$nama_ayah_suami .= '/' . $dat_rrkrj['NAMA_SUAMI_ISTERI']; 
	}else{
		$nama_ayah_suami = $dat_rrkrj['NAMA_SUAMI_ISTERI'];
	}	
	$templaterrkrj->setValue('nama_ayah_suami', htmlspecialchars(strtoupper($nama_ayah_suami)));
	$templaterrkrj->setValue('tempat_lahir', htmlspecialchars(strtoupper($dat_rrkrj['TMP_LAHIR'])));
	$templaterrkrj->setValue('tgl_lahir', $dat_rrkrj['TGL_LAHIR']);
	$templaterrkrj->setValue('agama', strtoupper($dat_rrkrj['NAMA_AGAMA']));
	$templaterrkrj->setValue('nama_ibu', htmlspecialchars(strtoupper($dat_rrkrj['NAMA_IBU'])));
	$templaterrkrj->setValue('nama_ayah', htmlspecialchars(strtoupper($dat_rrkrj['NAMA_AYAH'])));
	$templaterrkrj->setValue('pekerjaan', htmlspecialchars(strtoupper($dat_rrkrj['PEKERJAAN'])));
	$templaterrkrj->setValue('jenis_kelamin', strtoupper(jenisKelamin($dat_rrkrj['JNS_KELAMIN'])));
	$templaterrkrj->setValue('status_perkawinan', strtoupper(statusKawin($dat_rrkrj['ST_KAWIN'])));
	$templaterrkrj->setValue('pendidikan', strtoupper(jenPendidikan($dat_rrkrj['PENDIDIKAN_ID'])));
	$templaterrkrj->setValue('alamat', htmlspecialchars(strtoupper($dat_rrkrj['ALAMAT'])));
	$templaterrkrj->setValue('rtrw', htmlspecialchars(strtoupper($dat_rrkrj['ALAMAT_RT'] . '/' . $dat_rrkrj['ALAMAT_RW'])));
	$templaterrkrj->setValue('kelurahan', htmlspecialchars(strtoupper($dat_rrkrj['NAMA_KELURAHAN'])));
	$templaterrkrj->setValue('kecamatan', htmlspecialchars(strtoupper($dat_rrkrj['NAMA_KECAMATAN'])));
	$templaterrkrj->setValue('kabupaten', htmlspecialchars(strtoupper($dat_rrkrj['NAMA_KOTA'])));
	$templaterrkrj->setValue('dikirim_oleh', htmlspecialchars(strtoupper($dat_rrkrj['KET_ASAL_PASIEN'])));
	$templaterrkrj->setValue('penanggung_jawab', htmlspecialchars(strtoupper($dat_rrkrj['P_JAWAB_NAMA'])));
	$templaterrkrj->setValue('telepon', htmlspecialchars(strtoupper($dat_rrkrj['NO_TELEPON'])));
	
	$qry_alergi = 'SELECT t_irja.IRJA_ID,t_irja_alergi.ALERGI
				FROM t_irja
				INNER JOIN t_irja_alergi ON (t_irja.IRJA_ID = t_irja_alergi.IRJA_ID)
				WHERE t_irja.NOMR = "' . $nomr . '"
				AND t_irja.ST_BATAL IS NULL
				AND t_irja.NO_PENDAFTARAN IS NOT NULL
				ORDER BY t_irja.IRJA_ID DESC LIMIT 1';
	$get_alergi = mysql_query($qry_alergi) or die(mysql_error());
	$dat_alergi = mysql_fetch_assoc($get_alergi);	
	
	$qry_ranap = 'SELECT DATE_FORMAT(t_irna.PASIEN_MASUK,"%d-%m-%Y") AS MASUK,
				DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d-%m-%Y") AS KELUAR
				FROM t_irna
				WHERE t_irna.NOMR = "' . $nomr . '"
				AND t_irna.ST_BATAL IS NULL
				AND t_irna.NO_PENDAFTARAN IS NOT NULL
				AND t_irna.PASIEN_MASUK IS NOT NULL';
	$get_ranap = mysql_query($qry_ranap) or die(mysql_error());
	$p_ranap = '';
	while($dat_ranap = mysql_fetch_array($get_ranap)){
		$p_ranap .= $dat_ranap['MASUK'] . ' - ' . $dat_ranap['KELUAR'] . '<br>';
	}		
	$p_ranap = substr($p_ranap,0,strlen($p_ranap)-4);
	
	$qry_operasi = 'SELECT DATE_FORMAT(t_operasi.TANGGAL_OPERASI,"%d-%m-%Y") AS OPERASI
				FROM t_irna
				INNER JOIN t_operasi ON (t_irna.IRNA_ID = t_operasi.RAWAT_ID)
				WHERE t_irna.NOMR = "' . $nomr . '"
				AND t_irna.ST_BATAL IS NULL
				AND t_operasi.ST_BATAL IS NULL
				AND t_operasi.ST_APPROVE = "1"
				AND t_irna.NO_PENDAFTARAN IS NOT NULL
				AND t_operasi.TANGGAL_OPERASI IS NOT NULL';
	$get_operasi = mysql_query($qry_operasi) or die(mysql_error());
	$p_operasi = '';
	while($dat_operasi = mysql_fetch_array($get_operasi)){
		$p_operasi .= $dat_operasi['OPERASI'] . '<br>';
	}		
	$p_operasi = substr($p_operasi,0,strlen($p_operasi)-4);
	
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($p_operasi);
	$templaterrkrj->setValue('riwayat_operasi', $toOpenXML);
	$templaterrkrj->setValue('riwayat_alergi_obat', $dat_alergi['ALERGI']);
	$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($p_ranap);
	$templaterrkrj->setValue('riwayat_rawat_inap', $toOpenXML);
	
	$qry_rj = 'SELECT t_irja.IRJA_ID,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT,GROUP_CONCAT(DISTINCT t_irja_diagnosa.DIAGNOSA ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER SEPARATOR " -") AS DIAGNOSA,
				GROUP_CONCAT(DISTINCT CASE WHEN t_irja_diagnosa.ICD_CODE = "" OR t_irja_diagnosa.ICD_CODE IS NULL
						THEN "-" ELSE t_irja_diagnosa.ICD_CODE END ORDER BY t_irja_diagnosa.DIAGNOSA_ORDER SEPARATOR " -") AS ICD_CODE_9,
				GROUP_CONCAT(DISTINCT CASE WHEN m_tarif.KODE_TARIF_GROUP NOT IN ("01","02","09","92","93")
							THEN m_tarif.NAMA_TARIF END SEPARATOR "||") AS TINDAKAN,
				GROUP_CONCAT(DISTINCT CASE WHEN m_tarif.KODE_TARIF_GROUP NOT IN ("01","02","09","92","93")
								THEN 
									CASE WHEN t_irja_tarif.ICD_CODE = "" OR t_irja_tarif.ICD_CODE IS NULL
										THEN "-" ELSE t_irja_tarif.ICD_CODE END
							END) AS ICD_CODE_10,		
				m_pegawai.NAMA_PEGAWAI		
				FROM t_irja
				LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID
					AND t_irja_diagnosa.DIAGNOSA_ORDER <= 3 AND t_irja_diagnosa.DIAGNOSA IS NOT NULL
					AND t_irja_diagnosa.DIAGNOSA <> "")
				LEFT JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID
					AND t_irja_tarif.NO_TARIF IS NOT NULL 
					AND t_irja_tarif.ST_BAYAR <> "Batal"
					AND t_irja.ST_BATAL IS NULL)
				LEFT JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)	
				WHERE t_irja.NOMR = "' . $nomr . '"
				AND t_irja.ST_BATAL IS NULL
				AND t_irja.NO_PENDAFTARAN IS NOT NULL
				GROUP BY t_irja.IRJA_ID
				ORDER BY t_irja.IRJA_ID';
	$get_rj = mysql_query($qry_rj) or die(mysql_error());	
	if(mysql_num_rows($get_rj) > 0){
			$templaterrkrj->cloneRow('tgl_row', mysql_num_rows($get_rj));
			$l = 0;
			while($dat_rj = mysql_fetch_array($get_rj)){
				$templaterrkrj->setValue('tgl_row#' . ($l + 1), $dat_rj['TANGGAL_DAFTAR']);	 
				$templaterrkrj->setValue('klinik#' . ($l + 1), htmlspecialchars($dat_rj['NAMA_UNIT']));
				$templaterrkrj->setValue('diagnosa#' . ($l + 1), htmlspecialchars($dat_rj['DIAGNOSA']));
				$templaterrkrj->setValue('icd10#' . ($l + 1), htmlspecialchars($dat_rj['ICD_CODE_9']));
				
				$tindakan = '';
				if($dat_rj['TINDAKAN'] != ''){
					$tindakan = 'Tindakan : \n';
					$arr_tindakan = explode('||',$dat_rj['TINDAKAN']);
					for($i=0;$i < sizeof($arr_tindakan); $i++){
						$tindakan .= '- ' . $arr_tindakan[$i] . ' \n ';
					}		
				}
				
				//resep
				$v_resep = '';
				$sql_resep_m = 'SELECT DISTINCT t_irja_resep.NO_RESEP
					FROM t_irja_resep
					WHERE t_irja_resep.IRJA_ID = "' . $dat_rj['IRJA_ID'] . '" 
					AND t_irja_resep.RESEP IS NOT NULL
					ORDER BY t_irja_resep.NO_RESEP';
				$get_resep_m = mysql_query($sql_resep_m) or die(mysql_error());	
				if(mysql_num_rows($get_resep_m) > 0) $v_resep = 'Resep : \n'; 	
				while($dat_resep_m = mysql_fetch_array($get_resep_m)){
					$v_resep .= 'R/ \n';
					//non racikan
					$sql_resep = 'SELECT t_irja_resep.IRJA_ID,t_irja_resep.IRJA_RESEP_ID,
								t_irja_resep.RESEP,t_irja_resep.RACIKAN,t_irja_resep.GENERIK,
								t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
								t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,t_irja_resep.FORMULARIUM_NASIONAL,
								t_irja_resep.JUMLAH_KELUAR,t_irja_resep.SATUAN_DOSIS,t_irja_resep.WAKTU_PAKAI
								FROM t_irja_resep
								WHERE t_irja_resep.IRJA_ID = "' . $dat_rj['IRJA_ID'] . '" 
								AND t_irja_resep.NO_RESEP = "' . $dat_resep_m['NO_RESEP'] . '"
								AND (t_irja_resep.RACIKAN IS NULL OR t_irja_resep.RACIKAN = "")';
					$get_resep = mysql_query($sql_resep);
					while ($dat_resep = mysql_fetch_array($get_resep)) {
						$resep = '- ' . $dat_resep['RESEP'];
						$v_resep .= $resep . ' ' . $dat_resep['JUMLAH'] . ' ' . $dat_resep['SATUAN'];
							
						$arr_atp = explode('|',$dat_resep['DOSIS']);
						$atp = '';
						foreach($arr_atp as $row){
							if(is_numeric($row)){
								$atp .= $arr_aturan_pakai[$row] . ',';
							}else{
								$atp .= $row . ',';
							}
						}
						$v_resep .= ' ' . substr($atp,0,strlen($atp)-1);
										
						$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
						$str = '';
						foreach($arr_str as $row){
							if(is_numeric($row)){
								$str .= $arr_satuan_resep[$row] . ',';
							}else{
								$str .= $row . ',';
							}
						}
						$v_resep .= ' ' . substr($str,0,strlen($str)-1);
								
						$arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
						$wkp = '';
						foreach($arr_wkp as $row){
							if(is_numeric($row)){
								$wkp .= $arr_waktu_pakai[$row] . ',';
							}else{
								$wkp .= $row . ',';
							}
						}
						$wkp = substr($wkp,0,strlen($wkp)-1);
						$v_resep .= ' ' . str_replace('Bila perlu,','Bila perlu ',$wkp); 
						$v_resep .= ' \n';
					}
					
					//racikan
					$sql_resep = 'SELECT DISTINCT t_irja_resep.IRJA_RESEP_ID,t_irja_resep.RESEP,t_irja_resep.DOSIS,
								t_irja_resep.JUMLAH,t_irja_resep.SATUAN,t_irja_resep.SATUAN_DOSIS,t_irja_resep.WAKTU_PAKAI
								FROM t_irja_resep
								WHERE t_irja_resep.IRJA_ID = "' . $dat_rj['IRJA_ID'] . '" 
								AND t_irja_resep.NO_RESEP = "' . $dat_resep_m['NO_RESEP'] . '"
								AND t_irja_resep.RACIKAN = "1"';
					$get_resep = mysql_query($sql_resep);
					while ($dat_resep = mysql_fetch_array($get_resep)) {
						$resep = '- ';
						$arr_nmr = explode('|',$dat_resep['RESEP']);
						foreach($arr_nmr as $row){
							if(is_numeric($row)){
								$resep .= $arr_nama_racikan[$row] . ' ';
							}else{
								$resep .= $row . ' ';
							}
						}
						$resep = substr($resep,0,strlen($resep)-1); 
							
						$v_resep .= $resep . ' ' . $dat_resep['JUMLAH'] . ' ' . $dat_resep['SATUAN'];
							
						$arr_atp = explode('|',$dat_resep['DOSIS']);
						$atp = '';
						foreach($arr_atp as $row){
							if(is_numeric($row)){
								$atp .= $arr_aturan_pakai[$row] . ',';
							}else{
								$atp .= $row . ',';
							}
						}
						$v_resep .= ' ' . substr($atp,0,strlen($atp)-1);
										
						$arr_str = explode('|',$dat_resep['SATUAN_DOSIS']);
						$str = '';
						foreach($arr_str as $row){
							if(is_numeric($row)){
								$str .= $arr_satuan_resep[$row] . ',';
							}else{
								$str .= $row . ',';
							}
						}
						$v_resep .= ' ' . substr($str,0,strlen($str)-1);
								
						$arr_wkp = explode('|',$dat_resep['WAKTU_PAKAI']);
						$wkp = '';
						foreach($arr_wkp as $row){
							if(is_numeric($row)){
								$wkp .= $arr_waktu_pakai[$row] . ',';
							}else{
								$wkp .= $row . ',';
							}
						}
						$wkp = substr($wkp,0,strlen($wkp)-1);
						$v_resep .= ' ' . str_replace('Bila perlu,','Bila perlu ',$wkp); 
						$v_resep .= ' \n';
						
						$sql_resep_racikan = 'SELECT DISTINCT t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH,
								t_irja_resep_racikan.SATUAN
								FROM t_irja_resep_racikan
								WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $dat_resep['IRJA_RESEP_ID'] . '"';
						$get_resep_racikan = mysql_query($sql_resep_racikan) or die(mysql_error());		
						if(mysql_num_rows($get_resep_racikan) >0){
							$v_resep .= '(';
							while($dat_resep_racikan= mysql_fetch_array($get_resep_racikan)){
								$v_resep .= $dat_resep_racikan['RESEP'] . ' ' . $dat_resep_racikan['JUMLAH'] . ' ' . $dat_resep_racikan['SATUAN'] . ', ';
							}
							$v_resep = substr($v_resep,0,strlen($v_resep) - 2);
							$v_resep .= ')';
						}	
					}
				}		
				if($v_resep != '') $tindakan .= $v_resep;
				//end resep
				
				$tindakan = replace_newline($tindakan);
				$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($tindakan);
				$templaterrkrj->setValue('tindakan#' . ($l + 1), $toOpenXML);
				$templaterrkrj->setValue('icd9cm#' . ($l + 1), htmlspecialchars($dat_rj['ICD_CODE_10']));
				$templaterrkrj->setValue('kode_dokter#' . ($l + 1), htmlspecialchars($dat_rj['NAMA_PEGAWAI']));
				$l = $l + 1;
			}	
	}else{
		$templaterrkrj->setValue('tgl_row', '');	
		$templaterrkrj->setValue('klinik', '');	
		$templaterrkrj->setValue('diagnosa', '');	
		$templaterrkrj->setValue('icd10', '');
		$templaterrkrj->setValue('tindakan', '');
		$templaterrkrj->setValue('icd9cm', '');
		$templaterrkrj->setValue('kode_dokter', '');
	}
		
	if(!file_exists($rmfile_path . '/pdf/1/' . $nomr . '/' . $id)){
		@mkdir($rmfile_path . '/pdf/1/' . $nomr . '/' . $id, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/1/' . $nomr . '/' . $id)){
		@mkdir($rmfile_path . '/doc/1/' . $nomr . '/' . $id, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $id . '_2';	
	$templaterrkrj->saveAs($rmfile_path . '/doc/1/' . $nomr . '/' . $id . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE NOMR = "' . $nomr . '"
				AND RAWAT_ID = "' . $id . '"
				AND JNS_PERAWATAN = "1"
				AND JENIS_DOKUMEN_ID = "2"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,TANGGAL) 		
				VALUES("2","' . $nomr . '","' . $id . '","1","' . $nama_file . '.pdf","1",STR_TO_DATE("' . $dat_rrkrj['TANGGAL_DAFTAR'] . '","%d-%m-%Y"))') or die(mysql_error());		
	
	$source_file = $rmfile_path . '/doc/1/' . $nomr . '/' . $id . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/1/' . $nomr . '/' . $id . '/' . $nama_file . '.pdf';
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