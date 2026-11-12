<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('edoc_rekammedik/edoc_main.php');

$sql_trans = 'SELECT DISTINCT t_ipenunjang.PENUNJANG_ID AS IDX,
				t_ipenunjang_tarif.NO_SJP AS NO_ORDER,
				"irj" AS PERAWATAN
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND (m_tarif_group.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17") OR m_tarif.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17"))
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION 
				SELECT DISTINCT t_ipenunjang.PENUNJANG_ID AS IDX,
				t_ipenunjang_tarif.NO_SJP AS NO_ORDER,
				"irn" AS PERAWATAN
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND (m_tarif_group.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17") OR m_tarif.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17"))
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d") 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION
				SELECT DISTINCT t_ipenunjang.PENUNJANG_ID AS IDX,
				t_ipenunjang_tarif.NO_SJP AS NO_ORDER,
				"hrj" AS PERAWATAN
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND (m_tarif_group.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17") OR m_tarif.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17"))
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d") 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION
				SELECT DISTINCT t_ipenunjang.PENUNJANG_ID AS IDX,
				t_ipenunjang_tarif.NO_SJP AS NO_ORDER,
				"hri" AS PERAWATAN
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND (m_tarif_group.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17") OR m_tarif.UNIT_ID IN (SELECT UNIT_ID FROM m_unit WHERE PENUNJANG = "pnj"
				AND UNIT_ID <> "45" AND UNIT_ID <> "17"))
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d") 
				AND DATE(t_ipenunjang_tarif.TANGGAL_DAFTAR) <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
	$idx = $dat_trans['IDX'];
	$perawatan = $dat_trans['PERAWATAN'];
	$no_order = $dat_trans['NO_ORDER'];
	create_pdf_penunjang($idx,$perawatan,$no_order);
		
}

?>