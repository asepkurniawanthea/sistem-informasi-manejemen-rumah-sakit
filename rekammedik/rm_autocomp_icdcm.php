<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$data = mysql_query('SELECT CONCAT(m_icd_9cm.ICD_CODE,"--",m_icd_9cm.DESKRIPSI) AS ICD
					FROM m_icd_9cm') or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    if (strpos(strtolower($row['ICD']), $q) !== false) {
        echo $row['ICD'] . " \n ";
    }
}
?>