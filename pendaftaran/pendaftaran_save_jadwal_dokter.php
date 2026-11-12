<?php if(currentModul() == 'klinik' or $_SESSION['SES_SIMRS_ADMIN'] == '1'){ 

mysql_query('DELETE FROM t_dokter_jaga_jadwal WHERE UNIT_ID = "' . $_POST['unit_id'] . '"') or die(mysql_error());
$rowcnt = $_POST['rowcnt'];
$x = 1;
while($x <= $rowcnt){
	
	if(isset($_POST['minggu' . $x])){
		mysql_query('INSERT INTO t_dokter_jaga_jadwal(UNIT_ID,PEGAWAI_ID,HARI_ID,JAM_MULAI_PRAKTEK,JAM_SELESAI_PRAKTEK,KUOTA) VALUES("' . $_POST['unit_id'] . '","' . $_POST['minggu' . $x] . '",0,"' . $_POST['buka_minggu' . $x] . '","' . $_POST['tutup_minggu' . $x] . '","' . $_POST['kuota_minggu' . $x] . '")') or die(mysql_error());
		
	}
	if(isset($_POST['senin' . $x])){
		mysql_query('INSERT INTO t_dokter_jaga_jadwal(UNIT_ID,PEGAWAI_ID,HARI_ID,JAM_MULAI_PRAKTEK,JAM_SELESAI_PRAKTEK,KUOTA) VALUES("' . $_POST['unit_id'] . '","' . $_POST['senin' . $x] . '",1,"' . $_POST['buka_senin' . $x] . '","' . $_POST['tutup_senin' . $x] . '","' . $_POST['kuota_senin' . $x] . '")') or die(mysql_error());
		
	}
	if(isset($_POST['selasa' . $x])){
		mysql_query('INSERT INTO t_dokter_jaga_jadwal(UNIT_ID,PEGAWAI_ID,HARI_ID,JAM_MULAI_PRAKTEK,JAM_SELESAI_PRAKTEK,KUOTA) VALUES("' . $_POST['unit_id'] . '","' . $_POST['selasa' . $x] . '",2,"' . $_POST['buka_selasa' . $x] . '","' . $_POST['tutup_selasa' . $x] . '","' . $_POST['kuota_selasa' . $x] . '")') or die(mysql_error());
		
	}
	if(isset($_POST['rabu' . $x])){
		mysql_query('INSERT INTO t_dokter_jaga_jadwal(UNIT_ID,PEGAWAI_ID,HARI_ID,JAM_MULAI_PRAKTEK,JAM_SELESAI_PRAKTEK,KUOTA) VALUES("' . $_POST['unit_id'] . '","' . $_POST['rabu' . $x] . '",3,"' . $_POST['buka_rabu' . $x] . '","' . $_POST['tutup_rabu' . $x] . '","' . $_POST['kuota_rabu' . $x] . '")') or die(mysql_error());
		
	}
	if(isset($_POST['kamis' . $x])){
		mysql_query('INSERT INTO t_dokter_jaga_jadwal(UNIT_ID,PEGAWAI_ID,HARI_ID,JAM_MULAI_PRAKTEK,JAM_SELESAI_PRAKTEK,KUOTA) VALUES("' . $_POST['unit_id'] . '","' . $_POST['kamis' . $x] . '",4,"' . $_POST['buka_kamis' . $x] . '","' . $_POST['tutup_kamis' . $x] . '","' . $_POST['kuota_kamis' . $x] . '")') or die(mysql_error());
		
	}
	if(isset($_POST['jumat' . $x])){
		mysql_query('INSERT INTO t_dokter_jaga_jadwal(UNIT_ID,PEGAWAI_ID,HARI_ID,JAM_MULAI_PRAKTEK,JAM_SELESAI_PRAKTEK,KUOTA) VALUES("' . $_POST['unit_id'] . '","' . $_POST['jumat' . $x] . '",5,"' . $_POST['buka_jumat' . $x] . '","' . $_POST['tutup_jumat' . $x] . '","' . $_POST['kuota_jumat' . $x] . '")') or die(mysql_error());
		
	}
	if(isset($_POST['sabtu' . $x])){
		mysql_query('INSERT INTO t_dokter_jaga_jadwal(UNIT_ID,PEGAWAI_ID,HARI_ID,JAM_MULAI_PRAKTEK,JAM_SELESAI_PRAKTEK,KUOTA) VALUES("' . $_POST['unit_id'] . '","' . $_POST['sabtu' . $x] . '",6,"' . $_POST['buka_sabtu' . $x] . '","' . $_POST['tutup_sabtu' . $x] . '","' . $_POST['kuota_sabtu' . $x] . '")') or die(mysql_error());
		
	}
$x++;
}
} 
?>