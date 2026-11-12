<?php
$qry_pembayaran = '-- karcis
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN, 
					"REGISTRASI" AS JNS_URAIAN,"" AS NAMA_UNIT,
					URAIAN,SUM(JUMLAH) AS JUMLAH,SUM(BIAYA) AS BIAYA
					FROM (
						SELECT mtr.TARIF_ID,
						mtr.NAMA_TARIF AS URAIAN,
						SUM(trf.KUANTITI) AS JUMLAH,
						SUM(trf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN db_simrs.t_irja_tarif trf
						ON (irj.IRJA_ID = trf.IRJA_ID
						AND trf.NO_TARIF IS NOT NULL)
						INNER JOIN m_tarif mtr
						ON (trf.TARIF_ID = mtr.TARIF_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35 
						' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
						AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
						AND trf.JENIS_BAYAR_ID = "1"
						AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
						AND mtr.KODE_TARIF_GROUP IN (' . $arr_karcis . ')
						' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY mtr.TARIF_ID
					
						UNION ALL
						SELECT mtr.TARIF_ID,
						mtr.NAMA_TARIF AS URAIAN,
						SUM(pnjtf.KUANTITI) AS JUMLAH,
						SUM(pnjtf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN db_simrs.t_ipenunjang pnj
						ON (irj.IRJA_ID = pnj.RAWAT_ID)
						INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
						ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
						AND pnjtf.NO_TARIF IS NOT NULL
						AND pnjtf.ST_BATAL IS NULL)
						INNER JOIN m_tarif mtr
						ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
						AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "ORJ") 
						' . (($jns_bayar != '1') ? 'AND DATE(pnjtf.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
						AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND pnjtf.JENIS_BAYAR_ID = "1"
						AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
						AND mtr.KODE_TARIF_GROUP IN (' . $arr_karcis . ')
						' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY mtr.TARIF_ID';
						
	if($jns_bayar == '1'){
		$qry_pembayaran .= ' UNION ALL
						SELECT mtr.TARIF_ID,
						mtr.NAMA_TARIF AS URAIAN,
						SUM(trf.KUANTITI) AS JUMLAH,
						SUM(trf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN db_simrs.t_irja_tarif trf
						ON (irj.IRJA_ID = trf.IRJA_ID
						AND trf.NO_TARIF IS NOT NULL)
						INNER JOIN m_tarif mtr
						ON (trf.TARIF_ID = mtr.TARIF_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
						AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
						AND trf.JENIS_BAYAR_ID <> "1"
						AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
						AND mtr.TDK_KLAIM = "1"	
						AND mtr.KODE_TARIF_GROUP IN (' . $arr_karcis . ')
						' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY mtr.TARIF_ID
						
						UNION ALL
						SELECT mtr.TARIF_ID,
						mtr.NAMA_TARIF AS URAIAN,
						SUM(pnjtf.KUANTITI) AS JUMLAH,
						SUM(pnjtf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN db_simrs.t_ipenunjang pnj
						ON (irj.IRJA_ID = pnj.RAWAT_ID)
						INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
						ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
						AND pnjtf.NO_TARIF IS NOT NULL
						AND pnjtf.ST_BATAL IS NULL)
						INNER JOIN m_tarif mtr
						ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
						AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "ORJ") 
						AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
						AND pnjtf.JENIS_BAYAR_ID <> "1"
						AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
						AND mtr.TDK_KLAIM = "1"	
						AND mtr.KODE_TARIF_GROUP IN (' . $arr_karcis . ')
						' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY mtr.TARIF_ID';	
						
	}
	
$qry_pembayaran .= ' ) t_rj_karcis	
					GROUP BY TARIF_ID
					
					-- konsul dokter
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN,	
					"KONSUL DOKTER" AS JNS_URAIAN,
					unt.NAMA_UNIT,
					CASE WHEN mpg.NAMA_PEGAWAI IS NOT NULL THEN mpg.NAMA_PEGAWAI ELSE mpg2.NAMA_PEGAWAI END AS URAIAN,
					SUM(trf.KUANTITI) AS JUMLAH,
					SUM(trf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irja irj
					INNER JOIN m_unit unt
					ON (irj.UNIT_ID = unt.UNIT_ID)
					INNER JOIN db_simrs.t_irja_tarif trf
					ON (irj.IRJA_ID = trf.IRJA_ID
					AND trf.NO_TARIF IS NOT NULL)
					INNER JOIN m_tarif mtr
					ON (trf.TARIF_ID = mtr.TARIF_ID)
					LEFT JOIN m_pegawai mpg
					ON (trf.PEGAWAI_ID = mpg.PEGAWAI_ID)
					LEFT JOIN m_pegawai mpg2
					ON (irj.PEGAWAI_ID = mpg2.PEGAWAI_ID)
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 61 AND irj.UNIT_ID <> 35
					' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
					AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
					AND trf.JENIS_BAYAR_ID = "1"
					AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
					AND mtr.KODE_TARIF IN (' . $arr_konsul_di_rj . ')
					' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY unt.NAMA_UNIT,URAIAN
					
					-- tindakan
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN, 
					"TINDAKAN RAWAT JALAN" AS JNS_URAIAN,NAMA_UNIT,
					URAIAN,SUM(JUMLAH) AS JUMLAH,SUM(BIAYA) AS BIAYA
					FROM (
						SELECT unt.NAMA_UNIT,
						mpg.NAMA_PEGAWAI AS URAIAN,
						SUM(trf.KUANTITI) AS JUMLAH,
						SUM(trf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN m_unit unt
						ON (irj.UNIT_ID = unt.UNIT_ID)
						INNER JOIN db_simrs.t_irja_tarif trf
						ON (irj.IRJA_ID = trf.IRJA_ID
						AND trf.NO_TARIF IS NOT NULL)
						INNER JOIN m_tarif mtr
						ON (trf.TARIF_ID = mtr.TARIF_ID)
						LEFT JOIN m_pegawai mpg
						ON (trf.PEGAWAI_ID = mpg.PEGAWAI_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 61 AND irj.UNIT_ID <> 35
						' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
						AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
						AND trf.JENIS_BAYAR_ID = "1"
						AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
						AND mtr.KODE_TARIF_GROUP NOT IN (' . $arr_karcis . ')
						AND mtr.KODE_TARIF NOT IN (' . $arr_konsul_di_rj . ')
						' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY unt.NAMA_UNIT,mpg.NAMA_PEGAWAI';
					
	if($jns_bayar == '1'){
		$qry_pembayaran .= ' UNION ALL
						SELECT unt.NAMA_UNIT,
						mpg.NAMA_PEGAWAI AS URAIAN,
						SUM(trf.KUANTITI) AS JUMLAH,
						SUM(trf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN m_unit unt
						ON (irj.UNIT_ID = unt.UNIT_ID)
						INNER JOIN db_simrs.t_irja_tarif trf
						ON (irj.IRJA_ID = trf.IRJA_ID
						AND trf.NO_TARIF IS NOT NULL)
						INNER JOIN m_tarif mtr
						ON (trf.TARIF_ID = mtr.TARIF_ID)
						LEFT JOIN m_pegawai mpg
						ON (trf.PEGAWAI_ID = mpg.PEGAWAI_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 61 AND irj.UNIT_ID <> 35
						AND DATE(trf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(trf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
						AND trf.JENIS_BAYAR_ID <> "1"
						AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")
						AND mtr.TDK_KLAIM = "1"	
						AND mtr.KODE_TARIF_GROUP NOT IN (' . $arr_karcis . ')
						' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY unt.NAMA_UNIT,mpg.NAMA_PEGAWAI';
	}					

$qry_pembayaran .= ' ) t_rj_tindakan	
					GROUP BY NAMA_UNIT,URAIAN
					
					-- paket mcu 
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN,	
					"MCU (MEDICAL CHECKUP)" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					mtr.NAMA_TARIF AS URAIAN,
					SUM(trf.KUANTITI) AS JUMLAH,
					SUM(trf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irja irj
					INNER JOIN db_simrs.t_irja_tarif trf
					ON (irj.IRJA_ID = trf.IRJA_ID
					AND trf.NO_TARIF IS NOT NULL)
					INNER JOIN m_tarif mtr
					ON (trf.TARIF_ID = mtr.TARIF_ID)
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID = 61 
					' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
					AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
					AND trf.JENIS_BAYAR_ID = "1"
					AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
					AND mtr.KODE_TARIF_GROUP = "120"
					AND mtr.MCU IS NULL
					' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY mtr.NAMA_TARIF
					
					-- tindakan mcu
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN,	
					"MCU (MEDICAL CHECKUP)" AS JNS_URAIAN,
					"TINDAKAN MCU" AS NAMA_UNIT,
					mtr.NAMA_TARIF AS URAIAN,
					SUM(trf.KUANTITI) AS JUMLAH,
					SUM(trf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM db_simrs.t_irja irj
					INNER JOIN db_simrs.t_irja_tarif trf
					ON (irj.IRJA_ID = trf.IRJA_ID
					AND trf.NO_TARIF IS NOT NULL)
					INNER JOIN m_tarif mtr
					ON (trf.TARIF_ID = mtr.TARIF_ID)
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID = 61 
					' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
					AND trf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
					AND trf.ST_BAYAR = "Lunas"' : 'AND DATE(trf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(trf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
					AND trf.JENIS_BAYAR_ID = "1"
					AND (trf.ST_VERIF IS NOT NULL OR trf.ST_BAYAR = "Lunas")') . '
					AND mtr.KODE_TARIF_GROUP <> "120"
					AND mtr.KODE_TARIF_GROUP NOT IN (' . $arr_karcis . ')
					' . (($cash != '') ? ' AND trf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND trf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					GROUP BY mtr.NAMA_TARIF
					
					-- farmasi
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN,	
					"APOTIK RAWAT JALAN UMUM" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					"PENERIMAAN OBAT" AS URAIAN,
					COUNT(DISTINCT fms.NO_PENGELUARAN) AS JUMLAH,
					SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS BIAYA
					FROM db_simrs.t_irja irj
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran fms
					ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGELUARAN IS NOT NULL
					AND fms.JENIS_PENGELUARAN = "1"
					AND fms.ST_BATAL IS NULL)
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
					ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
					' . (($jns_bayar != '1') ? 'AND DATE(fms.TANGGAL_KELUAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(fms.TANGGAL_KELUAR) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "1"
					AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . ' 
					' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
					
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN,
					"APOTIK APS" AS JNS_URAIAN,	
					"" AS NAMA_UNIT,
					"PENERIMAAN OBAT" AS URAIAN,
					COUNT(DISTINCT fms.NO_PENGELUARAN) AS JUMLAH,
					SUM(fmsd.JUMLAH_KELUAR * fmsd.HARGA_JUAL) AS BIAYA
					FROM db_inventorirs.t_farmasi_apotik_pengeluaran fms
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengeluaran_detail fmsd
					ON (fms.FARMASI_PENGELUARAN_APOTIK_ID = fmsd.FARMASI_PENGELUARAN_ID)
					WHERE fms.NO_PENGELUARAN IS NOT NULL 
					AND fms.JENIS_PENGELUARAN = "3"
					AND fms.ST_BATAL IS NULL
					' . (($jns_bayar != '1') ? 'AND fms.JAMINAN_ID = "xyz"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
					' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
					AND (fms.APS_MASUK = "1" OR fms.APS_MASUK = "" OR fms.APS_MASUK IS NULL) 
					GROUP BY JNS_URAIAN
					
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN,	
					"APOTIK RAWAT JALAN UMUM" AS JNS_URAIAN,
					"" AS NAMA_UNIT,
					"RETURN OBAT" AS URAIAN,
					COUNT(DISTINCT fms.NO_PENGEMBALIAN) AS JUMLAH,
					0 - SUM(fmsd.HARGA_JUAL * fmsd.JUMLAH_KEMBALI) AS BIAYA
					FROM db_inventorirs.t_farmasi_apotik_pengembalian_resep fms 
					INNER JOIN db_inventorirs.t_farmasi_apotik_pengembalian_resep_detail fmsd
					ON (fms.FARMASI_PENGEMBALIAN_APOTIK_ID = fmsd.FARMASI_PENGEMBALIAN_ID)
					INNER JOIN db_simrs.t_irja irj
					ON (irj.IRJA_ID = fms.RAJAL_ID AND fms.NO_PENGEMBALIAN IS NOT NULL
					AND fms.JENIS_PENGEMBALIAN = "1")
					WHERE irj.NO_PENDAFTARAN IS NOT NULL 
					AND irj.ST_BATAL IS NULL
					AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
					' . (($jns_bayar != '1') ? 'AND DATE(fms.TANGGAL_KEMBALI) >= ' . $tgl_filter_1 . ' 
					AND DATE(fms.TANGGAL_KEMBALI) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "' . $jns_bayar . '"' : 'AND DATE(fms.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(fms.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
					AND fms.JAMINAN_ID = "1"
					AND (fms.ST_VERIF IS NOT NULL OR fms.NO_PEMBAYARAN IS NOT NULL)') . '
					' . (($cash != '') ? ' AND fms.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND fms.KODE_REKENING = "' . $rekening . '" ' : '') . '
					
					-- penunjang 
					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN, 
					"PENUNJANG RAWAT JALAN" AS JNS_URAIAN,NAMA_UNIT,
					URAIAN,SUM(JUMLAH) AS JUMLAH,SUM(BIAYA) AS BIAYA
					FROM (
						SELECT unt.NAMA_UNIT AS NAMA_UNIT,
						mpg.NAMA_PEGAWAI AS URAIAN,
						SUM(pnjtf.KUANTITI) AS JUMLAH,
						SUM(pnjtf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN db_simrs.t_ipenunjang pnj
						ON (irj.IRJA_ID = pnj.RAWAT_ID)
						INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
						ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
						AND pnjtf.NO_TARIF IS NOT NULL
						AND pnjtf.ST_BATAL IS NULL)
						INNER JOIN m_unit unt
						ON (pnjtf.UNIT_PENUNJANG_ID = unt.UNIT_ID)
						INNER JOIN m_tarif mtr
						ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
						LEFT JOIN m_pegawai mpg
						ON (pnjtf.PEGAWAI_PERIKSA_ID = mpg.PEGAWAI_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
						AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "ORJ") 
						' . (($jns_bayar != '1') ? 'AND DATE(pnjtf.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
						AND pnjtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND pnjtf.ST_BAYAR = "Lunas"' : 'AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
						AND pnjtf.JENIS_BAYAR_ID = "1"
						AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")') . '
						AND mtr.KODE_TARIF_GROUP NOT IN (' . $arr_karcis . ')
						' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY unt.NAMA_UNIT,mpg.NAMA_PEGAWAI
						
						UNION ALL
						SELECT "Ambulance" AS NAMA_UNIT,
						"" AS URAIAN,		
						SUM(tfamb.KUANTITI) AS JUMLAH,
						SUM(tfamb.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj 
						INNER JOIN db_simrs.t_ambulance_tarif tfamb
						ON (irj.IRJA_ID = tfamb.RAWAT_ID)
						INNER JOIN m_tarif mtr
						ON (tfamb.TARIF_ID = mtr.TARIF_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35  
						AND tfamb.JNS_ORDER = "IRJ"
						' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
						AND tfamb.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND tfamb.ST_BAYAR = "Lunas"' : 'AND DATE(tfamb.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(tfamb.TGL_BAYAR) <= ' . $tgl_filter_2 . '
						AND tfamb.JENIS_BAYAR_ID = "1"
						AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")') . '
						' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
						HAVING SUM(tfamb.KUANTITI) > 0 
						
						UNION ALL
						SELECT "Hemodialisa" AS NAMA_UNIT,
						"" AS URAIAN,	
						SUM(hmdtf.KUANTITI) AS JUMLAH,
						SUM(hmdtf.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN db_simrs.t_hemodialisa hmd
						ON (irj.IRJA_ID = hmd.RAWAT_ID)
						INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
						ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
						AND hmdtf.NO_TARIF IS NOT NULL)
						INNER JOIN m_tarif mtr
						ON (hmdtf.TARIF_ID = mtr.TARIF_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND hmd.JNS_ORDER = "IRJ"
						' . (($jns_bayar != '1') ? 'AND DATE(irj.TANGGAL_DAFTAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(irj.TANGGAL_DAFTAR) <= ' . $tgl_filter_2 . '
						AND hmdtf.JENIS_BAYAR_ID = "' . $jns_bayar . '"
						AND hmdtf.ST_BAYAR = "Lunas"' : 'AND DATE(hmdtf.TGL_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(hmdtf.TGL_BAYAR) <= ' . $tgl_filter_2 . '
						AND hmdtf.JENIS_BAYAR_ID = "1"
						AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")') . '
						' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						HAVING SUM(hmdtf.KUANTITI) > 0 ';
					
	if($jns_bayar == '1'){
		$qry_pembayaran .= ' UNION ALL
						SELECT unt.NAMA_UNIT AS NAMA_UNIT,
						mpg.NAMA_PEGAWAI AS URAIAN,
						SUM(pnjtf.KUANTITI) AS JUMLAH,
						SUM(pnjtf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj
						INNER JOIN db_simrs.t_ipenunjang pnj
						ON (irj.IRJA_ID = pnj.RAWAT_ID)
						INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
						ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
						AND pnjtf.NO_TARIF IS NOT NULL
						AND pnjtf.ST_BATAL IS NULL)
						INNER JOIN m_unit unt
						ON (pnjtf.UNIT_PENUNJANG_ID = unt.UNIT_ID)
						INNER JOIN m_tarif mtr
						ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
						LEFT JOIN m_pegawai mpg
						ON (pnjtf.PEGAWAI_PERIKSA_ID = mpg.PEGAWAI_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35
						AND (pnj.JNS_ORDER = "IRJ" OR pnj.JNS_ORDER = "ORJ") 
						AND DATE(pnjtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(pnjtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
						AND pnjtf.JENIS_BAYAR_ID <> "1"
						AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
						AND mtr.TDK_KLAIM = "1"
						AND mtr.KODE_TARIF_GROUP NOT IN (' . $arr_karcis . ')
						' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						GROUP BY unt.NAMA_UNIT,mpg.NAMA_PEGAWAI
						
						UNION ALL
						SELECT "Ambulance" AS NAMA_UNIT,
						"" AS URAIAN,		
						SUM(tfamb.KUANTITI) AS JUMLAH,
						SUM(tfamb.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja irj 
						INNER JOIN db_simrs.t_ambulance_tarif tfamb
						ON (irj.IRJA_ID = tfamb.RAWAT_ID)
						INNER JOIN m_tarif mtr
						ON (tfamb.TARIF_ID = mtr.TARIF_ID)
						WHERE irj.NO_PENDAFTARAN IS NOT NULL 
						AND irj.ST_BATAL IS NULL
						AND irj.UNIT_ID NOT IN (' . $arr_igd . ') AND irj.UNIT_ID <> 35  
						AND tfamb.JNS_ORDER = "IRJ"
						AND DATE(tfamb.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(tfamb.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
						AND tfamb.JENIS_BAYAR_ID <> "1"
						AND (tfamb.ST_VERIF IS NOT NULL OR tfamb.ST_BAYAR = "Lunas")
						AND mtr.TDK_KLAIM = "1"
						' . (($cash != '') ? ' AND tfamb.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND tfamb.KODE_REKENING = "' . $rekening . '" ' : '') . '
						HAVING SUM(tfamb.KUANTITI) > 0 
						
						UNION ALL
						SELECT "Hemodialisa" AS NAMA_UNIT,
						"" AS URAIAN,	
						SUM(hmdtf.KUANTITI) AS JUMLAH,
						SUM(hmdtf.KUANTITI *  mtr.TARIF_NON_KELAS) AS BIAYA
						FROM db_simrs.t_irja igd
						INNER JOIN db_simrs.t_hemodialisa hmd
						ON (igd.IRJA_ID = hmd.RAWAT_ID)
						INNER JOIN db_simrs.t_hemodialisa_tarif hmdtf
						ON (hmd.HEMODIALISA_ID = hmdtf.HEMODIALISA_ID
						AND hmdtf.NO_TARIF IS NOT NULL)
						INNER JOIN m_tarif mtr
						ON (hmdtf.TARIF_ID = mtr.TARIF_ID)
						WHERE igd.NO_PENDAFTARAN IS NOT NULL 
						AND igd.ST_BATAL IS NULL
						AND hmd.JNS_ORDER = "IRJ"
						AND DATE(hmdtf.TDK_KLAIM_BAYAR) >= ' . $tgl_filter_1 . ' 
						AND DATE(hmdtf.TDK_KLAIM_BAYAR) <= ' . $tgl_filter_2 . '
						AND hmdtf.JENIS_BAYAR_ID <> "1"
						AND (hmdtf.ST_VERIF IS NOT NULL OR hmdtf.ST_BAYAR = "Lunas")
						AND mtr.TDK_KLAIM = "1"
						' . (($cash != '') ? ' AND hmdtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
						' . (($rekening != '') ? ' AND hmdtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
						HAVING SUM(hmdtf.KUANTITI) > 0 ';	
	}					

$qry_pembayaran .= ' ) t_rj_penunjang	
					GROUP BY NAMA_UNIT,URAIAN					

					UNION ALL
					SELECT "PENERIMAAN RAWAT JALAN UMUM" AS JENIS_PENERIMAAN,	
					"PENUNJANG APS" AS JNS_URAIAN,
					unt.NAMA_UNIT AS NAMA_UNIT,
					mpg.NAMA_PEGAWAI AS URAIAN,
					SUM(pnjtf.KUANTITI) AS JUMLAH,
					SUM(pnjtf.KUANTITI * mtr.TARIF_NON_KELAS) AS BIAYA
					FROM t_ipenunjang pnj
					INNER JOIN db_simrs.t_ipenunjang_tarif pnjtf
					ON (pnj.PENUNJANG_ID = pnjtf.PENUNJANG_ID
					AND pnjtf.NO_TARIF IS NOT NULL
					AND pnjtf.ST_BATAL IS NULL)
					INNER JOIN m_unit unt
					ON (pnjtf.UNIT_PENUNJANG_ID = unt.UNIT_ID)
					INNER JOIN m_tarif mtr
					ON (pnjtf.TARIF_ID = mtr.TARIF_ID)
					LEFT JOIN m_pegawai mpg
					ON (pnjtf.PEGAWAI_PERIKSA_ID = mpg.PEGAWAI_ID)
					WHERE pnj.JNS_ORDER = "APS"
					AND pnj.JENIS_BAYAR_ID = "' . $jns_bayar . '" 
					AND DATE(pnjtf.TANGGAL_BAYAR) >= ' . $tgl_filter_1 . ' 
					AND DATE(pnjtf.TANGGAL_BAYAR) <= ' . $tgl_filter_2 . '
					AND (pnjtf.ST_VERIF IS NOT NULL OR pnjtf.ST_BAYAR = "Lunas")
					AND pnjtf.NO_TARIF IS NOT NULL
					AND pnjtf.ST_BATAL IS NULL
					' . (($cash != '') ? ' AND pnjtf.KODE_CASH = "' . $cash . '" ' : '') . ' 
					' . (($rekening != '') ? ' AND pnjtf.KODE_REKENING = "' . $rekening . '" ' : '') . '
					AND (pnjtf.APS_MASUK = "1" OR pnjtf.APS_MASUK = "" OR pnjtf.APS_MASUK IS NULL)
					GROUP BY JNS_URAIAN,unt.NAMA_UNIT,mpg.NAMA_PEGAWAI';					
?>