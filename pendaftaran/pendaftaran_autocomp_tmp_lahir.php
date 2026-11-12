<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$data = mysql_query('SELECT DISTINCT TMP_LAHIR FROM m_pasien WHERE TMP_LAHIR LIKE "%' . $q . '%"
					ORDER BY TMP_LAHIR') or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['TMP_LAHIR'] . " \n ";
}
?>