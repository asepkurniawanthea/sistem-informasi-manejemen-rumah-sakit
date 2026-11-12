<?php
if(empty($jns_order)){
	$qry_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.ST_BAYAR,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.ST_PERIKSA,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,
				t_ipenunjang.NO_ORDER
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $irja_id . '" AND t_ipenunjang.JNS_ORDER = "' . $jnsp . '" 
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND t_ipenunjang.HEMODIALISA_ID IS NULL
				ORDER BY t_ipenunjang.NO_ORDER,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
}else{
	$qry_tarif = 'SELECT DISTINCT t_ipenunjang_tarif.PENUNJANG_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF AS TARIF_X,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,
				t_ipenunjang_tarif.NO_PEMBAYARAN,t_ipenunjang_tarif.NO_TARIF,t_ipenunjang_tarif.ST_BAYAR,
				m_pegawai.NAMA_PEGAWAI,t_ipenunjang_tarif.ST_PERIKSA,
				m_tarif_pemeriksaan.NAMA_PEMERIKSAAN_ORDER AS NAMA_TARIF,
				t_ipenunjang.DESKRIPSI,t_ipenunjang_tarif.ST_DIAGNOSA,
				t_ipenunjang.NO_ORDER
				FROM t_ipenunjang
				INNER JOIN t_ipenunjang_tarif ON (t_ipenunjang.PENUNJANG_ID = t_ipenunjang_tarif.PENUNJANG_ID)
				INNER JOIN m_tarif ON (t_ipenunjang_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN m_tarif_pemeriksaan ON (m_tarif.KODE_TARIF = m_tarif_pemeriksaan.KODE_TARIF)
				LEFT JOIN m_pegawai ON (t_ipenunjang_tarif.PEGAWAI_PERIKSA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_ipenunjang.RAWAT_ID = "' . $idxord . '" AND t_ipenunjang.JNS_ORDER = "' . $jnsp . '" 
				AND (m_tarif_group.RADIOLOGI = "1" OR m_tarif_group.RADIOLOGI_CITO = "1"
				OR m_tarif.UNIT_ID = "17")
				AND t_ipenunjang.HEMODIALISA_ID = "' . $irja_id . '"
				ORDER BY t_ipenunjang.NO_ORDER,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';
}				
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Nomor</th>
	<th>Jenis Poto</th>
    <th>Nama Poto</th>
    <th>Tarif (Rp.)</th>
	<th>Pelaksana</th>
	<th>Hasil</th>
	<th>Photo</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
$total = 0;
$nomor = '';
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td align="center"><?php if($nomor != $dat_tarif['NO_ORDER']) { echo $dat_tarif['NO_ORDER']; $nomor = $dat_tarif['NO_ORDER']; }  ?></td>
        <td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
		<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
		<td align="right"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
		<td><?php echo $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td align="center"><?php if(!empty($dat_det_tarif['TANGGAL_DIAGNOSA'])){ ?><a href="#" onclick="window.open('index.php?popup=hemodialisaformviewradiologi&idp=<?php echo $dat_det_tarif['PENUNJANG_TARIF_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=700,height=600')" >lihat hasil</a><?php } ?></td>
		<td><?php
			$sql_photo = 'SELECT DISTINCT t_ipenunjang_tarif_photo.PHOTO_FILE FROM t_ipenunjang_tarif_photo
						WHERE t_ipenunjang_tarif_photo.PENUNJANG_TARIF_ID = "' . $dat_tarif['PENUNJANG_TARIF_ID'] . '"';
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
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_ORDER'])) echo ' Belum Disimpan'; ?></td>
        <td align="center" width="110"><?php if($_REQUEST['link'] != md5('hemodialisaviewpasienperiksa')){ ?>
		<?php if(empty($dat_tarif['NO_TARIF'])){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['PENUNJANG_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>&ord=<?php echo $jns_order; ?>" >hapus</a>
		<?php }else{ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['PENUNJANG_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>&ord=<?php echo $jns_order; ?>" >hapus</a>
		<?php } } ?></td>
    </tr>
    <?php
	$total = $total + $dat_tarif['TARIF_NON_KELAS'];
    $i++;
	}
?>