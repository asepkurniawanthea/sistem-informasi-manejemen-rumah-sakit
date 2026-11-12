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
				<tr><td rowspan="2" style="width:110px;"><img src="./image/logobaktihusda.gif"></td><td><h2>Formulir 5.2</h2></td><td rowspan="2" align="center"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>KUNJUNGAN RAWAT JALAN</h1></td></tr>
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
				$sql	= mysql_query('SELECT m_unit.UNIT_ID,m_unit.NAMA_UNIT,COUNT(t_irja.IRJA_ID) AS KUNJUNGAN
								FROM m_unit
								LEFT JOIN t_irja ON (m_unit.UNIT_ID = t_irja.UNIT_ID
								AND YEAR(t_irja.TANGGAL_DAFTAR) = ' . $_POST['tahun'] . ' AND MONTH(t_irja.TANGGAL_DAFTAR) = ' . $_POST['bulan'] . '
								AND t_irja.NO_PENDAFTARAN IS NOT NULL AND t_irja.ST_BATAL IS NULL)
								WHERE m_unit.IRJA IS NOT NULL
								GROUP BY m_unit.UNIT_ID,m_unit.NAMA_UNIT ORDER BY m_unit.NAMA_UNIT') or die(mysql_error());
				$i = 1;
				while($row	= mysql_fetch_array($sql)){
				?>
				<tr><td align="center" width="20px"><?php echo $i; ?></td><td width="220px"><?php echo $row['NAMA_UNIT']; ?></td><td align="right"><?php echo currFormat($row['KUNJUNGAN']); ?></td></tr>
				<?php $i++; } ?>
			</tbody>
			</table>
        </td>
    </tr>
</table>