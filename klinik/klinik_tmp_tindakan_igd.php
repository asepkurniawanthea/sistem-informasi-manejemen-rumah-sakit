<?php
$qry_tarif = 'SELECT DISTINCT t_irja_tarif.NO_PEMBAYARAN,t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,
				t_irja_tarif.ST_BAYAR,t_irja_tarif.DESKRIPSI,m_pegawai.NAMA_PEGAWAI
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_pegawai ON (t_irja.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
				AND m_tarif_group.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF <> "103001" AND m_tarif.KODE_TARIF <> "102001"
				OR (t_irja_tarif.DESKRIPSI = "Tindakan Di IGD" AND t_irja_tarif.IRJA_ID = "' . $irja_id . '")
				ORDER BY t_irja_tarif.NO_TARIF';				
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
    <th colspan="3">Nama Tindakan</th>
    <th>Tarif (Rp.)</th>
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
		<td align="right">&nbsp;</td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_TARIF'])) echo ' Belum Disimpan'; ?></td>
        <td align="center"><?php if($irja_final == '' and isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) 
						and !empty($dat_tarif['NO_TARIF'])){ ?>
		<a href="#" onclick="copykePAM('<?php echo $irja_id; ?>','<?php echo $dat_tarif['NO_TARIF']; ?>','<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>');">copy ke PAM</a>
		<?php } ?></td>
    </tr>
    <?php
		$pelaksana_tindakan = $dat_tarif['NAMA_PEGAWAI'];
		if(empty($dat_tarif['NO_TARIF'])){
		$qry_det_tarif = 'SELECT t_irja_tarif.IRJA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_irja_tarif.ICD_CODE,
				t_irja_tarif.NO_PEMBAYARAN,t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,m_pegawai.NAMA_PEGAWAI,
				t_irja_tarif.PEGAWAI_ID,t_irja_tarif.DESKRIPSI,t_irja_tarif.KUANTITI
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_irja_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '" AND t_irja_tarif.NO_TARIF IS NULL
				AND m_tarif_group.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF <> "103001" AND m_tarif.KODE_TARIF <> "102001"';
		}else{
		$qry_det_tarif = 'SELECT t_irja_tarif.IRJA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.KODE_TARIF_GROUP,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_irja_tarif.ICD_CODE,
				t_irja_tarif.NO_PEMBAYARAN,t_irja_tarif.NO_TARIF,DATE_FORMAT(t_irja_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,m_pegawai.NAMA_PEGAWAI,
				t_irja_tarif.PEGAWAI_ID,t_irja_tarif.DESKRIPSI,t_irja_tarif.KUANTITI
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_irja_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '" AND t_irja_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"
				AND m_tarif_group.KODE_TARIF_GROUP <> "01" AND m_tarif.KODE_TARIF <> "103001" AND m_tarif.KODE_TARIF <> "102001"';
		}		
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
		if(strtolower($dat_det_tarif['NAMA_TARIF']) != 'pendaftaran'){	
		?>
		<tr>
        <td colspan="4">&nbsp;</td>	
		<td width="10"><?php echo $y; ?></td>
		<td><?php echo $dat_det_tarif['NAMA_TARIF'] . ' (' . $dat_det_tarif['NAMA_TARIF_GROUP'] . ')'; ?></td>
		<td align="right"><?php echo currFormat($dat_det_tarif['TARIF_NON_KELAS']); ?></td>
		<td><?php echo $dat_det_tarif['NAMA_PEGAWAI']; ?></td>
		<td>&nbsp;</td>
        <td align="center" width="110">
		<?php if($dat_det_tarif['KODE_TARIF_GROUP'] != '01' and $irja_final == ''){ ?>
		<a href="#" onclick="window.open('index.php?popup=klinikformpelaksana&idx=<?php echo $irja_id; ?>&idt=<?php echo $dat_det_tarif['IRJA_TARIF_ID']; ?>&unit=<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>&pelaksana=<?php echo $dat_det_tarif['PEGAWAI_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=850,height=550')" >hasil</a>
		<?php } ?>  
		<?php if($irja_final == '' and (!in_array($jenis_bayar_id,getArrNonJaminan()) or empty($dat_det_tarif['NO_PEMBAYARAN']))){ ?>
		<?php if($dat_det_tarif['KUANTITI'] > 0){ ?>
		<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_det_tarif['IRJA_TARIF_ID']; ?>&nmk=<?php echo $dat_det_tarif['NAMA_TARIF']; ?>&grp=<?php echo $dat_det_tarif['KODE_TARIF_GROUP']; ?>&no=<?php echo $dat_det_tarif['NO_TARIF']; ?>" >hapus</a>
		<?php } ?>
		<?php } ?>
		</td>
    </tr>
		<?php
		$y++; $total = $total + $dat_det_tarif['TARIF_NON_KELAS']; 
		}
		}
		?>
		<tr>
		<td align="right" colspan="7">Total : Rp.&nbsp;&nbsp;&nbsp;<?php echo currFormat($total); ?></td>
		<td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
		<td align="center">&nbsp;</td>
    </tr>
		<?php
    $i++;
	}
?>