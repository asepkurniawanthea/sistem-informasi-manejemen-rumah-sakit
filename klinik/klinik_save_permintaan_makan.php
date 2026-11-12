<?php
$cn_no = $_POST['cn_no'];
if($cn_no > 1){
	$x = 1;
	$user_name = currentUser();
	$nomor = getNomorHarian('GIZI');
	while($x < $cn_no){
		$idx = $_POST['idx_' . $x];
	
		$diagnosa = '';
		$alergi = '';
		$diet = '';
		$y = 1;
		while($y < 6){
			if($_POST['diag_' . $x . '_' . $y] != '') $diagnosa .= $_POST['diag_' . $x . '_' . $y] . '||';
			if($_POST['diet_' . $x . '_' . $y] != '') $diet .= $_POST['diet_' . $x . '_' . $y] . '||';	
			if($_POST['alergi_' . $x . '_' . $y] != '') $alergi .= $_POST['alergi_' . $x . '_' . $y] . '||';			
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
		$jam_makan = $_POST['jam_' . $x] . ':' . $_POST['menit_' . $x];
							
		if($_POST['permintaan_id'] != ''){
			mysql_query('DELETE FROM db_inventorirs.t_gizi_permintaan_makan_rajal
				WHERE GIZI_PERMINTAAN_ID = "' . $_POST['permintaan_id'] . '"') or die(mysql_error());			
		}	
		
		$tgl_permintaan = 'STR_TO_DATE("' . $_POST['tgl_permintaan_' . $x] . '","%d-%m-%Y")';
		if($_POST['tgl_permintaan_' . $x] == '') $tgl_permintaan = 'NOW()';
		
		mysql_query('INSERT INTO db_inventorirs.t_gizi_permintaan_makan_rajal(TANGGAL_PERMINTAAN,WAKTU_MAKAN,NO_PERMINTAAN,
					RAJAL_ID,UNIT_ID,DIAGNOSA,DIET,ALERGI,VEGETARIAN,PUASA,JENIS_MAKAN,USER_UNIT,TGL_UPDATE) 
					VALUES(' . $tgl_permintaan . ',"' . $jam_makan . '","' . $nomor . '","' . $idx . '","' . $_SESSION['SES_SIMRS_UNIT_ID'] . '",
					"' . $diagnosa . '","' . $diet . '","' . $alergi . '","' . $veg . '","' . $puasa . '","' . $mkn . '",
					"' . $user_name . '",NOW())') or die(mysql_error());			
	$x++;
	}
	
	?>
	<script language="JavaScript" >
		alert('Simpan Data Permintaan Berhasil.');
		window.location = "index.php?link=8f30fb90f37b4942e3e528cb5ceb02aa";
	</script>
	<?php
}
		
?>