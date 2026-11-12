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
    <th width="60">Generik</th>
	<th width="60">Psiko<br/>tropika</th>
	<th>Form RS</th>
	<th>Form NS</th>
	<th>Harga (Rp.)</th>
	<th width="100">Status</th>
    <th width="400">Option</th>
</tr>
<?php
$arr_aturan_pakai = getResepAturanPakai();
$arr_satuan_resep = getResepSatuan();
$arr_waktu_pakai = getResepWaktuPakai();
$arr_nama_racikan = getResepNamaRacikan();

$qry_resep = 'SELECT DISTINCT t_irja_resep.IRJA_ID,t_irja_resep.NO_RESEP,t_irja_resep.ST_RESEP,
				CASE WHEN m_pegawai.NAMA_PEGAWAI IS NOT NULL THEN m_pegawai.NAMA_PEGAWAI 
				ELSE m_pegawai2.NAMA_PEGAWAI END AS NAMA_PEGAWAI,
				DATE_FORMAT(t_irja_resep.TGL_RESEP,"%d/%m/%Y") AS TGL_RESEP,
				m_unit.NAMA_UNIT
				FROM t_irja_resep
				INNER JOIN t_irja 
				ON (t_irja_resep.IRJA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_pegawai 
				ON (t_irja_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 
				ON (t_irja.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				LEFT JOIN m_unit
				ON (t_irja.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_irja_resep.IRJA_ID = "' . $irna_id . '" AND t_irja_resep.RESEP IS NOT NULL
				AND t_irja_resep.NO_RESEP IS NOT NULL
				ORDER BY t_irja_resep.TGL_RESEP,t_irja_resep.NO_RESEP';
$get_resep = mysql_query($qry_resep) or die(mysql_error());

$st_copy = false;
$i = 1;
while ($dat_resep = mysql_fetch_array($get_resep)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td><?php echo $dat_resep['TGL_RESEP']; ?></td>
		<td><?php echo $dat_resep['NO_RESEP']; ?></td>
		<td><?php echo $dat_resep['NAMA_UNIT'] . '/' . $dat_resep['NAMA_PEGAWAI']; ?></td>
        <td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php if($dat_resep['ST_RESEP'] != '') echo 'Selesai'; if(empty($dat_resep['NO_RESEP'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">
		<!-- -->
		<?php if(!empty($dat_resep['NO_RESEP'])){ ?>
		<a href="#" onclick="copykeRMirja('<?php echo $irna_id; ?>','<?php echo $dat_resep['NO_RESEP']; ?>');">copy resep</a>
		<?php } ?>
		<!-- -->
		</td>
    </tr>
    <?php
			$qry_det_resep = 'SELECT t_irja_resep.IRJA_RESEP_ID,t_irja_resep.RESEP,t_irja_resep.ST_RESEP,t_irja_resep.RACIKAN,
						t_irja_resep.GENERIK,t_irja_resep.DOSIS,t_irja_resep.JUMLAH,t_irja_resep.PSIKOTROPIKA,
						t_irja_resep.SATUAN,t_irja_resep.FORMULARIUM,t_irja_resep.FORMULARIUM_NASIONAL,
						t_irja_resep.JUMLAH_KELUAR,t_irja_resep.HARGA,t_irja_resep.SATUAN_DOSIS,
						t_irja_resep.WAKTU_PAKAI
						FROM t_irja_resep
						LEFT JOIN m_pegawai ON (t_irja_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE IRJA_ID = "' . $irna_id . '" AND t_irja_resep.NO_RESEP = "' . $dat_resep['NO_RESEP'] . '"
						ORDER BY t_irja_resep.IRJA_RESEP_ID';		
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
			<td align="center"><?php if($dat_det_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
			<td align="right"><?php if($dat_det_resep['RACIKAN'] != '1'){
						echo currFormat($dat_det_resep['JUMLAH_KELUAR'] * $dat_det_resep['HARGA']); 
						$total = $total + $dat_det_resep['JUMLAH_KELUAR'] * $dat_det_resep['HARGA'];
						}?></td>
			<td align="center">&nbsp;</td>
			<td align="center">&nbsp;</td>
    </tr>
			<?php if($dat_det_resep['RACIKAN'] == '1'){
			$sql_racikan = 'SELECT t_irja_resep_racikan.IRJA_RESEP_RACIKAN_ID,t_irja_resep_racikan.RESEP,t_irja_resep_racikan.JUMLAH,
							t_irja_resep_racikan.SATUAN,t_irja_resep_racikan.FORMULARIUM,t_irja_resep_racikan.FORMULARIUM_NASIONAL,
							t_irja_resep_racikan.JUMLAH_KELUAR,t_irja_resep_racikan.HARGA
							FROM t_irja_resep_racikan 
							WHERE t_irja_resep_racikan.IRJA_RESEP_ID = "' . $dat_det_resep['IRJA_RESEP_ID'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			while($dat_racikan = mysql_fetch_array($get_racikan)){
			?>
				<tr>
				<td colspan="5">&nbsp;</td>
				<td><?php echo $dat_racikan['RESEP']; ?></td>
				<td align="right"><?php echo $dat_racikan['JUMLAH']; ?></td>
				<td><?php echo $dat_racikan['SATUAN']; ?></td>
				<td colspan="5" align="center">&nbsp;</td>
				<td align="center"><?php if($dat_racikan['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
				<td align="center"><?php if($dat_racikan['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
				<td align="right"><?php echo currFormat($dat_racikan['JUMLAH_KELUAR'] * $dat_racikan['HARGA']); 
								$total = $total + $dat_racikan['JUMLAH_KELUAR'] * $dat_racikan['HARGA']; ?></td>
				<td>&nbsp;</td>
				<td align="center"><?php if($dat_det_resep['ST_RESEP'] == '' and $irna_final == ''){ ?>
						<a href="#" onclick="window.open('index.php?popup=klinikformeditresep&idx=<?php echo $irna_id; ?>&idr=<?php echo $dat_racikan['IRJA_RESEP_RACIKAN_ID']; ?>&tpr=3','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >ubah</a>	
						<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_racikan['IRJA_RESEP_RACIKAN_ID']; ?>&nmr=<?php echo $dat_racikan['RESEP']; ?>" >hapus</a>
				<?php } ?>
				</td>
				</tr>
			<?php
			}	
		 }
			
			$y++; }
		?>
		<tr>
		<td align="right" colspan="16">Total Rp.&nbsp;<?php echo currFormat($total); ?></td>
		<td colspan="2">&nbsp;</td>
</tr>	
		<?php	
    $i++;
	}

//end rawat jalan
$qry_resep = 'SELECT DISTINCT t_irna_resep.IRNA_ID,t_irna_resep.NO_RESEP,t_irna_resep.ST_RESEP,m_pegawai.NAMA_PEGAWAI,
				DATE_FORMAT(t_irna_resep.TGL_RESEP,"%d/%m/%Y %H:%i") AS TGL_RESEP,
				t_irna_resep.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT
				FROM t_irna_resep
				LEFT JOIN m_pegawai ON (t_irna_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_ruang ON (t_irna_resep.RUANG_ID = m_ruang.RUANG_ID)
				WHERE IRNA_ID = "' . $irna_id . '" AND t_irna_resep.RESEP IS NOT NULL
				ORDER BY t_irna_resep.TGL_RESEP,t_irna_resep.NO_RESEP';
$get_resep = mysql_query($qry_resep) or die(mysql_error());
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
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center"><?php if($dat_resep['ST_RESEP'] != '') echo 'Selesai'; if(empty($dat_resep['NO_RESEP'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">
		<!-- -->
		<?php if($irna_final == ''){ ?>
		<?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){
					if($dat_resep['NO_RESEP'] != '' and $dat_resep['ST_RESEP'] == ''){	?>
						<a href="<?php echo currentUrl(); ?>&idu=<?php echo $dat_resep['NO_RESEP']; ?>&nmr=<?php echo $dat_resep['NO_RESEP']; ?>" >ubah resep</a>
					<?php } 
				}else{
					if($dat_resep['NO_RESEP'] != '' and $dat_resep['ST_RESEP'] == '' and $dat_resep['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){	?>
						<a href="<?php echo currentUrl(); ?>&idu=<?php echo $dat_resep['NO_RESEP']; ?>&nmr=<?php echo $dat_resep['NO_RESEP']; ?>" >ubah resep</a>
					<?php }
				} ?>
		<?php } ?>		
		<!-- -->
		<!-- -->
		<?php if(!empty($dat_resep['NO_RESEP'])){ ?>
		<a href="#" onclick="copykeRMirna('<?php echo $irna_id; ?>','<?php echo $dat_resep['NO_RESEP']; ?>');">copy resep</a>
		<?php } ?>
		<!-- -->
		</td>
    </tr>
    <?php
			if(empty($dat_resep['NO_RESEP'])){
			$qry_det_resep = 'SELECT t_irna_resep.IRNA_RESEP_ID,t_irna_resep.RESEP,t_irna_resep.ST_RESEP,t_irna_resep.RACIKAN,
						t_irna_resep.GENERIK,t_irna_resep.DOSIS,t_irna_resep.JUMLAH,t_irna_resep.PSIKOTROPIKA,
						t_irna_resep.SATUAN,t_irna_resep.FORMULARIUM,t_irna_resep.FORMULARIUM_NASIONAL,
						t_irna_resep.JUMLAH_KELUAR,t_irna_resep.HARGA,t_irna_resep.SATUAN_DOSIS,
						t_irna_resep.WAKTU_PAKAI
						FROM t_irna_resep
						LEFT JOIN m_pegawai ON (t_irna_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE IRNA_ID = "' . $irna_id . '" AND t_irna_resep.NO_RESEP IS NULL
						ORDER BY t_irna_resep.IRNA_RESEP_ID';
			}else{
			$qry_det_resep = 'SELECT t_irna_resep.IRNA_RESEP_ID,t_irna_resep.RESEP,t_irna_resep.ST_RESEP,t_irna_resep.RACIKAN,
						t_irna_resep.GENERIK,t_irna_resep.DOSIS,t_irna_resep.JUMLAH,t_irna_resep.PSIKOTROPIKA,
						t_irna_resep.SATUAN,t_irna_resep.FORMULARIUM,t_irna_resep.FORMULARIUM_NASIONAL,
						t_irna_resep.JUMLAH_KELUAR,t_irna_resep.HARGA,t_irna_resep.SATUAN_DOSIS,
						t_irna_resep.WAKTU_PAKAI
						FROM t_irna_resep
						LEFT JOIN m_pegawai ON (t_irna_resep.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
						WHERE IRNA_ID = "' . $irna_id . '" AND t_irna_resep.NO_RESEP = "' . $dat_resep['NO_RESEP'] . '"
						ORDER BY t_irna_resep.IRNA_RESEP_ID';
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
			<td align="center"><?php if($dat_det_resep['GENERIK'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['PSIKOTROPIKA'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
			<td align="center"><?php if($dat_det_resep['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
			<td align="right"><?php if($dat_det_resep['RACIKAN'] != '1'){
						echo currFormat($dat_det_resep['JUMLAH_KELUAR'] * $dat_det_resep['HARGA']); 
						$total = $total + $dat_det_resep['JUMLAH_KELUAR'] * $dat_det_resep['HARGA'];
						}?></td>
			<td align="center">&nbsp;</td>
			<td align="center">
			<?php if($irna_final == ''){ ?>
			<?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){
					if($dat_det_resep['ST_RESEP'] == ''){ 
						if($dat_det_resep['RACIKAN'] != '1'){ ?>
							<a href="#" onclick="window.open('index.php?popup=ranapformeditresep&idx=<?php echo $irna_id; ?>&idr=<?php echo $dat_det_resep['IRNA_RESEP_ID']; ?>&tpr=1','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php }else{ ?>
							<a href="#" onclick="window.open('index.php?popup=ranapformeditresep&idx=<?php echo $irna_id; ?>&idr=<?php echo $dat_det_resep['IRNA_RESEP_ID']; ?>&tpr=2','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php } ?>
						<a href="<?php echo currentUrl(); ?>&idr=<?php echo $dat_det_resep['IRNA_RESEP_ID']; ?>&nmr=<?php echo $dat_det_resep['RESEP']; ?>" >hapus</a>
				<?php } 
				}else{
					if($dat_det_resep['ST_RESEP'] == '' and $dat_resep['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){ 
						if($dat_det_resep['RACIKAN'] != '1'){ ?>
							<a href="#" onclick="window.open('index.php?popup=ranapformeditresep&idx=<?php echo $irna_id; ?>&idr=<?php echo $dat_det_resep['IRNA_RESEP_ID']; ?>&tpr=1','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php }else{ ?>
							<a href="#" onclick="window.open('index.php?popup=ranapformeditresep&idx=<?php echo $irna_id; ?>&idr=<?php echo $dat_det_resep['IRNA_RESEP_ID']; ?>&tpr=2','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
						<?php } ?>
						<a href="<?php echo currentUrl(); ?>&idr=<?php echo $dat_det_resep['IRNA_RESEP_ID']; ?>&nmr=<?php echo $dat_det_resep['RESEP']; ?>" >hapus</a>
				<?php }
				} ?>
			<?php } ?>	
			</td>
			</tr>
			<?php
			if($dat_det_resep['RACIKAN'] == '1'){
			$sql_racikan = 'SELECT t_irna_resep_racikan.IRNA_RESEP_RACIKAN_ID,t_irna_resep_racikan.RESEP,t_irna_resep_racikan.JUMLAH,
							t_irna_resep_racikan.SATUAN,JUMLAH_KELUAR,HARGA,FORMULARIUM,FORMULARIUM_NASIONAL
							FROM t_irna_resep_racikan 
							WHERE t_irna_resep_racikan.IRNA_RESEP_ID = "' . $dat_det_resep['IRNA_RESEP_ID'] . '"';
			$get_racikan = mysql_query($sql_racikan) or die(mysql_error());
			while($dat_racikan = mysql_fetch_array($get_racikan)){
			?>
				<tr>
				<td colspan="5">&nbsp;</td>
				<td><?php echo $dat_racikan['RESEP']; ?></td>
				<td align="right"><?php echo $dat_racikan['JUMLAH']; ?></td>
				<td><?php echo $dat_racikan['SATUAN']; ?></td>
				<td colspan="5" align="center">&nbsp;</td>
				<td align="center"><?php if($dat_racikan['FORMULARIUM'] == '1') echo '&radic;'; ?></td>
				<td align="center"><?php if($dat_racikan['FORMULARIUM_NASIONAL'] == '1') echo '&radic;'; ?></td>
				<td align="right"><?php echo currFormat($dat_racikan['JUMLAH_KELUAR'] * $dat_racikan['HARGA']); 
								$total = $total + $dat_racikan['JUMLAH_KELUAR'] * $dat_racikan['HARGA']; ?></td>
				<td>&nbsp;</td>
				<td align="center">
				<?php if($irna_final == ''){ ?>
				<?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){
						if($dat_det_resep['ST_RESEP'] == ''){ ?>
							<a href="#" onclick="window.open('index.php?popup=ranapformeditresep&idx=<?php echo $irna_id; ?>&idr=<?php echo $dat_racikan['IRNA_RESEP_RACIKAN_ID']; ?>&tpr=3','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
							<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_racikan['IRNA_RESEP_RACIKAN_ID']; ?>&nmr=<?php echo $dat_racikan['RESEP']; ?>" >hapus</a>
				<?php 	}	 
					}else{
						if($dat_det_resep['ST_RESEP'] == '' and $dat_resep['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){ ?>
							<a href="#" onclick="window.open('index.php?popup=ranapformeditresep&idx=<?php echo $irna_id; ?>&idr=<?php echo $dat_racikan['IRNA_RESEP_RACIKAN_ID']; ?>&tpr=3','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=1100,height=400')" >edit</a>	
							<a href="<?php echo currentUrl(); ?>&idrc=<?php echo $dat_racikan['IRNA_RESEP_RACIKAN_ID']; ?>&nmr=<?php echo $dat_racikan['RESEP']; ?>" >hapus</a>
				<?php 	}
					}	?>
				<?php } ?>	
				</td>
				</tr>
			<?php
			}	
		 }
			
			$y++; }
			?>
			<tr>
				<td align="right" colspan="16">Total Rp.&nbsp;<?php echo currFormat($total); ?></td>
				<td colspan="2">&nbsp;</td>
			</tr>	
		<?php			
    $i++;
	}
?>