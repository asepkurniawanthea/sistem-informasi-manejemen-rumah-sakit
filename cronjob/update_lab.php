<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');

$get_lab = mysql_query('SELECT PENUNJANG_TARIF_ID FROM t_ipenunjang_tarif_pemeriksaan
					WHERE TARIF_PEMERIKSAAN_ID = 710 OR TARIF_PEMERIKSAAN_ID = 714
					OR TARIF_PEMERIKSAAN_ID = 715') or die(mysql_error());
while($dat_lab = mysql_fetch_array($get_lab)){
	
	$get_detail = mysql_query('SELECT * FROM t_ipenunjang_tarif_pemeriksaan
					WHERE PENUNJANG_TARIF_ID = "' . $dat_lab['PENUNJANG_TARIF_ID'] . '"') or die(mysql_error());
	$hasil_lab = '';
	$id = '';
	while($dat_detail = mysql_fetch_array($get_detail)){
		if($dat_detail['TARIF_PEMERIKSAAN_ID'] == '710' and !empty($dat_detail['HASIL_DIAGNOSA'])){
			$hasil_lab = $dat_detail['HASIL_DIAGNOSA'];
		}
		
		if($dat_detail['TARIF_PEMERIKSAAN_ID'] == '714' and !empty($dat_detail['HASIL_DIAGNOSA'])){
			$hasil_lab = $hasil_lab . ', ' . $dat_detail['HASIL_DIAGNOSA'];
		}
		
		if($dat_detail['TARIF_PEMERIKSAAN_ID'] == '715' and !empty($dat_detail['HASIL_DIAGNOSA'])){
			$hasil_lab = $hasil_lab . ', ' . $dat_detail['HASIL_DIAGNOSA'];
		}
		
		if($dat_detail['TARIF_PEMERIKSAAN_ID'] == '710') {
			$id = $dat_detail['PENUNJANG_TARIF_PEMERIKSAAN_ID'];
		}else{
			mysql_query('DELETE FROM t_ipenunjang_tarif_pemeriksaan 
						WHERE PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $dat_detail['PENUNJANG_TARIF_PEMERIKSAAN_ID'] . '"') or die(mysql_error());
		}	
	}	

	mysql_query('UPDATE t_ipenunjang_tarif_pemeriksaan SET HASIL_DIAGNOSA = "' . $hasil_lab . '"
				WHERE PENUNJANG_TARIF_PEMERIKSAAN_ID = "' . $id . '"') or die(mysql_error());	
	
}					
?>