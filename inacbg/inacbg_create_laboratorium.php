<?php
function inacbg_create_laboratorium($rawat,$id,$no_sep){
	global $eklaim_arsip_path;

	if($rawat == '2'){
		$qry_order = 'SELECT DISTINCT t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang.JNS_ORDER,
				m_tarif_pemeriksaan.FORM_HASIL
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1" OR m_tarif.UNIT_ID = "45")
				AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "ORJ" OR t_ipenunjang.JNS_ORDER = "HRJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL';
		$get_order = mysql_query($qry_order) or die(mysql_error());
		$r = 1;
		while($dat_order = mysql_fetch_array($get_order)){
			$no_tarif = $dat_order['NO_TARIF']; 
			$jns_order = $dat_order['JNS_ORDER']; 
			$form_hasil = $dat_order['FORM_HASIL'];

			if($form_hasil==''){
				$templatediag = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\hasil_laboratorium_1.docx');
			}else{
				$templatediag = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\hasil_laboratorium_' . $form_hasil . '.docx');
			}	
			
			$qry_diag = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
				t_ipenunjang_tarif.NO_TP,t_ipenunjang.UNIT_ID,
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
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y") AS TANGGAL,
				DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
				t_ipenunjang_tarif.CATATAN_SPESIMEN,
				m_pegawai.NAMA_PEGAWAI				
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
				LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
				LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
				LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
				WHERE t_ipenunjang.JNS_ORDER = "' . $jns_order . '" 
				AND t_ipenunjang.RAWAT_ID = "' . $id . '"
				AND t_ipenunjang_tarif.NO_TARIF ="' . $no_tarif . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form_hasil . '"';
			$get_diag = mysql_query($qry_diag) or die(mysql_error());
			$dat_diag = mysql_fetch_assoc($get_diag);
			$nomor = '';
			if($dat_diag['UNIT_ID'] == '9'){
				$nomor = 'IGD/' . $dat_diag['NO_TP'];
				$asal = $dat_diag['NAMA_UNIT'];		
			}else{
				$nomor = 'RJ/' . $dat_diag['NO_TP'];
				$asal = 'Poliklinik ' . $dat_diag['NAMA_UNIT'];		
			}
			if($jns_order == 'ORJ') $asal .= ' - ' . 'Kamar Operasi';	
			if($jns_order == 'HRJ') $asal .= ' - ' . 'Hemodialisa';
			$templatediag->setValue('nomor', $nomor);
			$templatediag->setValue('tanggal_minta', $dat_diag['TANGGAL_ORDER']);		
			$templatediag->setValue('nomor_mr', formatNomr($dat_diag['NOMR']));		
			$templatediag->setValue('asal', htmlspecialchars($asal));		
			$templatediag->setValue('nama_pasien', htmlspecialchars($dat_diag['NAMA_PASIEN']));
			$templatediag->setValue('dokter', htmlspecialchars($dat_diag['DOKTER_PENGIRIM']));
			$templatediag->setValue('tanggal_lahir', $dat_diag['TGL_LAHIR']);		
			$templatediag->setValue('jenis_kelamin', $dat_diag['JNS_KELAMIN']);		
			$templatediag->setValue('dokter_laboratorium', htmlspecialchars($dat_diag['DOKTER_PENANGGUNGJAWAB']));
			$alamat = trim($dat_diag['ALAMAT']) . ' ' . trim($dat_diag['ALAMAT_RT']) . '/' . trim($dat_diag['ALAMAT_RW']) . ' ' . trim($dat_diag['NAMA_KELURAHAN']) . ' ' . trim($dat_diag['NAMA_KECAMATAN']);
			if(!empty($dat_diag['NO_TELEPON'])) $alamat .= ', Telp. ' . $dat_diag['NO_TELEPON'];
			$alamat = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($alamat))));
			$templatediag->setValue('alamat', htmlspecialchars($alamat));
			$templatediag->setValue('selesai_tanggal', $dat_diag['TANGGAL_HASIL']);
			$templatediag->setValue('pengambilan_spesimen', $dat_diag['TANGGAL_SAMPLING']);
			$templatediag->setValue('catatan', htmlspecialchars($dat_diag['CATATAN_SPESIMEN']));
			$templatediag->setValue('pemeriksa', htmlspecialchars($dat_diag['NAMA_PEGAWAI']));
			$templatediag->setValue('tanggal', ' Tangerang, ' . $dat_diag['TANGGAL']);
			
			$qry_hasil = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				m_tarif_pemeriksaan.REPORT_ORDER,
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,
				m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,
				m_tarif_pemeriksaan.REPORT_FORMAT,
				t_ipenunjang_tarif_pemeriksaan.SATUAN,
				t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID,
				t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				LEFT JOIN m_nilai_rujukan_laboratorium ON (t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID = m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND t_ipenunjang.JNS_ORDER = "' . $jns_order . '"	
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_tarif . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form_hasil . '"
				ORDER BY m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.REPORT_ORDER';
			$get_hasil = mysql_query($qry_hasil) or die(mysql_error());
			
			if(isset($ret)) unset($ret);
			while ($dat_hasil = mysql_fetch_array($get_hasil)) {
				$rujukan = $dat_hasil['NILAI_RUJUKAN'];
				$rujukan_2 = $dat_hasil['NILAI_RUJUKAN'];
				$rujukan_array = explode('|',$dat_hasil['NILAI_RUJUKAN']);
				if(count($rujukan_array) > 1){
					$rujukan = $rujukan_array[1];
					$x = 1;
					$rujukan_2 = '';
					while($x < count($rujukan_array)){
						if($x > 1){
							$rujukan_2 = $rujukan_2 . '|' . $rujukan_array[$x];
						}else{
							$rujukan_2 = $rujukan_array[$x];
						}
					$x++;
					}
				}	
		
				$ret[] = array('CH_REPORT' => $dat_hasil['CH_REPORT'],
					'CH_LEVEL' => $dat_hasil['CH_LEVEL'],
					'NAMA_PEMERIKSAAN_GROUP' => $dat_hasil['NAMA_PEMERIKSAAN_GROUP'],
					'NAMA_PEMERIKSAAN' => $dat_hasil['NAMA_PEMERIKSAAN'],
					'REPORT_FORMAT' => $dat_hasil['REPORT_FORMAT'],
					'SATUAN' => $dat_hasil['SATUAN'],
					'NILAI_RUJUKAN' => $rujukan,
					'NILAI_RUJUKAN_2' => $rujukan_2,
					'HASIL_DIAGNOSA' => $dat_hasil['HASIL_DIAGNOSA']);
			}
			
			if(isset($ret) and sizeof($ret) > 0){
				//detail hasil diagnosa
				$l = 0;
				$cr = sizeof($ret);
				$nama_form = '';
				$nama_group = '';
				while($l < sizeof($ret)){
					if($ret[$l]['CH_REPORT'] != $nama_form){
						$nama_form = $ret[$l]['CH_REPORT'];
						$cr++;
					}
					if($ret[$l]['NAMA_PEMERIKSAAN_GROUP'] !=''){
						if($ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'] != $nama_group){
							$nama_group = $ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'];
							$cr++;
						}
					}	
				$l++;
				}
				$templatediag->cloneRow('pemeriksaan', $cr);
				
				$l = 0;
				$k = 1;
				$nama_form = '';
				$nama_group = '';
				while($l < sizeof($ret)){
					if($ret[$l]['CH_REPORT'] != $nama_form){
						$nama_form = $ret[$l]['CH_REPORT'];
						$templatediag->setValue('pemeriksaan#' . $k, "<w:r><w:rPr><w:b/></w:rPr><w:t>". htmlspecialchars(strtoupper($ret[$l]['CH_REPORT'])) ."</w:t></w:r>");
						$templatediag->setValue('hasil#' . $k, '');
						$templatediag->setValue('satuan#' . $k, '');
						$templatediag->setValue('rujukan#' . $k, '');
						$k++;
					}
					if($ret[$l]['NAMA_PEMERIKSAAN_GROUP'] !=''){
						if($ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'] != $nama_group){
							$nama_group = $ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'];
							$templatediag->setValue('pemeriksaan#' . $k, "<w:r><w:rPr><w:b/></w:rPr><w:t>". htmlspecialchars($ret[$l]['NAMA_PEMERIKSAAN_GROUP']) ."</w:t></w:r>");
							$vhasil = '';
							if($form_hasil == '2' and $ret[$l]['REPORT_FORMAT'] == '2'){
								$vhasil = '<w:tbl>
                           <w:tblPr>
                              <w:tblStyle w:val="TableGrid" />
                              <w:tblW w:w="7216" w:type="dxa" />
                              <w:tblLayout w:type="fixed" />
                              <w:tblLook w:val="04A0" />
                           </w:tblPr>
                           <w:tblGrid>
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1444" />
                           </w:tblGrid>
                           <w:tr w:rsidR="008D6286" w:rsidTr="00EC6857">
                              <w:trPr>
                                 <w:trHeight w:val="285" />
                              </w:trPr>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:left w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="00F94898" w:rsidRPr="00C544A1" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>Bi</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>Mi</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>S(%)</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>F(%)</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1444" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                       <w:right w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>G(%)</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                           </w:tr>
                        </w:tbl>';
							}
							$templatediag->setValue('hasil#' . $k, $vhasil);	
							$templatediag->setValue('satuan#' . $k, '');
							$templatediag->setValue('rujukan#' . $k, '');
							$k++;
						}	
					}
					
					if($ret[$l]['NAMA_PEMERIKSAAN_GROUP'] !=''){
						$templatediag->setValue('pemeriksaan#' . $k, htmlspecialchars('- ' . $ret[$l]['NAMA_PEMERIKSAAN']));
					}else{
						if($ret[$l]['CH_LEVEL'] == '1'){
							$templatediag->setValue('pemeriksaan#' . $k, '<w:r><w:rPr><w:b/></w:rPr><w:t>'. htmlspecialchars($ret[$l]['NAMA_PEMERIKSAAN']) .'</w:t></w:r>');
						}else{
							$templatediag->setValue('pemeriksaan#' . $k, htmlspecialchars($ret[$l]['NAMA_PEMERIKSAAN']));
						}		
					}	
					
					if($form_hasil == '2' and $ret[$l]['REPORT_FORMAT'] == '2'){
						$arr_hasil_diagnosa = explode('|!|',$ret[$l]['HASIL_DIAGNOSA']);
						if(sizeof($arr_hasil_diagnosa) > 4){
							$vhasil = '<w:tbl>
                           <w:tblPr>
                              <w:tblStyle w:val="TableGrid" />
                              <w:tblW w:w="7216" w:type="dxa" />
                              <w:tblLayout w:type="fixed" />
                              <w:tblLook w:val="04A0" />
                           </w:tblPr>
                           <w:tblGrid>
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1444" />
                           </w:tblGrid>
                           <w:tr w:rsidR="008D6286" w:rsidTr="00EC6857">
                              <w:trPr>
                                 <w:trHeight w:val="285" />
                              </w:trPr>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:left w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="00F94898" w:rsidRPr="00C544A1" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[0]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[1]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[2]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[3]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1444" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                       <w:right w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[4]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                           </w:tr>
                        </w:tbl>';
							$templatediag->setValue('hasil#' . $k, $vhasil);	
						}else{
							$templatediag->setValue('hasil#' . $k, htmlspecialchars('' . $ret[$l]['HASIL_DIAGNOSA']));	
						}	
					}else{
						$templatediag->setValue('hasil#' . $k, htmlspecialchars('' . $ret[$l]['HASIL_DIAGNOSA']));	
					}	
					$templatediag->setValue('satuan#' . $k, htmlspecialchars('' . $ret[$l]['SATUAN']));
					$templatediag->setValue('rujukan#' . $k, htmlspecialchars('' . $ret[$l]['NILAI_RUJUKAN']));
				$k++;	
				$l++;
				}	
			}else{
				$templatediag->setValue('pemeriksaan', '');	
				$templatediag->setValue('hasil', '');
				$templatediag->setValue('satuan', '');
				$templatediag->setValue('rujukan', '');		
			}	
			
			$nor = substr('00',0,2 - strlen($r)) . $r;
			$templatediag->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/04_laboratoium_' . $nor . '.docx');
			$r++;
		}	
	}else if($rawat == '1'){
		$qry_order = 'SELECT DISTINCT t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang.JNS_ORDER,
				m_tarif_pemeriksaan.FORM_HASIL
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1" OR m_tarif.UNIT_ID = "45")
				AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "ORJ" OR t_ipenunjang.JNS_ORDER = "HRJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION ALL
				SELECT DISTINCT t_ipenunjang.RAWAT_ID,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang.JNS_ORDER,
				m_tarif_pemeriksaan.FORM_HASIL
 				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1" OR m_tarif.UNIT_ID = "45")
				AND (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "ORI" OR t_ipenunjang.JNS_ORDER = "HRI")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.ST_BATAL IS NULL';
		$get_order = mysql_query($qry_order) or die(mysql_error());
		$r = 1;
		while($dat_order = mysql_fetch_array($get_order)){
			$no_tarif = $dat_order['NO_TARIF']; 
			$jns_order = $dat_order['JNS_ORDER']; 
			$form_hasil = $dat_order['FORM_HASIL'];

			if($form_hasil==''){
				$templatediag = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\hasil_laboratorium_1.docx');
			}else{
				$templatediag = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\hasil_laboratorium_' . $form_hasil . '.docx');
			}	
			
			if($jns_order == 'IRJ' or $jns_order == 'ORJ' or $jns_order == 'HRJ'){
				$qry_diag = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
					t_ipenunjang_tarif.NO_TP,t_ipenunjang.UNIT_ID,
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
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y") AS TANGGAL,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
					t_ipenunjang_tarif.CATATAN_SPESIMEN,
					m_pegawai.NAMA_PEGAWAI				
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
					LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
					LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
					LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
					WHERE t_ipenunjang.JNS_ORDER = "' . $jns_order . '" 
					AND t_ipenunjang.RAWAT_ID = "' . $id . '"
					AND t_ipenunjang_tarif.NO_TARIF ="' . $no_tarif . '"
					AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form_hasil . '"';
			}else if($jns_order == 'IRN' or $jns_order == 'ORI' or $jns_order == 'HRI'){
				$qry_diag = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
					t_ipenunjang_tarif.NO_TP,t_ipenunjang.UNIT_ID,
					DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
					t_ipenunjang.NOMR,
					CONCAT(m_ruang.NAMA_RUANG," Kls ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
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
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y") AS TANGGAL,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
					t_ipenunjang_tarif.CATATAN_SPESIMEN,
					m_pegawai.NAMA_PEGAWAI				
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					INNER JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
					LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
					LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
					LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
					WHERE (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "ORI" OR t_ipenunjang.JNS_ORDER = "HRI")  
					AND t_ipenunjang.JNS_ORDER = "' . $jns_order . '" 
					AND t_ipenunjang.RAWAT_ID = "' . $id . '"
					AND t_ipenunjang_tarif.NO_TARIF ="' . $no_tarif . '"
					AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form_hasil . '"';
			}		
			$get_diag = mysql_query($qry_diag) or die(mysql_error());
			$dat_diag = mysql_fetch_assoc($get_diag);
			$nomor = '';
			if($jns_order == 'IRJ' or $jns_order == 'ORJ' or $jns_order == 'HRJ'){
				if($dat_diag['UNIT_ID'] == '9'){
					$nomor = 'IGD/' . $dat_diag['NO_TP'];
					$asal = $dat_diag['NAMA_UNIT'];		
				}else{
					$nomor = 'RJ/' . $dat_diag['NO_TP'];
					$asal = 'Poliklinik ' . $dat_diag['NAMA_UNIT'];		
				}
			}else if($jns_order == 'IRN' or $jns_order == 'ORI' or $jns_order == 'HRI'){
				$nomor = 'RI/' . $dat_diag['NO_TP'];
				$asal = $dat_diag['NAMA_UNIT'];
			}	
			if($jns_order == 'ORJ' or $jns_order == 'ORI') $asal .= ' - ' . 'Kamar Operasi';	
			if($jns_order == 'HRJ' or $jns_order == 'HRI') $asal .= ' - ' . 'Hemodialisa';
			$templatediag->setValue('nomor', $nomor);
			$templatediag->setValue('tanggal_minta', $dat_diag['TANGGAL_ORDER']);		
			$templatediag->setValue('nomor_mr', formatNomr($dat_diag['NOMR']));		
			$templatediag->setValue('asal', htmlspecialchars($asal));		
			$templatediag->setValue('nama_pasien', htmlspecialchars($dat_diag['NAMA_PASIEN']));
			$templatediag->setValue('dokter', htmlspecialchars($dat_diag['DOKTER_PENGIRIM']));
			$templatediag->setValue('tanggal_lahir', $dat_diag['TGL_LAHIR']);		
			$templatediag->setValue('jenis_kelamin', $dat_diag['JNS_KELAMIN']);		
			$templatediag->setValue('dokter_laboratorium', htmlspecialchars($dat_diag['DOKTER_PENANGGUNGJAWAB']));
			$alamat = trim($dat_diag['ALAMAT']) . ' ' . trim($dat_diag['ALAMAT_RT']) . '/' . trim($dat_diag['ALAMAT_RW']) . ' ' . trim($dat_diag['NAMA_KELURAHAN']) . ' ' . trim($dat_diag['NAMA_KECAMATAN']);
			if(!empty($dat_diag['NO_TELEPON'])) $alamat .= ', Telp. ' . $dat_diag['NO_TELEPON'];
			$alamat = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($alamat))));
			$templatediag->setValue('alamat', htmlspecialchars($alamat));
			$templatediag->setValue('selesai_tanggal', $dat_diag['TANGGAL_HASIL']);
			$templatediag->setValue('pengambilan_spesimen', $dat_diag['TANGGAL_SAMPLING']);
			$templatediag->setValue('catatan', htmlspecialchars($dat_diag['CATATAN_SPESIMEN']));
			$templatediag->setValue('pemeriksa', htmlspecialchars($dat_diag['NAMA_PEGAWAI']));
			$templatediag->setValue('tanggal', ' Tangerang, ' . $dat_diag['TANGGAL']);
			
			$qry_hasil = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
				m_tarif_pemeriksaan.REPORT_ORDER,
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID,
				m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,
				m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,
				m_tarif_pemeriksaan.REPORT_FORMAT,
				t_ipenunjang_tarif_pemeriksaan.SATUAN,
				t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID,
				t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				LEFT JOIN m_nilai_rujukan_laboratorium ON (t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN_ID = m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '" 
				AND t_ipenunjang.JNS_ORDER = "' . $jns_order . '"	
				AND t_ipenunjang_tarif.NO_TARIF = "' . $no_tarif . '"
				AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form_hasil . '"
				ORDER BY m_tarif_pemeriksaan.CH_REPORT,m_tarif_pemeriksaan.REPORT_ORDER';
			$get_hasil = mysql_query($qry_hasil) or die(mysql_error());
			
			if(isset($ret)) unset($ret);
			while ($dat_hasil = mysql_fetch_array($get_hasil)) {
				$rujukan = $dat_hasil['NILAI_RUJUKAN'];
				$rujukan_2 = $dat_hasil['NILAI_RUJUKAN'];
				$rujukan_array = explode('|',$dat_hasil['NILAI_RUJUKAN']);
				if(count($rujukan_array) > 1){
					$rujukan = $rujukan_array[1];
					$x = 1;
					$rujukan_2 = '';
					while($x < count($rujukan_array)){
						if($x > 1){
							$rujukan_2 = $rujukan_2 . '|' . $rujukan_array[$x];
						}else{
							$rujukan_2 = $rujukan_array[$x];
						}
					$x++;
					}
				}	
		
				$ret[] = array('CH_REPORT' => $dat_hasil['CH_REPORT'],
					'CH_LEVEL' => $dat_hasil['CH_LEVEL'],
					'NAMA_PEMERIKSAAN_GROUP' => $dat_hasil['NAMA_PEMERIKSAAN_GROUP'],
					'NAMA_PEMERIKSAAN' => $dat_hasil['NAMA_PEMERIKSAAN'],
					'REPORT_FORMAT' => $dat_hasil['REPORT_FORMAT'],
					'SATUAN' => $dat_hasil['SATUAN'],
					'NILAI_RUJUKAN' => $rujukan,
					'NILAI_RUJUKAN_2' => $rujukan_2,
					'HASIL_DIAGNOSA' => $dat_hasil['HASIL_DIAGNOSA']);
			}
			
			if(isset($ret) and sizeof($ret) > 0){
				//detail hasil diagnosa
				$l = 0;
				$cr = sizeof($ret);
				$nama_form = '';
				$nama_group = '';
				while($l < sizeof($ret)){
					if($ret[$l]['CH_REPORT'] != $nama_form){
						$nama_form = $ret[$l]['CH_REPORT'];
						$cr++;
					}
					if($ret[$l]['NAMA_PEMERIKSAAN_GROUP'] !=''){
						if($ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'] != $nama_group){
							$nama_group = $ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'];
							$cr++;
						}
					}	
				$l++;
				}
				$templatediag->cloneRow('pemeriksaan', $cr);
				
				$l = 0;
				$k = 1;
				$nama_form = '';
				$nama_group = '';
				while($l < sizeof($ret)){
					if($ret[$l]['CH_REPORT'] != $nama_form){
						$nama_form = $ret[$l]['CH_REPORT'];
						$templatediag->setValue('pemeriksaan#' . $k, "<w:r><w:rPr><w:b/></w:rPr><w:t>". htmlspecialchars(strtoupper($ret[$l]['CH_REPORT'])) ."</w:t></w:r>");
						$templatediag->setValue('hasil#' . $k, '');
						$templatediag->setValue('satuan#' . $k, '');
						$templatediag->setValue('rujukan#' . $k, '');
						$k++;
					}
					if($ret[$l]['NAMA_PEMERIKSAAN_GROUP'] !=''){
						if($ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'] != $nama_group){
							$nama_group = $ret[$l]['CH_REPORT'] . $ret[$l]['NAMA_PEMERIKSAAN_GROUP'];
							$templatediag->setValue('pemeriksaan#' . $k, "<w:r><w:rPr><w:b/></w:rPr><w:t>". htmlspecialchars($ret[$l]['NAMA_PEMERIKSAAN_GROUP']) ."</w:t></w:r>");
							$vhasil = '';
							if($form_hasil == '2' and $ret[$l]['REPORT_FORMAT'] == '2'){
								$vhasil = '<w:tbl>
                           <w:tblPr>
                              <w:tblStyle w:val="TableGrid" />
                              <w:tblW w:w="7216" w:type="dxa" />
                              <w:tblLayout w:type="fixed" />
                              <w:tblLook w:val="04A0" />
                           </w:tblPr>
                           <w:tblGrid>
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1444" />
                           </w:tblGrid>
                           <w:tr w:rsidR="008D6286" w:rsidTr="00EC6857">
                              <w:trPr>
                                 <w:trHeight w:val="285" />
                              </w:trPr>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:left w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="00F94898" w:rsidRPr="00C544A1" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>Bi</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>Mi</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>S(%)</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>F(%)</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1444" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                       <w:right w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>G(%)</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                           </w:tr>
                        </w:tbl>';
							}
							$templatediag->setValue('hasil#' . $k, $vhasil);	
							$templatediag->setValue('satuan#' . $k, '');
							$templatediag->setValue('rujukan#' . $k, '');
							$k++;
						}	
					}
					
					if($ret[$l]['NAMA_PEMERIKSAAN_GROUP'] !=''){
						$templatediag->setValue('pemeriksaan#' . $k, htmlspecialchars('- ' . $ret[$l]['NAMA_PEMERIKSAAN']));
					}else{
						if($ret[$l]['CH_LEVEL'] == '1'){
							$templatediag->setValue('pemeriksaan#' . $k, '<w:r><w:rPr><w:b/></w:rPr><w:t>'. htmlspecialchars($ret[$l]['NAMA_PEMERIKSAAN']) .'</w:t></w:r>');
						}else{
							$templatediag->setValue('pemeriksaan#' . $k, htmlspecialchars($ret[$l]['NAMA_PEMERIKSAAN']));
						}		
					}	
					
					if($form_hasil == '2' and $ret[$l]['REPORT_FORMAT'] == '2'){
						$arr_hasil_diagnosa = explode('|!|',$ret[$l]['HASIL_DIAGNOSA']);
						if(sizeof($arr_hasil_diagnosa) > 4){
							$vhasil = '<w:tbl>
                           <w:tblPr>
                              <w:tblStyle w:val="TableGrid" />
                              <w:tblW w:w="7216" w:type="dxa" />
                              <w:tblLayout w:type="fixed" />
                              <w:tblLook w:val="04A0" />
                           </w:tblPr>
                           <w:tblGrid>
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1443" />
                              <w:gridCol w:w="1444" />
                           </w:tblGrid>
                           <w:tr w:rsidR="008D6286" w:rsidTr="00EC6857">
                              <w:trPr>
                                 <w:trHeight w:val="285" />
                              </w:trPr>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:left w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="00F94898" w:rsidRPr="00C544A1" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[0]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[1]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[2]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1443" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[3]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                              <w:tc>
                                 <w:tcPr>
                                    <w:tcW w:w="1444" w:type="dxa" />
                                    <w:tcBorders>
                                       <w:top w:val="nil" />
                                       <w:bottom w:val="nil" />
                                       <w:right w:val="nil" />
                                    </w:tcBorders>
                                 </w:tcPr>
                                 <w:p w:rsidR="008D6286" w:rsidRDefault="00424FD4" w:rsidP="00620CCA">
                                    <w:pPr>
                                       <w:jc w:val="center" />
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                    </w:pPr>
                                    <w:r>
                                       <w:rPr>
                                          <w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow" w:cs="Times New Roman" />
                                          <w:sz w:val="24" />
                                          <w:szCs w:val="24" />
                                       </w:rPr>
                                       <w:t>' . htmlspecialchars($arr_hasil_diagnosa[4]) . '</w:t>
                                    </w:r>
                                 </w:p>
                              </w:tc>
                           </w:tr>
                        </w:tbl>';
							$templatediag->setValue('hasil#' . $k, $vhasil);	
						}else{
							$templatediag->setValue('hasil#' . $k, htmlspecialchars('' . $ret[$l]['HASIL_DIAGNOSA']));	
						}	
					}else{
						$templatediag->setValue('hasil#' . $k, htmlspecialchars('' . $ret[$l]['HASIL_DIAGNOSA']));	
					}	
					$templatediag->setValue('satuan#' . $k, htmlspecialchars('' . $ret[$l]['SATUAN']));
					$templatediag->setValue('rujukan#' . $k, htmlspecialchars('' . $ret[$l]['NILAI_RUJUKAN']));
				$k++;	
				$l++;
				}	
			}else{
				$templatediag->setValue('pemeriksaan', '');	
				$templatediag->setValue('hasil', '');
				$templatediag->setValue('satuan', '');
				$templatediag->setValue('rujukan', '');		
			}	
			
			$nor = substr('00',0,2 - strlen($r)) . $r;
			$templatediag->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/04_laboratoium_' . $nor . '.docx');
			$r++;
		}
	}
}	
?>