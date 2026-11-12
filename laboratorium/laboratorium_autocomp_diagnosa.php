<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT DISTINCT t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA
		FROM t_ipenunjang_tarif_pemeriksaan
		WHERE t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA LIKE "%' . $q . '%"
		AND t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA NOT LIKE "%|!|%"
		ORDER BY t_ipenunjang_tarif_pemeriksaan.HASIL_DIAGNOSA'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['HASIL_DIAGNOSA'] . " \n ";
}
?>