<?php 
$irja_id = $_GET['idx'];
$qry_riwayat = 'SELECT DISTINCT * FROM (
						SELECT t_irja.IRJA_ID AS RAWAT_ID,
							STR_TO_DATE(DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") AS PASIEN_MASUK,
							STR_TO_DATE(DATE_FORMAT(t_irja.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") AS TGL_KELUAR,
							CASE WHEN t_irja.UNIT_ID = 9 THEN "IGD" 
							ELSE CONCAT("Rawat Jalan"," (",m_unit.NAMA_UNIT,")") END AS PELAYANAN,
							(SELECT GROUP_CONCAT(CONCAT(t_irja_diagnosa.DIAGNOSA," (",t_irja_diagnosa.ICD_CODE,")") SEPARATOR " -") 
							FROM t_irja_diagnosa 
								WHERE t_irja_diagnosa.IRJA_ID = t_irja.IRJA_ID
								AND t_irja_diagnosa.DIAGNOSA_ORDER <= 3
							GROUP BY t_irja_diagnosa.IRJA_ID) AS DIAGNOSA,
						m_pasien_pulang.KET_PASIEN_PULANG,
						"1" AS JNS_RAWAT,"RJ" AS ID_JNS_PERAWATAN
						FROM t_irja
						INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
						LEFT JOIN m_pasien_pulang ON (t_irja.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
						WHERE t_irja.NOMR = "' . $nomr . '" 
						AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
						UNION ALL
						SELECT t_irna.IRNA_ID AS RAWAT_ID,
						STR_TO_DATE(DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y"),"%d/%m/%Y") AS PASIEN_MASUK,
						STR_TO_DATE(DATE_FORMAT(t_irna.PASIEN_KELUAR,"%d/%m/%Y"),"%d/%m/%Y") AS TGL_KELUAR,
						CONCAT("Rawat Inap"," (",m_ruang.NAMA_RUANG,CASE WHEN LENGTH(m_ruang.DESKRIPSI) > 0 THEN CONCAT("-",m_ruang.DESKRIPSI) ELSE "" END,")") AS PELAYANAN,
						(SELECT GROUP_CONCAT(CONCAT(t_irna_diagnosa.DIAGNOSA," (",t_irna_diagnosa.ICD_CODE,")") SEPARATOR " -") 
							FROM t_irna_diagnosa 
								WHERE t_irna_diagnosa.IRNA_ID = t_irna.IRNA_ID
								AND t_irna_diagnosa.DIAGNOSA_ORDER <= 3
							GROUP BY t_irna_diagnosa.IRNA_ID) AS DIAGNOSA,
						m_pasien_pulang.KET_PASIEN_PULANG,
						"2" AS JNS_RAWAT,"RI" AS ID_JNS_PERAWATAN
						FROM t_irna
						INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
						LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID)
						WHERE t_irna.NOMR = "' . $nomr . '"
						AND t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
						) riwayat_table
						ORDER BY PASIEN_MASUK DESC';
?>
<?php include('hemodialisa/hemodialisa_tmp_riwayat_pasien.php'); ?>