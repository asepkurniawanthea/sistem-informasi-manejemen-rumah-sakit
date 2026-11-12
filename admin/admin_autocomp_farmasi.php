<?php
$q = strtolower($_GET['q']);
if (!$q)
    return;

$qry = 'SELECT frm.NAMA_PERSEDIAAN,frm.PERSEDIAAN_ID
		FROM db_inventorirs.m_persediaan_farmasi frm
		WHERE frm.NAMA_PERSEDIAAN LIKE "%' . $q . '%"
		ORDER BY frm.NAMA_PERSEDIAAN'; 	

$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
    echo $row['PERSEDIAAN_ID'] . '--' . $row['NAMA_PERSEDIAAN'] . " \n ";
}
?>