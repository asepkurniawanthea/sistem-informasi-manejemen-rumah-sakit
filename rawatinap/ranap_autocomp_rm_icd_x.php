<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT m_icd_x.DESKRIPSI AS DIAGNOSA,m_icd_x.ICD_CODE
			FROM m_icd_x
			WHERE CONCAT(m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI) LIKE "%' . $q . '%" ORDER BY m_icd_x.DESKRIPSI'; 	
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['ICD_CODE'] . '--' . $row['DIAGNOSA'] . " \n ";
}
?>