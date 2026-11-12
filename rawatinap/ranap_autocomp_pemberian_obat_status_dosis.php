<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT DISTINCT t_irna_pemberian_obat.STATUS_DOSIS
		FROM t_irna_pemberian_obat
		WHERE t_irna_pemberian_obat.STATUS_DOSIS LIKE "%' . $q . '%"
		ORDER BY t_irna_pemberian_obat.STATUS_DOSIS'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['STATUS_DOSIS'] . " \n ";
}
?>