<?php
$qry_resep = 'SELECT DISTINCT t_operasi_resep.OPERASI_ID,t_operasi_resep.NO_RESEP,t_operasi_resep.ST_RESEP,m_pegawai.NAMA_PEGAWAI,
				DATE_FORMAT(t_operasi_resep.TGL_RESEP,"%d/%m/%Y %H:%i") AS TGL_RESEP,
				t_operasi_resep.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT
				FROM t_operasi_resep
				LEFT JOIN m_pegawai ON (t_operasi_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_ruang ON (t_operasi_resep.RUANG_ID = m_ruang.RUANG_ID)
				WHERE OPERASI_ID = "' . $operasi_id . '" AND t_operasi_resep.RESEP IS NOT NULL
				ORDER BY t_operasi_resep.NO_RESEP';
$get_resep = mysql_query($qry_resep) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
	<th width="120">Pengirim</th>
	<th colspan="2">Nama Obat</th>
	<th>Jumlah</th>
	<th>Satuan</th>
	<th>Aturan Pakai</th>
	<th>Waktu Pakai</th>
    <th width="60">Racikan</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();
$arr_nama_racikan = getResepNamaRacikan();

$i = 1;
while ($dat_resep = mysql_fetch_array($get_resep)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_resep['TGL_RESEP']; ?></td>
		<td><?php echo $dat_resep['NO_RESEP']; ?></td>
		<td><?php echo $dat_resep['NAMA_RUANG'] . ' ' . $dat_resep['KELAS_RAWAT'] . '/' . $dat_resep['NAMA_PEGAWAI']; ?></td>
        <td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php if($dat_resep['ST_RESEP'] != '') echo 'Selesai'; if(empty($dat_resep['NO_RESEP'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">
		<!-- -->
		<?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){
					if($dat_resep['NO_RESEP'] != '' and $dat_resep['ST_RESEP'] == ''){	?>
						<a href="<?php echo currentUrl(); ?>&idu=<?php echo $dat_resep['NO_RESEP']; ?>&nmr=<?php echo $dat_resep['NO_RESEP']; ?>" >ubah resep</a>
					<?php } 
				}else{
					if($dat_resep['NO_RESEP'] != '' and $dat_resep['ST_RESEP'] == '' and $dat_resep['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){	?>
						<a href="<?php echo currentUrl(); ?>&idu=<?php echo $dat_resep['NO_RESEP']; ?>&nmr=<?php echo $dat_resep['NO_RESEP']; ?>" >ubah resep</a>
					<?php }
				} ?>
		<!-- -->
		</td>
    </tr>
    <?php
			if(empty($dat_resep['NO_RESEP'])){
			$qry_det_resep = 'SELECT t_operasi_resep.OPERASI_RESEP_ID,t_operasi_resep.RESEP,t_operasi_resep.ST_RESEP,t_operasi_resep.RACIKAN,
						t_operasi_resep.GENERIK,t_operasi_resep.DOSIS,t_operasi_resep.JUMLAH,t_operasi_resep.PSIKOTROPIKA,
						t_operasi_resep.SATUAN,t_operasi_resep.FORMULARIUM,t_operasi_resep.FORMULARIUM_NASIONAL,
						t_operasi_resep.JUMLAH_KELUAR,t_operasi_resep.HARGA,t_operasi_resep.SATUAN_DOSIS,
						t_operasi_resep.WAKTU_PAKAI
						FROM t_operasi_resep
						LEFT JOIN m_pegawai ON (t_operasi_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE OPERASI_ID = "' . $operasi_id . '" AND t_operasi_resep.NO_RESEP IS NULL
						ORDER BY t_operasi_resep.NO_RESEP';
			}else{
			$qry_det_resep = 'SELECT t_operasi_resep.OPERASI_RESEP_ID,t_operasi_resep.RESEP,t_operasi_resep.ST_RESEP,t_operasi_resep.RACIKAN,
						t_operasi_resep.GENERIK,t_operasi_resep.DOSIS,t_operasi_resep.JUMLAH,t_operasi_resep.PSIKOTROPIKA,
						t_operasi_resep.SATUAN,t_operasi_resep.FORMULARIUM,t_operasi_resep.FORMULARIUM_NASIONAL,
						t_operasi_resep.JUMLAH_KELUAR,t_operasi_resep.HARGA,t_operasi_resep.SATUAN_DOSIS,
						t_operasi_resep.WAKTU_PAKAI
						FROM t_operasi_resep
						LEFT JOIN m_pegawai ON (t_operasi_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE OPERASI_ID = "' . $operasi_id . '" AND t_operasi_resep.NO_RESEP = "' . $dat_resep['NO_RESEP'] . '"
						ORDER BY t_operasi_resep.NO_RESEP';
			}			
			$get_det_resep = mysql_query($qry_det_resep) or die(mysql_error());
			$y = 1;
			$total = 0;
			while($dat_det_resep = mysql_fetch_array($get_det_resep)){
			$resep = $dat_det_resep['RESEP'];
			if($dat_det_resep['RACIKAN'] == '1'){
				$resep = '';
				$arr_nmr = explode('|',$dat_det_resep['RESEP']);
								foreach($arr_nmr as $row){
									if(is_numeric($row)){
										$resep .= $arr_nama_racikan[$row] . ' ';
									}else{
										$resep .= $row . ' ';
									}
								}
				$resep = substr($resep,0,strlen($resep)-1); 
			}
			?>
			<tr>
			<td colspan="4">&nbsp;</td>
			<td width="30" align="center"><?php echo $y; ?></td>
			<td><?php echo $resep; ?></td>
			<td align="right"><?php echo $dat_det_resep['JUMLAH']; ?></td>
			<td><?php echo $dat_det_resep['SATUAN']; ?></td>
			<td><?php $arr_atp = explode('|',$dat_det_resep['DOSIS']);
				$atp = '';
				foreach($arr_atp as $row){
					if(is_numeric($row)){
						$atp .= $arr_aturan_pakai[$row] . ',';
					}else{
						$atp .= $row . ',';
					}
				}
				echo substr($atp,0,strlen($atp)-1);
						
				$arr_str = explode('|',$dat_det_resep['SATUAN_DOSIS']);
				$str = '';
				foreach($arr_str as $row){
					if(is_numeric($row)){
						$str .= $arr_satuan_resep[$row] . ',';
					}else{
						$str .= $row . ',';
					}
				}
				echo ' ' . substr($str,0,strlen($str)-1);
	?></td>
			<td><?php $arr_wkp = explode('|',$dat_det_resep['WAKTU_PAKAI']);
						$wkp = '';
						foreach($arr_wkp as $row){
							if(is_numeric($row)){
								$wkp .= $arr_waktu_pakai[$row] . ',';
							}else{
								$wkp .= $row . ',';
							}
						}
						$wkp = substr($wkp,0,strlen($wkp)-1);
						echo str_replace('Bila perlu,','Bila perlu ',$wkp); 
	?></td>
			<td align="center"><?php if($dat_det_resep['RACIKAN'] == '1') echo '&radic;'; ?></td>
			<td align="center">&nbsp;</td>
			<td align="center"><?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){
					if($dat_det_resep['ST_RESEP'] == ''){ 
						if($dat_det_resep['RACIKAN'] != '1'){ ?>
							<a href="#" onclick="window.open('index.php?popup=operasiformeditresep&idx=<?php echo $operasi_id; ?>&idr=<?php echo $dat_det_resep['OPERASI_RESEP_ID']; ?>&tpr=1','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php }else{ ?>
							<a href="#" onclick="window.open('index.php?popup=operasiformeditresep&idx=<?php echo $operasi_id; ?>&idr=<?php echo $dat_det_resep['OPERASI_RESEP_ID']; ?>&tpr=2','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php } ?>
						<a href="<?php echo currentUrl(); ?>&idr=<?php echo $dat_det_resep['OPERASI_RESEP_ID']; ?>&nmr=<?php echo $dat_det_resep['RESEP']; ?>" >hapus</a>
				<?php } 
				}else{
					if($dat_det_resep['ST_RESEP'] == '' and $dat_resep['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){ 
						if($dat_det_resep['RACIKAN'] != '1'){ ?>
							<a href="#" onclick="window.open('index.php?popup=operasiformeditresep&idx=<?php echo $operasi_id; ?>&idr=<?php echo $dat_det_resep['OPERASI_RESEP_ID']; ?>&tpr=1','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php }else{ ?>
							<a href="#" onclick="window.open('index.php?popup=operasiformeditresep&idx=<?php echo $operasi_id; ?>&idr=<?php echo $dat_det_resep['OPERASI_RESEP_ID']; ?>&tpr=2','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php } ?>
						<a href="<?php echo currentUrl(); ?>&idr=<?php echo $dat_det_resep['OPERASI_RESEP_ID']; ?>&nmr=<?php echo $dat_det_resep['RESEP']; ?>" >hapus</a>
				<?php }
				} ?></td>
			</tr>
			<?php
			if($dat_det_resep['RACIKAN'] == '1'){
			$sql_racikan = 'SELECT t_operasi_resep_racikan.OPERASI_RESEP_RACIKAN_ID,t_operasi_resep_racikan.RESEP,t_operasi_resep_racikan.JUMLAH,
							t_operasi_resep_racikan.SATUAN,JUMLAH_KELUAR,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL
							FROM t_operasi_resep_racikan 
							WHERE t_operasi_resep_racikan.OPERASI_RESEP_ID = "' . $dat_det_resep['OPERASI_RESEP_ID'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			while($dat_racikan = mysql_fetch_array($get_racikan)){
			?>
				<tr>
				<td colspan="5">&nbsp;</td>
				<td><?php echo $dat_racikan['RESEP']; ?></td>
				<td align="right"><?php echo $dat_racikan['JUMLAH']; ?></td>
				<td><?php echo $dat_racikan['SATUAN']; ?></td>
				<td colspan="3" align="center">&nbsp;</td>
				<td>&nbsp;</td>
				<td align="center">
				<?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){
						if($dat_det_resep['ST_RESEP'] == ''){ ?>
							<a href="#" onclick="window.open('index.php?popup=operasiformeditresep&idx=<?php echo $operasi_id; ?>&idr=<?php echo $dat_racikan['OPERASI_RESEP_RACIKAN_ID']; ?>&tpr=3','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
							<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_racikan['OPERASI_RESEP_RACIKAN_ID']; ?>&nmr=<?php echo $dat_racikan['RESEP']; ?>" >hapus</a>
				<?php 	}	 
					}else{
						if($dat_det_resep['ST_RESEP'] == '' and $dat_resep['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){ ?>
							<a href="#" onclick="window.open('index.php?popup=operasiformeditresep&idx=<?php echo $operasi_id; ?>&idr=<?php echo $dat_racikan['OPERASI_RESEP_RACIKAN_ID']; ?>&tpr=3','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
							<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_racikan['OPERASI_RESEP_RACIKAN_ID']; ?>&nmr=<?php echo $dat_racikan['RESEP']; ?>" >hapus</a>
				<?php 	}
					}	?>
				</td>
				</tr>
			<?php
			}	
		 }
			
			$y++; }
			?>
		<?php			
    $i++;
	}
?>