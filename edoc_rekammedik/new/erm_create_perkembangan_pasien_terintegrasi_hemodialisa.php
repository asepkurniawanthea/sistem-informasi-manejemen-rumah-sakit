<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$new_line = htmlspecialchars('<br>');
	$ret = str_replace($new_line,'<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_perkembangan_pasien_terintegrasi_hemodialisa($idx,$jns_order,$idxord){
	global $rmfile_path, $app_path;
	
	$jns_perawatan = '1';
	if($jns_order == 'IRN') $jns_perawatan = '2'; 
	
	$templateklinik = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\catatan_perkembangan_pasien_terintegrasi.docx');
	
	if($jns_order == ''){	
		$qry_pasien = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,t_irja.PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				t_irja.ASAL_PASIEN_ID,t_irja.KET_ASAL_PASIEN,t_irja.UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_irja.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_irja.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				m_unit.NAMA_UNIT
				FROM t_irja
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $idx . '"';
	}else{
		$qry_pasien = 'SELECT t_hemodialisa.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa.NOMR,
				t_hemodialisa.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,m_pegawai.NAMA_PEGAWAI,
				"" AS ASAL_PASIEN_ID,"" AS KET_ASAL_PASIEN,"55" AS UNIT_ID,m_jaminan.NAMA_JAMINAN,
				m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NIK,
				DATE_FORMAT(t_hemodialisa.PASIEN_MASUK,"%d-%m-%Y %H:%i") AS PASIEN_MASUK,t_hemodialisa.JENIS_BAYAR_ID,m_pasien.NO_TELEPON,
				DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
				"Hemodialisa" AS NAMA_UNIT
				FROM t_hemodialisa
				INNER JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
				INNER JOIN m_jaminan ON (t_hemodialisa.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.HEMODIALISA_ID = "' . $idx . '"';
	}			
	$get_pasien = mysql_query($qry_pasien);
	$dat_pasien = mysql_fetch_assoc($get_pasien);
	$nomr = $dat_pasien['NOMR'];
	$nama_pasien = $dat_pasien['NAMA_PASIEN'];
	$tgl_lahir = $dat_pasien['TGL_LAHIR'];
	$jns_kelamin = jenisKelamin($dat_pasien['JNS_KELAMIN']);
	$nama_unit = $dat_pasien['NAMA_UNIT'];
	$tgl_daftar = $dat_pasien['TANGGAL_DAFTAR'];
	
	$templateklinik->setValue('nomor_rm', formatNomr($nomr));
	$templateklinik->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templateklinik->setValue('tgl_lahir', htmlspecialchars($tgl_lahir));
	$templateklinik->setValue('jenis_kelamin', htmlspecialchars($jns_kelamin));
	$templateklinik->setValue('unit', htmlspecialchars($nama_unit));
	
	if($jns_order == ''){
		$qry_perkembangan = 'SELECT IRJA_PERKEMBANGAN_ID,NOMR,UNIT_ID,IRJA_ID,
			DATE_FORMAT(TANGGAL,"%d-%m-%Y %H:%i") AS TANGGAL,PEMBERI_ASUHAN,
			HASIL_ASESMEN,INTRUKSI_PPA,VERIFIKASI_DPJP,REGISTER,
			NAMA_PEGAWAI
			FROM t_irja_perkembangan
			LEFT JOIN m_pegawai ON (t_irja_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
			WHERE NOMR = "' . $nomr . '"
			AND IRJA_ID = "' . $idx . '"';
	}else{
		$qry_perkembangan = 'SELECT HEMODIALISA_PERKEMBANGAN_ID AS IRJA_PERKEMBANGAN_ID,NOMR,UNIT_ID,HEMODIALISA_ID AS IRJA_ID,
			DATE_FORMAT(TANGGAL,"%d-%m-%Y %H:%i") AS TANGGAL,PEMBERI_ASUHAN,
			HASIL_ASESMEN,INTRUKSI_PPA,VERIFIKASI_DPJP,REGISTER,
			NAMA_PEGAWAI
			FROM t_hemodialisa_perkembangan
			LEFT JOIN m_pegawai ON (t_hemodialisa_perkembangan.PEMBERI_ASUHAN = m_pegawai.PEGAWAI_ID)
			WHERE NOMR = "' . $nomr . '"
			AND HEMODIALISA_ID = "' . $idx . '"';
	}		
	$get_perkembangan = mysql_query($qry_perkembangan) or die(mysql_error());
	if(mysql_num_rows($get_perkembangan) > 0){
			$templateklinik->cloneRow('tgl', mysql_num_rows($get_perkembangan));
			$x = 1;
			while($dat_perkembangan = mysql_fetch_array($get_perkembangan)){
				$templateklinik->setValue('tgl#' . $x, htmlspecialchars($dat_perkembangan['TANGGAL']));
				$templateklinik->setValue('asuhan#' . $x, htmlspecialchars($dat_perkembangan['NAMA_PEGAWAI']));
				
				$hasil_asesmen = str_replace('|','"',$dat_perkembangan['HASIL_ASESMEN']);
				$hasil_asesmen = preg_replace('/\r|\n/','\n',trim($hasil_asesmen));
				$hasil_asesmen = json_decode($hasil_asesmen,true);
				
				if(isset($hasil_asesmen['s'])){
					$hasil_assesmen = replace_newline($hasil_asesmen['s']);
					$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_assesmen);
					$templateklinik->setValue('assesment_s#' . $x, $toOpenXML);
				}else{
					$templateklinik->setValue('assesment_s#' . $x, '');
				}

				if(isset($hasil_asesmen['o'])){
					$hasil_assesmen = replace_newline($hasil_asesmen['o']);
					$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_assesmen);
					$templateklinik->setValue('assesment_o#' . $x, $toOpenXML);
				}else{
					$templateklinik->setValue('assesment_o#' . $x, '');
				}

				if(isset($hasil_asesmen['a'])){
					$hasil_asesmeny = '';
					
					$diagnosax = '';
					$dg = 0;
					while($dg <= 3){
						if($hasil_asesmen['d' . $dg] != ''){
							$diagnosax .= '-' . $hasil_asesmen['d' . $dg] . ',';
						}		
					$dg++;
					}	
					if($diagnosax != ''){
						$hasil_asesmeny .= 'Diagnosa : ' . substr($diagnosax,0,strlen($diagnosax)-1);
					}

					$dg = 4;
					$diagnosaz = '';
					while($dg <= 7){
						if($hasil_asesmen['d' . $dg] != ''){
							$diagnosaz .= '-' . $hasil_asesmen['d' . $dg] . ',';
						}		
					$dg++;
					}	
					if($diagnosaz != ''){
						$hasil_asesmeny .= '<br>Diagnosa Banding : ' . substr($diagnosaz,0,strlen($diagnosaz)-1);
					}	
					
					if($hasil_asesmen['a'] != ''){
						$hasil_assesmen = replace_newline($hasil_asesmen['a']);
						$hasil_asesmeny .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;' . $hasil_assesmen;
					}	
					$hasil_asesmeny .= '<br><br>';
					$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_asesmeny);
					$templateklinik->setValue('assesment_a#' . $x, $toOpenXML);
				}else{
					$templateklinik->setValue('assesment_a#' . $x, '');
				}	
				
				if(isset($hasil_asesmen['p'])){
					$hasil_assesmen = replace_newline($hasil_asesmen['p']);
					$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($hasil_assesmen);
					$templateklinik->setValue('assesment_p#' . $x, $toOpenXML);
				}else{
					$templateklinik->setValue('assesment_p#' . $x, '');
				}
				
				$intruksi_ppa = replace_newline($dat_perkembangan['INTRUKSI_PPA']);
				$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML($intruksi_ppa);
				$templateklinik->setValue('intruksi#' . $x, $toOpenXML);
				$templateklinik->setValue('verifikasi#' . $x, htmlspecialchars($dat_perkembangan['VERIFIKASI_DPJP']));
			$x++;	
			}	
	}else{
		$templateklinik->setValue('tgl', '');
		$templateklinik->setValue('asuhan', '');
		$templateklinik->setValue('assesment_s', '');
		$templateklinik->setValue('assesment_o', '');
		$templateklinik->setValue('assesment_a', '');
		$templateklinik->setValue('assesment_p', '');
		$templateklinik->setValue('intruksi', '');
		$templateklinik->setValue('verifikasi', '');
	}		
	
	
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord, 0700, true);
	}
	
	$nama_file = $nomr . '_' . $idxord . $idx . '_37';	
	$templateklinik->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx');
	
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE NOMR = "' . $nomr . '"
				AND RAWAT_ID = "' . $idxord . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				' . (($jns_order != '') ? 'AND ORDER_PENUNJANG = "' . $idx . '"' : 'AND ORDER_PENUNJANG IS NULL') . '
				AND JENIS_DOKUMEN_ID = "37"
				AND NAMA_FILE = "' . $nama_file . '.pdf"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,
				NOMR,
				RAWAT_ID,
				JNS_PERAWATAN,
				ORDER_PENUNJANG,
				NAMA_FILE,
				ST_SISTEM,
				TANGGAL) 		
				VALUES("37",
				"' . $nomr . '",
				"' . $idxord . '",
				"' . $jns_perawatan . '",
				' . (($jns_order != '') ? '"' . $idx . '"' : 'NULL') . ',
				"' . $nama_file . '.pdf",
				"1",
				STR_TO_DATE("' . $tgl_daftar . '","%d/%m/%Y"))') or die(mysql_error());
	
	$source_file = $rmfile_path . '/doc/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $nomr . '/' . $idxord . '/' . $nama_file . '.pdf';
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