<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$data = mysql_query('SELECT CONCAT(m_icd_x.ICD_CODE,"--",m_icd_x.DESKRIPSI) AS ICD
					FROM m_icd_x') or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    if (strpos(strtolower($row['ICD']), $q) !== false) {
        echo $row['ICD'] . " \n ";
    }
}
?>