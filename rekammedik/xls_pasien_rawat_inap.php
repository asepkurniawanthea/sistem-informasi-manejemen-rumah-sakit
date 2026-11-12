<?php
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$tgl_1 = '';
if (isset($_POST['tgl_1']))
    $tgl_1 = $_POST['tgl_1'];
$tgl_2 = '';
if (isset($_POST['tgl_1']))
    $tgl_2 = $_POST['tgl_2'];

$unit_id = '';
if (isset($_POST['unit_id']))
		$unit_id = $_POST['unit_id'];

$jaminan_id = '';
if (isset($_POST['jaminan_id']))
		$jaminan_id = $_POST['jaminan_id'];	

$ruang_id = '';
if (isset($_POST['ruang_id']))
		$ruang_id = $_POST['ruang_id'];
	
$searchkey = '';
if (isset($_POST['searchkey']))
		$searchkey = $_POST['searchkey'];			

$tgl_filter_1 = fieldDate($tgl_1);
if (empty($tgl_1)) {
    $tgl_filter_1 = 'CURRENT_DATE()';
}
$tgl_filter_2 = fieldDate($tgl_2);
if (empty($tgl_2)) {
    $tgl_filter_2 = $tgl_filter_1;
}	

$qry_kunjungan = 'SELECT t_irna.IRNA_ID, t_irna.NOMR, t_irna.TANGGAL_DAFTAR,
	DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,t_irna.PASIEN_KELUAR,
	m_ruang.NAMA_RUANG,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,m_pasien.TGL_LAHIR,m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	t_irna.USER_PENDAFTARAN,m_pasien_pulang.KET_PASIEN_PULANG,t_irna.ST_PULANG,t_irna.KELAS_RAWAT,
	DATE_FORMAT(t_irna.PASIEN_MASUK,"%d/%m/%Y %H:%i") AS PASIEN_MASUK,m_pegawai.NAMA_PEGAWAI,
	DATEDIFF(t_irna.PASIEN_KELUAR,t_irna.PASIEN_MASUK) + 1 AS LOS,
	m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
	m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
	t_rm_tracer.RM_TERIMA,CASE t_irja.ST_BARU
	WHEN "1" THEN "v" END AS ST_BARU_LAMA,
	(
		SELECT COUNT(x.IRJA_ID) FROM t_irja x
		WHERE x.NOMR = t_irja.NOMR 
		AND DATE_FORMAT(x.TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(t_irna.TANGGAL_DAFTAR,"%m%Y") 
		AND x.IRJA_ID < t_irna.IRNA_ID
	)+1 AS KUNJ_KE,
		CASE WHEN t_irna.ST_CODING_ERM = "" OR t_irna.ST_CODING_ERM IS NULL THEN
			GROUP_CONCAT(DISTINCT 
				CASE WHEN t_irna_diagnosa.DIAGNOSA_ORDER = 0 THEN 
					CASE WHEN t_irna_diagnosa.ICD_CODE IS NULL OR t_irna_diagnosa.ICD_CODE = ""
						THEN t_irna_diagnosa.DIAGNOSA
						ELSE t_irna_diagnosa.ICD_CODE
					END	
				END 
			ORDER BY t_irna_diagnosa.ICD_CODE)
		ELSE 
			GROUP_CONCAT(DISTINCT 
				CASE WHEN t_irna_diagnosa_pulang.DIAGNOSA_ORDER = 0 THEN 
					CASE WHEN t_irna_diagnosa_pulang.ICD_CODE IS NULL OR t_irna_diagnosa_pulang.ICD_CODE = ""
						THEN t_irna_diagnosa_pulang.DIAGNOSA
						ELSE t_irna_diagnosa_pulang.ICD_CODE
					END	
				END 
			ORDER BY t_irna_diagnosa_pulang.ICD_CODE)
		END AS DU,
	CASE WHEN t_irna.ST_CODING_ERM = "" OR t_irna.ST_CODING_ERM IS NULL THEN
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa.DIAGNOSA_ORDER = 1 THEN 
			CASE WHEN t_irna_diagnosa.ICD_CODE IS NULL OR t_irna_diagnosa.ICD_CODE = ""
				THEN t_irna_diagnosa.DIAGNOSA
				ELSE t_irna_diagnosa.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa.ICD_CODE) 
	ELSE 	
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa_pulang.DIAGNOSA_ORDER = 1 THEN 
			CASE WHEN t_irna_diagnosa_pulang.ICD_CODE IS NULL OR t_irna_diagnosa_pulang.ICD_CODE = ""
				THEN t_irna_diagnosa_pulang.DIAGNOSA
				ELSE t_irna_diagnosa_pulang.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa_pulang.ICD_CODE) 
	END AS DS1,
	CASE WHEN t_irna.ST_CODING_ERM = "" OR t_irna.ST_CODING_ERM IS NULL THEN
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa.DIAGNOSA_ORDER = 2 THEN 
			CASE WHEN t_irna_diagnosa.ICD_CODE IS NULL OR t_irna_diagnosa.ICD_CODE = ""
				THEN t_irna_diagnosa.DIAGNOSA
				ELSE t_irna_diagnosa.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa.ICD_CODE)
	ELSE
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa_pulang.DIAGNOSA_ORDER = 2 THEN 
			CASE WHEN t_irna_diagnosa_pulang.ICD_CODE IS NULL OR t_irna_diagnosa_pulang.ICD_CODE = ""
				THEN t_irna_diagnosa_pulang.DIAGNOSA
				ELSE t_irna_diagnosa_pulang.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa_pulang.ICD_CODE)	
	END AS DS2,
	CASE WHEN t_irna.ST_CODING_ERM = "" OR t_irna.ST_CODING_ERM IS NULL THEN	
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa.DIAGNOSA_ORDER = 3 THEN 
			CASE WHEN t_irna_diagnosa.ICD_CODE IS NULL OR t_irna_diagnosa.ICD_CODE = ""
				THEN t_irna_diagnosa.DIAGNOSA
				ELSE t_irna_diagnosa.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa.ICD_CODE) 
	ELSE 
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa_pulang.DIAGNOSA_ORDER = 3 THEN 
			CASE WHEN t_irna_diagnosa_pulang.ICD_CODE IS NULL OR t_irna_diagnosa_pulang.ICD_CODE = ""
				THEN t_irna_diagnosa_pulang.DIAGNOSA
				ELSE t_irna_diagnosa_pulang.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa_pulang.ICD_CODE) 
	END AS DS3,
	CASE WHEN t_irna.ST_CODING_ERM = "" OR t_irna.ST_CODING_ERM IS NULL THEN	
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa.DIAGNOSA_ORDER = 4 THEN 
			CASE WHEN t_irna_diagnosa.ICD_CODE IS NULL OR t_irna_diagnosa.ICD_CODE = ""
				THEN t_irna_diagnosa.DIAGNOSA
				ELSE t_irna_diagnosa.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa.ICD_CODE) 
	ELSE 
		GROUP_CONCAT(DISTINCT CASE WHEN t_irna_diagnosa_pulang.DIAGNOSA_ORDER = 4 THEN 
			CASE WHEN t_irna_diagnosa_pulang.ICD_CODE IS NULL OR t_irna_diagnosa_pulang.ICD_CODE = ""
				THEN t_irna_diagnosa_pulang.DIAGNOSA
				ELSE t_irna_diagnosa_pulang.ICD_CODE
			END	
		END 
		ORDER BY t_irna_diagnosa_pulang.ICD_CODE) 	
	END AS DS4,
	GROUP_CONCAT(DISTINCT 
			CASE WHEN t_irna_tarif.ICD_CODE IS NOT NULL 
				AND t_irna_tarif.ICD_CODE <> ""
			THEN t_irna_tarif.ICD_CODE
			END
			ORDER BY t_irna_tarif.ICD_CODE SEPARATOR "|") AS TINDAKAN
	FROM t_irna
	INNER JOIN t_irja ON (t_irna.IRNA_ID = t_irja.IRJA_ID)
	INNER JOIN m_pasien ON (t_irna.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_ruang ON (t_irna.RUANG_ID = m_ruang.RUANG_ID)
	LEFT JOIN m_jaminan ON (t_irna.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN m_pasien_pulang ON (t_irna.PASIEN_PULANG_ID = m_pasien_pulang.PASIEN_PULANG_ID) 
	LEFT JOIN m_pegawai ON (t_irna.PEGAWAI_ID = m_pegawai.PEGAWAI_ID) 
	LEFT JOIN t_irna_diagnosa ON (t_irna.IRNA_ID = t_irna_diagnosa.IRNA_ID) 
	LEFT JOIN t_irna_diagnosa_pulang ON (t_irna.IRNA_ID = t_irna_diagnosa_pulang.IRNA_ID) 
	LEFT JOIN t_irna_tarif ON (t_irna.IRNA_ID = t_irna_tarif.IRNA_ID
		AND t_irna_tarif.NO_TARIF IS NOT NULL AND t_irna_tarif.ST_BAYAR <> "Batal"
		AND t_irna.ST_BATAL IS NULL)
	LEFT JOIN (SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF
		FROM m_tarif 
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP) 
		WHERE m_tarif_group.IRNA = "1"
		AND m_tarif_group.KODE_TARIF_GROUP NOT IN ("51","49")) t_tarif
	ON (t_irna_tarif.TARIF_ID = t_tarif.TARIF_ID)	
	LEFT JOIN t_rm_tracer ON (t_irna.IRNA_ID = t_rm_tracer.IRJA_ID)		
	LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
	LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
	LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
	WHERE t_irna.NO_PENDAFTARAN IS NOT NULL AND t_irna.ST_BATAL IS NULL
	AND (t_irna.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irna.TANGGAL_DAFTAR <= ' . $tgl_filter_2 . ')';
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry_kunjungan = $qry_kunjungan . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($ruang_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.RUANG_ID = "' . $ruang_id . '"';
}

if (!empty($jaminan_id)) {
    $qry_kunjungan = $qry_kunjungan . ' AND t_irna.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

$qry_kunjungan = $qry_kunjungan . ' GROUP BY t_irna.IRNA_ID 
				ORDER BY m_pasien.NAMA_PASIEN';
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="11">Pasien Rawat Inap Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
	<tr>
        <th>No</th>
        <th>Tanggal<br />Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tanggal<br />Lahir</th>
		<th>Umur</th>
        <th>Jenis Kelamin</th>
        <th>Alamat</th>
		<th>Domisili</th>
		<th>Kunjungan</th>
		<th>Jumlah<br/>Kunjungan</th>
		<th>Nama Dokter</th>
        <th>Ruang</th>
		<th>Kelas</th>
        <th>Pembayaran</th>
		<th>DU</th>
		<th>DS</th>
		<th>DS</th>
		<th>DS</th>
		<th>DS</th>
		<th>Tindakan I</th>
		<th>Tindakan II</th>
		<th>Tindakan III</th>
		<th>Tindakan IV</th>
		<th>Tanggal<br />Pulang</th>
		<th>Status</th>
		<th>Los</th>
		<th>Keterangan</th>
    </tr>
	<?php $rs = mysql_query($qry_kunjungan) or die(mysql_error());
			$i = 1;
			while ($data = mysql_fetch_array($rs)) {
	?>
        <tr>
			<td align="center"><?php echo $i; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
			<td><?php echo getUmurDaftar($data['TGL_LAHIR'],$data['TANGGAL_DAFTAR2']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php echo $data['ALAMAT']; ?></td>
			<td><?php echo $data['NAMA_KOTA']; ?></td>
			<td><?php if($data['ST_BARU_LAMA'] == 'v') echo 'Baru'; ?></td>
			<td><?php echo $data['KUNJ_KE']; ?></td>
			<td><?php echo $data['NAMA_PEGAWAI']; ?></td>
            <td><?php echo $data['NAMA_RUANG']; ?></td>
			<td align="center"><?php echo $data['KELAS_RAWAT']; ?></td>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td><?php echo $data['DU']; ?></td>
			<td><?php echo $data['DS1']; ?></td>
			<td><?php echo $data['DS2']; ?></td>
			<td><?php echo $data['DS3']; ?></td>
			<td><?php echo $data['DS4']; ?></td>
			<td><?php $arr_tindakan = explode('|',$data['TINDAKAN']); 
				if(isset($arr_tindakan[0])) echo $arr_tindakan[0]; ?></td>
			<td><?php if(isset($arr_tindakan[1])) echo $arr_tindakan[1]; ?></td>	
			<td><?php if(isset($arr_tindakan[2])) echo $arr_tindakan[2]; ?></td>
			<td><?php if(isset($arr_tindakan[3])) echo $arr_tindakan[3]; ?></td>
			<td align="center"><?php echo changeDateFormat($data['PASIEN_KELUAR']); ?></td>
			<td><?php echo $data['KET_PASIEN_PULANG']; ?></td>
			<td><?php echo $data['LOS'] + 1; ?></td>
			<td align="center">&nbsp;</td>
        </tr>
	<?php $i++;
	} ?>	
</table>