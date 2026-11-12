<?php
$qry_tarif = 'SELECT DISTINCT t_operasi_tarif.NO_PEMBAYARAN,t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y %H:%i") AS TGL_TARIF,
				t_operasi_tarif.ST_BAYAR,t_operasi_tarif.DESKRIPSI,m_jaminan.NAMA_JAMINAN,
				t_operasi_tarif.KELAS_RAWAT
				FROM t_operasi_tarif
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_operasi_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_jaminan ON (t_operasi_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				WHERE t_operasi_tarif.OPERASI_ID = "' . $operasi_id . '"
				AND t_operasi_tarif.DESKRIPSI <> "Kamar Operasi (Pendaftaran)"
				ORDER BY t_operasi_tarif.NO_TARIF';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
    <th colspan="3">Nama Tindakan</th>
    <th>Tarif (Rp.)</th>
	<th>Kelas</th>
	<th>Pelaksana</th>
	<th width="100">Status</th>
    <th width="100">Option</th>
</tr>
<?php
$i = 1;
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    ?>
    <tr>
        <td align="center"><?php echo $i; ?></td>	
		<td align="center"><?php echo $dat_tarif['TGL_TARIF']; ?></td>
		<td align="center"><?php echo $dat_tarif['NO_TARIF']; ?></td>
		<td colspan="2">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="right">&nbsp;</td>
		<td align="center"><?php echo $dat_tarif['KELAS_RAWAT']; ?></td>
		<td align="right">&nbsp;</td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_TARIF'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">&nbsp;</td>
    </tr>
    <?php
		if(empty($dat_tarif['NO_TARIF'])){
			$qry_det_tarif = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_operasi_tarif.ICD_CODE,
				t_operasi_tarif.NO_PEMBAYARAN,t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,m_pegawai.NAMA_PEGAWAI,
				t_operasi_tarif.PEGAWAI_ID,t_operasi_tarif.DESKRIPSI,m_tarif_group.NON_KELAS,
				CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
						END 
				END AS TARIF
				FROM t_operasi_tarif
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_operasi_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_operasi_tarif.OPERASI_ID = "' . $operasi_id . '" AND t_operasi_tarif.NO_TARIF IS NULL';
		}else{
		$qry_det_tarif = 'SELECT t_operasi_tarif.OPERASI_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_operasi_tarif.ICD_CODE,
				t_operasi_tarif.NO_PEMBAYARAN,t_operasi_tarif.NO_TARIF,DATE_FORMAT(t_operasi_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,m_pegawai.NAMA_PEGAWAI,
				t_operasi_tarif.PEGAWAI_ID,t_operasi_tarif.DESKRIPSI,m_tarif_group.NON_KELAS,
				CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_operasi_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
						END 
				END AS TARIF
				FROM t_operasi_tarif
				INNER JOIN m_tarif ON (t_operasi_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_operasi_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_operasi_tarif.OPERASI_ID = "' . $operasi_id . '" AND t_operasi_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"';
		}		
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
		?>
		<tr>
        <td colspan="4">&nbsp;</td>	
		<td width="10"><?php echo $y; ?></td>
		<td><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td align="right"><?php if($dat_det_tarif['NON_KELAS'] == '1'){
														echo currFormat($dat_det_tarif['TARIF_NON_KELAS']);
													}else{
														echo currFormat($dat_det_tarif['TARIF']);
													} ?></td>
		<td>&nbsp;</td>
		<td><?php echo $dat_det_tarif['NAMA_PEGAWAI']; ?></td>
		<td>&nbsp;</td>
        <td align="center" width="110"><?php if(!in_array($jenis_bayar_id,array('1','18')) or empty($dat_tarif['NO_PEMBAYARAN'])){ ?>
			<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_det_tarif['OPERASI_TARIF_ID']; ?>&nmk=<?php echo $dat_det_tarif['NAMA_TARIF']; ?>" >hapus</a>
		<?php } ?>
		</td>
		</tr>
		<?php
		$y++; 
		if($dat_det_tarif['NON_KELAS'] == '1'){
														$total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
													}else{
														$total = $total + $dat_det_tarif['TARIF']; 
													} 
		
		}
		?>
		<tr>
		<td align="right" colspan="7">Total : Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
		<td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
    </tr>
		<?php
    $i++;
	}
?>