<style>
thead th, thead td{text-align:center;}
thead tr:last{border-bottom :1px solid #999;}
</style>

<div align="center">
<div id="frame">
    <div id="frame_title"><h3>Laporan RL 3.8</h3></div>


<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td rowspan="2" style="width:110px;"><img src="<?php echo _BASE_;?>/img/logobaktihusda.gif"></td><td><h2>Formulir 3.8</h2></td><td rowspan="2"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>KEGIATAN LABORATORIUM</h1></td></tr>
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
                <tr><td colspan="2"><input type="submit" name="submit" value="Prosess"> <input type="submit" name="submit" value="Export to Excel"></td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <!--<tr><td colspan="2"><h2>RL 1.2 Indikator Pelayanan Rumah Sakit</h2></td></tr>-->
			</table>
				<input type="hidden" name="link" value="rl38">
			</form>
			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			<thead>
				<tr><th>NO</th><th>JENIS KEGIATAN</th><th>JUMLAH</th></tr>
				<tr><td>1</td><td>2</td><td>3</td></tr>
			</thead>
			<tbody>
				<?php
				
				$sql	= mysql_query('SELECT a.kode_tindakan, a.nama_tindakan, COUNT(b.kode) AS jumlah
FROM m_tarif2012 a 
LEFT JOIN t_orderlab b ON a.kode_tindakan = b.KODE AND YEAR(b.TANGGAL) = '.$tahun.'
WHERE a.kode_tindakan LIKE "06.01%" 
GROUP BY a.kode_tindakan');
				if(mysql_num_rows($sql) > 0)
				{
					$i	= 1;
					while($data	= mysql_fetch_array($sql))
					{
						echo '<tr><td align="center">'.$i.'</td><td>'.$data['nama_tindakan'].'</td><td align="right">'.$data['jumlah'].'</td></tr>';
						$i++;
					}
				}
				?>
				<tr><td align="center">99</td><td>TOTAL</td><td></td></tr>
			</tbody>
			</table>
			<form action="rm/rl38_xls.php" method="get">
				<input type="hidden" name="tahun" id="tahun" value=<?php echo $tahun?> />
				<input type="submit" value="export xls"  />
			</form>
        </td>
    </tr>
</table>
</div>
</div>