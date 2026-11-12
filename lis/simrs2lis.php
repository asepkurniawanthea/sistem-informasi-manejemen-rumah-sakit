<?php

function lis_create_order($visitno,$ono,$jnsorder){
	$ptype = '';
	if($jnsorder == 'IRJ'){
		$ptype = 'OP';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.UNIT_ID,"^",mu.NAMA_UNIT) AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			"" AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO	
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_unit mu ON (ti.UNIT_ID = mu.UNIT_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irja_diagnosa dg ON (ti.RAWAT_ID = dg.IRJA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}else if($jnsorder == 'IRN'){
		$ptype = 'IN';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.RUANG_ID,"^",mu.NAMA_RUANG) AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			tn.NO_TMP_TIDUR AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN t_irna tn ON (ti.RAWAT_ID = tn.IRNA_ID)
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_ruang mu ON (ti.RUANG_ID = mu.RUANG_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irna_diagnosa dg ON (ti.RAWAT_ID = dg.IRNA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}else if($jnsorder == 'APS'){
		$ptype = 'OP';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_PERMINTAAN,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ti.NO_PASIEN_PENUNJANG AS NOMR,ti.NAMA_PASIEN,CONCAT(ti.ALAMAT," RT. ",ti.ALAMAT_RT," RW. ",ti.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ti.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ti.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ti.JNS_KELAMIN = "L" THEN "1" WHEN ti.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT("-","^",ti.INSTANSI_PENGIRIM) AS UNIT_PENGIRIM,CONCAT("-","^",ti.PENGIRIM) AS PENGIRIM,
			"" AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			ti.DIAGNOSA_PENGIRIM AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		LEFT JOIN m_kelurahan kl ON (ti.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ti.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ti.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.PENUNJANG_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.PENUNJANG_ID';	
	}else if($jnsorder == 'ORJ'){
		$ptype = 'OP';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.UNIT_ID,"^",mu.NAMA_UNIT,"-Kamar Operasi") AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			"" AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO	
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_unit mu ON (ti.UNIT_ID = mu.UNIT_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irja_diagnosa dg ON (ti.RAWAT_ID = dg.IRJA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}else if($jnsorder == 'ORI'){	
		$ptype = 'IN';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.RUANG_ID,"^",mu.NAMA_RUANG,"-Kamar Operasi") AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			tn.NO_TMP_TIDUR AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN t_irna tn ON (ti.RAWAT_ID = tn.IRNA_ID)
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_ruang mu ON (ti.RUANG_ID = mu.RUANG_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irna_diagnosa dg ON (ti.RAWAT_ID = dg.IRNA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}
	$get = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($get) > 0){
		$dat = mysql_fetch_assoc($get);
		$order_control = 'NW';
		$pid = $dat['NOMR'];
		$pname = $dat['NAMA_PASIEN'];
		$address1 = $dat['ADDR_1'];
		$address2 = $dat['ADDR_2'];
		$address3 = $dat['ADDR_3'];
		$address4 = $dat['ADDR_4'];
		$birth_dt = $dat['TGL_LAHIR'];
		$sex = $dat['JNS_KELAMIN'];
		$request_dt = $dat['TANGGAL_ORDER'];
		$source = $dat['UNIT_PENGIRIM'];
		$clinician = $dat['PENGIRIM'];
		$room_no = $dat['NO_KAMAR'];
		
		$jns_pembayaran = $dat['JENIS_BAYAR_ID'];
		$no_pembayaran = $dat['NO_PEMBAYARAN'];
		$arr_unit = explode('^',$dat['UNIT_PENGIRIM']);
		
		$priority = 'R';
		if(trim($dat['CITO']) != '') $priority = 'U';
		$comment = $dat['DIAGNOSA'];
		$order_testid = $dat['KODE_TEST'];
		if($jnsorder == 'APS') $visitno = 'P' . $visitno;
		if($ptype == 'OP') $source = 'J' . $source; 
		if($ptype == 'IN') $source = 'I' . $source; 
		
		$st_kirim = false;
		if($jns_pembayaran != '1'){
			$st_kirim = true;	
		}else{
			if($jnsorder == 'IRN' or $jnsorder == 'ORJ' or $jnsorder == 'ORI'){
				$st_kirim = true;	
			}else if($jnsorder == 'APS'){	
				if($no_pembayaran != '') $st_kirim = true;
			}else if($jnsorder == 'IRJ'){
				if($arr_unit[0] == '9' or $arr_unit[0] == '64'){
					$st_kirim = true;	
				}else{
					if($no_pembayaran != '') $st_kirim = true;
				}	
			}		
		}			
	
		if($st_kirim){
			mysql_query('INSERT INTO db_lis.lis_order (MESSAGE_DT,ORDER_CONTROL,PID,PNAME,ADDRESS1,ADDRESS2,
					ADDRESS3,ADDRESS4,PTYPE,BIRTH_DT,SEX,ONO,REQUEST_DT,SOURCE,CLINICIAN,ROOM_NO,PRIORITY,
					COMMENT,VISITNO,ORDER_TESTID)
					VALUES(DATE_FORMAT(NOW(),"%Y%m%d%H%i%s"),"NW","' . $pid . '","' . $pname . '","' . $address1 . '",
					"' . $address2 . '","' . $address3 . '","' . $address4 . '","' . $ptype . '","' . $birth_dt . '",
					"' . $sex . '","' . $ono . '","' . $request_dt . '","' . $source . '","' . $clinician . '",
					"' . $room_no . '","' . $priority . '","' . $comment . '","' . $visitno . '","' . $order_testid . '")') or die(msql_error());
		}
	}	
}

function lis_update_order($visitno,$ono,$jnsorder){
	$ptype = '';
	if($jnsorder == 'IRJ'){
		$ptype = 'OP';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.UNIT_ID,"^",mu.NAMA_UNIT) AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			"" AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO	
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_unit mu ON (ti.UNIT_ID = mu.UNIT_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irja_diagnosa dg ON (ti.RAWAT_ID = dg.IRJA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}else if($jnsorder == 'IRN'){
		$ptype = 'IN';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.RUANG_ID,"^",mu.NAMA_RUANG) AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			tn.NO_TMP_TIDUR AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN t_irna tn ON (ti.RAWAT_ID = tn.IRNA_ID)
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_ruang mu ON (ti.RUANG_ID = mu.RUANG_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irna_diagnosa dg ON (ti.RAWAT_ID = dg.IRNA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}else if($jnsorder == 'APS'){
		$ptype = 'OP';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_PERMINTAAN,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ti.NO_PASIEN_PENUNJANG AS NOMR,ti.NAMA_PASIEN,CONCAT(ti.ALAMAT," RT. ",ti.ALAMAT_RT," RW. ",ti.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ti.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ti.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ti.JNS_KELAMIN = "L" THEN "1" WHEN ti.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT("-","^",ti.INSTANSI_PENGIRIM) AS UNIT_PENGIRIM,CONCAT("-","^",ti.PENGIRIM) AS PENGIRIM,
			"" AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			ti.DIAGNOSA_PENGIRIM AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		LEFT JOIN m_kelurahan kl ON (ti.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ti.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ti.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.PENUNJANG_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.PENUNJANG_ID';	
	}else if($jnsorder == 'ORJ'){
		$ptype = 'OP';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.UNIT_ID,"^",mu.NAMA_UNIT,"-Kamar Operasi") AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			"" AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO	
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_unit mu ON (ti.UNIT_ID = mu.UNIT_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irja_diagnosa dg ON (ti.RAWAT_ID = dg.IRJA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}else if($jnsorder == 'ORI'){	
		$ptype = 'IN';
		$sql = 'SELECT DATE_FORMAT(ti.TANGGAL_ORDER,"%Y%m%d%H%i%s") AS TANGGAL_ORDER,
			ps.NOMR,ps.NAMA_PASIEN,CONCAT(ps.ALAMAT," RT. ",ps.ALAMAT_RT," RW. ",ps.ALAMAT_RW) AS ADDR_1,
			CONCAT(kl.NAMA_KELURAHAN," ",kc.NAMA_KECAMATAN," ",kt.NAMA_KOTA) AS ADDR_2, 
			MAX(CONCAT(jm.JAMINAN_ID,"^",jm.NAMA_JAMINAN)) AS ADDR_3,ps.NO_TELEPON AS ADDR_4,
			DATE_FORMAT(ps.TGL_LAHIR,"%Y%m%d%H%i%s") AS TGL_LAHIR,
			CASE WHEN ps.JNS_KELAMIN = "L" THEN "1" WHEN ps.JNS_KELAMIN = "P" THEN "2" ELSE "0" END AS JNS_KELAMIN,
			CONCAT(mu.RUANG_ID,"^",mu.NAMA_RUANG,"-Kamar Operasi") AS UNIT_PENGIRIM,CONCAT(mp.PEGAWAI_ID,"^",mp.NAMA_PEGAWAI) AS PENGIRIM,
			tn.NO_TMP_TIDUR AS NO_KAMAR,ti.JENIS_BAYAR_ID,
			MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN,
			GROUP_CONCAT(DISTINCT dg.DIAGNOSA) AS DIAGNOSA,
			GROUP_CONCAT(DISTINCT mf.KODE_TARIF_LAB SEPARATOR "~") AS KODE_TEST,
			MAX(mg.LABORATORIUM_CITO) AS CITO
		FROM t_ipenunjang ti
		INNER JOIN t_ipenunjang_tarif tf ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
		INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
		INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)	
		INNER JOIN t_irna tn ON (ti.RAWAT_ID = tn.IRNA_ID)
		INNER JOIN m_pasien ps ON (ti.NOMR = ps.NOMR)
		INNER JOIN m_ruang mu ON (ti.RUANG_ID = mu.RUANG_ID)
		INNER JOIN m_pegawai mp ON (ti.PEGAWAI_ID = mp.PEGAWAI_ID)
		LEFT JOIN m_kelurahan kl ON (ps.KELURAHAN_ID = kl.KELURAHAN_ID)
		LEFT JOIN m_kecamatan kc ON (ps.KECAMATAN_ID = kc.KECAMATAN_ID)
		LEFT JOIN m_kota kt ON (ps.KOTA_ID = kt.KOTA_ID)
		LEFT JOIN t_irna_diagnosa dg ON (ti.RAWAT_ID = dg.IRNA_ID)
		LEFT JOIN m_jaminan jm ON (ti.JENIS_BAYAR_ID = jm.JAMINAN_ID)
		WHERE ti.RAWAT_ID = "' . $visitno . '"
		AND ti.JNS_ORDER = "' . $jnsorder . '"
		AND ti.NO_ORDER = "' . $ono . '"
		AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1"
			OR mf.UNIT_ID = "45")
		GROUP BY ti.RAWAT_ID,ti.JNS_ORDER,ti.NO_ORDER';
	}
	$get = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($get) > 0){
		$dat = mysql_fetch_assoc($get);
		$order_control = 'RP';
		$pid = $dat['NOMR'];
		$pname = $dat['NAMA_PASIEN'];
		$address1 = $dat['ADDR_1'];
		$address2 = $dat['ADDR_2'];
		$address3 = $dat['ADDR_3'];
		$address4 = $dat['ADDR_4'];
		$birth_dt = $dat['TGL_LAHIR'];
		$sex = $dat['JNS_KELAMIN'];
		$request_dt = $dat['TANGGAL_ORDER'];
		$source = $dat['UNIT_PENGIRIM'];
		$clinician = $dat['PENGIRIM'];
		$room_no = $dat['NO_KAMAR'];
		
		$jns_pembayaran = $dat['JENIS_BAYAR_ID'];
		$no_pembayaran = $dat['NO_PEMBAYARAN'];
		$arr_unit = explode('^',$dat['UNIT_PENGIRIM']);
		
		$priority = 'R';
		if(trim($dat['CITO']) != '') $priority = 'U';
		$comment = $dat['DIAGNOSA'];
		$order_testid = $dat['KODE_TEST'];
		if($jnsorder == 'APS') $visitno = 'P' . $visitno;
		if($ptype == 'OP') $source = 'J' . $source; 
		if($ptype == 'IN') $source = 'I' . $source; 
		
		$st_kirim = false;
		if($jns_pembayaran != '1'){
			$st_kirim = true;	
		}else{
			if($jnsorder == 'IRN' or $jnsorder == 'ORJ' or $jnsorder == 'ORI'){
				$st_kirim = true;	
			}else if($jnsorder == 'APS'){	
				if($no_pembayaran != '') $st_kirim = true;
			}else if($jnsorder == 'IRJ'){
				if($arr_unit[0] == '9' or $arr_unit[0] == '64'){
					$st_kirim = true;	
				}else{
					if($no_pembayaran != '') $st_kirim = true;
				}	
			}		
		}		
		
		if($st_kirim){
			mysql_query('INSERT INTO db_lis.lis_order (MESSAGE_DT,ORDER_CONTROL,PID,PNAME,ADDRESS1,ADDRESS2,
					ADDRESS3,ADDRESS4,PTYPE,BIRTH_DT,SEX,ONO,REQUEST_DT,SOURCE,CLINICIAN,ROOM_NO,PRIORITY,
					COMMENT,VISITNO,ORDER_TESTID)
					VALUES(DATE_FORMAT(NOW(),"%Y%m%d%H%i%s"),"RP","' . $pid . '","' . $pname . '","' . $address1 . '",
					"' . $address2 . '","' . $address3 . '","' . $address4 . '","' . $ptype . '","' . $birth_dt . '",
					"' . $sex . '","' . $ono . '","' . $request_dt . '","' . $source . '","' . $clinician . '",
					"' . $room_no . '","' . $priority . '","' . $comment . '","' . $visitno . '","' . $order_testid . '")') or die(msql_error());
		}
	}	
}

function lis_cancel_order($visitno,$ono){
	$sql = 'SELECT ID,MESSAGE_DT,ORDER_CONTROL,PID,PNAME,ADDRESS1,ADDRESS2,ADDRESS3,ADDRESS4,PTYPE,BIRTH_DT,
		SEX,ONO,REQUEST_DT,SOURCE,CLINICIAN,ROOM_NO,PRIORITY,COMMENT,VISITNO,ORDER_TESTID,FLAG
		FROM db_lis.lis_order
		WHERE VISITNO = "' . $visitno . '"
		AND ONO = "' . $ono . '"
		ORDER BY ID DESC LIMIT 1';
	$get = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($get) > 0){
		$dat = mysql_fetch_assoc($get);
	
		mysql_query('INSERT INTO db_lis.lis_order (MESSAGE_DT,ORDER_CONTROL,PID,PNAME,ADDRESS1,ADDRESS2,ADDRESS3,ADDRESS4,
			PTYPE,BIRTH_DT,SEX,ONO,REQUEST_DT,SOURCE,CLINICIAN,ROOM_NO,PRIORITY,COMMENT,VISITNO,ORDER_TESTID)
			VALUES (DATE_FORMAT(NOW(),"%Y%m%d%H%i%s"),"CA","' . $dat['PID'] . '","' . $dat['PNAME'] . '",
			"' . $dat['ADDRESS1'] . '","' . $dat['ADDRESS2'] . '","' . $dat['ADDRESS3'] . '","' . $dat['ADDRESS4'] . '",
			"' . $dat['PTYPE'] . '","' . $dat['BIRTH_DT'] . '","' . $dat['SEX'] . '","' . $dat['ONO'] . '",
			"' . $dat['REQUEST_DT'] . '","' . $dat['SOURCE'] . '","' . $dat['CLINICIAN'] . '","' . $dat['ROOM_NO'] . '",
			"' . $dat['PRIORITY'] . '","' . $dat['COMMENT'] . '","' . $dat['VISITNO'] . '","' . $dat['ORDER_TESTID'] . '")') or die(mysql_error());
	}		
}

?>

