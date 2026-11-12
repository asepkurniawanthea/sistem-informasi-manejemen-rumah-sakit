<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif.NAMA_TARIF) AS TARIF,m_tarif.TARIF_NON_KELAS	
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE m_tarif_group.POLIKLINIK = "1"
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif.NAMA_TARIF LIKE "%' . $q . '%" ORDER BY m_tarif.NAMA_TARIF'; 			
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['TARIF'] . ' ' . number_format($row['TARIF_NON_KELAS'], 0, ',', '.') .  " \n ";
}
?>