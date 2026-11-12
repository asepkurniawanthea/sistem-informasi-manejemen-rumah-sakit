<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT DISTINCT t_ipenunjang_tarif.CATATAN_SPESIMEN
		FROM t_ipenunjang_tarif
		WHERE t_ipenunjang_tarif.CATATAN_SPESIMEN LIKE "%' . $q . '%"
		AND t_ipenunjang_tarif.CATATAN_SPESIMEN NOT LIKE "%|!|%"
		ORDER BY t_ipenunjang_tarif.CATATAN_SPESIMEN'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['CATATAN_SPESIMEN'] . " \n ";
}
?>