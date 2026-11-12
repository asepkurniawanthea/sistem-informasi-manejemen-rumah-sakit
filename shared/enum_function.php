<?php

function getJnsKelamin($sl) {
    $slc1 = '';
    $slc2 = '';
    if ($sl == 'L')
        $slc1 = 'selected="selected"';
    if ($sl == 'P')
        $slc2 = 'selected="selected"';
    $ret = '<option value="L" ' . $slc1 . ' >Laki-laki</option>';
    $ret = $ret . '<option value="P" ' . $slc2 . ' >Perempuan</option>';
    return $ret;
}

function getAgama($sl) {
    $sql = 'SELECT * FROM m_agama';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['AGAMA_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['AGAMA_ID'] . '" ' . $slc . ' >' . $dat['NAMA_AGAMA'] . '</option>';
    }
    return $ret;
}

function getStKawin($sl) {
    $slc1 = '';
    $slc2 = '';
    $slc3 = '';
    if ($sl == '1')
        $slc1 = 'selected="selected"';
    if ($sl == '2')
        $slc2 = 'selected="selected"';
    if ($sl == '3')
        $slc3 = 'selected="selected"';
    $ret = '<option value="1" ' . $slc1 . ' >Belum Kawin</option>';
    $ret = $ret . '<option value="2" ' . $slc2 . ' >Kawin</option>';
    $ret = $ret . '<option value="3" ' . $slc3 . ' >Janda/Duda</option>';
    return $ret;
}

function getAsalPasien($sl) {
    $sql = 'SELECT * FROM m_asal_pasien';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['ASAL_PASIEN_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['ASAL_PASIEN_ID'] . '" ' . $slc . ' >' . $dat['KET_ASAL_PASIEN'] . '</option>';
    }
    return $ret;
}

function getJnsBayar($sl,$daftar = '0') {
	
    $sql = 'SELECT * FROM m_jaminan';
	if($daftar != '0') $sql = $sql . ' WHERE PENDAFTARAN = "1" ORDER BY URUT';
    $rsl = mysql_query($sql) or die(mysql_error());
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['JAMINAN_ID'] == $sl) {
			$slc = 'selected="selected"';
		}	
        $ret = $ret . ' <option value="' . $dat['JAMINAN_ID'] . '" ' . $slc . ' >' . $dat['NAMA_JAMINAN'] . '</option>';
    }
    return $ret;
}

function getPendidikan($sl) {
    $sql = 'SELECT * FROM m_pendidikan';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PENDIDIKAN_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PENDIDIKAN_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PENDIDIKAN'] . '</option>';
    }
    return $ret;
}

function getUnit($st,$sl) {
    $sql = 'SELECT * FROM m_unit';
    if ($st == 'irja') $sql = $sql . ' WHERE IRJA IS NOT NULL';
	if ($st == 'igd') $sql = $sql . ' WHERE IRJA = "igd"';
	if ($st == 'kusta') $sql = $sql . ' WHERE IRJA = "kusta"';
	if ($st == 'umum') $sql = $sql . ' WHERE IRJA = "umum"';
	if ($st == 'pnj') $sql = $sql . ' WHERE PENUNJANG IS NOT NULL';
	if ($st == 'irna') $sql = $sql . ' WHERE IRNA IS NOT NULL';
	if ($st == 'irjp') $sql = $sql . ' WHERE IRJA IS NOT NULL OR PENUNJANG IS NOT NULL';
	if ($st == 'umumigd') $sql = $sql . ' WHERE IRJA = "umum" OR IRJA = "igd" OR IRJA = "kusta" OR IRJA = "mcu"';
	if ($st == 'umummcu') $sql = $sql . ' WHERE IRJA = "umum" OR IRJA = "mcu"';
	if ($st == 'umumkusta') $sql = $sql . ' WHERE IRJA = "umum" OR IRJA = "kusta" OR IRJA = "mcu"';
    $sql = $sql . ' ORDER BY NAMA_UNIT';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['UNIT_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['UNIT_ID'] . '" ' . $slc . ' >' . $dat['NAMA_UNIT'] . '</option>';
    }
    return $ret;
}

function getRuang($st, $sl) {
    $sql = 'SELECT * FROM m_ruang WHERE ST_AKTIF = "1" ORDER BY NAMA_RUANG';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['RUANG_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['RUANG_ID'] . '" ' . $slc . ' >' . $dat['NAMA_RUANG'] . ' Kelas ' . $dat['KELAS_RAWAT'] . '</option>';
    }
    return $ret;
}

function getBangsal($sl) {
    $sql = 'SELECT DISTINCT BANGSAL FROM m_ruang WHERE ST_AKTIF = "1" ORDER BY BANGSAL';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['BANGSAL'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['BANGSAL'] . '" ' . $slc . ' >' . $dat['BANGSAL'] . '</option>';
    }
    return $ret;
}

function getBangsalPerawatan($st,$sl) {
    $sql = 'SELECT CASE WHEN JNS_PERAWATAN_DETAIL IS NULL OR JNS_PERAWATAN_DETAIL = ""  THEN KELAS_RAWAT
					ELSE CONCAT(KELAS_RAWAT, "-", JNS_PERAWATAN_DETAIL) END AS BANGSAL_PERAWATAN FROM m_ruang  
			WHERE BANGSAL = "' . $st . '"
			AND ST_AKTIF = "1"';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['BANGSAL'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['BANGSAL_PERAWATAN'] . '" ' . $slc . ' >' . $dat['BANGSAL_PERAWATAN'] . '</option>';
    }
    return $ret;
}

function getRuangRawat($sl) {
    $sql = 'SELECT m_ruang.*,m_kelas_rawat.NON_KELAS 
			FROM m_ruang 
			LEFT JOIN m_kelas_rawat
			ON (m_ruang.KELAS_RAWAT = m_kelas_rawat.KELAS_RAWAT)
			WHERE ST_AKTIF = "1" 
			ORDER BY NAMA_RUANG,KELAS_RAWAT';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['RUANG_ID'] == $sl)
            $slc = 'selected="selected"';
		$nama_ruang = str_replace('R.R.','',$dat['NAMA_RUANG']);
		if($dat['NON_KELAS'] == '') $nama_ruang .= ' (Kelas ' . $dat['KELAS_RAWAT'] . ')'; 
        $ret = $ret . ' <option value="' . $dat['RUANG_ID'] . '" ' . $slc . ' >' . $nama_ruang .  '</option>';
    }
    return $ret;
}

function getRuangRawat1($sl) {
    $sql = 'SELECT DISTINCT(substring(NAMA_RUANG,1,10)) as NM_RUANG,NAMA_RUANG,RUANG_ID 
	FROM m_ruang WHERE ST_AKTIF = "1"
	GROUP BY substring(NAMA_RUANG,1,10) ORDER BY NAMA_RUANG';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['RUANG_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['NAMA_RUANG'] . '" ' . $slc . ' >' . str_replace('1','',$dat['NAMA_RUANG']) . '</option>';
    }
    return $ret;
}

function getPropinsi($sl) {
    $sql = 'SELECT * FROM m_propinsi ORDER BY NAMA_PROPINSI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PROPINSI_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PROPINSI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PROPINSI'] . '</option>';
    }
    return $ret;
}

function getKota($s, $sl) {
    $sql = 'SELECT * FROM m_kota WHERE PROPINSI_ID = "' . $s . '" ORDER BY NAMA_KOTA';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['KOTA_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['KOTA_ID'] . '" ' . $slc . ' >' . $dat['NAMA_KOTA'] . '</option>';
    }
    return $ret;
}

function getKecamatan($s, $sl) {
    $sql = 'SELECT * FROM m_kecamatan WHERE KOTA_ID = "' . $s . '" ORDER BY NAMA_KECAMATAN';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['KECAMATAN_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['KECAMATAN_ID'] . '" ' . $slc . ' >' . $dat['NAMA_KECAMATAN'] . '</option>';
    }
    return $ret;
}

function getKelurahan($s, $sl) {
    $sql = 'SELECT * FROM m_kelurahan WHERE KECAMATAN_ID = "' . $s . '" ORDER BY NAMA_KELURAHAN';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['KELURAHAN_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['KELURAHAN_ID'] . '" ' . $slc . ' >' . $dat['NAMA_KELURAHAN'] . '</option>';
    }
    return $ret;
}

function getPegawai($sl) {
    $sql = 'SELECT m_pegawai.*,m_pegawai_tipe.* FROM m_pegawai 
							INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
							ORDER BY NAMA_PEGAWAI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
		if($dat['NAMA_PEGAWAI'] != '-'){	
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
		}else{
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >[' . $dat['KET_TIPE_PEGAWAI'] . ']</option>';
		}	
    }
    return $ret;
}

function getDokter($sl,$st = '') {
    $sql = 'SELECT m_pegawai.NAMA_PEGAWAI,t_dokter_jaga.UNIT_ID,t_dokter_jaga.PEGAWAI_ID,
			m_pegawai_tipe.KET_TIPE_PEGAWAI
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			INNER JOIN t_dokter_jaga ON (m_pegawai.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID)';
	if(!empty($st)) $sql = $sql . ' WHERE t_dokter_jaga.UNIT_ID = "' . $st . '"';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        if($dat['NAMA_PEGAWAI'] != '-'){	
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
		}else{
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >[' . $dat['KET_TIPE_PEGAWAI'] . ']</option>';
		}
    }
    return $ret;
}

function getPelaksanaKlinik($sl,$st) {
    $sql = 'SELECT * FROM (SELECT DISTINCT m_pegawai.NAMA_PEGAWAI,m_pegawai.PEGAWAI_ID,
			m_pegawai_tipe.KET_TIPE_PEGAWAI,1 AS ORD
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			INNER JOIN t_dokter_jaga ON (m_pegawai.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID)
			UNION
			SELECT DISTINCT m_pegawai.NAMA_PEGAWAI,m_pegawai.PEGAWAI_ID,
			m_pegawai_tipe.KET_TIPE_PEGAWAI,2 AS ORD
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			INNER JOIN t_pelaksana_penunjang ON (m_pegawai.PEGAWAI_ID = t_pelaksana_penunjang.PEGAWAI_ID)
			) t_pelaksana ORDER BY ORD,NAMA_PEGAWAI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        if($dat['NAMA_PEGAWAI'] != '-'){	
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
		}else{
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >[' . $dat['KET_TIPE_PEGAWAI'] . ']</option>';
		}
    }
    return $ret;
}

function getDokterRanap($sl) {
    $sql = 'SELECT DISTINCT m_pegawai.NAMA_PEGAWAI,t_dokter_jaga.PEGAWAI_ID,
			m_pegawai_tipe.KET_TIPE_PEGAWAI
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			INNER JOIN t_dokter_jaga ON (m_pegawai.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID)
			WHERE m_pegawai_tipe.TIPE_PEGAWAI_ID = "1" 
			OR m_pegawai_tipe.TIPE_PEGAWAI_ID = "2" 
			OR m_pegawai_tipe.TIPE_PEGAWAI_ID = "3"  
			OR m_pegawai_tipe.TIPE_PEGAWAI_ID = "18"  
			ORDER BY m_pegawai.NAMA_PEGAWAI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        if($dat['NAMA_PEGAWAI'] != '-'){	
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
		}else{
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >[' . $dat['KET_TIPE_PEGAWAI'] . ']</option>';
		}
    }
    return $ret;
}

function getTempatTidur($st,$sl){
	 $sql = 'SELECT COUNT(t_irna.IRNA_ID) AS ISI,m_ruang_detail.NO_TMP_TIDUR
							FROM m_ruang_detail
							LEFT JOIN t_irna ON (m_ruang_detail.RUANG_ID = t_irna.RUANG_ID AND UPPER(TRIM(m_ruang_detail.NO_TMP_TIDUR)) = UPPER(TRIM(t_irna.NO_TMP_TIDUR)) AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL AND t_irna.ST_PULANG IS NULL)
							WHERE m_ruang_detail.RUANG_ID = "' . $st . '"
							GROUP BY m_ruang_detail.NO_TMP_TIDUR';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['NO_TMP_TIDUR'] == $sl)
            $slc = 'selected="selected"';
        if($dat['ISI'] == 0){	
			$ret = $ret . ' <option value="' . $dat['NO_TMP_TIDUR'] . '" ' . $slc . ' >' . $dat['NO_TMP_TIDUR'] . '</option>';
		}
    }
    return $ret;
}

function getTempatTidurEdit($st,$sl){
	 $sql = 'SELECT COUNT(t_irna.IRNA_ID) AS ISI,m_ruang_detail.NO_TMP_TIDUR
							FROM m_ruang_detail
							LEFT JOIN t_irna ON (m_ruang_detail.RUANG_ID = t_irna.RUANG_ID AND UPPER(TRIM(m_ruang_detail.NO_TMP_TIDUR)) = UPPER(TRIM(t_irna.NO_TMP_TIDUR)) AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL AND t_irna.ST_PULANG IS NULL)
							WHERE m_ruang_detail.RUANG_ID = "' . $st . '"
							GROUP BY m_ruang_detail.NO_TMP_TIDUR';
    $rsl = mysql_query($sql);
    $ret = '';
	if(!empty($sl)) $ret = $ret . ' <option value="' . $sl . '" selected="selected" >' . $sl . '</option>';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['NO_TMP_TIDUR'] == $sl)
            $slc = 'selected="selected"';
			$ret = $ret . ' <option value="' . $dat['NO_TMP_TIDUR'] . '" ' . $slc . ' >' . $dat['NO_TMP_TIDUR'] . '</option>';
    }
    return $ret;
}

function getPelaksanaPenunjang($sl, $un) {	
		$sql = 'SELECT DISTINCT m_pegawai.NAMA_PEGAWAI,m_pegawai.PEGAWAI_ID,
			m_pegawai_tipe.KET_TIPE_PEGAWAI
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			INNER JOIN t_pelaksana_penunjang ON (m_pegawai.PEGAWAI_ID = t_pelaksana_penunjang.PEGAWAI_ID)
			WHERE t_pelaksana_penunjang.UNIT_ID = "' . $un . '" 
			ORDER BY m_pegawai.NAMA_PEGAWAI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        if($dat['NAMA_PEGAWAI'] != '-'){	
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
		}else{
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >[' . $dat['KET_TIPE_PEGAWAI'] . ']</option>';
		}
    }
    return $ret;
}

function getPulang($sl) {
    $sql = 'SELECT * FROM m_pasien_pulang';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PASIEN_PULANG_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PASIEN_PULANG_ID'] . '" ' . $slc . ' >' . $dat['KET_PASIEN_PULANG'] . '</option>';
    }
    return $ret;
}

function getPulangRanap($sl) {
    $sql = 'SELECT * FROM m_pasien_pulang WHERE IRNA = "1"';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PASIEN_PULANG_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PASIEN_PULANG_ID'] . '" ' . $slc . ' >' . $dat['KET_PASIEN_PULANG'] . '</option>';
    }
    return $ret;
}

function getSuplier($sl, $farmasi, $gudang, $gizi) {
    $sql = 'SELECT * FROM m_suplier';
    if ($farmasi == '1') {
        $sql = $sql . ' WHERE FARMASI = "1"';
    };
    if ($gudang == '1') {
        $sql = $sql . ' WHERE GUDANG = "1"';
    }
    if ($gizi == '1') {
        $sql = $sql . ' WHERE GIZI = "1"';
    }
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['SUPLIER_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['SUPLIER_ID'] . '" ' . $slc . ' >' . $dat['NAMA_SUPLIER'] . '</option>';
    }
    return $ret;
}

function getAturanMinum($sl) {
    $slc[1] = '3 x 1 tablet';
    $slc[2] = '3 x 1 sendok takar';
    $slc[3] = '3 x 1 sendok makan';
    $slc[4] = '3 x 0.1 ml';
    $slc[5] = '3 x 0.2 ml';
    $slc[6] = '3 x 0.3 ml';
    $slc[7] = '3 x 0.4 ml';
    $slc[8] = '3 x 0.5 ml';
    $slc[9] = '3 x 0.6 ml';
    $slc[10] = '3 x 0.7 ml';
    $slc[11] = '3 x 0.8 ml';
    $slc[12] = '3 x 0.9 ml';
    $slc[13] = '3 x 2 tetes';
    $ret = '';
    $i = 1;
    while ($i <= 13) {
        $slcx = '';
        if ($slc[$i] == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $slc[$i] . '" ' . $slcx . ' >' . $slc[$i] . '</option>';
        $i++;
    }
    return $ret;
}

function getWaktuMinum($sl) {
    $slc[1] = 'Setelah Makan';
    $slc[2] = 'Sebelum Makan';
    $slc[3] = 'Sebelum Tidur';
    $ret = '';
    $i = 1;
    while ($i <= 3) {
        $slcx = '';
        if ($slc[$i] == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $slc[$i] . '" ' . $slcx . ' >' . $slc[$i] . '</option>';
        $i++;
    }
    return $ret;
}

function getJenisPenerimaan($sl, $p = 0) {
    $slc[1] = 'Pembelian';
    $slc[2] = 'Hibah';
    $slc[3] = 'Donasi';
    $slc[4] = 'Lain-lain';
    $slc[5] = 'Produksi';
    $ret = '';
    $m = 5;
    if ($p == 1)
        $m = 4;
    $i = 1;
    while ($i <= $m) {
        $slcx = '';
        if ($i == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $i . '" ' . $slcx . ' >' . $slc[$i] . '</option>';
        $i++;
    }
    return $ret;
}

function getJenisPengeluaran($sl, $p = 0) {
    $slc[1] = 'Amprahan';
    $slc[2] = 'Kadaluarsa';
    $slc[3] = 'Rusak';
    $slc[4] = 'Lain-lain';
    $slc[5] = 'Produksi';
    $ret = '';
    $m = 5;
    if ($p == 1)
        $m = 4;
    $i = 1;
    while ($i <= $m) {
        $slcx = '';
        if ($i == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $i . '" ' . $slcx . ' >' . $slc[$i] . '</option>';
        $i++;
    }
    return $ret;
}

function getShiftItem($sl) {
    $slc[1] = '1';
    $slc[2] = '2';
    $slc[3] = '3';
    $ret = '';
    $i = 1;
    while ($i <= 3) {
        $slcx = '';
        if ($slc[$i] == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $slc[$i] . '" ' . $slcx . ' >' . $slc[$i] . '</option>';
        $i++;
    }
    return $ret;
}

function getPersediaanGroup($sl, $farmasi, $gudang, $gizi, $alkes, $obat) {
    $sql = 'SELECT * FROM m_persediaan_group';
    if ($farmasi == '1') {
        $sql = $sql . ' WHERE FARMASI = "1"';
        if ($alkes == '1') {
            $sql = $sql . ' AND ALKES = "1"';
        }
        if ($obat == '1') {
            $sql = $sql . ' AND ALKES IS NULL';
        }
    };
    if ($gudang == '1') {
        $sql = $sql . ' WHERE GUDANG = "1"';
    }
    if ($gizi == '1') {
        $sql = $sql . ' WHERE GIZI = "1"';
    }
    $sql = $sql . ' ORDER BY PERSEDIAAN_GROUP';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PERSEDIAAN_GROUP_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PERSEDIAAN_GROUP_ID'] . '" ' . $slc . ' >' . $dat['PERSEDIAAN_GROUP'] . '</option>';
    }
    return $ret;
}

function getPersediaanKategori($sl, $farmasi, $gudang, $gizi, $alkes, $obat) {
    $sql = 'SELECT * FROM m_persediaan_kategori';
    if ($farmasi == '1') {
        $sql = $sql . ' WHERE FARMASI = "1"';
        if ($alkes == '1') {
            $sql = $sql . ' AND ALKES = "1"';
        }
        if ($obat == '1') {
            $sql = $sql . ' AND ALKES IS NULL';
        }
    };
    if ($gudang == '1') {
        $sql = $sql . ' WHERE GUDANG = "1"';
    }
    if ($gizi == '1') {
        $sql = $sql . ' WHERE GIZI = "1"';
    }
    $sql = $sql . ' ORDER BY PERSEDIAAN_KATEGORI_ID';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PERSEDIAAN_KATEGORI_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PERSEDIAAN_KATEGORI_ID'] . '" ' . $slc . ' >' . $dat['PERSEDIAAN_KATEGORI'] . '</option>';
    }
    return $ret;
}

function getJenisFilm($sl) {
    $slc[1] = 'CT';
    $slc[2] = '35';
    $slc[3] = '30';
	$slc[4] = '24';
	$slc[5] = '18';
	$slc[6] = 'Gigi';
    $ret = '';
    $i = 1;
    while ($i <= 6) {
        $slcx = '';
        if ($slc[$i] == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $slc[$i] . '" ' . $slcx . ' >' . $slc[$i] . '</option>';
        $i++;
    }
    return $ret;
}

function getPelaksanaRanap($sl,$st) {
    $sql = 'SELECT * FROM (SELECT DISTINCT m_pegawai.NAMA_PEGAWAI,m_pegawai.PEGAWAI_ID,
			m_pegawai_tipe.KET_TIPE_PEGAWAI,1 AS ORD
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			INNER JOIN t_dokter_jaga ON (m_pegawai.PEGAWAI_ID = t_dokter_jaga.PEGAWAI_ID)
			WHERE m_pegawai_tipe.TIPE_PEGAWAI_ID = "1" OR m_pegawai_tipe.TIPE_PEGAWAI_ID = "2" OR m_pegawai_tipe.TIPE_PEGAWAI_ID = "3"  
			UNION
			SELECT DISTINCT m_pegawai.NAMA_PEGAWAI,m_pegawai.PEGAWAI_ID,
			m_pegawai_tipe.KET_TIPE_PEGAWAI,2 AS ORD
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			INNER JOIN t_pelaksana_penunjang ON (m_pegawai.PEGAWAI_ID = t_pelaksana_penunjang.PEGAWAI_ID)
			) t_pelaksana ORDER BY ORD,NAMA_PEGAWAI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        if($dat['NAMA_PEGAWAI'] != '-'){	
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
		}else{
			$ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >[' . $dat['KET_TIPE_PEGAWAI'] . ']</option>';
		}
    }
    return $ret;
}

function getJam($sl) {
    $ret = '';
    $i = 0;
    while ($i < 24) {
        $slcx = '';
		$val = substr('00', 0, 2 - strlen($i)) . $i;
        if ($val == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $val . '" ' . $slcx . ' >' . $val . '</option>';
        $i++;
    }
    return $ret;
}

function getMenit($sl) {
    $ret = '';
    $i = 0;
    while ($i < 60) {
        $slcx = '';
		$val = substr('00', 0, 2 - strlen($i)) . $i;
        if ($val == $sl)
            $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $val . '" ' . $slcx . ' >' . $val . '</option>';
        $i++;
    }
    return $ret;
}

function getNilaiRujukanLab($group,$pemeriksaan,$jnskel,$selec){
	$sql = 'SELECT m_nilai_rujukan_laboratorium.LABEL_UMUR,
				CONCAT(m_nilai_rujukan_laboratorium.UMUR_TAHUN,"-",m_nilai_rujukan_laboratorium.UMUR_BULAN,"-",m_nilai_rujukan_laboratorium.UMUR_HARI) AS UMUR,
				m_nilai_rujukan_laboratorium.NILAI_RUJUKAN,m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID
			FROM m_nilai_rujukan_laboratorium
			WHERE m_nilai_rujukan_laboratorium.CH_REPORT = "' . $group . '"
			AND m_nilai_rujukan_laboratorium.NAMA_PEMERIKSAAN = "' . $pemeriksaan . '"';
			if(strtoupper($jnskel) == 'L') $sql = $sql . ' AND m_nilai_rujukan_laboratorium.JNS_KELAMIN_LK = "1"';
			if(strtoupper($jnskel) == 'P') $sql = $sql . ' AND m_nilai_rujukan_laboratorium.JNS_KELAMIN_PR = "1"';
	$sql = $sql . ' ORDER BY m_nilai_rujukan_laboratorium.UMUR_TAHUN,
				m_nilai_rujukan_laboratorium.UMUR_BULAN,
				m_nilai_rujukan_laboratorium.UMUR_HARI';		

    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
		$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN']; 
		$nilai_rujukan = $dat['LABEL_UMUR'] . ' : ' . $dat['NILAI_RUJUKAN'];
        if ($id == $selec)
            $slc = 'selected="selected"';
			$ret = $ret . ' <option value="' . $id . '" ' . $slc . ' >' . $nilai_rujukan . '</option>';
    }
    return $ret;
}

function setNilaiRujukanLab($group,$pemeriksaan,$jnskel,$umur){
	$u_tahun_array = explode('tahun',$umur);
	$u_tahun = trim(str_replace(' ','',$u_tahun_array[0]));
	$u_bulan_array = explode('bulan',$u_tahun_array[1]);
	$u_bulan = trim(str_replace(' ','',$u_bulan_array[0]));
	$u_hari = trim(str_replace(' hari','',$u_bulan_array[1]));
	
	$sql = 'SELECT m_nilai_rujukan_laboratorium.NILAI_RUJUKAN_ID,
			m_nilai_rujukan_laboratorium.UMUR_TAHUN,
			m_nilai_rujukan_laboratorium.UMUR_BULAN,
			m_nilai_rujukan_laboratorium.UMUR_HARI,
			m_nilai_rujukan_laboratorium.LABEL_UMUR,
			m_nilai_rujukan_laboratorium.NILAI_RUJUKAN,
			CONCAT(m_nilai_rujukan_laboratorium.UMUR_TAHUN,"-",m_nilai_rujukan_laboratorium.UMUR_BULAN,"-",m_nilai_rujukan_laboratorium.UMUR_HARI) AS UMUR
			FROM m_nilai_rujukan_laboratorium
			WHERE m_nilai_rujukan_laboratorium.CH_REPORT = "' . $group . '"
			AND m_nilai_rujukan_laboratorium.NAMA_PEMERIKSAAN = "' . $pemeriksaan . '"';
	if(strtoupper($jnskel) == 'L') $sql = $sql . ' AND m_nilai_rujukan_laboratorium.JNS_KELAMIN_LK = "1"';
	if(strtoupper($jnskel) == 'P') $sql = $sql . ' AND m_nilai_rujukan_laboratorium.JNS_KELAMIN_PR = "1"';
	$sql = $sql . ' ORDER BY m_nilai_rujukan_laboratorium.UMUR_TAHUN,
				m_nilai_rujukan_laboratorium.UMUR_BULAN,
				m_nilai_rujukan_laboratorium.UMUR_HARI';
	$rsl = mysql_query($sql) or die(mysql_error());
	$id = '';
	
	while ($dat = mysql_fetch_array($rsl)) {
		$d_tahun = $dat['UMUR_TAHUN']; 
		$d_bulan = $dat['UMUR_BULAN']; 
		$d_hari = $dat['UMUR_HARI']; 

		if($u_tahun == 0 and $u_bulan == 0 and $u_hari == 0){
			//umur 0 hari
			if($d_tahun == 0 and $d_bulan == 0 and $d_hari == 0){
				$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN'];
				break;
			}
			if($d_tahun > 0 or $d_bulan > 0 or $d_hari > 0){
				$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN'];
				break;
			}
			//
		}else if($u_tahun == 0 and $u_bulan == 0 and $u_hari > 0){
			//umur < 1 bulan
			if($d_tahun == 0 and $d_bulan == 0 and $u_hari <= $d_hari){
				$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN'];
				break;
			}
			if($d_tahun > 0 or $d_bulan > 0){
				$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN'];
				break;
			}
			//
		}else if($u_tahun == 0 and $u_bulan > 0){
			//umur < 1 tahun
			if($d_tahun == 0 and $d_bulan > 0){
				$d_hari_bulan = $d_hari + ($d_bulan * 30); 
				$u_hri_bulan =  $u_hari + ($u_bulan * 30);
				
				
				if($d_tahun == 0 and $u_hri_bulan <= $d_hari_bulan){
					$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN'];
					break;
				}
			}
			
			if($d_tahun > 0){
				$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN'];
				break;
			}
			//	
		}else if($u_tahun > 0){
			//umur => 1 tahun
			if($d_tahun > 0){
				$d_hr_bulan = $d_bulan * 30;
				$d_hr_tahun = $d_tahun * 12 * 30;
				$d_hr = $d_hari + $d_hr_bulan + $d_hr_tahun;  
				
				$u_hr_bulan = $u_bulan * 30;
				$u_hr_tahun = $u_tahun * 12 * 30;
				$u_hr = $u_hari + $u_hr_bulan + $u_hr_tahun;
				
				if($u_hr <= $d_hr){
					$id = $dat['UMUR'] . '|' . $dat['NILAI_RUJUKAN'];
					break;
				}
			}
			//
		}

    }
    return $id;
}

function getKeadaanPulangRanap($sl) {
    $sql = 'SELECT * FROM m_pasien_keadaan_pulang ORDER BY URUT';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['KEADAAN_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['KEADAAN_ID'] . '" ' . $slc . ' >' . $dat['NAMA_KEADAAN'] . '</option>';
    }
    return $ret;
}

function getJenisPelayananIgd($sl) {
    $slc[1] = 'Bedah';
    $slc[2] = 'Penyakit Dalam';
    $slc[3] = 'Kebidanan';
	$slc[4] = 'Psikiatrik';
	$slc[5] = 'Anak';
	
    $ret = '';
    $i = 1;
    while ($i <= 5) {
        $slcx = '';
        if ($i == $sl) $slcx = 'selected="selected"';
        $ret = $ret . ' <option value="' . $i . '" ' . $slcx . ' >' . $slc[$i] . '</option>';
        $i++;
    }
    return $ret;
}

function getListTarifGroup($sl) {
    $sql = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP
			FROM m_tarif_group
			ORDER BY m_tarif_group.NAMA_TARIF_GROUP';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['KODE_TARIF_GROUP'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['KODE_TARIF_GROUP'] . '" ' . $slc . ' >' . $dat['NAMA_TARIF_GROUP'] . '</option>';
    }
    return $ret;
}

function getArrayTarifGroup() {
    $sql = 'SELECT m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP
			FROM m_tarif_group
			ORDER BY m_tarif_group.NAMA_TARIF_GROUP';
    $rsl = mysql_query($sql);
    $ret = array('' => '');
	while ($dat = mysql_fetch_array($rsl)) {
        $ret[$dat['KODE_TARIF_GROUP']]=$dat['NAMA_TARIF_GROUP'];
	}
    return $ret;
}

function getPerawat($sl) {
    $sql = 'SELECT m_pegawai.PEGAWAI_ID,
			m_pegawai.NAMA_PEGAWAI
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe 
			ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			WHERE m_pegawai_tipe.TIPE_PEGAWAI_ID = "6"
			ORDER BY m_pegawai.NAMA_PEGAWAI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
    }
    return $ret;
}

function getDriver($sl) {
    $sql = 'SELECT m_pegawai.PEGAWAI_ID,
			m_pegawai.NAMA_PEGAWAI
			FROM m_pegawai
			INNER JOIN m_pegawai_tipe 
			ON (m_pegawai.TIPE_PEGAWAI_ID = m_pegawai_tipe.TIPE_PEGAWAI_ID)
			WHERE m_pegawai_tipe.TIPE_PEGAWAI_ID = "15"
			ORDER BY m_pegawai.NAMA_PEGAWAI';
    $rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
    }
    return $ret;
}

function getJenisOperasi() {
	$ret = array();
	$ret[''] = '-';
    $sql = 'SELECT * FROM m_jenis_operasi';
    $rsl = mysql_query($sql);
    while ($dat = mysql_fetch_array($rsl)) {
        $ret[$dat['JENIS_OPERASI_ID']] = $dat['JENIS_OPERASI'];
    }
    return $ret;
}


function getJenisLuka() {
	$ret = array();
    $ret['1'] = 'Bersih';
	$ret['2'] = 'Bersih Kontaminasi';
	$ret['3'] = 'Kontaminasi';
	$ret['4'] = 'Kotor';
    return $ret;
}

function getLamaOperasi() {
	$ret = array();
    $ret['1'] = '1 Jam';
	$ret['2'] = '2 Jam';
	$ret['3'] = '5 Jam';
    return $ret;
}

function getResepAturanPakai(){
	$ret =  array();
	$ret['1'] = '4 x 1';
	$ret['2'] = '3 x 1';
	$ret['3'] = '2 x 1';
	$ret['4'] = '1 x 1';
    return $ret;
}

function getResepSatuan(){
	$ret =  array();
	$ret['1'] = 'Ampul';
	$ret['2'] = 'Sendok makan (15ml)';
	$ret['3'] = 'Sendok obat (5ml)';
	$ret['4'] = 'Tablet';
	$ret['5'] = 'Kapsul';
	$ret['6'] = 'Bungkus';
	$ret['7'] = 'Vial';
    return $ret;
}

function getResepWaktuPakai(){
	$ret =  array();
	$ret['1'] = 'Sebelum makan';
	$ret['2'] = 'Sesudah makan';
	$ret['3'] = 'Sewaktu makan';
	$ret['4'] = 'Dihabiskan';
	$ret['5'] = 'Kunyah dahulu';
	$ret['6'] = 'Bila perlu';
    return $ret;
}

function getResepNamaRacikan(){
	$ret =  array();
	$ret['1'] = 'Salep';
	$ret['2'] = 'Cream';
	$ret['3'] = 'Puyer';
	$ret['4'] = 'Kapsul';
    return $ret;
}

function getPaketObat(){
	global $hostname_3;
	global $username_3;
	global $password_3;
	global $database_3;
	
	$connect = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
	mysql_select_db($database_3, $connect) or die(mysql_error());
	$sql = 'SELECT t_paket_obat.PAKET_OBAT_ID,t_paket_obat.NAMA_PAKET_OBAT
			FROM t_paket_obat
			ORDER BY t_paket_obat.NAMA_PAKET_OBAT';
	$ret = array();
	$get = mysql_query($sql) or die(mysql_error());
	while($dat = mysql_fetch_array($get)){
		$ret[$dat['PAKET_OBAT_ID']] = $dat['NAMA_PAKET_OBAT'];
	}
	return $ret;	
}

function getJenisLaporanLab(){
	$sql = 'SELECT * FROM m_jenis_laporan_lab
			ORDER BY JENIS_LAPORAN';
	$ret = array();
	$get = mysql_query($sql) or die(mysql_error());
	$i = 0;
	while($dat = mysql_fetch_array($get)){
		$ret[$i] = $dat['JENIS_LAPORAN'];
	$i++;
	}
	return $ret;
}

function getUserRawatJalan($select,$unit,$modul){
	$sql = 'SELECT DISTINCT PEGAWAI_ID,NAMA_PEGAWAI
		FROM (
			SELECT p.PEGAWAI_ID,p.NAMA_PEGAWAI
			FROM m_pegawai p
			INNER JOIN m_app_user u
			ON (p.PEGAWAI_ID = u.PEGAWAI_ID)
			WHERE p.TIPE_PEGAWAI_ID IN (4,5,6,9,10,11)';
		
			if($modul == '4') $sql .= ' AND u.MODUL_ID = "' . $modul . '" AND u.UNIT_ID = "' . $unit . '"';
			if($modul == '15' or $modul == '100' or $modul == '105') $sql .= ' AND u.MODUL_ID = "' . $modul . '"';
			
	$sql .= 'UNION ALL
			SELECT p.PEGAWAI_ID,p.NAMA_PEGAWAI
			FROM m_pegawai p
			INNER JOIN t_dokter_jaga j
			ON (p.PEGAWAI_ID = j.PEGAWAI_ID)
		) t';		
		
	$sql .= ' ORDER BY NAMA_PEGAWAI';
		
	$rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $select)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
    }
    return $ret;	
}	

function getUserRawatInap($sl,$ruang){
	$sql = 'SELECT DISTINCT PEGAWAI_ID,NAMA_PEGAWAI
		FROM (
			SELECT p.PEGAWAI_ID,p.NAMA_PEGAWAI
			FROM m_pegawai p
			INNER JOIN m_app_user u
			ON (p.PEGAWAI_ID = u.PEGAWAI_ID)
			WHERE p.TIPE_PEGAWAI_ID IN (4,5,6,9,10,11)
			AND u.MODUL_ID = "11"';
	if($ruang != '') $sql .= ' AND u.RUANG_ID = "' . $ruang . '"';		
			
	$sql .= 'UNION ALL
			SELECT p.PEGAWAI_ID,p.NAMA_PEGAWAI
			FROM m_pegawai p
			INNER JOIN t_dokter_jaga j
			ON (p.PEGAWAI_ID = j.PEGAWAI_ID)
		) t';		
		
	$sql .= ' ORDER BY NAMA_PEGAWAI';
		
	$rsl = mysql_query($sql);
    $ret = '';
    while ($dat = mysql_fetch_array($rsl)) {
        $slc = '';
        if ($dat['PEGAWAI_ID'] == $sl)
            $slc = 'selected="selected"';
        $ret = $ret . ' <option value="' . $dat['PEGAWAI_ID'] . '" ' . $slc . ' >' . $dat['NAMA_PEGAWAI'] . '</option>';
    }
    return $ret;	
}

function getCash(){
    $arr_cash = array();
    $qry_cash = 'SELECT ID_CASH,KODE_CASH,PERC_POTONGAN,DESKRIPSI FROM m_cash';
    $get_cash = mysql_query($qry_cash) or die(mysql_error());
    $i = 0;
    while($dat_cash = mysql_fetch_array($get_cash)){
        $arr_cash[$i] = array('id'=>$dat_cash['ID_CASH'],
                            'kode'=>$dat_cash['KODE_CASH'],
                            'potongan'=>$dat_cash['PERC_POTONGAN'],
                            'deskripsi'=>$dat_cash['DESKRIPSI']);
        $i++;
    }

    return $arr_cash;
}

function getCashPotongan($ch=''){
    $potongan = 0;
    $qry_cash = 'SELECT PERC_POTONGAN FROM m_cash WHERE KODE_CASH = "' . $ch . '"';
    $get_cash = mysql_query($qry_cash) or die(mysql_error());
    $dat_cash = mysql_fetch_assoc($get_cash);
    $potongan = $dat_cash['PERC_POTONGAN'];

    return $potongan; 
}

function getRekening(){
    $arr_rekening = array();
    $qry_rekening = 'SELECT ID_REKENING,KODE_REKENING,DESKRIPSI FROM m_rekening';
    $get_rekening = mysql_query($qry_rekening) or die(mysql_error());
    $i = 0;
    while($dat_rekening = mysql_fetch_array($get_rekening)){
        $arr_rekening[$i] = array('id'=>$dat_rekening['ID_REKENING'],
                            'kode'=>$dat_rekening['KODE_REKENING'],
                            'deskripsi'=>$dat_rekening['DESKRIPSI']);
        $i++;
    }

    return $arr_rekening;
}

function getArrNonJaminan(){
	return array('1','18','26');
}	

function getArrRencanaJaminan(){
	return array('18','26');
}

function getArrUnitIGD(){
	return array('9','64');
}

function getArrIrjaNonKonsul(){
	return array('55');
}

function getArrIrjaEksekutif(){
	return array('54','63');
}	

function getArrJnsBayar(){	
    $ret = array();
	$sql = 'SELECT * FROM m_jaminan WHERE PENDAFTARAN = "1" ORDER BY URUT';
    $rsl = mysql_query($sql) or die(mysql_error());
    $i = 0;
    while($dat = mysql_fetch_array($rsl)){
        $ret[$i] = array('id'=>$dat['JAMINAN_ID'],
                         'nama'=>$dat['NAMA_JAMINAN']);
        $i++;
    }

    return $ret;
}

function getJenisBatalBayar(){
	return array('1'=>'BTL',
		'2'=>'KMB',
		'9'=>'LNL');
}

function getUserCasemix(){
	return array('alexranap');
}
?>