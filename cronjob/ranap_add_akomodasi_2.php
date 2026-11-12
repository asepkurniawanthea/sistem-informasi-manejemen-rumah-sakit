<?php

include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');

$sql_tarif = 'SELECT TARIF_ID FROM m_tarif 
		WHERE KODE_TARIF = "51001"
		AND ST_AKTIF = "1"';
$get_tarif = mysql_query($sql_tarif) or die(mysql_error());
$dat_tarif = mysql_fetch_assoc($get_tarif);
$tarif_id = $dat_tarif['TARIF_ID'];

$sql_opname = 'SELECT t_irna.IRNA_ID,
				t_irna.NOMR,
				t_irna.RUANG_ID,
				t_irna.NO_TMP_TIDUR,
				t_irna.JENIS_BAYAR_ID,
				m_ruang.KELAS_RAWAT,
				t_irna.KELAS_JAMINAN
				FROM t_irna
				INNER JOIN m_ruang
				ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna.PASIEN_MASUK IS NOT NULL
				AND t_irna.PASIEN_KELUAR IS NULL
				AND t_irna.ST_PULANG IS NULL
				AND t_irna.ST_BATAL IS NULL';
$get_opname = mysql_query($sql_opname) or die(mysql_error());
while($dat_opname = mysql_fetch_array($get_opname)){
	
	mysql_query('DELETE t_irna_tarif 
		FROM t_irna_tarif 
		INNER JOIN m_tarif 
		ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
		WHERE t_irna_tarif.IRNA_ID = "' . $dat_opname['IRNA_ID'] . '"
		AND m_tarif.KODE_TARIF = "51001"
		AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d%m%Y") = DATE_FORMAT(NOW(),"%d%m%Y")') or die(mysql_error());
	
	//akomodasi					
	$no_bayar = 'NULL';
	$st_bayar = 'NULL';
	if($dat_opname['JENIS_BAYAR_ID'] <> '1' and $dat_opname['JENIS_BAYAR_ID'] <> '18'){
		$no_bayar = '"' . getNomorHarian('Kasir') . '"';
		$st_bayar = '"Lunas"';
	}
	$nomor = getNomorHarian('Tarif');	
					
	mysql_query('INSERT INTO t_irna_tarif(IRNA_ID,TARIF_ID,KUANTITI,DESKRIPSI,KELAS_RAWAT,RUANG_ID,
		NO_TARIF,NO_PEMBAYARAN,TGL_TARIF,ST_BAYAR,KELAS_JAMINAN,JENIS_BAYAR_ID) 
		VALUES("' . $dat_opname['IRNA_ID'] . '","' . $tarif_id . '",1,"Tindakan (Ruang Rawat)",
		"' . $dat_opname['KELAS_RAWAT'] . '","' . $dat_opname['RUANG_ID'] . '","' . $nomor . '",' . $no_bayar . ',
		NOW(),' . $st_bayar . ',"' . $dat_opname['KELAS_JAMINAN'] . '","' . $dat_opname['JENIS_BAYAR_ID'] . '")') or die(mysql_error());
	//end akomodasi
}	
?>