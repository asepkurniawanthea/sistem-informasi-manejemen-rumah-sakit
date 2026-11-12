<?php
$tgl_filter_tindakan = '';
if($tgl_filter != '' and $tgl_filter2 == '') $tgl_filter_tindakan = 'AND DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") = "' . $tgl_filter . '"';
if($tgl_filter != '' and $tgl_filter2 != '') $tgl_filter_tindakan = 'AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") >= STR_TO_DATE("' . $tgl_filter . '","%d/%m/%Y")
		AND STR_TO_DATE(DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y"),"%d/%m/%Y") <= STR_TO_DATE("' . $tgl_filter2 . '","%d/%m/%Y")';

$ruang_tindakan_filter = '';
if($ruang_tindakan != ''){
	$ruang_tindakan_filter = 'AND t_irna_tarif.RUANG_ID = "' . $ruang_tindakan . '"';
}
	
$qry_tarif = 'SELECT DISTINCT t_irna_tarif.NO_PEMBAYARAN,t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y %H:%i") AS TGL_TARIF,
				t_irna_tarif.ST_BAYAR,t_irna_tarif.DESKRIPSI,m_jaminan.NAMA_JAMINAN,
				t_irna_tarif.KELAS_RAWAT,t_irna_tarif.RUANG_ID,m_ruang.NAMA_RUANG
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_irna_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_jaminan ON (t_irna_tarif.JENIS_BAYAR_ID = m_jaminan.JAMINAN_ID)
				LEFT JOIN m_ruang ON (t_irna_tarif.RUANG_ID = m_ruang.RUANG_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '"
				' . $tgl_filter_tindakan . '
				' . $ruang_tindakan_filter . '
				' . (($nama_tindakan != '') ? ' AND m_tarif.NAMA_TARIF LIKE "%' . $nama_tindakan . '%"' : '') . '
				AND t_irna_tarif.DESKRIPSI <> "Karcis & Konsultasi" AND t_irna_tarif.DESKRIPSI <> "Konsultasi"
				OR (t_irna_tarif.DESKRIPSI = "Tindakan Di IGD" AND t_irna_tarif.IRNA_ID = "' . $irna_id . '")
				ORDER BY t_irna_tarif.TGL_TARIF,t_irna_tarif.NO_TARIF';
$get_tarif = mysql_query($qry_tarif) or die(mysql_error());
?>
<tr>
    <th width="30">No</th>
	<th width="100">Tanggal</th>
	<th width="100">Nomor</th>
    <th colspan="3">Nama Tindakan</th>
    <th>Tarif (Rp.)</th>
	<th>Ruang/Kelas</th>
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
		<td align="center"><?php echo $dat_tarif['NAMA_RUANG'] . '/' . $dat_tarif['KELAS_RAWAT']; ?></td>
		<td align="right">&nbsp;</td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_TARIF'])) echo ' Belum Disimpan'; ?></td>
        <td align="center">&nbsp;</td>
    </tr>
    <?php
		if(empty($dat_tarif['NO_TARIF'])){
			$qry_det_tarif = 'SELECT t_irna_tarif.IRNA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_irna_tarif.ICD_CODE,
				t_irna_tarif.NO_PEMBAYARAN,t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,m_pegawai.NAMA_PEGAWAI,
				t_irna_tarif.PEGAWAI_ID,t_irna_tarif.DESKRIPSI,m_tarif_group.NON_KELAS,
				m_tarif_group.KODE_TARIF_GROUP,t_irna_tarif.KUANTITI,
				CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
						END 
				END AS TARIF
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_irna_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '" 
				' . (($nama_tindakan != '') ? ' AND m_tarif.NAMA_TARIF LIKE "%' . $nama_tindakan . '%"' : '') . '
				AND t_irna_tarif.NO_TARIF IS NULL';
		}else{
			$qry_det_tarif = 'SELECT t_irna_tarif.IRNA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_irna_tarif.ICD_CODE,
				t_irna_tarif.NO_PEMBAYARAN,t_irna_tarif.NO_TARIF,DATE_FORMAT(t_irna_tarif.TGL_TARIF,"%d/%m/%Y") AS TGL_TARIF,m_pegawai.NAMA_PEGAWAI,
				t_irna_tarif.PEGAWAI_ID,t_irna_tarif.DESKRIPSI,m_tarif_group.NON_KELAS,
				m_tarif_group.KODE_TARIF_GROUP,t_irna_tarif.KUANTITI,
				CASE WHEN m_tarif_group.NON_KELAS = "1" THEN m_tarif.TARIF_NON_KELAS
					ELSE	
						CASE WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "3" THEN m_tarif.TARIF_KELAS_3 
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "2" THEN m_tarif.TARIF_KELAS_2
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "1" THEN m_tarif.TARIF_KELAS_1
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VIP" THEN m_tarif.TARIF_KELAS_UTAMA
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "UTAMA 2" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "VVIP" THEN m_tarif.TARIF_KELAS_UTAMA_2
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "HCU" THEN m_tarif.TARIF_HCU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICU" THEN m_tarif.TARIF_ICU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "NICU" THEN m_tarif.TARIF_NICU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PICU" THEN m_tarif.TARIF_PICU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "ICCU" THEN m_tarif.TARIF_ICCU
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "PERINA" THEN m_tarif.TARIF_PERINA
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SEHAT" THEN m_tarif.TARIF_KELAS_PERINA_SEHAT
							WHEN UPPER(t_irna_tarif.KELAS_RAWAT) = "BAYI SAKIT" THEN m_tarif.TARIF_KELAS_PERINA_SAKIT
						END 
				END AS TARIF
				FROM t_irna_tarif
				INNER JOIN m_tarif ON (t_irna_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				LEFT JOIN m_pegawai ON (t_irna_tarif.PEGAWAI_PELAKSANA_ID = m_pegawai.PEGAWAI_ID)
				WHERE t_irna_tarif.IRNA_ID = "' . $irna_id . '" 
				' . (($nama_tindakan != '') ? ' AND m_tarif.NAMA_TARIF LIKE "%' . $nama_tindakan . '%"' : '') . '
				AND t_irna_tarif.NO_TARIF = "' . $dat_tarif['NO_TARIF'] . '"';
		}		
		$get_det_tarif = mysql_query($qry_det_tarif) or die(mysql_error());
		$y = 1;
		$total = 0;
		while($dat_det_tarif = mysql_fetch_array($get_det_tarif)){
			if(strtolower($dat_det_tarif['NAMA_TARIF']) != 'pendaftaran'){	?>
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
				<td><?php echo $dat_det_tarif['NAMA_PEGAWAI'];?></td>
				<td>&nbsp;</td>
				<td align="center" width="130">
				<?php if($irna_final == ''){ ?>
				<?php if($_SESSION['SES_SIMRS_RUANG_ID'] == ''){ ?>
							<a href="#" onclick="window.open('index.php?popup=ranapformpelaksana&idx=<?php echo $irna_id; ?>&idt=<?php echo $dat_det_tarif['IRNA_TARIF_ID']; ?>&unit=<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>&pelaksana=<?php echo $dat_det_tarif['PEGAWAI_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=850,height=530')" >pelaksana_hasil</a>
							<?php if(!in_array($jenis_bayar_id,getArrNonJaminan()) or empty($dat_det_tarif['NO_PEMBAYARAN'])){ ?>
								<?php if($dat_det_tarif['KUANTITI'] > 0){ ?>
								<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_det_tarif['IRNA_TARIF_ID']; ?>&nmk=<?php echo $dat_det_tarif['NAMA_TARIF']; ?>&grp=<?php echo $dat_det_tarif['KODE_TARIF_GROUP']; ?>&no=<?php echo $dat_det_tarif['NO_TARIF']; ?>" >hapus</a>
								<?php } ?>
							<?php } ?>
				<?php }else{
							if($dat_tarif['RUANG_ID'] == $_SESSION['SES_SIMRS_RUANG_ID']){ ?>
								<a href="#" onclick="window.open('index.php?popup=ranapformpelaksana&idx=<?php echo $irna_id; ?>&idt=<?php echo $dat_det_tarif['IRNA_TARIF_ID']; ?>&unit=<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>&pelaksana=<?php echo $dat_det_tarif['PEGAWAI_ID']; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=850,height=530')" >pelaksana_hasil</a>
								<?php if(!in_array($jenis_bayar_id,getArrNonJaminan()) or empty($dat_det_tarif['NO_PEMBAYARAN'])){ ?>
									<?php if($dat_det_tarif['KUANTITI'] > 0){ ?>
									<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_det_tarif['IRNA_TARIF_ID']; ?>&nmk=<?php echo $dat_det_tarif['NAMA_TARIF']; ?>&grp=<?php echo $dat_det_tarif['KODE_TARIF_GROUP']; ?>&no=<?php echo $dat_det_tarif['NO_TARIF']; ?>" >hapus</a>
									<?php } ?>
							<?php } 
							} ?>
				<?php } ?>
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