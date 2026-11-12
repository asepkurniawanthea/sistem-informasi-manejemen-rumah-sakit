<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/lis/simrs2lis.php');

$sql_order_lab = 'SELECT ti.RAWAT_ID,ti.PENUNJANG_ID,ti.NO_ORDER,ti.JENIS_BAYAR_ID,
	ti.JNS_ORDER,ti.UNIT_ID,
	MIN(tf.NO_PEMBAYARAN) AS NO_PEMBAYARAN
	FROM t_ipenunjang ti
	INNER JOIN t_ipenunjang_tarif tf
	ON (ti.PENUNJANG_ID = tf.PENUNJANG_ID)
	INNER JOIN m_tarif mf ON (tf.TARIF_ID = mf.TARIF_ID)
	INNER JOIN m_tarif_group mg ON (mf.KODE_TARIF_GROUP = mg.KODE_TARIF_GROUP)
	WHERE ti.ORDER_BY_LIS IS NULL
	AND ti.JENIS_BAYAR_ID = "1"
	AND (ti.JNS_ORDER = "IRJ" OR ti.JNS_ORDER = "APS")
	AND tf.NO_PEMBAYARAN IS NOT NULL
	AND (mg.LABORATORIUM = "1" OR mg.LABORATORIUM_CITO = "1" OR mf.UNIT_ID = "45")
	GROUP BY ti.PENUNJANG_ID';  
$get_order_lab = mysql_query($sql_order_lab) or die(mysql_error());	
while($dat_order_lab = mysql_fetch_array($get_order_lab)){
	
	$jnsorder = $dat_order_lab['JNS_ORDER'];
	$ono = $dat_order_lab['NO_ORDER'];
	$visitno = $dat_order_lab['RAWAT_ID'];
	if($jnsorder == 'APS') $visitno = $dat_order_lab['PENUNJANG_ID'];
	
	if($dat_order_lab['UNIT_ID'] != '9' or $dat_order_lab['UNIT_ID'] != '64'){
		lis_create_order($visitno,$ono,$jnsorder);
		mysql_query('UPDATE t_ipenunjang SET ORDER_BY_LIS = "1" WHERE PENUNJANG_ID = "' . $dat_order_lab['PENUNJANG_ID'] . '"') or die(mysql_error());
	}	
}				
?>			
