<?php
$qry_ruang = 'SELECT RUANG_ID,NAMA_RUANG,m_ruang.KELAS_RAWAT,NON_KELAS 
			FROM m_ruang
			LEFT JOIN m_kelas_rawat
			ON (m_ruang.KELAS_RAWAT = m_kelas_rawat.KELAS_RAWAT)
			WHERE ST_AKTIF = "1"
			AND (KUSTA IS NULL OR KUSTA = "")
			ORDER BY NAMA_RUANG,KELAS_RAWAT';
$get_ruang = mysql_query($qry_ruang) or die(mysql_error());
while($dat_ruang = mysql_fetch_array($get_ruang)){
		$nama_ruang = strtoupper($dat_ruang['NAMA_RUANG']);
		if($dat_ruang['NON_KELAS'] != '1') $nama_ruang .= ' KELAS ' . strtoupper($dat_ruang['KELAS_RAWAT']);
		$qry_pembayaran .= ' UNION ALL
							SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
							"' . $nama_ruang  . '" AS JNS_URAIAN,
							"" AS NAMA_UNIT,
							"Akomodasi" AS URAIAN,	
							SUM(trf.KUANTITI) AS JUMLAH,
							SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN trf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(trf.KELAS_RAWAT) = "3" THEN trf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(trf.KELAS_RAWAT) = "2" THEN trf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(trf.KELAS_RAWAT) = "1" THEN trf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "VIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA 2" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "VVIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "HCU" THEN trf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICU" THEN trf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(trf.KELAS_RAWAT) = "NICU" THEN trf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(trf.KELAS_RAWAT) = "PICU" THEN trf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICCU" THEN trf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(trf.KELAS_RAWAT) = "PERINA" THEN trf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SEHAT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SAKIT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN m_tarif mtr
							ON (trf.TARIF_ID = mtr.TARIF_ID)
							INNER JOIN m_tarif_group mtrg
							ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "1"
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							AND trf.RUANG_ID = "' . $dat_ruang['RUANG_ID'] . '"
							AND mtr.KODE_TARIF_GROUP IN (' . $arr_akomodasi . ') 
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
							"' . $nama_ruang . '" AS JNS_URAIAN,
							CONCAT("Visite ",mtr.NAMA_TARIF) AS NAMA_UNIT,
							CASE WHEN mpg.NAMA_PEGAWAI IS NOT NULL THEN mpg.NAMA_PEGAWAI ELSE mpg2.NAMA_PEGAWAI END AS URAIAN,	
							SUM(trf.KUANTITI) AS JUMLAH,
							SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN trf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(trf.KELAS_RAWAT) = "3" THEN trf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(trf.KELAS_RAWAT) = "2" THEN trf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(trf.KELAS_RAWAT) = "1" THEN trf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "VIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA 2" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "VVIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "HCU" THEN trf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICU" THEN trf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(trf.KELAS_RAWAT) = "NICU" THEN trf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(trf.KELAS_RAWAT) = "PICU" THEN trf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICCU" THEN trf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(trf.KELAS_RAWAT) = "PERINA" THEN trf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SEHAT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SAKIT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN m_tarif mtr
							ON (trf.TARIF_ID = mtr.TARIF_ID)
							INNER JOIN m_tarif_group mtrg
							ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
							LEFT JOIN m_pegawai mpg
							ON (trf.PEGAWAI_ID = mpg.PEGAWAI_ID)
							LEFT JOIN m_pegawai mpg2
							ON (irn.PEGAWAI_ID = mpg2.PEGAWAI_ID)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "1"
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							AND trf.RUANG_ID = "' . $dat_ruang['RUANG_ID'] . '"
							AND mtr.KODE_TARIF IN (' . $arr_visit_dokter_umum . ',' . $arr_visit_dokter_spesialis . ') 
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							GROUP BY mtr.NAMA_TARIF,URAIAN
							UNION ALL
							SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
							"' . $nama_ruang . '" AS JNS_URAIAN,
							"" AS NAMA_UNIT,
							"Tindakan Rawat Inap" AS URAIAN,	
							SUM(trf.KUANTITI) AS JUMLAH,
							SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN trf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(trf.KELAS_RAWAT) = "3" THEN trf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(trf.KELAS_RAWAT) = "2" THEN trf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(trf.KELAS_RAWAT) = "1" THEN trf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "VIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA 2" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "VVIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "HCU" THEN trf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICU" THEN trf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(trf.KELAS_RAWAT) = "NICU" THEN trf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(trf.KELAS_RAWAT) = "PICU" THEN trf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICCU" THEN trf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(trf.KELAS_RAWAT) = "PERINA" THEN trf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SEHAT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SAKIT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN m_tarif mtr
							ON (trf.TARIF_ID = mtr.TARIF_ID)
							INNER JOIN m_tarif_group mtrg
							ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "1"
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							AND trf.RUANG_ID = "' . $dat_ruang['RUANG_ID'] . '"
							AND mtr.KODE_TARIF_GROUP NOT IN (' . $arr_akomodasi . ',' . $arr_askep . ',' . $arr_pmi . ')
							AND mtr.KODE_TARIF NOT IN (' . $arr_visit_dokter_umum . ',' . $arr_visit_dokter_spesialis . ')
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '');
							
		if($jns_bayar == '1'){
			$qry_pembayaran .= ' UNION ALL
							SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
							"' . $nama_ruang . '" AS JNS_URAIAN,
							"" AS NAMA_UNIT,
							"Tindakan Rawat Inap" AS URAIAN,	
							SUM(trf.KUANTITI) AS JUMLAH,
							SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN trf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(trf.KELAS_RAWAT) = "3" THEN trf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(trf.KELAS_RAWAT) = "2" THEN trf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(trf.KELAS_RAWAT) = "1" THEN trf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "VIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA 2" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "VVIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "HCU" THEN trf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICU" THEN trf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(trf.KELAS_RAWAT) = "NICU" THEN trf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(trf.KELAS_RAWAT) = "PICU" THEN trf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICCU" THEN trf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(trf.KELAS_RAWAT) = "PERINA" THEN trf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SEHAT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SAKIT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN m_tarif mtr
							ON (trf.TARIF_ID = mtr.TARIF_ID)
							INNER JOIN m_tarif_group mtrg
							ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID <> "1"
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
							AND trf.RUANG_ID = "' . $dat_ruang['RUANG_ID'] . '"
							AND mtr.TDK_KLAIM = "1"
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							HAVING SUM(trf.KUANTITI) > 0';
		}					
		
		$qry_pembayaran .= ' UNION ALL
							SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
							"' . $nama_ruang . '" AS JNS_URAIAN,
							"" AS NAMA_UNIT,
							"Askep" AS URAIAN,	
							SUM(trf.KUANTITI) AS JUMLAH,
							SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN trf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(trf.KELAS_RAWAT) = "3" THEN trf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(trf.KELAS_RAWAT) = "2" THEN trf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(trf.KELAS_RAWAT) = "1" THEN trf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "VIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA 2" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "VVIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "HCU" THEN trf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICU" THEN trf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(trf.KELAS_RAWAT) = "NICU" THEN trf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(trf.KELAS_RAWAT) = "PICU" THEN trf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICCU" THEN trf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(trf.KELAS_RAWAT) = "PERINA" THEN trf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SEHAT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SAKIT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN m_tarif mtr
							ON (trf.TARIF_ID = mtr.TARIF_ID)
							INNER JOIN m_tarif_group mtrg
							ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "1"
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							AND trf.RUANG_ID = "' . $dat_ruang['RUANG_ID'] . '"
							AND mtr.KODE_TARIF_GROUP IN (' . $arr_askep . ')
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
							"' . $nama_ruang . '" AS JNS_URAIAN,
							"" AS NAMA_UNIT,
							"PMI" AS URAIAN,	
							SUM(trf.KUANTITI) AS JUMLAH,
							SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN trf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(trf.KELAS_RAWAT) = "3" THEN trf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(trf.KELAS_RAWAT) = "2" THEN trf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(trf.KELAS_RAWAT) = "1" THEN trf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "VIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(trf.KELAS_RAWAT) = "UTAMA 2" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "VVIP" THEN trf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(trf.KELAS_RAWAT) = "HCU" THEN trf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICU" THEN trf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(trf.KELAS_RAWAT) = "NICU" THEN trf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(trf.KELAS_RAWAT) = "PICU" THEN trf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(trf.KELAS_RAWAT) = "ICCU" THEN trf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(trf.KELAS_RAWAT) = "PERINA" THEN trf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SEHAT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(trf.KELAS_RAWAT) = "BAYI SAKIT" THEN trf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA	
							FROM db_simrs.t_irna irn
							INNER JOIN db_simrs.t_irna_tarif trf
							ON (irn.IRNA_ID = trf.IRNA_ID
							AND trf.NO_TARIF IS NOT NULL)
							INNER JOIN m_tarif mtr
							ON (trf.TARIF_ID = mtr.TARIF_ID)
							INNER JOIN m_tarif_group mtrg
							ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
							AND trf.JENIS_BAYAR_ID = "1"
							AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
							AND trf.RUANG_ID = "' . $dat_ruang['RUANG_ID'] . '"
							AND mtr.KODE_TARIF_GROUP IN (' . $arr_pmi . ')
							' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
							' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
							UNION ALL
							SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
							"' . $nama_ruang . '" AS JNS_URAIAN,
							"" AS NAMA_UNIT,
							"Jumlah Pasien & Cost Sharing" AS URAIAN,	
							COUNT(irn.IRNA_ID) AS JUMLAH,
							SUM(irn.COST_SHARING) AS BIAYA	
							FROM db_simrs.t_irna irn
							WHERE irn.NO_PENDAFTARAN IS NOT NULL 
							AND irn.ST_BATAL IS NULL
							AND irn.JENIS_BAYAR_ID = "' . $jns_bayar . '"
							AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
							AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
							AND irn.RUANG_ID = "' . $dat_ruang['RUANG_ID'] . '"';
}
	$qry_pembayaran .= ' UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"APOTIK RAWAT INAP" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					"PENERIMAAN OBAT" AS URAIAN,
					COUNT(DISTINCT fms.NO_PENGELUARAN) AS JUMLAH,
					SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS BIAYA
					FROM db_simrs.t_irna irn
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
					ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGELUARAN IS NOT NULL
					AND fms.JENIS_PENGELUARAN = "2"
					AND fms.ST_BATAL IS NULL)
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
					ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
					INNER JOIN db_simrs.m_ruang rng 
					ON (fms.RUANG_ID = rng.RUANG_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL 
					' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "1"
					AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . ' 
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
					UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"APOTIK RAWAT INAP" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					"RETURN OBAT" AS URAIAN,
					COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JUMLAH,
					0 - SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS BIAYA
					FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
					ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
					INNER JOIN db_simrs.t_irna irn
					ON (irn.IRNA_ID = fms.RANAP_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
					AND fms.JENIS_PENGEMBALIAN = "2")
					INNER JOIN db_simrs.m_ruang rng 
					ON (fms.RUANG_ID = rng.RUANG_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "1"
					AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . ' 
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
					UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"PENUNJANG RAWAT INAP" AS JNS_URAIAN,
					unt.NAMA_UNIT AS NAMA_UNIT,
					mpg.NAMA_PEGAWAI AS URAIAN,
					SUM(pnjtf.KUANTITI) AS JUMLAH,
					SUM(pnjtf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irna irn
					INNER JOIN db_simrs.t_ipenunjang pnj
					ON (irn.IRNA_ID = pnj.RAWAT_ID)
					INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
					ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
					AND pnjtf.NO_TARIF IS NOT NULL
					AND pnjtf.ST_BATAL IS NULL)
					INNER JOIN m_unit unt
					ON (pnjtf.UNIT_PENUNJANG_ID = unt.UNIT_ID)
					INNER JOIN m_tarif mtr
					ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_ruang rng 
					ON (pnj.RUANG_ID = rng.RUANG_ID)
					LEFT JOIN m_pegawai mpg
					ON (pnjtf.PEGAWAI_PERIKSA_ID = mpg.PEGAWAI_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "ORI")
					' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
					AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
					AND pnjtf.JENIS_BAYAR_ID = "1"
					AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY unt.NAMA_UNIT,mpg.NAMA_PEGAWAI';
					
if($jns_bayar == '1'){
	$qry_pembayaran .= ' UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"PENUNJANG RAWAT INAP" AS JNS_URAIAN,
					unt.NAMA_UNIT AS NAMA_UNIT,
					mpg.NAMA_PEGAWAI AS URAIAN,
					SUM(pnjtf.KUANTITI) AS JUMLAH,
					SUM(pnjtf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irna irn
					INNER JOIN db_simrs.t_ipenunjang pnj
					ON (irn.IRNA_ID = pnj.RAWAT_ID)
					INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
					ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
					AND pnjtf.NO_TARIF IS NOT NULL
					AND pnjtf.ST_BATAL IS NULL)
					INNER JOIN m_unit unt
					ON (pnjtf.UNIT_PENUNJANG_ID = unt.UNIT_ID)
					INNER JOIN m_tarif mtr
					ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_ruang rng 
					ON (pnj.RUANG_ID = rng.RUANG_ID)
					LEFT JOIN m_pegawai mpg
					ON (pnjtf.PEGAWAI_PERIKSA_ID = mpg.PEGAWAI_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND (pnj.JNS_ORDER = "IRN" OR pnj.JNS_ORDER = "ORI")
					AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
					AND pnjtf.JENIS_BAYAR_ID <> "1"
					AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					AND mtr.TDK_KLAIM = "1"
					' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY unt.NAMA_UNIT,mpg.NAMA_PEGAWAI';
}	
				
$qry_pembayaran .= ' UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"PENUNJANG RAWAT INAP" AS JNS_URAIAN,
					"Ambulance" AS NAMA_UNIT,
					"" AS URAIAN,		
					SUM(tfamb.KUANTITI) AS JUMLAH,
					SUM(tfamb.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irna irn 
					INNER JOIN db_simrs.t_ambulance_tarif tfamb
					ON (irn.IRNA_ID = tfamb.RAWAT_ID)
					INNER JOIN m_tarif mtr
					ON (tfamb.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_ruang rng 
					ON (tfamb.RUANG_ID = rng.RUANG_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND tfamb.JNS_ORDER = "IRN"
					' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
					AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND tfamb.ST_BAYAR = "Lunas"' : 'AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
					AND tfamb.JENIS_BAYAR_ID = "1"
					AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . '
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
					HAVING SUM(tfamb.KUANTITI) > 0';

if($jns_bayar == '1'){
	$qry_pembayaran .= ' UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"PENUNJANG RAWAT INAP" AS JNS_URAIAN,
					"Ambulance" AS NAMA_UNIT,
					"" AS URAIAN,		
					SUM(tfamb.KUANTITI) AS JUMLAH,
					SUM(tfamb.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irna irn 
					INNER JOIN db_simrs.t_ambulance_tarif tfamb
					ON (irn.IRNA_ID = tfamb.RAWAT_ID)
					INNER JOIN m_tarif mtr
					ON (tfamb.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_ruang rng 
					ON (tfamb.RUANG_ID = rng.RUANG_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND tfamb.JNS_ORDER = "IRN"
					AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
					AND tfamb.JENIS_BAYAR_ID <> "1"
					AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					AND mtr.TDK_KLAIM = "1"
					' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
					HAVING SUM(tfamb.KUANTITI) > 0';
}	

$qry_pembayaran .= ' UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"PENUNJANG RAWAT INAP" AS JNS_URAIAN,
					"Hemodialisa" AS NAMA_UNIT,
					"" AS URAIAN,	
					SUM(hmdtf.KUANTITI) AS JUMLAH,
					SUM(hmdtf.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irna irn
					INNER JOIN db_simrs.t_hemodialisa hmd
					ON (irn.IRNA_ID = hmd.RAWAT_ID)
					INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
					ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
					AND hmdtf.NO_TARIF IS NOT NULL)
					INNER JOIN m_tarif mtr
					ON (hmdtf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_ruang rng 
					ON (hmd.RUANG_ID = rng.RUANG_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND hmd.JNS_ORDER = "IRN"
					' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
					AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND hmdtf.ST_BAYAR = "Lunas"' : 'AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
					AND hmdtf.JENIS_BAYAR_ID = "1"
					AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					HAVING SUM(hmdtf.KUANTITI) > 0 ';

if($jns_bayar == '1'){
	$qry_pembayaran .= ' UNION ALL
					SELECT "PENERIMAAN RAWAT INAP UMUM" AS JENIS_PENERIMAAN,	
					"PENUNJANG RAWAT INAP" AS JNS_URAIAN,
					"Hemodialisa" AS NAMA_UNIT,
					"" AS URAIAN,	
					SUM(hmdtf.KUANTITI) AS JUMLAH,
					SUM(hmdtf.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irna irn
					INNER JOIN db_simrs.t_hemodialisa hmd
					ON (irn.IRNA_ID = hmd.RAWAT_ID)
					INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
					ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
					AND hmdtf.NO_TARIF IS NOT NULL)
					INNER JOIN m_tarif mtr
					ON (hmdtf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN db_simrs.m_ruang rng 
					ON (hmd.RUANG_ID = rng.RUANG_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND hmd.JNS_ORDER = "IRN"
					AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
					AND hmdtf.JENIS_BAYAR_ID <> "1"
					AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
					AND (rng.KUSTA IS NULL OR rng.KUSTA = "")
					AND mtr.TDK_KLAIM = "1"
					' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					HAVING SUM(hmdtf.KUANTITI) > 0 ';
}
?>