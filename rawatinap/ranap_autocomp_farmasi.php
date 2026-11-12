<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());

$qry = 'SELECT m_persediaan_farmasi.NAMA_PERSEDIAAN,m_persediaan_farmasi.FORMULARIUM,
		m_persediaan_farmasi.FORMULARIUM_NASIONAL,
		m_persediaan_farmasi.PERSEDIAAN_ID,m_persediaan_farmasi.SATUAN,
		SUM(m_persediaan_farmasi_detail.JML_STOK) AS STOK_GUDANG,
		SUM(m_persediaan_farmasi_detail.JML_STOK_APOTIK_RANAP) AS STOK_RANAP,
		SUM(m_persediaan_farmasi_detail.JML_STOK_APOTIK_IGD) AS STOK_IGD
		FROM m_persediaan_farmasi
		LEFT JOIN m_persediaan_farmasi_detail
		ON (m_persediaan_farmasi.PERSEDIAAN_ID = m_persediaan_farmasi_detail.PERSEDIAAN_ID)
		WHERE m_persediaan_farmasi.NAMA_PERSEDIAAN LIKE "%' . $q . '%"
		GROUP BY m_persediaan_farmasi.PERSEDIAAN_ID
		ORDER BY m_persediaan_farmasi.NAMA_PERSEDIAAN'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
	$formularium = '';
	if($row['FORMULARIUM'] == '1') {
		$formularium = ' [Form RS';
	}	
	
	if($row['FORMULARIUM_NASIONAL'] == '1'){
		if(!empty($formularium)){
			$formularium = $formularium . ' - Form Nasional';
		}else{
			$formularium = ' [Form Nasional';
		}
	}
	if(!empty($formularium)) $formularium = $formularium . ']'; 
	
	$kategori = '';
	//if($row['PERSEDIAAN_KATEGORI'] != '') $kategori = ' - ' . $row['PERSEDIAAN_KATEGORI']; 
	
	$temp_stok = 0;
	$temp_stok = $row['STOK_GUDANG'] + $row['STOK_RANAP'];
	$stok = '[' . $temp_stok . ' ' . $row['SATUAN'] . ']';
	
	echo $row['NAMA_PERSEDIAAN'] . $kategori . ' ' . $formularium . ' ' . $stok . " \n ";
}
?>