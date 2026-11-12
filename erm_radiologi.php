<?php
$user_name ='';
include('config/config.php');
include('shared/connect_db.php');
include('shared/function.php');
include('edoc_rekammedik/edoc_main.php');

$sql_trans = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID AS IDX,
				t_ipenunjang_tarif.NO_TARIF AS NO_ORDER,
				"irj" AS PERAWATAN,
				t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "IRJ"
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION 
				SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID AS IDX,
				t_ipenunjang_tarif.NO_TARIF AS NO_ORDER,
				"irn" AS PERAWATAN,
				t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "IRN"
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION
				SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID AS IDX,
				t_ipenunjang_tarif.NO_TARIF AS NO_ORDER,
				"hrj" AS PERAWATAN,
				t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "HRJ"
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL
				UNION
				SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID AS IDX,
				t_ipenunjang_tarif.NO_TARIF AS NO_ORDER,
				"hri" AS PERAWATAN,
				t_ipenunjang.RAWAT_ID
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				WHERE t_ipenunjang.JNS_ORDER = "HRI"
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND t_ipenunjang_tarif.NO_TARIF IS NOT NULL
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE(DATE_FORMAT(DATE_ADD(NOW(),INTERVAL - 7 DAY),"%Y-%m-%d"),"%Y-%m-%d")
				AND STR_TO_DATE(DATE_FORMAT(t_ipenunjang_tarif.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE(DATE_FORMAT(NOW(),"%Y-%m-%d"),"%Y-%m-%d")
				AND t_ipenunjang_tarif.ST_BATAL IS NULL';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
	$idx_tarif = $dat_trans['IDX'];
	$idx_rawat = $dat_trans['RAWAT_ID'];
	$perawatan = $dat_trans['PERAWATAN'];
	$no_order = $dat_trans['NO_ORDER'];
	create_pdf_radiologi($idx_rawat,$idx_tarif,$perawatan,$no_order);
		
}

?>