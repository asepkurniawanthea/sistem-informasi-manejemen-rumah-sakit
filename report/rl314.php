<style>
thead th, thead td{text-align:center;}
thead tr:last{border-bottom :1px solid #999;}
</style>
<div align="center">
<div id="frame">
    <div id="frame_title"><h3>Laporan RL 3.14</h3></div>


<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td rowspan="2" style="width:110px;"><img src="<?php echo _BASE_;?>/img/logobaktihusda.gif"></td><td><h2>Formulir 3.14</h2></td><td rowspan="2"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>KEGIATAN RUJUKAN</h1></td></tr>
			</table>
			

			
			<form action="<?php $_SERVER['PHP_SELF'];?>" method="get">
			<?php 
				$date = date('Y') - 10;
				$koders	= isset($_REQUEST['kode_rs']) ? $_REQUEST['kode_rs'] : '';
				$namars	= isset($_REQUEST['nama_rs']) ? $_REQUEST['nama_rs'] : '';
				$tahun	= isset($_REQUEST['tahun']) ? $_REQUEST['tahun'] : date('Y');
				
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
				<input type="hidden" name="link" value="rl314">
			</form>

			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			<thead>
				<tr><th rowspan="2">NO</th><th rowspan="2">JENIS SPESIALISASI</th><th colspan="6">RUJUKAN</th><th colspan="3">DIRUJUK</th></tr>
				<tr><th>DITERIMA DARI PUSKESMAS</th><th>DITERIMA DARI FASILITAS KES. LAIN</th><th>DITERIMA DARI RS LAIN</th><th>DIKEMBALIKAN KE PUSKESMAS</th><th>DIKEMBALIKAN KE FASILITAS KES. LAIN</th><th>DIKEMBALIKAN KE RS LAIN</th><th>PASIEN RUJUKAN</th><th>PASIEN DATANG SENDIRI</th><th>DITERIMA KEMBALI</th></tr>
				<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td></tr>
			</thead>
			<tbody>
				<?php
				$sql	= mysql_query('SELECT a.kode_unit, a.nama_unit, SUM(IF(b.KDRUJUK = 2,1,0)) AS puskesmas, SUM(IF(b.KDRUJUK = 3,1,0)) AS rslain, 
SUM(IF(b.KDRUJUK = 4,1,0)) AS faslain, SUM(IF(b.status > 1 AND b.KDRUJUK > 1,1,0)) AS pasienrujukan,
SUM(IF(b.status > 1 AND b.KDRUJUK = 1,1,0)) AS pasienaps
FROM m_unit a 
LEFT JOIN t_pendaftaran b ON b.KDPOLY = a.kode_unit
WHERE a.kode_unit <> 0 AND a.kode_unit <> 14 AND a.kode_unit <> 32  AND YEAR(b.TGLREG) = '.$tahun.'
GROUP BY a.kode_unit');
				$tpuskesmas	= 0;
				$tfaslain	= 0;
				$trslain	= 0;
				$tkmpuskesmas	= 0;
				$tkmfaslain		= 0;
				$tkmrslain		= 0;
				$trujukan		= 0;
				$taps			= 0;
				$tkembali		= 0;
				if(mysql_num_rows($sql) > 0)
				{
					$i	= 1;
					while($data	= mysql_fetch_array($sql))
					{
						$tpuskesmas	= $tpuskesmas + $data['puskesmas'];
						$tfaslain	= $tfaslain	+ $data['faslain'];
						$trslain	= $trslain	+ $data['rslain'];
						$trujukan	= $trujukan + $data['pasienrujukan'];
						$taps		= $taps		+ $data['pasienaps'];
						echo '<tr><td align="center">'.$i.'</td><td>'.$data['nama_unit'].'</td>
						<td align="right">'.$data['puskesmas'].'</td>
						<td align="right">'.$data['faslain'].'</td>
						<td align="right">'.$data['rslain'].'</td>
						<td align="right">0</td>
						<td align="right">0</td>
						<td align="right">0</td>
						<td align="right">'.$data['pasienrujukan'].'</td>
						<td align="right">'.$data['pasienaps'].'</td>
						<td align="right">0</td></tr>';
						$i++;
					}
				}
				echo '<tr><td>99</td><td>TOTAL</td>
					<td align="right">'.$tpuskesmas.'</td>
					<td align="right">'.$tfaslain.'</td>
					<td align="right">'.$trslain.'</td>
					<td align="right">'.$tkmpuskesmas.'</td>
					<td align="right">'.$tkmfaslain.'</td>
					<td align="right">'.$tkmrslain.'</td>
					<td align="right">'.$trujukan.'</td>
					<td align="right">'.$taps.'</td>
					<td align="right">'.$tkembali.'</td></tr>';
				?>
			</tbody>
			</table>
			<form action="rm/rl314_xls.php" method="get">
				<input type="hidden" name="tahun" id="tahun" value=<?php echo $tahun?> />
				<input type="submit" value="export xls"  />
			</form>
        </td>
    </tr>
</table>
</div>
</div>