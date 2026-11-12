<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$data = mysql_query('SELECT DISTINCT PEKERJAAN FROM m_pasien WHERE PEKERJAAN LIKE "%' . $q . '%"
					ORDER BY PEKERJAAN') or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['PEKERJAAN'] . " \n ";
}
?>