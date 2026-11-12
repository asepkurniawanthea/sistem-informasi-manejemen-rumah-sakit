<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

/*echo 'Per Oral' . " \n ";
echo 'Parenteral' . " \n ";
echo 'Kemih' . " \n ";
echo 'Muntah' . " \n ";
echo 'Defekasi' . " \n ";
echo 'Berkemih' . " \n ";*/

$qry = 'SELECT DISTINCT JENIS_KELUAR_MASUK
		FROM t_irna_askep_catatan_keluar_masuk
		WHERE JENIS_KELUAR_MASUK LIKE "%' . $q . '%" ORDER BY JENIS_KELUAR_MASUK'; 
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['JENIS_KELUAR_MASUK'] .  " \n ";
}
?>