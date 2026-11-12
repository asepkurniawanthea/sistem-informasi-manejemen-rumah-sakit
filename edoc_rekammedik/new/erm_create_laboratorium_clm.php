<?php
function replace_newline($str){
	$ret = preg_replace('/\r|\n/','\n',trim($str));
	$ret = str_replace('\n','<br>',$ret);
	$ret = str_replace('<br><br>','<br>',$ret);
	return $ret;
}

function erm_laboratorium_clm($idx,$ord,$nomor){
	global $rmfile_path;
	
	$tanggal_validasi_bulan_nama['01'] = 'Januari';
	$tanggal_validasi_bulan_nama['02'] = 'Februari';
	$tanggal_validasi_bulan_nama['03'] = 'Maret';
	$tanggal_validasi_bulan_nama['04'] = 'April';
	$tanggal_validasi_bulan_nama['05'] = 'Mei';
	$tanggal_validasi_bulan_nama['06'] = 'Juni';
	$tanggal_validasi_bulan_nama['07'] = 'Juli';
	$tanggal_validasi_bulan_nama['08'] = 'Agustus';
	$tanggal_validasi_bulan_nama['09'] = 'September';
	$tanggal_validasi_bulan_nama['10'] = 'Oktober';
	$tanggal_validasi_bulan_nama['11'] = 'Nopember';
	$tanggal_validasi_bulan_nama['12'] = 'Desember';

	$templatelab = new \PhpOffice\PhpWord\TemplateProcessor(dirname(__FILE__) . '\laboratorium_form_lis.docx');
	
	if($ord == 'aps'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.PENUNJANG_ID AS RAWAT_ID,
			t_ipenunjang.NO_PASIEN_PENUNJANG AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			t_ipenunjang.NAMA_PASIEN AS NAMA_PASIEN,
			t_ipenunjang.JNS_KELAMIN AS JNS_KELAMIN,
			t_ipenunjang.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			t_ipenunjang.ALAMAT AS ALAMAT,
			t_ipenunjang.NO_TELEPON AS NO_TELEPON,
			t_ipenunjang.INSTANSI_PENGIRIM AS NAMA_UNIT,
			t_ipenunjang.PENGIRIM AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,
			m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_ipenunjang.ALAMAT_RT,t_ipenunjang.ALAMAT_RW,
			t_ipenunjang.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
			DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_PERIKSA,
			t_ipenunjang.NO_ORDER,
			t_ipenunjang.NO_LABORATORIUM
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (t_ipenunjang.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';
	}else if($ord == 'irj'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			m_unit.NAMA_UNIT AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,
			m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
			DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_PERIKSA,
			t_ipenunjang.NO_ORDER,
			t_ipenunjang.NO_LABORATORIUM
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
			AND t_ipenunjang.NO_ORDER = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "IRJ"';	
	}else if($ord == 'irn'){
		$jns_perawatan = '2';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT) AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,
			m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
			DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_PERIKSA,
			t_ipenunjang.NO_ORDER,
			t_ipenunjang.NO_LABORATORIUM
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
			AND t_ipenunjang.NO_ORDER = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "IRN"';	
	}else if($ord == 'hrj'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,
			m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
			DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_PERIKSA,
			t_ipenunjang.NO_ORDER,
			t_ipenunjang.NO_LABORATORIUM
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
			AND t_ipenunjang.NO_ORDER = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "HRJ"';	
	}else if($ord == 'hri'){
		$jns_perawatan = '2';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT,"-Hemodialisa") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
			DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_PERIKSA,
			t_ipenunjang.NO_ORDER,
			t_ipenunjang.NO_LABORATORIUM
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
			AND t_ipenunjang.NO_ORDER = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "HRI"';			
	}else if($ord == 'ori'){
		$jns_perawatan = '2';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT,"-Kamar Operasi") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,
			m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
			DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_PERIKSA,
			t_ipenunjang.NO_ORDER,
			t_ipenunjang.NO_LABORATORIUM
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
			AND t_ipenunjang.NO_ORDER = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "ORI"';
	}else if($ord == 'orj'){
		$jns_perawatan = '1';
		$qry_lab = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
			t_ipenunjang.RAWAT_ID,
			t_ipenunjang.NOMR AS NOMR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%Y/%m/%d") AS TANGGAL_DAFTAR_2,
			m_pasien.NAMA_PASIEN AS NAMA_PASIEN,
			m_pasien.JNS_KELAMIN AS JNS_KELAMIN,
			m_pasien.NAMA_IBU AS NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y/%m/%d") AS TGL_LAHIR_2,
			m_pasien.ALAMAT AS ALAMAT,
			m_pasien.NO_TELEPON AS NO_TELEPON,
			CONCAT(m_unit.NAMA_UNIT,"-Kamar Operasi") AS NAMA_UNIT,
			m_pegawai2.NAMA_PEGAWAI AS DOKTER_PENGIRIM, 
			m_jaminan.NAMA_JAMINAN,
			m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER,
			DATE_FORMAT(t_ipenunjang.TANGGAL_PERIKSA_NW,"%d-%m-%Y %H:%i:%s") AS TANGGAL_PERIKSA,
			t_ipenunjang.NO_ORDER,
			t_ipenunjang.NO_LABORATORIUM
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
			AND t_ipenunjang.NO_ORDER = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "ORJ"';			
	}
	
	$get_lab = mysql_query($qry_lab) or die(mysql_error());
	$dat_lab = mysql_fetch_assoc($get_lab);
	
	$rawat_id = $dat_lab['RAWAT_ID'];
	$nomr = $dat_lab['NOMR'];
    $nama_pasien = $dat_lab['NAMA_PASIEN'];
    $tgl_lahir = $dat_lab['TGL_LAHIR'];
    $jns_kelamin = $dat_lab['JNS_KELAMIN'];
    $alamat = trim($dat_lab['ALAMAT']) . ' ' . trim($dat_lab['ALAMAT_RT']) . '/' . trim($dat_lab['ALAMAT_RW']) . ' ' . trim($dat_lab['NAMA_KELURAHAN']) . ' ' . trim($dat_lab['NAMA_KECAMATAN']);
    if (!empty($dat_lab['NO_TELEPON']))
        $alamat = $alamat . ', Telp. ' . $dat_lab['NO_TELEPON'];
	$alamat = str_replace('\' ', '\'', ucwords(str_replace('\'', '\' ', strtolower($alamat))));
	$st_baru = $dat_lab['ST_BARU'];
	$nama_unit = $dat_lab['NAMA_UNIT'];
    $nama_dokter = $dat_lab['DOKTER_PENGIRIM'];
    $tgl_order = $dat_lab['TANGGAL_ORDER'];
	$tgl_daftar = $dat_lab['TANGGAL_DAFTAR'];
	$no_laboratorium = $dat_lab['NO_LABORATORIUM'];
	$tgl_periksa = $dat_lab['TANGGAL_PERIKSA'];

    $umur = getUmurDaftar($dat_lab['TGL_LAHIR'],$dat_lab['TANGGAL_DAFTAR']);
	$tgl_lahir = str_replace('/', '-', $tgl_lahir);
	
	if (strlen($nomr) == 8) {
        $rm1 = substr($nomr, 0, 4);
        $rm2 = substr($nomr, 4, 4);
        $nomr = $rm1 . '-' . $rm2;
    }

    if (strlen($nomr) == 6) {
        $rm1 = substr($nomr, 0, 2);
        $rm2 = substr($nomr, 2, 2);
        $rm3 = substr($nomr, 4, 2);
        $nomr = $rm1 . '-' . $rm2 . '-' . $rm3;
    }
	
	if ($jns_kelamin == 'L')
        $jns_kelamin = 'Laki-laki';
    if ($jns_kelamin == 'P')
        $jns_kelamin = 'Perempuan';

    $asal_pasien = $nama_unit;
    if ($ord == 'aps') {
        $asal_pasien = 'Permintaan Sendiri';
        $no_laboratorium = 'APS/' . $no_laboratorium;
    }
    if ($nama_unit == 'IGD') {
        $no_laboratorium = 'IGD/' . $no_laboratorium;
    }
    if (($nama_unit != 'IGD') and ($ord == 'irj')) {
        $asal_pasien = 'Poliklinik ' . $asal_pasien;
        $no_laboratorium = 'RJ/' . $no_laboratorium;
    }
    if ($ord == 'irn') {
        $no_laboratorium = 'RI/' . $no_laboratorium;
    }

    if ($st_baru == '1')
        $asal_pasien = $asal_pasien . ' (Pasien Baru)';
	
	$tgl_order_array = explode(' ', $tgl_order);
	$tanggal_order = $tgl_order_array[0];
	$jam_order = $tgl_order_array[1];
	
	$templatelab->setValue('nomor', $no_laboratorium);
	$templatelab->setValue('nomor_mr', $nomr);
	$templatelab->setValue('nama_pasien', htmlspecialchars($nama_pasien));
	$templatelab->setValue('tanggal_lahir', $tgl_lahir);
	$templatelab->setValue('jenis_kelamin', $jns_kelamin);
	$templatelab->setValue('alamat', htmlspecialchars($alamat));
	$templatelab->setValue('permintaan_tanggal', $tanggal_order . ' Jam : ' . $jam_order);
	$templatelab->setValue('asal', htmlspecialchars($asal_pasien));
	$templatelab->setValue('dokter_pengirim', htmlspecialchars($nama_dokter));
	
	if($ord != 'aps'){
		$sql_lab_detail = 'SELECT LIS_ID,PENUNJANG_ID,RAWAT_ID,JNS_ORDER,NO_ORDER,NO_TARIF,KODE_TEST,NAMA_TEST,GROUP_TEST,
				RUJUKAN,TIPE_DATA,HASIL,FLAG,SATUAN,KETERANGAN_HASIL,KODE_PETUGAS,NAMA_PETUGAS,
				DATE_FORMAT(TGL_VALIDASI,"%d-%m-%Y") AS TGL_VALIDASI,
				DATE_FORMAT(TGL_VALIDASI,"%d-%m-%Y %H:%i:%s") AS TGL_TRANS
				FROM t_laboratorium_lis_data
				WHERE RAWAT_ID = "' . $idx . '" 
				AND NO_ORDER = "' . $nomor . '"
				AND JNS_ORDER = "' . $ord . '"
				ORDER BY LIS_ID';
	}else{
		$sql_lab_detail = 'SELECT LIS_ID,PENUNJANG_ID,RAWAT_ID,JNS_ORDER,NO_ORDER,NO_TARIF,KODE_TEST,NAMA_TEST,GROUP_TEST,
				RUJUKAN,TIPE_DATA,HASIL,FLAG,SATUAN,KETERANGAN_HASIL,KODE_PETUGAS,NAMA_PETUGAS,
				DATE_FORMAT(TGL_VALIDASI,"%d-%m-%Y") AS TGL_VALIDASI,
				DATE_FORMAT(TGL_VALIDASI,"%d-%m-%Y %H:%i:%s") AS TGL_TRANS
				FROM t_laboratorium_lis_data
				WHERE PENUNJANG_ID = "' . $idx . '" 
				AND NO_ORDER = "' . $nomor . '"
				AND JNS_ORDER = "' . $ord . '"
				ORDER BY LIS_ID';
	}	
	$get_lab_detail = mysql_query($sql_lab_detail) or die(mysql_error());	
	$dat_lab_detail = mysql_fetch_assoc($get_lab_detail);
    
	$tanggal_validasi_array = explode('-',$tgl_periksa);
    $tanggal_validasi_hari = $tanggal_validasi_array[0] + 0;
    $tanggal_validasi_bulan = $tanggal_validasi_array[1];
    $tanggal_validasi_tahun = $tanggal_validasi_array[2];
    $tanggal_validasi = $tanggal_validasi_hari . ' ' . $tanggal_validasi_bulan_nama[$tanggal_validasi_bulan] . ' ' . $tanggal_validasi_tahun;
	$templatelab->setValue('tanggal', $tanggal_validasi);
	$templatelab->setValue('nama_pemeriksa', htmlspecialchars($dat_lab_detail['NAMA_PETUGAS']));
	$templatelab->setValue('dicetak_oleh', $dat_lab_detail['TGL_TRANS']);
	
	mysql_data_seek($get_lab_detail,0);
	$nama_pemeriksaan_report = '';
	$nama_pemeriksaan_group = '';
	$jml_row = 0;
	$jml_group = 0;
	$jml_report = 0;
	while($dat_lab_detail = mysql_fetch_array($get_lab_detail)){
		if ($nama_pemeriksaan_report != $dat_lab_detail['GROUP_TEST']) {
			$nama_pemeriksaan_report = $dat_lab_detail['GROUP_TEST'];
			$jml_report++; 	
		} 	
	};
	
	mysql_data_seek($get_lab_detail,0);
	while($dat_lab_detail = mysql_fetch_array($get_lab_detail)){
		if(trim($dat_lab_detail['HASIL'] == '')){
			if ($nama_pemeriksaan_group != $dat_lab_detail['NAMA_TEST']) {
				$nama_pemeriksaan_group = $dat_lab_detail['NAMA_TEST'];
				$jml_group++; 	
			} 	
		}
	};
	
	mysql_data_seek($get_lab_detail,0);
	while($dat_lab_detail = mysql_fetch_array($get_lab_detail)){
		if(trim($dat_lab_detail['HASIL'] != '')){
				$jml_row++; 	
		}
	};
	
	$templatelab->cloneRow('pemeriksaan_row', $jml_row + $jml_report + $jml_group);
	
	$tbl_center = '<w:tbl><w:tblPr><w:tblStyle w:val="TableGrid"/><w:tblW w:w="0" w:type="auto"/><w:tblBorders><w:top w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:left w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:bottom w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:right w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideH w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideV w:val="none" w:sz="0" w:space="0" w:color="auto"/></w:tblBorders><w:tblLook w:val="04A0"/></w:tblPr><w:tblGrid><w:gridCol w:w="9576"/></w:tblGrid><w:tr w:rsidR="008625A1" w:rsidRPr="00B83DDE" w:rsidTr="002934D7"><w:tc><w:tcPr><w:tcW w:w="9576" w:type="dxa"/></w:tcPr><w:p w:rsidR="008625A1" w:rsidRPr="00B83DDE" w:rsidRDefault="000B0E14" w:rsidP="008A2F08"><w:pPr><w:jc w:val="center"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00B83DDE"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil}</w:t></w:r></w:p></w:tc></w:tr></w:tbl>';
	$tbl_left = '<w:tbl><w:tblPr><w:tblStyle w:val="TableGrid"/><w:tblW w:w="0" w:type="auto"/><w:tblBorders><w:top w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:left w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:bottom w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:right w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideH w:val="none" w:sz="0" w:space="0" w:color="auto"/><w:insideV w:val="none" w:sz="0" w:space="0" w:color="auto"/></w:tblBorders><w:tblLook w:val="04A0"/></w:tblPr><w:tblGrid><w:gridCol w:w="9576"/></w:tblGrid><w:tr w:rsidR="008A2F08" w:rsidRPr="00B83DDE" w:rsidTr="002934D7"><w:tc><w:tcPr><w:tcW w:w="9576" w:type="dxa"/></w:tcPr><w:p w:rsidR="008A2F08" w:rsidRPr="00B83DDE" w:rsidRDefault="000B0E14" w:rsidP="008A2F08"><w:pPr><w:jc w:val="both"/><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr></w:pPr><w:r w:rsidRPr="00B83DDE"><w:rPr><w:rFonts w:ascii="Arial Narrow" w:hAnsi="Arial Narrow"/><w:sz w:val="24"/><w:szCs w:val="24"/></w:rPr><w:t>${rpl_hasil}</w:t></w:r></w:p></w:tc></w:tr></w:tbl>';
		
	$nama_pemeriksaan_report = '';
	$nama_pemeriksaan_group = '';
	$l = 1;
	mysql_data_seek($get_lab_detail,0);
	while($dat_lab_detail = mysql_fetch_array($get_lab_detail)){
		if ($nama_pemeriksaan_report != $dat_lab_detail['GROUP_TEST']) {
			$nama_pemeriksaan_report = $dat_lab_detail['GROUP_TEST'];
			$templatelab->setValue('pemeriksaan_row#' . $l, '<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars(strtoupper($dat_lab_detail['GROUP_TEST'])) . '</w:t></w:r>');
			$templatelab->setValue('hasil#' . $l, '');
			$templatelab->setValue('satuan#' . $l, '');
			$templatelab->setValue('nilai_rujukan#' . $l, '');
			$l++;
		}
		
		$sm = true;
		$nama_pemeriksaan_group_temp = '';
		if(trim($dat_lab_detail['HASIL']) == '') $nama_pemeriksaan_group_temp = $dat_lab_detail['NAMA_TEST'];
		if ($nama_pemeriksaan_group != $nama_pemeriksaan_group_temp) {
			$nama_pemeriksaan_group = $nama_pemeriksaan_group_temp;
			$sm = false;
		}
		
		if (!empty($nama_pemeriksaan_group_temp) and $sm == false) {
			$templatelab->setValue('pemeriksaan_row#' . $l, '<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars($nama_pemeriksaan_group_temp) . '</w:t></w:r>');
			$templatelab->setValue('hasil#' . $l, '');
			$templatelab->setValue('satuan#' . $l, '');
			$templatelab->setValue('nilai_rujukan#' . $l, '');
		}	
		
		if($dat_lab_detail['HASIL'] == ''){
			$nama_pemeriksaan = '<w:r><w:rPr><w:b/></w:rPr><w:t>' . htmlspecialchars($dat_lab['NAMA_TEST']) . '</w:t></w:r>';
		}else{
			$nama_pemeriksaan = htmlspecialchars($dat_lab_detail['NAMA_TEST']);		
		}		
		
		if(strlen($dat_lab_detail['HASIL']) <= 20){
				$hasil_test = str_replace('${rpl_hasil}',$dat_lab_detail['HASIL'],$tbl_center);
		}else{
				
				$hasil_test = replace_newline($dat_lab_detail['HASIL']);
				$hasil_test = HTMLtoOpenXML::getInstance()->fromHTML($hasil_test);
		}	
		
		$satuan = replace_newline($dat_lab_detail['SATUAN']);
		$satuan = HTMLtoOpenXML::getInstance()->fromHTML($satuan);
		
		$rujukan = replace_newline($dat_lab_detail['RUJUKAN']);
		$rujukan = HTMLtoOpenXML::getInstance()->fromHTML($rujukan);
				
		$templatelab->setValue('pemeriksaan_row#' . $l, $nama_pemeriksaan);
		$templatelab->setValue('hasil#' . $l, $hasil_test);
		$templatelab->setValue('satuan#' . $l, $satuan);
		$templatelab->setValue('nilai_rujukan#' . $l, $rujukan);
		
		$l++;
	}	
		
	if(!file_exists($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id, 0700, true);
	}

	if(!file_exists($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id)){
		@mkdir($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id, 0700, true);
	}
	
	$nama_file = $dat_lab['NOMR'] . '_' . strtoupper($ord) . $rawat_id . '_66_' . $nomor . '_' . $form;	
	$templatelab->saveAs($rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.docx');
	mysql_query('DELETE FROM t_rm_dokumen_file 
				WHERE RAWAT_ID = "' . $rawat_id . '"
				AND JNS_PERAWATAN = "' . $jns_perawatan . '"
				AND JENIS_DOKUMEN_ID = "66"
				AND ORDER_PENUNJANG = "' . strtoupper($ord) . $nomor . $form . '"') or die(mysql_error());
	mysql_query('INSERT INTO t_rm_dokumen_file(JENIS_DOKUMEN_ID,NOMR,RAWAT_ID,JNS_PERAWATAN,NAMA_FILE,ST_SISTEM,
				ORDER_PENUNJANG,TANGGAL) VALUES("66","' . $dat_lab['NOMR'] . '","' . $rawat_id . '","' . $jns_perawatan . '",
				"' . $nama_file . '.pdf","1","' . strtoupper($ord) . $nomor . $form . '",
				STR_TO_DATE("' . $dat_lab['TANGGAL_DAFTAR'] . '","%d/%m/%Y"))') or die(mysql_error());	

	$source_file = $rmfile_path . '/doc/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.docx';			
	$source_file = str_replace('/','\\',$source_file);
	$target_file = $rmfile_path . '/pdf/' . $jns_perawatan . '/' . $dat_lab['NOMR'] . '/' . $rawat_id . '/' . $nama_file . '.pdf';
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