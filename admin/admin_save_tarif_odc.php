<?php
mysql_query('UPDATE m_tarif SET ODC = NULL') or die(mysql_error());
$rowcnt = $_POST['rowcnt'];
$x = 1;
while($x <= $rowcnt){
	if(isset($_POST['one_day_care' . $x])){
		if($_POST['kelas' . $x] == '3'){
			mysql_query('UPDATE m_tarif SET ODC = "1",
					JASA_RS = JASA_SARANA_KELAS_3,
					JASA_PELAYANAN = JASA_PELAYANAN_KELAS_3,
					TARIF_NON_KELAS = TARIF_KELAS_3,
					KELAS_ODC = "' . $_POST['kelas' . $x] . '"
					WHERE TARIF_ID = "' . $_POST['one_day_care' . $x] . '"') or die(mysql_error());
		}else if($_POST['kelas' . $x] == '2'){
			mysql_query('UPDATE m_tarif SET ODC = "1",
					JASA_RS = JASA_SARANA_KELAS_2,
					JASA_PELAYANAN = JASA_PELAYANAN_KELAS_2,
					TARIF_NON_KELAS = TARIF_KELAS_2,
					KELAS_ODC = "' . $_POST['kelas' . $x] . '"
					WHERE TARIF_ID = "' . $_POST['one_day_care' . $x] . '"') or die(mysql_error());	
		}else if($_POST['kelas' . $x] == '1'){
			mysql_query('UPDATE m_tarif SET ODC = "1",
					JASA_RS = JASA_SARANA_KELAS_1,
					JASA_PELAYANAN = JASA_PELAYANAN_KELAS_1,
					TARIF_NON_KELAS = TARIF_KELAS_1,
					KELAS_ODC = "' . $_POST['kelas' . $x] . '"
					WHERE TARIF_ID = "' . $_POST['one_day_care' . $x] . '"') or die(mysql_error());
		}			
	}
$x++;
}
?>