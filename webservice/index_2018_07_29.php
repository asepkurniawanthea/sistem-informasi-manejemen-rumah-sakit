<?php

require_once('lib/nusoap.php');
require_once('../config/config.php');
require_once('../shared/connect_db.php');
require_once('../shared/function.php');

$server = new soap_server;

$server->register('getPasien');

function getPasien($nomr) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT m_pasien.PASIEN_ID,m_pasien.NOMR,m_pasien.PARENT_NOMR,m_pasien.NAMA_PASIEN,
			m_pasien.TMP_LAHIR,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			m_pasien.TGL_LAHIR AS TGL_LAHIR_2,
			CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Lk" ELSE "Pr" END AS JNS_KELAMIN,
			CASE WHEN m_pasien.ST_KAWIN = "1" THEN "Belum Kawin" WHEN m_pasien.ST_KAWIN = "2" THEN "Kawin" 
			WHEN m_pasien.ST_KAWIN = "3" THEN "Janda/Duda" END AS ST_KAWIN,
			m_agama.NAMA_AGAMA,m_pendidikan.NAMA_PENDIDIKAN,m_pasien.PEKERJAAN,m_pasien.ALAMAT,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,m_propinsi.NAMA_PROPINSI,
			m_pasien.KODE_POS,m_pasien.NO_TELEPON,m_pasien.NAMA_IBU,m_pasien.NAMA_AYAH,m_pasien.NAMA_SUAMI_ISTERI,m_pasien.NIK,m_pasien.KHUSUS
			FROM m_pasien
			LEFT JOIN m_agama ON (m_pasien.AGAMA_ID = m_agama.AGAMA_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			LEFT JOIN m_propinsi ON (m_pasien.PROPINSI_ID = m_propinsi.PROPINSI_ID) 
			LEFT JOIN m_pendidikan ON (m_pasien.PENDIDIKAN_ID = m_pendidikan.PENDIDIKAN_ID)
			WHERE m_pasien.NOMR = "' . $nomr . '"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('PASIEN_ID' => $r['PASIEN_ID'],
            'NOMR' => $r['NOMR'],
            'PARENT_NOMR' => $r['PARENT_NOMR'],
            'NAMA_PASIEN' => $r['NAMA_PASIEN'],
            'TMP_LAHIR' => $r['TMP_LAHIR'],
            'TGL_LAHIR' => $r['TGL_LAHIR'],
			'TGL_LAHIR_2' => $r['TGL_LAHIR_2'],
            'JNS_KELAMIN' => $r['JNS_KELAMIN'],
            'ST_KAWIN' => $r['ST_KAWIN'],
            'NAMA_AGAMA' => $r['NAMA_AGAMA'],
            'NAMA_PENDIDIKAN' => $r['NAMA_PENDIDIKAN'],
            'PEKERJAAN' => $r['PEKERJAAN'],
            'ALAMAT' => $r['ALAMAT'],
            'ALAMAT_RT' => $r['ALAMAT_RT'],
            'ALAMAT_RW' => $r['ALAMAT_RW'],
            'NAMA_KELURAHAN' => $r['NAMA_KELURAHAN'],
            'NAMA_KECAMATAN' => $r['NAMA_KECAMATAN'],
            'NAMA_KOTA' => $r['NAMA_KOTA'],
            'NAMA_PROPINSI' => $r['NAMA_PROPINSI'],
            'KODE_POS' => $r['KODE_POS'],
            'NAMA_IBU' => $r['NAMA_IBU'],
			'NAMA_AYAH' => $r['NAMA_AYAH'],
			'NAMA_SUAMI_ISTERI' => $r['NAMA_SUAMI_ISTERI'],
			'NIK' => $r['NIK'],
			'KHUSUS' => $r['KHUSUS']
        );
    }
    return $ret;
}

$server->register('getIrja');

function getIrja($idx) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			t_irja.ST_BARU,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,t_irja.MT_RUJUKAN,m_jaminan.NAMA_JAMINAN,
			t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,m_asal_pasien.KET_ASAL_PASIEN,t_irja.PASIEN_MASUK,
			t_irja.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irja.NO_PENDAFTARAN,t_irja.SHIFT_ID,t_irja.USER_PENDAFTARAN
			FROM t_irja 
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
			LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irja.IRJA_ID = "' . $idx . '"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
	
		$sql_kunjungan = 'SELECT IRJA_ID
							FROM t_irja WHERE NOMR = "' . $r['NOMR'] . '"
							AND NO_PENDAFTARAN IS NOT NULL AND ST_BATAL IS NULL
							AND DATE_FORMAT(TANGGAL_DAFTAR,"%d/%m/%Y") = "' . $r['TANGGAL_DAFTAR'] . '"
							AND IRJA_ID <= ' . $idx . '
							ORDER BY IRJA_ID';
		$get_kunjungan = mysql_query($sql_kunjungan) or die(mysql_error());
		$knj = 0;
		while($dat_kunjungan = mysql_fetch_array($get_kunjungan)){
			$knj++;		
		}
	
        $ret[] = array('IRJA_ID' => $r['IRJA_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
            'ST_BARU' => $r['ST_BARU'],
            'NAMA_UNIT' => $r['NAMA_UNIT'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'MT_RUJUKAN' => $r['MT_RUJUKAN'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'] . '-' . $knj,
			'KET_ASAL_PASIEN' => $r['KET_ASAL_PASIEN'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'SHIFT_ID' => $r['SHIFT_ID'],
			'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN']
        );
    }
    return $ret;
}

$server->register('getIrjaKasir');

function getIrjaKasir($idx,$nomor) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			t_irja.ST_BARU,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,t_irja.MT_RUJUKAN,
			CASE WHEN m_jaminan2.NAMA_JAMINAN IS NOT NULL THEN m_jaminan2.NAMA_JAMINAN
			ELSE m_jaminan.NAMA_JAMINAN END AS NAMA_JAMINAN,
			t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,m_asal_pasien.KET_ASAL_PASIEN,t_irja.PASIEN_MASUK,
			t_irja.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irja.NO_PENDAFTARAN,t_irja.SHIFT_ID,t_irja_tarif.USER_PENDAFTARAN,
			t_irja_tarif.USER_KASIR
			FROM t_irja 
			INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
			LEFT JOIN m_jaminan m_jaminan2 ON (t_irja_tarif.JENIS_BAYAR_ID = m_jaminan2.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irja.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF = "' . $nomor . '"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRJA_ID' => $r['IRJA_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
            'ST_BARU' => $r['ST_BARU'],
            'NAMA_UNIT' => $r['NAMA_UNIT'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'MT_RUJUKAN' => $r['MT_RUJUKAN'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'],
			'KET_ASAL_PASIEN' => $r['KET_ASAL_PASIEN'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'SHIFT_ID' => $r['SHIFT_ID'],
			'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN'],
			'USER_KASIR' => $r['USER_KASIR']
        );
    }
    return $ret;
}

$server->register('getPembayaranKarcis');

function getPembayaranKarcis($idx,$nomor) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
		$sql = 'SELECT t_irja_tarif.IRJA_TARIF_ID,t_irja_tarif.IRJA_ID,t_irja_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,t_irja_tarif.KUANTITI,t_irja_tarif.NO_TARIF,t_irja_tarif.DESKRIPSI,m_tarif.SATUAN,
				m_tarif.TARIF_NON_KELAS,m_tarif_group.NAMA_TARIF_GROUP
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF = "' . $nomor . '"
				ORDER BY m_tarif.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
		
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRJA_TARIF_ID' => $r['IRJA_TARIF_ID'],
            'IRJA_ID' => $r['IRJA_ID'],
            'TARIF_ID' => $r['TARIF_ID'],
            'KODE_TARIF' => $r['KODE_TARIF'],
			'NAMA_TARIF' => $r['NAMA_TARIF'] . '(' . $r['NAMA_TARIF_GROUP'] . ')',
			'KUANTITI' => $r['KUANTITI'],
			'NO_TARIF' => $r['NO_TARIF'],
			'DESKRIPSI' => $r['DESKRIPSI'],
			'SATUAN' => $r['SATUAN'],
			'TARIF_NON_KELAS' => $r['TARIF_NON_KELAS']
        );
    }
    return $ret;
}

$server->register('getPembayaranIrja');

function getPembayaranIrja($idx,$nomor) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
		$sql = 'SELECT t_irja_tarif.IRJA_ID,t_irja_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,SUM(t_irja_tarif.KUANTITI) AS KUANTITI,t_irja_tarif.NO_TARIF,t_irja_tarif.DESKRIPSI,m_tarif.SATUAN,
				SUM(t_irja_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
				CASE WHEN t_irja_tarif.PEGAWAI_ID IS NOT NULL THEN 
				(SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irja_tarif.PEGAWAI_ID) 
				END AS PEGAWAI_ID
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $idx . '" AND t_irja_tarif.NO_TARIF = "' . $nomor . '"
				GROUP BY t_irja_tarif.IRJA_ID,t_irja_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,t_irja_tarif.NO_TARIF,t_irja_tarif.DESKRIPSI,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP
				ORDER BY m_tarif.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
		
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
	
		$nama_tarif = $r['NAMA_SKT'];
		if(!empty($r['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r['PEGAWAI_ID'];
	
        $ret[] = array('IRJA_ID' => $r['IRJA_ID'],
            'TARIF_ID' => $r['TARIF_ID'],
            'KODE_TARIF' => $r['KODE_TARIF'],
			'NAMA_TARIF' => $r['NAMA_TARIF'],
			'KUANTITI' => $r['KUANTITI'],
			'NO_TARIF' => $r['NO_TARIF'],
			'DESKRIPSI' => $r['DESKRIPSI'],
			'SATUAN' => $r['SATUAN'],
			'TARIF_NON_KELAS' => $r['TARIF_NON_KELAS'],
			'NAMA_TARIF_GROUP' => $nama_tarif
        );
    }
    return $ret;
}

$server->register('getIrna');

function getIrna($idx) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			m_ruang.NAMA_RUANG,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN,
			t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,t_irna.PASIEN_MASUK,
			t_irna.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irna.NO_PENDAFTARAN,t_irna.SHIFT_ID,t_irna.USER_PENDAFTARAN,t_irna.KELAS_RAWAT,
			DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_DAFTAR_IRJA
			FROM t_irna 
			INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
			INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
			INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irna.IRNA_ID = "' . $idx . '"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRNA_ID' => $r['IRNA_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR_IRJA'],
            'NAMA_RUANG' => $r['NAMA_RUANG'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'SHIFT_ID' => $r['SHIFT_ID'],
			'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN'],
			'KELAS_RAWAT' => $r['KELAS_RAWAT']
        );
    }
    return $ret;
}

$server->register('getIrnaKasir');

function getIrnaKasir($idx,$nomor) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,t_irna.PASIEN_MASUK,
			t_irna.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irna.NO_PENDAFTARAN,t_irna_tarif.USER_PENDAFTARAN,
			t_irna_tarif.USER_KASIR,t_irna_tarif.KELAS_RAWAT,
			CASE WHEN t_irna_tarif.PEGAWAI_ID IS NULL THEN m_pegawai.NAMA_PEGAWAI ELSE m_pegawai1.NAMA_PEGAWAI END AS NAMA_PEGAWAI
			FROM t_irna 
			INNER JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID)
			INNER JOIN m_ruang ON (t_irna_tarif.RUANG_ID = m_ruang.RUANG_ID)
			INNER JOIN m_jaminan ON (t_irna_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai1 ON (t_irna_tarif.PEGAWAI_ID = m_pegawai1.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irna.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF = "' . $nomor . '"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRNA_ID' => $r['IRNA_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
            'NAMA_RUANG' => $r['NAMA_RUANG'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN'],
			'USER_KASIR' => $r['USER_KASIR'],
			'KELAS_RAWAT' => $r['KELAS_RAWAT']
        );
    }
    return $ret;
}

$server->register('getPembayaranIrna');

function getPembayaranIrna($idx,$nomor) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
		$sql = 'SELECT t_irna_tarif.IRNA_ID,t_irna_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,SUM(t_irna_tarif.KUANTITI) AS KUANTITI,t_irna_tarif.NO_TARIF,t_irna_tarif.DESKRIPSI,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
				CASE WHEN t_irna_tarif.PEGAWAI_PELAKSANA_ID IS NOT NULL THEN CONCAT(" /",t_irna_tarif.PEGAWAI_ID) END AS PEGAWAI_ID,
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
				END AS TARIF
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '" AND t_irna_tarif.NO_TARIF = "' . $nomor . '"
				GROUP BY t_irna_tarif.IRNA_ID,t_irna_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,t_irna_tarif.NO_TARIF,t_irna_tarif.DESKRIPSI,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
				ORDER BY m_tarif.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
		
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRNA_ID' => $r['IRNA_ID'],
            'TARIF_ID' => $r['TARIF_ID'],
            'KODE_TARIF' => $r['KODE_TARIF'],
			'NAMA_TARIF' => $r['NAMA_TARIF'],
			'KUANTITI' => $r['KUANTITI'],
			'NO_TARIF' => $r['NO_TARIF'],
			'DESKRIPSI' => $r['DESKRIPSI'],
			'SATUAN' => $r['SATUAN'],
			'TARIF' => $r['TARIF'] * $r['KUANTITI'],
			'NAMA_TARIF_GROUP' => $r['PEGAWAI_ID'] . $r['NAMA_SKT']
        );
    }
    return $ret;
}


$server->register('getPenunjang');

function getPenunjang($idx,$nomor,$ord) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    
	if($ord != 'hirj' and $ord != 'hirn'){
		$sql = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,t_ipenunjang.NOMR,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NO_PASIEN_PENUNJANG ELSE m_pasien.NOMR END AS NOMR,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NAMA_PASIEN ELSE m_pasien.NAMA_PASIEN END AS NAMA_PASIEN,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.JNS_KELAMIN ELSE m_pasien.JNS_KELAMIN END AS JNS_KELAMIN,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NAMA_IBU ELSE m_pasien.NAMA_IBU END AS NAMA_IBU,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") ELSE DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") END AS TGL_LAHIR,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.TGL_LAHIR ELSE m_pasien.TGL_LAHIR END AS TGL_LAHIR_2,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.ALAMAT ELSE m_pasien.ALAMAT END AS ALAMAT,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.PENGIRIM ELSE m_pegawai.NAMA_PEGAWAI END AS NAMA_PEGAWAI,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.INSTANSI_PENGIRIM 
			 WHEN t_ipenunjang.JNS_ORDER = "IRJ" THEN m_unit.NAMA_UNIT 
			 WHEN t_ipenunjang.JNS_ORDER = "IRN" THEN CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT)
			 WHEN t_ipenunjang.JNS_ORDER = "HRJ" THEN CONCAT(m_unit.NAMA_UNIT,"-Hemodialisa") 
			 WHEN t_ipenunjang.JNS_ORDER = "HRN" THEN CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT,"-Hemodialisa") END AS NAMA_UNIT,
			CASE WHEN m_jaminan2.NAMA_JAMINAN IS NOT NULL THEN m_jaminan2.NAMA_JAMINAN
			ELSE m_jaminan.NAMA_JAMINAN END AS NAMA_JAMINAN,
			t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.USER_KASIR,t_ipenunjang_tarif.USER_PENDAFTARAN,
			m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,t_ipenunjang_tarif.NO_SJP,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
			m_pegawai2.NAMA_PEGAWAI AS NAMA_PELAKSANA,
			DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_MASUK
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			LEFT JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
			LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_jaminan m_jaminan2 ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan2.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)';
			if($ord == 'aps'){
				$sql = $sql . ' WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
			}else{
				$sql = $sql . ' WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"';
			}	
			$sql = $sql . ' AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"
							AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"';
						
		$q = mysql_query($sql);
		while ($r = mysql_fetch_array($q)) {
			$ret[] = array('PENUNJANG_ID' => $r['PENUNJANG_ID'],
				'NOMR' => $r['NOMR'],
				'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
				'NAMA_UNIT' => $r['NAMA_UNIT'],
				'NAMA_PENUNJANG' => $r['NAMA_PENUNJANG'],
				'NAMA_PASIEN' => $r['NAMA_PASIEN'],
				'JNS_KELAMIN' => $r['JNS_KELAMIN'],
				'NAMA_IBU' => $r['NAMA_IBU'],
				'TGL_LAHIR' => $r['TGL_LAHIR'],
				'TGL_LAHIR_2' => $r['TGL_LAHIR_2'],
				'ALAMAT' => $r['ALAMAT'],
				'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
				'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
				'NO_TARIF' => $r['NO_TARIF'],
				'NO_SJP' => $r['NO_SJP'],
				'USER_KASIR' => $r['USER_KASIR'],
				'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN'],
				'NAMA_KELURAHAN' => $r['NAMA_KELURAHAN'],
				'NAMA_KECAMATAN' => $r['NAMA_KECAMATAN'],
				'NAMA_PELAKSANA' => $r['NAMA_PELAKSANA'],
				'TANGGAL_MASUK' => $r['TANGGAL_MASUK']
			);
		}
	}else{
		$xord = strtoupper(str_replace('h','',$ord));
		$sql = 'SELECT DISTINCT t_hemodialisa.HEMODIALISA_ID,t_hemodialisa.NOMR,
			DATE_FORMAT(t_hemodialisa.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			m_pasien.NOMR,m_pasien.NAMA_PASIEN,m_pasien.JNS_KELAMIN,m_pasien.NAMA_IBU,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			m_pasien.TGL_LAHIR AS TGL_LAHIR_2,m_pasien.ALAMAT,
			m_pegawai.NAMA_PEGAWAI,
			CASE WHEN t_hemodialisa.JNS_ORDER = "IRJ" THEN m_unit.NAMA_UNIT 
			 WHEN t_hemodialisa.JNS_ORDER = "IRN" THEN CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT) END AS NAMA_UNIT,
			CASE WHEN m_jaminan2.NAMA_JAMINAN IS NOT NULL THEN m_jaminan2.NAMA_JAMINAN
				ELSE m_jaminan.NAMA_JAMINAN END AS NAMA_JAMINAN,
			t_hemodialisa_tarif.NO_TARIF,t_hemodialisa_tarif.USER_KASIR,t_hemodialisa_tarif.USER_DIAGNOSA,
			t_hemodialisa.NO_SJP,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
			DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_MASUK,
			m_pegawai2.NAMA_PEGAWAI AS NAMA_PELAKSANA
			FROM t_hemodialisa 
			INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
			LEFT JOIN t_irja ON (t_hemodialisa.RAWAT_ID = t_irja.IRJA_ID)
			LEFT JOIN m_jaminan ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_jaminan m_jaminan2 ON (t_hemodialisa_tarif.JENIS_BAYAR_ID = m_jaminan2.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_hemodialisa.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_hemodialisa.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_ruang ON (t_hemodialisa.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_hemodialisa.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (t_hemodialisa.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (t_hemodialisa.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
			AND t_hemodialisa.JNS_ORDER = "' . strtoupper($xord) . '"
			AND t_hemodialisa_tarif.NO_TARIF = "' . $nomor . '"';
						
		$q = mysql_query($sql);
		while ($r = mysql_fetch_array($q)) {
			$ret[] = array('PENUNJANG_ID' => $r['HEMODIALISA_ID'],
				'NOMR' => $r['NOMR'],
				'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
				'NAMA_UNIT' => $r['NAMA_UNIT'],
				'NAMA_PENUNJANG' => 'Hemodialisa',
				'NAMA_PASIEN' => $r['NAMA_PASIEN'],
				'JNS_KELAMIN' => $r['JNS_KELAMIN'],
				'NAMA_IBU' => $r['NAMA_IBU'],
				'TGL_LAHIR' => $r['TGL_LAHIR'],
				'TGL_LAHIR_2' => $r['TGL_LAHIR_2'],
				'ALAMAT' => $r['ALAMAT'],
				'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
				'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
				'NO_TARIF' => $r['NO_TARIF'],
				'NO_SJP' => $r['NO_SJP'],
				'USER_KASIR' => $r['USER_KASIR'],
				'USER_PENDAFTARAN' => $r['USER_DIAGNOSA'],
				'NAMA_KELURAHAN' => $r['NAMA_KELURAHAN'],
				'NAMA_KECAMATAN' => $r['NAMA_KECAMATAN'],
				'NAMA_PELAKSANA' => $r['NAMA_PELAKSANA'],
				'TANGGAL_MASUK' => $r['TANGGAL_MASUK']
			);
		}
	}	
    return $ret;
}

$server->register('getPembayaranPenunjang');

function getPembayaranPenunjang($idx,$nomor,$ord) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	
	if($ord != 'hirj' and $ord != 'hirn'){
		$sql = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.TARIF_ID,
				m_tarif.KODE_TARIF,CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
				m_tarif_group.NAMA_SKT,
				m_tarif.SATUAN,	m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS AS TX,
				COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
				COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
				m_tarif_group.KODE_TARIF_GROUP
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)';
				if($ord == 'aps'){
					$sql = $sql . ' WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
				}else{
					$sql = $sql . ' WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"';
				}	
				$sql = $sql . ' AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"
							AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
				GROUP BY t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.KODE_TARIF';
	
		
		$q = mysql_query($sql);
		while ($r = mysql_fetch_array($q)) {
			$ret[] = array('PENUNJANG_ID' => $r['PENUNJANG_ID'],
				'TARIF_ID' => $r['TARIF_ID'],
				'KODE_TARIF' => $r['KODE_TARIF'],
				'NAMA_TARIF' => $r['NAMA_TARIF'],
				'KUANTITI' => $r['KUANTITI'],
				'SATUAN' => $r['SATUAN'],
				'TARIF_NON_KELAS' => $r['TARIF_NON_KELAS'],
				'NAMA_TARIF_GROUP' => $r['NAMA_SKT']
			);
		}
	}else{
		$xord = strtoupper(str_replace('h','',$ord));
		$sql = 'SELECT DISTINCT t_hemodialisa_tarif.HEMODIALISA_ID,t_hemodialisa_tarif.TARIF_ID,
				m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif_group.NAMA_SKT,
				m_tarif.SATUAN,	m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS AS TX,
				COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) AS KUANTITI,
				COUNT(DISTINCT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
				m_tarif_group.KODE_TARIF_GROUP
				FROM t_hemodialisa
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
				AND t_hemodialisa.JNS_ORDER = "' . strtoupper($xord) . '"
				AND t_hemodialisa_tarif.NO_TARIF = "' . $nomor . '"
				GROUP BY t_hemodialisa_tarif.HEMODIALISA_ID,t_hemodialisa_tarif.TARIF_ID,m_tarif.KODE_TARIF';
		$q = mysql_query($sql);
		while ($r = mysql_fetch_array($q)) {
			$ret[] = array('PENUNJANG_ID' => $r['HEMODIALISA_ID'],
				'TARIF_ID' => $r['TARIF_ID'],
				'KODE_TARIF' => $r['KODE_TARIF'],
				'NAMA_TARIF' => $r['NAMA_TARIF'],
				'KUANTITI' => $r['KUANTITI'],
				'SATUAN' => $r['SATUAN'],
				'TARIF_NON_KELAS' => $r['TARIF_NON_KELAS'],
				'NAMA_TARIF_GROUP' => $r['NAMA_SKT']
			);
		}
	}				
			
    return $ret;
}	

$server->register('getLaboratorium');

function getLaboratorium($idx,$nomor,$ord,$form) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    
	if($ord == 'aps'){
		$sql = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
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
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_ipenunjang.ALAMAT_RT,t_ipenunjang.ALAMAT_RW,
			t_ipenunjang.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (t_ipenunjang.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';
	}else if($ord == 'irj'){
		$sql = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
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
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "IRJ"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';	
	}else if($ord == 'irn'){
		$sql = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,t_ipenunjang.NOMR,
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
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "IRN"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';	
	}else if($ord == 'hrj'){
		$sql = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,
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
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			t_irja.ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang
			INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)	
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "HRJ"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';	
	}else if($ord == 'hri'){
		$sql = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,t_ipenunjang.NOMR,
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
			m_jaminan.NAMA_JAMINAN,t_ipenunjang_tarif.NO_PENUNJANG,t_ipenunjang_tarif.USER_DIAGNOSA,t_ipenunjang_tarif.USER_PERIKSA,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DIAGNOSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_DIAGNOSA,t_ipenunjang_tarif.NO_TP,
			m_pegawai.NAMA_PEGAWAI,m_pegawai3.NAMA_PEGAWAI AS DOKTER_PENANGGUNGJAWAB,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d-%m-%Y %H:%i:%s") AS TANGGAL_SAMPLING,
			DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d-%m-%Y %H:%i:%s") AS TANGGAL_HASIL,
			t_ipenunjang_tarif.CATATAN_SPESIMEN,
			m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
			m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
			"" AS ST_BARU,
			DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d-%m-%Y %H:%i:%s") AS TANGGAL_ORDER
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			INNER JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai3 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai3.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
			LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
			WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
			AND t_ipenunjang.JNS_ORDER = "HRI"
			AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
			ORDER BY t_ipenunjang_tarif.TANGGAL_DIAGNOSA';			
	}
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
		$tgl_daftar = $r['TANGGAL_DAFTAR'];
		$tgl_lahir = $r['TGL_LAHIR'];
		
		
        $ret[] = array('PENUNJANG_ID' => $r['PENUNJANG_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
			'NAMA_UNIT' => $r['NAMA_UNIT'],
			'DOKTER_PENGIRIM' => $r['DOKTER_PENGIRIM'],
            'NAMA_PASIEN' => $r['NAMA_PASIEN'],
			'JNS_KELAMIN' => $r['JNS_KELAMIN'],
			'NAMA_IBU' => $r['NAMA_IBU'],
			'TGL_LAHIR' => $r['TGL_LAHIR'],
			'TGL_LAHIR_2' => $r['TGL_LAHIR_2'],
			'ALAMAT' => trim($r['ALAMAT']) . ' ' . trim($r['ALAMAT_RT']) . '/' . trim($r['ALAMAT_RW']) . ' ' . trim($r['NAMA_KELURAHAN']) . ' ' . trim($r['NAMA_KECAMATAN']),
			'NO_TELEPON' => $r['NO_TELEPON'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PENUNJANG' => $r['NO_PENUNJANG'],
			'NO_TP' => $r['NO_TP'],
			'TANGGAL_DIAGNOSA' => $r['TANGGAL_DIAGNOSA'],
			'USER_PERIKSA' => $r['USER_PERIKSA'],
			'USER_DIAGNOSA' => $r['USER_DIAGNOSA'],
			'TANGGAL_SAMPLING' => $r['TANGGAL_SAMPLING'],
			'TANGGAL_HASIL' => $r['TANGGAL_HASIL'],
			'DOKTER_PENANGGUNGJAWAB' => $r['DOKTER_PENANGGUNGJAWAB'],
			'CATATAN_SPESIMEN' => $r['CATATAN_SPESIMEN'],
			'ST_BARU' => $r['ST_BARU'],
			'UMUR' => getUmurDaftar($tgl_lahir,$tgl_daftar),
			'TANGGAL_ORDER' => $r['TANGGAL_ORDER']
        );
    }
    return $ret;
}

$server->register('getLaboratoriumPeriksa');

function getLaboratoriumPeriksa($idx,$nomor,$ord,$form) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	if($ord != 'aps'){
    $sql = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%H") AS JAM_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%i") AS MENIT_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%H") AS JAM_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%i") AS MENIT_PERIKSA,
					t_ipenunjang_tarif.CATATAN_SPESIMEN,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					m_pegawai2.NAMA_PEGAWAI AS NAMA_PENANGGUNGJAWAB
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"	
					AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"	
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
					OR m_tarif.UNIT_ID = "45")
					AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
					ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
	}else{
	$sql = 'SELECT DISTINCT m_tarif_pemeriksaan.CH_REPORT,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%d/%m/%Y") AS TANGGAL_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%H") AS JAM_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_SAMPLING,"%i") AS MENIT_SAMPLING,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%d/%m/%Y") AS TANGGAL_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%H") AS JAM_PERIKSA,
					DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_PERIKSA,"%i") AS MENIT_PERIKSA,
					t_ipenunjang_tarif.CATATAN_SPESIMEN,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					m_pegawai2.NAMA_PEGAWAI AS NAMA_PENANGGUNGJAWAB
					FROM t_ipenunjang
					INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID = m_pegawai2.PEGAWAI_ID)
					WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"
					AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"		
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
					OR m_tarif.UNIT_ID = "45")
					AND m_tarif_pemeriksaan.FORM_HASIL = "' . $form . '"
					ORDER BY m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID';
	}
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('CH_REPORT' => $r['CH_REPORT'],
            'TANGGAL_SAMPLING' => $r['TANGGAL_SAMPLING'],
            'JAM_SAMPLING' => $r['JAM_SAMPLING'],
			'MENIT_SAMPLING' => $r['MENIT_SAMPLING'],
            'TANGGAL_PERIKSA' => $r['TANGGAL_PERIKSA'],
			'JAM_PERIKSA' => $r['JAM_PERIKSA'],
			'MENIT_PERIKSA' => $r['MENIT_PERIKSA'],
			'CATATAN_SPESIMEN' => $r['CATATAN_SPESIMEN'],
			'NAMA_PEMERIKSA' => $r['NAMA_PEMERIKSA'],
			'NAMA_PENANGGUNGJAWAB' => $r['NAMA_PENANGGUNGJAWAB']
        );
    }
    return $ret;
}

$server->register('getLaboratoriumPeriksaDetail');

function getLaboratoriumPeriksaDetail($idx,$nomor,$ord,$report) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	if($ord != 'aps'){
    $sql = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.METHODE,t_ipenunjang_tarif_pemeriksaan.SATUAN
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '" 
				AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"	
				AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
				AND m_tarif_pemeriksaan.CH_REPORT = "' . $report . '"
				ORDER BY m_tarif_pemeriksaan.REPORT_ORDER';
	}else{
	$sql = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID,m_tarif_pemeriksaan.CH_LEVEL,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_GROUP,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN,m_tarif_pemeriksaan.REPORT_FORMAT,
				m_tarif_pemeriksaan.REPORT_ORDER,t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_PEMERIKSAAN_ID,
				t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT,t_ipenunjang_tarif_pemeriksaan.NILAI_RUJUKAN,
				t_ipenunjang_tarif_pemeriksaan.METHODE,t_ipenunjang_tarif_pemeriksaan.SATUAN
				FROM t_ipenunjang_tarif
				INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN t_ipenunjang_tarif_pemeriksaan ON (m_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID = t_ipenunjang_tarif_pemeriksaan.TARIF_PEMERIKSAAN_ID 
				AND t_ipenunjang_tarif_pemeriksaan.PENUNJANG_TARIF_ID = 
				t_ipenunjang_tarif.PENUNJANG_TARIF_ID)
				WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '" AND t_ipenunjang_tarif.NO_TARIF = "' . $nomor . '"
				AND m_tarif_pemeriksaan.CH_REPORT = "' . $report . '"
				ORDER BY m_tarif_pemeriksaan.REPORT_ORDER';
	}
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
		$rujukan = $r['NILAI_RUJUKAN'];
		$rujukan_2 = $r['NILAI_RUJUKAN'];
		$rujukan_array = explode('|',$r['NILAI_RUJUKAN']);
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
		
        $ret[] = array('CH_LEVEL' => $r['CH_LEVEL'],
            'NAMA_PEMERIKSAAN_GROUP' => $r['NAMA_PEMERIKSAAN_GROUP'],
            'NAMA_PEMERIKSAAN' => $r['NAMA_PEMERIKSAAN'],
			'REPORT_FORMAT' => $r['REPORT_FORMAT'],
            'SATUAN' => $r['SATUAN'],
			'METHODE' => $r['METHODE'],
			'NILAI_RUJUKAN' => $rujukan,
			'NILAI_RUJUKAN_2' => $rujukan_2,
			'HASIL_DIAGNOSA' => $r['HASIL_DIAGNOSA'],
			'CH_REPORT' => $r['CH_REPORT'],
			'CH_LEVEL' => $r['CH_LEVEL']
        );
    }
    return $ret;
}

$server->register('getSepIrja');

function getSepIrja($idx) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT t_irja.IRJA_ID,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			t_irja.NO_SEP,t_irja.NO_PESERTA,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
			END AS JNS_KELAMIN,
			m_unit.NAMA_UNIT,t_irja.JKN_DIAGNOSA,t_irja.JKN_CATATAN,t_irja.JKN_NAMA_PKK,t_irja.JKN_PBI_NONPBI,
			t_irja.JKN_KELAS_RAWAT
			FROM t_irja
			INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			WHERE t_irja.IRJA_ID = "' . $idx . '"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRJA_ID' => $r['IRJA_ID'],
            'TGL_SEP' => $r['TANGGAL_DAFTAR'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NAMA_PASIEN' => $r['NAMA_PASIEN'],
			'TGL_LAHIR' => $r['TGL_LAHIR'],
			'JNS_KELAMIN' => $r['JNS_KELAMIN'],
			'NAMA_UNIT' => $r['NAMA_UNIT'],
			'JKN_DIAGNOSA' => $r['JKN_DIAGNOSA'],
			'JKN_CATATAN' => $r['JKN_CATATAN'],
			'JKN_NAMA_PKK' => $r['JKN_NAMA_PKK'],
			'JKN_PBI_NONPBI' => $r['JKN_PBI_NONPBI'],
			'JKN_KELAS_RAWAT' => '3'
        );
    }
    return $ret;
}

$server->register('getSepIrna');

function getSepIrna($idx) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT t_irna.IRNA_ID,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			t_irna.NO_SEP,t_irna.NO_PESERTA,m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
			CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan"
			END AS JNS_KELAMIN,
			m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
			t_irna.JKN_DIAGNOSA,t_irna.JKN_CATATAN,t_irna.JKN_NAMA_PKK,t_irna.JKN_PBI_NONPBI,
			t_irna.JKN_KELAS_RAWAT,
			DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR_IRJA
			FROM t_irna
			INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
			INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
			INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
			WHERE t_irna.IRNA_ID = "' . $idx . '"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRNA_ID' => $r['IRNA_ID'],
            'TGL_SEP' => $r['TANGGAL_DAFTAR_IRJA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NAMA_PASIEN' => $r['NAMA_PASIEN'],
			'TGL_LAHIR' => $r['TGL_LAHIR'],
			'JNS_KELAMIN' => $r['JNS_KELAMIN'],
			'NAMA_RUANG' => $r['NAMA_RUANG'],
			'KELAS_RAWAT' => $r['JKN_KELAS_RAWAT'],
			'JKN_DIAGNOSA' => $r['JKN_DIAGNOSA'],
			'JKN_CATATAN' => $r['JKN_CATATAN'],
			'JKN_NAMA_PKK' => $r['JKN_NAMA_PKK'],
			'JKN_PBI_NONPBI' => $r['JKN_PBI_NONPBI'],
			'JKN_KELAS_RAWAT' => $r['JKN_KELAS_RAWAT']
        );
    }
    return $ret;
}

$server->register('getSepPenunjang');

function getSepPenunjang($idx,$no) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT "1" AS JNS,t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
					m_unit.NAMA_UNIT,t_ipenunjang_tarif.NO_SJP,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					t_ipenunjang_tarif.ST_PERIKSA AS ST_PERIKSA,
					t_ipenunjang_tarif.NO_SEP,t_ipenunjang_tarif.TANGGAL_SEP,
					m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan" END AS JNS_KELAMIN,
					t_ipenunjang_tarif.NO_PESERTA,t_ipenunjang_tarif.JKN_DIAGNOSA,t_ipenunjang_tarif.JKN_CATATAN,t_ipenunjang_tarif.JKN_NAMA_PKK,
					t_ipenunjang_tarif.JKN_PBI_NONPBI	
					FROM t_ipenunjang_tarif 
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang_tarif.NO_TARIF = "' . $no . '"
					AND t_ipenunjang.JNS_ORDER = "IRJ"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('TGL_SEP' => $r['TANGGAL_SEP'],
			'NO_SEP' => $r['NO_SEP'],
			'NAMA_PASIEN' => $r['NAMA_PASIEN'],
			'TGL_LAHIR' => $r['TGL_LAHIR'],
			'JNS_KELAMIN' => $r['JNS_KELAMIN'],
			'NAMA_UNIT' => $r['NAMA_UNIT'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'JKN_DIAGNOSA' => $r['JKN_DIAGNOSA'],
			'JKN_CATATAN' => $r['JKN_CATATAN'],
			'JKN_NAMA_PKK' => $r['JKN_NAMA_PKK'],
			'JKN_PBI_NONPBI' => $r['JKN_PBI_NONPBI'],
			'JKN_KELAS_RAWAT' => '3'
        );
    }
    return $ret;
}

$server->register('getPenunjangEdit');

function getPenunjangEdit($idx,$nomor,$ord) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID,t_ipenunjang.NOMR,DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NO_PASIEN_PENUNJANG ELSE m_pasien.NOMR END AS NOMR,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NAMA_PASIEN ELSE m_pasien.NAMA_PASIEN END AS NAMA_PASIEN,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.JNS_KELAMIN ELSE m_pasien.JNS_KELAMIN END AS JNS_KELAMIN,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.NAMA_IBU ELSE m_pasien.NAMA_IBU END AS NAMA_IBU,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN DATE_FORMAT(t_ipenunjang.TGL_LAHIR,"%d/%m/%Y") ELSE DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") END AS TGL_LAHIR,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.TGL_LAHIR ELSE m_pasien.TGL_LAHIR END AS TGL_LAHIR_2,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.ALAMAT ELSE m_pasien.ALAMAT END AS ALAMAT,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.PENGIRIM ELSE m_pegawai.NAMA_PEGAWAI END AS NAMA_PEGAWAI,
			CASE WHEN t_ipenunjang.JNS_ORDER = "APS" THEN t_ipenunjang.INSTANSI_PENGIRIM 
			 WHEN t_ipenunjang.JNS_ORDER = "IRJ" THEN m_unit.NAMA_UNIT 
			 WHEN t_ipenunjang.JNS_ORDER = "IRN" THEN CONCAT(m_ruang.NAMA_RUANG," Kelas ",m_ruang.KELAS_RAWAT) END AS NAMA_UNIT,
			CASE WHEN m_jaminan2.NAMA_JAMINAN IS NOT NULL THEN m_jaminan2.NAMA_JAMINAN
			ELSE m_jaminan.NAMA_JAMINAN END AS NAMA_JAMINAN,
			t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.USER_KASIR,t_ipenunjang_tarif.USER_PENDAFTARAN,
			m_unit2.NAMA_UNIT AS NAMA_PENUNJANG,t_ipenunjang_tarif.NO_SJP,m_kelurahan.NAMA_KELURAHAN,m_kecamatan.NAMA_KECAMATAN,
			m_pegawai2.NAMA_PEGAWAI AS NAMA_PELAKSANA,
			DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d-%m-%Y") AS TANGGAL_MASUK
			FROM t_ipenunjang 
			INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
			LEFT JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
			LEFT JOIN m_jaminan ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_jaminan m_jaminan2 ON (t_ipenunjang_tarif.JENIS_BAYAR_ID = m_jaminan2.JAMINAN_ID)
			LEFT JOIN m_pasien ON (t_ipenunjang.NOMR = m_pasien.NOMR)
			LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
			LEFT JOIN m_unit m_unit2 ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit2.UNIT_ID)
			LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
			LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai2 ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai2.PEGAWAI_ID)
			LEFT JOIN m_kelurahan ON (t_ipenunjang.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
			LEFT JOIN m_kecamatan ON (t_ipenunjang.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)';
			if($ord == 'aps'){
				$sql = $sql . ' WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
			}else{
				$sql = $sql . ' WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"';
			}	
			$sql = $sql . ' AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"
							AND t_ipenunjang_tarif.NO_SJP = "' . $nomor . '"';
						
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('PENUNJANG_ID' => $r['PENUNJANG_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
			'NAMA_UNIT' => $r['NAMA_UNIT'],
			'NAMA_PENUNJANG' => $r['NAMA_PENUNJANG'],
            'NAMA_PASIEN' => $r['NAMA_PASIEN'],
			'JNS_KELAMIN' => $r['JNS_KELAMIN'],
			'NAMA_IBU' => $r['NAMA_IBU'],
			'TGL_LAHIR' => $r['TGL_LAHIR'],
			'TGL_LAHIR_2' => $r['TGL_LAHIR_2'],
			'ALAMAT' => $r['ALAMAT'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_TARIF' => $r['NO_TARIF'],
			'NO_SJP' => $r['NO_SJP'],
			'USER_KASIR' => $r['USER_KASIR'],
			'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN'],
			'NAMA_KELURAHAN' => $r['NAMA_KELURAHAN'],
			'NAMA_KECAMATAN' => $r['NAMA_KECAMATAN'],
			'NAMA_PELAKSANA' => $r['NAMA_PELAKSANA'],
			'TANGGAL_MASUK' => $r['TANGGAL_MASUK']
        );
    }
    return $ret;
}

$server->register('getPembayaranPenunjangEdit');

function getPembayaranPenunjangEdit($idx,$nomor,$ord) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
		$sql = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.TARIF_ID,
				m_tarif.KODE_TARIF,CASE WHEN m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				THEN m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER ELSE m_tarif.NAMA_TARIF END AS NAMA_TARIF,
				m_tarif_group.NAMA_SKT,
				m_tarif.SATUAN,	m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS AS TX,
				COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) AS KUANTITI,
				COUNT(DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID) * m_tarif.TARIF_NON_KELAS AS TARIF_NON_KELAS,
				m_tarif_group.KODE_TARIF_GROUP
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)';
				if($ord == 'aps'){
					$sql = $sql . ' WHERE t_ipenunjang.PENUNJANG_ID = "' . $idx . '"';
				}else{
					$sql = $sql . ' WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"';
				}	
				$sql = $sql . ' AND t_ipenunjang.JNS_ORDER = "' . strtoupper($ord) . '"
							AND t_ipenunjang_tarif.NO_SJP = "' . $nomor . '"
				GROUP BY t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.TARIF_ID,m_tarif.KODE_TARIF';
		
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('PENUNJANG_ID' => $r['PENUNJANG_ID'],
            'TARIF_ID' => $r['TARIF_ID'],
            'KODE_TARIF' => $r['KODE_TARIF'],
			'NAMA_TARIF' => $r['NAMA_TARIF'],
			'KUANTITI' => $r['KUANTITI'],
			'SATUAN' => $r['SATUAN'],
			'TARIF_NON_KELAS' => $r['TARIF_NON_KELAS'],
			'NAMA_TARIF_GROUP' => $r['NAMA_SKT']
        );
    }
    return $ret;
}

$server->register('getSepPenunjangEdit');

function getSepPenunjangEdit($idx,$no) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT "1" AS JNS,t_ipenunjang_tarif.PENUNJANG_ID,t_ipenunjang_tarif.UNIT_PENUNJANG_ID,
					m_unit.NAMA_UNIT,t_ipenunjang_tarif.NO_SJP,m_pegawai.NAMA_PEGAWAI AS NAMA_PEMERIKSA,
					t_ipenunjang_tarif.ST_PERIKSA AS ST_PERIKSA,
					t_ipenunjang_tarif.NO_SEP,t_ipenunjang_tarif.TANGGAL_SEP,
					m_pasien.NAMA_PASIEN,DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR,
					CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "Laki-laki" WHEN m_pasien.JNS_KELAMIN = "P" THEN "Perempuan" END AS JNS_KELAMIN,
					t_ipenunjang_tarif.NO_PESERTA,t_ipenunjang_tarif.JKN_DIAGNOSA,t_ipenunjang_tarif.JKN_CATATAN,t_ipenunjang_tarif.JKN_NAMA_PKK,
					t_ipenunjang_tarif.JKN_PBI_NONPBI	
					FROM t_ipenunjang_tarif 
					INNER JOIN m_unit ON (t_ipenunjang_tarif.UNIT_PENUNJANG_ID = m_unit.UNIT_ID)
					INNER JOIN t_ipenunjang ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN t_irja ON (t_ipenunjang.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
					LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
					WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
					AND t_ipenunjang_tarif.NO_SJP = "' . $no . '"
					AND t_ipenunjang.JNS_ORDER = "IRJ"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('TGL_SEP' => $r['TANGGAL_SEP'],
			'NO_SEP' => $r['NO_SEP'],
			'NAMA_PASIEN' => $r['NAMA_PASIEN'],
			'TGL_LAHIR' => $r['TGL_LAHIR'],
			'JNS_KELAMIN' => $r['JNS_KELAMIN'],
			'NAMA_UNIT' => $r['NAMA_UNIT'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'JKN_DIAGNOSA' => $r['JKN_DIAGNOSA'],
			'JKN_CATATAN' => $r['JKN_CATATAN'],
			'JKN_NAMA_PKK' => $r['JKN_NAMA_PKK'],
			'JKN_PBI_NONPBI' => $r['JKN_PBI_NONPBI'],
			'JKN_KELAS_RAWAT' => '3'
        );
    }
    return $ret;
}

$server->register('getIrjaKasirAll');

function getIrjaKasirAll($idx) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	
	$sql = 'SELECT t_irja.IRJA_ID,t_irja.NOMR,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			t_irja.ST_BARU,m_unit.NAMA_UNIT,m_pegawai.NAMA_PEGAWAI,t_irja.MT_RUJUKAN,
			m_jaminan.NAMA_JAMINAN,
			t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,m_asal_pasien.KET_ASAL_PASIEN,t_irja.PASIEN_MASUK,
			t_irja.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irja.NO_PENDAFTARAN,t_irja.SHIFT_ID,t_irja.USER_PENDAFTARAN,
			t_irja_tarif.USER_KASIR
			FROM t_irja 
			INNER JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID)
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
			LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irja.IRJA_ID = "' . $idx . '"';
			
	$q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRJA_ID' => $r['IRJA_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
            'ST_BARU' => $r['ST_BARU'],
            'NAMA_UNIT' => $r['NAMA_UNIT'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'MT_RUJUKAN' => $r['MT_RUJUKAN'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'],
			'KET_ASAL_PASIEN' => $r['KET_ASAL_PASIEN'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'SHIFT_ID' => $r['SHIFT_ID'],
			'USER_PENDAFTARAN' => $r['USER_KASIR']
        );
    }
    return $ret;
}

$server->register('getPembayaranIrjaAll');

function getPembayaranIrjaAll($idx) {
    global $database, $connect;
	global $hostname, $username, $password;
	global $database_3, $connect_3;
	global $hostname_3, $username_3, $password_3;
	
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						CASE WHEN t_irja_tarif.PEGAWAI_ID IS NOT NULL THEN 
						(SELECT m_pegawai.PEGAWAI_ID FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irja_tarif.PEGAWAI_ID) 
						END AS PEGAWAI_ID
						FROM t_irja_tarif
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.IRJA_ID = "' . $idx . '"
						AND t_irja_tarif.NO_TARIF IS NOT NULL
						AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_irja_tarif.ST_BAYAR = "Lunas"
						AND t_irja_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_irja_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}		
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRJ"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "IRJ"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}

	//hemodialisa
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_hemodialisa 
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_hemodialisa_tarif.PEGAWAI_ID
						FROM t_hemodialisa
						INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
						INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_pegawai ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
						AND t_hemodialisa.JNS_ORDER = "IRJ"
						AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
						AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
						AND t_hemodialisa.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_hemodialisa_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "HRJ"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "HRJ"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	//	
				
	$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
    mysql_select_db($database_3, $connect_3) or die(mysql_error());

	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
		WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
		AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
		AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
		AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
			OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
		AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
		AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL
		GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
		m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
		t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
		ORDER BY PERSEDIAAN ASC';	
		
	$q = mysql_query($sql);
	
	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
		WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
		AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
		AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
		AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
			OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
		AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
		AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL
		GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
		m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
		t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
		ORDER BY PERSEDIAAN ASC';	
		
	$qf = mysql_query($sql);

	if((mysql_num_rows($q) > 0) or (mysql_num_rows($qf) > 0)){
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
			
	while ($r = mysql_fetch_array($qf)) {	
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
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						"" AS PEGAWAI_ID
						FROM t_ambulance_tarif
						INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
						AND t_ambulance_tarif.JNS_ORDER = "IRJ"
						AND t_ambulance_tarif.NO_TARIF IS NOT NULL
						AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ambulance_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ambulance_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRJA_ID' => $r2['IRJA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $r2['NAMA_TARIF'],
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF_NON_KELAS' => $r2['TARIF_NON_KELAS'],
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	
    return $ret;
}

$server->register('getIrnaKasirAll');

function getIrnaKasirAll($idx) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	
	$sql = 'SELECT t_irna.IRNA_ID,t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			m_ruang.NAMA_RUANG,m_pegawai.NAMA_PEGAWAI,m_jaminan.NAMA_JAMINAN,t_irna.KELAS_RAWAT,
			t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,t_irna.PASIEN_MASUK,
			t_irna.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irna.NO_PENDAFTARAN,t_irna.SHIFT_ID,t_irna.USER_PENDAFTARAN,
			t_irna_tarif.USER_KASIR
			FROM t_irna 
			INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
			INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
            LEFT JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID)
			LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irna.IRNA_ID = "' . $idx . '"';
			
	$q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('IRNA_ID' => $r['IRNA_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
            'NAMA_RUANG' => $r['NAMA_RUANG'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'SHIFT_ID' => $r['SHIFT_ID'],
			'KELAS_RAWAT' => $r['KELAS_RAWAT'],
			'USER_PENDAFTARAN' => $r['USER_KASIR']
        );
    }
    return $ret;
}

$server->register('getPembayaranIrnaAll');

function getPembayaranIrnaAll($idx) {
    global $database, $connect;
	global $hostname, $username, $password;
	global $database_3, $connect_3;
	global $hostname_3, $username_3, $password_3;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						CASE WHEN t_irna_tarif.PEGAWAI_ID IS NOT NULL THEN 
							(SELECT m_pegawai.PEGAWAI_ID FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irna_tarif.PEGAWAI_ID) 
						END AS PEGAWAI_X,t_irna_tarif.KELAS_RAWAT,t_irna_tarif.JENIS_BAYAR_ID
						FROM t_irna_tarif
						INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irna_tarif.IRNA_ID = "' . $idx . '"
						AND t_irna_tarif.NO_TARIF IS NOT NULL
						AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_irna_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_irna_tarif.TARIF_ID,t_irna_tarif.KELAS_RAWAT,
						t_irna_tarif.JENIS_BAYAR_ID,PEGAWAI_X';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$kelas_rawat = $r2['KELAS_RAWAT'];
					if($r2['KELAS_RAWAT'] == 'BAYI SEHAT') $kelas_rawat = 'PSE'; 
					if($r2['KELAS_RAWAT'] == 'BAYI SAKIT') $kelas_rawat = 'PSA'; 
					if($r2['KELAS_RAWAT'] == 'UTAMA') $kelas_rawat = 'UTM'; 
					if($r2['KELAS_RAWAT'] == 'VIP') $kelas_rawat = 'VIP'; 
					$kelas_rawat  = $kelas_rawat . ',B:' . $r2['JENIS_BAYAR_ID'];
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif = $nama_tarif . ',P:' . $r2['PEGAWAI_X'];
					
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF'],
						'KELAS_RAWAT' => $kelas_rawat,
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
					);
			} 
	}	
		
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,
						t_ipenunjang_tarif.JENIS_BAYAR_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "IRN"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',B:' . $r2['JENIS_BAYAR_ID'];
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
				);
			}
	}	
	
	//operasi
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_operasi_tarif
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						CASE WHEN t_operasi_tarif.PEGAWAI_PELAKSANA_ID IS NOT NULL THEN 
							(SELECT m_pegawai.PEGAWAI_ID FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_operasi_tarif.PEGAWAI_PELAKSANA_ID) 
						END AS PEGAWAI_X,t_operasi_tarif.KELAS_RAWAT,t_operasi_tarif.JENIS_BAYAR_ID
						FROM t_operasi_tarif
						INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
						INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_operasi.RAWAT_ID = "' . $idx . '"
						AND t_operasi_tarif.NO_TARIF IS NOT NULL
						AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_operasi_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_operasi_tarif.TARIF_ID,t_operasi_tarif.KELAS_RAWAT,
						t_operasi_tarif.JENIS_BAYAR_ID,PEGAWAI_X';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$kelas_rawat = $r2['KELAS_RAWAT'];
					if($r2['KELAS_RAWAT'] == 'BAYI SEHAT') $kelas_rawat = 'PSE'; 
					if($r2['KELAS_RAWAT'] == 'BAYI SAKIT') $kelas_rawat = 'PSA'; 
					if($r2['KELAS_RAWAT'] == 'UTAMA') $kelas_rawat = 'UTM'; 
					if($r2['KELAS_RAWAT'] == 'VIP') $kelas_rawat = 'VIP'; 
					$kelas_rawat  = $kelas_rawat . ',B:' . $r2['JENIS_BAYAR_ID'];
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_X'];
				
					$ret[] = array('IRNA_ID' => $r2['OPERASI_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF'],
						'KELAS_RAWAT' => $kelas_rawat,
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
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
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_hemodialisa_tarif.PEGAWAI_ID,t_hemodialisa_tarif.JENIS_BAYAR_ID
						FROM t_hemodialisa
						INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
						INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_pegawai ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
						AND t_hemodialisa.JNS_ORDER = "IRN"
						AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
						AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
						AND t_hemodialisa.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_hemodialisa_tarif.TARIF_ID,t_hemodialisa_tarif.PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',B:' . $r2['JENIS_BAYAR_ID'];
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
				);
			}
	}
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "HRI"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,
						t_ipenunjang_tarif.JENIS_BAYAR_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "HRI"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',B:' . $r2['JENIS_BAYAR_ID'];
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
				);
			}
	}
	//end hemodialisa

	$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
    mysql_select_db($database_3, $connect_3) or die(mysql_error());

	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
			WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
				OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN
			ORDER BY PERSEDIAAN ASC';	
		
	$q = mysql_query($sql);	
	
	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
			WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
				OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN
			ORDER BY PERSEDIAAN ASC';	
		
	$qf = mysql_query($sql);

	if((mysql_num_rows($q) > 0) or (mysql_num_rows($qf) > 0)){
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

				
	while ($r = mysql_fetch_array($qf)) {	
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
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						"" AS PEGAWAI_ID
						FROM t_ambulance_tarif
						INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
						AND t_ambulance_tarif.JNS_ORDER = "IRN"
						AND t_ambulance_tarif.NO_TARIF IS NOT NULL
						AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ambulance_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ambulance_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
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
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	
    return $ret;
}

$server->register('getPembayaranIrnaCs');

function getPembayaranIrnaCs($idx) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '"
				AND t_irna_tarif.NO_TARIF IS NOT NULL
				AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_irna_tarif.ST_BAYAR = "Lunas"
				AND t_irna_tarif.ST_BATAL IS NULL
				AND t_irna_tarif.JENIS_BAYAR_ID <> "1"
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
						m_tarif.TARIF_KELAS_3,
						m_tarif.TARIF_KELAS_2,
						m_tarif.TARIF_KELAS_1,
						m_tarif.TARIF_KELAS_UTAMA,
						m_tarif.TARIF_KELAS_PERINA_SEHAT,
						m_tarif.TARIF_KELAS_PERINA_SAKIT,
						m_tarif.TARIF_HCU,
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						CASE WHEN t_irna_tarif.PEGAWAI_ID IS NOT NULL THEN 
							(SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irna_tarif.PEGAWAI_ID) 
						END AS PEGAWAI_ID,t_irna_tarif.KELAS_RAWAT,t_irna_tarif.JENIS_BAYAR_ID,
						t_irna_tarif.KELAS_JAMINAN,
						m_kelas_rawat.BOBOT AS BOBOT_RAWAT,m_kelas_rawat2.BOBOT AS BOBOT_JAMINAN
						FROM t_irna_tarif
						INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_kelas_rawat ON (t_irna_tarif.KELAS_RAWAT = m_kelas_rawat.KELAS_RAWAT) 
						LEFT JOIN m_kelas_rawat m_kelas_rawat2 ON (t_irna_tarif.KELAS_JAMINAN = m_kelas_rawat2.KELAS_RAWAT)
						WHERE t_irna_tarif.IRNA_ID = "' . $idx . '"
						AND t_irna_tarif.NO_TARIF IS NOT NULL
						AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_irna_tarif.ST_BAYAR = "Lunas"
						AND t_irna_tarif.ST_BATAL IS NULL
						AND t_irna_tarif.JENIS_BAYAR_ID <> "1"
						GROUP BY t_irna_tarif.TARIF_ID,t_irna_tarif.KELAS_RAWAT,t_irna_tarif.KELAS_JAMINAN,
						t_irna_tarif.JENIS_BAYAR_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$kelas_rawat = $r2['KELAS_RAWAT'];
					if($r2['KELAS_RAWAT'] == 'BAYI SEHAT') $kelas_rawat = 'PSE'; 
					if($r2['KELAS_RAWAT'] == 'BAYI SAKIT') $kelas_rawat = 'PSA'; 
					if($r2['KELAS_RAWAT'] == 'UTAMA') $kelas_rawat = 'UTM'; 
					if($r2['KELAS_RAWAT'] == 'VIP') $kelas_rawat = 'VIP'; 
					$kelasrawat  = $kelasrawat . ',B:' . $r2['JENIS_BAYAR_ID'];
					$kelasrawat  = $kelasrawat . ',K:' . $r2['KELAS_JAMINAN'];
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_ID'];
					
					$tarif_cs = 0;
					$tarif_rawat = 0;
					$tarif_jaminan = 0;
					if(strtoupper($r['KELAS_RAWAT']) == '1') $tarif_rawat = $r['TARIF_KELAS_1'];
					if(strtoupper($r['KELAS_RAWAT']) == '2') $tarif_rawat = $r['TARIF_KELAS_2'];
					if(strtoupper($r['KELAS_RAWAT']) == '3') $tarif_rawat = $r['TARIF_KELAS_3'];
					if(strtoupper($r['KELAS_RAWAT']) == 'UTAMA') $tarif_rawat = $r['TARIF_KELAS_UTAMA'];
					if(strtoupper($r['KELAS_RAWAT']) == 'VIP') $tarif_rawat = $r['TARIF_KELAS_UTAMA'];
					if(strtoupper($r['KELAS_RAWAT']) == 'BAYI SEHAT') $tarif_rawat = $r['TARIF_KELAS_PERINA_SEHAT'];
					if(strtoupper($r['KELAS_RAWAT']) == 'BAYI SAKIT') $tarif_rawat = $r['TARIF_KELAS_PERINA_SAKIT'];
					if(strtoupper($r['KELAS_RAWAT']) == 'HCU') $tarif_rawat = $r['TARIF_HCU'];
				
					if(strtoupper($r['KELAS_JAMINAN']) == '1') $tarif_jaminan = $r['TARIF_KELAS_1'];
					if(strtoupper($r['KELAS_JAMINAN']) == '2') $tarif_jaminan = $r['TARIF_KELAS_2'];
					if(strtoupper($r['KELAS_JAMINAN']) == '3') $tarif_jaminan = $r['TARIF_KELAS_3'];
				
					if(!empty($r['KELAS_JAMINAN']) and ($r['BOBOT_RAWAT'] > $r['BOBOT_JAMINAN'])){
						$tarif_cs = ($tarif_rawat * $r['KUANTITI']) - ($tarif_jaminan * $r['KUANTITI']);  
					}
				
					$ret[] = array('IRNA_ID' => $r['IRNA_ID'],
					'TARIF_ID' => $r['TARIF_ID'],
					'KODE_TARIF' => $r['KODE_TARIF'],
					'NAMA_TARIF' => $nama_tarif,
					'KUANTITI' => $r['KUANTITI'],
					'NO_TARIF' => '',
					'DESKRIPSI' => '',
					'SATUAN' => $r['SATUAN'],
					'TARIF' => $tarif_cs,
					'KELAS_RAWAT' => $kelasrawat,
					'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
				);
			}
	}		
	
    return $ret;
}

$server->register('getOperasiKasir');

function getOperasiKasir($idx,$nomor) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    $sql = 'SELECT t_operasi.OPERASI_ID,t_operasi.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			CONCAT(m_ruang.NAMA_RUANG,"/",m_ruang.KELAS_RAWAT) AS NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,t_irna.PASIEN_MASUK,
			t_irna.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irna.NO_PENDAFTARAN,t_operasi_tarif.USER_PENDAFTARAN,
			t_operasi_tarif.USER_KASIR,t_operasi_tarif.KELAS_RAWAT,
			CASE WHEN t_operasi_tarif.PEGAWAI_PELAKSANA_ID IS NULL THEN m_pegawai.NAMA_PEGAWAI ELSE m_pegawai1.NAMA_PEGAWAI END AS NAMA_PEGAWAI
			FROM t_operasi 
			INNER JOIN t_irna ON (t_operasi.RAWAT_ID = t_irna.IRNA_ID)
			INNER JOIN t_operasi_tarif ON (t_operasi.OPERASI_ID = t_operasi_tarif.OPERASI_ID)
			INNER JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai1 ON (t_operasi_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai1.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID) 
			WHERE t_operasi.OPERASI_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF = "' . $nomor . '"
			AND (t_operasi.JNS_ORDER = "IRN" OR t_operasi.ST_MASUK = "2")
			UNION
			SELECT t_operasi.OPERASI_ID,t_operasi.NOMR,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			m_unit.NAMA_UNIT AS NAMA_RUANG,m_jaminan.NAMA_JAMINAN,t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,t_irja.PASIEN_MASUK,
			t_irja.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irja.NO_PENDAFTARAN,
			CASE WHEN t_operasi_tarif.USER_PENDAFTARAN IS NOT NULL 
			THEN t_operasi_tarif.USER_PENDAFTARAN ELSE t_operasi.USER_DAFTAR END AS USER_PENDAFTARAN,
			t_operasi_tarif.USER_KASIR,t_operasi_tarif.KELAS_RAWAT,
			CASE WHEN t_operasi_tarif.PEGAWAI_PELAKSANA_ID IS NULL THEN m_pegawai.NAMA_PEGAWAI ELSE m_pegawai1.NAMA_PEGAWAI END AS NAMA_PEGAWAI
			FROM t_operasi 
			INNER JOIN t_irja ON (t_operasi.RAWAT_ID = t_irja.IRJA_ID)
			INNER JOIN t_operasi_tarif ON (t_operasi.OPERASI_ID = t_operasi_tarif.OPERASI_ID)
			INNER JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_operasi.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pegawai m_pegawai1 ON (t_operasi_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai1.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID) 
			WHERE t_operasi.OPERASI_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF = "' . $nomor . '"
			AND t_operasi.JNS_ORDER = "IRJ" AND t_operasi.ST_MASUK = "1"';
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('OPERASI_ID' => $r['OPERASI_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
            'NAMA_RUANG' => $r['NAMA_RUANG'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN'],
			'USER_KASIR' => $r['USER_KASIR'],
			'KELAS_RAWAT' => $r['KELAS_RAWAT']
        );
    }
    return $ret;
}

$server->register('getPembayaranOperasi');

function getPembayaranOperasi($idx,$nomor) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
		$sql = 'SELECT t_operasi_tarif.OPERASI_ID,t_operasi_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,SUM(t_operasi_tarif.KUANTITI) AS KUANTITI,t_operasi_tarif.NO_TARIF,t_operasi_tarif.DESKRIPSI,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
				CASE WHEN t_operasi_tarif.PEGAWAI_PELAKSANA_ID IS NOT NULL THEN CONCAT(" /",t_operasi_tarif.PEGAWAI_ID) END AS PEGAWAI_ID,
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
				END AS TARIF
				FROM t_operasi_tarif
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi_tarif.OPERASI_ID = "' . $idx . '" AND t_operasi_tarif.NO_TARIF = "' . $nomor . '"
				GROUP BY t_operasi_tarif.OPERASI_ID,t_operasi_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,t_operasi_tarif.NO_TARIF,t_operasi_tarif.DESKRIPSI,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT
				ORDER BY m_tarif.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
		
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
        $ret[] = array('OPERASI_ID' => $r['OPERASI_ID'],
            'TARIF_ID' => $r['TARIF_ID'],
            'KODE_TARIF' => $r['KODE_TARIF'],
			'NAMA_TARIF' => $r['NAMA_TARIF'],
			'KUANTITI' => $r['KUANTITI'],
			'NO_TARIF' => $r['NO_TARIF'],
			'DESKRIPSI' => $r['DESKRIPSI'],
			'SATUAN' => $r['SATUAN'],
			'TARIF' => $r['TARIF'] * $r['KUANTITI'],
			'NAMA_TARIF_GROUP' => $r['PEGAWAI_ID'] . $r['NAMA_SKT']
        );
    }
    return $ret;
}

$server->register('getPembayaranAll');

function getPembayaranAll($idx) {
    global $database, $connect;
	global $hostname, $username, $password;
	global $database_3, $connect_3;
	global $hostname_3, $username_3, $password_3;
	
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irja_tarif.IRJA_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						CASE WHEN t_irja_tarif.PEGAWAI_ID IS NOT NULL THEN 
						(SELECT m_pegawai.PEGAWAI_ID FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irja_tarif.PEGAWAI_ID) 
						END AS PEGAWAI_ID
						FROM t_irja_tarif
						INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irja_tarif.IRJA_ID = "' . $idx . '"
						AND t_irja_tarif.NO_TARIF IS NOT NULL
						AND t_irja_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_irja_tarif.ST_BAYAR = "Lunas"
						AND t_irja_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_irja_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
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
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}		
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRJ"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "IRJ"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
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
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}

	//hemodialisa
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_hemodialisa 
				INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_hemodialisa_tarif.PEGAWAI_ID
						FROM t_hemodialisa
						INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
						INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_pegawai ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
						AND t_hemodialisa.JNS_ORDER = "IRJ"
						AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
						AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
						AND t_hemodialisa.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_hemodialisa_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
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
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "HRJ"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "HRJ"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
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
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	//	
				
	$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
    mysql_select_db($database_3, $connect_3) or die(mysql_error());

	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
		WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
		AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
		AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
		AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
			OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
		AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
		AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL
		GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
		m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
		t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
		ORDER BY PERSEDIAAN ASC';	
		
	$q = mysql_query($sql);		

	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
		WHERE t_rajal_resep.RAJAL_ID = "' . $idx . '"
		AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
		AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
		AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
			OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
		AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
		AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL
		GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
		m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
		t_rajal_resep_detail.RACIKAN,t_rajal_resep_detail.NAMA_RACIKAN
		ORDER BY PERSEDIAAN ASC';	
		
	$qf = mysql_query($sql);	

	if((mysql_num_rows($q) > 0) or (mysql_num_rows($qf) > 0)){
		$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => 'FARMASI-IRJ',
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
					'KODE_TARIF' => 'PERSEDIAAN_ID',
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

		
	while ($r = mysql_fetch_array($qf)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => 'PERSEDIAAN_ID',
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
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						"" AS PEGAWAI_ID
						FROM t_ambulance_tarif
						INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
						AND t_ambulance_tarif.JNS_ORDER = "IRJ"
						AND t_ambulance_tarif.NO_TARIF IS NOT NULL
						AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ambulance_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ambulance_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
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
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	
	//end rawat jalan
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_irna_tarif.IRNA_ID = "' . $idx . '"
				AND t_irna_tarif.NO_TARIF IS NOT NULL
				AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_irna_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
	$q = mysql_query($sql);			
	while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRI',
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						CASE WHEN t_irna_tarif.PEGAWAI_ID IS NOT NULL THEN 
							(SELECT m_pegawai.PEGAWAI_ID FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_irna_tarif.PEGAWAI_ID) 
						END AS PEGAWAI_X,t_irna_tarif.KELAS_RAWAT,t_irna_tarif.JENIS_BAYAR_ID
						FROM t_irna_tarif
						INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_irna_tarif.IRNA_ID = "' . $idx . '"
						AND t_irna_tarif.NO_TARIF IS NOT NULL
						AND t_irna_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_irna_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_irna_tarif.TARIF_ID,t_irna_tarif.KELAS_RAWAT,
						t_irna_tarif.JENIS_BAYAR_ID,PEGAWAI_X';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$kelas_rawat = $r2['KELAS_RAWAT'];
					if($r2['KELAS_RAWAT'] == 'BAYI SEHAT') $kelas_rawat = 'PSE'; 
					if($r2['KELAS_RAWAT'] == 'BAYI SAKIT') $kelas_rawat = 'PSA'; 
					if($r2['KELAS_RAWAT'] == 'UTAMA') $kelas_rawat = 'UTM'; 
					if($r2['KELAS_RAWAT'] == 'VIP') $kelas_rawat = 'VIP'; 
					$kelas_rawat  = $kelas_rawat . ',B:' . $r2['JENIS_BAYAR_ID'];
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif = $nama_tarif . ',P:' . $r2['PEGAWAI_X'];
					
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF'],
						'KELAS_RAWAT' => $kelas_rawat,
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
					);
			} 
	}	
		
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "IRN"
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
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRI',
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,
						t_ipenunjang_tarif.JENIS_BAYAR_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "IRN"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',B:' . $r2['JENIS_BAYAR_ID'];
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
				);
			}
	}	
	
	//operasi
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_operasi_tarif
				INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_operasi.RAWAT_ID = "' . $idx . '"
				AND t_operasi_tarif.NO_TARIF IS NOT NULL
				AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
				AND t_operasi_tarif.ST_BAYAR = "Lunas"
				ORDER BY m_tarif_group.KODE_TARIF_GROUP';
	$q = mysql_query($sql);			
	while ($r = mysql_fetch_array($q)) {	
			$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRI',
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						CASE WHEN t_operasi_tarif.PEGAWAI_PELAKSANA_ID IS NOT NULL THEN 
							(SELECT m_pegawai.PEGAWAI_ID FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_operasi_tarif.PEGAWAI_PELAKSANA_ID) 
						END AS PEGAWAI_X,t_operasi_tarif.KELAS_RAWAT,t_operasi_tarif.JENIS_BAYAR_ID
						FROM t_operasi_tarif
						INNER JOIN t_operasi ON (t_operasi_tarif.OPERASI_ID = t_operasi.OPERASI_ID)
						INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_operasi.RAWAT_ID = "' . $idx . '"
						AND t_operasi_tarif.NO_TARIF IS NOT NULL
						AND t_operasi_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_operasi_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_operasi_tarif.TARIF_ID,t_operasi_tarif.KELAS_RAWAT,
						t_operasi_tarif.JENIS_BAYAR_ID,PEGAWAI_X';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$kelas_rawat = $r2['KELAS_RAWAT'];
					if($r2['KELAS_RAWAT'] == 'BAYI SEHAT') $kelas_rawat = 'PSE'; 
					if($r2['KELAS_RAWAT'] == 'BAYI SAKIT') $kelas_rawat = 'PSA'; 
					if($r2['KELAS_RAWAT'] == 'UTAMA') $kelas_rawat = 'UTM'; 
					if($r2['KELAS_RAWAT'] == 'VIP') $kelas_rawat = 'VIP'; 
					$kelas_rawat  = $kelas_rawat . ',B:' . $r2['JENIS_BAYAR_ID'];
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_X'];
				
					$ret[] = array('IRNA_ID' => $r2['OPERASI_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF'],
						'KELAS_RAWAT' => $kelas_rawat,
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
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
				WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
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
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRI',
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_hemodialisa_tarif.PEGAWAI_ID,t_hemodialisa_tarif.JENIS_BAYAR_ID
						FROM t_hemodialisa
						INNER JOIN t_hemodialisa_tarif ON (t_hemodialisa.HEMODIALISA_ID = t_hemodialisa_tarif.HEMODIALISA_ID)
						INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_pegawai ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_hemodialisa.RAWAT_ID = "' . $idx . '"
						AND t_hemodialisa.JNS_ORDER = "IRN"
						AND t_hemodialisa_tarif.NO_TARIF IS NOT NULL
						AND t_hemodialisa_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_hemodialisa_tarif.ST_BAYAR = "Lunas"
						AND t_hemodialisa.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_hemodialisa_tarif.TARIF_ID,t_hemodialisa_tarif.PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',B:' . $r2['JENIS_BAYAR_ID'];
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
				);
			}
	}
	
	$sql = 'SELECT DISTINCT m_tarif_group.NAMA_TARIF_GROUP_PRINT
				FROM t_ipenunjang 
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
				AND t_ipenunjang.JNS_ORDER = "HRI"
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
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT'] . '-IRI',
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID AS PEGAWAI_ID,
						t_ipenunjang_tarif.JENIS_BAYAR_ID
						FROM t_ipenunjang
						INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
						INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						LEFT JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
						LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
						WHERE t_ipenunjang.RAWAT_ID = "' . $idx . '"
						AND t_ipenunjang.JNS_ORDER = "HRI"
						AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
						AND t_ipenunjang_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ipenunjang_tarif.ST_BAYAR = "Lunas"
						AND t_ipenunjang_tarif.ST_BATAL IS NULL
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ipenunjang_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) { 
					
					$nama_tarif = $r2['NAMA_TARIF']; 
					$nama_tarif  = $nama_tarif . ',B:' . $r2['JENIS_BAYAR_ID'];
					$nama_tarif  = $nama_tarif . ',P:' . $r2['PEGAWAI_ID'];
				
					$ret[] = array('IRNA_ID' => $r2['IRNA_ID'],
						'TARIF_ID' => $r2['TARIF_ID'],
						'KODE_TARIF' => $r2['KODE_TARIF'],
						'NAMA_TARIF' => $nama_tarif,
						'KUANTITI' => $r2['KUANTITI'],
						'NO_TARIF' => '',
						'DESKRIPSI' => '',
						'SATUAN' => $r2['SATUAN'],
						'TARIF' => $r2['TARIF_NON_KELAS'],
						'KELAS_RAWAT' => '',
						'NAMA_TARIF_GROUP' => $r2['NAMA_SKT']
				);
			}
	}
	//end hemodialisa

	$connect_3= mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
    mysql_select_db($database_3, $connect_3) or die(mysql_error());

	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
			WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
				OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN
			ORDER BY PERSEDIAAN ASC';	
		
	$q = mysql_query($sql);			
	
	$sql = 'SELECT t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
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
			WHERE t_ranap_resep.RANAP_ID = "' . $idx . '"
			AND t_farmasi_apotik_pengeluaran_detail.JUMLAH_KELUAR > 0
			AND t_farmasi_apotik_pengeluaran.NO_PENGELUARAN IS NOT NULL
			AND ((t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NOT NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID = "1") 
				OR (t_farmasi_apotik_pengeluaran.NO_PEMBAYARAN IS NULL AND t_farmasi_apotik_pengeluaran.JAMINAN_ID != "1"))
			AND t_farmasi_apotik_pengeluaran.ST_BATAL IS NULL
			AND t_farmasi_apotik_pengeluaran.HEMODIALISA_ID IS NOT NULL
			GROUP BY t_farmasi_apotik_pengeluaran_detail.PERSEDIAAN_ID,t_farmasi_apotik_pengeluaran_detail.HARGA_JUAL,
			m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.SATUAN,
			t_ranap_resep_detail.RACIKAN,t_ranap_resep_detail.NAMA_RACIKAN
			ORDER BY PERSEDIAAN ASC';	
		
	$qf = mysql_query($sql);
	
	if((mysql_num_rows($q) > 0) or (mysql_num_rows($qf) > 0)){
		$ret[] = array('IRNA_ID' => '',
					'TARIF_ID' => '',
					'KODE_TARIF' => '',
					'NAMA_TARIF' => 'FARMASI-IRI',
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
			
	while ($r = mysql_fetch_array($qf)) {	
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
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
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
					'NAMA_TARIF' => $r['NAMA_TARIF_GROUP_PRINT']. '-IRI',
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
						m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,
						"" AS PEGAWAI_ID
						FROM t_ambulance_tarif
						INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
						INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
						WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '"
						AND t_ambulance_tarif.JNS_ORDER = "IRN"
						AND t_ambulance_tarif.NO_TARIF IS NOT NULL
						AND t_ambulance_tarif.NO_PEMBAYARAN IS NOT NULL
						AND t_ambulance_tarif.ST_BAYAR = "Lunas"
						AND m_tarif_group.NAMA_TARIF_GROUP_PRINT = "' . $r['NAMA_TARIF_GROUP_PRINT'] . '"
						GROUP BY t_ambulance_tarif.TARIF_ID,PEGAWAI_ID';
				
				$q2 = mysql_query($sql2);
				while ($r2 = mysql_fetch_array($q2)) {
				
					$nama_tarif = $r2['NAMA_SKT'];
					if(!empty($r2['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r2['PEGAWAI_ID'];
				
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
						'NAMA_TARIF_GROUP' => $nama_tarif
				);
			}
	}
	
    return $ret;
}

$server->register('getAmbulance');

function getAmbulance($idx,$nomor,$ord) {
	global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
    
	if($ord == 'irj'){
	
		$sql = 'SELECT t_irja.IRJA_ID AS RAWAT_ID,t_irja.NOMR,DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			t_irja.ST_BARU,(SELECT x.NO_POLISI FROM t_ambulance_tarif x WHERE x.RAWAT_ID = "' . $idx . '"
			AND x.JNS_ORDER = "' . strtoupper($ord) . '" AND x.NO_TARIF = "' . $nomor . '"
			LIMIT 1) AS NAMA_UNIT,(SELECT m.NAMA_PEGAWAI FROM t_ambulance_tarif x 
			INNER JOIN m_pegawai m ON (x.PEGAWAI_ID = m.PEGAWAI_ID)
			WHERE x.RAWAT_ID = "' . $idx . '" AND x.JNS_ORDER = "' . strtoupper($ord) . '" AND x.NO_TARIF = "' . $nomor . '"
			LIMIT 1) AS NAMA_PEGAWAI,t_irja.MT_RUJUKAN,m_jaminan.NAMA_JAMINAN,
			t_irja.NO_PESERTA,t_irja.NO_SEP,t_irja.NO_SJP,m_asal_pasien.KET_ASAL_PASIEN,t_irja.PASIEN_MASUK,
			t_irja.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irja.NO_PENDAFTARAN,t_irja.SHIFT_ID,t_irja.USER_PENDAFTARAN,
			(SELECT x.GMAP_DIRECTION FROM t_ambulance_tarif x WHERE x.RAWAT_ID = "' . $idx . '"
			AND x.JNS_ORDER = "' . strtoupper($ord) . '" AND x.NO_TARIF = "' . $nomor . '"
			LIMIT 1) AS TUJUAN
			FROM t_irja 
			INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
			INNER JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			INNER JOIN m_asal_pasien ON (t_irja.ASAL_PASIEN_ID = m_asal_pasien.ASAL_PASIEN_ID)
			LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irja.IRJA_ID = "' . $idx . '"';
	}else{
		
		$sql = 'SELECT t_irna.IRNA_ID AS RAWAT_ID,t_irna.NOMR,DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR,
			"" AS ST_BARU,(SELECT x.NO_POLISI FROM t_ambulance_tarif x WHERE x.RAWAT_ID = "' . $idx . '"
			AND x.JNS_ORDER = "' . strtoupper($ord) . '" AND x.NO_TARIF = "' . $nomor . '"
			LIMIT 1) AS NAMA_UNIT,(SELECT m.NAMA_PEGAWAI FROM t_ambulance_tarif x 
			INNER JOIN m_pegawai m ON (x.PEGAWAI_ID = m.PEGAWAI_ID)
			WHERE x.RAWAT_ID = "' . $idx . '" AND x.JNS_ORDER = "' . strtoupper($ord) . '" AND x.NO_TARIF = "' . $nomor . '"
			LIMIT 1) AS NAMA_PEGAWAI,"" AS MT_RUJUKAN,m_jaminan.NAMA_JAMINAN,
			t_irna.NO_PESERTA,t_irna.NO_SEP,t_irna.NO_SJP,"" AS KET_ASAL_PASIEN,t_irna.PASIEN_MASUK,
			t_irna.PASIEN_KELUAR,m_pasien_pulang.KET_PASIEN_PULANG,
			t_irna.NO_PENDAFTARAN,t_irna.SHIFT_ID,t_irna.USER_PENDAFTARAN,
			(SELECT x.GMAP_DIRECTION FROM t_ambulance_tarif x WHERE x.RAWAT_ID = "' . $idx . '"
			AND x.JNS_ORDER = "' . strtoupper($ord) . '" AND x.NO_TARIF = "' . $nomor . '"
			LIMIT 1) AS TUJUAN
			FROM t_irna 
			INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
			INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
			INNER JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
			LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
			LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
			WHERE t_irna.IRNA_ID = "' . $idx . '"';
	}		
						
		$q = mysql_query($sql);
		while ($r = mysql_fetch_array($q)) {
			$ret[] = array('RAWAT_ID' => $r['RAWAT_ID'],
            'NOMR' => $r['NOMR'],
            'TANGGAL_DAFTAR' => $r['TANGGAL_DAFTAR'],
            'ST_BARU' => $r['ST_BARU'],
            'NAMA_UNIT' => $r['NAMA_UNIT'],
            'NAMA_PEGAWAI' => $r['NAMA_PEGAWAI'],
            'MT_RUJUKAN' => $r['MT_RUJUKAN'],
            'NAMA_JAMINAN' => $r['NAMA_JAMINAN'],
			'NO_PESERTA' => $r['NO_PESERTA'],
			'NO_SEP' => $r['NO_SEP'],
			'NO_SJP' => $r['NO_SJP'],
			'KET_ASAL_PASIEN' => $r['KET_ASAL_PASIEN'],
			'PASIEN_MASUK' => $r['PASIEN_MASUK'],
			'PASIEN_KELUAR' => $r['PASIEN_KELUAR'],
			'KET_PASIEN_PULANG' => $r['KET_PASIEN_PULANG'],
			'NO_PENDAFTARAN' => $r['NO_PENDAFTARAN'],
			'SHIFT_ID' => $r['SHIFT_ID'],
			'USER_PENDAFTARAN' => $r['USER_PENDAFTARAN'],
			'TUJUAN' => $r['TUJUAN']
			);
		}
		
    return $ret;
}

$server->register('getPembayaranAmbulance');

function getPembayaranAmbulance($idx,$nomor,$ord) {
    global $database, $connect;
	global $hostname, $username, $password;
	$connect= mysql_connect($hostname, $username, $password) or die(mysql_error());
    mysql_select_db($database, $connect) or die(mysql_error());
		$sql = 'SELECT t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,SUM(t_ambulance_tarif.KUANTITI) AS KUANTITI,t_ambulance_tarif.NO_TARIF,
				t_ambulance_tarif.GMAP_DIRECTION AS DESKRIPSI,m_tarif.SATUAN,SUM(t_ambulance_tarif.KUANTITI * m_tarif.TARIF_NON_KELAS) AS TARIF_NON_KELAS,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif_group.NAMA_SKT,CASE WHEN t_ambulance_tarif.PEGAWAI_ID IS NOT NULL THEN 
				(SELECT m_pegawai.NAMA_PEGAWAI FROM m_pegawai WHERE m_pegawai.PEGAWAI_ID = t_ambulance_tarif.PEGAWAI_ID) 
				END AS PEGAWAI_ID
				FROM t_ambulance_tarif
				INNER JOIN m_tarif ON (t_ambulance_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ambulance_tarif.RAWAT_ID = "' . $idx . '" AND t_ambulance_tarif.NO_TARIF = "' . $nomor . '"
				AND t_ambulance_tarif.JNS_ORDER = "' . strtoupper($ord) . '"
				GROUP BY t_ambulance_tarif.RAWAT_ID,t_ambulance_tarif.TARIF_ID,m_tarif.KODE_TARIF,
				m_tarif.NAMA_TARIF,t_ambulance_tarif.NO_TARIF,t_ambulance_tarif.GMAP_DIRECTION,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP
				ORDER BY m_tarif.KODE_TARIF_GROUP,m_tarif.NAMA_TARIF';
		
    $q = mysql_query($sql);
    while ($r = mysql_fetch_array($q)) {
	
		$nama_tarif = $r['NAMA_SKT'];
		if(!empty($r['PEGAWAI_ID'])) $nama_tarif  = $nama_tarif . ',' . $r['PEGAWAI_ID'];
	
        $ret[] = array('RAWAT_ID' => $r['RAWAT_ID'],
            'TARIF_ID' => $r['TARIF_ID'],
            'KODE_TARIF' => $r['KODE_TARIF'],
			'NAMA_TARIF' => $r['NAMA_TARIF'],
			'KUANTITI' => $r['KUANTITI'],
			'NO_TARIF' => $r['NO_TARIF'],
			'DESKRIPSI' => $r['DESKRIPSI'],
			'SATUAN' => $r['SATUAN'],
			'TARIF_NON_KELAS' => $r['TARIF_NON_KELAS'],
			'NAMA_TARIF_GROUP' => $nama_tarif
        );
    }
    return $ret;
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
@mysql_close($connect);
@mysql_close($connect_2);
@mysql_close($connect_3);
exit();
?>