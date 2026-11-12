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

$qry = 'SELECT t_irja.IRJA_ID, t_irja.NOMR, t_irja.TANGGAL_DAFTAR,
	DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%d/%m/%Y") AS TANGGAL_DAFTAR2,
	CASE t_irja.ST_BARU
	WHEN "1" THEN "v" END AS ST_BARU_LAMA,
	CASE t_irja.ST_RUJUKAN
	WHEN "1" THEN "v" END AS ST_RUJUKAN,
	m_unit.NAMA_UNIT,m_jaminan.NAMA_JAMINAN,m_pasien.NAMA_PASIEN,
	m_pasien.TGL_LAHIR,
	DATE_FORMAT(m_pasien.TGL_LAHIR,"%d/%m/%Y") AS TGL_LAHIR2,
	m_pasien.JNS_KELAMIN,m_pasien.ALAMAT,m_pasien.NAMA_IBU,
	m_pasien.ALAMAT_RT,m_pasien.ALAMAT_RW,m_kelurahan.NAMA_KELURAHAN,
	m_kecamatan.NAMA_KECAMATAN,m_kota.NAMA_KOTA,
	t_irja.USER_RM,t_irja.PRINT_TRACER,t_irja.PRINT_RRKRJ,t_rm_tracer.RM_TRACER_ID,
	(
		SELECT COUNT(x.IRJA_ID) FROM t_irja x
		WHERE x.NOMR = t_irja.NOMR 
		AND DATE_FORMAT(x.TANGGAL_DAFTAR,"%m%Y") = DATE_FORMAT(t_irja.TANGGAL_DAFTAR,"%m%Y") 
		AND x.IRJA_ID < t_irja.IRJA_ID
	)+1 AS KUNJ_KE,
	m_pegawai.NAMA_PEGAWAI,
	GROUP_CONCAT(DISTINCT CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 0 THEN 
		CASE WHEN t_irja_diagnosa.ICD_CODE IS NULL OR t_irja_diagnosa.ICD_CODE = ""
			THEN t_irja_diagnosa.DIAGNOSA
			ELSE t_irja_diagnosa.ICD_CODE
		END	
	END 
	ORDER BY t_irja_diagnosa.ICD_CODE) AS DU,
	GROUP_CONCAT(DISTINCT CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 1 THEN 
		CASE WHEN t_irja_diagnosa.ICD_CODE IS NULL OR t_irja_diagnosa.ICD_CODE = ""
			THEN t_irja_diagnosa.DIAGNOSA
			ELSE t_irja_diagnosa.ICD_CODE
		END	
	END 
	ORDER BY t_irja_diagnosa.ICD_CODE) AS DS1,
	GROUP_CONCAT(DISTINCT CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 2 THEN 
		CASE WHEN t_irja_diagnosa.ICD_CODE IS NULL OR t_irja_diagnosa.ICD_CODE = ""
			THEN t_irja_diagnosa.DIAGNOSA
			ELSE t_irja_diagnosa.ICD_CODE
		END	
	END 
	ORDER BY t_irja_diagnosa.ICD_CODE) AS DS2,
	GROUP_CONCAT(DISTINCT CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 3 THEN 
		CASE WHEN t_irja_diagnosa.ICD_CODE IS NULL OR t_irja_diagnosa.ICD_CODE = ""
			THEN t_irja_diagnosa.DIAGNOSA
			ELSE t_irja_diagnosa.ICD_CODE
		END	
	END 
	ORDER BY t_irja_diagnosa.ICD_CODE) AS DS3,
	GROUP_CONCAT(DISTINCT CASE WHEN t_irja_diagnosa.DIAGNOSA_ORDER = 4 THEN 
		CASE WHEN t_irja_diagnosa.ICD_CODE IS NULL OR t_irja_diagnosa.ICD_CODE = ""
			THEN t_irja_diagnosa.DIAGNOSA
			ELSE t_irja_diagnosa.ICD_CODE
		END	
	END 
	ORDER BY t_irja_diagnosa.ICD_CODE) AS DS4,
	GROUP_CONCAT(DISTINCT 
			CASE WHEN t_irja_tarif.ICD_CODE IS NOT NULL 
				AND t_irja_tarif.ICD_CODE <> ""
			THEN t_irja_tarif.ICD_CODE
			END
			ORDER BY t_irja_tarif.ICD_CODE SEPARATOR "|") AS TINDAKAN,
	MAX(t_irja_diagnosa.KASUS_BARU) AS KASUS_BARU		
	FROM t_irja
	INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR) 
	LEFT JOIN m_unit ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
	LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
	LEFT JOIN m_jaminan ON (t_irja.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
	LEFT JOIN t_rm_tracer ON (t_irja.IRJA_ID = t_rm_tracer.IRJA_ID)
	LEFT JOIN m_kelurahan ON (m_pasien.KELURAHAN_ID = m_kelurahan.KELURAHAN_ID)
	LEFT JOIN m_kecamatan ON (m_pasien.KECAMATAN_ID = m_kecamatan.KECAMATAN_ID)
	LEFT JOIN m_kota ON (m_pasien.KOTA_ID = m_kota.KOTA_ID)
	LEFT JOIN t_irja_diagnosa ON (t_irja.IRJA_ID = t_irja_diagnosa.IRJA_ID) 
	LEFT JOIN t_irja_tarif ON (t_irja.IRJA_ID = t_irja_tarif.IRJA_ID
		AND t_irja_tarif.NO_TARIF IS NOT NULL AND t_irja_tarif.ST_BAYAR <> "Batal"
		AND t_irja.ST_BATAL IS NULL)
	LEFT JOIN (SELECT m_tarif.TARIF_ID,m_tarif.NAMA_TARIF
		FROM m_tarif 
		INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP) 
		WHERE (m_tarif_group.NON_KELAS = "1" OR m_tarif_group.ONE_DAY_CARE = "1")
		AND m_tarif_group.KODE_TARIF_GROUP NOT IN ("01")) t_tarif
	ON (t_irja_tarif.TARIF_ID = t_tarif.TARIF_ID)
	
	WHERE t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL 
	AND t_irja.TANGGAL_DAFTAR >= ' . $tgl_filter_1 . ' AND t_irja.TANGGAL_DAFTAR <= ' . $tgl_filter_2;
	
if(!empty($searchkey)){
	$searchkey = str_replace(' ', '%', $searchkey);
	$qry = $qry . ' AND CONCAT(m_pasien.NOMR,m_pasien.NAMA_PASIEN) LIKE "%' . $searchkey . '%"';
}	
if (!empty($unit_id)) {
    $qry = $qry . ' AND t_irja.UNIT_ID = "' . $unit_id . '"';
}

if (!empty($jaminan_id)) {
    $qry = $qry . ' AND t_irja.JENIS_BAYAR_ID = "' . $jaminan_id . '"';
}

$qry = $qry . ' GROUP BY t_irja.IRJA_ID
ORDER BY m_pasien.NAMA_PASIEN,m_pasien.NOMR';	
?>
<table width="100%" border="1" >
	<tr>
		<th colspan="23">Pasien Rawat Jalan Tanggal <?php echo $tgl_1; ?> Sampai <?php echo $tgl_2; ?></th>
	</tr>	
	<tr>
        <th>No</th>
        <th>Tanggal Daftar</th>
        <th>Nomor MR</th>
        <th>Nama Pasien</th>
        <th>Tgl Lahir</th>
		 <th>Umur</th>
        <th>Jns Kelamin</th>
		 <th>Domisili</th>
        <th>Kunjungan</th>
		 <th>Kasus Baru/Lama</th>
		 <th>Kunjungan Ke/Bulan</th>
        <th>Klinik</th>
        <th>DPJP</th>
		 <th>DU</th>
		 <th>DS</th>
		 <th>DS</th>
		 <th>DS</th>
		 <th>DS</th>
		<th>Tindakan I</th>
		<th>Tindakan II</th>
		<th>Tindakan III</th>
		<th>Pembayaran</th>
		<th>Keterangan</th>
    </tr>
	<?php $rs = mysql_query($qry) or die(mysql_error());
			$i = 1;
			while ($data = mysql_fetch_array($rs)) {
	?>
        <tr>
            <td align="center"><?php echo $i; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TANGGAL_DAFTAR']); ?></td>
            <td align="center"><?php echo formatNoMR($data['NOMR']); ?></td>
            <td><?php echo $data['NAMA_PASIEN']; ?></td>
            <td align="center"><?php echo changeDateFormat($data['TGL_LAHIR']); ?></td>
			  <td><?php echo getUmurDaftar($data['TGL_LAHIR2'],$data['TANGGAL_DAFTAR2']); ?></td>
            <td><?php echo jenisKelamin($data['JNS_KELAMIN']); ?></td>
            <td><?php 
				$domisili= '';
				/*$domisili = $data['ALAMAT'];
				if($data['ALAMAT_RT'] != '') $domisili .= ' Rt.' . $data['ALAMAT_RT'];
				if($data['ALAMAT_RW'] != '') $domisili .= ' Rw.' . $data['ALAMAT_RW'];
				if($data['NAMA_KELURAHAN'] != '') $domisili .= ' ' . $data['NAMA_KELURAHAN'];
				if($data['NAMA_KECAMATAN'] != '') $domisili .= ' ' . $data['NAMA_KECAMATAN'];*/
				if($data['NAMA_KOTA'] != '') $domisili .= ' ' . $data['NAMA_KOTA'];
				echo $domisili; ?></td>
            <td><?php if($data['ST_BARU_LAMA'] == 'v') echo 'Baru'; ?></td>
			<td><?php if($data['KASUS_BARU'] == '1') echo 'Kasus Baru'; ?></td>
            <td><?php echo $data['KUNJ_KE']; ?></td>
			 <td><?php echo $data['NAMA_UNIT']; ?></td>
			  <td><?php echo $data['NAMA_PEGAWAI']; ?></td>
			<td><?php echo $data['DU']; ?></td>
			<td><?php echo $data['DS1']; ?></td>
			<td><?php echo $data['DS2']; ?></td>
			<td><?php echo $data['DS3']; ?></td>
			<td><?php echo $data['DS4']; ?></td>
			<td><?php $arr_tindakan = explode('|',$data['TINDAKAN']); 
				if(isset($arr_tindakan[0])) echo $arr_tindakan[0]; ?></td>
			<td><?php if(isset($arr_tindakan[1])) echo $arr_tindakan[1]; ?></td>	
			<td><?php if(isset($arr_tindakan[2])) echo $arr_tindakan[2]; ?></td>
			<td><?php echo $data['NAMA_JAMINAN']; ?></td>
			<td>&nbsp;</td>
        </tr>
	<?php $i++;
	} ?>	
</table>