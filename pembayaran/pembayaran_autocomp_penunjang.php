<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT * FROM (SELECT DISTINCT CASE WHEN m_tarif_group.LABORATORIUM_CITO = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
			THEN CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER," Cito")
			ELSE CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER) END AS TARIF,
			m_tarif.TARIF_NON_KELAS,
			m_tarif.SATUAN		
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
			WHERE (m_tarif_group.LABORATORIUM = "1"
			OR m_tarif_group.LABORATORIUM_CITO = "1"
			OR m_tarif_group.RADIOLOGI = "1"
			OR m_tarif_group.RADIOLOGI_CITO = "1")
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif_pemeriksaan.NAMA_PEMERIKSAAN LIKE "%' . $q . '%" 
			UNION
			SELECT DISTINCT CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif.NAMA_TARIF) AS TARIF,
			m_tarif.TARIF_NON_KELAS,
			m_tarif.SATUAN		
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE m_tarif_group.PENUNJANG = "1"
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif.NAMA_TARIF LIKE "%' . $q . '%") t_pnj ORDER BY TARIF'; 			
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['TARIF'] . ' ' . number_format($row['TARIF_NON_KELAS'], 0, ',', '.') . ' [' . $row['SATUAN'] . ']' . " \n ";
}
?>