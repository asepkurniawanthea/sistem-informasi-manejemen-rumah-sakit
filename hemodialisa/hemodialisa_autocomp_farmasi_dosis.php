<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT DISTINCT t_hemodialisa_resep.DOSIS
		FROM t_hemodialisa_resep
		WHERE t_hemodialisa_resep.DOSIS LIKE "%' . $q . '%"
		ORDER BY t_hemodialisa_resep.DOSIS'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['DOSIS'] . " \n ";
}
?>