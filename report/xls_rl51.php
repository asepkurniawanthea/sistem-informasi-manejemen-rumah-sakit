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
				<tr><td rowspan="2" style="width:110px;"><img src="./image/logobaktihusda.gif"></td><td><h2>Formulir 5.1</h2></td><td rowspan="2" align="center"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>PENGUNJUNG</h1></td></tr>
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
				<tr><th>NO</th><th>NAMA KEGIATAN</th><th>JUMLAH</th></tr>
				<tr><td>1</td><td>2</td><td>3</td></tr>
			</thead>
			<tbody>
				<?php
				$sql	= mysql_query('SELECT COUNT(CASE WHEN PENGUNJUNG > 0 THEN NOMR END) AS pasienbaru,
						COUNT(CASE WHEN PENGUNJUNG = 0 THEN NOMR END) AS pasienlama FROM
						(SELECT NOMR, SUM(CASE WHEN ST_BARU = "1" THEN 1 ELSE 0 END) AS PENGUNJUNG
						FROM t_irja WHERE YEAR(TANGGAL_DAFTAR) = ' . $_POST['tahun'] . ' AND MONTH(TANGGAL_DAFTAR) = ' . $_POST['bulan'] . '
						AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL
						GROUP BY NOMR) t_tran') or die(mysql_error());
				$row	= mysql_fetch_array($sql);
				?>
				<tr align="center"><td width="20px">1</td><td width="220px">Pengunjung Baru</td><td align="right"><?php echo currFormat($row['pasienbaru'],0);?></td></tr>
				<tr align="center"><td width="20px">2</td><td width="220px">Pengunjung Lama</td><td align="right"><?php echo currFormat($row['pasienlama'],0);?></td></tr>
			</tbody>
			</table>
        </td>
    </tr>
</table>