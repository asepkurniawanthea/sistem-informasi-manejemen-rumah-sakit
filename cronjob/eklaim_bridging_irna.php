<?php
include('C:/xampp/htdocs/nsimrs/config/config.php');
include('C:/xampp/htdocs/nsimrs/shared/connect_db.php');
include('C:/xampp/htdocs/nsimrs/shared/function.php');
include('C:/xampp/htdocs/nsimrs/inacbg/ina_function.php');

$jaminan_claim = '1,5,9,12,13,14';
$hari_claim = '20';
$coder_nik = '3671032';

$sql_date = 'SELECT DATE_FORMAT(DATE_ADD(NOW(),INTERVAL -' . $hari_claim . ' DAY),"%Y-%m-%d") AS TANGGAL FROM DUAL';
$get_date = mysql_query($sql_date) or die(mysql_error());
$dat_date = mysql_fetch_assoc($get_date);
$tanggal = $dat_date['TANGGAL'];

$sql_trans = 'SELECT t_irna.IRNA_ID,t_irna.NO_PESERTA,t_irna.NO_SEP,
			t_irna.NOMR,m_pasien.NAMA_PASIEN,
			DATE_FORMAT(m_pasien.TGL_LAHIR,"%Y-%m-%d") AS TGL_LAHIR,
			CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN "1" 
				WHEN m_pasien.JNS_KELAMIN = "P" THEN "2" END AS JNS_KELAMIN,
			DATE_FORMAT(t_irja.PASIEN_MASUK,"%Y-%m-%d %H:%i:%s") AS TANGGAL_MASUK,
			DATE_FORMAT(t_irna.PASIEN_KELUAR,"%Y-%m-%d %H:%i:%s") AS TANGGAL_KELUAR,
			t_irna.KELAS_JAMINAN AS KELAS_RAWAT,m_pasien.BERAT_LAHIR,t_irna.PASIEN_PULANG_ID,
			m_pegawai.NAMA_PEGAWAI,CASE WHEN UPPER(m_ruang.JNS_PERAWATAN) = "KUSTA" THEN "AP"
			ELSE "BP" END AS KODE_TARIF,t_irna.JENIS_BAYAR_ID
		FROM t_irna 
		INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
		INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR)
		INNER JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
		INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
		WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL 
		AND DATE_FORMAT(t_irna.PASIEN_KELUAR,"%Y-%m-%d") = "' . $tanggal . '"
		AND t_irna.JENIS_BAYAR_ID IN (' . $jaminan_claim . ')';
$get_trans = mysql_query($sql_trans) or die(mysql_error());
$x = mysql_num_rows($get_trans);
while($dat_trans = mysql_fetch_array($get_trans)){
		$buat_klaim = buat_klaim($dat_trans['NO_PESERTA'],$dat_trans['NO_SEP'],$dat_trans['NOMR'],$dat_trans['NAMA_PASIEN'],
								$dat_trans['TGL_LAHIR'],$dat_trans['JNS_KELAMIN'],$dat_trans['IRNA_ID'],'1');
		if($buat_klaim == '200'){
			
			$update_klaim = update_klaim($dat_trans['NO_SEP'],$dat_trans['NO_PESERTA'],$dat_trans['TANGGAL_MASUK'],$dat_trans['TANGGAL_KELUAR'],'1',
					$dat_trans['KELAS_RAWAT'],$dat_trans['BERAT_LAHIR'],$dat_trans['PASIEN_PULANG_ID'],$dat_trans['NAMA_PEGAWAI'],
					$dat_trans['KODE_TARIF'],$dat_trans['JENIS_BAYAR_ID'],$coder_nik,$dat_trans['IRNA_ID'],$dat_trans['NOMR']);
			if($update_klaim == '200'){
				
				$grouping_klaim = grouping_klaim($dat_trans['NO_SEP'],$dat_trans['IRNA_ID'],'1');
				if($grouping_klaim == '200'){
					
					$final_klaim = final_klaim($dat_trans['NO_SEP'],$dat_trans['IRNA_ID'],'1',$coder_nik);
					if($final_klaim == '200'){
						
						detail_klaim($dat_trans['NO_SEP'],$dat_trans['IRNA_ID'],'1');
					}
				}
			}			
		}		
}	
?>