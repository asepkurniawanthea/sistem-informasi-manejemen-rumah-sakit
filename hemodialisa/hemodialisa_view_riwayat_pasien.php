<?php 
$irja_id = $_GET['idx'];
$qry_riwayat = 'SELECT * FROM (SELECT MAX(t_rm_dokumen_file.FILE_ID) AS FILE_ID,
					t_rm_dokumen_file.RAWAT_ID,"Rawat Jalan" AS JNS_PERAWATAN,
					t_irja.TANGGAL_DAFTAR AS PASIEN_MASUK,m_unit.NAMA_UNIT,
					"RJ" AS ID_JNS_PERAWATAN
					FROM t_rm_dokumen_file
					INNER JOIN t_irja ON (t_rm_dokumen_file.RAWAT_ID = t_irja.IRJA_ID)
					INNER JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
					WHERE t_rm_dokumen_file.NOMR = "' . $nomr . '"
					AND t_irja.NO_PENDAFTARAN IS NOT NULL 
					AND t_irja.ST_BATAL IS NULL
					AND t_rm_dokumen_file.JNS_PERAWATAN = "1"
					GROUP BY t_rm_dokumen_file.RAWAT_ID
					UNION 
					SELECT MAX(t_rm_dokumen_file.FILE_ID) AS FILE_ID,
					t_rm_dokumen_file.RAWAT_ID,"Rawat Inap" AS JNS_PERAWATAN,
					t_irna.TANGGAL_DAFTAR AS PASIEN_MASUK,m_ruang.NAMA_RUANG AS NAMA_UNIT,
					"RI" AS ID_JNS_PERAWATAN
					FROM t_rm_dokumen_file
					INNER JOIN t_irna ON (t_rm_dokumen_file.RAWAT_ID = t_irna.IRNA_ID)
					INNER JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
					WHERE t_rm_dokumen_file.NOMR = "' . $nomr . '"
					AND t_irna.NO_PENDAFTARAN IS NOT NULL 
					AND t_irna.ST_BATAL IS NULL
					AND t_rm_dokumen_file.JNS_PERAWATAN = "2"
					GROUP BY t_rm_dokumen_file.RAWAT_ID) t_doc
					ORDER BY PASIEN_MASUK DESC';
?>
    <table class="tableData" id="tfhover" >
        <?php include('klinik/klinik_tmp_riwayat_pasien.php'); ?>
	</table>	
</form>