<style>
thead th, thead td{text-align:center;}
thead tr:last{border-bottom :1px solid #999;}
</style>
<div align="center">
<div id="frame">
    <div id="frame_title"><h3>Laporan RL 3.1</h3></div>


<table border="0" width="95%">
	<tr valign="top">
		<td align="center">
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td rowspan="2" style="width:110px;"><img src="<?php echo _BASE_;?>/img/logobaktihusda.gif"></td><td><h2>Formulir 3.1</h2></td><td rowspan="2"><div style="border:1px dashed #999; padding:10px; display:block; font-style:italic; width:170px;">Ditjen Bina Upaya Kesehatan <br />Kementrian Kesehatan RI</div> 
</td></tr>
				<tr><td><h1>KEGIATAN PELAYANAN RAWAT INAP</h1></td></tr>
			</table>
		
			<table cellpadding="0" class="tb" width="95%" cellspacing="0">
				<tr><td> Kode RS </td><td>: <input type="text" name="kode_rs" class="inputrl12" /></td></tr>
                <tr><td> Nama RS </td><td>: <input type="text" name="nama_rs" class="inputrl12" /></td></tr>
                <tr><td> Tahun </td><td>: <input type="text" name="tahun" class="inputrl12" /></td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <tr><td colspan="2">&nbsp;</td></tr>
                <!--<tr><td colspan="2"><h2>RL 1.2 Indikator Pelayanan Rumah Sakit</h2></td></tr>-->
			</table>
		
			<table cellspacing="1" cellpadding="1" class="tb" width="95%">
			<thead>
				<tr><th rowspan="2">NO</th><th rowspan="2">JENIS PELAYANAN</th><th rowspan="2">PASIEN AWAL TAHUN</th><th rowspan="2">PASIEN MASUK</th><th rowspan="2">PASIEN KELUAR HIDUP</th>
					<th colspan="2"> PASIEN KELUAR MATI </th><th rowspan="2">JUMLAH LAMA DI RAWAT</th><th rowspan="2">PASIEN AKHIR TAHUN</th><th rowspan="2">JUMLAH HARI PERAWATAN</th><th colspan="6">RINCIAN HARI PERAWATAN PER KELAS</th></tr>
				<tr><th>< 48 </th><th> > 48</th><th>VVIP</th><th>VIP</th><th>I</th><th>II</th><th>III</th><th>KELAS KHUSUS</th></tr>
				<tr><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td></tr>
			</thead>
			<tbody>
				<?php
				$sql	= mysql_query('select * from m_unit where kode_unit <> 0 and kode_unit <> 14 and kode_unit <> 32');
				if(mysql_num_rows($sql) > 0)
				{
					$i	= 1;
					while($data	= mysql_fetch_array($sql))
					{
						echo '<tr><td align="center">'.$i.'</td><td>'.$data['nama_unit'].'</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
						$i++;
					}
				}
				?>
			</tbody>
			</table>
        </td>
    </tr>
</table>
</div>
</div>