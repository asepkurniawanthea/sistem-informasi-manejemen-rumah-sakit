<?php
function set_terbilang($x) {
    $abil = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    if ($x < 12)
        return ' ' . $abil[$x];
    elseif ($x < 20)
        return set_terbilang($x - 10) . 'belas';
    elseif ($x < 100)
        return set_terbilang($x / 10) . ' puluh' . set_terbilang($x % 10);
    elseif ($x < 200)
        return ' seratus' . set_terbilang($x - 100);
    elseif ($x < 1000)
        return set_terbilang($x / 100) . ' ratus' . set_terbilang($x % 100);
    elseif ($x < 2000)
        return ' seribu' . set_terbilang($x - 1000);
    elseif ($x < 1000000)
        return set_terbilang($x / 1000) . ' ribu' . set_terbilang($x % 1000);
    elseif ($x < 1000000000)
        return set_terbilang($x / 1000000) . ' juta' . set_terbilang($x % 1000000);
}

function inacbg_create_billing($rawat,$id,$no_sep){
	global $hostname_3, $username_3, $password_3, $database_3, $connect_3;
	global $hostname, $username, $password, $database, $connect;
	global $eklaim_arsip_path;
		
	$arr_bulan['01'] = 'Januari';
	$arr_bulan['02'] = 'Februari';
	$arr_bulan['03'] = 'Maret';
	$arr_bulan['04'] = 'April';
	$arr_bulan['05'] = 'Mei';
	$arr_bulan['06'] = 'Juni';
	$arr_bulan['07'] = 'Juli';
	$arr_bulan['08'] = 'Agustus';
	$arr_bulan['09'] = 'September';
	$arr_bulan['10'] = 'Oktober';
	$arr_bulan['11'] = 'Nopember';
	$arr_bulan['12'] = 'Desember';

	if($rawat == '2'){
		$templatebilling = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\billing_rawat_jalan.docx');
		$qry_billing = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%e") AS HARI_DAFTAR,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m") AS BULAN_DAFTAR,
				DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y") AS TAHUN_DAFTAR,
				m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN,
				t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,t_irja.NO_PENDAFTARAN,
				t_irja_tarif.USER_PENDAFTARAN,t_irja_tarif.USER_KASIR,m_pasien.NAMA_PASIEN,
				m_pasien.ALAMAT,m_pasien.NO_TELEPON
				FROM t_irja 
				INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
				INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
				LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja.IRJA_ID = "' . $id . '"';
		$get_billing = mysql_query($qry_billing) or die(mysql_error());
		$dat_billing = mysql_fetch_assoc($get_billing);
		$templatebilling->setValue('nama_pasien', htmlspecialchars($dat_billing['NAMA_PASIEN']));
		$templatebilling->setValue('nomor_mr', formatNoMR($dat_billing['NOMR']));
		$templatebilling->setValue('alamat', htmlspecialchars($dat_billing['ALAMAT'] . '/' . $dat_billing['NO_TELEPON']));
		$templatebilling->setValue('nomor_billing', htmlspecialchars($dat_billing['NO_PENDAFTARAN']));
		$templatebilling->setValue('klinik_ruang', htmlspecialchars(strtoupper($dat_billing['NAMA_UNIT'])));
		$templatebilling->setValue('nama_dokter', htmlspecialchars(strtoupper($dat_billing['NAMA_PEGAWAI'])));
		$templatebilling->setValue('tanggal', 'Tangerang, ' . $dat_billing['HARI_DAFTAR'] . ' ' . ((isset($arr_bulan[$dat_billing['BULAN_DAFTAR']])) ? $arr_bulan[$dat_billing['BULAN_DAFTAR']] : '') . ' ' . $dat_billing['TAHUN_DAFTAR']);
		$templatebilling->setValue('pembayaran', htmlspecialchars($dat_billing['NAMA_JAMINAN']));
		$kasir = explode('|',$dat_billing['USER_KASIR']);
		if(isset($kasir[1])) {
			$templatebilling->setValue('kasir',htmlspecialchars($kasir[1]));	
		}else{
			$templatebilling->setValue('kasir','');	
		}
	
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
			FROM t_irja_tarif
			INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE t_irja_tarif.IRJA_ID = "' . $id . '"
			AND t_irja_tarif.NO_TARIF IS NOT NULL
			AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
			AND t_irja_tarif.ST_BAYAR = "Lunas"
			AND t_irja_tarif.ST_BATAL IS NULL
			ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRJA_ID' => '',
				'TARIF_ID' => '',
				'KODE_TARIF' => '',
				'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
				'KUANTITI' => '0',
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => '',
				'TARIF_NON_KELAS' => '0',
				'NAMA_TARIF_GROUP' => ''
			);
				
			$sql2 = 'SELECT t_irja_tarif.IRJA_ID,t_irja_tarif.TARIF_ID,m_tarif.KODE_TARIF,
					m_tarif.NAMA_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,m_tarif.SATUAN,
					SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,
					m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
					FROM t_irja_tarif
					INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_irja_tarif.IRJA_ID = "' . $id . '"
					AND t_irja_tarif.NO_TARIF IS NOT NULL
					AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
					AND t_irja_tarif.ST_BAYAR = "Lunas"
					AND t_irja_tarif.ST_BATAL IS NULL
					AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
					GROUP BY t_irja_tarif.TARIF_ID';
					
			$q2 = mysql_query($sql2);
			while ($r2 = mysql_fetch_array($q2)) {
				$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
					'TARIF_ID' => $r2['TARIF_ID'],
					'KODE_TARIF' => $r2['KODE_TARIF'],
					'NAMA_TARIF' => $r2['NAMA_TARIF'],
					'KUANTITI' => $r2['KUANTITI'],
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => $r2['SATUAN'],
					'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
					'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}		
	
		//penunjang
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE t_ipenunjang.RAWAT_ID = "' . $id . '"
			AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
			AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
			AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
			AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
			AND t_ipenunjang_tarif.ST_BATAL IS NULL
			ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRJA_ID' => '',
				'TARIF_ID' => '',
				'KODE_TARIF' => '',
				'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
				'KUANTITI' => '0',
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => '',
				'TARIF_NON_KELAS' => '0',
				'NAMA_TARIF_GROUP' => ''
			);
			
			$sql2 = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID AS IRJA_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
				COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,m_tarif.SATUAN,
				COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '"
				AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
				GROUP BY t_ipenunjang_tarif.TARIF_ID';
				
			$q2 = mysql_query($sql2);
			while ($r2 = mysql_fetch_array($q2)) {
				$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
					'TARIF_ID' => $r2['TARIF_ID'],
					'KODE_TARIF' => $r2['KODE_TARIF'],
					'NAMA_TARIF' => $r2['NAMA_TARIF'],
					'KUANTITI' => $r2['KUANTITI'],
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => $r2['SATUAN'],
					'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
					'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}

		//operasi
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
			FROM t_operasi 
			INNER JOIN t_operasi_tarif ON (t_operasi.OPERASI_ID = t_operasi_tarif.OPERASI_ID)
			INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE t_operasi.RAWAT_ID = "' . $id . '"
			AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
			AND t_operasi_tarif.NO_TARIF IS NOT NULL
			AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
			AND t_operasi_tarif.ST_BAYAR = "Lunas"
			AND t_operasi.ST_BATAL IS NULL
			ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRJA_ID' => '',
				'TARIF_ID' => '',
				'KODE_TARIF' => '',
				'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
				'KUANTITI' => '0',
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => '',
				'TARIF_NON_KELAS' => '0',
				'NAMA_TARIF_GROUP' => ''
			);
			
		$sql2 = 'SELECT t_operasi_tarif.OPERASI_ID AS IRJA_ID,t_operasi_tarif.TARIF_ID,
				m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,
				COUNT(DISTINCT t_operasi_tarif.OPERASI_TARIF_ID) AS KUANTITI,m_tarif.SATUAN,
				COUNT(DISTINCT t_operasi_tarif.OPERASI_TARIF_ID) * (
				CASE WHEN t_operasi_tarif.KELAS_RAWAT = "3" THEN m_tarif.TARIF_KELAS_3
					WHEN t_operasi_tarif.KELAS_RAWAT = "2" THEN m_tarif.TARIF_KELAS_2
					WHEN t_operasi_tarif.KELAS_RAWAT = "1" THEN m_tarif.TARIF_KELAS_1
					WHEN t_operasi_tarif.KELAS_RAWAT = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
					WHEN t_operasi_tarif.KELAS_RAWAT = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
					WHEN t_operasi_tarif.KELAS_RAWAT = "HCU" THEN m_tarif.TARIF_HCU 
				END) AS TARIF_NON_KELAS,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
				FROM t_operasi
				INNER JOIN t_operasi_tarif ON (t_operasi.OPERASI_ID = t_operasi_tarif.OPERASI_ID)
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi.RAWAT_ID = "' . $id . '"
				AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"
				AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_operasi_tarif.ST_BAYAR = "Lunas"
				AND t_operasi.ST_BATAL IS NULL
				AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
				GROUP BY t_operasi_tarif.TARIF_ID';
				
		$q2 = mysql_query($sql2);
		while ($r2 = mysql_fetch_array($q2)) {
			$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
				'TARIF_ID' => $r2['TARIF_ID'],
				'KODE_TARIF' => $r2['KODE_TARIF'],
				'NAMA_TARIF' => $r2['NAMA_TARIF'],
				'KUANTITI' => $r2['KUANTITI'],
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => $r2['SATUAN'],
				'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
				'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
			);
		}
	}
		//end operasi
		
		//hemodialisa
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_hemodialisa 
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_hemodialisa.RAWAT_ID = "' . $id . '"
				AND t_hemodialisa.JNS_ORDER = "IRJ"
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
				AND t_hemodialisa.ST_BATAL IS NULL
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRJA_ID' => '',
				'TARIF_ID' => '',
				'KODE_TARIF' => '',
				'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
				'KUANTITI' => '0',
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => '',
				'TARIF_NON_KELAS' => '0',
				'NAMA_TARIF_GROUP' => ''
			);
				
			$sql2 = 'SELECT t_hemodialisa_tarif.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa_tarif.TARIF_ID,
					m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,
					COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,m_tarif.SATUAN,
					COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
					m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
					FROM t_hemodialisa
					INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
					INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_hemodialisa.RAWAT_ID = "' . $id . '"
					AND t_hemodialisa.JNS_ORDER = "IRJ"
					AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
					AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
					AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
					AND t_hemodialisa.ST_BATAL IS NULL
					AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
					GROUP BY t_hemodialisa_tarif.TARIF_ID';
					
			$q2 = mysql_query($sql2);
			while ($r2 = mysql_fetch_array($q2)) {
				$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
					'TARIF_ID' => $r2['TARIF_ID'],
					'KODE_TARIF' => $r2['KODE_TARIF'],
					'NAMA_TARIF' => $r2['NAMA_TARIF'],
					'KUANTITI' => $r2['KUANTITI'],
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => $r2['SATUAN'],
					'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
					'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}
	
		$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());

		$sql = 'SELECT t_farmasi.PERSEDIAAN_ID,
			t_farmasi.HARGA_JUAL,
			SUM(t_farmasi.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			t_farmasi.NAMA_PERSEDIAAN,
			t_farmasi.SATUAN,
			t_farmasi.RACIKAN,
			t_farmasi.NAMA_RACIKAN,
			t_farmasi.PERSEDIAAN,
			t_farmasi.GENERIK,
			t_farmasi.ALKES,
			SUM(t_farmasi.HARGA_TOTAL) AS HARGA_TOTAL 
			FROM (
			SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN,
			CASE WHEN t_rajal_resep_detail.RACIKAN = "1" THEN CONCAT(t_rajal_resep_detail.NAMA_RACIKAN," (", m_persediaan_farmasi.NAMA_PERSEDIAAN,")") 
			ELSE m_persediaan_farmasi.NAMA_PERSEDIAAN END AS PERSEDIAAN,
			CASE WHEN t_rajal_resep_detail.GENERIK = "1" THEN "v" END AS GENERIK,
			CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "v" END AS ALKES,
			SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
			- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
			(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA_TOTAL
			FROM t_rajal_resep 
			INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
			INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
			INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
			WHERE t_rajal_resep.RAJAL_ID = "' . $id . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL 
			AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1"
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
			UNION ALL
			SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN,
			CASE WHEN t_rajal_resep_detail.RACIKAN = "1" THEN CONCAT(t_rajal_resep_detail.NAMA_RACIKAN," (", m_persediaan_farmasi.NAMA_PERSEDIAAN,")") 
			ELSE m_persediaan_farmasi.NAMA_PERSEDIAAN END AS PERSEDIAAN,
			CASE WHEN t_rajal_resep_detail.GENERIK = "1" THEN "v" END AS GENERIK,
			CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "v" END AS ALKES,
			SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
			- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
			(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA_TOTAL
			FROM t_rajal_resep 
			INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
			INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
			INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
			WHERE t_rajal_resep.RAJAL_ID = "' . $id . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
			) t_farmasi
			GROUP BY t_farmasi.PERSEDIAAN_ID,
			t_farmasi.HARGA_JUAL,
			t_farmasi.PERSEDIAAN
			ORDER BY t_farmasi.PERSEDIAAN ASC';	
			
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0){
			$ret[] = array('IRJA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => 'FARMASI',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF_NON_KELAS' => '0',
					'NAMA_TARIF_GROUP' => ''
			);
		}	
	
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRJA_ID' => '',
				'TARIF_ID' => '',
				'KODE_TARIF' => 'PERSEDIAAN_ID',
				'NAMA_TARIF' => $r['PERSEDIAAN'],
				'KUANTITI' => $r['JUMLAH_KELUAR'],
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => $r['SATUAN'],
				'TARIF_NON_KELAS' => $r['HARGA_TOTAL'],
				'NAMA_TARIF_GROUP' => $r['SATUAN']
			);		
		}	
				
		$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
		
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ambulance_tarif
				INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $id . '"
				AND t_ambulance_tarif.JNS_ORDER = "IRJ"
				AND t_ambulance_tarif.NO_TARIF IS NOT NULL
				AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_ambulance_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql) or die(mysql_error());			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRJA_ID' => '',
				'TARIF_ID' => '',
				'KODE_TARIF' => '',
				'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
				'KUANTITI' => '0',
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => '',
				'TARIF_NON_KELAS' => '0',
				'NAMA_TARIF_GROUP' => ''
			);
				
			$sql2 = 'SELECT t_ambulance_tarif.RAWAT_ID AS IRJA_ID,t_ambulance_tarif.TARIF_ID,m_tarif.KODE_TARIF,
					m_tarif.NAMA_TARIF,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,m_tarif.SATUAN,
					SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,
					m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
					FROM t_ambulance_tarif
					INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_ambulance_tarif.RAWAT_ID = "' . $id . '"
					AND t_ambulance_tarif.JNS_ORDER = "IRJ"
					AND t_ambulance_tarif.NO_TARIF IS NOT NULL
					AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
					AND t_ambulance_tarif.ST_BAYAR = "Lunas"
					AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
					GROUP BY t_ambulance_tarif.TARIF_ID';
					
			$q2 = mysql_query($sql2);
			while ($r2 = mysql_fetch_array($q2)) {
				$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
					'TARIF_ID' => $r2['TARIF_ID'],
					'KODE_TARIF' => $r2['KODE_TARIF'],
					'NAMA_TARIF' => $r2['NAMA_TARIF'],
					'KUANTITI' => $r2['KUANTITI'],
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => $r2['SATUAN'],
					'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
					'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}
	
		if(isset($ret) and sizeof($ret) > 0){
			$templatebilling->cloneRow('no', sizeof($ret));
			//detail bill
			$total = 0;
			$l = 0;
			$k = 1;
			while($l < sizeof($ret)){
				if(empty($ret[$l]['NAMA_TARIF_GROUP'])){
					 $templatebilling->setValue('no#' . ($l + 1), '');	 
					 $templatebilling->setValue('tindakan#' . ($l + 1), "<w:r><w:rPr><w:b/></w:rPr><w:t>". htmlspecialchars($ret[$l]['NAMA_TARIF']) ."</w:t></w:r>");
					 $templatebilling->setValue('jumlah#' . ($l + 1), '');
					 $templatebilling->setValue('biaya#' . ($l + 1), '');	 
				}else{
					 $templatebilling->setValue('no#' . ($l + 1), $k);	 
					 $templatebilling->setValue('tindakan#' . ($l + 1), htmlspecialchars($ret[$l]['NAMA_TARIF']));
					 $templatebilling->setValue('jumlah#' . ($l + 1), $ret[$l]['KUANTITI']);
					 $templatebilling->setValue('biaya#' . ($l + 1), currFormat($ret[$l]['KUANTITI'] * $ret[$l]['TARIF_NON_KELAS'],0));
					 $total = $total + ($ret[$l]['KUANTITI'] * $ret[$l]['TARIF_NON_KELAS']);
					 $k = $k + 1;
				}
				$l = $l + 1;
			}
			$terbilang = set_terbilang(round($total)) . ' rupiah';
			$templatebilling->setValue('total', currFormat(round($total),0));	
			$templatebilling->setValue('terbilang', strtoupper($terbilang));	
			//end detail bill	
		}else{
			$templatebilling->setValue('no', '');	
			$templatebilling->setValue('tindakan', '');	
			$templatebilling->setValue('jumlah', '0');	
			$templatebilling->setValue('biaya', '0');
			$templatebilling->setValue('total', '0');
			$templatebilling->setValue('terbilang', '');		
		} 
	
		$templatebilling->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/01_billing.docx');
	}else if($rawat == '1'){
		$templatebilling = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\billing_rawat_inap.docx');
		$qry_billing = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%e") AS HARI_DAFTAR,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%m") AS BULAN_DAFTAR,
				DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%Y") AS TAHUN_DAFTAR,
				m_ruang.NAMA_RUANG,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN,
				t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,t_irna.NO_PENDAFTARAN,
				t_irna.USER_PENDAFTARAN,t_irna_tarif.USER_KASIR,
				m_pasien.NAMA_PASIEN,m_pasien.ALAMAT,m_pasien.NO_TELEPON
				FROM t_irna 
				INNER JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID)
				INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
				LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna.IRNA_ID = "' . $id . '"';
		$get_billing = mysql_query($qry_billing) or die(mysql_error());
		$dat_billing = mysql_fetch_assoc($get_billing);
		$templatebilling->setValue('nama_pasien', htmlspecialchars($dat_billing['NAMA_PASIEN']));
		$templatebilling->setValue('nomor_mr', formatNoMR($dat_billing['NOMR']));
		$templatebilling->setValue('alamat', htmlspecialchars($dat_billing['ALAMAT'] . '/' . $dat_billing['NO_TELEPON']));
		$templatebilling->setValue('nomor_billing', htmlspecialchars($dat_billing['NO_PENDAFTARAN']));
		$templatebilling->setValue('klinik_ruang', htmlspecialchars(strtoupper($dat_billing['NAMA_RUANG'])));
		$templatebilling->setValue('nama_dokter', htmlspecialchars(strtoupper($dat_billing['NAMA_PEGAWAI'])));
		$templatebilling->setValue('tanggal', 'Tangerang, ' . $dat_billing['HARI_DAFTAR'] . ' ' . ((isset($arr_bulan[$dat_billing['BULAN_DAFTAR']])) ? $arr_bulan[$dat_billing['BULAN_DAFTAR']] : '') . ' ' . $dat_billing['TAHUN_DAFTAR']);
		$templatebilling->setValue('pembayaran', htmlspecialchars($dat_billing['NAMA_JAMINAN']));
		$kasir = explode('|',$dat_billing['USER_KASIR']);
		if(isset($kasir[1])) {
			$templatebilling->setValue('kasir',htmlspecialchars($kasir[1]));	
		}else{
			$templatebilling->setValue('kasir','');	
		}
	
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $id . '"
				AND t_irja_tarif.NO_TARIF IS NOT NULL
				AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_irja_tarif.ST_BAYAR = "Lunas"
				AND t_irja_tarif.ST_BATAL IS NULL
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRJ',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_irja_tarif.IRJA_ID,t_irja_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						m_tarif.NAMA_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,m_tarif.SATUAN,
						SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_irja_tarif
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.IRJA_ID = "' . $id . '"
						AND t_irja_tarif.NO_TARIF IS NOT NULL
						AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_irja_tarif.ST_BAYAR = "Lunas"
						AND t_irja_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_irja_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}		
	
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '"
				AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRJ',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_ipenunjang_tarif.PENUNJANG_ID AS IRJA_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
						OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
						THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
						COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,m_tarif.SATUAN,
						COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						WHERE t_ipenunjang.RAWAT_ID = "' . $id . '"
						AND (t_ipenunjang.JNS_ORDER = "IRJ" OR t_ipenunjang.JNS_ORDER = "HRJ" OR t_ipenunjang.JNS_ORDER = "ORJ")
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}
	
		//operasi
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_operasi_tarif
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi.RAWAT_ID = "' . $id . '"
				AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1")
				AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_operasi_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRJ',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_operasi_tarif.OPERASI_ID,t_operasi_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						m_tarif.NAMA_TARIF,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,
						m_tarif.SATUAN,
						SUM(t_operasi_tarif.KUANTITI * (
							CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
								ELSE
								CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN  m_tarif.TARIF_KELAS_1
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN  m_tarif.TARIF_KELAS_2
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN  m_tarif.TARIF_KELAS_3
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN  m_tarif.TARIF_KELAS_UTAMA
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN  m_tarif.TARIF_KELAS_UTAMA
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN  m_tarif.TARIF_HCU
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN  m_tarif.TARIF_KELAS_PERINA_SEHAT
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN  m_tarif.TARIF_KELAS_PERINA_SAKIT
								END 
							END))  
						AS TARIF,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_operasi_tarif
						INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
						INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_operasi.RAWAT_ID = "' . $id . '"
						AND (t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1")
						AND t_operasi_tarif.NO_TARIF IS NOT NULL
						AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_operasi_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_operasi_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['OPERASI_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF'],
						'KELAS_RAWAT' => $r2['KELAS_RAWAT'],
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}	
		//end operasi

		//hemodialisa
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_hemodialisa 
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_hemodialisa.RAWAT_ID = "' . $id . '"
				AND t_hemodialisa.JNS_ORDER = "IRJ"
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
				AND t_hemodialisa.ST_BATAL IS NULL
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRJ',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_hemodialisa_tarif.HEMODIALISA_ID AS IRJA_ID,t_hemodialisa_tarif.TARIF_ID,
						m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,
						COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,m_tarif.SATUAN,
						COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_hemodialisa
						INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
						INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_hemodialisa.RAWAT_ID = "' . $id . '"
						AND t_hemodialisa.JNS_ORDER = "IRJ"
						AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
						AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
						AND t_hemodialisa.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_hemodialisa_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}
		//	
				
		$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());

		$sql = 'SELECT t_farmasi.PERSEDIAAN_ID,
			t_farmasi.HARGA_JUAL,
			SUM(t_farmasi.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			t_farmasi.NAMA_PERSEDIAAN,
			t_farmasi.SATUAN,
			t_farmasi.RACIKAN,
			t_farmasi.NAMA_RACIKAN,
			t_farmasi.PERSEDIAAN,
			t_farmasi.GENERIK,
			t_farmasi.ALKES,
			SUM(t_farmasi.HARGA_TOTAL) AS HARGA_TOTAL 
			FROM (
			SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN,
			CASE WHEN t_rajal_resep_detail.RACIKAN = "1" THEN CONCAT(t_rajal_resep_detail.NAMA_RACIKAN," (", m_persediaan_farmasi.NAMA_PERSEDIAAN,")") 
			ELSE m_persediaan_farmasi.NAMA_PERSEDIAAN END AS PERSEDIAAN,
			CASE WHEN t_rajal_resep_detail.GENERIK = "1" THEN "v" END AS GENERIK,
			CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "v" END AS ALKES,
			SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
			- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
			(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA_TOTAL
			FROM t_rajal_resep 
			INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
			INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
			INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
			WHERE t_rajal_resep.RAJAL_ID = "' . $id . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL 
			AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1"
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
			UNION ALL
			SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN,
			CASE WHEN t_rajal_resep_detail.RACIKAN = "1" THEN CONCAT(t_rajal_resep_detail.NAMA_RACIKAN," (", m_persediaan_farmasi.NAMA_PERSEDIAAN,")") 
			ELSE m_persediaan_farmasi.NAMA_PERSEDIAAN END AS PERSEDIAAN,
			CASE WHEN t_rajal_resep_detail.GENERIK = "1" THEN "v" END AS GENERIK,
			CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "v" END AS ALKES,
			SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
			- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
			(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA_TOTAL
			FROM t_rajal_resep 
			INNER JOIN t_rajal_resep_detail ON (t_rajal_resep.RAJAL_RESEP_ID = t_rajal_resep_detail.RAJAL_RESEP_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_rajal_resep_detail.RAJAL_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RAJAL_RESEP_DETAIL_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
			INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
			INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
			WHERE t_rajal_resep.RAJAL_ID = "' . $id . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
			) t_farmasi
			GROUP BY t_farmasi.PERSEDIAAN_ID,
			t_farmasi.HARGA_JUAL,
			t_farmasi.PERSEDIAAN
			ORDER BY t_farmasi.PERSEDIAAN ASC';	
			
		$q = mysql_query($sql);
		if(mysql_num_rows($q) > 0){
			$ret[] = array('IRJA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => 'FARMASI-IRJ',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF_NON_KELAS' => '0',
					'NAMA_TARIF_GROUP' => ''
			);
		}	
	
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRJA_ID' => '',
				'TARIF_ID' => '',
				'KODE_TARIF' => 'PERSEDIAAN_ID',
				'NAMA_TARIF' => $r['PERSEDIAAN'],
				'KUANTITI' => $r['JUMLAH_KELUAR'],
				'NO_TARIF' => '',
				'DESKRIPSI' => '',
				'SATUAN' => $r['SATUAN'],
				'TARIF_NON_KELAS' => $r['HARGA_TOTAL'],
				'NAMA_TARIF_GROUP' => $r['SATUAN']
			);		
		}	
	
	
		$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
	
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ambulance_tarif
				INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $id . '"
				AND t_ambulance_tarif.JNS_ORDER = "IRJ"
				AND t_ambulance_tarif.NO_TARIF IS NOT NULL
				AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_ambulance_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql) or die(mysql_error());			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT']. '-IRJ',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_ambulance_tarif.RAWAT_ID AS IRNA_ID,t_ambulance_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						m_tarif.NAMA_TARIF,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,m_tarif.SATUAN,
						SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_ambulance_tarif
						INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_ambulance_tarif.RAWAT_ID = "' . $id . '"
						AND t_ambulance_tarif.JNS_ORDER = "IRJ"
						AND t_ambulance_tarif.NO_TARIF IS NOT NULL
						AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ambulance_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ambulance_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}
	
		//end rawat jalan
	
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irna_tarif.IRNA_ID = "' . $id . '"
				AND t_irna_tarif.NO_TARIF IS NOT NULL
				AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_irna_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_irna_tarif.IRNA_ID,t_irna_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						m_tarif.NAMA_TARIF,SUM(t_irna_tarif.KUANTITI) AS KUANTITI,
						m_tarif.SATUAN,
						SUM(t_irna_tarif.KUANTITI * (
							CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
								ELSE
								CASE WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "1" THEN  m_tarif.TARIF_KELAS_1
								 WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "2" THEN  m_tarif.TARIF_KELAS_2
								 WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "3" THEN  m_tarif.TARIF_KELAS_3
								 WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA" THEN  m_tarif.TARIF_KELAS_UTAMA
								 WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VIP" THEN  m_tarif.TARIF_KELAS_UTAMA
								 WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "HCU" THEN  m_tarif.TARIF_HCU
								 WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN  m_tarif.TARIF_KELAS_PERINA_SEHAT
								 WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN  m_tarif.TARIF_KELAS_PERINA_SAKIT
								END 
							END))  
						AS TARIF,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_irna_tarif
						INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irna_tarif.IRNA_ID = "' . $id . '"
						AND t_irna_tarif.NO_TARIF IS NOT NULL
						AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_irna_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_irna_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
					);
			} 
		}	
		
	
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $id . '"
				AND (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "HRI" OR t_ipenunjang.JNS_ORDER = "ORI")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_ipenunjang.RAWAT_ID AS IRNA_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
							OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
							THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
							COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,m_tarif.SATUAN,
							COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						WHERE t_ipenunjang.RAWAT_ID = "' . $id . '"
						AND (t_ipenunjang.JNS_ORDER = "IRN" OR t_ipenunjang.JNS_ORDER = "HRI" OR t_ipenunjang.JNS_ORDER = "ORI")
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}	
	
		//operasi
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_operasi_tarif
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi.RAWAT_ID = "' . $id . '"
				AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2")
				AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_operasi_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_operasi_tarif.OPERASI_ID,t_operasi_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						m_tarif.NAMA_TARIF,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,
						m_tarif.SATUAN,
					SUM(t_operasi_tarif.KUANTITI * (
							CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
								ELSE
								CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN  m_tarif.TARIF_KELAS_1
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN  m_tarif.TARIF_KELAS_2
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN  m_tarif.TARIF_KELAS_3
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN  m_tarif.TARIF_KELAS_UTAMA
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN  m_tarif.TARIF_KELAS_UTAMA
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN  m_tarif.TARIF_HCU
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN  m_tarif.TARIF_KELAS_PERINA_SEHAT
								 WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN  m_tarif.TARIF_KELAS_PERINA_SAKIT
								END 
							END))  
						AS TARIF,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_operasi_tarif
						INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
						INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_operasi.RAWAT_ID = "' . $id . '"
						AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2")
						AND t_operasi_tarif.NO_TARIF IS NOT NULL
						AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_operasi_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_operasi_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['OPERASI_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}	
		//end operasi
	
		//hemodialisa
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_hemodialisa 
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_hemodialisa.RAWAT_ID = "' . $id . '"
				AND t_hemodialisa.JNS_ORDER = "IRN"
				AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
				AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
				AND t_hemodialisa.ST_BATAL IS NULL
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql);			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_hemodialisa.RAWAT_ID AS IRNA_ID,t_hemodialisa_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						m_tarif.NAMA_TARIF,
						COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,m_tarif.SATUAN,
						COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_hemodialisa
						INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
						INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_hemodialisa.RAWAT_ID = "' . $id . '"
						AND t_hemodialisa.JNS_ORDER = "IRN"
						AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
						AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
						AND t_hemodialisa.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_hemodialisa_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}
		//end hemodialisa

		$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
		mysql_select_db($database_3, $connect_3) or die(mysql_error());

		$sql = 'SELECT t_farmasi.PERSEDIAAN_ID,
			t_farmasi.HARGA_JUAL,
			SUM(t_farmasi.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			t_farmasi.NAMA_PERSEDIAAN,
			t_farmasi.SATUAN,
			t_farmasi.RACIKAN,
			t_farmasi.NAMA_RACIKAN,
			t_farmasi.PERSEDIAAN,
			t_farmasi.GENERIK,
			t_farmasi.ALKES,
			SUM(t_farmasi.HARGA_TOTAL) AS HARGA_TOTAL 
			FROM (
			SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN,
			CASE WHEN t_ranap_resep_detail.RACIKAN = "1" THEN CONCAT(t_ranap_resep_detail.NAMA_RACIKAN," (", m_persediaan_farmasi.NAMA_PERSEDIAAN,")") 
			ELSE m_persediaan_farmasi.NAMA_PERSEDIAAN END AS PERSEDIAAN,
			CASE WHEN t_ranap_resep_detail.GENERIK = "1" THEN "v" END AS GENERIK,
			CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "v" END AS ALKES,
			SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
			- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
			(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA_TOTAL
			FROM t_ranap_resep 
			INNER JOIN t_ranap_resep_detail ON (t_ranap_resep.RANAP_RESEP_ID = t_ranap_resep_detail.RANAP_RESEP_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
			INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
			INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
			WHERE t_ranap_resep.RANAP_ID = "' . $id . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL 
			AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1"
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN
			UNION ALL
			SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			SUM(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR) AS JUMLAH_KELUAR,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN,
			CASE WHEN t_ranap_resep_detail.RACIKAN = "1" THEN CONCAT(t_ranap_resep_detail.NAMA_RACIKAN," (", m_persediaan_farmasi.NAMA_PERSEDIAAN,")") 
			ELSE m_persediaan_farmasi.NAMA_PERSEDIAAN END AS PERSEDIAAN,
			CASE WHEN t_ranap_resep_detail.GENERIK = "1" THEN "v" END AS GENERIK,
			CASE WHEN m_persediaan_farmasi.ALKES = "1" THEN "v" END AS ALKES,
			SUM((t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL)
			- ((t_farmasi_apotik_pengeluaran.PERSEN_JAMINAN/100) * 
			(t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR * t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL))) AS HARGA_TOTAL
			FROM t_ranap_resep 
			INNER JOIN t_ranap_resep_detail ON (t_ranap_resep.RANAP_RESEP_ID = t_ranap_resep_detail.RANAP_RESEP_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran_detail ON (t_ranap_resep_detail.RANAP_RESEP_DETAIL_ID = t_farmasi_apotik_pengeluaran_detail.RANAP_RESEP_DETAIL_ID)
			INNER JOIN t_farmasi_apotik_pengeluaran ON (t_farmasi_apotik_pengeluaran_detail.FARMASI_PENGELUARAN_ID = t_farmasi_apotik_pengeluaran.FARMASI_PENGELUARAN_APOTIK_ID)
			INNER JOIN m_persediaan_farmasi ON (t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID = m_persediaan_farmasi.PERSEDIAAN_ID)
			INNER JOIN m_persediaan_group ON (m_persediaan_farmasi.PERSEDIAAN_GROUP_ID = m_persediaan_group.PERSEDIAAN_GROUP_ID)
			WHERE t_ranap_resep.RANAP_ID = "' . $id . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN
			) t_farmasi
			GROUP BY t_farmasi.PERSEDIAAN_ID,
			t_farmasi.HARGA_JUAL,
			t_farmasi.PERSEDIAAN
			ORDER BY t_farmasi.PERSEDIAAN ASC';	
		
		$q = mysql_query($sql) or die(mysql_error());			
	
		if(mysql_num_rows($q) > 0){
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => 'FARMASI',
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
		}
	
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => $r['PERSEDIAAN_ID'],
					'NAMA_TARIF' => $r['PERSEDIAAN'],
					'KUANTITI' => $r['JUMLAH_KELUAR'],
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => $r['SATUAN'],
					'TARIF' => $r['HARGA_TOTAL'],
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => $r['SATUAN']
				);		
		}
	
		$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
		mysql_select_db($database, $connect) or die(mysql_error());
	
		$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ambulance_tarif
				INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $id . '"
				AND t_ambulance_tarif.JNS_ORDER = "IRN"
				AND t_ambulance_tarif.NO_TARIF IS NOT NULL
				AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_ambulance_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
		$q = mysql_query($sql) or die(mysql_error());			
		while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'],
					'KUANTITI' => '0',
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => '',
					'TARIF' => '0',
					'KELAS_RAWAT' => '',
					'NAMA_TARIF_GROUP' => ''
				);
			
				$sql2 = 'SELECT t_ambulance_tarif.RAWAT_ID AS IRNA_ID,t_ambulance_tarif.TARIF_ID,m_tarif.KODE_TARIF,
						m_tarif.NAMA_TARIF,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,m_tarif.SATUAN,
						SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
						FROM t_ambulance_tarif
						INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_ambulance_tarif.RAWAT_ID = "' . $id . '"
						AND t_ambulance_tarif.JNS_ORDER = "IRN"
						AND t_ambulance_tarif.NO_TARIF IS NOT NULL
						AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ambulance_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ambulance_tarif.TARIF_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_TARIF_GROUP']
				);
			}
		}
	
		if(isset($ret) and sizeof($ret) > 0){
			$templatebilling->cloneRow('no', sizeof($ret));
			//detail bill
			$total = 0;
			$l = 0;
			$k = 1;
			while($l < sizeof($ret)){
				if(empty($ret[$l]['NAMA_TARIF_GROUP'])){
					 $templatebilling->setValue('no#' . ($l + 1), '');	 
					 $templatebilling->setValue('tindakan#' . ($l + 1), "<w:r><w:rPr><w:b/></w:rPr><w:t>". htmlspecialchars($ret[$l]['NAMA_TARIF']) ."</w:t></w:r>");
					 $templatebilling->setValue('jumlah#' . ($l + 1), '');
					 $templatebilling->setValue('biaya#' . ($l + 1), '');	 
				}else{
					 $templatebilling->setValue('no#' . ($l + 1), $k);	 
					 $templatebilling->setValue('tindakan#' . ($l + 1), htmlspecialchars($ret[$l]['NAMA_TARIF']));
					 $templatebilling->setValue('jumlah#' . ($l + 1), $ret[$l]['KUANTITI']);
					 $templatebilling->setValue('biaya#' . ($l + 1), currFormat($ret[$l]['KUANTITI'] * $ret[$l]['TARIF'],0));
					 $total = $total + ($ret[$l]['KUANTITI'] * $ret[$l]['TARIF']);
					 $k = $k + 1;
				}
				$l = $l + 1;
			}
			$terbilang = set_terbilang(round($total)) . ' rupiah';
			$templatebilling->setValue('total', currFormat(round($total),0));	
			$templatebilling->setValue('terbilang', strtoupper($terbilang));	
			//end detail bill	
		}else{
			$templatebilling->setValue('no', '');	
			$templatebilling->setValue('tindakan', '');	
			$templatebilling->setValue('jumlah', '0');	
			$templatebilling->setValue('biaya', '0');
			$templatebilling->setValue('total', '0');
			$templatebilling->setValue('terbilang', '');		
		} 
	
		$templatebilling->saveAs($eklaim_arsip_path . '/doc/' . $no_sep . '/01_billing.docx');
	}
	
	try{
		$source_file = $eklaim_arsip_path . '/doc/' . $no_sep . '/01_billing.docx';
		$target_file = $eklaim_arsip_path . '/pdf/' . $no_sep . '/01_billing.pdf';
		
		$word = new COM("Word.Application") or die ("Could not initialise Object.");
		$word->Visible = 0;
		$word->DisplayAlerts = 0;
		$word->Documents->Open($source_file);
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