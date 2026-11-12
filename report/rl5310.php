<style>
thead th, thead td{text-align:center;}
thead tr:last{border-bottom :1px solid #999;}
</style>
<div align="center">
<div id="frame">
    <div id="frame_title"><h3>Laporan RL 5.3</h3></div>


<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td rowspan="2" style="width:110px;"><img src="<?php echo _BASE_;?>/img/logobaktihusda.gif"></td><td><h2>Formulir 5.3</h2></td><td rowspan="2"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>Daftar 10 Besar Penyakit Rawat Inap</h1></td></tr>
			</table>
			

			<form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
			<?php 
				$date = date('Y') - 10;
				$koders	= isset($_REQUEST['kode_rs']) ? $_REQUEST['kode_rs'] : '';
				$namars	= isset($_REQUEST['nama_rs']) ? $_REQUEST['nama_rs'] : '';
				$tahun	= isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');
				
				$blnname	= array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
			?>
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td> Kode RS </td><td>: <input type="text" name="kode_rs" class="inputrl12" value="<?php echo $koders;?>" /></td></tr>
                <tr><td> Nama RS </td><td>: <input type="text" name="nama_rs" class="inputrl12" value="<?php echo $namars;?>" /></td></tr>
                <tr><td> Tahun </td><td>: <select name="tahun" id="tahun" class="selectbox">
											<?php
											for($i=$date; $i<=date('Y'); $i++)
											{
												$selected	= ($i == $tahun) ? 'selected="selected"' : date('Y') ;
												echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
											}
											?>
										  </select></td></tr>
                <tr><td colspan="2"><input type="submit" name="submit" value="Prosess"></td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <!--<tr><td colspan="2"><h2>RL 1.2 Indikator Pelayanan Rumah Sakit</h2></td></tr>-->
			</table>
				<input type="hidden" name="link" value="rl5310">
			</form>

			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			<thead>
				<tr><th rowspan="2">NO URUT</th><th rowspan="2">ICD</th><th rowspan="2">DESKRIPSI</th><th colspan="2">Pasien Keluar (Hidup & Mati) Menurut Jenis Kelamin</th><th rowspan="2">Jumlah Pasien Keluar Hidup</th><th rowspan="2">Jumlah Pasien Keluar Mati</th></tr>
				<tr><th>LK</th><th>PR</th></tr>
				<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td></tr>
			</thead>
			<tbody>
				<?php
				$sql = mysql_query("SELECT a.NOMR,a.ICD_CODE,b.jenis_penyakit, COUNT(a.ICD_CODE) AS jumlah, SUM(IF(c.JENISKELAMIN = 'P',1,0)) AS pr, SUM(IF(c.JENISKELAMIN = 'L',1,0)) AS lk
,SUM(IF(KDTUJUANRUJUK <> 2 OR KDTUJUANRUJUK <> 6, 1, 0)) AS hidup, SUM(IF(KDTUJUANRUJUK = 2 OR KDTUJUANRUJUK = 6, 1, 0)) AS mati
FROM t_diagnosadanterapi a
JOIN icd b ON a.icd_code=b.icd_code 
JOIN m_pasien c ON a.NOMR = c.NOMR
WHERE YEAR(a.TANGGAL) = ".$tahun."
GROUP BY a.ICD_CODE ORDER BY jumlah DESC LIMIT 10");
				if(mysql_num_rows($sql) > 0)
				{
					while($data = mysql_fetch_array($sql)){
						echo '<tr><td>1</td><td>'.$data['ICD_CODE'].'</td><td>'.$data['jenis_penyakit'].'</td><td>'.$data['lk'].'</td><td>'.$data['pr'].'</td><td>'.$data['hidup'].'</td><td>'.$data['mati'].'</td></tr>';
					}
				}
				?>
			</tbody>
			</table>
			<form action="rm/rl5310_xls.php" method="get">
			<input type="hidden" name="tahun" id="tahun" value=<?php echo $tahun?> />
			<input type="submit" value="export xls"  />
			</form>
        </td>
    </tr>
</table>
</div>
</div>