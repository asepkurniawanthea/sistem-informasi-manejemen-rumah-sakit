<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

if($_SESSION['SES_SIMRS_NAMA_MODUL'] == 'IGD'){		
$qry = 'SELECT DISTINCT CASE WHEN m_tarif_group.RADIOLOGI_CITO = "1" 
			THEN CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER," Cito")
			ELSE CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER) END AS TARIF,m_tarif.TARIF_NON_KELAS	
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			WHERE (m_tarif_group.RADIOLOGI = "1"
			OR m_tarif_group.RADIOLOGI_CITO = "1")
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER LIKE "%' . $q . '%" ORDER BY m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER'; 
}else{
$qry = 'SELECT DISTINCT CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER) AS TARIF,m_tarif.TARIF_NON_KELAS	
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			WHERE m_tarif_group.RADIOLOGI = "1"
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER LIKE "%' . $q . '%" ORDER BY m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER'; 
}			
			
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['TARIF'] . ' ' . number_format($row['TARIF_NON_KELAS'], 0, ',', '.') .  " \n ";
}
?>