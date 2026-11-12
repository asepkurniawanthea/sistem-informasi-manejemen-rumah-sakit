<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT DISTINCT t_hemodialisa_resep.JUMLAH
		FROM t_hemodialisa_resep
		WHERE t_hemodialisa_resep.JUMLAH LIKE "%' . $q . '%"
		ORDER BY t_hemodialisa_resep.JUMLAH'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['JUMLAH'] . " \n ";
}
?>