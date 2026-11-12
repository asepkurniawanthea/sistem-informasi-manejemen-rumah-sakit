<?php
mysql_query('UPDATE m_tarif_group SET IRNA = NULL, 
								KAMAR_OPERASI = NULL, 
								KAMAR_BERSALIN = NULL,
								ONE_DAY_CARE = NULL
								WHERE NON_KELAS IS NULL') or die(mysql_error());
$rowcnt = $_POST['rowcnt'];
$x = 1;
while($x <= $rowcnt){
	if(isset($_POST['rawat_inap' . $x])){
		mysql_query('UPDATE m_tarif_group SET IRNA = "1" WHERE TARIF_GROUP_ID = "' . $_POST['rawat_inap' . $x] . '"') or die(mysql_error());
		
	}
	if(isset($_POST['kamar_operasi' . $x])){
		mysql_query('UPDATE m_tarif_group SET KAMAR_OPERASI = "1" WHERE TARIF_GROUP_ID = "' . $_POST['kamar_operasi' . $x] . '"') or die(mysql_error());
		
	}
	if(isset($_POST['kamar_bersalin' . $x])){
		mysql_query('UPDATE m_tarif_group SET KAMAR_BERSALIN = "1" WHERE TARIF_GROUP_ID = "' . $_POST['kamar_bersalin' . $x] . '"') or die(mysql_error());
		
	}
	if(isset($_POST['one_day_care' . $x])){
		mysql_query('UPDATE m_tarif_group SET ONE_DAY_CARE = "1" WHERE TARIF_GROUP_ID = "' . $_POST['one_day_care' . $x] . '"') or die(mysql_error());
		
	}
$x++;
}
?>