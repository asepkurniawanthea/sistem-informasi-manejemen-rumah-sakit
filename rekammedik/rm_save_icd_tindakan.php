<?php
$cnr = $_POST['cnr'];
$z = 1;
while($z < $cnr){
	$icd = explode('--',$_POST['icd_code'. $z]);
	if(count($icd) > 1){
		$icd_code = $icd[0]; 
		$id = $_POST['tarif_id' . $z];
		mysql_query('UPDATE m_tarif
					SET ICD_CODE = "' . $icd_code . '",
					USER_RM = "' . $user_name . '"
					WHERE TARIF_ID = "' . $id . '"') or die(mysql_error());
	}
$z++;	
}
?>