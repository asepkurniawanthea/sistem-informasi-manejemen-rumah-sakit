<?php
$qry_pembayaran .= '-- kamar operasi kusta
					UNION ALL
					SELECT "PENERIMAAN KAMAR OPERASI KUSTA" AS JENIS_PENERIMAAN,	
					"" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					mpg.NAMA_PEGAWAI AS URAIAN,	
					COUNT(opr.OPERASI_ID) AS JUMLAH,
					0 AS BIAYA
					FROM db_simrs.t_irja irj
					INNER JOIN db_simrs.t_operasi opr
					ON (irj.IRJA_ID = opr.RAWAT_ID)
					INNER JOIN m_pegawai mpg
					ON (opr.PEGAWAI_PELAKSANA_ID = mpg.PEGAWAI_ID)
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID = 35
					AND opr.NO_PENDAFTARAN IS NOT NULL
					AND opr.ST_MASUK = "1"
					AND opr.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE(opr.TANGGAL_OPERASI) >= ' . $tgl_filter_1 . ' 
					AND DATE(opr.TANGGAL_OPERASI) <= ' . $tgl_filter_2 . '
					GROUP BY mpg.NAMA_PEGAWAI
					HAVING COUNT(opr.OPERASI_ID) > 0
					UNION ALL
					SELECT "PENERIMAAN KAMAR OPERASI KUSTA" AS JENIS_PENERIMAAN,	
					"" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					mpg.NAMA_PEGAWAI AS URAIAN,	
					COUNT(opr.OPERASI_ID) AS JUMLAH,
					0 AS BIAYA
					FROM db_simrs.t_irna irn
					INNER JOIN db_simrs.t_operasi opr
					ON (irn.IRNA_ID = opr.RAWAT_ID)
					INNER JOIN m_pegawai mpg
					ON (opr.PEGAWAI_PELAKSANA_ID = mpg.PEGAWAI_ID)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND opr.NO_PENDAFTARAN IS NOT NULL
					AND opr.ST_MASUK = "2"
					AND opr.RUANG_ID IN (
						SELECT r.RUANG_ID FROM m_ruang r WHERE r.KUSTA = "1"
					)
					AND opr.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND DATE(opr.TANGGAL_OPERASI) >= ' . $tgl_filter_1 . ' 
					AND DATE(opr.TANGGAL_OPERASI) <= ' . $tgl_filter_2 . ' 
					GROUP BY mpg.NAMA_PEGAWAI
					HAVING COUNT(opr.OPERASI_ID) > 0
					UNION ALL
					SELECT "PENERIMAAN KAMAR OPERASI KUSTA" AS JENIS_PENERIMAAN,	
					"" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					mtrg.NAMA_TARIF_GROUP AS URAIAN,	
					SUM(optf.KUANTITI) AS JUMLAH,
					SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN optf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(optf.KELAS_RAWAT) = "3" THEN optf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(optf.KELAS_RAWAT) = "2" THEN optf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(optf.KELAS_RAWAT) = "1" THEN optf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "VIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA 2" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "VVIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "HCU" THEN optf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICU" THEN optf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(optf.KELAS_RAWAT) = "NICU" THEN optf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(optf.KELAS_RAWAT) = "PICU" THEN optf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICCU" THEN optf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(optf.KELAS_RAWAT) = "PERINA" THEN optf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SEHAT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SAKIT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA
					FROM db_simrs.t_irja irj 
					INNER JOIN db_simrs.t_operasi opr
					ON (irj.IRJA_ID = opr.RAWAT_ID)
					INNER JOIN db_simrs.t_operasi_tarif optf
					ON (opr.OPERASI_ID = optf.OPERASI_ID
					AND optf.NO_TARIF IS NOT NULL
					AND opr.ST_MASUK = "1")
					INNER JOIN m_tarif mtr
					ON (optf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID = 35
					' . (($jns_bayar != '1') ? 'AND DATE(opr.TANGGAL_OPERASI) >= ' . $tgl_filter_1 . ' 
					AND DATE(opr.TANGGAL_OPERASI) <= ' . $tgl_filter_2 . '
					AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND optf.ST_BAYAR = "Lunas"' : 'AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
					AND optf.JENIS_BAYAR_ID = "1"
					AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
					' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY mtrg.NAMA_TARIF_GROUP
					HAVING SUM(optf.KUANTITI) > 0
					UNION ALL
					SELECT "PENERIMAAN KAMAR OPERASI KUSTA" AS JENIS_PENERIMAAN,	
					"" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					mtrg.NAMA_TARIF_GROUP AS URAIAN,	
					SUM(optf.KUANTITI) AS JUMLAH,
					SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN optf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(optf.KELAS_RAWAT) = "3" THEN optf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(optf.KELAS_RAWAT) = "2" THEN optf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(optf.KELAS_RAWAT) = "1" THEN optf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "VIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA 2" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "VVIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "HCU" THEN optf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICU" THEN optf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(optf.KELAS_RAWAT) = "NICU" THEN optf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(optf.KELAS_RAWAT) = "PICU" THEN optf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICCU" THEN optf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(optf.KELAS_RAWAT) = "PERINA" THEN optf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SEHAT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SAKIT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA
					FROM db_simrs.t_irna irn 
					INNER JOIN db_simrs.t_operasi opr
					ON (irn.IRNA_ID = opr.RAWAT_ID)
					INNER JOIN db_simrs.t_operasi_tarif optf
					ON (opr.OPERASI_ID = optf.OPERASI_ID
					AND optf.NO_TARIF IS NOT NULL
					AND opr.ST_MASUK = "2")
					INNER JOIN m_tarif mtr
					ON (optf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND opr.RUANG_ID IN (
						SELECT r.RUANG_ID FROM m_ruang r WHERE r.KUSTA = "1" 	
					)
					' . (($jns_bayar != '1') ? 'AND DATE(irn.PASIEN_KELUAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irn.PASIEN_KELUAR) <= ' . $tgl_filter_2 . '
					AND optf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND optf.ST_BAYAR = "Lunas"' : 'AND DATE(optf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(optf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
					AND optf.JENIS_BAYAR_ID = "1"
					AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")') . '
					' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY mtrg.NAMA_TARIF_GROUP
					HAVING SUM(optf.KUANTITI) > 0 ';
if($jns_bayar == '1'){
	$qry_pembayaran .= ' UNION ALL
					SELECT "PENERIMAAN KAMAR OPERASI KUSTA" AS JENIS_PENERIMAAN,	
					"" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					mtrg.NAMA_TARIF_GROUP AS URAIAN,	
					SUM(optf.KUANTITI) AS JUMLAH,
					SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN optf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(optf.KELAS_RAWAT) = "3" THEN optf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(optf.KELAS_RAWAT) = "2" THEN optf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(optf.KELAS_RAWAT) = "1" THEN optf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "VIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA 2" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "VVIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "HCU" THEN optf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICU" THEN optf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(optf.KELAS_RAWAT) = "NICU" THEN optf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(optf.KELAS_RAWAT) = "PICU" THEN optf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICCU" THEN optf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(optf.KELAS_RAWAT) = "PERINA" THEN optf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SEHAT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SAKIT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA
					FROM db_simrs.t_irja irj 
					INNER JOIN db_simrs.t_operasi opr
					ON (irj.IRJA_ID = opr.RAWAT_ID)
					INNER JOIN db_simrs.t_operasi_tarif optf
					ON (opr.OPERASI_ID = optf.OPERASI_ID
					AND optf.NO_TARIF IS NOT NULL
					AND opr.ST_MASUK = "1")
					INNER JOIN m_tarif mtr
					ON (optf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID = 35
					AND optf.JENIS_BAYAR_ID <> "1"
					AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
					AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
					AND mtr.TDK_KLAIM = "1"
					' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY mtrg.NAMA_TARIF_GROUP
					HAVING SUM(optf.KUANTITI) > 0
					UNION ALL
					SELECT "PENERIMAAN KAMAR OPERASI KUSTA" AS JENIS_PENERIMAAN,	
					"" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					mtrg.NAMA_TARIF_GROUP AS URAIAN,	
					SUM(optf.KUANTITI) AS JUMLAH,
					SUM(CASE WHEN mtrg.NON_KELAS = "1" 
									THEN optf.KUANTITI * mtr.TARIF_NON_KELAS
								ELSE	
									CASE WHEN UPPER(optf.KELAS_RAWAT) = "3" THEN optf.KUANTITI * mtr.TARIF_KELAS_3 
										WHEN UPPER(optf.KELAS_RAWAT) = "2" THEN optf.KUANTITI * mtr.TARIF_KELAS_2
										WHEN UPPER(optf.KELAS_RAWAT) = "1" THEN optf.KUANTITI * mtr.TARIF_KELAS_1
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "VIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA
										WHEN UPPER(optf.KELAS_RAWAT) = "UTAMA 2" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "VVIP" THEN optf.KUANTITI * mtr.TARIF_KELAS_UTAMA_2
										WHEN UPPER(optf.KELAS_RAWAT) = "HCU" THEN optf.KUANTITI * mtr.TARIF_HCU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICU" THEN optf.KUANTITI * mtr.TARIF_ICU
										WHEN UPPER(optf.KELAS_RAWAT) = "NICU" THEN optf.KUANTITI * mtr.TARIF_NICU
										WHEN UPPER(optf.KELAS_RAWAT) = "PICU" THEN optf.KUANTITI * mtr.TARIF_PICU
										WHEN UPPER(optf.KELAS_RAWAT) = "ICCU" THEN optf.KUANTITI * mtr.TARIF_ICCU
										WHEN UPPER(optf.KELAS_RAWAT) = "PERINA" THEN optf.KUANTITI * mtr.TARIF_PERINA
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SEHAT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SEHAT
										WHEN UPPER(optf.KELAS_RAWAT) = "BAYI SAKIT" THEN optf.KUANTITI * mtr.TARIF_KELAS_PERINA_SAKIT
									END 
								END
							) AS BIAYA
					FROM db_simrs.t_irna irn 
					INNER JOIN db_simrs.t_operasi opr
					ON (irn.IRNA_ID = opr.RAWAT_ID)
					INNER JOIN db_simrs.t_operasi_tarif optf
					ON (opr.OPERASI_ID = optf.OPERASI_ID
					AND optf.NO_TARIF IS NOT NULL
					AND opr.ST_MASUK = "2")
					INNER JOIN m_tarif mtr
					ON (optf.TARIF_ID = mtr.TARIF_ID)
					INNER JOIN m_tarif_group mtrg
					ON (mtr.KODE_TARIF_GROUP = mtrg.KODE_TARIF_GROUP)
					WHERE irn.NO_PENDAFTARAN IS NOT NULL 
					AND irn.ST_BATAL IS NULL
					AND opr.RUANG_ID IN (
						SELECT r.RUANG_ID FROM m_ruang r WHERE r.KUSTA = "1"	
					)
					AND optf.JENIS_BAYAR_ID <> "1"
					AND DATE(optf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(optf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
					AND (optf.ST_VERIF IS NOT NULL OR optf.ST_BAYAR = "Lunas")
					AND mtr.TDK_KLAIM = "1"
					' . (($cash != '') ? ' AND optf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND optf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY mtrg.NAMA_TARIF_GROUP
					HAVING SUM(optf.KUANTITI) > 0';
}	
?>