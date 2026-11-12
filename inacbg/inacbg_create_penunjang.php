<?php
function inacbg_create_penunjang($rawat,$id,$no_sep){
	global $eklaim_arsip_path;

	if($rawat == '2'){
		$qry_order = 'SELECT DISTINCT t_ipenunjang.RAWAT_ID,t_ipenunjang.PENUNJANG_ID,
				t_ipenunjang_tarif.NO_SJP,t_ipenunjang.JNS_ORDER
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND t_ipenunjang_tarif.UNIT_PENUNJANG_ID IN (
					SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
					AND UNIT_ID <> 17 AND UNIT_ID <> 45
				)
				AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "ORJ" OR t_ipenunjang.JNS_ORDER = "HRJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL';
		$get_order = mysql_query($qry_order) or die(mysql_error());
		$r = 1;
		while($dat_order = mysql_fetch_array($get_order)){
			$no_sjp = $dat_order['NO_SJP']; 
			$jns_order = $dat_order['JNS_ORDER']; 
			$id_penunjang = $dat_order['PENUNJANG_ID'];

			$templatediag = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\tindakan_penunjang.docx');
						
			$qry_diag = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
				t_ipenunjang.UNIT_ID,
				DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
				t_ipenunjang.NOMR,
				m_unit.NAMA_UNIT,
				m_pasien.NAMA_PASIEN,
				CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
				END AS JNS_KELAMIN,
				DATE_FORMAT(m_pasien.TGL_LAHIR,"%d-%m-%Y") AS TGL_LAHIR,
				m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM,
				m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
				m_pasien.ALAMAT,
				m_pasien.ALAMAT_RT,
				m_pasien.ALAMAT_RW,
				m_kelurahan.NAMA_KELURAHAN,
				m_kecamatan.NAMA_KECAMATAN,
				m_pasien.NO_TELEPON AS NO_TELEPON,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y") AS TANGGAL,
				t_ipenunjang_tarif.HASIL_DIAGNOSA,
				m_pegawai.NAMA_PEGAWAI,
				m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,
				t_ipenunjang_tarif.NO_SJP	
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				WHERE t_ipenunjang.JNS_ORDER = "' . $jns_order . '" 
				AND t_ipenunjang.RAWAT_ID = "' . $id . '"
				AND t_ipenunjang_tarif.NO_SJP ="' . $no_sjp . '"
				AND t_ipenunjang.PENUNJANG_ID = "' . $id_penunjang . '"';
			$get_diag = mysql_query($qry_diag) or die(mysql_error());
			$dat_diag = mysql_fetch_assoc($get_diag);
			$nama_penunjang = str_replace('/','_',str_replace('.','',str_replace(' ','_',$dat_diag['NAMA_PENUNJANG'])));
			$nomor = '';
			if($dat_diag['UNIT_ID'] == '9'){
				$nomor = 'IGD/' . $dat_diag['NO_SJP'];
				$asal = $dat_diag['NAMA_UNIT'];		
			}else{
				$nomor = 'RJ/' . $dat_diag['NO_SJP'];
				$asal = 'Poliklinik ' . $dat_diag['NAMA_UNIT'];		
			}
			if($jns_order == 'ORJ') $asal .= ' - ' . 'Kamar Operasi';	
			if($jns_order == 'HRJ') $asal .= ' - ' . 'Hemodialisa';
			$templatediag->setValue('nama_penunjang', strtoupper(htmlspecialchars($dat_diag['NAMA_PENUNJANG'])));
			$templatediag->setValue('nomor', $nomor);
			$templatediag->setValue('tanggal_minta', $dat_diag['TANGGAL_ORDER']);		
			$templatediag->setValue('nomor_mr', formatNomr($dat_diag['NOMR']));		
			$templatediag->setValue('asal', htmlspecialchars($asal));		
			$templatediag->setValue('nama_pasien', htmlspecialchars($dat_diag['NAMA_PASIEN']));
			$templatediag->setValue('dokter', htmlspecialchars($dat_diag['DOKTER_PENGIRIM']));
			$templatediag->setValue('tanggal_lahir', $dat_diag['TGL_LAHIR']);		
			$templatediag->setValue('jenis_kelamin', $dat_diag['JNS_KELAMIN']);		
			$alamat = trim($dat_diag['ALAMAT']) . ' ' . trim($dat_diag['ALAMAT_RT']) . '/' . trim($dat_diag['ALAMAT_RW']) . ' ' . trim($dat_diag['NAMA_KELURAHAN']) . ' ' . trim($dat_diag['NAMA_KECAMATAN']);
			if(!empty($dat_diag['NO_TELEPON'])) $alamat .= ', Telp. ' . $dat_diag['NO_TELEPON'];
			$alamat = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($alamat))));
			$templatediag->setValue('alamat', htmlspecialchars($alamat));
			$templatediag->setValue('catatan', htmlspecialchars($dat_diag['HASIL_DIAGNOSA']));
			$templatediag->setValue('pemeriksa', htmlspecialchars($dat_diag['NAMA_PEGAWAI']));
			$templatediag->setValue('tanggal', ' Tangerang, ' . $dat_diag['TANGGAL']);

			$qry_tindakan = 'SELECT DISTINCT m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP,
				t_ipenunjang_tarif.ICD_CODE
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $id_penunjang . '"
				AND t_ipenunjang.JNS_ORDER = "' . $jns_order . '" 
				AND t_ipenunjang_tarif.NO_SJP = "' . $no_sjp . '"
				AND t_ipenunjang.RAWAT_ID = "' . $id . '"
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND m_tarif.KODE_TARIF_GROUP NOT IN ("01")';
			$get_tindakan = mysql_query($qry_tindakan) or die(mysql_error());			
			if(mysql_num_rows($get_tindakan) > 0){
				$templatediag->cloneRow('no', mysql_num_rows($get_tindakan));
				$l = 0;
				while($dat_tindakan = mysql_fetch_array($get_tindakan)){
					$templatediag->setValue('no#' . ($l + 1), ($l + 1));	 
					$templatediag->setValue('tindakan#' . ($l + 1), htmlspecialchars($dat_tindakan['NAMA_TARIF_GROUP'] . '-' . $dat_tindakan['NAMA_TARIF']));
					$templatediag->setValue('icd#' . ($l + 1), htmlspecialchars($dat_tindakan['ICD_CODE']));
					$l = $l + 1;
				}	
			}else{
				$templatediag->setValue('no', '');	
				$templatediag->setValue('tindakan', '');	
				$templatediag->setValue('icd', '');	
			}	
			
			$nor = substr('00',0,2 - strlen($r)) . $r;
			$templatediag->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/06_' . strtolower($nama_penunjang) . '_' . $nor . '.docx');
			$r++;
		}	
	}else if($rawat == '1'){
		
	}
}	
?>