<?php
$qry_tarif = 'SELECT DISTINCT t_ipenunjang.NO_ORDER,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				t_ipenunjang_tarif.ST_BAYAR,m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.ST_PERIKSA,
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
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				ORDER BY t_ipenunjang.NO_ORDER';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
	<th width="300">Pengirim</th>
    <th colspan="2">Nama Pemeriksaan</th>
	<th width="150">Pelaksana</th>
	<th>Hasil</th>
</tr>
<tr>
<td colspan="8"><strong>LABORATORIUM</strong></td>
</tr>
<?php
$i = 1;
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>	
		<td align="center"><?php echo $dat_tarif['TANGGAL_ORDER']; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_ORDER']; ?></td>
		<td><?php echo  $dat_tarif['NAMA_RUANG'] . ' ' . $dat_tarif['KELAS_RAWAT'] . '/' . $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td>&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td>&nbsp;</td>
		<td align="center" width="105px" rowspan="<?php 
			$sql_row = 'SELECT COUNT(t_ipenunjang_tarif.PENUNJANG_TARIF_ID)+1 AS CNT
					FROM t_ipenunjang_tarif
					INNER JOIN t_ipenunjang
					ON (t_ipenunjang_tarif.PENUNJANG_ID = t_ipenunjang.PENUNJANG_ID)
					INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
					INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
					WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" 
					AND t_ipenunjang.JNS_ORDER = "IRN" 
					AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
					OR m_tarif.UNIT_ID = "45")
					AND t_ipenunjang.NO_ORDER = "' . $dat_tarif['NO_ORDER'] . '"';
			$get_row = mysql_query($sql_row) or die(mysql_error());		
			$dat_row = mysql_fetch_assoc($get_row);
			echo $dat_row['CNT']; ?>">
				<?php $sql_view_rm = 'SELECT FILE_ID FROM t_rm_dokumen_file
						WHERE JNS_PERAWATAN = "2"
						AND NOMR = "' . $nomr . '"
						AND RAWAT_ID = "' . $irna_id . '"
						AND JENIS_DOKUMEN_ID = "5"
						AND (ORDER_PENUNJANG LIKE "IRN' . $dat_tarif['NO_TARIF'] . '%"
						OR ORDER_PENUNJANG LIKE "IRN' . $dat_tarif['NO_ORDER'] . '%")';
				$get_view_rm = mysql_query($sql_view_rm) or die(mysql_error());		
				while($dat_view_rm = mysql_fetch_array($get_view_rm)){ 
				if($dat_tarif['NO_ORDER'] != ''){ ?>
				<a href="#" onclick="window.open('index.php?flex=<?php echo $dat_view_rm['FILE_ID']; ?>', '_blank');" >lihat hasil</a><br/><br/>
				<?php }  } ?></td>
    </tr>
    <?php
		if(empty($dat_tarif['NO_ORDER'])){
		$qry_det_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang.PEGAWAI_ID,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT,
				MIN(m_tarif_pemeriksaan.FORM_HASIL) AS FORM_HASIL,t_ipenunjang.NO_ORDER,
				t_ipenunjang_tarif.NO_PENUNJANG AS NOMOR_PNJ,
				t_ipenunjang.NO_LABORATORIUM
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" AND t_ipenunjang.NO_ORDER IS NULL
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				AND (t_ipenunjang.DESKRIPSI IS NULL OR t_ipenunjang.DESKRIPSI = "Laboratorium (Ruang Rawat)"
				OR t_ipenunjang.DESKRIPSI = "Paket Skrining Covid-19")
				GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID';
		}else{
		$qry_det_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,DATE_FORMAT(t_ipenunjang.TANGGAL_ORDER,"%d/%m/%Y") AS TANGGAL_ORDER,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang.PEGAWAI_ID,m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,m_tarif_pemeriksaan.CH_REPORT,
				MIN(m_tarif_pemeriksaan.FORM_HASIL) AS FORM_HASIL,t_ipenunjang.NO_ORDER,
				t_ipenunjang_tarif.NO_PENUNJANG AS NOMOR_PNJ,
				t_ipenunjang.NO_LABORATORIUM
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irna_id . '" AND t_ipenunjang.NO_ORDER = "' . $dat_tarif['NO_ORDER'] . '"
				AND (m_tarif_group.LABORATORIUM = "1" OR m_tarif_group.LABORATORIUM_CITO = "1"
				OR m_tarif.UNIT_ID = "45")
				GROUP BY t_ipenunjang_tarif.PENUNJANG_TARIF_ID';
		}		
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
		?>
		<tr>
        <td colspan="4">&nbsp;</td>	
		<td width="10"><?php echo $y; ?></td>
		<td colspan="1"><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td><?php echo $dat_det_tarif['NAMA_PEGAWAI']; ?></td>
		<?php if($dat_tarif['NO_ORDER']==''){ ?>
		<td>&nbsp;</td>
		<?php } ?>
    </tr>
		<?php
		$y++; $total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
		}
		?>
		<?php
    $i++;
	}
?>
<tr>
<td colspan="8"><strong>RADIOLOGI</strong></td>
</tr>
<?php
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
$i = 1;
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>	
		<td align="center"><?php echo $dat_tarif['TANGGAL_ORDER']; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_ORDER']; ?></td>
		<td><?php echo  $dat_tarif['NAMA_RUANG'] . ' ' . $dat_tarif['KELAS_RAWAT'] . '/' . $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td colspan="2">&nbsp;</td>
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
		<td colspan="1"><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td><?php echo $dat_det_tarif['NAMA_PEGAWAI']; ?></td>
    </tr>
		<?php
		$y++; $total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
		}
		?>
		<?php
    $i++;
	}
?>