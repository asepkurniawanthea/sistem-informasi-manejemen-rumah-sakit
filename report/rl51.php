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
				<tr><td rowspan="2" style="width:110px;"><img src="image/logobaktihusda.gif"></td><td><h2>Formulir 5.1</h2></td><td rowspan="2" align="center"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>PENGUNJUNG</h1></td></tr>
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
				<tr><th>NO</th><th>NAMA KEGIATAN</th><th>JUMLAH</th></tr>
				<tr><td>1</td><td>2</td><td>3</td></tr>
			</thead>
			<tbody>
				<?php
				$sql	= mysql_query('SELECT COUNT(CASE WHEN PENGUNJUNG > 0 THEN NOMR END) AS pasienbaru,
						COUNT(CASE WHEN PENGUNJUNG = 0 THEN NOMR END) AS pasienlama FROM
						(SELECT NOMR, SUM(CASE WHEN ST_BARU = "1" THEN 1 ELSE 0 END) AS PENGUNJUNG
						FROM t_irja WHERE YEAR(TANGGAL_DAFTAR) = ' . $tahun . ' AND MONTH(TANGGAL_DAFTAR) = ' . $bulan . '
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
<br />
</div>
</div>
 <form id="xls_export" name="xls_export" method="post">
    <input type="hidden" name="page_to_excel" value="1" />
    <input type="hidden" name="tahun" value="<?php echo $tahun; ?>" />
    <input type="hidden" name="bulan" value="<?php echo $bulan; ?>" />
    <input type="hidden" name="xlsfile" value="report/xls_rl51.php" />
    <input type="hidden" name="xlsname" value="rpt_rl51.xls" />            
</form>