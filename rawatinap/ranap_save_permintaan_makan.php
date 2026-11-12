<?php
$cn_no = $_POST['cn_no'];
if($cn_no > 1){
	$x = 1;
	$user_name = currentUser();
	while($x < $cn_no){
		$idx = $_POST['idx_' . $x];
		
		$diagnosa = '';
		$alergi = '';
		$diet = '';
		
		$y = 1;
		while($y < 6){
			if($_POST['diag_' . $x . '_' . $y] != '') $diagnosa .= $_POST['diag_' . $x . '_' . $y] . '||';
			if($_POST['alergi_' . $x . '_' . $y] != '') $alergi .= $_POST['alergi_' . $x . '_' . $y] . '||';			
			if($_POST['diet_' . $x . '_' . $y] != '') $diet .= $_POST['diet_' . $x . '_' . $y] . '||';	
		 $y++;	
		}
		
		$diagnosa = substr($diagnosa,0,strlen($diagnosa)-2);
		$diet = substr($diet,0,strlen($diet)-2);
		$alergi = substr($alergi,0,strlen($alergi)-2);
		
		$veg = '';
		if(isset($_POST['veg_' . $x])) $veg = '1';
		$puasa = '';
		if(isset($_POST['puasa_' . $x])) $puasa = '1';
		$mkn = $_POST['mkn_' . $x];
		$kmr = $_POST['kmr_' . $x];
		
		mysql_query('DELETE FROM db_inventorirs.t_gizi_permintaan_makan_ranap WHERE RANAP_ID = "' . $idx . '"') or die(mysql_error());	
		mysql_query('INSERT INTO db_inventorirs.t_gizi_permintaan_makan_ranap(RANAP_ID,DIAGNOSA,DIET,ALERGI,VEGETARIAN,PUASA,JENIS_MAKAN,USER_UNIT,TGL_UPDATE,RUANG_ID,KAMAR) 
					VALUES("' . $idx . '","' . $diagnosa . '","' . $diet . '","' . $alergi . '","' . $veg . '","' . $puasa . '","' . $mkn . '","' . $user_name . '",NOW(),
					(SELECT RUANG_ID FROM db_simrs.t_irna WHERE IRNA_ID = "' . $idx . '"),"' . $kmr . '")') or die(mysql_error());		
	$x++;
	}
	$_SESSION['ranappermintaanmakan_ruang_id'] = '';
	?>
	<script language="JavaScript" >
		alert('Simpan Data Permintaan Berhasil.');
		window.location = "index.php?link=b9dd8bbfb4bfd7464009e8db36368a07";
	</script>
	<?php
}
		
?>