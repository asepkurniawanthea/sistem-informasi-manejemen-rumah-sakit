<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$c_modul = strtolower($_SESSION['SES_SIMRS_NAMA_MODUL']);	
if($c_modul == 'klinik' or $c_modul == 'kusta'){
$qry = 'SELECT CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif.NAMA_TARIF) AS TARIF,m_tarif.TARIF_NON_KELAS,
			m_tarif.SATUAN	
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE m_tarif_group.POLIKLINIK = "1"
			AND (m_tarif_group.LABORATORIUM IS NULL OR m_tarif_group.LABORATORIUM = "")
			AND (m_tarif_group.LABORATORIUM_CITO IS NULL OR m_tarif_group.LABORATORIUM_CITO = "")
			AND (m_tarif_group.RADIOLOGI IS NULL OR m_tarif_group.RADIOLOGI = "")
			AND (m_tarif_group.RADIOLOGI_CITO IS NULL OR m_tarif_group.RADIOLOGI_CITO = "")
			AND (m_tarif_group.REHABILITASI_MEDIK IS NULL OR m_tarif_group.REHABILITASI_MEDIK = "")
			AND (m_tarif_group.PENUNJANG IS NULL OR m_tarif_group.PENUNJANG = "")
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif.KODE_TARIF_GROUP NOT IN ("170")
			AND m_tarif.NAMA_TARIF LIKE "%' . $q . '%" ORDER BY m_tarif.NAMA_TARIF'; 
}else if($c_modul == 'igd'){
$qry = 'SELECT CONCAT(m_tarif.KODE_TARIF," -- ",m_tarif.NAMA_TARIF) AS TARIF,m_tarif.TARIF_NON_KELAS,
			m_tarif.SATUAN
			FROM m_tarif
			INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
			WHERE m_tarif_group.IGD = "1"
			AND (m_tarif_group.LABORATORIUM IS NULL OR m_tarif_group.LABORATORIUM = "")
			AND (m_tarif_group.LABORATORIUM_CITO IS NULL OR m_tarif_group.LABORATORIUM_CITO = "")
			AND (m_tarif_group.RADIOLOGI IS NULL OR m_tarif_group.RADIOLOGI = "")
			AND (m_tarif_group.RADIOLOGI_CITO IS NULL OR m_tarif_group.RADIOLOGI_CITO = "")
			AND (m_tarif_group.REHABILITASI_MEDIK IS NULL OR m_tarif_group.REHABILITASI_MEDIK = "")
			AND (m_tarif_group.PENUNJANG IS NULL OR m_tarif_group.PENUNJANG = "")
			AND m_tarif.KODE_TARIF_GROUP NOT IN ("170")
			AND m_tarif.ST_AKTIF = "1"
			AND m_tarif.NAMA_TARIF LIKE "%' . $q . '%" ORDER BY m_tarif.NAMA_TARIF'; 
}			
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['TARIF'] . ' ' . number_format($row['TARIF_NON_KELAS'], 0, ',', '.') . ' [' . $row['SATUAN'] . ']' . " \n ";
}
?>