<style>
thead th, thead td{text-align:center;}
thead tr:last{border-bottom :1px solid #999;}
</style>
<div align="center">
<div id="frame">
    <div id="frame_title"><h3>Laporan RL 3.13</h3></div>


<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td rowspan="2" style="width:110px;"><img src="<?php echo _BASE_;?>/img/logobaktihusda.gif"></td><td><h2>Formulir 3.13</h2></td><td rowspan="2"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>PENGADAAN OBAT, PENULISAN DAN PELAYANAN RESEP</h1></td></tr>
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
				<input type="hidden" name="link" value="rl313">
			</form>
			<p style="text-align:left; width:95%; margin:0 auto; font-weight:bold;" > A. Pengadaan Obat</p>
			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			<thead>
				<tr><th>NO</th><th>GOLONGAN OBAT</th><th>JUMLAH ITEM OBAT</th><th>JUMLAH ITEM OBAT YANG TERSEDIA di RUMAH SAKIT</th><th>JUMLAH ITEM OBAT FORMULATORIUM TERSEDIA DIRUMAH SAKIT</th></tr>
				<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>
			</thead>
			<tbody>
				<tr><td>1</td><td>OBAT GENERIK</td><td></td><td></td><td></td></tr>
				<tr><td>2</td><td>Obat Non Generik Formulatorium</td><td></td><td></td><td></td></tr>
				<tr><td>3</td><td>Obat Non Generik</td><td></td><td></td><td></td></tr>
				<tr><td>99</td><td>TOTAL</td><td></td><td></td><td></td></tr>
				
			</tbody>
			</table>
			
			<p style="text-align:left; width:95%; margin:0 auto; font-weight:bold;" > B. Penulisan dan Pelayanan Resep</p>
			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			<thead>
				<tr><th>NO</th><th>GOLONGAN OBAT</th><th>RAWAT JALAN</th><th>IGD</th><th>RAWAT INAP</th></tr>
				<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>
			</thead>
			<tbody>
				<?
				$sql	= mysql_query('SELECT SUM(IF(lapkemenkes = "Generik",1,0)) AS tgenerik, SUM(IF(lapkemenkes = "Non Generik",1,0)) AS tnongenerik
FROM t_billobat_rajal 
WHERE KODE_OBAT NOT LIKE "07.%" AND kode_obat NOT LIKE "R%" AND YEAR(tanggal) = '.$tahun);
				$rajal	= mysql_fetch_array($sql);
				
				$sql2	=  mysql_query('SELECT SUM(IF(lapkemenkes = "Generik",1,0)) AS tgenerik, SUM(IF(lapkemenkes = "Non Generik",1,0)) AS tnongenerik
FROM t_billobat_ranap
WHERE KODE_OBAT NOT LIKE "07.%" AND kode_obat NOT LIKE "R%" AND YEAR(tanggal) = '.$tahun);
				$ranap	= mysql_fetch_array($sql2);
				?>
				<tr><td>1</td><td>OBAT GENERIK</td><td><?php echo $rajal['tgenerik'];?></td><td>0</td><td><?php echo $ranap['tgenerik'];?></td></tr>
				<tr><td>2</td><td>Obat Non Generik Formulatorium</td><td>0</td><td>0</td><td>0</td></tr>
				<tr><td>3</td><td>Obat Non Generik</td><td><?php echo $rajal['tnongenerik'];?></td><td>0</td><td><?php echo $ranap['tnongenerik'];?></td></tr>
				<tr><td>99</td><td>TOTAL</td><td></td><td></td><td></td></tr>
			</tbody>
			</table>
			<form action="rm/rl313_xls.php" method="get">
				<input type="hidden" name="tahun" id="tahun" value=<?php echo $tahun?> />
				<input type="submit" value="export xls"  />
			</form>
        </td>
    </tr>
</table>
</div>
</div>