<?php
$connect = mysql_connect('localhost', 'root', '20sitanala15') or die(mysql_error());
mysql_select_db('db_simrs', $connect) or die(mysql_error());

include('C:/xampp/htdocs/nsimrs/shared/function.php');
include('C:/xampp/htdocs/nsimrs/shared/enum_function.php');

$qry_pasien = 'SELECT * FROM (
			SELECT irj.IRJA_ID,irj.NOMR,irj.UNIT_ID,un.NAMA_UNIT,
			irj.PEGAWAI_ID,tp.TIPE_PEGAWAI_ID,tp.KET_TIPE_PEGAWAI,
			irj.JENIS_BAYAR_ID,
			irj.USER_PENDAFTARAN,irj.TGL_TRANS,COUNT(trf.TARIF_ID) AS JML
			FROM t_irja irj
			LEFT JOIN t_irja_tarif trf
			ON (irj.IRJA_ID = trf.IRJA_ID)
			LEFT JOIN m_pegawai pg
			ON (irj.PEGAWAI_ID = pg.PEGAWAI_ID)
			LEFT JOIN m_pegawai_tipe tp
			ON (pg.TIPE_PEGAWAI_ID = tp.TIPE_PEGAWAI_ID)
			LEFT JOIN m_unit un
			ON (irj.UNIT_ID = un.UNIT_ID)
			WHERE irj.TANGGAL_DAFTAR = STR_TO_DATE("22/10/2021","%d/%m/%Y") 
			GROUP BY irj.IRJA_ID
			) tbl
			WHERE JML = 0
			AND USER_PENDAFTARAN <> "rollback"
			AND UNIT_ID IS NOT NULL';
$get_pasien = mysql_query($qry_pasien) or die(mysql_error());
while($dat_pasien = mysql_fetch_array($get_pasien)){
	echo $dat_pasien['IRJA_ID'] . ' \n';
	$no_bayar = 'NULL';
	$st_bayar = 'NULL';
	if(!in_array($dat_pasien['JENIS_BAYAR_ID'],getArrNonJaminan())){
		$no_bayar = '"' . getNomorHarian('Kasir') . '"';
		$st_bayar = '"Lunas"';
	}
	$nomor = getNomorHarian('Tarif');
	//karcis
	if(in_array($dat_pasien['UNIT_ID'],getArrIrjaEksekutif())){
		$kode_tarif = '92001';
	}else{
		$kode_tarif = '01001';
	}
	$sql_tarif_karcis = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif . '" AND ST_AKTIF = "1"';
	$get_tarif_karcis = mysql_query($sql_tarif_karcis) or die(mysql_error());
	$dat_tarif_karcis = mysql_fetch_assoc($get_tarif_karcis);
	$tarif_karcis_id = $dat_tarif_karcis['TARIF_ID'];
	mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
		ST_BAYAR,JENIS_BAYAR_ID,ST_PRINT)
		VALUES("' . $dat_pasien['IRJA_ID'] . '",STR_TO_DATE("22/10/2021 09:30:01","%d/%m/%Y %H:%i:%s"),
		"' . $tarif_karcis_id . '",1,"' . $nomor . '", ' . $no_bayar . ',
		"Karcis & Konsultasi",' . $st_bayar . ',"' . $dat_pasien['JENIS_BAYAR_ID'] . '",NULL)') or die(mysql_error());	
						
	//konsultasi
	$sql_dokter_tipe = 'SELECT TIPE_PEGAWAI_ID FROM m_pegawai WHERE PEGAWAI_ID = "' . $dat_pasien['PEGAWAI_ID'] . '"';
	$get_dokter_tipe = mysql_query($sql_dokter_tipe) or die(mysql_error());
	$dat_dokter_tipe = mysql_fetch_assoc($get_dokter_tipe);
	$dokter_tipe = $dat_dokter_tipe['TIPE_PEGAWAI_ID']; 
	if(in_array($dat_pasien['UNIT_ID'],getArrUnitIGD())){
		if($dokter_tipe == '2'){
			$kode_tarif_konsul = '09001';
		}else{
			$kode_tarif_konsul = '09002';
		}
	}else if(in_array($dat_pasien['UNIT_ID'],getArrIrjaEksekutif())){
		if($dokter_tipe == '1'){
			$kode_tarif_konsul = '93002';
		}else if($dokter_tipe == '2'){
			$kode_tarif_konsul = '93001';
		}else if($dokter_tipe == '3'){
			$kode_tarif_konsul = '93003';
		}else if($dokter_tipe == '4'){
			$kode_tarif_konsul = '93004';
		}else if($dokter_tipe == '18'){
			$kode_tarif_konsul = '93005';	
		}
	}else{
		if($dokter_tipe == '1'){
			$kode_tarif_konsul = '02002';
		}else if($dokter_tipe == '2'){
			$kode_tarif_konsul = '02001';
		}else if($dokter_tipe == '3'){
			$kode_tarif_konsul = '02003';
		}else if($dokter_tipe == '4'){
			$kode_tarif_konsul = '02004';
		}else if($dokter_tipe == '9'){
			$kode_tarif_konsul = '02005';
		}else if($dokter_tipe == '18'){
			$kode_tarif_konsul = '93005';	
		}	
	}
				
	$sql_tarif_konsul = 'SELECT TARIF_ID FROM m_tarif WHERE KODE_TARIF = "' . $kode_tarif_konsul . '" AND ST_AKTIF = "1"';
	$get_tarif_konsul = mysql_query($sql_tarif_konsul) or die(mysql_error());
	$dat_tarif_konsul = mysql_fetch_assoc($get_tarif_konsul);
	$tarif_konsul_id = $dat_tarif_konsul['TARIF_ID'];
	mysql_query('INSERT INTO t_irja_tarif(IRJA_ID,TGL_TARIF,TARIF_ID,KUANTITI,NO_TARIF,NO_PEMBAYARAN,DESKRIPSI,
		ST_BAYAR,JENIS_BAYAR_ID,ST_PRINT)
		VALUES("' . $dat_pasien['IRJA_ID'] . '",STR_TO_DATE("22/10/2021 09:30:01","%d/%m/%Y %H:%i:%s"),
		"' . $tarif_konsul_id . '",1,"' . $nomor . '", ' . $no_bayar . ',
		"Karcis & Konsultasi",' . $st_bayar . ',"' . $dat_pasien['JENIS_BAYAR_ID'] . '",NULL)') or die(mysql_error());	

}	
				
				
				
				

