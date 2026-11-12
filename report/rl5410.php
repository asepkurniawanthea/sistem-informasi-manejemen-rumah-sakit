<style>
thead th, thead td{text-align:center;}
thead tr:last{border-bottom :1px solid #999;}
</style>
<br />
<div align="center">
<div id="frame">
<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0" border="0">
				<tr><td rowspan="2" style="width:110px;"><img src="image/logobaktihusda.gif"></td><td><h2>Formulir 5.4</h2></td><td rowspan="2" align="center"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>Daftar 10 Besar Penyakit Rawat Jalan</h1></td></tr>
			</table>
			

			<form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
			<?php 
				$date = date('Y') - 10;
				$koders	= isset($_REQUEST['kode_rs']) ? $_REQUEST['kode_rs'] : '';
				$namars	= isset($_REQUEST['nama_rs']) ? $_REQUEST['nama_rs'] : '';
				$tahun	= isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');
				$bulan	= isset($_REQUEST['bulan']) ? $_REQUEST['bulan'] : date('m');
				
				$blnname	= array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			?>
			<table cellpadding="0" class="tb" width="95%" cellspacing="0" border="0">
				<tr><td width="200"> Kode RS </td><td  width="200">: <input type="text" name="kode_rs" class="text_dt" size="22" value="<?php echo $rs_kode;?>" /></td><td>&nbsp;</td></tr>
                <tr><td> Nama RS </td><td>: <input type="text" name="nama_rs" class="text_dt" size="22" value="<?php echo $rs_nama;?>" /></td><td>&nbsp;</td></tr>
                <tr><td> Tahun </td><td>: <select name="tahun" id="tahun" class="text_dt" style="width:155px;" >
											<?php
											for($i=$date; $i<=date('Y'); $i++)
											{
												$selected	= ($i == $tahun) ? 'selected="selected"' : date('Y') ;
												echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
											}
											?>
										  </select></td><td>&nbsp;</td></tr>
				<tr><td> Bulan </td><td>: <select name="bulan" id="bulan" class="text_dt" style="width:155px;" >
											<?php
											for($i=1; $i<=12; $i++)
											{
												$namabulan	= $blnname[$i - 1];
												$selected_bulan	= ($i == $bulan) ? 'selected="selected"' : date('m') ;
												echo '<option value="'.$i.'" '.$selected_bulan.'>'.$namabulan.'</option>';
											}
											?>
										  </select></td><td><input type="submit" name="submit" value="proses" class="myButton1" >
										  <input type="button" value="export excel" class="myButton" onclick="document.getElementById('xls_export').submit(); return false;" />
										  </td></tr>
			</table>
				<input type="hidden" name="link" value="<?php echo $_REQUEST['link']; ?>">
			</form>
			<br />
			<table cellspacing="1" cellpadding="1" class="tableData" width="95%">
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
								AND YEAR(TANGGAL_DAFTAR) = ' . $tahun . ' AND MONTH(TANGGAL_DAFTAR) = ' . $bulan . '
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
<br />
</div>
</div>
 <form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
    <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
    <input type="hidden" name="xlsfile" value="report/xls_rl5410.php" />
    <input type="hidden" name="xlsname" value="rpt_rl5410.xls" />            
</form>