<?php

$q = strtolower($_GET['q']);
$kelas = $_GET['kelas'];
if (!$q)
    return;

if(strtoupper($kelas) == '3') $field = 'm_tarif.TARIF_KELAS_3 ';
if(strtoupper($kelas) == '2') $field = 'm_tarif.TARIF_KELAS_2 ';
if(strtoupper($kelas) == '1') $field = 'm_tarif.TARIF_KELAS_1 ';
if(strtoupper($kelas) == 'UTAMA') $field = 'm_tarif.TARIF_KELAS_UTAMA ';
if(strtoupper($kelas) == 'HCU') $field = 'm_tarif.TARIF_HCU ';
if(strtoupper($kelas) == 'PERINA SEHAT') $field = 'm_tarif.TARIF_KELAS_PERINA_SEHAT ';
if(strtoupper($kelas) == 'PERINA_SAKIT') $field = 'm_tarif.TARIF_KELAS_PERINA_SAKIT ';
		
$qry = 'SELECT CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif.NAMA_TARIF) AS TARIF,' . $field . ' AS HARGA,
			m_tarif.TARIF_NON_KELAS,m_tarif_group.NON_KELAS,m_tarif.SATUAN
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE (m_tarif_group.NON_KELAS IS NULL OR m_tarif_group.IRNA = "1") 
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif.NAMA_TARIF LIKE "%' . $q . '%" 
			ORDER BY m_tarif.NAMA_TARIF'; 			
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
	if($row['NON_KELAS'] == '1'){
		echo $row['TARIF'] . ' ' . number_format($row['TARIF_NON_KELAS'], 0, ',', '.') . ' [' . $row['SATUAN'] . ']' .  " \n ";
	}else{
		echo $row['TARIF'] . ' ' . number_format($row['HARGA'], 0, ',', '.') . ' [' . $row['SATUAN'] . ']' . " \n ";
	}	
}
?>