<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');
include('C:/xampp/htdocs/nsimrs/inacbg/ina_function.php');

$jaminan_claim = '1,5,9,12,13,14';
$poli_executive = '54';
$hari_claim = '20';
$coder_nik = '3671032';

$sql_date = 'SELECT DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -' . $hari_claim . ' DAY),"%Y-%m-%d") AS TANGGAL FROM DUAL';
$get_date = mysql_query($sql_date) or die(mysql_error());
$dat_date = mysql_fetch_assoc($get_date);
$tanggal = $dat_date['TANGGAL'];

$sql_trans = 'SELECT t_irja.IRJA_ID,t_irja.NO_PESERTA,t_irja.NO_SEP,
			t_irja.NOMR,m_pasien.NAMA_PASIEN,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y-%m-%d") AS TGL_LAHIR,
			CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "1" 
				WHEN m_pasien.JNS_KELAMIN = "P" THEN "2" END AS JNS_KELAMIN,
			DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") AS TANGGAL_MASUK,
			CASE WHEN t_irja.UNIT_ID = 9 THEN DATE_FORMAT(t_irja.PASIEN_KELUAR,"%Y-%m-%d")
			ELSE DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%Y-%m-%d") END AS TANGGAL_KELUAR,
			CASE WHEN t_irja.UNIT_ID IN (' . $poli_executive . ') THEN "1"
			ELSE "3" END AS KELAS_RAWAT,m_pasien.BERAT_LAHIR,t_irja.PASIEN_PULANG_ID,
			m_pegawai.NAMA_PEGAWAI,CASE WHEN t_irja.UNIT_ID = 35 THEN "AP"
			ELSE "BP" END AS KODE_TARIF,t_irja.JENIS_BAYAR_ID
		FROM 
			(SELECT MIN(irj.IRJA_ID) AS IRJA_ID, COUNT(irj.IRJA_ID) AS JML_PELAYANAN,
			irj.TANGGAL_DAFTAR,irj.NOMR,irj.JENIS_BAYAR_ID 
			FROM t_irja irj
			WHERE irj.NO_PENDAFTARAN IS NOT NULL AND irj.ST_BATAL IS NULL 
			AND DATE_FORMAT(irj.TANGGAL_DAFTAR,"%Y-%m-%d") = "' . $tanggal . '"
			AND irj.JENIS_BAYAR_ID IN (' . $jaminan_claim . ')
			AND irj.IRJA_ID NOT IN (
				SELECT t_irna.IRNA_ID FROM t_irna WHERE t_irna.NOMR = irj.NOMR
			)
			GROUP BY t_irja.TANGGAL_DAFTAR,t_irja.NOMR,t_irja.JENIS_BAYAR_ID) x_irj
		INNER JOIN t_irja ON (x_irj.IRJA_ID = t_irja.IRJA_ID)
		INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
		INNER JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
		WHERE 1';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
		$buat_klaim = buat_klaim($dat_trans['NO_PESERTA'],$dat_trans['NO_SEP'],$dat_trans['NOMR'],$dat_trans['NAMA_PASIEN'],
								$dat_trans['TGL_LAHIR'],$dat_trans['JNS_KELAMIN'],$dat_trans['IRJA_ID'],'2');
		if($buat_klaim == '200'){
			
			$update_klaim = update_klaim($dat_trans['NO_SEP'],$dat_trans['NO_PESERTA'],$dat_trans['TANGGAL_MASUK'],$dat_trans['TANGGAL_KELUAR'],'2',
					$dat_trans['KELAS_RAWAT'],$dat_trans['BERAT_LAHIR'],$dat_trans['PASIEN_PULANG_ID'],$dat_trans['NAMA_PEGAWAI'],
					$dat_trans['KODE_TARIF'],$dat_trans['JENIS_BAYAR_ID'],$coder_nik,$dat_trans['IRJA_ID'],$dat_trans['NOMR']);
			if($update_klaim == '200'){
				
				$grouping_klaim = grouping_klaim($dat_trans['NO_SEP'],$dat_trans['IRJA_ID'],'2');
				if($grouping_klaim == '200'){
					
					$final_klaim = final_klaim($dat_trans['NO_SEP'],$dat_trans['IRJA_ID'],'2',$coder_nik);
					if($final_klaim == '200'){
						
						detail_klaim($dat_trans['NO_SEP'],$dat_trans['IRJA_ID'],'2');
					}
				}
			}			
		}
}
?>