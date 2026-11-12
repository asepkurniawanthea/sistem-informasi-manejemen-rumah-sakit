<?php 
include('./config/config.php');
include('./shared/connect_db.php');
include('./shared/function.php');

$blnname	= array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
?>
<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
			<table border="0">
				<tr><td rowspan="2" style="width:110px;"><img src="./image/logobaktihusda.gif"></td><td><h2>Formulir 5.4</h2></td><td rowspan="2" align="center"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>Daftar 10 Besar Penyakit Rawat Jalan</h1></td></tr>
			</table>
			<table border="0">
				<tr><td width="200"> Kode RS </td><td  width="200">:&nbsp;<?php echo $rs_kode;?></td><td>&nbsp;</td></tr>
                <tr><td> Nama RS </td><td>:&nbsp;<?php echo $rs_nama;?></td><td>&nbsp;</td></tr>
                <tr><td> Tahun </td><td>:&nbsp;<?php echo $_POST['tahun']; ?></td><td>&nbsp;</td></tr>
				<tr><td> Bulan </td><td>:&nbsp;<?php echo $blnname[$_POST['bulan'] - 1]; ?></td><td>&nbsp;</td></tr>
			</table>
			<br />
			<table border="1" width="95%">
			<thead>
				<tr><th rowspan="2">No</th><th rowspan="2">Kode ICD</th><th rowspan="2">Deskripsi</th><th colspan="2">Kasus Baru Menurut Jenis Kelamin</th><th rowspan="2">Jumlah Kasus Baru</th><th rowspan="2">Jumlah Kunjungan</th></tr>
				<tr><th>Lk</th><th>Pr</th></tr>
				<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td></tr>
			</thead>
			<tbody>
				<?php
				$sql	= mysql_query('SELECT * FROM (SELECT m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI,
								COUNT(t_irja_diagnosa.IRJA_DIAGNOSA_ID) AS JML_PENYAKIT,
								COUNT(DISTINCT t_irja.IRJA_ID) AS KUNJUNGAN,
								COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "L" THEN t_irja_diagnosa.IRJA_DIAGNOSA_ID END) AS JML_PENYAKIT_LK,
								COUNT(CASE WHEN m_pasien.JNS_KELAMIN = "P" THEN t_irja_diagnosa.IRJA_DIAGNOSA_ID END) AS JML_PENYAKIT_PR
								FROM 
								t_irja_diagnosa
								INNER JOIN t_irja ON (t_irja_diagnosa.IRJA_ID = t_irja.IRJA_ID)
								INNER JOIN m_icd_x ON (t_irja_diagnosa.ICD_CODE = m_icd_x.ICD_CODE)
								INNER JOIN m_pasien ON (t_irja.NOMR = m_pasien.NOMR)
								WHERE t_irja.NO_PENDAFTARAN IS NOT NULL
								AND t_irja.ST_BATAL IS NULL
								AND YEAR(TANGGAL_DAFTAR) = ' . $_POST['tahun'] . ' AND MONTH(TANGGAL_DAFTAR) = ' . $_POST['bulan'] . '
								GROUP BY m_icd_x.ICD_CODE,m_icd_x.DESKRIPSI
								) t_tran ORDER BY JML_PENYAKIT DESC LIMIT 10') or die(mysql_error());
				$i = 1;
				while($row	= mysql_fetch_array($sql)){
				?>
				<tr><td align="center" width="20px"><?php echo $i; ?></td><td width="160px"><?php echo $row['ICD_CODE']; ?></td>
				<td><?php echo $row['DESKRIPSI']; ?></td>
				<td align="right"><?php echo currFormat($row['JML_PENYAKIT_LK']); ?></td>
				<td align="right"><?php echo currFormat($row['JML_PENYAKIT_PR']); ?></td>
				<td align="right"><?php echo currFormat($row['JML_PENYAKIT']); ?></td>
				<td align="right"><?php echo currFormat($row['KUNJUNGAN']); ?></td></tr>
				<?php $i++; } ?>
			</tbody>
			</table>
        </td>
    </tr>
</table>