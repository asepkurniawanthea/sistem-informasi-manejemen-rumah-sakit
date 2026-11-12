<?php
if(empty($jns_order)){
	$qry_tarif = 'SELECT t_irja_tarif.IRJA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_irja_tarif.ICD_CODE,
				t_irja_tarif.NO_PEMBAYARAN,t_irja_tarif.NO_TARIF,t_irja_tarif.ST_BAYAR,t_irja_tarif.USER_KASIR,
				CASE WHEN (t_irja_tarif.PEGAWAI_ID IS NOT NULL AND t_irja_tarif.PEGAWAI_ID <> "") THEN m_pegawai.NAMA_PEGAWAI
				ELSE m_pegawai2.NAMA_PEGAWAI END AS NAMA_PEGAWAI,t_irja_tarif.PEGAWAI_ID,t_irja_tarif.DESKRIPSI,
				m_tarif_group.KODE_TARIF_GROUP
				FROM t_irja_tarif
				INNER JOIN m_tarif ON (t_irja_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_irja ON (t_irja_tarif.IRJA_ID = t_irja.IRJA_ID)
				LEFT JOIN m_pegawai ON (t_irja_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_irja.PEGAWAI_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_irja_tarif.IRJA_ID = "' . $irja_id . '"
				AND m_tarif_group.KODE_TARIF_GROUP <> "01" AND 
				m_tarif.KODE_TARIF <> "103001" 
				AND m_tarif.KODE_TARIF <> "102001"
				OR (t_irja_tarif.DESKRIPSI = "Tindakan Di Poliklinik" AND t_irja_tarif.IRJA_ID = "' . $irja_id . '")
				ORDER BY t_irja_tarif.NO_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';				
}else{
	$qry_tarif = 'SELECT t_hemodialisa_tarif.HEMODIALISA_TARIF_ID AS IRJA_TARIF_ID,m_tarif.KODE_TARIF,m_tarif.NAMA_TARIF,m_tarif.SATUAN,
				m_tarif_group.NAMA_TARIF_GROUP,m_tarif.TARIF_NON_KELAS,t_hemodialisa_tarif.ICD_CODE,
				t_hemodialisa_tarif.NO_PEMBAYARAN,t_hemodialisa_tarif.NO_TARIF,t_hemodialisa_tarif.ST_BAYAR,t_hemodialisa_tarif.USER_KASIR,
				CASE WHEN (t_hemodialisa_tarif.PEGAWAI_ID IS NOT NULL AND t_hemodialisa_tarif.PEGAWAI_ID <> "") THEN m_pegawai.NAMA_PEGAWAI
				ELSE m_pegawai2.NAMA_PEGAWAI END AS NAMA_PEGAWAI,t_hemodialisa_tarif.PEGAWAI_ID,t_hemodialisa_tarif.DESKRIPSI,
				m_tarif_group.KODE_TARIF_GROUP
				FROM t_hemodialisa_tarif
				INNER JOIN m_tarif ON (t_hemodialisa_tarif.TARIF_ID = m_tarif.TARIF_ID)
				INNER JOIN m_tarif_group ON (m_tarif.KODE_TARIF_GROUP = m_tarif_group.KODE_TARIF_GROUP)
				INNER JOIN t_hemodialisa ON (t_hemodialisa_tarif.HEMODIALISA_ID = t_hemodialisa.HEMODIALISA_ID)
				LEFT JOIN m_pegawai ON (t_hemodialisa_tarif.PEGAWAI_ID = m_pegawai.PEGAWAI_ID)
				LEFT JOIN m_pegawai m_pegawai2 ON (t_hemodialisa.PEGAWAI_PERIKSA_ID = m_pegawai2.PEGAWAI_ID)
				WHERE t_hemodialisa_tarif.HEMODIALISA_ID = "' . $irja_id . '"
				AND m_tarif_group.KODE_TARIF_GROUP <> "01" 
				AND m_tarif.KODE_TARIF <> "103001" 
				AND m_tarif.KODE_TARIF <> "102001"
				OR (t_hemodialisa_tarif.DESKRIPSI = "Tindakan Di Poliklinik" AND t_hemodialisa_tarif.HEMODIALISA_ID = "' . $irja_id . '")
				ORDER BY t_hemodialisa_tarif.NO_TARIF,m_tarif_group.NAMA_TARIF_GROUP,m_tarif.NAMA_TARIF';				
}				
$get_tarif = mysql_query($qry_tarif);
?>
<tr>
    <th width="30">No</th>
	<th width="100">Nomor</th>
	<th>Jenis Tindakan</th>
    <th>Nama Tindakan</th>
    <th>Tarif (Rp.)</th>
	<th>Pelaksana</th>
	<th width="100">Status</th>
    <th width="200">Option</th>
</tr>
<?php
$i = 1;
$total = 0;
$nomor = '';
$st_copy = false;
while ($dat_tarif = mysql_fetch_array($get_tarif)) {
    if(strtolower($dat_tarif['NAMA_TARIF']) != 'pendaftaran'){	?>
    <tr>
        <td align="center"><?php echo $i; ?></td>
		<td align="center"><?php if($nomor != $dat_tarif['NO_TARIF']) { 
				echo $dat_tarif['NO_TARIF']; 
				$nomor = $dat_tarif['NO_TARIF'];
				$st_copy = true;	
			}else{
				$st_copy = false;
			}  ?></td>
        <td><?php echo $dat_tarif['NAMA_TARIF_GROUP']; ?></td>
		<td><?php echo $dat_tarif['NAMA_TARIF']; ?></td>
		<td align="right"><?php echo currFormat($dat_tarif['TARIF_NON_KELAS']); ?></td>
		<td><?php echo $dat_tarif['NAMA_PEGAWAI']; ?></td>
		<td align="center"><?php echo $dat_tarif['ST_BAYAR']; if(empty($dat_tarif['NO_TARIF'])) echo ' Belum Disimpan'; ?></td>
        <td align="center" width="110"><?php if($dat_tarif['KODE_TARIF_GROUP'] != '01' and $hemodialisa_final == ''){ ?>
				<a href="#" onclick="window.open('index.php?popup=hemodialisaformpelaksana&idx=<?php echo $irja_id; ?>&idt=<?php echo $dat_tarif['IRJA_TARIF_ID']; ?>&unit=<?php echo $_SESSION['SES_SIMRS_UNIT_ID']; ?>&pelaksana=<?php echo $dat_tarif['PEGAWAI_ID']; ?>&ord=<?php echo $jns_order; ?>&idxord=<?php echo $idxord; ?>','','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=yes,resizable=no,width=850,height=550')" >hasil</a>
			<?php } ?>
			
			<?php if($hemodialisa_final == '' and (!in_array($jenis_bayar_id,array('1','18')) or empty($dat_tarif['NO_PEMBAYARAN']))){ ?>
				<a href="<?php echo currentUrl(); ?>&idk=<?php echo $dat_tarif['IRJA_TARIF_ID']; ?>&nmk=<?php echo $dat_tarif['NAMA_TARIF']; ?>&ord=<?php echo $jns_order; ?>" >hapus</a>
			<?php } ?>
			<?php if($hemodialisa_final == '' and $st_copy == true 
				and isDokter($_SESSION['SES_SIMRS_TIPE_PEGAWAI']) 
					and $pegawai_id == $_SESSION['SES_SIMRS_PEGAWAI_ID']
						and !empty($dat_tarif['NO_TARIF'])){ ?>
		<a href="#" onclick="copykePAM('<?php echo $irja_id; ?>','<?php echo $dat_tarif['NO_TARIF']; ?>','<?php echo $jns_order; ?>');">copy ke PAM</a>
		<?php } ?>
			</td>
    </tr>
    <?php
	$total = $total + $dat_tarif['TARIF_NON_KELAS'];
    $i++;
	}
}	
?>