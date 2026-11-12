<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT m_tarif.KODE_TARIF,CONCAT(m_tarif.NAMA_TARIF,"(",m_tarif_group.NAMA_TARIF_GROUP,")") AS NAMA_TARIF
		FROM m_tarif
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
		WHERE (m_tarif.KODE_TARIF LIKE "%' . $q . '%"
		OR CONCAT(m_tarif.NAMA_TARIF,m_tarif_group.NAMA_TARIF_GROUP) LIKE "%' . $q . '%")
		AND m_tarif.ST_AKTIF = "1"
		ORDER BY m_tarif.NAMA_TARIF'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['KODE_TARIF'] . '--' . $row['NAMA_TARIF'] . " \n ";
}
?>