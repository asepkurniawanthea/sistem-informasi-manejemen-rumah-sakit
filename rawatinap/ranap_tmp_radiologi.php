<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
	<th width="100">Pengirim</th>
    <th colspan="3">Nama Poto</th>
    <th>Tarif (Rp.)</th>
	<th>Pelaksana</th>
	<th width="100">Hasil</th>
	<th width="100">Photo</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$qry_tarif = 'SELECT DISTINCT t_ipenunjang.NO_ORDER,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				t_ipenunjang_tarif.ST_BAYAR,m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.NO_TARIF,
				m_unit.NAMA_UNIT
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_unit ON (t_ipenunjang.UNIT_ID = m_unit.UNIT_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
				AND t_ipenunjang.JNS_ORDER = "IRJ" 
				AND t_ipenunjang.NO_ORDER IS NOT NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")
				ORDER BY t_ipenunjang.NO_ORDER';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
$i = 1;
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>	
		<td align="center"><?php echo $dat_tarif['TANGGAL_ORDER']; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_ORDER']; ?></td>
		<td><?php echo $dat_tarif['NAMA_UNIT'] . '/'. $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td colspan="3">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="center" rowspan="<?php 
			$sql_row = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID)+1 AS CNT
					FROM t_ipenunjang_tarif
					INNER JOIN t_ipenunjang
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_ORDER = "IRJ" 
					AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
					OR m_tarif.UNIT_ID = "17")
					AND t_ipenunjang.NO_ORDER = "' . $dat_tarif['NO_ORDER'] . '"';
			$get_row = mysql_query($sql_row) or die(mysql_error());		
			$dat_row = mysql_fetch_assoc($get_row);
			echo $dat_row['CNT']; ?>" ><?php $sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "1"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $irna_id . '"
						AND JENIS_DOKUMEN_ID = "6"
						AND ORDER_PENUNJANG LIKE "IRJ' . $dat_tarif['NO_TARIF'] . '%"';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				while($dat_view_rm = mysql_fetch_array($get_view_rm)){ ?>
				<a href="#" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" >lihat hasil</a><br/><br/>
		<?php } ?></td>
		<td>&nbsp;</td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_ORDER'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">&nbsp;</td>
    </tr>
    <?php
			$qry_det_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,
				t_ipenunjang.NO_ORDER,t_ipenunjang_tarif.TANGGAL_DIAGNOSA,t_ipenunjang_tarif.ST_PERIKSA,t_ipenunjang_tarif.ST_DIAGNOSA,
				t_ipenunjang_tarif.TANGGAL_PERIKSA
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" AND t_ipenunjang.NO_ORDER = "' . $dat_tarif['NO_ORDER'] . '"
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1")';	
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
		?>
		<tr>
        <td colspan="4">&nbsp;</td>	
		<td width="10"><?php echo $y; ?></td>
		<td colspan="2"><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td align="right"><?php echo currFormat($dat_det_tarif['TARIF_NON_KELAS']); ?></td>
		<td><?php echo $dat_det_tarif['NAMA_PEGAWAI']; ?></td>
		<td><?php
			$sql_photo = 'SELECT DISTINCT t_ipenunjang_tarif_photo.PHOTO_FILE FROM t_ipenunjang_tarif_photo
						WHERE t_ipenunjang_tarif_photo.PENUNJANG_TARIF_ID = "' . $dat_det_tarif['PENUNJANG_TARIF_ID'] . '"';
			$get_photo = mysql_query($sql_photo) or die(mysql_error());
			if(mysql_num_rows($get_photo) > 0){
				echo '<table width="100%" border="0">';
				$z = 1;
				while($dat_photo = mysql_fetch_array($get_photo)){
						echo '<tr>';
						echo '<td align="center">';
						echo '<img id="image' . $z . '" src="dicom/thumbnail/' . $dat_photo['PHOTO_FILE'] . '" height="50px" >';
						?>
						<script type="text/javascript" >
						$("#image<?php echo $z; ?>").click(function() {
							$.fancybox.open({
								href : 'index.php?dicom=<?php echo $dat_photo['PHOTO_FILE']; ?>',
								type : 'iframe',
								padding : 1,
								width    : '1100px'
								});
						});
						</script>
						<?php
						echo '</td>';
						echo '</tr>';
				$z++; }
				echo '</table>';
			}
		?></td>
		<td>&nbsp;</td>
        <td align="center" width="110"><?php if(!empty($dat_tarif['NO_TARIF'])){ ?>
		<a href="#" onclick="copykeRMirja('<?php echo $irna_id; ?>','<?php echo $dat_det_tarif['PENUNJANG_TARIF_ID']; ?>');">copy hasil</a>
		<?php } ?>
		</td>
    </tr>
		<?php
		$y++; $total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
		}
		?>
		<tr>
		<td align="right" colspan="8">Total : Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
		<td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
    </tr>
		<?php
    $i++;
	}
//end rawat jalan
$qry_tarif = 'SELECT DISTINCT t_ipenunjang.NO_ORDER,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				t_ipenunjang_tarif.ST_BAYAR,m_pegawai.NAMA_PEGAWAI,
				t_ipenunjang.RUANG_ID,m_ruang.NAMA_RUANG,m_ruang.KELAS_RAWAT,
				t_ipenunjang_tarif.NO_TARIF
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_ipenunjang.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_ruang ON (t_ipenunjang.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '"
				AND t_ipenunjang.JNS_ORDER = "IRN" 
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				ORDER BY t_ipenunjang.NO_ORDER';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>	
		<td align="center"><?php echo $dat_tarif['TANGGAL_ORDER']; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_ORDER']; ?></td>
		<td><?php echo  $dat_tarif['NAMA_RUANG'] . ' ' . $dat_tarif['KELAS_RAWAT'] . '/' . $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td colspan="3">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center" rowspan="<?php 
			$sql_row = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID)+1 AS CNT
					FROM t_ipenunjang_tarif
					INNER JOIN t_ipenunjang
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_ORDER = "IRN" 
					AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
					OR m_tarif.UNIT_ID = "17")
					AND t_ipenunjang.NO_ORDER = "' . $dat_tarif['NO_ORDER'] . '"';
			$get_row = mysql_query($sql_row) or die(mysql_error());		
			$dat_row = mysql_fetch_assoc($get_row);
			echo $dat_row['CNT']; ?>" ><?php $sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $irna_id . '"
						AND JENIS_DOKUMEN_ID = "6"
						AND ORDER_PENUNJANG LIKE "IRN' . $dat_tarif['NO_TARIF'] . '%"';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				while($dat_view_rm = mysql_fetch_array($get_view_rm)){ ?>
				<a href="#" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" >lihat hasil</a><br/><br/>
		<?php } ?></td>
		<td>&nbsp;</td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_ORDER'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">&nbsp;</td>
    </tr>
    <?php
		if(empty($dat_tarif['NO_ORDER'])){
			$qry_det_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,
				t_ipenunjang.NO_ORDER,t_ipenunjang_tarif.TANGGAL_DIAGNOSA,t_ipenunjang_tarif.TANGGAL_PERIKSA
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" AND t_ipenunjang.NO_ORDER IS NULL
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang.DESKRIPSI = "Radiologi (Ruang Rawat)"
				OR t_ipenunjang.DESKRIPSI = "Paket Skrining Covid-19")';
		}else{
			$qry_det_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.PEGAWAI_DIAGNOSA_ID,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,
				t_ipenunjang.NO_ORDER,t_ipenunjang_tarif.TANGGAL_DIAGNOSA,t_ipenunjang_tarif.TANGGAL_PERIKSA
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" AND t_ipenunjang.NO_ORDER = "' . $dat_tarif['NO_ORDER'] . '"
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")';
		}		
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
		?>
		<tr>
        <td colspan="4">&nbsp;</td>	
		<td width="10"><?php echo $y; ?></td>
		<td colspan="2"><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td align="right"><?php echo currFormat($dat_det_tarif['TARIF_NON_KELAS']); ?></td>
		<td><?php echo $dat_det_tarif['NAMA_PEGAWAI']; ?></td>
		<!--<td align="center">
		<?php if(!empty($dat_det_tarif['TANGGAL_DIAGNOSA'])){ ?><a href="#" onclick="window.open('index.php?popup=ranapformviewradiologi&idp=<?php echo $dat_det_tarif['PENUNJANG_TARIF_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=700,height=600')" >lihat hasil</a><?php } ?></td>-->
		<?php if($dat_tarif['NO_ORDER'] == ''){ ?>
		<td>&nbsp;</td>
		<?php } ?>
		<td><?php
			$sql_photo = 'SELECT DISTINCT t_ipenunjang_tarif_photo.PHOTO_FILE FROM t_ipenunjang_tarif_photo
						WHERE t_ipenunjang_tarif_photo.PENUNJANG_TARIF_ID = "' . $dat_det_tarif['PENUNJANG_TARIF_ID'] . '"';
			$get_photo = mysql_query($sql_photo) or die(mysql_error());
			if(mysql_num_rows($get_photo) > 0){
				echo '<table width="100%" border="0">';
				$z = 1;
				while($dat_photo = mysql_fetch_array($get_photo)){
						echo '<tr>';
						echo '<td align="center">';
						echo '<img id="image' . $z . '" src="dicom/thumbnail/' . $dat_photo['PHOTO_FILE'] . '" height="50px" >';
						?>
						<script type="text/javascript" >
						$("#image<?php echo $z; ?>").click(function() {
							$.fancybox.open({
								href : 'index.php?dicom=<?php echo $dat_photo['PHOTO_FILE']; ?>',
								type : 'iframe',
								padding : 1,
								width    : '1100px'
								});
						});
						</script>
						<?php
						echo '</td>';
						echo '</tr>';
				$z++; }
				echo '</table>';
			}
		?></td>
		<td>&nbsp;</td>
        <td align="center" width="110">
		<?php if(!empty($dat_tarif['NO_TARIF'])){ ?>
		<a href="#" onclick="copykeRMirna('<?php echo $irna_id; ?>','<?php echo $dat_det_tarif['PENUNJANG_TARIF_ID']; ?>');">copy hasil</a>
		<?php } ?>
		<?php if($irna_final == ''){ ?>
		<?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){
					if($dat_det_tarif['TANGGAL_PERIKSA'] == ''){ 
						if(!in_array($jenis_bayar_id,array('1','18')) or empty($dat_det_tarif['NO_PEMBAYARAN'])){ ?>
						<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_det_tarif['PENUNJANG_TARIF_ID']; ?>&nmk=<?php echo $dat_det_tarif['NAMA_TARIF']; ?>" >hapus</a>
					<?php } }  
				}else{
					if($dat_tarif['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){ 
						if($dat_det_tarif['TANGGAL_PERIKSA'] == ''){  
							if(!in_array($jenis_bayar_id,array('1','18')) or empty($dat_det_tarif['NO_PEMBAYARAN'])){ ?>
								<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_det_tarif['PENUNJANG_TARIF_ID']; ?>&nmk=<?php echo $dat_det_tarif['NAMA_TARIF']; ?>" >hapus</a>
					<?php } } }
				} ?>
		<?php } ?>
		</td>
    </tr>
		<?php
		$y++; $total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
		}
		?>
		<tr>
		<td align="right" colspan="8">Total : Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
		<td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
    </tr>
		<?php
    $i++;
	}
?>