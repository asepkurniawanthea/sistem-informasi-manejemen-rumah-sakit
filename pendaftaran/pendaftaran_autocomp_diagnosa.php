<?php

$q = strtolower($_GET['q']);
if (!$q)
    return;

/*$data = mysql_query('SELECT CONCAT(t_ref_diagnosis.CODE,"--",t_ref_diagnosis.DESCRIPTION) AS DIAGNOSA
					FROM t_ref_diagnosis WHERE CONCAT(t_ref_diagnosis.CODE,t_ref_diagnosis.DESCRIPTION) LIKE "%' . $q . '%"
					ORDER BY t_ref_diagnosis.CODE') or die(mysql_error());*/
$data = mysql_query('SELECT CONCAT(m_icd_x.ICD_CODE,"--",m_icd_x.DESKRIPSI) AS DIAGNOSA
					FROM m_icd_x WHERE CONCAT(m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI) LIKE "%' . $q . '%"
					ORDER BY m_icd_x.ICD_CODE') or die(mysql_error());					
while ($row = mysql_fetch_array($data)) {
    echo $row['DIAGNOSA'] . " \n ";
}
?>