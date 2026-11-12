<?php
mysql_query('UPDATE m_tarif_group SET POLIKLINIK = NULL, 
					IGD = NULL, 
					IRNA = NULL,
					PENUNJANG = NULL,
					UNIT_ID = NULL,
					PENERIMAAN_LAIN_LAIN = NULL
					WHERE NON_KELAS IS NOT NULL') or die(mysql_error());
$rowcnt = $_POST['rowcnt'];
$x = 1;
while($x <= $rowcnt){
	if(isset($_POST['poliklinik' . $x])){
		mysql_query('UPDATE m_tarif_group SET POLIKLINIK = "1" WHERE TARIF_GROUP_ID = "' . $_POST['poliklinik' . $x] . '"') or die(mysql_error());
	}
	if(isset($_POST['igd' . $x])){
		mysql_query('UPDATE m_tarif_group SET IGD = "1" WHERE TARIF_GROUP_ID = "' . $_POST['igd' . $x] . '"') or die(mysql_error());
		
	}
	if(isset($_POST['irna' . $x])){
		mysql_query('UPDATE m_tarif_group SET IRNA = "1" WHERE TARIF_GROUP_ID = "' . $_POST['irna' . $x] . '"') or die(mysql_error());
		
	}
	if(isset($_POST['penunjang' . $x])){
		mysql_query('UPDATE m_tarif_group SET PENUNJANG = "1" WHERE TARIF_GROUP_ID = "' . $_POST['penunjang' . $x] . '"') or die(mysql_error());	
	}
	if(!empty($_POST['unit' . $x])){
		mysql_query('UPDATE m_tarif_group SET UNIT_ID = "' . $_POST['unit' . $x] . '" WHERE TARIF_GROUP_ID = "' . $_POST['id' . $x] . '"') or die(mysql_error());
	}
	if(isset($_POST['penerimaan_lain' . $x])){
		mysql_query('UPDATE m_tarif_group SET PENERIMAAN_LAIN_LAIN = "1" WHERE TARIF_GROUP_ID = "' . $_POST['penerimaan_lain' . $x] . '"') or die(mysql_error());
	}
$x++;
}
?>