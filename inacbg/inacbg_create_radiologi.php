<?php
function inacbg_create_radiologi($rawat,$id,$no_sep){
	global $eklaim_arsip_path;

	if($rawat == '2'){
		$qry_order = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				t_ipenunjang.JNS_ORDER
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND (m_tarif_group.RADIOLOGI = "1" 
					OR m_tarif_group.RADIOLOGI_CITO = "1" 
					OR m_tarif.UNIT_ID = "17")
				AND (t_ipenunjang.JNS_ORDER = "IRJ" 
					OR t_ipenunjang.JNS_ORDER = "ORJ" 
					OR t_ipenunjang.JNS_ORDER = "HRJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL';
		$get_order = mysql_query($qry_order) or die(mysql_error());
		$r = 1;
		while($dat_order = mysql_fetch_array($get_order)){
			$tarif_id = $dat_order['PENUNJANG_TARIF_ID']; 
			$jns_order = $dat_order['JNS_ORDER']; 
			
			$templatediag = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\diagnosa_radiologi.docx');	
			
			$qry_diag = 'SELECT t_ipenunjang.PENUNJANG_ID,
				m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
				m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,
				m_pasien.NO_TELEPON,
				CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
				END AS JNS_KELAMIN,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y") AS TANGGAL_DIAGNOSA,
				m_pegawai.NAMA_PEGAWAI AS DOKTER_PENGIRIM,
				m_unit.NAMA_UNIT,
				CASE WHEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER IS NOT NULL 
					AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER <> ""
					THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER 
					ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
				t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_RADIOLOGI
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE t_ipenunjang.JNS_ORDER = "' . $jns_order . '"
				AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $tarif_id . '"';
			$get_diag = mysql_query($qry_diag) or die(mysql_error());
			$dat_diag = mysql_fetch_assoc($get_diag);
			$templatediag->setValue('nomor_mr', formatNomr($dat_diag['NOMR']));
			$templatediag->setValue('nama_pasien', htmlspecialchars($dat_diag['NAMA_PASIEN']));
			$templatediag->setValue('tanggal_lahir', $dat_diag['TGL_LAHIR']);		
			$templatediag->setValue('jenis_kelamin', $dat_diag['JNS_KELAMIN']);		
			$alamat = trim($dat_diag['ALAMAT']) . ' ' . trim($dat_diag['ALAMAT_RT']) . '/' . trim($dat_diag['ALAMAT_RW']) . ' ' . trim($dat_diag['NAMA_KELURAHAN']) . ' ' . trim($dat_diag['NAMA_KECAMATAN']);
			if(!empty($dat_diag['NO_TELEPON'])) $alamat .= ', Telp. ' . $dat_diag['NO_TELEPON'];
			$alamat = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($alamat))));
			$templatediag->setValue('alamat', htmlspecialchars($alamat));
			$templatediag->setValue('tanggal', $dat_diag['TANGGAL_DIAGNOSA']);		
			$templatediag->setValue('dokter_pengirim', htmlspecialchars($dat_diag['DOKTER_PENGIRIM']));
			$asal = $dat_diag['NAMA_UNIT'];	
			if($jns_order == 'ORJ') $asal .= ' - ' . 'Kamar Operasi';	
			if($jns_order == 'HRJ') $asal .= ' - ' . 'Hemodialisa';
			$templatediag->setValue('pengirim', htmlspecialchars($asal));		
			$templatediag->setValue('photo', htmlspecialchars('Foto ' . $dat_diag['NAMA_TARIF']));
			$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML(htmlspecialchars($dat_diag['HASIL_DIAGNOSA']));
			$templatediag->setValue('hasil_diagnosa', $toOpenXML);		
			$templatediag->setValue('dokter_radiologi', htmlspecialchars($dat_diag['DOKTER_RADIOLOGI']));		
			$nor = substr('00',0,2 - strlen($r)) . $r;
			$templatediag->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/05_radiologi_' . $nor . '.docx');
			$r++;
		}	
	}else if($rawat == '1'){
		$qry_order = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				t_ipenunjang.JNS_ORDER
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND (m_tarif_group.RADIOLOGI = "1" 
					OR m_tarif_group.RADIOLOGI_CITO = "1" 
					OR m_tarif.UNIT_ID = "17")
				AND (t_ipenunjang.JNS_ORDER = "IRJ" 
					OR t_ipenunjang.JNS_ORDER = "ORJ" 
					OR t_ipenunjang.JNS_ORDER = "HRJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION ALL
				SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				t_ipenunjang.JNS_ORDER
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND (m_tarif_group.RADIOLOGI = "1" 
					OR m_tarif_group.RADIOLOGI_CITO = "1" 
					OR m_tarif.UNIT_ID = "17")
				AND (t_ipenunjang.JNS_ORDER = "IRN" 
					OR t_ipenunjang.JNS_ORDER = "ORI" 
					OR t_ipenunjang.JNS_ORDER = "HRI")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL';
		$get_order = mysql_query($qry_order) or die(mysql_error());
		$r = 1;
		while($dat_order = mysql_fetch_array($get_order)){
			$tarif_id = $dat_order['PENUNJANG_TARIF_ID']; 
			$jns_order = $dat_order['JNS_ORDER']; 
		
			$templatediag = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\diagnosa_radiologi.docx');	
			
			if($jns_order == 'IRJ' or $jns_order == 'ORJ' or $jns_order == 'HRJ'){
				$qry_diag = 'SELECT t_ipenunjang.PENUNJANG_ID,
					m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
					m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
					m_kelurahan.NAMA_KELURAHAN,
					m_kecamatan.NAMA_KECAMATAN,
					m_pasien.NO_TELEPON,
					CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
					END AS JNS_KELAMIN,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y") AS TANGGAL_DIAGNOSA,
					m_pegawai.NAMA_PEGAWAI AS DOKTER_PENGIRIM,
					m_unit.NAMA_UNIT,
					CASE WHEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER IS NOT NULL 
						AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER <> ""
						THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER 
						ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
					t_ipenunjang_tarif.HASIL_DIAGNOSA,
					m_pegawai2.NAMA_PEGAWAI AS DOKTER_RADIOLOGI
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
					INNER JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
					INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
					LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
					LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
					LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					WHERE t_ipenunjang.JNS_ORDER = "' . $jns_order . '"
					AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $tarif_id . '"';
			}else if($jns_order == 'IRN' or $jns_order == 'ORI' or $jns_order == 'HRI'){
				$qry_diag = 'SELECT t_ipenunjang.PENUNJANG_ID,
					m_pasien.NAMA_PASIEN,t_ipenunjang.NOMR,m_pasien.TGL_LAHIR,m_pasien.ALAMAT,
					m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
					m_kelurahan.NAMA_KELURAHAN,
					m_kecamatan.NAMA_KECAMATAN,
					m_pasien.NO_TELEPON,
					CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
					END AS JNS_KELAMIN,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y") AS TANGGAL_DIAGNOSA,
					m_pegawai.NAMA_PEGAWAI AS DOKTER_PENGIRIM,
					CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
					CASE WHEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER IS NOT NULL 
						AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER <> ""
						THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER 
						ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
					t_ipenunjang_tarif.HASIL_DIAGNOSA,
					m_pegawai2.NAMA_PEGAWAI AS DOKTER_RADIOLOGI
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
					INNER JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
					INNER JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
					LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
					LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
					LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					WHERE t_ipenunjang.JNS_ORDER = "' . $jns_order . '"
					AND t_ipenunjang_tarif.PENUNJANG_TARIF_ID = "' . $tarif_id . '"';
			}		
			$get_diag = mysql_query($qry_diag) or die(mysql_error());
			$dat_diag = mysql_fetch_assoc($get_diag);
			$templatediag->setValue('nomor_mr', formatNomr($dat_diag['NOMR']));
			$templatediag->setValue('nama_pasien', htmlspecialchars($dat_diag['NAMA_PASIEN']));
			$templatediag->setValue('tanggal_lahir', $dat_diag['TGL_LAHIR']);		
			$templatediag->setValue('jenis_kelamin', $dat_diag['JNS_KELAMIN']);		
			$alamat = trim($dat_diag['ALAMAT']) . ' ' . trim($dat_diag['ALAMAT_RT']) . '/' . trim($dat_diag['ALAMAT_RW']) . ' ' . trim($dat_diag['NAMA_KELURAHAN']) . ' ' . trim($dat_diag['NAMA_KECAMATAN']);
			if(!empty($dat_diag['NO_TELEPON'])) $alamat .= ', Telp. ' . $dat_diag['NO_TELEPON'];
			$alamat = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($alamat))));
			$templatediag->setValue('alamat', htmlspecialchars($alamat));
			$templatediag->setValue('tanggal', $dat_diag['TANGGAL_DIAGNOSA']);		
			$templatediag->setValue('dokter_pengirim', htmlspecialchars($dat_diag['DOKTER_PENGIRIM']));
			$asal = $dat_diag['NAMA_UNIT'];	
			if($jns_order == 'ORJ') $asal .= ' - ' . 'Kamar Operasi';	
			if($jns_order == 'HRJ') $asal .= ' - ' . 'Hemodialisa';
			$templatediag->setValue('pengirim', htmlspecialchars($asal));		
			$templatediag->setValue('photo', htmlspecialchars('Foto ' . $dat_diag['NAMA_TARIF']));
			$toOpenXML = HTMLtoOpenXML::getInstance()->fromHTML(htmlspecialchars($dat_diag['HASIL_DIAGNOSA']));
			$templatediag->setValue('hasil_diagnosa', $toOpenXML);		
			$templatediag->setValue('dokter_radiologi', htmlspecialchars($dat_diag['DOKTER_RADIOLOGI']));		
			$nor = substr('00',0,2 - strlen($r)) . $r;
			$templatediag->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/05_radiologi_' . $nor . '.docx');
			$r++;
			}
	}
}	
?>