<?php

$q = strtolower($_GET['q']);
$rawat = $_GET['rawat'];
if (!$q)
    return;

$connect_3 = mysql_connect($hostname_3, $username_3, $password_3) or die(mysql_error());
mysql_select_db($database_3, $connect_3) or die(mysql_error());
		
$qry = 'SELECT * FROM (
			SELECT DISTINCT "2" AS JN,DIAGNOSA
			FROM t_gizi_permintaan
			WHERE DIAGNOSA LIKE "%' . $q . '%" 
			UNION
			SELECT DISTINCT "1" AS JN,DIAGNOSA
			FROM t_gizi_permintaan
			WHERE RAWAT_ID = "' . $rawat . '" 
			AND DIAGNOSA LIKE "%' . $q . '%"
		) t	
		ORDER BY DIAGNOSA'; 			
$ret = '';
$data = mysql_query($qry) or die(mysql_error());
while ($row = mysql_fetch_array($data)) {
	if($row['JN'] == '1'){
		$ret .= $row['DIAGNOSA'] . " \n ";
	}	
}
if($ret == ''){
	mysql_data_seek($data,0);
	while ($row = mysql_fetch_array($data)) {
		$ret .= $row['DIAGNOSA'] . " \n ";
	}	
}

echo $ret;
?>