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
				<tr><td rowspan="2" style="width:110px;"><img src="image/logobaktihusda.gif"></td><td><h2>Formulir 2.B</h2></td><td rowspan="2" align="center"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>DATA KEADAAN MORBIDITAS PASIEN RAWAT JALAN RUMAH SAKIT</h1></td></tr>
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
				<!--<tr><td width="200"> Kode RS </td><td  width="200">: <input type="text" name="kode_rs" class="text_dt" size="22" value="<?php echo $rs_kode;?>" /></td><td>&nbsp;</td></tr>
                <tr><td> Nama RS </td><td>: <input type="text" name="nama_rs" class="text_dt" size="22" value="<?php echo $rs_nama;?>" /></td><td>&nbsp;</td></tr>-->
                <tr><td> Tahun </td><td width="200">: <select name="tahun" id="tahun" class="text_dt" style="width:155px;" >
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
				<tr>
    <th rowspan="3">NO</th>
    <th rowspan="3">NODTD</th>
    <th rowspan="3">NO.DAFTARTERPERINCI</th>
    <th rowspan="3">GOLONGAN SEBAB-SEBAB SAKIT</th>
    <th colspan="8">PASIEN KELUAR (HIDUP &amp;  MATI) MENURUT GOLONGAN UMUR</th>
    <th colspan="2">PASIEN KEL(H &amp; M) ME-NURUT SEX</th>
    <th rowspan="2"><p>JML</p>
      <p>PASIEN</p>
      <p>KELUAR</p></th>
    <th rowspan="3"><p>JML</p>
      <p>PASIEN</p>
      <p>KEL.MATI</p></th>
  </tr>
  
  <tr>
    <th rowspan="2">0-28HR</th>
    <th rowspan="2">28 HR-&lt;1TH</th>
    <th rowspan="2">1-4TH</th>
    <th rowspan="2">5-14TH</th>
    <th rowspan="2">15-24TH</th>
    <th rowspan="2">25-44TH</th>
    <th rowspan="2">45-64TH</th>
    <th rowspan="2">65+TH</th>
    <th rowspan="2">LK</th>
    <th rowspan="2">PR</th>
    </tr>
  <tr>
    <th>(13+14)</th>
    </tr>
  <tr>
    <th>1</th>
    <th>2</th>
    <th>3</th>
    <th>4</th>
    <th>5</th>
    <th>6</th>
    <th>7</th>
    <th>8</th>
    <th>9</th>
    <th>10</th>
    <th>11</th>
    <th>12</th>
    <th>13</th>
    <th>14</th>
    <th>15</th>
    <th>16</th>
  </tr>
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
				<tr><td align="center">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
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
    <input type="hidden" name="xlsfile" value="report/xls_rl2b.php" />
    <input type="hidden" name="xlsname" value="rpt_rl2b.xls" />            
</form>